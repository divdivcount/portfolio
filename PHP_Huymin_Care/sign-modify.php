<?php
/*
FileName: sign-modify.php
Modified Date: 20190925
Description: 관리자 비밀번호 변경
*/

// Load Modules
require_once('modules/error.php');
require_once('modules/notification.php');
require_once('modules/db.php');
require_once('modules/admin.php');

// Parameter

// Functions

// Process
$loginObj = new YoYangLogin($DBconfig['dburl'], $DBconfig['dbid'], $DBconfig['dbpw'], $DBconfig['dbtable'], $DBconfig['dbtype']);
?>
<!DOCTYPE html>
<html lang="ko" dir="ltr">
  <head>
    <?php require_once('modules/form_head.php'); ?>
    <title></title>
    <link rel="stylesheet" href="/css/administrator.css">
  </head>
  <body>
    <?php require_once('modules/form_navigation.php'); ?>
	 <header>
      <h1>비밀번호 변경</h1>
    </header>
    <main>
      <form class="sign_pw_bg" action="sign-pwchange.php" method="post">
        <div class="sign_pw">
          <div class="sign_box">
        <div class="textbox">
            <input type="password" placeholder="현재 비밀번호" name="old">
        </div>
          <br>
        <div class="textbox">
          <input type="password" placeholder="새 비밀번호" name="new">
        </div>
          <br>
        <div class="textbox">
          <input type="password" placeholder="새 비밀번호 확인" name="newre">
        </div>
          <br>
        <button type="submit" class="btn" value="">변경하기</button>
        </div>
      </div>
      </form>
    </main>
  </body>
</html>
