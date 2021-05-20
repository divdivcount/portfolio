<?php
// $ss_mb_id = empty($_SESSION['ss_mb_id']) ? "" : $_SESSION['ss_mb_id'];
session_start(); // 세션의 시작
unset($_SESSION['ss_mb_id']); // 모든 세션변수를 언레지스터 시켜줌
if(empty($_SESSION['ss_mb_id'])){
}else{
	session_destroy($_SESSION['ss_mb_id']); // 세션파괴
}
if(!isset($_SESSION['ss_mb_id'])) { // 세션이 삭제되었다면 로그인 페이지로 이동
	echo "<script>alert('로그아웃 되었습니다.');</script>";
	echo "<script>location.replace('./index.php');</script>";
	exit;
}
?>
