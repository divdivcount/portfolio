<?php
/*
FileName: error.php
Modified Date: 20190902
Description: 리눅스 httpd에서 500 에러 대신 오류를 띄워줍니다.
*/
// Load Modules
require_once($_SERVER['DOCUMENT_ROOT'].'/modules/module_protect.php');

// Parameter

// Functions

// Process
error_reporting(E_ALL);
ini_set("display_errors", 1);
ini_set("display_startup_errors", 1);
?>
