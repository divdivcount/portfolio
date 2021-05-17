<?php
/*
FileName: form_check.php
Modified Date: 20190923
Description: 폼: 페이지 체커
*/

// Load Modules
require_once($_SERVER['DOCUMENT_ROOT'].'/modules/module_protect.php');

// Parameter

// Functions
function UserPage() {
  $list = [
    '/sub.php', '/consulting_upload.php', '/gallery_download.php'
  ];
  foreach ($list as $file) {
    if($_SERVER['DOCUMENT_ROOT'].$file == $_SERVER['SCRIPT_FILENAME']) {
      return true;
    }
  }
  return false;
}

function AdminPage() {
  $list = [
    '/board_delete.php', '/board_list.php', '/board_write.php',
    '/board_writeok.php','/video_board_delete.php', '/video_board_list.php', '/video_board_write.php',
    '/video_board_writeok.php', '/calendar_list.php', '/calendar_update.php',
    '/consulting_checked.php', '/consulting_delete.php', '/consulting_list.php',
    '/consulting_upload.php', '/dashboard.php', '/gallery_delete.php',
    '/gallery_list.php', '/gallery_modify.php', '/gallery_upload.php',
    '/sign-modify.php'
  ];
  foreach ($list as $file) {
    if($_SERVER['DOCUMENT_ROOT'].$file == $_SERVER['SCRIPT_FILENAME']) {
      return true;
    }
  }
  return false;
}

// Process

?>
