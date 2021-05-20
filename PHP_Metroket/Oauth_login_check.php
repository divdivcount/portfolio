<?php
require_once("modules/db.php");
require_once("modules/notification.php");
require_once("modules/parameter.php");

$naver_id = trim(GET("om_id",0));
$kakao_id = trim(GET("om_id",0));

if(isset($naver_id)){
  $_SESSION['naver_mb_id'] = $naver_id;
  if(isset($_SESSION['naver_mb_id'])) { // 세션이 있다면 로그인 확인 페이지로 이동
  	echo "<script>alert('로그인 되었습니다.');</script>";
  	echo "<script>location.replace('./index.php');</script>";
  }
}elseif(isset($kakao_id)){
  $_SESSION['kakao_mb_id'] = $kakao_id;
  if(isset($_SESSION['kakao_mb_id'])) { // 세션이 있다면 로그인 확인 페이지로 이동
  	echo "<script>alert('로그인 되었습니다.');</script>";
  	echo "<script>location.replace('./index.php');</script>";
  }
}else{
  userGoto("Oauth로 로그인되지 않았습니다.", '');
}
?>
