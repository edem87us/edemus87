<?php
namespace App\Services\Markup\Module\Factories;

use App\Services\Markup\Module\Factories\Interfaces\MarkupFactoryInterface;
use App\Services\Markup\Module\Interfaces\PricingInterface;
use App\Services\Markup\Module\Markuppers\Markup;
use App\Services\Markup\Module\Markuppers\RexMarkup;
use App\Services\Markup\Module\RexMarkupPricing;

/**
 * Class RexMarkupFactory
 * @package App\Services\Markup\Module\Factories
 */
class RexMarkupFactory implements MarkupFactoryInterface
{
    /**
     * Создает экземпляр класса для наценок агентств Русского Экспресса
     *
     * @return Markup
     */
    public function createMarkup(): Markup
    {
        return new RexMarkup();
    }

    /**
     * Создает экземпляр класса для применения наценок для агентств Русского Экспресса
     *
     * @return PricingInterface
     */
    public function createPricing(): PricingInterface
    {
        return new RexMarkupPricing();
    }
}