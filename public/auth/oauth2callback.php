<?php

use BSchedule\App\Client\Google\Action\SetupGoogleClientAction;

require_once(getenv('PROJECT_ROOT').'/vendor/autoload.php');

session_start();

$client = (new SetupGoogleClientAction())->getOauthClient();

if (!isset($_GET['code'])) {
    // Generate and set state value
    $state = bin2hex(random_bytes(16));
    $client->setState($state);
    $_SESSION['state'] = $state;

    $auth_url = $client->createAuthUrl();
    header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));
} else {
    // Check the state value
    if (!isset($_GET['state']) || $_GET['state'] !== $_SESSION['state']) {
        die('State mismatch. Possible CSRF attack.');
    }
    $client->fetchAccessTokenWithAuthCode($_GET['code']);
    $_SESSION['access_token'] = $client->getAccessToken();
    $redirect_uri = getenv('DOMAIN').'/schedule.php';
    header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
}