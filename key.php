<?php
//header("Content-Type: application/octet-stream");
header("Connection: keep-alive");

$jctBase = "cutibeau2ic";

$ssoToken = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1bmlxdWUiOiI5YWZkNWY3Ny02ZGRmLTQxMjktOGQyNy02ODBmZmZhNzg1MjEiLCJ1c2VyVHlwZSI6IlJJTHBlcnNvbiIsImF1dGhMZXZlbCI6IjQwIiwiZGV2aWNlSWQiOiJkNzJmNDdmZjRjMWVjMjdjYjBjNjVjNDNiMzM1ODY4YzI3YzA0NGFjNmEzMDJjMzBjODNiY2JiZmRmM2VlNDBmNWI3YWJlNzRjYWVkMTM0OWU4YjQzOTQ4MTgxMTAwZTQzNjRhOTUxYWI1ZGFlMjYwMzk5NzdkODNmMjAzOTM1NCIsImp0aSI6ImQ1OWI4MTQ3LTdiMzUtNGQzZi1iNDI4LTE2NThiODdhNzdhOSIsImlhdCI6MTYzNzM0NjUwNX0.wvt9OUj7vueNa5EStFHylK6II0B95zLW4_quNl_ooiU"; 
$uid = "9afd5f77-6ddf-4129-8d27-680fffa78521"; 
$crm = "7075872813"; 

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

$url="https://tv.media.jio.com/streams_live/"  . $_GET["key"] . $p;

$ch = curl_init();
curl_setopt ($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
   'deviceId: 8856c00cd7ce497a','crmid: ' . $crm,'usergroup: tvYR7NSNn7rymo3F','versionCode: 226','userId: ril7062436625','appkey: NzNiMDhlYzQyNjJm','uniqueId: '  . $uid,'devicetype: phone','os: android','srno: 191202011043','osVersion: 6.0','subscriberId: '  . $crm,'channelid: 125','lbcookie: 1','ssotoken: ' . $ssoToken,'User-Agent: jiotv \r\n'));

curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch,CURLOPT_USERAGENT,'jiotv \r\n');
$contents = curl_exec($ch);
if (curl_errno($ch)) {
   $contents = '';
} else {
  curl_close($ch);
}

echo $contents;

?>