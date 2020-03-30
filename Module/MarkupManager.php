<?php
namespace App\Services\Markup\Module;

use App\Exceptions\OnexException;
use App\Hunter\Communication\ISearchRQ;
use SearchResult;

/**
 * Class MarkupManager
 * @package App\Services\Markup\Module
 */
class MarkupManager implements MarkupManagerInterface
{
    /**
     * Применяет наценку на результат поиска
     *
     * @param ISearchRQ    $request
     * @param SearchResult $result
     * @throws OnexException
     */
    public function applyMarkups(ISearchRQ $request, SearchResult $result): void
    {
        $markupFactory = new MarkupFactory($request->getSchema());
        $factory = $markupFactory->create();

        $markup = $factory->createMarkup();
        $markup->init($request);

        $pricing = $factory->createPricing();
        $pricing->setMarkupper($markup);

        $price = $pricing->calculatePrice($result->getPrice());
        $markPrice = $pricing->calculateMarkup($result->getMarkPrice());
        $result->setPrice($price);
        $result->setMarkPrice($markPrice);
    }

}