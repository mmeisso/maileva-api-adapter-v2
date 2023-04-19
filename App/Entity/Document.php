<?php

namespace MailevaApiAdapter\App\Entity;

use MailevaApiAdapter\App\Exception\MailevaCoreException;
use MailevaApiAdapter\App\Exception\MailevaParameterException;
use MailevaApiAdapter\App\MailevaConnection;

class Document
{
    public const MAX_MB_FILE_MAILEVA = 10485760; #10MO

    protected string $file;

    protected string $filename;

    protected ?int $nbPage = null;

    private int $filePriority = 1;

    /**
     * @throws MailevaParameterException
     */
    public function validate(string $type)
    {
        $file = $this->getFile();

        if (!file_exists($file)) {
            throw new MailevaParameterException(MailevaParameterException::ERROR_MAILEVA_FILE_NOT_FOUND,
                'file ' . $file . ' not found');
        }
        if (!in_array($type, [MailevaConnection::LRCOPRO])) {
            if (filesize($file) >= self::MAX_MB_FILE_MAILEVA) {
                throw new MailevaParameterException(MailevaParameterException::ERROR_MAILEVA_FILE_IS_TOO_BIG,
                    'The file is too big :' . $file . ' the maximum is ' . self::MAX_MB_FILE_MAILEVA . ' MB');
            }
        }
    }

    public function getFilePriority(): int
    {
        return $this->filePriority;
    }

    /**
     * @return $this
     */
    public function setFilePriority(int $filePriority): Document
    {
        $this->filePriority = $filePriority;
        return $this;
    }

    /**
     * @return $this
     */
    public function setFile(string $file): Document
    {
        $this->file = $file;
        return $this;
    }

    public function getFile(): string
    {
        return $this->file;
    }

    /**
     * @return $this
     */
    public function setFilename(string $filename): Document
    {
        $this->filename = $filename;
        return $this;
    }

    public function getFilename(): string
    {
        return $this->filename;
    }

    /**
     * @throws MailevaCoreException
     */
    public function getNbPage(): int
    {
        if ($this->nbPage !== null) {
            return $this->nbPage;
        }

        $this->nbPage = 0;
        $commandList  = [
            "pdfinfo " . escapeshellarg($this->getFile()) . " 2>/dev/null | grep Pages | awk '{print $2}'",
            'pdftk ' . escapeshellarg($this->getFile()) . " dump_data | sed '/NumberOfPages/!d;s/[^0-9]*//'",
            'echo $(strings < ' . escapeshellarg($this->getFile()) . ' | sed -n \'s|.*/Count -\{0,1\}\([0-9]\{1,\}\).*|\1|p\' | sort -rn | head -n 1)'
        ];

        foreach ($commandList as $command) {
            $output = [];
            exec($command, $output, $result);

            if (isset($output[0]) && intval($output[0]) > 0) {
                $this->nbPage = (int)$output[0];
                break;
            }
        }
        if ($this->nbPage === 0) {
            throw new MailevaCoreException('Impossible to get page number from ' . $this->getFile());
        }

        return $this->nbPage;
    }

    /**
     * @return $this
     */
    public function setNbPage(int $nbPage): Document
    {
        $this->nbPage = $nbPage;
        return $this;
    }


}