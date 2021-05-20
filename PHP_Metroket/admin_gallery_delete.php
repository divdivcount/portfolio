<?php
// Load Modules
require_once("modules/admin.php");
// Parameter
$ids = Post('id', null);

// Functions

// Process
try {
  $galleryObj = new Gallery();
  if($ids) {
    foreach ($ids as $id) {
      $galleryObj->Gallery_Delete($id);
    }
  }
} catch (Exception $e) {
  echo $e->getMessage();
  exit();
}
userGoNow('admin_gallery_list.php');
?>
