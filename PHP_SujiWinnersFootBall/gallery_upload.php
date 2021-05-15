<?php
/*
FileName: gallery_upload.php
Modified Date: 20190905
Description: 사진 업로드
*/
// Load Modules
require_once("modules/error.php");
require_once("modules/notification.php");
require_once("modules/db.php");
require_once("modules/admin.php");

// Parameter
$descriptions = Post('names', null);

// Functions

// Process
try {
  $galleryObj = new YoYangGallery($DBconfig['dburl'], $DBconfig['dbid'], $DBconfig['dbpw'], $DBconfig['dbtable'], $DBconfig['dbtype']);
  if($descriptions) {
    for($i=0; $i<count($_FILES['files']['name']); $i++) {
      if($_FILES['files']['type'][$i] == 'image/jpeg' || $_FILES['files']['type'][$i] == 'image/png' || $_FILES['files']['type'][$i] == 'image/gif') {
        $galleryObj->Upload('files', $i, ['description'=>$descriptions[$i]]);
      }
    }
  }
} catch (Exception $e) {
  echo $e->getMessage();
  exit();
}
userGoNow('/gallery_list.php');
?>
