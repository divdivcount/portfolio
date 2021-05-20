<?php
// Load Modules
require_once("modules/db.php");
require_once("modules/notification.php");
$ctg_name = $_POST['ctg_name'];
$om_line_station_update = $_POST['station'];
$om_line_station= '';
// echo $ctg_name;
// echo $om_line_station_update;
if($ctg_name != "all" && $om_line_station_update){
	// echo "통과1";
	$sql = "select s.s_name, i.l_name  from station s, line i where i.l_id = '$ctg_name'";
	$line = mysqli_query($conn, $sql);
	$a = 0;

	while($station = mysqli_fetch_assoc($line)){
		// print_r($station)."<br>";
		if(array_search($om_line_station_update, $station) === false) {
			// $theVariable = "not";
			// echo $theVariable."<br>";
		}else{
			// $theVariable = "sure";
			// echo $theVariable."<br>";
			$ctg_name = $station["l_name"];
			$om_line_station = $ctg_name."&nbsp;".$om_line_station_update;
			$a = 1;
			break;
		}
	}
}else{
	if($ctg_name == "all" && $om_line_station_update){
		$sql = "select s.s_name, i.l_name from station s, line i where s.l_id = i.l_id and s.s_name = '$om_line_station_update'";
		// echo $sql;
		$line = mysqli_query($conn, $sql);
		$a = 0;

		while($station = mysqli_fetch_assoc($line)){
			// print_r($station)."<br>";
			if(array_search($om_line_station_update, $station) === false) {
				$theVariable = "not";
				// echo $theVariable."<br>";
			}else{
				$ctg_name = $station["l_name"];
				$om_line_station = $ctg_name."&nbsp;".$om_line_station_update;
				// echo $om_line_station;
				$theVariable = "sure";
				// echo $theVariable."<br>";
				$a = 1;
				break;
			}
		}
	}
}


$mbs_id = Post('mbs_id', 'null');
$om_id = Post('om_id', 'null');
// echo $mbs_id."<br>";
// echo $om_id."<br>";
// echo $ctg_name."<br>";
// echo $om_line_station_update."<br>";
// echo $a."<br>";

if($a == 0){
	echo "<script>alert('입력을 잘못하셨거나 없는 역을 입력하셨습니다.');</script>";
	echo "<script>location.replace('./My_one_page.php');</script>";
	exit;
}else{
	if($mbs_id != "null"){
		// echo $mbs_id."<br>";
		// echo $om_id."<br>";
		// echo $om_line_station."<br>";
		// echo "mb"."<br>";
		$dao = new Member();
		$dao->mbom_line_station_update($om_id,$mbs_id,$om_line_station);
		echo "<script>location.href='My_one_page.php';</script>";
		// echo "<script>location.replace('./member_update.php');</script>";
	}elseif($om_id != "null"){
		// echo $mbs_id."<br>";
		// echo $om_id."<br>";
		// echo $om_line_station."<br>";
		// echo "om"."<br>";
		$dao = new Oauths();
		$dao->mbom_line_station_update($om_id,$mbs_id,$om_line_station);
		echo "<script>location.href='My_one_page.php';</script>";
	}else{
		echo $mbs_id."<br>";
		echo $om_id."<br>";
		echo $om_line_station."<br>";
	}
}
?>
