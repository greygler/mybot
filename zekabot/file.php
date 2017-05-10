<?
$json=file_get_contents('https://api.vk.com/method/groups.getMembers?group_id=levchuktya', false);
$data=json_decode($json, true);
foreach ($data['response']['users'] as $key => $value) echo ("{$key} = {$value}<br>");
print_r($json);
