<?php
/*
Description: 이 모듈이 포함된 페이지는 관리자만 접근 가능
*/
// Load Modules
require_once($_SERVER['DOCUMENT_ROOT'].'/modules/module_protect.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/modules/notification.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/modules/db.php');

// Parameter

// Functions

// Process
$loginObj = new ProLogin();
if($loginObj->SignedIn()) {
  ;
}
else {
  userGoto('관리자만 접근할 수 있습니다.', '');
  ?>
  <script>
    // parent.window.open("about:blank","_self").close();
  </script>
  <?php
  exit(0);
}
?>
