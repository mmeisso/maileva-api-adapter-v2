<?php
/**
 * Created by PhpStorm.
 * User: loic
 * Date: 04/09/2018
 * Time: 08:59
 */

namespace MailevaApiAdapter\App\Core;

use MailevaApiAdapter\App\Exception\MailevaCoreException;
use Throwable;

class MailevaLREStatuses
{

    const DELIVERY_STATUSES = 'delivery_statuses';
    const ID = 'id';
    const DATE = 'date';
    const STATUS = 'status';
    const DESCRIPTION = 'description';
    const LIST_SENDING_STATUS_FULL_PROCESSED = [
        'D01',
        'A19'
    ];
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
    private $statuses = [];

    public function __construct() { }

    /**
     * @return array
     * @throws MailevaCoreException
     */
    public function getActiveStatus(): array
    {
        if ($this->hasStatuses()) {
            return $this->statuses[count($this->statuses) - 1];
        } else {
            throw new MailevaCoreException('No valid status set');
        }
    }

    /**
     * @return string
     * @throws MailevaCoreException
     */
    public function getActiveStatusToString(): string
    {
        return $this->getIdForActiveStatus() . ' ' . $this->getStatusCodeForActiveStatus() . ' ' . $this->getDescriptionForActiveStatus(
            ) . ' ' . $this->getDateForActiveStatus();
    }

    /**
     * @return string
     * @throws MailevaCoreException
     */
    public function getDateForActiveStatus(): string
    {
        return $this->getActiveStatus()[self::DATE];
    }

    /**
     * @return string
     * @throws MailevaCoreException
     */
    public function getDescriptionForActiveStatus(): string
    {
        return $this->getActiveStatus()[self::DESCRIPTION];
    }

    /**
     * @return string
     * @throws MailevaCoreException
     */
    public function getIdForActiveStatus(): string
    {
        return $this->getActiveStatus()[self::ID];
    }

    /**
     * @return string
     * @throws MailevaCoreException
     */
    public function getStatusCodeForActiveStatus(): string
    {
        return $this->getActiveStatus()[self::STATUS];
    }

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
     * @throws MailevaCoreException
     */
    public function setStatuses(array $statuses)
    {
        foreach ($statuses as $item) {
            try {
                $status = $item[self::STATUS];

                if (array_key_exists($status, $this->codeDescriptionMapping)) {
                    $item[self::DESCRIPTION] = $this->codeDescriptionMapping[$status];
                    $this->statuses[]        = $item;
                } else {
                    throw new MailevaCoreException('unknow status ' . $status);
                }
            } catch (Throwable $t) {
                throw new MailevaCoreException($t->getMessage());
            }
        }
    }

    /**
     * @return bool
     */
    public function hasStatuses(): bool
    {
        return count($this->statuses) > 0;
    }
}

