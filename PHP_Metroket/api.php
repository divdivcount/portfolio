<?php
$ch = curl_init();
$url = 'http://openapi.tago.go.kr/openapi/service/MetroRtInfoService/getMetroLineInfoList'; /*URL*/
$queryParams = '?' . urlencode('ServiceKey') . ''; /*Service Key*/
$queryParams .= '&' . urlencode('cityCd') . '=' . urlencode('BS'); /**/
$queryParams .= '&' . urlencode('lineNo') . '=' . urlencode('2'); /**/
$queryParams .= '&' . urlencode('dirCd') . '=' . urlencode('1'); /**/

curl_setopt($ch, CURLOPT_URL, $url . $queryParams);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_HEADER, FALSE);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
$response = curl_exec($ch);
curl_close($ch);

var_dump($response);
?>
