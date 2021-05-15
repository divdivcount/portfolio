<?php
// Load Modules
require_once('modules/notification.php');
require_once('modules/db.php');
// Parameter
$id = Post('id', null);
$pw = Post('pw', null);
echo $id;
echo $pw."<br>";
// Functions

// Process
if(!$id || !$pw) {
  userGoto('모든 입력란을 입력하십시오.', '');
}
$loginObj = new ProLogin();
if($loginObj->SignIn($id, $pw)) {
  userGoNow('admin_index.php');
  echo "true";
}
else {
  userGoto('로그인 실패', '');
  echo "fali";
}

?>
