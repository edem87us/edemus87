<?php
namespace App\Services\Markup\Module\Markuppers;

use App\Hunter\Communication\ISearchRQ;
use App\Services\Markup\Module\Builders\TourMarkupsQueryBuilder;
use Exception;
use HunterEngine;
use Onex\DBPackage\Models\AgencyDPCommission;
use Onex\DBPackage\Models\Interfaces\AgencyInterface;

/**
 * Class TourMarkup
 * @package App\Services\Markup\Module
 */
final class TourMarkup extends Markup
{
    /**
     * @var int
     */
    public const MARKUP_SCHEME = HunterEngine::MARKUP_SCHEME_TOUR;

    /**
     * Инициализация наценок, комиссий и установка настроек
     *
     * @param ISearchRQ $params
     * @param bool|AgencyInterface $agency
     * @return void
     * @throws Exception
     */
    public function init(ISearchRQ $params, $agency = null): void
    {
        $agency = $agency ?? $this->getAgency();
        $this->setAgency($agency);
        $this->setParams($params);
        $this->initMarkup();
        $this->initCommissions();
    }

    /**
     * Инициализирует единую наценку для тура
     *
     * @return void
     * @throws Exception
     */
    public function initMarkup(): void
    {
        $query = TourMarkupsQueryBuilder::getQuery($this->getParams());

        if ($activeMarkups = $query->first()) {
            $this->getMarkupTypes()->setOnex($activeMarkups->markupValue, 0);
        }
    }

    /**
     * Устанавливает значения комиссий для данного агентства
     *
     * @return void
     */
    public function initCommissions(): void
    {
        $commission = AgencyDPCommission::where('agencyId', '=', $this->getAgency()->getId())->first();

        if ($commission) {
            $this->getMarkupTypes()->setClient($commission->value);
        }
    }

}