<?php
/**
 * Created by PhpStorm.
 * User: Loïc
 * Date: 12/02/2018
 * Time: 09:42
 */

namespace MailevaApiAdapter\App\Core;

use MailevaApiAdapter\App\LrCoproClient;
use MailevaApiAdapter\App\MailevaSendingStatus;

/**
 * Class MailevaResponseLRCOPRO
 *
 * @package MailevaApiAdapter\App\Core
 */
class MailevaResponseLRCOPRO implements MailevaResponseInterface
{

    private string $id;
    private string $trackId;
    private string $status;
    private string $creationDate;
    private string $postageType;
    private string $pagesCount;
    private string $documentsCount;
    private string $billedPageCount;
    private string $depositId;
    private string $expectedProductionDate;
    private bool $duplexPrinting;
    private bool $colorPrinting;

    private array $responseAsArray;

    /**
     * @return array
     */
    public function getResponseAsArray(): array
    {
        if (!isset($this->responseAsArray)) {
            $this->responseAsArray = [
                'id' => $this->id,
                'trackId' => $this->trackId,
                'status' => $this->status,
                'deposit_id' => $this->depositId,
                'expected_production_date' => $this->expectedProductionDate,
                'duplex_printing' => $this->duplexPrinting,
                'color_printing' => $this->colorPrinting,
            ];
            if(isset($this->postageType)) {
                $this->responseAsArray = array_merge($this->responseAsArray, [
                    'postage_type' => $this->postageType,
                    'creation_date' => $this->creationDate,
                    'pages_count' => $this->pagesCount,
                    'documents_count' => $this->documentsCount,
                    'billed_page_count' => $this->billedPageCount,
                ]);
            }
        }
        return $this->responseAsArray;
    }

    /**
     * @param array $responseAsArray
     */
    public function setResponseAsArray(array $responseAsArray)
    {
        $this->responseAsArray = $responseAsArray;
    }

    public function hydrate(string $xmlContent): void
    {
        $xml = simplexml_load_string($xmlContent);

        $this->trackId = (string)$xml->Request->TrackId[0];
        $this->id = trim($this->trackId, LrCoproClient::TRACK_ID_SUFFIX);

        # Todo pansement pas joli, mieux gérer les différents status LRCOPRO
        if (in_array((string)$xml->Request->Status[0], ['ACCEPT', 'OK'])) {
            $this->status = MailevaSendingStatus::ACCEPTED;
        }
        if ((string)$xml->Request->Status[0] === 'NACCEPT') {
            $this->status = MailevaSendingStatus::SUBMIT_ERROR;
        }

        $this->creationDate = (string)$xml->Request->ReceptionDate[0];
        if (isset($xml->Request->PaperOptions)) {
            $this->postageType = (string)$xml->Request->PaperOptions->PostageClass[0];
            $this->pagesCount = (string)$xml->Request->PaperOptions->PageCount[0];
            $this->documentsCount = (string)$xml->Request->PaperOptions->DocumentCount[0];
            $this->billedPageCount = (string)$xml->Request->PaperOptions->BilledPageCount[0];
            $this->duplexPrinting = $xml->Request->PaperOptions->PrintDuplex[0] ? 1 : 0;
            $this->colorPrinting = $xml->Request->PaperOptions->HasColorPage[0] ? 1 : 0;
        }
        $this->depositId = (string)$xml->Request->DepositId[0];
        $this->expectedProductionDate = (string)$xml->Request->ExpectedProductionDate[0];
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return MailevaResponseLRCOPRO
     */
    public function setId(string $id): MailevaResponseLRCOPRO
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getTrackId(): string
    {
        return $this->trackId;
    }

    /**
     * @param string $trackId
     * @return MailevaResponseLRCOPRO
     */
    public function setTrackId(string $trackId): MailevaResponseLRCOPRO
    {
        $this->trackId = $trackId;
        return $this;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     * @return MailevaResponseLRCOPRO
     */
    public function setStatus(string $status): MailevaResponseLRCOPRO
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return string
     */
    public function getCreationDate(): string
    {
        return $this->creationDate;
    }

    /**
     * @param string $creationDate
     * @return MailevaResponseLRCOPRO
     */
    public function setCreationDate(string $creationDate): MailevaResponseLRCOPRO
    {
        $this->creationDate = $creationDate;
        return $this;
    }

    /**
     * @return string
     */
    public function getPostageType(): string
    {
        return $this->postageType;
    }

    /**
     * @param string $postageType
     * @return MailevaResponseLRCOPRO
     */
    public function setPostageType(string $postageType): MailevaResponseLRCOPRO
    {
        $this->postageType = $postageType;
        return $this;
    }

    /**
     * @return string
     */
    public function getPagesCount(): string
    {
        return $this->pagesCount;
    }

    /**
     * @param string $pagesCount
     * @return MailevaResponseLRCOPRO
     */
    public function setPagesCount(string $pagesCount): MailevaResponseLRCOPRO
    {
        $this->pagesCount = $pagesCount;
        return $this;
    }

    /**
     * @return string
     */
    public function getDocumentsCount(): string
    {
        return $this->documentsCount;
    }

    /**
     * @param string $documentsCount
     * @return MailevaResponseLRCOPRO
     */
    public function setDocumentsCount(string $documentsCount): MailevaResponseLRCOPRO
    {
        $this->documentsCount = $documentsCount;
        return $this;
    }

    /**
     * @return string
     */
    public function getBilledPageCount(): string
    {
        return $this->billedPageCount;
    }

    /**
     * @param string $billedPageCount
     * @return MailevaResponseLRCOPRO
     */
    public function setBilledPageCount(string $billedPageCount): MailevaResponseLRCOPRO
    {
        $this->billedPageCount = $billedPageCount;
        return $this;
    }

    /**
     * @return string
     */
    public function getDepositId(): string
    {
        return $this->depositId;
    }

    /**
     * @param string $depositId
     * @return MailevaResponseLRCOPRO
     */
    public function setDepositId(string $depositId): MailevaResponseLRCOPRO
    {
        $this->depositId = $depositId;
        return $this;
    }

    /**
     * @return string
     */
    public function getExpectedProductionDate(): string
    {
        return $this->expectedProductionDate;
    }

    /**
     * @param string $expectedProductionDate
     * @return MailevaResponseLRCOPRO
     */
    public function setExpectedProductionDate(string $expectedProductionDate): MailevaResponseLRCOPRO
    {
        $this->expectedProductionDate = $expectedProductionDate;
        return $this;
    }

    /**
     * @return bool
     */
    public function isDuplexPrinting(): bool
    {
        return $this->duplexPrinting;
    }

    /**
     * @param bool $duplexPrinting
     * @return MailevaResponseLRCOPRO
     */
    public function setDuplexPrinting(bool $duplexPrinting): MailevaResponseLRCOPRO
    {
        $this->duplexPrinting = $duplexPrinting;
        return $this;
    }

    /**
     * @return bool
     */
    public function isColorPrinting(): bool
    {
        return $this->colorPrinting;
    }

    /**
     * @param bool $colorPrinting
     * @return MailevaResponseLRCOPRO
     */
    public function setColorPrinting(bool $colorPrinting): MailevaResponseLRCOPRO
    {
        $this->colorPrinting = $colorPrinting;
        return $this;
    }
}
