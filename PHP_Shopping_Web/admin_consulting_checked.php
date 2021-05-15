<?php
// Load Modules
require_once("modules/admin.php");

// Parameter
$ids = Post('id', null);
// Functions

// Process
try {
  if($ids) {
    $consultObj = new Consulting();
    foreach ($ids as $id) {
      $consultObj->Modify('',null,'',$id,['statok'=>true , 'dtok'=>date('Y-m-d H:i:s')]);
    }
  }
} catch (Exception $e) {
  echo $e->getMessage();
  exit();
}
userGoNow('admin_consulting_list.php');
?>
