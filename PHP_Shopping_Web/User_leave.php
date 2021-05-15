<?php
// Load Modules
require_once('modules/db.php');
//유저페이지에서 1개값 받아옴
$u_mb_id = Get("mb",null);//empty($_REQUEST["mb"]) ? "" :  $_REQUEST["mb"];

?>
<!doctype html>
<html>
	<head>
		<?php require_once('modules/form_head.php'); ?>
		<link rel="stylesheet" href="css/css_login.css">
		<title></title>
	</head>
	<body>
    <form action="User_leave_check.php?mb=<?=$u_mb_id?>" method="post">
			<div class="login-box-bg">
        <div style="width:365px;" class="login-box">
					<h1 style="font-size:20px; width:100%;"><?=$u_mb_id?>님 회원 탈퇴 하시겠습니까?</h1>
					<div class="textbox">
      			<input type="password" name="password" placeholder="비밀번호를 입력해주세요.">
					</div>
						<input class="btn" type="submit" value="삭제" />
    </form>
	</body>
</html>
