<?php

namespace MailevaApiAdapter\App\Collection;

use ArrayIterator;
use IteratorAggregate;
use MailevaApiAdapter\App\Entity\Document;
use MailevaApiAdapter\App\Exception\MailevaCoreException;

/**
 * Class Documents
 * @package MailevaApiAdapter\App\Collection
 *
 */
class Documents implements IteratorAggregate
{
    /** @var Document[] */
    protected array $documents = [];

    /**
     * @return Document[]
     */
    public function toArray(): array
    {
        return $this->documents;
    }

    /**
     * @throws MailevaCoreException
     */
    public function getFirst(): Document
    {
        return $this->get(0);
    }

    /**
     * @throws MailevaCoreException
     */
    public function get(int $index): Document
    {
        if (!array_key_exists($index, $this->documents)) {
            throw new MailevaCoreException('First document not found');
        }

        return $this->documents[$index];
    }

    /**
     * @throws MailevaCoreException
     */
    public function fromArray(array $documents): Documents
    {
        $err = array_filter(
            $documents,
            fn ($document) => !($document instanceof Document)
        );
        if (!empty($err)) {
            throw new MailevaCoreException('Only instance of ' . Document::class . ' is accepted');
        }

        $this->documents = $documents;
        return $this;
    }

    public function add(Document $document): Documents
    {
        $this->documents[] = $document;

        return $this;
    }

    public function isEmpty(): bool
    {
        return $this->count() === 0;
    }

    public function count(): int
    {
        return count($this->documents);
    }

    /**
     * @return ArrayIterator|Document[]
     */
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->documents);
    }
}