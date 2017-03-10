<?php
$port = 9008;
$dhost = "";
$dport = 8080;
if (intval($_GET['port']) > 0) {
    $port = $_GET['port']; 
}
if (intval($_GET['dh']) > 0) {
    $dhost = $_GET['dh']; 
}
if (intval($_GET['dp']) > 0) {
    $dport = $_GET['dp']; 
}
$direct = "DIRECT;";
if (strlen($dhost) > 8) {
    $direct = "PROXY {$dhost}:{$dport};"; 
}
?>

var domains = {
  "nytimes.com": 1, 
  "mobile.guardianapis.com": 1, 
  "co.uk": 1, 
};

var proxy = "PROXY 127.0.0.1:<?php echo $port; ?>;";

var direct = "<?php echo $direct; ?>";

function FindProxyForURL(url, host) {
    var suffix;
    var pos = host.lastIndexOf('.');
    pos = host.lastIndexOf('.', pos - 1);
    while(1) {
        if (pos <= 0) {
            if (hasOwnProperty.call(domains, host)) {
                return proxy;
            } else {
                return direct;
            }
        }
        suffix = host.substring(pos + 1);
        if (hasOwnProperty.call(domains, suffix)) {
            return proxy;
        }
        pos = host.lastIndexOf('.', pos - 1);
    }
}

