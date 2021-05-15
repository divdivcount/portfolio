<?php
// Load Modules
session_start();
require_once('modules/notification.php');
$_SESSION['user'];
// Parameter

// Functions

// Process
// 모든 세션변수를 언레지스터 시켜줌
if(empty($_SESSION['user'])){
	echo "세션이 없다.";
}else{
  unset($_SESSION['user']);
	session_destroy($_SESSION['user']); // 세션파괴
}
if(!isset($_SESSION['user'])) { // 세션이 삭제되었다면 로그인 페이지로 이동
	echo "<script>alert('로그아웃 되었습니다.');</script>";
	userGoNow('admin_login.php');
	exit;
}
?>
