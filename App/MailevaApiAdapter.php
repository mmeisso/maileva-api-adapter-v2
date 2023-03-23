<?php
/**
 * Created by PhpStorm.
 * User: Loïc
 * Date: 08/02/2018
 * Time: 11:33
 */

namespace MailevaApiAdapter\App;

use League\Flysystem\FilesystemException;
use MailevaApiAdapter\App\Client\AuthClient\ApiException;
use MailevaApiAdapter\App\Core\MailevaResponse;
use MailevaApiAdapter\App\Core\MailevaResponseInterface;
use MailevaApiAdapter\App\Exception\MailevaAllReadyExistException;
use MailevaApiAdapter\App\Exception\MailevaCoreException;
use MailevaApiAdapter\App\Exception\MailevaParameterException;
use MailevaApiAdapter\App\Exception\MailevaResponseException;
use Symfony\Component\Filesystem\Filesystem;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class MailevaApiAdapter
 *
 * @package MailevaApiAdapter\App
 */
class MailevaApiAdapter
{
    /** @var MailevaConnection|null */
    private ?MailevaConnection $mailevaConnection;

    /**
     * MailevaApiAdapter constructor.
     *
     * @param MailevaConnection $mailevaConnection
     */
    public function __construct(MailevaConnection $mailevaConnection)
    {
        $this->mailevaConnection = $mailevaConnection;
    }


    /**
     * @param string $sendingId
     * @return void
     * @throws ApiException
     * @throws Client\LrelClient\ApiException
     * @throws Client\SimpleSendingClient\ApiException
     * @throws MailevaCoreException
     */
    public function deleteSendingBySendingId(string $sendingId): void
    {
        switch ($this->getType()) {
            case MailevaConnection::CLASSIC:
                $simpleSendingClient = new SimpleSendingClient($this->mailevaConnection);
                $simpleSendingClient->deleteSendingBySendingId($sendingId);
                break;
            case MailevaConnection::LRE:
                $lrelClient = new LrelClient($this->mailevaConnection);
                $lrelClient->deleteSendingBySendingId($sendingId);
                break;
            default:
                throw new MailevaCoreException('Type not available');
        }
    }

    /**
     * @param string $sendingId
     * @param string $recipientId
     * @param string $localFilePath
     * @return MailevaResponse
     * @throws ApiException
     * @throws Client\LrelClient\ApiException
     * @throws MailevaCoreException
     */
    public function downloadAcknowledgementOfReceiptBySendingIdAndRecipientId(
        string $sendingId,
        string $recipientId,
        string $localFilePath
    ): MailevaResponse {
        if ($this->getType() !== MailevaConnection::LRE) {
            throw new MailevaCoreException('Only available for LRE');
        }

        $lrelClient = new LrelClient($this->mailevaConnection);
        $file = $lrelClient->downloadAcknowledgementOfReceiptBySendingIdAndRecipientId(
            $sendingId,
            $recipientId
        );

        $filesystem = new Filesystem();
        $filesystem->rename($file->getPathname(), $localFilePath);

        return new MailevaResponse();
    }

    /**
     * @param string $sendingId
     * @param string $localFilePath
     * @return MailevaResponse
     * @throws ApiException
     * @throws Client\LrelClient\ApiException
     * @throws MailevaCoreException
     */
    public function downloadDepositProofBySendingId(string $sendingId, string $localFilePath): MailevaResponse
    {
        if ($this->getType() !== MailevaConnection::LRE) {
            throw new MailevaCoreException('Only available for LRE');
        }
        $lrelClient = new LrelClient($this->mailevaConnection);
        $file = $lrelClient->downloadDepositProofBySendingId($sendingId);

        $filesystem = new Filesystem();
        $filesystem->rename($file->getPathname(), $localFilePath);

        return new MailevaResponse();
    }

    /**
     * @param string $sendingId
     * @param string $documentId
     * @return MailevaResponse
     * @throws ApiException
     * @throws Client\LrelClient\ApiException
     * @throws Client\SimpleSendingClient\ApiException
     * @throws MailevaCoreException
     */
    public function getDocumentBySendingIdAndDocumentId(string $sendingId, string $documentId): MailevaResponse
    {
        switch ($this->getType()) {
            case MailevaConnection::CLASSIC:
                $simpleSendingClient = new SimpleSendingClient($this->mailevaConnection);
            return $simpleSendingClient->getDocumentBySendingIdAndDocumentId($sendingId, $documentId);
            case MailevaConnection::LRE:
                $lrelClient = new LrelClient($this->mailevaConnection);
                return $lrelClient->getDocumentBySendingIdAndDocumentId($sendingId, $documentId);
            default:
                throw new MailevaCoreException('Type not available');
        }
    }

    /**
     * @param string $sendingId
     * @param int $startIndex
     * @param int $count
     * @return MailevaResponse
     * @throws ApiException
     * @throws Client\LrelClient\ApiException
     * @throws Client\SimpleSendingClient\ApiException
     * @throws MailevaCoreException
     */
    public function getDocumentsBySendingId(string $sendingId, int $startIndex = 1, int $count = 100): MailevaResponse
    {
        switch ($this->getType()) {
            case MailevaConnection::CLASSIC:
                $simpleSendingClient = new SimpleSendingClient($this->mailevaConnection);
                return $simpleSendingClient->getDocumentsBySendingId($sendingId, $startIndex, $count);
            case MailevaConnection::LRE:
                $lrelClient = new LrelClient($this->mailevaConnection);
                return $lrelClient->getDocumentsBySendingId($sendingId, $startIndex, $count);
            default:
                throw new MailevaCoreException('Type not available');
        }
    }

    /**
     * @param string $sendingId
     * @param string $recipientId
     * @return MailevaResponse
     * @throws ApiException
     * @throws Client\LrelClient\ApiException
     * @throws Client\SimpleSendingClient\ApiException
     * @throws MailevaCoreException
     */
    public function getRecipientBySendingIdAndRecipientId(string $sendingId, string $recipientId): MailevaResponse
    {
        switch ($this->getType()) {
            case MailevaConnection::CLASSIC:
                $simpleSendingClient = new SimpleSendingClient($this->mailevaConnection);
                return $simpleSendingClient->getRecipientBySendingIdAndRecipientId($sendingId, $recipientId);
            case MailevaConnection::LRE:
                $lrelClient = new LrelClient($this->mailevaConnection);
                return $lrelClient->getRecipientBySendingIdAndRecipientId($sendingId, $recipientId);
            default:
                throw new MailevaCoreException('Type not available');
        }
    }

    /**
     * @param string $sendingId
     * @param int $startIndex
     * @param int $count
     * @return MailevaResponse
     * @throws ApiException
     * @throws Client\LrelClient\ApiException
     * @throws Client\SimpleSendingClient\ApiException
     * @throws MailevaCoreException
     */
    public function getRecipientsBySendingId(string $sendingId, int $startIndex = 1, int $count = 100): MailevaResponse
    {
        switch ($this->getType()) {
            case MailevaConnection::CLASSIC:
                $simpleSendingClient = new SimpleSendingClient($this->mailevaConnection);
                return $simpleSendingClient->getRecipientsBySendingId($sendingId, $startIndex, $count);
            case MailevaConnection::LRE:
                $lrelClient = new LrelClient($this->mailevaConnection);
                return $lrelClient->getRecipientsBySendingId($sendingId, $startIndex, $count);
            default:
                throw new MailevaCoreException('Type not available');
        }
    }

    /**
     * @param string $sendingId
     * @return MailevaResponseInterface
     * @throws ApiException
     * @throws Client\LrelClient\ApiException
     * @throws Client\MailevaCoproClient\ApiException
     * @throws Client\SimpleSendingClient\ApiException
     * @throws MailevaResponseException
     * @throws MailevaCoreException
     * @throws FilesystemException
     */
    public function getSendingBySendingId(string $sendingId): MailevaResponseInterface
    {
        switch ($this->getType()) {
            case MailevaConnection::MAILEVA_COPRO:
                $MailevaCoproClient = new MailevaCoproClient($this->mailevaConnection);
                return $MailevaCoproClient->getSendingBySendingId($sendingId);
            case MailevaConnection::LRCOPRO:
                $lrCoproClient = new LrCoproClient($this->mailevaConnection);
                return $lrCoproClient->getSendingBySendingId($sendingId);
            case MailevaConnection::CLASSIC:
                $simpleSendingClient = new SimpleSendingClient($this->mailevaConnection);
                return $simpleSendingClient->getSendingBySendingId($sendingId);
            case MailevaConnection::LRE:
                $lrelClient = new LrelClient($this->mailevaConnection);
                return $lrelClient->getSendingBySendingId($sendingId);
            default:
                throw new MailevaCoreException('Type not available');
        }
    }

    /**
     * @param string $sendingId
     * @param string $recipientId
     * @return MailevaResponse
     * @throws ApiException
     * @throws Client\LrelClient\ApiException
     * @throws Client\SimpleSendingClient\ApiException
     * @throws MailevaCoreException
     */
    public function getSendingStatusBySendingIdAndRecipientId(string $sendingId, string $recipientId): MailevaResponse
    {
        switch ($this->getType()) {
            case MailevaConnection::CLASSIC:
                $simpleSendingClient = new SimpleSendingClient($this->mailevaConnection);
                return $simpleSendingClient->getSendingStatusBySendingIdAndRecipientId($sendingId, $recipientId);
            case MailevaConnection::LRE:
                $lrelClient = new LrelClient($this->mailevaConnection);
                return $lrelClient->getSendingStatusBySendingIdAndRecipientId($sendingId, $recipientId);
            default:
                throw new MailevaCoreException('Type not available');
        }
    }

    /**
     * @param MailevaSending $mailevaSending
     * @return array
     * @throws ApiException
     * @throws Client\LrelClient\ApiException
     * @throws Client\MailevaCoproClient\ApiException
     * @throws Client\SimpleSendingClient\ApiException
     * @throws FilesystemException
     * @throws MailevaCoreException
     * @throws MailevaResponseException
     */
    public function getSimilarPreviousAlreadyBeenSent(MailevaSending $mailevaSending): array
    {
        $this->mailevaConnection->initMemcachedManager();
        $sendingIdSimilarPrevious = $this->mailevaConnection->getMemcachedManager()
            ->get($mailevaSending->getUID()[0], false);

        # new sending
        if (false === $sendingIdSimilarPrevious) {
            return [false, null];
        } elseif ($this->mailevaConnection->isCopro()) {
            # not new but is copro... So it seems to be ok to have multiple sending
            return [true, null];
        } else {
            # document already sent
            $previousSimilarMailevaSimple = $this->getSendingBySendingId($sendingIdSimilarPrevious)
                ->getResponseAsArray();
            return [true, $previousSimilarMailevaSimple];
        }
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->mailevaConnection->getType();
    }

    /**
     * @param string $type
     * @return void
     * @throws MailevaCoreException
     */
    public function setType(string $type): void
    {
        $this->mailevaConnection->setType($type);
    }

    /**
     * @param MailevaSending $mailevaSending
     * @param bool $checkSimilarPreviousHasAlreadyBeenSent
     * @return string
     * @throws ApiException
     * @throws Client\LrelClient\ApiException
     * @throws Client\MailevaCoproClient\ApiException
     * @throws Client\SimpleSendingClient\ApiException
     * @throws FilesystemException
     * @throws LoaderError
     * @throws MailevaAllReadyExistException
     * @throws MailevaCoreException
     * @throws MailevaParameterException
     * @throws MailevaResponseException
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function prepare(MailevaSending $mailevaSending, bool $checkSimilarPreviousHasAlreadyBeenSent = true): string
    {
        $mailevaSending->validate($this->getType());

        if ($checkSimilarPreviousHasAlreadyBeenSent === true) {
            $sendingIdSimilarPrevious = $this->getSimilarPreviousAlreadyBeenSent($mailevaSending);

            if ($sendingIdSimilarPrevious[0] !== false) {
                if ($this->mailevaConnection->isCopro()) {
                    $allReadyExistException = new MailevaAllReadyExistException(
                        MailevaAllReadyExistException::ERROR_SAME_MAILEVASENDING_HAS_ALREADY_BEEN_SENT_WITH_SENDINGID,
                        "Same mailevaSending the LRCOPRO has already been sent"
                    );
                } else {
                    $allReadyExistException = new MailevaAllReadyExistException(
                        MailevaAllReadyExistException::ERROR_SAME_MAILEVASENDING_HAS_ALREADY_BEEN_SENT_WITH_SENDINGID,
                        "Same mailevaSending has already been sent with sendingId " . $sendingIdSimilarPrevious[1]['id']
                    );
                    $allReadyExistException->setPreviousMailevaSending($sendingIdSimilarPrevious[1]);
                }

                throw $allReadyExistException;
            }
        }

        switch ($this->getType()) {
            case MailevaConnection::CLASSIC:
                $simpleSendingClient = new SimpleSendingClient($this->mailevaConnection);
                return $simpleSendingClient->prepare($mailevaSending);

            case MailevaConnection::LRE:
                $lrelClient = new LrelClient($this->mailevaConnection);
                return $lrelClient->prepare($mailevaSending);

            case MailevaConnection::MAILEVA_COPRO:
                $MailevaCoproClient = new MailevaCoproClient($this->mailevaConnection);
                return $MailevaCoproClient->prepare($mailevaSending);

            case MailevaConnection::LRCOPRO:
                $MailevaCoproClient = new LrCoproClient($this->mailevaConnection);
                return $MailevaCoproClient->prepare($mailevaSending);

            default:
                throw new MailevaCoreException('Type not available');
        }
    }

    /**
     * @param string $sendingId
     * @return void
     * @throws ApiException
     * @throws Client\LrelClient\ApiException
     * @throws Client\MailevaCoproClient\ApiException
     * @throws Client\SimpleSendingClient\ApiException
     * @throws MailevaCoreException
     * @throws FilesystemException
     */
    public function submit(string $sendingId): void
    {
        switch ($this->getType()) {
            case MailevaConnection::MAILEVA_COPRO:
                $MailevaCoproClient = new MailevaCoproClient($this->mailevaConnection);
                $MailevaCoproClient->submit($sendingId);
                break;

            case MailevaConnection::LRCOPRO:
                $MailevaCoproClient = new LrCoproClient($this->mailevaConnection);
                $MailevaCoproClient->submit($sendingId);
                break;

            case MailevaConnection::CLASSIC:
                $simpleSendingClient = new SimpleSendingClient($this->mailevaConnection);
                $simpleSendingClient->postSendingBySendingId($sendingId);
                break;

            case MailevaConnection::LRE:
                $lrelClient = new LrelClient($this->mailevaConnection);
                $lrelClient->postSendingBySendingId($sendingId);
                break;

            default:
                throw new MailevaCoreException('Type not available');
        }
    }



}


