<?php

namespace BSchedule\App\Client\HTTP\Schedule\Action;

use BSchedule\App\Date\Type\DateRange;
use BSchedule\Domain\Schedule\Request\GetScheduleRequest;

class SendScheduleRequestAction
{
    public function handle(GetScheduleRequest $request)
    {
        $url = 'https://schedule.kse.ua/uk/index/'.$request->format.'?id_grp='.implode(',',$request->groups).
            '&date_beg='.$request->range->start->format('d.m.Y').
            '&date_end='.$request->range->end->format('d.m.Y');
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPGET, true);

        $response = curl_exec($ch);
        $filename = 'Schedule_'.$request->range->start->format('d-m-Y').'-'.$request->range->end->format('d-m-Y');
        curl_close($ch);

        if ($request->format === 'pdf') {
            header('Content-Type: application/pdf');
            header('Content-Disposition: inline; filename="' . $filename.'.pdf' . '"');
        }

        if ($request->format == 'ical') {
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . $filename.'.ics' . '"');
        }

        header('Content-Length: ' . strlen($response));
        echo $response;
    }
}