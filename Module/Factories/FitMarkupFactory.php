<?php
namespace App\Services\Markup\Module\Factories;

use App\Services\Markup\Module\Factories\Interfaces\MarkupFactoryInterface;
use App\Services\Markup\Module\Markuppers\FitMarkup;
use App\Services\Markup\Module\FitMarkupPricing;
use App\Services\Markup\Module\Interfaces\PricingInterface;
use App\Services\Markup\Module\Markuppers\Markup;

class FitMarkupFactory implements MarkupFactoryInterface
{
    /**
     * Создает экземпляр класса для получения наценок агентств FIT
     *
     * @return Markup
     */
    public function createMarkup(): Markup
    {
        return new FitMarkup();
    }

    /**
     * Создает экземпляр класса для применения наценок для агентств FIT
     *
     * @return PricingInterface
     */
    public function createPricing(): PricingInterface
    {
        return new FitMarkupPricing();
    }
}