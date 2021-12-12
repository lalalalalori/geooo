<?php
//http://localhost/jio/jio_fetcher.php?u=&p=  // link format
$u = $_GET['u'];
if(strpos($u, "@") !== false) {
$user = $u;
} else {
$user = "+91".$u;
}
$p = $_GET['p'];
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://api.jio.com/v3/dip/user/unpw/verify",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS =>"{\n  \"identifier\": \"ayushmanbbk@gmail.com\",\n  \"password\": \"ayushnlove17\",\n  \"rememberUser\": \"T\",\n  \"upgradeAuth\": \"Y\",\n  \"returnSessionDetails\": \"T\",\n  \"deviceInfo\": {\n    \"consumptionDeviceName\": \"Xiaomi POCO F1\",\n    \"info\": {\n      \"type\": \"android\",\n      \"platform\": {\n        \"name\": \"beryllium\",\n        \"version\": \"9\"\n      },\n      \"androidId\": \"1108b7f7a2646ggb\"\n    }\n  }\n}",
  CURLOPT_HTTPHEADER => array(
    "Content-Type: application/json",
    "x-api-key: l7xx938b6684ee9e4bbe8831a9a682b8e19f"
  ),
));

$result = curl_exec($curl);
curl_close($curl);

//echo $result;
$j=json_decode($result,true);
echo var_dump($j);
$k= $j["ssoToken"];
$crm= $j["sessionAttributes"]["user"]["subscriberId"];
$u= $j["sessionAttributes"]["user"]["unique"];

file_put_contents("tok.txt",$k);
file_put_contents("crm.txt",$crm);
file_put_contents("uid.txt",$u);

?>