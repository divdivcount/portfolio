<?php
/*
FileName: gallery_download.php
Modified Date: 20190905
Description: ajax 사진 가져오기
*/
// Load Modules
require_once("modules/error.php");
require_once("modules/db.php");

// Parameter
$latest = Get('latest', 0);

// Functions

// Process
header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-cache');
if( preg_match("/MSIE*/", $_SERVER["HTTP_USER_AGENT"]) || preg_match("/Tridemt*/", $_SERVER["HTTP_USER_AGENT"])) {
  header('Content-Type: text/json');
}

try {
  $urls = array();
  $names = array();
  $loadSize = 8;
  $galleryObj = new YoYangGallery($DBconfig['dburl'], $DBconfig['dbid'], $DBconfig['dbpw'], $DBconfig['dbtable'], $DBconfig['dbtype']);
  $fetchAll = $galleryObj->SelectIdList($latest, $loadSize, 'description, fname, id');
  $latest = 0;
  $last = 0;
  foreach ($fetchAll as $fetch) {
    array_push($names, $fetch['description']);
    array_push($urls, $fetch['fname']);
    $latest = $fetch['id'];
  }
  $obj = $galleryObj->SelectAll('id', 'id='.($latest-1));

  $result = [
    'latest' => (int)$latest,
    'url' => $urls,
    'names' => $names,
    'len' => count($urls),
    'maxlen' => $loadSize,
    'last' => ($obj)?false:true
  ];

  echo json_encode2($result);
} catch (Exception $e) {
  exit();
}
?>
