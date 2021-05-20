<?php
// error_reporting(E_ALL);
// ini_set('display_errors', '1');
require_once('modules/db.php'); // DB연결을 위한 같은 경로의 dbconn.php를 인클루드합니다.

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
$me_read_datetime	= date('Y-m-d H:i:s', time()); // 메모읽은일시

if ($kind == 'recive')
{
    $kind_str = "보낸";
    $kind_date = "받은";

    $sql = " UPDATE mb_om_memo
                SET me_recive_datetime = '$me_read_datetime'
                WHERE me_id = '$me_id'
                AND me_recive_mb_id = '$all'
                AND me_recive_datetime = '0000-00-00 00:00:00' ";
		// echo $sql;
    $result = mysqli_query($conn, $sql);
}
else if ($kind == 'send')
{
    $kind_str = "받는";
    $kind_date = "보낸";
}
else
{
	echo "<script>alert('변수 kind 값이 없습니다.');window.close();</script>";
	exit;
}

$sql = " SELECT * FROM mb_om_memo
            WHERE me_id = '$me_id'
            AND me_{$kind}_mb_id = '$all' ";
$result = mysqli_query($conn, $sql);
$memo = mysqli_fetch_assoc($result);

$sql = " SELECT a.*,b.mb_id, b.mb_email, c.om_id,c.om_nickname
            FROM mb_om_memo a
            LEFT JOIN member b ON (a.me_{$kind}_mb_id = b.mb_id)
            LEFT JOIN oauth_member c ON (a.me_{$kind}_mb_id = c.om_id)
            WHERE a.me_{$kind}_mb_id = '{$memo[me_send_mb_id]}'";
// echo $sql;
$result = mysqli_query($conn, $sql);
$memos = mysqli_fetch_assoc($result);
// echo $memos['mb_id'];
mysqli_close($conn); // 데이터베이스 접속 종료
?>

<html>
<head>
	<title>Memo View</title>
	<link href="./style.css" rel="stylesheet" type="text/css">
</head>
<body id="memo">
	<!-- 쪽지보기 시작 { -->
	<div>
		<h1>쪽지 보기</h1>

		<ul>
			<li><a href="./memo.php?kind=recive">받은쪽지</a></li>
			<li><a href="./memo.php?kind=send">보낸쪽지</a></li>
		</ul>

		<article>
			<header>
				<h1>쪽지 내용</h1>
			</header>
			<table>
				<colgroup>
					<col width="20%">
					<col width="*">
					<col width="20%">
					<col width="*">
				</colgroup>
				<tr>
					<th><?php echo $kind_str ?>사람</th>
					<td><strong><?php echo $memo['me_send_mb_id'] ?></strong></td>
					<th><?php echo $kind_date ?>시간</th>
					<td><strong><?php echo substr($memo['me_send_datetime'], 0, 16); ?></strong></td>
				</tr>
				<tr>
					<td colspan="4"><?php echo nl2br($memo['me_text']) ?></td>
				</tr>
			</table>
		</article>

		<div class="win_btn">
			<?php if ($kind == 'recive') {  ?><a href="./memo_form.php?me_recive_mb_id=<?php echo $memos['mb_id'] != null ? $memos['mb_id']  : 'sir'.$memos['om_id']  ?>&amp;me_id=<?php echo $memo['me_id'] ?>&amp;id=<?=$memos['pr_id']?>">
				<?php if($memo['me_send_mb_id'] === 'admin'){echo "";}else{echo "답장";}?></a><?php }  ?>
			<a href="./memo.php?kind=<?php echo $kind ?>">목록보기</a>
			<button type="button" onclick="window.close();">창닫기</button>
		</div>
	</div>
	<!-- } 쪽지보기 끝 -->
</body>
</html>
