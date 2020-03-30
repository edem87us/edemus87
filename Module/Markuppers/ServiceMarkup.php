<?php
namespace App\Services\Markup\Module\Markuppers;

use Exception;
use HunterEngine;
use App\Hunter\Communication\ISearchRQ;
use Illuminate\Support\Facades\DB;
use Onex\DBPackage\Models\Interfaces\AgencyInterface;

/**
 * Class ServiceMarkup
 * @package App\Services\Markup\Module
 */
final class ServiceMarkup extends Markup
{
    /**
     * @var int
     */
    public const MARKUP_SCHEME = HunterEngine::MARKUP_SCHEME_ONEX_STANDARD;

    /**
     * @var int
     */
    public $serviceId;

    /**
     * Получение и запись наценок исходя из параметров
     *
     * @param ISearchRQ       $params
     * @param AgencyInterface $agency
     * @return void
     * @throws Exception
     */
    public function init(ISearchRQ $params, $agency = null): void
    {
        $this->setParams($params);
        $agency = $agency ?? $this->getAgency();

        $this->setAgency($agency);
        $this->setServiceId($this->getParams()->getServiceId());

        $this->initClientMarkups();
        $this->initOnlineExpressMarkups();
        $this->initAgenciesMarkups();
        $this->initFilterMarkups();
    }

    /**
     *  Инициализирует клиентские наценки
     */
    private function initClientMarkups(): void
    {
        $clientMarkup = DB::select('CALL getClientMarkup(?)', [$this->agency->getId()]);

        if ($clientMarkup) {
            $this->getMarkupTypes()->setClient(current($clientMarkup['markup']));
        }
    }

    /**
     *  Инициализирует агентские наценки
     */
    private function initAgenciesMarkups(): void
    {
        if ($this->agency->isRoot()) {
            return;
        }

        $agencyMarkups = DB::select('CALL getAllOnexMarkup(?,?)',[$this->agency->getId(), $this->getServiceId()]);
        foreach ($agencyMarkups as $agencyMarkup) {
            $this->getMarkupTypes()->setAgency($agencyMarkup['markup'], $agencyMarkup['supplierId']);
        }
    }

    /**
     *  Инициализирует наценки OEX
     */
    private function initOnlineExpressMarkups(): void
    {
        $onlineExpressMarkups = DB::select('CALL getAllOnexMarkup(?,?)',[$this->agency->getId(), $this->getServiceId()]);
        foreach ($onlineExpressMarkups as $onlineExpressMarkup) {
            $this->getMarkupTypes()->setOnex($onlineExpressMarkup['markup'], $onlineExpressMarkup['supplierId']);
        }
    }

    /**
     * Инициализация фильтр-наценок
     */
    private function initFilterMarkups(): void
    {
        $query   = \FilterMarkupQueryBuilder::getQuery($this->getParams(), $this->getServiceId());
        $markups = $query->get()->toArray();

        if (!empty($markups)) {
            foreach ($markups as $markup) {
                $this->getMarkupTypes()->setFilter($markup['supplierId'], $markup);
            }
        }
    }

    /**
     * @return int
     */
    private function getServiceId(): int
    {
        return $this->serviceId;
    }

    /**
     * @param int $serviceId
     */
    private function setServiceId(int $serviceId): void
    {
        $this->serviceId = $serviceId;
    }

}