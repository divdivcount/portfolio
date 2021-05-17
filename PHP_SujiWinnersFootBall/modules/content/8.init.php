<?php require_once($_SERVER['DOCUMENT_ROOT'].'/modules/module_protect.php'); ?>
<?php $pagename = '풋볼 플레이 영상'; ?>
<?php
// Load Modules
require_once('modules/notification.php');
require_once('modules/db.php');
require_once('modules/error.php');

// Parameter
$id = Get('id', null);

// Functions

// Process
if(!$id) {
  userGoNow('?p=9');
  exit(0);
}
try {
  $boardObj = new YoYangVideoBoard($DBconfig['dburl'], $DBconfig['dbid'], $DBconfig['dbpw'], $DBconfig['dbtable'], $DBconfig['dbtype']);
  $post = $boardObj->SelectId($id);
  $boardObj->execHits($id);
}
catch (CommonException $e) {
  userGoto($e->getMessage(), '');
  exit(0);
}
catch (Exception $e) {
  userGoto('게시판이 작동하지 않습니다.', '');
  exit(0);
}
?>
