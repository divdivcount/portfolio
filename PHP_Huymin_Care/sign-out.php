<?php
/*
FileName: sign-pwchange.php
Modified Date: 20190925
Description: 로그인 비밀번호 변경
*/

// Load Modules
require_once('modules/notification.php');

// Parameter

// Functions

// Process
session_start();
session_destroy();
userGoNow('login.html');
?>
