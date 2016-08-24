<?php
if ($_GET['https'] > 0) {
    echo json_encode( array(
"https://gg.kfd.me",
"https://gg.wen.lu",
"https://www.sslpxy.com",
) ); 
} else {
    echo json_encode( array(
"http://bing.com/",
"http://www.gufen138.com",
"http://www.wanzi138.com",
"http://hk.wangyan.org",
"https://gg.kfd.me",
"https://gg.wen.lu",
"https://www.sslpxy.com",
) );
}
