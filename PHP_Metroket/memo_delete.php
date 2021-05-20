<?php
// error_reporting(E_ALL);
// ini_set('display_errors', '1');
require_once('modules/db.php');  // DB연결을 위한 같은 경로의 dbconn.php를 인클루드합니다.

$mb_id = isset($_SESSION['ss_mb_id']) ? $_SESSION['ss_mb_id'] : null;
$om_id =	isset($_SESSION['naver_mb_id']) ? $_SESSION['naver_mb_id'] : $_SESSION['kakao_mb_id'];
$om_id = substr($om_id, 5);
$all = isset($mb_id) ? $mb_id : $om_id;
$kind = $_GET['kind'] ? $_GET['kind'] : 'recive';

if (!$mb_id && !$om_id) {
	echo "<script>alert('회원만 이용하실 수 있습니다.');window.close();</script>";
	exit;
}

$me_id = $_GET['me_id'];

$sql = " DELETE FROM mb_om_memo
            WHERE me_id = '{$me_id}'
            AND (me_recive_mb_id = '{$all}' OR me_send_mb_id = '{$all}') ";
$result = mysqli_query($conn, $sql);

if ($result) { // 쿼리가 정상 실행됐다면.
	$url = './memo.php?kind='.$kind;
	echo "<script>alert('쪽지가 삭제 완료 되었습니다.');</script>";
	echo "<script>location.replace('$url');</script>";
	exit;
} else {
	echo "삭제 실패: " . mysqli_error($conn);
	mysqli_close($conn); // 데이터베이스 접속 종료
}
?>
