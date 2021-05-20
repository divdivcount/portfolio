<?php
// 메일 전송을 위한 라이브러리
include_once('./PHPMailer/PHPMailerAutoload.php');

// 메일 보내기
// mailer("보내는 사람 이름", "보내는 사람 메일주소", "받는 사람 메일주소", "제목", "내용");
function mailer($fname, $fmail, $to, $subject, $content)
{
    $mail = new PHPMailer();

    $mail->IsSMTP();

    $mail->SMTPSecure = "ssl";
    $mail->SMTPAuth = true;

    $mail->Host = "smtp.naver.com";
    $mail->Port = 465;
    $mail->Username = "dame502030@naver.com"; // 네이버메일 계정
    $mail->Password = "y!j@r#05812002!"; // 네이버메일 비밀번호

    $mail->CharSet = 'UTF-8';
    $mail->From = $fmail;
    $mail->FromName = $fname;
    $mail->Subject = $subject;
    $mail->msgHTML($content);
    $mail->addAddress($to);

    return $mail->send();
}
?>
