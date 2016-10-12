<?php
$basedir = dirname(dirname(__FILE__)) . "/";
$jsonstr = file_get_contents($basedir . "ruleset/a096abd9-3855-4a91-9336-1d7e66aa5323.mume");
$json = json_decode($jsonstr, true);

$REJECT = fopen($basedir . "data/CN-ADS","r");
$ads = "";
if($REJECT) {
    while(!feof($REJECT)) {
        $line = trim(fgets($REJECT));
        $arr = explode(",", $line);
        if (count($arr) != 2) break;
        $json["rules"][] = array('action'=>'REJECT', 'pattern'=>$arr[1], 'type'=>$arr[0], 'order' => '0');
        
        $url = "http" . $arr[1];
        $ch = curl_init(); 
            curl_setopt($ch, CURLOPT_URL, $url); 
            curl_setopt($ch, CURLOPT_HEADER, TRUE); 
            curl_setopt($ch, CURLOPT_NOBODY, TRUE); // remove body 
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); 
            $head = curl_exec($ch); 
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE); 
            curl_close($ch); 
        print ($arr[1] . " ");
        var_dump ($head);
        print ($httpCode);
        if ($head) {
            $ads = $ads . $line . "\n";
        }
    }
    fclose($REJECT);
}

$json["rules"][] = array('action'=>'DIRECT', 'pattern'=>'CN', 'type'=>'GEOIP', 'order' => '0');
$json["rules"][] = array('action'=>'DIRECT', 'pattern'=>'.cn', 'type'=>'URL', 'order' => '0');
$json['name'] = '中国地区广告屏蔽后直连';
if (!isset($_SERVER['REQUEST_URI']) || strpos($_SERVER['REQUEST_URI'], $json["id"]) !== FALSE) 
    echo json_encode($json['rules'], JSON_PRETTY_PRINT);

print $ads;
