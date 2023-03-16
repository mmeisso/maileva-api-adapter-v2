<?php

namespace MailevaApiAdapter\App;

use League\Flysystem\Config;
use League\Flysystem\Filesystem;
use League\Flysystem\FilesystemException;
use League\Flysystem\Ftp\FtpAdapter;
use League\Flysystem\Ftp\FtpConnectionOptions;
use League\Flysystem\Local\LocalFilesystemAdapter;
use League\Flysystem\StorageAttributes;
use MailevaApiAdapter\App\Core\MailevaResponseLRCOPRO;
use MailevaApiAdapter\App\Exception\MailevaResponseException;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Loader\FilesystemLoader;
use ZipArchive;


class LrCoproClient extends AbstractClient
{
    public const HOST_PROD = "ftp.maileva.com";
    public const HOST_SANDBOX = "ftp.recette.maileva.com";
    private const HOST_LIST = [
        [
            "host" => self::HOST_PROD,
            "description" => "Production",
        ],
        [
            "host" => self::HOST_SANDBOX,
            "description" => "Sandbox",
        ]
    ];
    const TRACK_ID_SUFFIX = '.Rq';

    /**
     * @param MailevaConnection $mailevaConnection
     * @throws Client\AuthClient\ApiException
     */
    public function __construct(MailevaConnection $mailevaConnection)
    {
        parent::__construct($mailevaConnection);
    }

    /**
     * @return null
     */
    protected function getNewConfiguration()
    {
        return null;
    }

    /**
     * @param MailevaSending $mailevaSending
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws FilesystemException
     */
    public function prepare(MailevaSending $mailevaSending): string
    {
        $sendingId = str_replace('.', '', uniqid('', 'true'));

        # create xml file
        $context = [
            'login' => $this->mailevaConnection->getFtpUserName(),
            'password' => $this->mailevaConnection->getFtpPassword(),
            'customId' => $mailevaSending->getCustomId(),
            'sendingId' => $sendingId,
            'trackId' => $this->getTrackId($sendingId),
            'name' => 'Envoi LRCOPRO',
            'duplexPrinting' => $mailevaSending->isDuplexPrinting() ? 1 : 0,
            'notificationEmail' => $mailevaSending->getNotificationEmail(),

            'addressLine1' => $mailevaSending->getAddressLine1(),
            'addressLine2' => $mailevaSending->getAddressLine2(),
            'addressLine3' => $mailevaSending->getAddressLine3(),
            'addressLine4' => $mailevaSending->getAddressLine4(),
            'addressLine5' => $mailevaSending->getAddressLine5(),
            'addressLine6' => $mailevaSending->getAddressLine6(),

            'senderAddressLine1' => $mailevaSending->getSenderAddressLine1(),
            'senderAddressLine2' => $mailevaSending->getSenderAddressLine2(),
            'senderAddressLine3' => $mailevaSending->getSenderAddressLine3(),
            'senderAddressLine4' => $mailevaSending->getSenderAddressLine4(),
            'senderAddressLine5' => $mailevaSending->getSenderAddressLine5(),
            'senderAddressLine6' => $mailevaSending->getSenderAddressLine6(),
        ];

        $loader = new FilesystemLoader(__DIR__ . '/templates/');
        $twig = new Environment($loader);
        $xmlContent = $twig->render('lrcopro.xml', $context);

        # Create Zip file
        $zip = new ZipArchive();
        $tempZip = sys_get_temp_dir() . '/' . $sendingId . '.zip';
        $zip->open($tempZip, ZipArchive::CREATE);
        $zip->addFile($mailevaSending->getFile(), "$sendingId.001");
        $zip->addFromString("$sendingId.002", $xmlContent);
        $zip->close();

        # Upload file on ftp
        $ftpAdapter = $this->getFtpAdapter();
        $zipResource = fopen($tempZip, 'r');
        $ftpAdapter->writeStream("$sendingId.zip", $zipResource, new Config());
        if (is_resource($zipResource)) {
            fclose($zipResource);
        }

        # Store into memcached to avoid duplicate sending
        $this->mailevaConnection->getMemcachedManager()
            ->set($mailevaSending->getUID()[0], $sendingId, self::MEMCACHE_SIMILAR_DURATION);

        return $sendingId;
    }

    /**
     * @param string $sendingId
     * @return void
     * @throws FilesystemException
     */
    public function submit(string $sendingId): void
    {
        $from = "$sendingId.zip";
        $to = "$sendingId.zcou";
        $ftpAdapter = $this->getFtpAdapter();
        $ftpAdapter->move($from, $to, new Config());
    }

    /**
     * @param string $sendingId
     * @return MailevaResponseLRCOPRO
     * @throws MailevaResponseException
     * @throws FilesystemException
     */
    public function getSendingBySendingId(string $sendingId): MailevaResponseLRCOPRO
    {
        # Create local dir
        $concurrentDirectory = sprintf(
            "%s%s",
            $this->mailevaConnection->getTmpFileDirectory(),
            $this->mailevaConnection->getDirectoryCallback()
        );
        $localAdapter = $this->getLocalAdapter('/');
        $localAdapter->createDirectory($concurrentDirectory);

        # List all notification file in ftp
        $ftpAdapter = $this->getFtpAdapter();
        $listing = $ftpAdapter->listContents($this->mailevaConnection->getDirectoryCallback(), false);
        /** @var StorageAttributes $file */
        foreach ($listing as $file) {
            # Filter file
            if (!$file->isFile()) {
                continue;
            }

            # Download file if it doesn't exist into local temp directory
            $fileName = basename($file->path());
            $localFilePath = sprintf(
                "%s%s/%s",
                $this->mailevaConnection->getTmpFileDirectory(),
                $this->mailevaConnection->getDirectoryCallback(),
                $fileName
            );
            if (!$localAdapter->fileExists($localFilePath)) {
                $resource = $ftpAdapter->readStream($file->path());
                $localAdapter->writeStream($localFilePath, $resource);
            }

            # Fetch notification
            $xml = preg_replace('/tnsb:/', '', $localAdapter->read($localFilePath));
            $mailevaResponseLRCOPRO = new MailevaResponseLRCOPRO();
            $mailevaResponseLRCOPRO->hydrate($xml);

            if ($mailevaResponseLRCOPRO->getId() !== $sendingId) {
                continue;
            }

            $outputDirectory = sprintf(
                "%s/%s",
                $this->mailevaConnection->getDirectoryCallback(),
                $mailevaResponseLRCOPRO->getStatus()
            );
            $ftpAdapter->createDirectory($outputDirectory, new Config());
            $targetName = sprintf("%s/%s", $outputDirectory, $fileName);
            $ftpAdapter->move($file->path(), $targetName, new Config());

            return $mailevaResponseLRCOPRO;
        }
        throw new MailevaResponseException('Unable to retrieve by sendingId ' . $sendingId);
    }

    /**
     * @return string
     */
    private function getHost(): string
    {
        return self::HOST_LIST[$this->mailevaConnection->getHostIndex()]['host'];
    }

    /**
     * @param string $sendingid
     * @return string
     */
    private function getTrackId(string $sendingid): string
    {
        return $sendingid . self::TRACK_ID_SUFFIX;
    }

    /**
     * @return FtpAdapter
     */
    private function getFtpAdapter(): FtpAdapter
    {
        return new FtpAdapter(
        // Connection options
            FtpConnectionOptions::fromArray([
                'host' => $this->getHost(),
                'root' => '/',
                'username' => $this->mailevaConnection->getFtpClientId(),
                'password' => $this->mailevaConnection->getFtpClientSecret(),
                'passive' => true,
                'transferMode' => FTP_BINARY,
            ])
        );
    }

    /**
     * @param string $directory
     * @return Filesystem
     */
    private function getLocalAdapter(string $directory): Filesystem
    {
        $localAdapter = new LocalFilesystemAdapter($directory);
        return new Filesystem($localAdapter);
    }
}