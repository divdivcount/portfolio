<?php
// Load Modules
require_once('modules/db.php');
$_SESSION['ss_mb_id'];
//id 값 유저페이지에서 1개값 받아옴
$u_mb_id = empty($_REQUEST["mb"]) ? "" :  $_REQUEST["mb"];

$sql = " select * from member where mb_id = TRIM('$u_mb_id') ";
$result = mysqli_query($conn, $sql);
$mb = mysqli_fetch_assoc($result);
// echo   $mb["mb_num"];
// echo   $mb["mb_id"];

//Password 값 유저페이지에서 1개값 받아옴
$mb_password = empty($_POST["password"]) ? "" : $_POST["password"];

$sql = " SELECT PASSWORD('$mb_password') AS pass ";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
// echo $mb['mb_password']."<br>";
$password = $row['pass'];
// echo $password."<br>";
mysqli_close($conn);


if (!$u_mb_id || !($password === $mb['mb_password'])) {
	echo "<script>alert('가입된 회원아이디가 아니거나 비밀번호가 틀립니다.\\n비밀번호는 대소문자를 구분합니다.');</script>";
	echo "<script>location.replace('./login.php');</script>";
	exit;
}else{
	unset($_SESSION['ss_mb_id']); // 모든 세션변수를 언레지스터 시켜줌
	$dao = new Member();
  $del = $dao -> Member_Delete($mb["mb_num"]);
  exit;
}



?>
