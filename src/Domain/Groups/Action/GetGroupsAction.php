<?php

namespace BSchedule\Domain\Groups\Action;

use BSchedule\App\Client\Google\Action\SetupGoogleClientAction;
use BSchedule\App\Client\HTTP\Action\GetGroupIDsAction;
use Google_Service_Oauth2;

class GetGroupsAction
{
    public function handle(): array
    {
        session_start();

        $client = (new SetupGoogleClientAction())->getOauthClient();
        $client->setAccessToken($_SESSION['access_token']);

        if ($client->isAccessTokenExpired())
        {
            header('Location: '.getenv('DOMAIN').'/auth/auth.php' );
            exit();
        }

        $service = new Google_Service_Oauth2($client);
        $email = ($service->userinfo->get())->getEmail();

        $allGroups = json_decode(file_get_contents(getenv('PROJECT_ROOT').'/service/data/groups.json'), true);
        $userGroups = $allGroups[$email];

        return (new GetGroupIDsAction())->handle($userGroups);
    }
}