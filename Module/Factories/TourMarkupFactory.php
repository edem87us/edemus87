<?php
namespace App\Services\Markup\Module\Factories;

use App\Services\Markup\Module\Factories\Interfaces\MarkupFactoryInterface;
use App\Services\Markup\Module\Interfaces\PricingInterface;
use App\Services\Markup\Module\Markuppers\Markup;
use App\Services\Markup\Module\Markuppers\TourMarkup;
use App\Services\Markup\Module\TourMarkupPricing;

/**
 * Class TourMarkupFactory
 * @package App\Services\Markup\Module\Factories
 */
class TourMarkupFactory implements MarkupFactoryInterface
{
    /**
     * Создает экземпляр класса для получения наценок туров
     *
     * @return Markup
     */
    public function createMarkup(): Markup
    {
        return new TourMarkup();
    }
    /**
     * Создает экземпляр класса для применения наценок для туров
     *
     * @return PricingInterface
     */
    public function createPricing(): PricingInterface
    {
        return new TourMarkupPricing();
    }
}