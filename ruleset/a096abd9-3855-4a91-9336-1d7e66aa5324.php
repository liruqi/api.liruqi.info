<?php
$basedir = dirname(dirname(__FILE__)) . "/";
$jsonstr = file_get_contents($basedir . "ruleset/a096abd9-3855-4a91-9336-1d7e66aa5323.mume");
$json = json_decode($jsonstr, true);

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
$json['name'] = '中国地区广告屏蔽';
if (!isset($_SERVER['REQUEST_URI']) || strpos($_SERVER['REQUEST_URI'], $json["id"]) !== FALSE) 
    echo json_encode($json);
