<?php


namespace App\Services\Markup\Module\Builders;

use AviaticketSearchRQ;
use Exception;
use HotelSearchRQ;
use Onex\DBPackage\Models\FilterMarkup;
use \Illuminate\Database\Eloquent\Builder;
use \Onex\DBPackage\Factories\RepositoryFactory;
use \Carbon\Carbon;
use App\Hunter\Communication\ISearchRQ;

class TourMarkupsQueryBuilder
{
    /**
     * @var ISearchRQ
     */
    public static $params;

    /**
     * Getter params
     *
     * @return HotelSearchRQ|AviaticketSearchRQ|ISearchRQ
     */
    protected static function getParams()
    {
        return self::$params;
    }

    /**
     * Генерирует запрос на получение наценок Русского Экспресса
     *
     * @param ISearchRQ $params
     * @return Builder
     * @throws Exception
     */
    public static function getQuery(ISearchRQ $params): Builder
    {
        self::$params = $params;

        $query = FilterMarkup::query();

        self::addMainPartToQuery($query);
        self::addDatesToQuery($query);

        return $query;
    }

    /**
     * Добавляет основные параметры запроса
     *
     * @param Builder $query
     */
    private static function addMainPartToQuery(Builder $query): void
    {
        $suppliersRepo = RepositoryFactory::makeSuppliersRepo();
        $suppliersId = $suppliersRepo->getAllEnabledNS()->pluck('id')->toArray();
        $suppliersId[] = 0;

        $query->select(['markupValue'])
            ->whereIn('suppliersId', $suppliersId)
            ->where([['enabled', '=', 1], ['serviceId', '=', \HunterEngine::TYPE_TOURS]])
            ->orderBy('id', 'desc');
    }

    /**
     * Добавляет параметр времени бронирования
     *
     * @param Builder $query
     * @throws Exception
     */
    private static function addDatesToQuery(Builder $query): void
    {
        $checkInDate = self::getParams()->getStartDate();
        $checkOutDate =self::getParams()->getEndDate();

        $query->where(static function($q) use ($checkInDate, $checkOutDate)  {
            $q->where([['arrivalDateStart', '<', $checkInDate], ['arrivalDateFinish', '>', $checkOutDate]])
                ->orWhere(static function ($g) {
                    $g->where('arrivalDateStart', '=', null)
                        ->where('arrivalDateFinish', '=', null);
                });
        });

        $query->where(static function($q) {
            $q->where([['bookingDateStart', '<', time()], ['bookingDateFinish', '>', time()]])
                ->orWhere(static function ($g) {
                    $g->where('bookingDateStart', '=', null)
                        ->where('bookingDateFinish', '=', null);
                });
        });
    }
}