<?php
require_once('modules/db.php');  // DB연결을 위한 같은 경로의 dbconn.php를 인클루드합니다.
require_once('modules/notification.php');
$mb_id = isset($_SESSION['ss_mb_id']) ? $_SESSION['ss_mb_id'] : null;
$om_id = isset($_SESSION['naver_mb_id']) ? $_SESSION['naver_mb_id'] : (isset($_SESSION['kakao_mb_id']) ? $_SESSION['kakao_mb_id'] : null);
$om_id = substr($om_id, 5);

$pr_id = trim($_POST['id']);
$recv_mb_id = $_POST["me_recv_mb_id"];
$me_text = $_POST["me_memo"];

$all = ($mb_id ? $mb_id :
       ($om_id ? $om_id : null));
$me_send_datetime = date('Y-m-d H:i:s', time());


$sql = " INSERT INTO mb_om_memo
    SET	me_recive_mb_id		= '$recv_mb_id',
      me_send_mb_id			= '$all',
      me_send_datetime		= '$me_send_datetime',
      me_text				= '$me_text',
      pr_id = $pr_id";

$result = mysqli_query($conn, $sql);
userGoto("거래 신청 쪽지를 보냈습니다.", "");
?>
