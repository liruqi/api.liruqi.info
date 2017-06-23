<?php
$basedir = dirname(dirname(__FILE__)) . "/";
$json = array("is_official" => True, "description"=>"屏蔽Google广告");
$json['id'] = 'a096abd9-3855-4a91-9336-1d7e66aa5324';

$DIRECT = fopen($basedir . "data/lhie1_google_ads.txt","r");
if($DIRECT) {
    while(!feof($DIRECT)) {
        $line = trim(fgets($DIRECT));
        $arr = explode(",", $line);
        if (count($arr) != 2) break;
        $json["rules"][] = array('action'=>'REJECT', 'pattern'=>$arr[1], 'type'=>$arr[0], 'order' => '0');
    }
    fclose($DIRECT);
}
$json['name'] = 'Google广告屏蔽';
if (!isset($_SERVER['REQUEST_URI']) || strpos($_SERVER['REQUEST_URI'], $json["id"]) !== FALSE) 
    echo json_encode($json, JSON_PRETTY_PRINT);
