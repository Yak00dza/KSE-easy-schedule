<?php

namespace BSchedule\App\Date\Type;

use DateTimeImmutable;

class DateRange
{
    public DateTimeImmutable $start;

    public DateTimeImmutable $end;

    public function __construct(DateTimeImmutable $start, DateTimeImmutable $end)
    {
        $this->start = $start;
        $this->end = $end;
    }

    public function __toString()
    {
        return 'Start: '.$this->start->format('d.m.Y').' End: '.$this->end->format('d.m.Y');
    }
}