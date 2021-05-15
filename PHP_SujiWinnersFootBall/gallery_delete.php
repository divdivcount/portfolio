<?php
/*
FileName: gallery_delete.php
Modified Date: 20190905
Description: 사진 삭제
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
  $galleryObj = new YoYangGallery($DBconfig['dburl'], $DBconfig['dbid'], $DBconfig['dbpw'], $DBconfig['dbtable'], $DBconfig['dbtype']);
  if($ids) {
    foreach ($ids as $id) {
      $galleryObj->Delete($id);
    }
  }
} catch (Exception $e) {
  echo $e->getMessage();
  exit();
}
userGoNow('/gallery_list.php');
?>
