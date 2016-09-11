<?php
$rulesetdir =  dirname(__FILE__) . "/ruleset";
$files = array_diff(scandir($rulesetdir), ['.', '..']);

$jsonArray = [];
foreach($files as $key => $name) {
    if (explode(".", $name)[1] == "json") {
        $jsonArray[] = json_decode( file_get_contents($rulesetdir . "/" . $name), true);
    } else if (explode(".", $name)[1] == "php"){
        include $rulesetdir . "/" . $name;
        $jsonArray[] = $json;
    }
}

echo json_encode($jsonArray);
