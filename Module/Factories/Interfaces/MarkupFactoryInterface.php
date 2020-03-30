<?php
namespace App\Services\Markup\Module\Factories\Interfaces;

use App\Services\Markup\Module\Interfaces\PricingInterface;
use App\Services\Markup\Module\Markuppers\Markup;

/**
 * Interface MarkupFactoryInterface
 * @package App\Services\Markup\Module\Factories\Interfaces
 */
interface MarkupFactoryInterface
{
    /**
     * Создает экземпляр класса для получения наценок
     *
     * @return Markup
     */
    public function createMarkup(): Markup;

    /**
     * Создает экземпляр класса для применения наценок
     *
     * @return PricingInterface
     */
    public function createPricing(): PricingInterface;

}