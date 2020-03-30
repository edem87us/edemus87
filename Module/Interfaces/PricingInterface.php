<?php
namespace App\Services\Markup\Module\Interfaces;

use App\Services\Markup\Module\Markuppers\Markup;

/**
 * Interface PricingInterface
 * @package App\Services\Markup\Module\Interfaces
 */
interface PricingInterface
{
    /**
     * @param float $priceNet
     * @return float
     */
    public function calculatePrice(float $priceNet): float;

    /**
     * @param float $price
     * @return float
     */
    public function calculateMarkup(float $price): float;

    /**
     * @param Markup $markupper
     */
    public function setMarkupper(Markup $markupper): void;
}