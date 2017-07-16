<?php

if (($_GET['version']==='1.7.4' || $_GET['version']==='1.0') && $_GET['lang']==='zh-Hans-CN') {
    $basedir = dirname(dirname(__FILE__)) . "/";
    $jsonstr = file_get_contents($basedir . "ruleset/a096abd9-3855-4a91-9336-1d7e66aa5323.mume");
    $json = json_decode($jsonstr, true);
    $json['id'] = 'a096abd9-3855-4a91-9336-1d7e66aa5323';
    $REJECT = fopen($basedir . "data/lhie1_cn_ads.txt","r");
    if($REJECT) {
        while(!feof($REJECT)) {
            $line = trim(fgets($REJECT));
            $arr = explode(",", $line);
            if (count($arr) != 2) break;
            $json["rules"][] = array('action'=>'REJECT', 'pattern'=>$arr[1], 'type'=>$arr[0], 'order' => '0');
        }
        fclose($REJECT);
    }

    $json['name'] = '阻止无用的网络请求';
    if (!isset($_SERVER['REQUEST_URI']) || strpos($_SERVER['REQUEST_URI'], $json["id"]) !== FALSE) 
        echo json_encode($json, JSON_PRETTY_PRINT);
}
