<?php
namespace App\Services\Markup\Module\PricingServices;

use App\Services\Markup\Module\Interfaces\PricingInterface;
use App\Services\Markup\Module\Markuppers\Markup;

/**
 * Базовый класс расчета наценок
 *
 * Class MarkupPricing
 * @package App\Services\Markup\Module
 */
class MarkupPricing implements PricingInterface
{
    /**
     * @var Markup
     */
    private $markupper;

    /**
     * Вычисляет цену с учетом наценки
     *
     * @param float $price
     * @return float
     */
    public function calculatePrice(float $price): float
    {
        $markup = $this->getMarkupper()->getMarkupTypes()->getOnex(0);
        $price += $price * ($markup / 100);

        return round($price, 2);
    }

    /**
     * Вычисляет комиссии для агентств
     *
     * @param float $price
     * @return float
     */
    public function calculateMarkup(float $price): float
    {
        return round($price * ($this->getMarkupper()->getMarkupTypes()->getClient() / 100), 2);
    }

    /**
     * @return Markup
     */
    public function getMarkupper(): Markup
    {
        return $this->markupper;
    }

    /**
     * @param Markup $markupper
     */
    public function setMarkupper(Markup $markupper): void
    {
        $this->markupper = $markupper;
    }
}