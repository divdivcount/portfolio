<?php
/*
FileName: sign-pwchange.php
Modified Date: 20190925
Description: 로그인 비밀번호 변경
*/

// Load Modules
require_once('modules/error.php');
require_once('modules/notification.php');
require_once('modules/db.php');
require_once("modules/admin.php");

// Parameter
$old = Post('old', null);
$new = Post('new', null);
$newre = Post('newre', null);

// Functions

// Process
if(!$old || !$new || !$newre) {
  userGoto('모든 입력란을 입력하십시오.', '');
}
if($new != $newre) {
  userGoto('비밀번호 변경 실패', '');
}
$loginObj = new YoYangLogin($DBconfig['dburl'], $DBconfig['dbid'], $DBconfig['dbpw'], $DBconfig['dbtable'], $DBconfig['dbtype']);
if($loginObj->PasswordChange($old, $new)) {
  userGoto('변경되었습니다.', '/board_list.php');
}
else {
  userGoto('비밀번호 변경 실패', '');
}

?>
