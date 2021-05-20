<?php
// Load Modules
// error_reporting(E_ALL);
// ini_set('display_errors', '1');
require_once("modules/db.php");
require_once("modules/notification.php");
$db = new ProLogin();
$mb_id = trim($_POST['mb_id']);
$mb_password = trim($_POST['mb_password']);

if (!$mb_id || !$mb_password) {
	echo "<script>alert('회원아이디나 비밀번호가 공백이면 안됩니다.');</script>";
	echo "<script>location.replace('./index.php');</script>";
	exit;
}

$sql = " SELECT * FROM member WHERE mb_id = '$mb_id' ";
$result = mysqli_query($conn, $sql);
$mb = mysqli_fetch_assoc($result);

$sql = " SELECT PASSWORD('$mb_password') AS pass ";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$password = $row['pass'];



// $sql = " SELECT * FROM member WHERE mb_id = '$mb_id' and mb_del = 'y' ";
// $result = mysqli_query($conn, $sql);
// $mb_del = mysqli_fetch_assoc($result);
//
// if ($mb_del['mb_id']) {
// 	echo "<script>alert('회원탈퇴한 아이디 입니다.');</script>";
// 	echo "<script>location.replace('./login.php');</script>";
// 	exit;
// }
// var_dump($mb['mb_block'] === 'y');
if($mb['mb_block'] === 'y'){
	echo "<script>alert('관리자로 인해 차단 당한 아이디 입니다.');</script>";
	echo "<script>location.replace('./index.php');</script>";
	exit;
}

if (!$mb['mb_id'] || !($password === $mb['mb_password'])) {
	echo "<script>alert('가입된 회원아이디가 아니거나 비밀번호가 틀립니다.\\n비밀번호는 대소문자를 구분합니다.');</script>";
	echo "<script>location.replace('./index.php');</script>";
	exit;
}

if ($mb['mb_email_certify'] == '0000-00-00 00:00:00') {
	include_once('./function.php');

	$mb_md5 = md5(pack('V*', rand(), rand(), rand(), rand()));

	$sql = " UPDATE member SET mb_email_certify2 = '$mb_md5' WHERE mb_id = '$mb_id' ";
	$result = mysqli_query($conn, $sql);
	mysqli_close($conn);

	$certify_href = 'https://metroket.kro.kr/email_certify.php?&amp;mb_id='.$mb_id.'&amp;mb_md5='.$mb_md5; // 메일 인증 주소

	$subject = '인증확인 메일입니다.'; // 메일 제목

	ob_start();
	include_once ('./register_update_mail.php');
	$content = ob_get_contents(); // 메일 내용
	ob_end_clean();

	$mail_from = "dame502030@naver.com"; // 보내는 메일 주소
	$mail_to = $mb['mb_email']; // 받을 메일 주소

	mailer('관리자', $mail_from, $mail_to, $subject, $content); // 메일 전송

	echo "<script>alert('".$mb['mb_email']." 메일로 인증메일을 전송하였습니다.\\n".$mb['mb_email']." 메일로 메일인증을 받으셔야 로그인 가능합니다.');</script>";
	echo "<script>location.replace('./index.php');</script>";
	exit;
}



if(!isset($_SESSION['ss_mb_id']) && $mb['mb_operation'] == 2) { // 세션이 있다면 로그인 확인 페이지로 이동
	echo "<script>alert('로그인 되었습니다.');</script>";
	echo "<script>location.replace('./index.php');</script>";
	$_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
	$_SESSION['ss_mb_id'] = $mb_id;
}elseif(!isset($_SESSION['ss_mb_id']) && $mb['mb_operation'] == 1 && $db->InternalIP()){
	echo "<script>alert('관리자님 안녕하세요.');</script>";
	echo "<script>location.replace('./admin_index.php');</script>";
	$_SESSION['ss_mb_id'] = $mb_id;
	$_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
}else{
	userGoto("로그인에 실패했습니다.", "");
}
mysqli_close($conn); // 데이터베이스 접속 종료
?>
