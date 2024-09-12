<?php

namespace BSchedule\Domain\Schedule\Action;

use BSchedule\App\Client\HTTP\Action\GetGroupIDsAction;
use BSchedule\App\Client\HTTP\Schedule\Action\SendScheduleRequestAction;
use BSchedule\App\Date\Convert\RelativeToStrictDateConverter;
use BSchedule\App\Date\Type\DateRange;
use BSchedule\Domain\Groups\Action\GetGroupsAction;
use BSchedule\Domain\Schedule\Request\GetScheduleRequest;
use DateTimeImmutable;

class GetScheduleAction
{
    public function handle(array $get)
    {
        $timeframe = $get['timeframe'];
        $endDate = $get['end_date'];
        $format = $get['format'];

        if ($endDate) {
            $range = new DateRange(new DateTimeImmutable(), DateTimeImmutable::createFromFormat('Y-m-d', $endDate));
        }
        else {
            $converter = new RelativeToStrictDateConverter();
            $range = $converter->convert($timeframe);
        }
        $groups = (new GetGroupsAction())->handle();

        $request = new GetScheduleRequest($range, $groups, $format);
        (new SendScheduleRequestAction())->handle($request);
    }
}