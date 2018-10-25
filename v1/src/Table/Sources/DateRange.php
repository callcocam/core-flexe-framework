<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 07/09/2018
 * Time: 16:41
 */

namespace Flexe\Table\Sources;


use Carbon\Carbon;
use Flexe\Db\Commons\Queries\Select;

trait DateRange
{

    public $field_date = 'created_at';

    /**
     * Scope a query to only include the current minute entries.
     *
     * @param $query
     * @param null $number
     * @return Select
     */
    public function CurrentMinute($query, $number = null)
    {
        return $query->between($this->field_date, [
            Carbon::now()->second(0),
            Carbon::now()
        ]);
    }

    /**
     * Scope a query to only include the last minute entries.
     *
     * @param $query
     * @param null $number
     * @return Select
     */
    public function lastMinute($query, $number = null)
    {
        if($number):

            return $this->LastMinutes($query, $number);

        endif;

        return $query->between($this->field_date, [
            Carbon::now()->subMinute()->second(0),
            Carbon::now()->second(0)
        ]);
    }

    /**
     * Scope a query to only include the current hour entries.
     *
     * @param $query
     * @param null $number
     * @return Select
     */
    public function CurrentHour($query, $number = null)
    {
        return $query->between($this->field_date, [
            Carbon::now()->minute(0)->second(0),
            Carbon::now()
        ]);
    }

    /**
     * Scope a query to only include the last hour entries.
     *
     * @param $query
     * @param null $number
     * @return Select
     */
    public function LastHour($query, $number = null)
    {
        if($number):

            return $this->LastHours($query, $number);

        endif;

        return $query->between($this->field_date, [
            Carbon::now()->subHour()->minute(0)->second(0),
            Carbon::now()->minute(0)->second(0)
        ]);
    }

    /**
     * Scope a query to only include the current day entries.
     *
     * @param $query
     * @param null $number
     * @return Select
     */
    public function CurrentDay($query, $number = null)
    {
        return $query->between($this->field_date, [
            Carbon::now()->startOfDay(),
            Carbon::now()
        ]);
    }

    /**
     * Scope a query to only include the last day entries.
     *
     * @param $query
     * @param null $number
     * @return Select
     */
    public function LastDay($query, $number = null)
    {
        if($number):

            return $this->LastDays($query, $number);

        endif;

        return $query->between($this->field_date, [
            Carbon::now()->subDay()->startOfDay(),
            Carbon::now()->startOfDay()
        ]);
    }

    /**
     * Scope a query to only include the current week entries.
     *
     * @param $query
     * @param null $number
     * @return Select
     */
    public function CurrentWeek($query, $number = null)
    {
        return $query->between($this->field_date, [
            Carbon::now()->startOfWeek(),
            Carbon::now()
        ]);
    }

    /**
     * Scope a query to only include the last week entries.
     *
     * @param $query
     * @param null $number
     * @return Select
     */
    public function LastWeek($query, $number = null)
    {
        if($number):

            return $this->LastWeeks($query, $number);

        endif;

        return $query->between($this->field_date, [
            Carbon::now()->subWeek()->startOfWeek(),
            Carbon::now()->subWeek()->endOfWeek()
        ]);
    }

    /**
     * Scope a query to only include the current month entries.
     *
     * @param $query
     * @return Select
     */
    public function CurrentMonth($query, $number = null)
    {
        return $query->between($this->field_date, [
            Carbon::now()->startOfMonth(),
            Carbon::now()
        ]);
    }

    /**
     * Scope a query to only include the last month entries.
     *
     * @param $query
     * @return Select
     */
    public function LastMonth($query, $number = null)
    {
        if($number):

            return $this->LastMonths($query, $number);

        endif;

        return $query->between($this->field_date, [
            Carbon::now()->subMonth()->startOfMonth(),
            Carbon::now()->subMonth()->endOfMonth()
        ]);
    }

    /**
     * Scope a query to only include the current year entries.
     *
     * @param $query
     * @return Select
     */
    public function CurrentYear($query, $number = null)
    {
        return $query->between($this->field_date, [
            Carbon::now()->startOfYear(),
            Carbon::now()
        ]);
    }

    /**
     * Scope a query to only include the last year entries.
     *
     * @param $query
     * @return Select
     */
    public function LastYear($query, $number = null)
    {
        if($number):

            return $this->LastYears($query, $number);

        endif;

        return $query->between($this->field_date, [
            Carbon::now()->subYear()->startOfYear(),
            Carbon::now()->subYear()->endOfYear()
        ]);
    }

    /**
     * Scope a query to only include the last x seconds entries.
     *
     * @param $query
     * @param int $countSeconds
     * @return Select
     */
    public function LastSeconds($query, int $countSeconds)
    {
        return $query->between($this->field_date, [
            Carbon::now()->subSeconds($countSeconds),
            Carbon::now()
        ]);
    }

    /**
     * Scope a query to only include the last x minutes entries.
     *
     * @param $query
     * @param int $countMinutes
     * @return Select
     */
    public function LastMinutes($query, int $countMinutes)
    {
        return $query->between($this->field_date, [
            Carbon::now()->subMinutes($countMinutes)->second(0),
            Carbon::now()
        ]);
    }

    /**
     * Scope a query to only include the last x hours entries.
     *
     * @param $query
     * @param int $countHours
     * @return Select
     */
    public function LastHours($query, int $countHours)
    {
        return $query->between($this->field_date, [
            Carbon::now()->subHours($countHours)->minute(0),
            Carbon::now()
        ]);
    }

    /**
     * Scope a query to only include the last x days entries.
     *
     * @param $query
     * @param int $countDays
     * @return Select
     */
    public function LastDays($query, int $countDays)
    {
        return $query->between($this->field_date, [
            Carbon::now()->subDays($countDays)->startOfDay(),
            Carbon::now()
        ]);
    }

    /**
     * Scope a query to only include the last x weeks entries.
     *
     * @param $query
     * @param int $countWeeks
     * @return Select
     */
    public function LastWeeks($query, int $countWeeks)
    {
        return $query->between($this->field_date, [
            Carbon::now()->subWeeks($countWeeks)->startOfWeek(),
            Carbon::now()
        ]);
    }

    /**
     * Scope a query to only include the last x months entries.
     *
     * @param $query
     * @param int $countMonths
     * @return Select
     */
    public function LastMonths($query, int $countMonths)
    {
        return $query->between($this->field_date, [
            Carbon::now()->subMonths($countMonths)->startOfMonth(),
            Carbon::now()
        ]);
    }

    /**
     * Scope a query to only include the last x years entries.
     *
     * @param $query
     * @param int $countYears
     * @return Select
     */
    public function LastYears($query, int $countYears)
    {
        return $query->between($this->field_date, [
            Carbon::now()->subYears($countYears)->startOfYear(),
            Carbon::now()
        ]);
    }
}