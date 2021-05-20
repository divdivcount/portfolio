<?php
require_once('modules/db.php'); // DB연결을 위한 같은 경로의 dbconn.php를 인클루드합니다.

$me_recv_mb_id = $_GET['me_recive_mb_id']; // GET 방식으로 넘어온 받는 회원아이디
$pr_id = $_GET['id']; // GET 방식으로 넘어온 받는 제품번호
?>

<html>
<head>
	<title>Memo Form</title>
	<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
	<link rel="stylesheet" href="css/css_memo_form.css">
	<link rel="stylesheet" href="css/css_noamlfont.css">
</head>
<body id="memo">
	<!-- 쪽지 보내기 시작 { -->
  <div class="header">
    <img src="img/note.png">
    <span class="title">쪽지 보내기</span>
  </div>

	<div class="content_box">
		<form name="fmemoform" action="./memo_form_update.php" onsubmit="return fmemoform_submit(this);" method="post" autocomplete="off">
			<!-- 받는사람 나오고 버튼있는 박스 -->
			<div class="sendMemo_box">
				<!-- 받는사람 나오는 부분  -->
				<div class="recive_member">
					<span>받는사람</span>
					<input type="text" name="me_recv_mb_id" value="<?php echo $me_recv_mb_id ?>" id="me_recv_mb_id" readonly required class="frm_input required" size="47">
					<input type="hidden" name= "id" value="<?=$pr_id?>">
				</div>

				<!-- 답장하기버튼 -->
				<div class="conbtn">
	        <input type="submit" class="cbtn" id="submit_memo" value="답장하기">
	      </div>
    	</div>

			<div class="insertText_box">
				<textarea name="me_memo" rows="10" cols="50" required placeholder="쪽지에 내용은 여기에 표시됩니다"></textarea>
			</div>
		</form>
	</div>

	<!-- 쪽지 보내기 끝 { -->
</body>
</html>
