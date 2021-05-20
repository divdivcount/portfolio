<?php
// Load Modules
require_once("modules/db.php");
$mode = empty($_POST['mode']) ? "" : $_POST['mode'];

if($mode != 'insert' && $mode != 'modify') { // 아무런 모드가 없다면 중단
	echo "<script>alert('mode 값이 제대로 넘어오지 않았습니다.');</script>";
	echo "<script>location.replace('./register.php');</script>";
	exit;
}
switch ($mode) {
    case 'insert' :
        $mb_id = $_POST['mb_id'];
		$title = "회원가입";
        break;
    case 'modify' :
        $mb_id = ($_SESSION['ss_mb_id'] ? $_SESSION['ss_mb_id'] :
								 ($_SESSION['naver_mb_id'] ? $_SESSION['naver_mb_id'] : $_SESSION['kakao_mb_id']));
		$title = "회원수정";
    break;
}
$mb_now_password = $_POST['old_pw'];
$mb_password = $_POST['mb_password']; // 첫번째 입력 패스워드
$mb_password_re	= $_POST['mb_password_re']; // 두번째 입력 패스워드
$mb_name = $_POST['mb_name']; // 이름
$mb_email_one	= $_POST['mb_email']; // 이메일1
$mb_email_two	= $_POST['mb_email_two']; // 이메일2
$mb_datetime = date('Y-m-d H:i:s', time()); // 가입일
$mb_modify_datetime	= date('Y-m-d H:i:s', time()); // 수정일
$mb_email = $mb_email_one.'@'.$mb_email_two;



$sql = " SELECT mb_password FROM member WHERE mb_id = '$mb_id'"; // 입력한 비밀번호를 MySQL password() 함수를 이용해 암호화해서 가져옴
$result = mysqli_query($conn, $sql);
$mb_pw = mysqli_fetch_assoc($result);
$mb_pws = $mb_pw["mb_password"];
$sql = " SELECT PASSWORD('$mb_now_password') AS pass "; // 입력한 비밀번호를 MySQL password() 함수를 이용해 암호화해서 가져옴
$result = mysqli_query($conn, $sql);
$rows = mysqli_fetch_assoc($result);
$mbs_password = $rows['pass'];
// echo $mbs_password."<br>";
// echo $mb_pw["mb_password"];


if($mb_pw["mb_password"] != $mbs_password){
	echo "<script>alert('현재 비밀번호가 일치하지 않습니다.');</script>";
	echo "<script>location.replace('./member_update.php');</script>";
	exit;
}
if (!$mb_id) {
	echo "<script>alert('아이디가 넘어오지 않았습니다.');</script>";
	echo "<script>location.replace('./register.php');</script>";
	exit;
}

if (!$mb_password) {
	echo "<script>alert('비밀번호가 넘어오지 않았습니다.');</script>";
	echo "<script>location.replace('./register.php');</script>";
	exit;
}

if ($mb_password != $mb_password_re) {
	echo "<script>alert('비밀번호가 일치하지 않습니다.');</script>";
	echo "<script>location.replace('./register.php');</script>";
	exit;
}

if (!$mb_name) {
	echo "<script>alert('이름이 넘어오지 않았습니다.');</script>";
	echo "<script>location.replace('./register.php');</script>";
	exit;
}

if (!$mb_email) {
	echo "<script>alert('이메일이 넘어오지 않았습니다.');</script>";
	echo "<script>location.replace('./register.php');</script>";
	exit;
}
$sql = " SELECT PASSWORD('$mb_password') AS pass "; // 입력한 비밀번호를 MySQL password() 함수를 이용해 암호화해서 가져옴
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$mb_password = $row['pass'];

if($mode == "insert") { // 신규 등록 상태
	// if($mb_id != NULL){
	//
		$sql = "select * from member where mb_id='{$_POST['mb_id']}'"; // 회원가입을 시도하는 아이디가 사용중인 아이디인지 체크
		$result = mysqli_query($conn, $sql);
		$id_check = mysqli_num_rows($result);
	// 	if ($id_check >= 1) {
	// 				echo "존재하는 아이디입니다.";
	// 			} else {
	// 				echo "존재하지 않는 아이디입니다.";
	// 			}
	// 		}
	if (mysqli_num_rows($result) > 0) { // 만약 사용중인 아이디라면 알림창을 띄우고 회원가입 페이지로 이동
		echo "<script>alert('이미 사용중인 회원아이디 입니다.');</script>";
		echo "<script>location.replace('./register.php');</script>";
		exit;
	}

	$sql = " INSERT INTO member
				SET mb_id = '$mb_id',
				mb_image = 'img/normal_profile.png',
					 mb_password = '$mb_password',
					 mb_name = '$mb_name',
					 mb_email = '$mb_email',
					 mb_datetime = '$mb_datetime' ";
	$result = mysqli_query($conn, $sql);

} else if ($mode == "modify") {
 // 회원 수정 상태
	$sql = " UPDATE member
				SET mb_password = '$mb_password',
					 mb_modify_datetime = '$mb_modify_datetime'
			 WHERE mb_id = '$mb_id' ";
	$result = mysqli_query($conn, $sql);




}

if ($result) {


	if($mode == "insert") { // 신규 가입의 경우 무조건 메일 인증확인 메일 발송
		include_once('./function.php'); // 메일 전송을 위한 파일을 인클루드합니다.

		$mb_md5 = md5(pack('V*', rand(), rand(), rand(), rand())); // 어떠한 회원정보도 포함되지 않은 일회용 난수를 생성하여 인증에 사용

		$sql = " UPDATE member SET mb_email_certify2 = '$mb_md5' WHERE mb_id = '$mb_id' "; // 회원가입을 시도하는 아이디에 메일 인증을 위한 일회용 난수를 업데이트
		$result = mysqli_query($conn, $sql);
		mysqli_close($conn); // 데이터베이스 접속 종료

		$certify_href = 'https://metroket.kro.kr/email_certify.php?&amp;mb_id='.$mb_id.'&amp;mb_md5='.$mb_md5; // 메일 인증 주소

		$subject = '인증확인 메일입니다.'; // 메일 제목

		ob_start(); //ob_start — 출력 버퍼링 켜기
		include_once ('./register_update_mail.php');
		$content = ob_get_contents(); // 메일 내용
		ob_end_clean(); //출력 버퍼를 정리 (지우기)하고 출력 버퍼링을 종료.

		$mail_from = "dame502030@naver.com"; // 보내는 이메일 주소
		$mail_to = $mb_email; // 받을 이메일 주소

		mailer('관리자', $mail_from, $mail_to, $subject, $content); // 메일 전송
		echo "<script>alert('".$title."이 완료 되었습니다.\\n신규가입의 경우 메일인증을 받으셔야 로그인 가능합니다.');</script>";
		echo "<script>location.replace('./index.php');</script>";
	}
if($mode == "modify") {
	echo "<script>alert('".$title."이 완료 되었습니다.');</script>";
	echo "<script>location.replace('./member_update.php');</script>";
}

	exit;
} else {
	echo "생성 실패: " . mysqli_error($conn);
	mysqli_close($conn); // 데이터베이스 접속 종료
}
?>
