<?php
namespace App\Services\Markup\Module\PricingServices;

/**
 * Class ServiceMarkupPricing
 * @package App\Services\Markup\Module
 */
final class ServiceMarkupPricing extends MarkupPricing
{
    /**
     * @var int
     */
    private $supplierId;

    /**
     * Рассчет цены с учетом наценки
     *
     * @param float $price
     * @return float
     */
    public function calculatePrice(float $price): float
    {
        $markups = $this->getMarkupper()->getMarkupTypes();
        //Добавляем агенстскую наценку
        $price += $price * ($markups->getAgency($this->getSupplierId()) / 100);

        //Добавляем наценку ОЕ и фильтры
        $filterMarkup = $markups->getFilter($this->getSupplierId());
        $markup = $filterMarkup + $markups->getOnex($this->getSupplierId());

        $price += $price * ($markup / 100);

        //добавляем клиентскую наценку
        $price += $price * ($markups->getClient() / 100);

        return round($price, 2);
    }

    /**
     * Рассчет наценки клиента
     *
     * @param float $price
     * @return float
     */
    public function calculateMarkup(float $price): float
    {
        $price = $this->calculatePrice($price);
        return round($price - $price / ($this->getMarkupper()->getMarkupTypes()->getClient() / 100 + 1));
    }

    /**
     * @return int
     */
    public function getSupplierId(): int
    {
        return $this->supplierId;
    }

    /**
     * @param int $supplierId
     */
    public function setSupplierId(int $supplierId): void
    {
        $this->supplierId = $supplierId;
    }
}
