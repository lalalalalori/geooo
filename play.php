<?php

header("Content-Type: application/vnd.apple.mpegurl");
header("Connection: keep-alive");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Expose-Headers: Content-Length,Content-Range");
header("Access-Control-Allow-Headers: Range");
header("Accept-Ranges: bytes");
date_default_timezone_set('Asia/Kolkata');

$jctBase = "cutibeau2ic";

$ssoToken = "testing";

function tokformat($str)
{
$str= base64_encode(md5($str,true));

return str_replace("\n","",str_replace("\r","",str_replace("/","_",str_replace("+","-",str_replace("=","",$str)))));

}


function generateJct($st, $pxe) 
{
 global $jctBase;
 return trim(tokformat($jctBase . $st . $pxe));
}

function generatePxe() {
return time() + 800;
}

function generateSt() {
global $ssoToken;
return tokformat($ssoToken);
}

function generateToken() {
$st = generateSt();
$pxe = generatePxe();
$jct = generateJct($st, $pxe);

return "?jct=" . $jct . "&pxe=" . $pxe . "&st=" . $st;
}

$p= generateToken();

$opts = [
    "http" => [
        "method" => "GET",
        "header" => "User-Agent: jiotv \r\n" 
    ]
];

$quality = $_GET["q"];
if($quality == "800") {
	$q = "800";
} else {
	$q = $quality;
}

$cx = stream_context_create($opts);
$hs = file_get_contents("https://jiotvweb.cdn.jio.com/jiotv.live.cdn.jio.com/" . $_GET["c"] . "/" . $_GET["c"] . "_" . $q . ".m3u8" .  $p,false,$cx);

$hs= @preg_replace("/" . $_GET["c"] . "_" . $q ."-([^.]+\.)key/", 'key.php?key='  . $_GET["c"] . '/' .   $_GET["c"] . '_' . $q . '-$1key' , $hs);
$hs= @preg_replace("/" . $_GET["c"] . "_" . $q ."-([^.]+\.)ts/", "https://jiotvweb.cdn.jio.com/jiotv.live.cdn.jio.com/"  . $_GET["c"] . '/' .   $_GET["c"] . '_' . $q . '-$1ts', $hs);

$hs=str_replace("https://tv.media.jio.com/streams_live/" .  $_GET["c"] . "/","",$hs);


echo $hs;



?>