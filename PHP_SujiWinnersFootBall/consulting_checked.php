<?php
/*
FileName: consulting_checked.php
Modified Date: 20190906
Description: 상담 완료 처리로 변경
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
      $consultObj->Modify($id, ['statok'=>true , 'dtok'=>date('Y-m-d H:i:s')]);
    }
  }
} catch (Exception $e) {
  echo $e->getMessage();
  exit();
}
userGoNow('/consulting_list.php');
?>
