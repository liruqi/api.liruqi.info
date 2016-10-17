<?php
$basedir = dirname(dirname(__FILE__)) . "/";
$jsonstr = file_get_contents($basedir . "ruleset/a096abd9-3855-4a91-9336-1d7e66aa5323.mume");
$json = json_decode($jsonstr, true);
$json['id'] = 'a096abd9-3855-4a91-9336-1d7e66aa5323';
$REJECT = fopen($basedir . "data/CN-ADS","r");
if($REJECT) {
    while(!feof($REJECT)) {
        $line = trim(fgets($REJECT));
        $arr = explode(",", $line);
        if (count($arr) != 2) break;
        $json["rules"][] = array('action'=>'REJECT', 'pattern'=>$arr[1], 'type'=>$arr[0], 'order' => '0');
    }
    fclose($REJECT);
}

$DIRECT = fopen($basedir . "data/DIRECT","r");
if($DIRECT) {
    while(!feof($DIRECT)) {
        $line = trim(fgets($DIRECT));
        $arr = explode(",", $line);
        if (count($arr) != 2) break;
        $json["rules"][] = array('action'=>'DIRECT', 'pattern'=>$arr[1], 'type'=>$arr[0], 'order' => '0');
    }
    fclose($REJECT);
}
$json["rules"][] = array('action'=>'DIRECT', 'pattern'=>'CN', 'type'=>'GEOIP', 'order' => '0');
$json["rules"][] = array('action'=>'DIRECT', 'pattern'=>'.cn', 'type'=>'URL', 'order' => '0');
$json['name'] = '中国地区广告屏蔽后直连';
if (!isset($_SERVER['REQUEST_URI']) || strpos($_SERVER['REQUEST_URI'], $json["id"]) !== FALSE) 
    echo json_encode($json, JSON_PRETTY_PRINT);
