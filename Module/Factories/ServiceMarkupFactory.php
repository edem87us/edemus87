<?php
namespace App\Services\Markup\Module\Factories;

use App\Services\Markup\Module\Factories\Interfaces\MarkupFactoryInterface;
use App\Services\Markup\Module\Interfaces\PricingInterface;
use App\Services\Markup\Module\Markuppers\Markup;
use App\Services\Markup\Module\Markuppers\ServiceMarkup;
use App\Services\Markup\Module\ServiceMarkupPricing;

/**
 * Class ServiceMarkupFactory
 * @package App\Services\Markup\Module\Factories
 */
class ServiceMarkupFactory implements MarkupFactoryInterface
{
    /**
     * Создает экземпляр класса для получения наценок сервисов услуг
     *
     * @return Markup
     */
    public function createMarkup(): Markup
    {
        return new ServiceMarkup();
    }
    /**
     * Создает экземпляр класса для применения наценок для сервисов услуг
     *
     * @return PricingInterface
     */
    public function createPricing(): PricingInterface
    {
        return new ServiceMarkupPricing();
    }
}