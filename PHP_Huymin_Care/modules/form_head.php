<?php
/*
FileName: form_head.php
Modified Date: 20190902
Description: 폼: 헤더
*/
// Load Modules
require_once($_SERVER['DOCUMENT_ROOT'].'/modules/module_protect.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/modules/form_check.php');

// Parameter

// Functions

// Process
?>
<?php if(UserPage()) : ?>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
  <script src="script/navigation.js"></script>
  <link href="css/css_sub2.css" rel="stylesheet" type="text/css">
  <link href="css/size1366.css" rel="stylesheet" type="text/css" media="screen and (max-width: 1366px)">
  <link href="css/size600.css" rel="stylesheet" type="text/css" media="screen and (max-width: 900px)">
<?php elseif(AdminPage()) : ?>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
  <link href="/css/administrator.css" rel="stylesheet" type="text/css">
<?php endif ?>
<!-- <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script> -->
