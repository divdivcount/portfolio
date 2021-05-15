<?php
/*
FileName: gallery_modify.php
Modified Date: 20190905
Description: 사진 설명 변경
*/
// Load Modules
require_once("modules/error.php");
require_once("modules/notification.php");
require_once("modules/db.php");
require_once("modules/admin.php");

// Parameter
$id = Post('id', null);
$description = Post('description', null);

// Functions

// Process
try {
  $galleryObj = new YoYangGallery($DBconfig['dburl'], $DBconfig['dbid'], $DBconfig['dbpw'], $DBconfig['dbtable'], $DBconfig['dbtype']);
  if($id && $description) {
    $galleryObj->Modify($id, ['description' => $description]);
  }
  else {
    userGoto('잘못된 인수 전달.', '');
  }
} catch (Exception $e) {
  echo $e->getMessage();
  exit();
}
userGoNow('/gallery_list.php');
?>
