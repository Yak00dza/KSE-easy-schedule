<?php

use BSchedule\App\Client\Google\Action\SetupGoogleClientAction;

require_once(getenv('PROJECT_ROOT').'/vendor/autoload.php');

session_start();

$client = (new SetupGoogleClientAction())->getOauthClient();

if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
    $client->setAccessToken($_SESSION['access_token']);
}
if ($client->isAccessTokenExpired() || !isset($_SESSION['access_token']))
{
    $redirect_uri = $client->getRedirectUri();

    header('Location: '.$redirect_uri);
    exit();
}

$redirect_uri = getenv('DOMAIN').'/schedule.php';
header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));