<?php

namespace App\Services\Markup\Module\Markuppers;

use App\Hunter\Communication\ISearchRQ;
use App\Services\Markup\Module\Models\MarkupType;
use Onex\DBPackage\Models\Agency;
use Onex\DBPackage\Models\Interfaces\AgencyInterface;

/**
 * Class Markup
 * @package App\Services\Markup\Module
 */
abstract class Markup
{
    /**
     * @var string наименование агентства гость
     */
    protected const GUEST_AGENCY_NAME = 'guestMarkups';

    /**
     * @var MarkupType
     */
    private $markupTypes;

    /**
     * @var ISearchRQ
     */
    private $params;

    /**
     * @var AgencyInterface
     */
    protected $agency;

    public function __construct()
    {
        $this->setMarkupTypes(new MarkupType());
    }

    /**
     * @param ISearchRQ $params
     * @param AgencyInterface $agency
     * @return void
     */
    abstract public function init(ISearchRQ $params, $agency = null): void;

    /**
     * @return MarkupType
     */
    public function getMarkupTypes(): MarkupType
    {
        return $this->markupTypes;
    }

    /**
     * @param MarkupType $markupTypes
     */
    protected function setMarkupTypes(MarkupType $markupTypes): void
    {
        $this->markupTypes = $markupTypes;
    }

    /**
     * @return ISearchRQ
     */
    protected function getParams(): ISearchRQ
    {
        return $this->params;
    }

    /**
     * @param ISearchRQ $params
     */
    protected function setParams(ISearchRQ $params): void
    {
        $this->params = $params;
    }

    /**
     * @return AgencyInterface
     */
    protected function getAgency(): AgencyInterface
    {
        if (Auth::user()) {
            return Auth::user()->agency;
        }

        return Agency::where('name', '=', self::GUEST_AGENCY_NAME)->first();
    }

    /**
     * @param AgencyInterface $agency
     */
    protected function setAgency(AgencyInterface $agency): void
    {
        $this->agency = $agency;
    }


}