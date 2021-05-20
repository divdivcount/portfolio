<?php
$subwayPath = array(
  'apiKey' => 'TZYw9wdykk0/zkQcoi3NneOKk52BOQvMmmOPDezQjIU',
  'CID' => '1000',
  'SID' => isset($_POST["departure_stationID"]) ?$_POST["departure_stationID"] : null,
  'EID' => isset($_POST["arrival_stationID"]) ?$_POST["arrival_stationID"] : null,
  'Sopt' => '1'
);
$return_stationTime_array =array();
$url = "https://api.odsay.com/v1/api/subwayPath" . "?" . http_build_query($subwayPath, '');

$ch = curl_init();                                 //curl 초기화
curl_setopt($ch, CURLOPT_URL, $url);               //URL 지정하기
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);    //요청 결과를 문자열로 반환
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);      //connection timeout 10초
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);   //원격 서버의 인증서가 유효한지 검사 안함
curl_setopt($ch, CURLOPT_VERBOSE, true);

$response = curl_exec($ch);
curl_close($ch);


if (isset($_POST["departure_stationID"]) && isset($_POST["arrival_stationID"])) {
  $response_result=json_decode($response,true);
  // print_r($response_result);
  //삽질하는 그대에게 이게 맞는가 편지를 씁니다.. 왜 아까 했을때 안됐을까요?
  echo $response_result['result']['globalTravelTime'];
  // if (is_array($response_result["result"])) {
  //   print_r($response_result["result"]["globalStartName"]);
  // }

  // foreach ($response_result["result"] as  $value) {
  //   $return_stationTime_array = $value["globalStartName"];
  // }
  // echo $return_stationTime_array;
  //var_dump( json_encode($return_stationTime_array, JSON_UNESCAPED_UNICODE));
  // echo $response_result["result"]["globalTravelTime"];
  // echo $response_result['result'] -> 'globalStartName';
}else {
  // code...
}

?>
