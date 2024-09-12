<?php

namespace BSchedule\App\Date\Convert;

use BSchedule\App\Date\Type\DateRange;
use DateTimeImmutable;

class RelativeToStrictDateConverter
{
    public function convert(string $relative)
    {
        return call_user_func([static::class, $relative]);
    }

    static function this_week(): DateRange
    {
        $today = new DateTimeImmutable();
        if ($today->format('N') != 7){
            return new DateRange($today, $today->modify('next Sunday'));
        }
        return new DateRange($today, $today);
    }

    static function this_month(): DateRange
    {
        $today = new DateTimeImmutable();
        $month_end = $today->modify('last day of this month');

        return new DateRange($today, $month_end);
    }

    static function next_week(): DateRange
    {
        $today = new DateTimeImmutable();
        $start = $today->modify('next Monday');
        $end = $start->modify('next Sunday');

        return new DateRange($start, $end);
    }

    static function next_month(): DateRange
    {
        $today = new DateTimeImmutable();
        $start = $today->modify('first day of next month');
        $end = $today->modify('last day of next month');

        return new DateRange($start, $end);
    }

}