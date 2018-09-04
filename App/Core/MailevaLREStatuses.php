<?php
/**
 * Created by PhpStorm.
 * User: loic
 * Date: 04/09/2018
 * Time: 08:59
 */

namespace MailevaApiAdapter\App\Core;

use MailevaApiAdapter\App\Exception\MailevaException;

class MailevaLREStatuses
{

    const DELIVERY_STATUSES = 'delivery_statuses';
    const ID = 'id';
    const DATE = 'date';
    const STATUS = 'status';
    const DESCRIPTION = 'description';
    private $statuses = [];
    private $codeDescriptionMapping = [
        'A01' => 'Pris en charge',
        'A02' => 'Avisé',
        'A03' => 'Départ de France',
        'A04' => 'Arrivée',
        'A05' => 'Tentative de distribution infructueuse',
        'A06' => 'Dépôt',
        'A07' => 'Départ',
        'A08' => 'Arrivée en France',
        'A09' => 'Attente douane / dédouanement',
        'A10' => 'Dédouané, distribution en cours',
        'A11' => 'Renvoyé vers la bonne destination',
        'A12' => 'Renvoyé vers la bonne destination suite à correction de l\'adresse par La Poste',
        'A13' => 'Pli manquant au dépôt',
        'A14' => 'Non distribuable pour cause de dépassement du délai de mise à disposition du recommandé en ligne',
        'A15' => 'Non distribuable en attente d\'un contact client auprès du service Consommateurs',
        'A16' => 'Non distribuable pour cause de refus par le destinataire',
        'A17' => 'Non distribuable délai de conservation expiré (CGV)',
        'A18' => 'Non distribuable - refus',
        'A19' => 'Non distribuable',
        'A20' => 'En cours de traitement',
        'A21' => 'Retourné à l\'expéditeur pour cause d\'accès à la boîte aux lettres impossible',
        'A22' => 'Retourné à l\'expéditeur pour cause de boîte aux lettres non identifiable',
        'A23' => 'Retourné à l\'expéditeur pour cause d\'adresse incorrecte',
        'A24' => 'Retourné à l\'expéditeur suite à des recherches de La Poste',
        'A25' => 'Retourné à l\'expéditeur sur demande de l\'expéditeur',
        'A26' => 'Retourné à l\'expéditeur',
        'A27' => 'Renvoyé vers la bonne destination sur demande de l\'expéditeur',
        'P01' => 'Attend d\'être retiré au guichet',
        'P02' => 'En attente de seconde présentation',
        'P03' => 'Retourné à l\'expéditeur pour cause de dépassement de délai d\'instance',
        'P04' => 'Retour à l\'expéditeur - refus',
        'P05' => 'Retourné à l\'expéditeur pour cause de refus à l\'adresse',
        'P06' => 'Retourné à l\'expéditeur pour cause de refus de paiement',
        'D01' => 'Distribué',
        'N01' => 'AR Signé : RAR distribué',
        'N02' => 'PND (Pli Non Distribuable) pour une LR',
        'N03' => 'Non réclamé',
        'N04' => 'Décédé',
        'N05' => 'Refusé',
        'N06' => 'Impossibilité de signer',
        'N07' => 'Adresse incomplète',
        'N08' => 'Refus détérioré',
        'N09' => 'Régime international',
        'N10' => 'PND (Pli Non Distribuable) pour un courrier'
    ];

    public function __construct() { }

    /**
     * @return array
     */
    public function getStatuses(): array
    {
        return $this->statuses;
    }

    /**
     * @param array $statuses
     *
     * @throws MailevaException
     */
    public function setStatuses(array $statuses)
    {
        foreach ($statuses as $item) {
            try {
                $id   = $item[self::ID];
                $date = $item[self::DATE];

                $status = $item[self::STATUS];

                if (array_key_exists($status, $this->codeDescriptionMapping)) {
                    $item[self::DESCRIPTION] = $this->codeDescriptionMapping[$status];
                    $this->statuses[]        = $item;
                } else {
                    throw new MailevaException('unknow status ' . $status);
                }
            } catch (\Throwable $t) {
                throw new MailevaException($t->getMessage());
            }
        }
    }

    /**
     * @return array
     * @throws MailevaException
     */
    public function getActiveStatus(): array
    {
        if ($this->hasStatuses()) {
            return $this->statuses[count($this->statuses) - 1];
        } else {
            throw new MailevaException('No valid status set');
        }
    }

    /**
     * @return string
     * @throws MailevaException
     */
    public function getStatusCodeForActiveStatus(): string
    {
        return $this->getActiveStatus()[self::STATUS];
    }

    /**
     * @return string
     * @throws MailevaException
     */
    public function getDescriptionForActiveStatus(): string
    {
        return $this->getActiveStatus()[self::DESCRIPTION];
    }

    /**
     * @return string
     * @throws MailevaException
     */
    public function getIdForActiveStatus(): string
    {
        return $this->getActiveStatus()[self::ID];
    }

    /**
     * @return string
     * @throws MailevaException
     */
    public function getDateForActiveStatus(): string
    {
        return $this->getActiveStatus()[self::DATE];
    }

    /**
     * @return string
     * @throws MailevaException
     */
    public function getActiveStatusToString(): string
    {
        return $this->getIdForActiveStatus() . ' ' . $this->getStatusCodeForActiveStatus() . ' ' . $this->getDescriptionForActiveStatus() . ' ' . $this->getDateForActiveStatus();
    }

    /**
     * @return bool
     */
    public function hasStatuses(): bool
    {
        return count($this->statuses) > 0;
    }
}

