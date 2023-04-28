<?php

namespace MailevaApiAdapter\App\Legacy;

use MailevaApiAdapter\App\Entity\Document;
use MailevaApiAdapter\App\Exception\MailevaCoreException;
use MailevaApiAdapter\App\Collection\Documents;

/** @deprecated : this file has old properties which were in MailevaSending and which are now in App/Entity/Document entity
 *
 * Instead of using these properties, do that :
 * $docs = new Documents();
 * $doc = new Document();
 * $docs->add($doc);
 * $mailevaSending = new MailevaSending();
 * $mailevaSending->setDocuments($docs);
 *  TODO : remove this Trait
 */
trait FileHandlerLegacyTrait
{
    protected ?string $file = null;

    protected ?string $filename = null;

    protected int $filepriority = 1;

    protected ?int $nbPage = null;

    /**
     * @deprecated
     * @param int $nbPage
     * @return self
     * @throws MailevaCoreException
     */
    public function setNbPage(int $nbPage)
    {
        $this->getDocuments()->getFirst()->setNbPage($nbPage);

        $this->nbPage = $nbPage;
        return $this;

    }

    /**
     * @deprecated
     * @return int
     * @throws MailevaCoreException
     */
    public function getNbPage(): int
    {
        if ($this->nbPage === null) {
            $this->nbPage = $this->getDocuments()->getFirst()->getNbPage();
        }

        return $this->nbPage;
    }

    /**
     * @deprecated
     * @return string
     * @throws MailevaCoreException
     */
    public function getFile(): string
    {
        if ($this->file) {
            return $this->file;
        }
        return $this->getDocuments()->getFirst()->getFile();
    }

    /**
     * @deprecated
     * @param string $file
     *
     * @return self
     * @throws MailevaCoreException
     */
    public function setFile(string $file): self
    {
        $this->file = $file;

        # also set file for first document in case of legacy (one file per send)
        $this->getDocuments()->getFirst()->setFile($file);

        return $this;
    }

    /**
     * @deprecated
     * @return string
     * @throws MailevaCoreException
     */
    public function getFilename(): string
    {
        if ($this->filename) {
            return $this->filename;
        }
        return $this->getDocuments()->getFirst()->getFilename();
    }

    /**
     * @deprecated
     * @param string $filename
     *
     * @return self
     * @throws MailevaCoreException
     */
    public function setFilename(string $filename): self
    {
        # also set file for first document in case of legacy (one file per send)
        $this->getDocuments()->getFirst()->setFilename($filename);

        $this->filename = $filename;
        return $this;
    }

    /**
     * @deprecated
     * @return Int
     * @throws MailevaCoreException
     */
    public function getFilepriority(): Int
    {
        if ($this->filepriority) {
            return $this->filepriority;
        }
        return $this->getDocuments()->getFirst()->getFilePriority();
    }

    /**
     * @deprecated
     * @param Int $filepriority
     *
     * @return self
     * @throws MailevaCoreException
     */
    public function setFilepriority(Int $filepriority): self
    {
        # also set file for first document in case of legacy (one file per send)
        $this->getDocuments()->getFirst()->setFilePriority($filepriority);

        $this->filepriority = $filepriority;
        return $this;
    }


    /**
     * a getter that converts from legacy single file Api to new multi Document Api
     */
    public function getDocuments(): Documents
    {
        if ($this->documents === null) {
            $this->documents = new Documents();

            $document = new Document();

            if ($this->file !== null) {
                $document->setFile($this->file);
            }
            if ($this->filename !== null) {
                $document->setFilename($this->filename);
            }
            if ($this->nbPage !== null) {
                $document->setNbPage($this->nbPage);
            }
            $document->setFilePriority($this->filepriority);


            try {
                $this->documents->add($document);
            } catch (MailevaCoreException $e) {
                // Never happens unless you change $document type
            }
        }
        return $this->documents;
    }
}