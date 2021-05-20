<?php
  $station = array(
    'apiKey' => 'TZYw9wdykk0/zkQcoi3NneOKk52BOQvMmmOPDezQjIU',
    'stationName' => isset($_POST["station"]) ?$_POST["station"] : null,
    'CID' => '1000',
    'stationClass' => '2',
  );
  $return_stationID_array = array();
  $return_stationLine_array =array();

  $return_result= isset($_POST["return_result"]) ?$_POST["return_result"] : null;
  // 출발역 정보 검색
  if (isset($_POST["station"])) {
    // code...

    $url = "https://api.odsay.com/v1/api/searchStation" . "?" . http_build_query($station, '', );

    $ch = curl_init();                                 //curl 초기화
    curl_setopt($ch, CURLOPT_URL, $url);               //URL 지정하기
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);    //요청 결과를 문자열로 반환
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);      //connection timeout 10초
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);   //원격 서버의 인증서가 유효한지 검사 안함
    curl_setopt($ch, CURLOPT_VERBOSE, true);

    $response = curl_exec($ch);
    curl_close($ch);

    $response_result=json_decode($response,true);
    if ($return_result == "s_num") {
      foreach ($response_result['result']['station'] as  $value) {
        $return_stationID_array[] = $value["stationID"];
      }
    }else{
      for ($i=0; $i < count($response_result['result']['station']); $i++) {
        $return_stationID_array["stationName"][$i] = $response_result['result']['station'][$i]["laneName"]. ":" .$response_result['result']['station'][$i]["stationName"];
        $return_stationID_array["stationID"][$i] = $response_result['result']['station'][$i]["stationID"];
      }
      // foreach ($response_result['result']['station'] as  $value) {
      //   $return_stationID_array["station"]["name"] = $value["laneName"]. ":" .$value["stationName"];
      //   $return_stationID_array["station"]["stationID"] = $value["stationID"];
      //   // $return_stationLine_array[] = $value["laneName"]+;
      // }
    }

    echo json_encode($return_stationID_array, JSON_UNESCAPED_UNICODE);
    // echo json_encode($return_stationLine_array, JSON_UNESCAPED_UNICODE);
  }
?>
