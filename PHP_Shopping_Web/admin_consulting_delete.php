<?php
// Load Modules
require_once("modules/admin.php");

// Parameter
$ids = Post('id', null);
$sc_id = Post('sc_id',null);
echo $sc_id;
// Functions

// Process
try {
  if($ids) {
    $consultObj = new Consulting();
    foreach ($ids as $id) {
      $consultObj->Delete($id);
    }
  }
} catch (Exception $e) {
  echo $e->getMessage();
  exit();
}
userGoNow('admin_consulting_list.php');
?>
