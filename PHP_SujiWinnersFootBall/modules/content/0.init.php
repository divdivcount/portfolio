<?php require_once($_SERVER['DOCUMENT_ROOT'].'/modules/module_protect.php'); ?>
<?php $pagename = 'index'; ?>
<?php
// Load Modules
require_once('modules/error.php');
require_once('modules/notification.php');
require_once('modules/db.php');

// Parameter

// Functions

// Process
$boardObj = new YoYangBoard($DBconfig['dburl'], $DBconfig['dbid'], $DBconfig['dbpw'], $DBconfig['dbtable'], $DBconfig['dbtype']);
try {
  $result = $boardObj->SelectPageLength(1, 5);
  $list = $boardObj->SelectPageList($result['current'], 5);
} catch (Exception $e) {
  $result = null;
  $list = null;
  echo $e->getMessage();
}
$galleryObj = new YoYangGallery($DBconfig['dburl'], $DBconfig['dbid'], $DBconfig['dbpw'], $DBconfig['dbtable'], $DBconfig['dbtype']);
try {
  $result2 = $galleryObj->GalleryListFive();
} catch (Exception $e) {
  echo $e->getMessage();
}
?>
