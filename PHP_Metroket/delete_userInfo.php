<?php
  require_once("modules/db.php");
  $mb_id = Get("id", 'null');
  $om_id = Get("oid", 'null');
  // echo $mb_id;
  // echo $om_id;
  $reasons = new Reasons;
  $reasons_del = $reasons->Reason_select();
  /* ky : 내일 작업 예정입니다 건들지 말아주세요*/
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="css/css_my_one_page.css">
    <link rel="stylesheet" href="css/css_noamlfont.css">
    <link rel="stylesheet" href="css/css_delete_userInfo.css">

  </head>
  <body>
    <div class="w3-container">

      <!-- 로고이미지 부분 -->
      <div id="logoimg_box">
        <img src="img/metroket_blue.png" alt="">
      </div>

      <!-- 경고 문구 제목 -->
      <h3>회원탈퇴 시 메트로켓에서 만들어진 모든 데이터는 삭제됩니다.</h3>

      <!-- 탈퇴시 내용  -->
      <p>
        정말로 탈퇴 하시겠습니까?<br>
        탈퇴 후 개인정보는 바로 삭제됩니다.
      </p>

      <form class="" action="mb_del_check.php" method="post">
        <input type="hidden" name="mb_id" value="<?=$mb_id?>">
        <input type="hidden" name="om_id" value="<?=$om_id?>">
      <!-- 탈퇴사유 선태 select 박스 -->
      <div id="select_box">

        <select class="w3-select" name="sau">
          <?php foreach ($reasons_del as $reasons_a) :?>
          <option value="<?=$reasons_a["reason_id"]?>"><?=$reasons_a["reasons_string"]?></option>
          <?php endforeach ?>
        </select>

      </div>
      <div id="btn_box">
        <input type="submit" name="" value="탈퇴하기">
        <input type="button" name="" value="뒤로" onclick = "parent.changeIframeUrl('member_update.php')">
      </div>

      </form>

    </div>
  </body>
  <script type="text/javascript">

  </script>
</html>
