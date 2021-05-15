<?php
/*
FileName: consulting_upload.php
Modified Date: 20190906
Description: 상담 등록
*/
// Load Modules
require_once("modules/error.php");
require_once("modules/notification.php");
require_once("modules/db.php");

// Parameter
$name = Post('name', null);
$phone = Post('phone', null);
$content = Post('content', null);

// Functions
$pattern = '/^[가-힣]{3,}$/';

        function send($name,$phone,$content){
		$data = array(
			'username'=> "상담봇",
			'content'=>"||{$name}||님께서 상담 요청을 하셨습니다.",
		);
		$json_data = json_encode($data);
		$url = "https://discord.com/api/webhooks/817751435269505035/EUHSL-HsOs96PxCvxhhS1CLdTFsM_WAOI8d-mC6r9k9S8aD_MvYCGCaTVjrSO7kcWboL";
		$ch = curl_init();                                 //curl 초기화
		curl_setopt($ch, CURLOPT_URL, $url);               //URL 지정하기
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);    //요청 결과를 문자열로 반환
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);      //connection timeout 10초
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);   //원격 서버의 인증서가 유효한지 검사 안함
		curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);       //POST data
		curl_setopt($ch, CURLOPT_POST, true);              //true시 post 전송
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json', 'Content-Type: application/json'));
		$response = curl_exec($ch);
		curl_close($ch);

	}


// Process


try {
  if($name && $phone && $content) {
    $consultObj = new YoYangConsulting($DBconfig['dburl'], $DBconfig['dbid'], $DBconfig['dbpw'], $DBconfig['dbtable'], $DBconfig['dbtype']);
    if(strlen($phone) != 11){
      userGoto('전화번호를 다시 한번 확인해주세요.', '');
    }
    if (preg_match($pattern, $name, $macheResult)) {
    } else {
      userGoto($name.'은(는) 적합하지 않은 이름입니다.', '');
    }

    $consultObj->Upload('', 0, ['phone'=>$phone, 'name'=>$name, 'content'=>$content]);
    send($name,$phone,$content);
  }
  else {
    userGoto('모든 입력란을 작성하세요.', '');
  }
} catch (Exception $e) {
  echo $e->getMessage();
  exit();
}
userGoto('접수가 완료되었습니다. 빠른 시일 내에 입력하신 전화번호로 연락드리겠습니다.', '/sub.php?p=4');
?>
