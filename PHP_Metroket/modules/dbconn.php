<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/modules/module_protect.php');
$mysql_host = "localhost";
$mysql_user = "metro";
$mysql_password = "metro20210316";
$mysql_db = "metro";

$conn = mysqli_connect($mysql_host, $mysql_user, $mysql_password, $mysql_db); // MySQL 데이터베이스 연결

if (!$conn) { // 연결 오류 발생 시 스크립트 종료
    die("연결 실패: " . mysqli_connect_error());
}
function mq($sql)
	{
		global $conn;
		return $conn->query($sql);
	}
session_start(); // 세션의 시작
?>
