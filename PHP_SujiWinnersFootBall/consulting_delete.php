<?php
/*
FileName: consulting_delete.php
Modified Date: 20190906
Description: 상담 기록 삭제(부적절한 기록 삭제에 유용)
*/
// Load Modules
require_once("modules/error.php");
require_once("modules/notification.php");
require_once("modules/db.php");
require_once("modules/admin.php");

// Parameter
$ids = Post('id', null);

// Functions

// Process
try {
  if($ids) {
    $consultObj = new YoYangConsulting($DBconfig['dburl'], $DBconfig['dbid'], $DBconfig['dbpw'], $DBconfig['dbtable'], $DBconfig['dbtype']);
    foreach ($ids as $id) {
      $consultObj->Delete($id);
    }
  }
} catch (Exception $e) {
  echo $e->getMessage();
  exit();
}
userGoNow('/consulting_list.php');
?>
