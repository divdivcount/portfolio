<?php
// Load Modules
require_once("modules/notification.php");
require_once("modules/db.php");

// Parameter
$name = Post('name', null);
$email = Post('email', null);
$content = Post('content', null);
$mb_num = Post('mb_num', null);
// Functions

// Process
try {
  if($name && $email && $content) {
    $consultObj = new Consulting();
    $consultObj->Upload('','', 0, ['email'=>$email, 'name'=>$name, 'content'=>$content, 'mb_num'=>$mb_num]);
  }
  else {
    userGoto('모든 입력란을 작성하세요.', '');
  }
} catch (Exception $e) {
  echo $e->getMessage();
  exit();
}
userGoto('접수가 완료되었습니다. 빠른 시일 내에 입력하신 전화번호로 연락드리겠습니다.', './User_consulting_user.php');
?>
