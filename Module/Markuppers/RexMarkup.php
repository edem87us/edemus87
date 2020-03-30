<?php


namespace App\Services\Markup\Module\Markuppers;

use App\Services\Markup\Module\Builders\RexMarkupQueryBuilder;
use Exception;
use HunterEngine;
use Onex\DBPackage\Models\AgenciesLevels;
use Onex\DBPackage\Models\Interfaces\AgencyInterface;
use Onex\DBPackage\Models\RussianExpressMarkups;
use App\Hunter\Communication\ISearchRQ;

final class RexMarkup extends Markup
{
    /**
     * @var int
     */
    public const MARKUP_SCHEME = HunterEngine::MARKUP_SCHEME_REX_STANDARD;

    /**
     * Инициализация наценок, комиссий и установка настроек
     *
     * @param ISearchRQ            $params
     * @param bool|AgencyInterface $agency
     * @throws Exception
     */
    public function init($params, $agency = null): void
    {
        $agency = $agency ?? $this->getAgency();

        $this->setParams($params);
        $this->initMarkup();
        $this->initCommissions($agency);
    }

    /**
     * Инициализирует единую наценку для тура
     * @throws Exception
     */
    private function initMarkup(): void
    {
        $countryId = $this->getParams()->getCountryId() ?? 0;
        $cityId = $this->getParams()->getCityId() ?? 0;

        $query = RexMarkupQueryBuilder::getQuery($this->getParams());

        /** @var RussianExpressMarkups $markup */
        foreach ($query->get() as $markup) {
            if (($markup->citiesId !== 0) && !in_array($cityId, explode(',', $markup->citiesId), true)) {
                continue;
            }

            if (($markup->countriesId !== 0) && !in_array($countryId, explode(',', $markup->countriesId), true)) {
                continue;
            }

            $this->getMarkupTypes()->setOnex($markup->value, 0);
            break;
        }
    }
    /**
     * Устанавливает значения комиссий для данного агентства
     *
     * @param AgencyInterface $agency
     */
    public function initCommissions(AgencyInterface $agency): void
    {
        $agency->commissionLevelId = $agency->commissionLevelId ?? 1;

        $commission = AgenciesLevels::find($agency->commissionLevelId);
        $this->getMarkupTypes()->setClient($commission->commissionStandard);
    }
}