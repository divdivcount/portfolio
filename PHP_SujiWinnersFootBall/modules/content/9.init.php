<?php require_once($_SERVER['DOCUMENT_ROOT'].'/modules/module_protect.php'); ?>
<?php $pagename = '동영상 갤러리'; ?>
<?php
// Load Modules
require_once('modules/error.php');
require_once('modules/notification.php');
require_once('modules/db.php');

// Parameter
$pid = Get('bp', 1);

// Functions

// Process
$boardObj = new YoYangVideoBoard($DBconfig['dburl'], $DBconfig['dbid'], $DBconfig['dbpw'], $DBconfig['dbtable'], $DBconfig['dbtype']);
try {
  $result = $boardObj->SelectPageLength($pid, 15);
  $list = $boardObj->SelectPageList($result['current'], 15);
} catch (Exception $e) {
  $result = null;
  $list = null;
  echo $e->getMessage();
}
?>
