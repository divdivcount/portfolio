<?php
// Load Modules
require_once("modules/admin.php");
require_once('modules/cat.php');
// echo $cat = $_GET['var'];
// Parameter
$id = Get('id', 0);
$name = Post('name', null);
$manufacturer = Post('manufacturer', null);
$info = Post('info', null);
$date = Post('date', null);
$price = Post('price', null);
$ds='';
// Functions
// require_once('admin_upload.php');
// Process
try {
  if(!($name && $manufacturer && $info && $date && $price)) {
    userGoto('모든 입력란을 채워야 합니다.', '');
  }

  if((int)$id > 0) {
    $dao ->Modify($product, 'upload_file',0, $id ,['name' => $name ,'manufacturer' => $manufacturer, "info" => $info, "date" => $date, "price" => $price]);
    userGoto('수정이 완료되었습니다.', "admin_list.php?var=$link");
  }
  else {

  }
}
catch (PDOException $e) {
  userGoto('데이터베이스가 작동하지 않습니다:'.$e->getMessage(), '');
}
catch (Exception $e) {
  userGoto($e->getMessage(), '');
}
?>
