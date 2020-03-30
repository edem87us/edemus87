<?php
namespace App\Services\Markup\Module;

use App\Exceptions\OnexException;
use App\Services\Markup\Module\Exceptions\MarkupException;
use App\Services\Markup\Module\Factories\FitMarkupFactory;
use App\Services\Markup\Module\Factories\Interfaces\MarkupFactoryInterface;
use App\Services\Markup\Module\Factories\RexMarkupFactory;
use App\Services\Markup\Module\Factories\ServiceMarkupFactory;
use App\Services\Markup\Module\Factories\TourMarkupFactory;
use App\Services\Markup\Module\Markuppers\FitMarkup;
use App\Services\Markup\Module\Markuppers\RexMarkup;
use App\Services\Markup\Module\Markuppers\ServiceMarkup;
use App\Services\Markup\Module\Markuppers\TourMarkup;

/**
 * Class MarkupFactory
 * @package App\Services\Markup\Module
 */
class MarkupFactory
{
    /**
     * @var string
     */
    private $markupSchema;

    /**
     * MarkupFactory constructor.
     * @param string $markupSchema
     */
    public function __construct(string $markupSchema)
    {
        $this->markupSchema = $markupSchema;
    }

    /**
     * Создание фабрики наценщика
     *
     * @return MarkupFactoryInterface
     * @throws OnexException
     */
    public function create(): MarkupFactoryInterface
    {
        switch ($this->markupSchema) {
            case ServiceMarkup::MARKUP_SCHEME:
                return new ServiceMarkupFactory();
                break;
            case TourMarkup::MARKUP_SCHEME:
                return new TourMarkupFactory();
                break;
            case RexMarkup::MARKUP_SCHEME:
                return new RexMarkupFactory();
                break;
            case FitMarkup::MARKUP_SCHEME:
                return new FitMarkupFactory();
                break;
            default:
                throw MarkupException::create(MarkupException::NOT_FOUND_MARKUP_CLASS);
        }
    }
}