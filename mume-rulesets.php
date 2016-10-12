<?php
$names = array();
$names['f1176cc3-9312-4024-8789-5d7c4bf28797'] = 1;
$rulesetdir =  dirname(__FILE__) . "/ruleset";
$files = array_diff(scandir($rulesetdir), ['.', '..']);

$jsonArray = [];
foreach($files as $key => $name) {
    $uuid = explode(".", $name)[0];
    if (isset($names[$uuid])) continue;
    $names[$uuid] = 1;
    if (explode(".", $name)[1] == "json") {
        $jsonArray[] = json_decode( file_get_contents($rulesetdir . "/" . $name), true);
    } else if (explode(".", $name)[1] == "php"){
        include $rulesetdir . "/" . $name;
        $jsonArray[] = $json;
    }
}

echo json_encode($jsonArray);
