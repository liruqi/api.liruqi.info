<?php
require 'vendor/autoload.php';
use GeoIp2\Database\Reader;

$names = array();
$names['f1176cc3-9312-4024-8789-5d7c4bf28797'] = 1;

$mmdbReader = new Reader('/srv/http/106.187.88.85/vpn/GeoLite2-City_20170606/GeoLite2-City.mmdb');
$record = $mmdbReader->city($_SERVER['REMOTE_ADDR']);
if ($record->country->isoCode === 'CN') {
    $names['f1176cc3-9312-4024-8789-5d7c4bf28798'] = 1;
}

$rulesetdir =  dirname(__FILE__) . "/ruleset";
$files = array_diff(scandir($rulesetdir), ['.', '..']);

$jsonArray = [];
foreach($files as $key => $name) {
    $uuid = explode(".", $name)[0];
    if (isset($names[$uuid])) continue;
    if (explode(".", $name)[1] == "json") {
        $names[$uuid] = 1;
        $jsonArray[] = json_decode( file_get_contents($rulesetdir . "/" . $name), true);
    } else if (explode(".", $name)[1] == "php"){
        $names[$uuid] = 1;
        include $rulesetdir . "/" . $name;
        if (empty($json)) {
            continue;
        }
        if (count($json) < 5) {
            continue;
        }
        $jsonArray[] = $json;
    }
}

echo json_encode($jsonArray);
