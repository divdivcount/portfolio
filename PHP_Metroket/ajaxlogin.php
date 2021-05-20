<?php
// Load Modules
require_once("modules/db.php");
$mb_ids = Post("mb_ids",null);//$mb_ids = empty($_POST['mb_ids']) ? "" : $_POST['mb_ids'];
if(isset($mb_ids) != NULL){
  $sql = "select * from member where mb_id='{$_POST['mb_ids']}'"; // 회원가입을 시도하는 아이디가 사용중인 아이디인지 체크
  $result = mysqli_query($conn, $sql);
  $id_check = mysqli_num_rows($result);
		if ($id_check >= 1) {
					echo "존재하는 아이디입니다.";
		} else {
					echo "존재하지 않는 아이디입니다.";
		}
	}else{
	}


?>
