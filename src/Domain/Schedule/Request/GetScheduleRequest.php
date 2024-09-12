<?php

namespace BSchedule\Domain\Schedule\Request;

use BSchedule\App\Date\Type\DateRange;

class GetScheduleRequest
{
    public function __construct(
       public DateRange $range,
       public array $groups,
       public string $format
    ) {}
}