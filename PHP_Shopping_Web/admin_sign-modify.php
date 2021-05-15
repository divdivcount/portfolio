<?php
// Load Modules

require_once("modules/admin.php");
// Parameter

// Functions

// Process
$loginObj = new ProLogin();
?>
<!DOCTYPE html>
<html lang="ko" dir="ltr">
  <head>
    <title></title>
    <?php require_once('modules/form_head.php'); ?>
  </head>
  <body>
    <main>
      <form class="sign_pw_bg" action="admin_sign-pwchange.php" method="post">
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
        <button type="submit" class="" value="">변경하기</button>
        </div>
      </div>
      </form>
    </main>
  </body>
</html>
