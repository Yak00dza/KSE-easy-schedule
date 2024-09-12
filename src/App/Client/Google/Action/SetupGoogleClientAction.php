<?php

namespace BSchedule\App\Client\Google\Action;

use Google_Client;
use Google_Service_Sheets;

class SetupGoogleClientAction
{
    public function getOauthClient(): Google_Client
    {
        $config = json_decode(file_get_contents(getenv('PROJECT_ROOT').'/config/client.json'), true)['web'];

        $client = new Google_Client();
        $client->setClientId($config['client_id']);
        $client->setClientSecret($config['client_secret']);
        $client->setScopes(['email']);
        $client->setRedirectUri(getenv('DOMAIN').'/auth/oauth2callback.php');
        $client->setAccessType('offline');
        $client->setPrompt('consent');
        $client->setIncludeGrantedScopes(true);

        return $client;
    }



}