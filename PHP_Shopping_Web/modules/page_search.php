<?php
	try {
			// $start_s_value = empty($_REQUEST["start_s_value"]) ? "" : $_REQUEST["start_s_value"];
		  $s_value = empty($_REQUEST["s_value"]) ? "" : $_REQUEST["s_value"];
			// if($start_s_value){
			// 	$result = $dao->SelectPageLength($pid, 10, $s_value, $start_s_value);
			//   $list = $dao->SelectPageList($result['current'], 10,$s_value, $start_s_value);
			// }else{
			$result = $dao->SelectPageLength($pid, 10, $s_value);
			$list = $dao->SelectPageList($result['current'], 10,$s_value);
		// }
	} catch (PDOException $e) {
	  $result = null;
	  $list = null;
	 echo $e->getMessage();
	}
?>
