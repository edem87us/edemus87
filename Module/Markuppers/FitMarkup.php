<?php
namespace App\Services\Markup\Module\Markuppers;

use App\Hunter\Communication\ISearchRQ;
use HunterEngine;
use Onex\DBPackage\Models\Interfaces\AgencyInterface;

/**
 * Class FitMarkup
 * @package App\Services\Markup\Module
 */
final class FitMarkup extends Markup
{
    /**
     * @var int
     */
    public const MARKUP_SCHEME = HunterEngine::MARKUP_SCHEME_FIT;

    /**
     * Инициализация наценок, комиссий и установка настроек.
     * На данном этапе на агентства FIT не применяется наценка
     *
     * @param ISearchRQ       $params
     * @param AgencyInterface $agency
     * @return void
     */
    public function init(ISearchRQ $params, $agency = null): void
    {
        $this->setParams($params);
        $agency = $agency ?? $this->getAgency();

        $this->setAgency($agency);
        $this->getMarkupTypes()->setOnex(0, 0);
    }
}