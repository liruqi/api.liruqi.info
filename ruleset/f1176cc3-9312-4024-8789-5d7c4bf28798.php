<?php
$json = array("id"=> "f1176cc3-9312-4024-8789-5d7c4bf28798", "enabled"=> true, "updated_at"=> "2016-06-14T14:46:32",
  "rules"=> [array("action"=> "PROXY", "pattern"=> "CN", "type"=> "GEOIP", "order"=> "0"), array("action"=> "PROXY", "pattern"=> ".cn", "type"=> "URL", "order"=> "0")],
  "created_at"=> "2016-06-14T14:46:32", "is_official"=> true, "name"=> "中国地区走代理", "description"=> "用于国外翻回中国");

if (strpos($_SERVER['REQUEST_URI'], $json["id"]) !== FALSE)
    echo json_encode( $json);
