<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
require_once("modules/db.php");



	$bno = $_GET["bno"];
	$mb_id = $_GET['mb_id'];
	$om_id = $_GET['om_id'];
	$rep_con = $_GET['rep_con'];



	if($mb_id == 'null' && $om_id == 'null'){
		usergoto("로그인을 먼저 해주세요","index.php");
		exit;
	}
	// echo $bno."<br>";
	// echo $mb_id."<br>";
	// echo $om_id."<br>";
	// echo $rep_con;


	$sql =  mq("insert into reply(pr_id,mb_id,om_id,content) values($bno,$mb_id,$om_id,'$rep_con')");
	$rno = $_POST['rno']; // 댓글 번호
	$sql = mq("select * from reply where idx='".$rno."'"); // reply테이블에서 idx가 rno변수에 저장된 값을 찾음
	$reply = $sql->fetch_array();
	$bno = $_POST['b_no']; // 개시글 번호
	$sql2 = mq("select * from product where pr_id='".$bno."'"); // board테이블에서 idx가 bno변수에 저장된 값을 찾음
	$board = $sql2->fetch_array();

?>
