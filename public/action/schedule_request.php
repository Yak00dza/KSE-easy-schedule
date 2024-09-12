<?php

require_once(getenv('PROJECT_ROOT').'/vendor/autoload.php');

use BSchedule\Domain\Schedule\Action\GetScheduleAction;

$action = new GetScheduleAction();
$action->handle($_GET);


