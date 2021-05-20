<?php
require_once('modules/db.php');
$member_search = new Member;

$mb_name = Post("mb_name",0);
$mb_names = Post("mb_names",0);
$mb_id = Post("userId",0);
$mb_first_email = Post("first_email",0);
$mb_second_email = Post("second_email",0);
$mb_email = $mb_first_email.'@'.$mb_second_email;
$title = "임시 비밀번호 및 인증메일이 전송";
echo $mb_name;
echo $mb_names;
echo $mb_id;
echo $mb_email;
if($mb_name && $mb_email){
  $member_searchs = $member_search->Member_Search($mb_name, $mb_email);
  foreach ($member_searchs as $row) {
    $row['mb_id'];
  }
  ?>
  <script>
      alert("<?=$row['mb_id']?>");
      location.replace('./findIdPW.php');
  </script>
  <?php
}elseif($mb_names && $mb_id &&$mb_email){
  include_once('./function.php'); // 메일 전송을 위한 파일을 인클루드합니다.

  $mb_md5 = md5(pack('V*', rand(), rand(), rand(), rand())); // 어떠한 회원정보도 포함되지 않은 일회용 난수를 생성하여 인증에 사용

  $sql = " UPDATE member SET mb_email_certify2 = '$mb_md5' WHERE mb_id = '$mb_id' "; // 회원가입을 시도하는 아이디에 메일 인증을 위한 일회용 난수를 업데이트
  $results = mysqli_query($conn, $sql);
  $certify_href = 'https://metroket.kro.kr/email_certify.php?&amp;mb_id='.$mb_id.'&amp;mb_md5='.$mb_md5; // 메일 인증 주소

  // $sql = " SELECT mb_password FROM member WHERE mb_id = '$mb_id' and mb_name = '$mb_names' and mb_email = '$mb_email' "; // 회원가입을 시도하는 아이디에 메일 인증을 위한 일회용 난수를 업데이트
  // $result = mysqli_query($conn, $sql);
  // $row = mysqli_fetch_assoc($result)
  //
  // $row["mb_password"];
  $sql = " UPDATE member SET mb_password = PASSWORD('$mb_md5') WHERE mb_id = '$mb_id' and mb_name = '$mb_names' and mb_email = '$mb_email' "; // 회원가입을 시도하는 아이디에 메일 인증을 위한 일회용 난수를 업데이트
  $result = mysqli_query($conn, $sql);
  mysqli_close($conn); // 데이터베이스 접속 종료
  $imsi_bi = $mb_md5;
  $subject = '인증 메일 및 임시 비밀번호 메일입니다.'; // 메일 제목

  ob_start(); //ob_start — 출력 버퍼링 켜기
  include_once ('./findpw_update_mail.php');
  $content = ob_get_contents(); // 메일 내용
  ob_end_clean(); //출력 버퍼를 정리 (지우기)하고 출력 버퍼링을 종료.

  $mail_from = "dame502030@naver.com"; // 보내는 이메일 주소
  $mail_to = $mb_email; // 받을 이메일 주소

  mailer('관리자', $mail_from, $mail_to, $subject, $content); // 메일 전송
  echo "<script>alert('".$title."이 완료 되었습니다.\\n신규가입의 경우 메일인증을 받으셔야 로그인 가능합니다.');</script>";
  echo "<script>location.replace('./index.php');</script>";
}



 ?>
