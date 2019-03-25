<?php
$filenames = ['../mume.red/mmhk.php', '../mumevpm.com/mmhk.php'];
foreach($filenames as $k => $filename) {
    if (file_exists($filename)) {
        include_once $filename;
        break;
    }
}

$jsonArray = [];

if (empty($country)) {
    $langs = explode('-', $_GET['lang']);
    $can = end($langs); 
    if (strlen($can) === 2) {
        $country = $can;
    }
}

// require 'vendor/autoload.php';
// use GeoIp2\Database\Reader;

$names = array();
$names['f1176cc3-9312-4024-8789-5d7c4bf28797'] = 1;

if ($_GET['build'] >= 83 && $_GET['appstore']=='1') {
    $names['a096abd9-3855-4a91-9336-1d7e66aa5324'] = 1;

    echo json_encode($jsonArray);
    exit();
}

// $mmdbReader = new Reader('/srv/http/106.187.88.85/vpn/GeoLite2-City_20170606/GeoLite2-City.mmdb');
// $record = $mmdbReader->city($_SERVER['REMOTE_ADDR']);
if ($country === 'CN' || !empty($corpIP) 
    || $userIP == $proxyIP['hk5']
    || $userIP == $proxyIP['hk4']
    || $userIP == $proxyIP['us0.mume.red']
    ) {
    $names['f1176cc3-9312-4024-8789-5d7c4bf28798'] = 1;
} else {
    $names['833fb590-f3d2-419f-9b64-e4879f2ed5a3'] = 1; //proxy rules
}

$rulesetdir = dirname(__FILE__) . "/ruleset";
$files = array_diff(scandir($rulesetdir), ['.', '..']);

foreach($files as $key => $name) {
    $uuid = explode(".", $name)[0];
    if (isset($names[$uuid])) continue;
    if (explode(".", $name)[1] == "json") {
        $names[$uuid] = 1;
        $jsonArray[] = json_decode( file_get_contents($rulesetdir . "/" . $name), true);
    } else if (explode(".", $name)[1] == "php"){
        $names[$uuid] = 1;
        include_once $rulesetdir . "/" . $name;
        if (empty($json)) {
            continue;
        }
        if (count($json) < 5) {
            continue;
        }
        $jsonArray[] = $json;
        $json = [];
    }
}

echo json_encode($jsonArray);
