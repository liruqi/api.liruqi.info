<?php
$basedir = dirname(dirname(__FILE__)) . "/";
$jsonstr = file_get_contents($basedir . "ruleset/833fb590-f3d2-419f-9b64-e4879f2ed5a3.mume");
$json = json_decode($jsonstr, true);
$REJECT = fopen($basedir . "data/lhie1_proxy.txt","r");
if($REJECT) {
    while(!feof($REJECT)) {
        $line = trim(fgets($REJECT));
        $arr = explode(",", $line);
        if (count($arr) != 2) break;
        $json["rules"][] = array('action'=>'PROXY', 'pattern'=>$arr[1], 'type'=>$arr[0], 'order' => '0');
    }
    fclose($REJECT);
}

if (substr($_GET['lang'], 0, 2) == 'zh') {
    $json['name'] = '代理被屏蔽的站点';
    $json['description'] = '代理被屏蔽的大部分常用站点';
}
if (!isset($_SERVER['REQUEST_URI']) || strpos($_SERVER['REQUEST_URI'], $json["id"]) !== FALSE) 
    echo json_encode($json, JSON_PRETTY_PRINT);
