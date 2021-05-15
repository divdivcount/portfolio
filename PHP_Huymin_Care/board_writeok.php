<?php
/*
FileName: board_writeok.php
Modified Date: 20190902
Description: 게시글 등록 프로세스
*/
// Load Modules
require_once('modules/error.php');
require_once('modules/notification.php');
require_once('modules/db.php');
require_once('modules/admin.php');

// Parameter
$id = Get('id', 0);
//$pname = Post('name', null);
//$ppw = Post('pw', null);
$pcontent = Post('content', null);
$ptitle = Post('title', null);

// Functions

// Process
try {
  if(!($pcontent && $ptitle)) {
    userGoto('모든 입력란을 채워야 합니다.', '');
  }

  $boardObj = new YoYangBoard($DBconfig['dburl'], $DBconfig['dbid'], $DBconfig['dbpw'], $DBconfig['dbtable'], $DBconfig['dbtype']);
  if((int)$id > 0) {
    $boardObj->Modify($id, ['title'=>$ptitle,'content'=>$pcontent]);
    userGoto('수정이 완료되었습니다.', '/board_list.php');
  }
  else {
    $boardObj->Upload('upload_file', 0, ['name'=>'','pw'=>'','title'=>$ptitle,'content'=>$pcontent,'date'=>date('Y-m-d')]);
    userGoto('작성 완료되었습니다.', '/board_list.php');
  }
}
catch (PDOException $e) {
  userGoto('데이터베이스가 작동하지 않습니다:'.$e->getMessage(), '');
}
catch (Exception $e) {
  userGoto($e->getMessage(), '');
}
?>
