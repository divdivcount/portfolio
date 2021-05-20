<?php
$ch = curl_init();
$url = 'http://openapi.tago.go.kr/openapi/service/MetroRtInfoService/getMetroLineInfoList'; /*URL*/
$queryParams = '?' . urlencode('ServiceKey') . 'a1Mb14Z%2FrXV%2FkrLBy3t31nY2CzHJ%2B8ufVJEQN%2Fy4srUAN%2FHX%2FJY4rp%2FJAJxuZJU384i4P0Z1OZI338Pcts%2FFmg%3D%3D'; /*Service Key*/
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
