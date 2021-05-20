<?php
// error_reporting(E_ALL);
// ini_set('display_errors', '1');
require_once('modules/db.php');  // DB연결을 위한 같은 경로의 dbconn.php를 인클루드합니다.

$mb_id = isset($_SESSION['ss_mb_id']) ? $_SESSION['ss_mb_id'] : null;
$om_id =	isset($_SESSION['naver_mb_id']) ? $_SESSION['naver_mb_id'] : $_SESSION['kakao_mb_id'];
$om_id = substr($om_id, 5);
$all = isset($mb_id) ? $mb_id : $om_id;
$kind = $_GET['kind'] ? $_GET['kind'] : 'recive';
// echo $all;
if ($kind == 'recive') {
    $unkind = 'send';
	$kind_title = '받은';
} else if ($kind == 'send') {
    $unkind = 'recive';
	$kind_title = '보낸';
} else {
	echo "<script>alert(''.$kind .'값을 넘겨주세요.');</script>";
	echo "<script>location.replace('./login.php');</script>";
	exit;
}

$sql = " SELECT COUNT(*) AS cnt FROM mb_om_memo WHERE me_{$kind}_mb_id = '{$all}' ";
// echo $sql."<br>";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$total_count = $row['cnt'];

$page_rows = 5; // 페이지당 목록 수
$page = Get('page', 0);

$total_page  = ceil($total_count / $page_rows);  // 전체 페이지 계산
if ($page < 1) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $page_rows; // 시작 열을 구함

$list = array();

$sql = " SELECT a.*, b.mb_id, b.mb_name, b.mb_email, c.om_id,c.om_nickname, c.om_email
            FROM mb_om_memo a
            LEFT JOIN member b ON (a.me_{$unkind}_mb_id = b.mb_id)
            LEFT JOIN oauth_member c ON (a.me_{$unkind}_mb_id = c.om_id)
            WHERE a.me_{$kind}_mb_id = '{$all}'
            ORDER BY a.me_id DESC LIMIT $from_record, {$page_rows} ";
// echo $sql;
$result = mysqli_query($conn, $sql);
for ($i=0; $row=mysqli_fetch_assoc($result); $i++)
{
    $list[$i] = $row;

    $mb_id = $row["me_{$unkind}_mb_id"];

    if ($row['me_recive_datetime'] == '0000-00-00 00:00:00'){
      $read_datetime = '미열람';
    }else{
        $read_datetime =$row['me_recive_datetime'] ? $row['me_recive_datetime'] : null;
        $read_datetime = substr($read_datetime, 5, 5);
    }
    $send_datetime = $row['me_send_datetime'];
    $send_datetime = substr($send_datetime, 5, 5);
    $list[$i]['send_datetime'] = $send_datetime;
    $list[$i]['read_datetime'] = $read_datetime;
    $list[$i]['view_href'] = './memo_view.php?me_id='.$row['me_id'].'&amp;kind='.$kind; // 쪽지 읽기 링크
    $list[$i]['del_href'] = './memo_delete.php?me_id='.$row['me_id'].'&amp;kind='.$kind; // 쪽지 삭제 링크
}

$str = ''; // 페이징 시작
if ($page > 1) {
	$str .= '<a href="./memo.php?kind='.$kind.'&amp;page=1" class="pg_page pg_start"><</a>';
}

$start_page = ( ( (int)( ($page - 1 ) / $page_rows ) ) * $page_rows ) + 1;
$end_page = $start_page + $page_rows - 1;

if ($end_page >= $total_page) $end_page = $total_page;

if ($start_page > 1) $str .= '<a href="./memo.php?kind='.$kind.'&amp;page='.($start_page-1).'" class="pg_page pg_prev">이전</a>';

if ($total_page > 1) {
	for ($k=$start_page;$k<=$end_page;$k++) {
		if ($page != $k)
			$str .= '<a href="./memo.php?kind='.$kind.'&amp;page='.$k.'" class="pg_page">'.$k.'</a>';
		else
			$str .= '<strong class="pg_current">'.$k.'</strong>';
	}
}

if ($total_page > $end_page) $str .= '<a href="./memo.php?kind='.$kind.'&amp;page='.($end_page+1).'" class="pg_page pg_next">다음</a>';

if ($page < $total_page) {
	$str .= '<a href="./memo.php?kind='.$kind.'&amp;page='.$total_page.'" class="pg_page pg_end">></a>';
}

if ($str) // 페이지가 있다면 생성
	$write_page = "<nav id='pagenation_box'><span class=\"pg\">{$str}</span></nav>";
else
	$write_page = "";

mysqli_close($conn); // 데이터베이스 접속 종료
?>

<html>
<head>
	<title>Memo</title>
	<link href="css/note.css" rel="stylesheet" type="text/css">
  <link href="css/content.css" rel="stylesheet" type="text/css">
</head>
<body id="memo">
	<!-- 쪽지 목록 시작 { -->
	<div class="note">
    <div class="header">
      <div class="header_img">
        <img src="img/note.png">
        <span class="title">쪽지함</span>
      </div>
      <span class="text">전체 <?php echo $kind_title ?>쪽지 <?php echo $total_count ?>통</span>
    </div>

			<button class="btn1" onclick="location.href ='./memo.php?kind=recive'">받은쪽지</button>
			<button class="btn2" onclick="location.href ='./memo.php?kind=send'">보낸쪽지</button>

  </div>
		<div id="contentBody">
			<table class='contentheader'>
			<!-- <caption>
				전통<br>
			</caption> -->
			<colgroup>
				<col width="20%">
				<col width="">
				<col width="">
				<col width="20%">
			</colgroup>
			<thead>
			<tr>
				<th><?php echo ($kind == "recive") ? "보낸사람" : "받는사람";  ?></th>
				<th>보낸날</th>
				<th>읽은날</th>
				<th>삭제</th>
			</tr>
			</thead>
			<tbody>
			<?php for ($i=0; $i<count($list); $i++) {  ?>
			<tr>
				<td><?php echo isset($list[$i]['mb_name']) ? $list[$i]['mb_name'] : $list[$i]['om_nickname'] ?></td>
				<td><?php echo $list[$i]['send_datetime'] ?></td>
				<td><a href="<?php echo $list[$i]['view_href'] ?>"><?php echo $list[$i]['read_datetime'] ?></a></td>
				<td><a href="<?php echo $list[$i]['del_href'] ?>" onclick="del(this.href); return false;"><img src="img/delete.png"></a></td>
			</tr>
			<?php }  ?>
			<?php if ($i==0) { echo '<tr><td colspan="4">자료가 없습니다.</td></tr>'; }  ?>
			</tbody>
			</table>
      <!-- 페이지네이션 -->
      <?php echo $write_page;  ?>

		</div>
</body>
  <script type="text/javascript">
  <?php
    $kind= $_REQUEST["kind"];
      if ($kind =="recive") {
  ?>
        document.querySelector('.btn1').classList.add("current");
        document.querySelector('.btn2').classList.remove("current");
  <?php
      }else{
  ?>
        document.querySelector('.btn2').classList.add("current");
        document.querySelector('.btn1').classList.remove("current");
  <?php
      }
  ?>

  </script>
</html>
