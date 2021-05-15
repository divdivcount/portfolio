<?php
// Load Modules
require_once("modules/db.php");
require_once('modules/notification.php');
?>

<html>
<head>
	<title>Login</title>
	<link href="css/css_login.css" rel="stylesheet" type="text/css">
</head>
<body>

<?php if(!isset($_SESSION['ss_mb_id'])) { // 로그인 세션이 있을 경우 로그인 화면 ?>
	<form action="./login_check.php" method="post">
		<div class="login-box-bg">
			<div class="login-box">
				<h1>Login</h1>
				<div class="textbox">
				<td><input type="text" placeholder="Username" name="mb_id"></td>
				</div>
			<div class="textbox">
				<input type="password" placeholder="Password" name="mb_password">
			</div>
					<button type="submit" class="btn" value="">Sign in</button>
					<div style="text-align:center; width:95%" class="btn"><a style="font-size: 19px;text-decoration:none; color:#fff;" href="./register.php">register</a></div>
				</div>
      </div>
	</form>

<?php } else { // 로그인 세션이 없을 경우 로그인 완료 화면 ?>
	<?php
	$mb_id = $_SESSION['ss_mb_id'];

	$sql = " select * from member where mb_id = TRIM('$mb_id') ";
	$result = mysqli_query($conn, $sql);
	$mb = mysqli_fetch_assoc($result);

	mysqli_close($conn); // 데이터베이스 접속 종료

		userGoNow('index.php');

 } ?>

</body>
</html>
