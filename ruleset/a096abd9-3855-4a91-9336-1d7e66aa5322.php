<?php
$basedir = dirname(dirname(__FILE__));
$json = array("is_official" => True, "description"=>"避免影响国内站点访问速度");
$json['id'] = 'a096abd9-3855-4a91-9336-1d7e66aa5322';
$od = "0";

$GFW = fopen(dirname($basedir) . "/mume.red/etc/gfw.m16","r");
if($GFW) {
    while(!feof($GFW)) {
        $line = trim(fgets($GFW));
        $arr = explode(".", $line);
        if (count($arr) != 2) break;
        $json["rules"][] = array('action'=>'PROXY', 'pattern'=>$line . '.0.0/16', 'type'=>'IP-CIDR', 'order' => $od);
    }
    fclose($GFW);
}

$od = "1";
$DIRECT = fopen(dirname($basedir) . "/mume.red/etc/cn30.m8","r");
if($DIRECT) {
    while(!feof($DIRECT)) {
        $line = trim(fgets($DIRECT));
        $arr = explode(".", $line);
        if (count($arr) != 2) break;
        $json["rules"][] = array('action'=>'DIRECT', 'pattern'=>$line . '0.0.0/8', 'type'=>'IP-CIDR', 'order' => $od);
    }
    fclose($DIRECT);
}

$od = "2";
$json["rules"][] = array('action'=>'DIRECT', 'pattern'=>'.cn', 'type'=>'URL', 'order' => '2');
$json["rules"][] = array('action'=>'DIRECT', 'pattern'=>'.qq.com', 'type'=>'URL', 'order' => '2');
$json["rules"][] = array('action'=>'DIRECT', 'pattern'=>'.baidu.com', 'type'=>'URL', 'order' => '2');
$json["rules"][] = array('action'=>'DIRECT', 'pattern'=>'captive.apple.com', 'type'=>'DOMAIN-SUFFIX', 'order' => '2');
$json["rules"][] = array('action'=>'DIRECT', 'pattern'=>'icloud.com', 'type'=>'DOMAIN-SUFFIX', 'order' => '2');
$json['name'] = '中国地区直连';

if ($_GET['q'] != $json['id']) {
if (!isset($_SERVER['REQUEST_URI']) || strpos($_SERVER['REQUEST_URI'], $json["id"]) !== FALSE) 
    echo json_encode($json, JSON_PRETTY_PRINT);
}
