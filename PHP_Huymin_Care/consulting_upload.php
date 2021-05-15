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

// Process
try {
  if($name && $phone && $content) {
    $consultObj = new YoYangConsulting($DBconfig['dburl'], $DBconfig['dbid'], $DBconfig['dbpw'], $DBconfig['dbtable'], $DBconfig['dbtype']);
    $consultObj->Upload('', 0, ['phone'=>$phone, 'name'=>$name, 'content'=>$content]);
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
