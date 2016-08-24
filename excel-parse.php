<?php

$name = "test-25.xls";
if (isset($_SERVER["REMOTE_ADDR"])) {
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
<title>api.liruqi.info</title>
<meta charset="UTF-8">
</head>
<body>
<?php

    echo $_SERVER["REMOTE_ADDR"] . "<br/>";
    if ($_GET['name']) $name = $_GET['name']; 
} else {
    if (count($argv) > 1) $name = $argv[1];
}

require_once 'vendor/PHPExcel-1.8.1/Classes/PHPExcel.php';

        $root =  dirname(__FILE__);
        $importFile = $root . "/uploads/" . $name;
        $objDateTime = new DateTime('NOW'); 
        
        $yes = array(); $no = array(); $cnt=0; $ignore = array();

        $nsImportFields = array('id', 'title', 'C', 'D', 'brand');

        $objPHPExcel =  PHPExcel_IOFactory::load($importFile);
        //$objPHPExcel->setReadDataOnly(TRUE);
        $objWorksheet = $objPHPExcel->getActiveSheet();
        echo 'Import file: ' . $importFile . PHP_EOL;
        foreach ($objWorksheet->getRowIterator() as $row) {
            $cnt += 1;
            if ($cnt <=1 ) continue; // skip table head

            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(FALSE); 
            $nsUser = array();
            
            $index = 0;
            foreach ($cellIterator as $cell) {
                $val = "";
                if (array_key_exists($index, $nsImportFields)) {
                    $val = $cell->getValue();
                    
                    $nsUser[$nsImportFields[$index]] = $val;
                    $index += 1;
                } 
            }
            
            if (empty ($nsUser['id'])) break;
            
            echo $nsUser['id'] . PHP_EOL;
            if (strpos($nsUser['title'], $nsUser['brand'])===0) {
                $yes [] = $nsUser;
                $suffix = substr($nsUser['title'], strlen($nsUser['brand']));
                $fgh = explode(" ", $suffix);
                $f = $fgh[0];
                $objPHPExcel->getActiveSheet()->setCellValue('F' . $cnt, $f);
                if (isset($fgh[1])) {
                    list($g, $h) = sscanf($fgh[1], "%d%s");
                    $objPHPExcel->getActiveSheet()->setCellValue('G' . $cnt, $g);
                    $objPHPExcel->getActiveSheet()->setCellValue('H' . $cnt, $h);
                } 
                echo json_encode($nsUser) . PHP_EOL;
            } else {
                echo ($nsUser['title'] . " " .  $nsUser['brand']. PHP_EOL);
            }
        }
        echo "<p>导入成功" . count($yes) . ", 失败" . count($no) . ", 忽略(无变更)" . count($ignore) . "</p>";
        echo "<p>导入成功: " . implode(', ', $yes) . "</p>";
        echo "<p>导入失败: " . implode(', ', $no) . "</p>";
        echo "<p>无变更: " . implode(', ', $ignore) . "</p>";

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save($root . "/uploads/" . time() . $name . ".xlsx");

