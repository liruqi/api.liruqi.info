<?php
if (($_GET['build'] !== '203' && $_GET['appstore'] === '1') || $_SERVER['DOCUMENT_URI'] === '/import.php') {
    $basedir = dirname(dirname(__FILE__)) . "/";
    $jsonstr = file_get_contents($basedir . "ruleset/a096abd9-3855-4a91-9336-1d7e66aa5323.mume");
    $json = json_decode($jsonstr, true);
    $json['id'] = 'a096abd9-3855-4a91-9336-1d7e66aa5323';
    $REJECT = fopen($basedir . "data/h2y_ads.txt","r");
    if($REJECT) {
        while(!feof($REJECT)) {
            $line = trim(fgets($REJECT));
            $arr = explode(",", $line);
            if (count($arr) != 1) break;
            $json["rules"][] = array('action'=>'REJECT', 'pattern'=>$arr[0], 'type'=>'DOMAIN-SUFFIX', 'order' => '0');
        }
        fclose($REJECT);
    }

    if ($country==='CN') {
        $json['name'] = '阻止广告类的网络请求';
        $json['description'] = '拦截部分网页广告';
    } else {
        $json['name'] = 'Block Ads traffic';
        $json['description'] = 'Block some website ads';
    }
    if (!isset($_SERVER['REQUEST_URI'])) 
        echo json_encode($json, JSON_PRETTY_PRINT);
}
