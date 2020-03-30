<?php
namespace App\Services\Markup\Module\Builders;

use AviaticketSearchRQ;
use Exception;
use HotelSearchRQ;
use \Onex\DBPackage\Models\RussianExpressMarkups;
use \Illuminate\Database\Eloquent\Builder;
use \Onex\DBPackage\Factories\RepositoryFactory;
use \Carbon\Carbon;
use App\Hunter\Communication\ISearchRQ;

class RexMarkupQueryBuilder
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

        $query = RussianExpressMarkups::query();

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

        $query->select(['markupType', 'currency', 'value', 'citiesId', 'countriesId', 'servicesId'])
            ->whereIn( 'suppliersId', $suppliersId)
            ->orderBy('priority', 'desc');
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
        $duration = self::getParams()->countDuration();

        $query->where(static function($q) use ($checkInDate, $checkOutDate)  {
            $q->where([['arrivalDateStart', '<', $checkInDate], ['arrivalDateFinish', '>', $checkOutDate]])
                ->orWhere(static function ($g) {
                    $g->where('arrivalDateStart', '=', null)
                        ->where('arrivalDateFinish', '=', null);
                });
        });

        $query->where(static function($q) use ($duration)  {
            $q->where([['durationStart', '<=', $duration], ['durationFinish', '>=', $duration]])
                ->orWhere(static function ($g) {
                    $g->where('durationStart', '=', 0)
                        ->where('durationFinish', '=', 0);
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