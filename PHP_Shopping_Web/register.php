<?php
// Load Modules
require_once("modules/db.php");
?>
<html>
<head>
	<title>Register</title>
	<link rel="stylesheet" href="css/css_login.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

</head>
<?php
$mb_id = empty($_SESSION['ss_mb_id']) ? "" : $_SESSION['ss_mb_id'];
if($mb_id && isset($_GET['mode']) == 'modify') { // 세션이 있고 회원수정 mode라면 회원 정보를 가져옴
	$dao = new Member();
	$result = $dao->Member_Search("",$mb_id);
	foreach ($result as $mb) {

	}
	$mode = "modify";
	$title = "Modify";
	$modify_mb_info = "readonly";
} else {
	$mb['mb_id']= "";
	$modify_mb_info = "";
	$mb['mb_name'] = "";
	$mb['mb_email'] = "";
	$mb['mb_gender'] = "";

	$mode = "insert";
	$title = "register";
	$modify_mb_info = '';

	?>
<script>
	$(document).ready(function(e) {
		$(".id_checking").on("keyup", function(){ //id_checking 라는 클래스에 입력을 감지(keyup이벤트)
			var id_checking = $(this); //id_checking 클래스 자기자신
			var mb_id;
			if(id_checking.attr("id") === "mb_id"){ //id_checking.attr("id") -> mb_id === mb_id
				mb_id = id_checking.val();//id_checking 벨류값을 mb_id에 담김
			}
			$.post( //post방식으로 register_update.php에 입력한 userid값을 넘깁니다
				"ajaxlogin.php",
				{ mb_ids : mb_id},
				function(data){
					if(data){ //만약 data값이 전송되면
						$('#id_check').html(data); //id_check에 값을 넣음
					}
				}
			);
		});
	});

	</script>
	<?php
}
?>
<body>
<form action="./register_update.php" onsubmit="return fregisterform_submit(this);" method="post">
	<input type="hidden" name="mode" value="<?php echo $mode; ?>">
	<div style="height:600px;" class="login-box-bg">
		<div class="login-box">
			<h1><?php echo $title; ?></h1>
			<div class="textbox">
				<input type="text" placeholder="UserId" name="mb_id" id="mb_id"  class="id_checking" value="<?php echo $mb['mb_id']; ?>" <?php echo $modify_mb_info; ?>/>
			</div>
			<p id='id_check'></p>
			<div class="textbox">
				<input type="password" placeholder="Password" name="mb_password">
			</div>
			<div class="textbox">
				<input type="password" placeholder="Password_Re" name="mb_password_re">
			</div>
			<div class="textbox">
				<input type="text" name="mb_name" placeholder="Name" value="<?php echo $mb['mb_name'] ?>" <?php echo $modify_mb_info ?>>
			</div>
			<div class="textbox">
				<input type="text" name="mb_email" placeholder="E-Mail" value="<?php echo $mb['mb_email'] ?>">
			</div>
			<div style="text-align:center;" >
				<label style="margin-right:15px;"><input type="radio" name="mb_gender" value="남자" <?php echo ($mb['mb_gender'] == "남자") ? "checked" : "";?> >남자</label>
				<label style="margin-left:100px;"><input type="radio" name="mb_gender" value="여자" <?php echo ($mb['mb_gender'] == "여자") ? "checked" : "";?> >여자</label>
			</div>

			<input type="submit" class="btn" value="<?php echo $title ?>">
			<div style="width:96%; text-align:center;"class="btn"><a style="font-size: 19px;text-decoration:none; color:#fff;" href="./login.php">Cancel</a></div>
			</div>
	</div>
</form>

<script>
function fregisterform_submit(f) { // submit 최종 폼체크

	if (f.mb_id.value.length < 1) { // 회원아이디 검사
		alert("아이디를 입력하십시오.");
		f.mb_id.focus();
		return false;
	}

	if (f.mb_name.value.length < 1) { // 이름 검사
		alert("이름을 입력하십시오.");
		f.mb_name.focus();
		return false;
	}

	if (f.mb_password.value.length < 3) {
		alert("비밀번호를 3글자 이상 입력하십시오.");
		f.mb_password.focus();
		return false;
	}

	if (f.mb_password.value != f.mb_password_re.value) {
		alert("비밀번호가 같지 않습니다.");
		f.mb_password_re.focus();
		return false;
	}

	if (f.mb_password.value.length > 0) {
		if (f.mb_password_re.value.length < 3) {
			alert("비밀번호를 3글자 이상 입력하십시오.");
			f.mb_password_re.focus();
			return false;
		}
	}

	if (f.mb_email.value.length < 1) { // 이메일 검사
		alert("이메일을 입력하십시오.");
		f.mb_email.focus();
		return false;
	}

	if (f.mb_email.value.length > 0) { // 이메일 형식 검사
		var regExp = /^[0-9a-zA-Z]([-_.]?[0-9a-zA-Z])*@[0-9a-zA-Z]([-_.]?[0-9a-zA-Z])*.[a-zA-Z]{2,3}$/i;
		if (f.mb_email.value.match(regExp) == null) {
			alert("이메일 주소가 형식에 맞지 않습니다.");
			f.mb_email.focus();
			return false;
		}
	}

	return true;

}
</script>

</body>
</html>
