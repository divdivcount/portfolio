<?php
/*
FileName: contents.php
Modified Date: 20190902
Description: 메인 및 서브
*/
// Load Modules
require_once($_SERVER['DOCUMENT_ROOT'].'/modules/module_protect.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/modules/parameter.php');

// Parameter
$page = Get('p', 0);

// Functions

// Process
if(file_exists($_SERVER['DOCUMENT_ROOT'].'/modules/content/'.$page.'.init.php')) {
  require($_SERVER['DOCUMENT_ROOT'].'/modules/content/'.$page.'.init.php');
}
?>
