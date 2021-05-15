<?php
// Load Modules
require_once("modules/admin.php");
$id = Post('id', null);
// echo $id;
// Functions
// Process
try {
	require_once('modules/cat.php');
	if(is_array($id)) {
		foreach ($id as $id) {
			$result = $dao->Delete($id);

		}
	}
	userGoNow("admin_list.php?var=$link");
}
catch (PDOException $e) {
	userGoto('데이터베이스가 작동하지 않습니다.', '');
}
catch (Exception $e) {
	userGoto($e->getMessage(), '');
}
?>
