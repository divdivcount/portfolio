<?php

require_once('modules/db.php');  // DB연결을 위한 같은 경로의 dbconn.php를 인클루드합니다.

$mb_id = isset($_SESSION['ss_mb_id']) ? $_SESSION['ss_mb_id'] : null;
$om_id =	isset($_SESSION['naver_mb_id']) ? $_SESSION['naver_mb_id'] : $_SESSION['kakao_mb_id'];
$om_id = substr($om_id, 5);
// var_dump($mb_id);
// var_dump($om_id);

if(!(empty($_SESSION['ss_mb_id']) || empty($_SESSION['naver_mb_id']) || empty($_SESSION['kakao_mb_id']))){
	echo "<script>alert('쪽지를 보내기 위해서는 로그인이 필요합니다.');</script>";
	echo "<script>history.back();</script>";
}else{
	$me_send_datetime = date('Y-m-d H:i:s', time()); // 메모 작성일

	$recv_list1 = trim($_POST['me_recv_mb_id']);
	$pr_id = trim($_POST['id']);
	if(strpos($recv_list1, "sir") !== false) {
	    $recv_list = explode('sir', $recv_list1);
			// echo $recv_list[0]."<br>";
			// echo $recv_list[1]."<br>";
			$sql = " SELECT om_id, om_nickname FROM oauth_member WHERE om_id = $recv_list[1]";
	} else {
			$sql = " SELECT mb_id, mb_name FROM member WHERE mb_id = '{$recv_list1}' ";
	}
	$str_name_list = '';

	$member_list = array();

		$result = mysqli_query($conn, $sql);
		$row = mysqli_fetch_assoc($result);
		if (isset($row['mb_id'])) { // 해당 회원이 존재한다면
			$member_list['id'][0]   = $row['mb_id'];
			$member_list['name'][0] = $row['mb_name'];
		} elseif($row['om_id']) { // 해당 회원이 존재하지 않는다면
			$member_list['id'][0]   = $row['om_id'];
			$member_list['name'][0] = $row['om_nickname'];
		} else { // 해당 회원이 존재하지 않는다면
			$error_list   = $recv_list1;
			if ($error_list) {
				echo "<script>alert('회원아이디 {$error_list} 은(는) 존재하지 않는 회원아이디 입니다.\\n쪽지를 발송하지 않았습니다.');window.close();</script>";
				exit;
			}
		}
	// var_dump($member_list['id'])."<br>";
	// echo $mb_id."mb_id<br>";
	// echo $om_id."om_id<br>";
	$all = ($mb_id ? $mb_id :
				 ($om_id ? $om_id : null));
	// echo $all;
	for ($i=0; $i<count($member_list['id']); $i++) {
	    $recv_mb_id = $member_list['id'][$i];
	    // 쪽지 INSERT
	    $sql = " INSERT INTO mb_om_memo
					SET	me_recive_mb_id		= '$recv_mb_id',
						me_send_mb_id			= '$all',
						me_send_datetime		= '$me_send_datetime',
						me_text				= '{$_POST["me_memo"]}',
						pr_id = $pr_id";
	    $result = mysqli_query($conn, $sql);
			// echo $sql."<br>";
			// echo $recv_mb_id."<br>";

	}

	mysqli_close($conn); // 데이터베이스 접속 종료

	if ($member_list) {
	    $str_name_list = implode(',', $member_list['name']);
		echo "<script>alert('{$str_name_list} 님께 쪽지를 전달하였습니다.');window.close();</script>";
		// window.close();
		exit;
	} else {
		echo "<script>alert('회원아이디 오류 같습니다.');window.close();</script>";
		exit;
	}
}
?>
