<?php
// Load Modules
require_once("modules/admin.php");
// Parameter
$id = Post('id', null);
$description = Post('description', null);

// Functions

// Process
try {
  $galleryObj = new Gallery;
  if($id && $description) {
    $galleryObj->Gallery_Modify($id, ['description' => $description]);
  }
  else {
    userGoto('잘못된 인수 전달.', '');
  }
} catch (Exception $e) {
  echo $e->getMessage();
  exit();
}
userGoNow('admin_gallery_list.php');
?>
