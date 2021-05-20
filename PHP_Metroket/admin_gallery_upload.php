<?php
// Load Modules
require_once("modules/admin.php");
// Parameter
$descriptions = Post('names', null);

// Functions

// Process
try {
  $galleryObj = new Gallery;
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
userGoNow('admin_gallery_list.php');
?>
