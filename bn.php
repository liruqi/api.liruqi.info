<?php
$port = 8080;

if (intval($_GET['port']) > 0) {
    $port = $_GET['port']; 
}
?>

var domains = {
  "nytimes.com": 1, 
  "mobile.guardianapis.com": 1, 
  "co.uk": 1, 
};

var proxy = "PROXY 127.0.0.1:<?php echo $port; ?>;";

var direct = 'DIRECT;';

function FindProxyForURL(url, host) {
    var lastPos = 0;
    var domain = host;
    while(url.startsWith("https") && lastPos >= 0) {
        if (domains[domain]) {
            return proxy;
        }
        lastPos = host.indexOf('.', lastPos + 1);
        domain = host.slice(lastPos + 1);
    }
    return direct;
}
