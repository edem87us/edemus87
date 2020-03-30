<?php
namespace App\Services\Markup\Module\Exceptions;

use App\Exceptions\OnexException;

/**
 * Class MarkupException
 * @package App\Services\Markup\Module
 */
class MarkupException extends OnexException
{
    /**
     * @var int
     */
    public const NOT_FOUND_MARKUP_CLASS = 1;

    /**
     * @var int
     */
    public const CANT_INIT_MARKUP = 2;

    /**
     * Получение текста ошибки
     *
     * @param int $code
     * @param null $additional
     * @return string|null
     */
    protected static function getMessageByCode($code, $additional = null): ?string
    {
        switch ($code) {
            case self::NOT_FOUND_MARKUP_CLASS:
                return 'Не найден класс инициализации наценок для сщщтветствующей схемы';
                break;
            case self::CANT_INIT_MARKUP:
                return 'Не удалось получить наценки';
                break;
            default:
                return $additional;
                break;
        }
    }
}