<?php
/*
Description: 폼: 페이지 체커
*/

// Load Modules

// Parameter

// Functions
function UserPage() {
  $list = [
    '/ky_project/User_basket.php', '/ky_project/User_consulting_upload.php', '/ky_project/User_cart.php',
    '/ky_project/User_changeqty.php','/ky_project/User_consulting_user.php','/ky_project/User_list.php','/ky_project/index.php',
    '/ky_project/login.php','/ky_project/User_payhistory.php','/ky_project/register.php','/ky_project/User_page.php','/ky_project/User_rating.php'

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
    '/ky_project/admin_index.php', '/ky_project/admin_list.php', '/ky_project/admin_login.php',
    '/ky_project/admin_consulting_list.php', '/ky_project/admin_calendar_list.php', '/ky_project/admin_calendar_update.php',
    '/ky_project/admin_consulting_checked.php', '/ky_project/admin_consulting_delete.php', '/ky_project/consulting_list.php',
    '/ky_project/admin_consulting_upload.php','/ky_project/admin_gallery_delete.php',
    '/ky_project/admin_gallery_list.php', '/ky_project/admin_gallery_modify.php', '/ky_project/admin_gallery_upload.php',
    '/ky_project/admin_sign-modify.php', '/ky_project/admin_delivery.php','/ky_project/admin_ProductWrite.php'
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
