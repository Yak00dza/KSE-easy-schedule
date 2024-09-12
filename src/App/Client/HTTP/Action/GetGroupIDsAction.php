<?php

namespace BSchedule\App\Client\HTTP\Action;

class GetGroupIDsAction
{
    public function handle(array $textGroups): array
    {
        $ids = [];

        $groupIDs = json_decode(file_get_contents(getenv('PROJECT_ROOT').'/service/data/group_ids.json'), true);
        foreach($textGroups as $group) {
            if (isset($groupIDs[$group])) {
                $ids[] = $groupIDs[$group];
            } else {
                $id = $this->requestGroupId($group);
                if ($id != -1) {
                    $groupIDs[$group] = $id;
                    $ids[] = $id;
                }
            }
        }

        file_put_contents(getenv('PROJECT_ROOT').'/service/data/group_ids.json', json_encode($groupIDs));
        return $ids;
    }

    private function requestGroupId(string $group): int
    {
        $url = 'https://schedule.kse.ua/index/groups?term='.urlencode($group);
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPGET, true);

        $response = json_decode(curl_exec($ch), true)['result'];
        if (!isset($response[0])) {
            return -1;
        }
        return $response[0]['id'];
    }

}