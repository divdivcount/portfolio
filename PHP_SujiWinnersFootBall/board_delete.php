<?php
/*
FileName: board_delete.php
Modified Date: 20190902
Description: 게시글 삭제 프로세스
*/
// Load Modules
require_once('modules/error.php');
require_once('modules/notification.php');
require_once('modules/db.php');
require_once('modules/admin.php');


// Parameter(idx)
$ids = Post('id', null);

// Functions

// Process
try {
	$boardObj = new YoYangBoard($DBconfig['dburl'], $DBconfig['dbid'], $DBconfig['dbpw'], $DBconfig['dbtable'], $DBconfig['dbtype']);
	if(is_array($ids)) {
		foreach ($ids as $id) {
			$result = $boardObj->Delete($id);
			echo $id.'<br>';
		}
	}
	userGoNow('/board_list.php');
}
catch (PDOException $e) {
	userGoto('데이터베이스가 작동하지 않습니다.', '');
}
catch (Exception $e) {
	userGoto($e->getMessage(), '');
}
?>
