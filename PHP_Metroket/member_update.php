<?php
require_once("modules/db.php");
  if(empty($_SESSION['ss_mb_id']) && empty($_SESSION['naver_mb_id']) && empty($_SESSION['kakao_mb_id']) ){
    echo "<script>alert('로그인을 해주세요');</script>";
    echo "<script>location.replace('./index.php');</script>";
  }else{
?>
<?php
if(isset($_SESSION['ss_mb_id'])){
  $mb_ids = $_SESSION['ss_mb_id'];
  $sql = " SELECT * FROM member WHERE mb_id = '$mb_ids' ";
  $result = mysqli_query($conn, $sql);
  $mb = mysqli_fetch_assoc($result);
  $mb_id = $mb['mb_num'];
  // echo  $mb_id;
}elseif(isset($_SESSION['naver_mb_id'])){
  $mb_ids = $_SESSION['naver_mb_id'];
  $mb_ids = substr($mb_ids, 5);
  $sql = " SELECT * FROM oauth_member WHERE om_id = $mb_ids ";
  $result = mysqli_query($conn, $sql);
  $om = mysqli_fetch_assoc($result);
  $mb_id = $om['om_id'];
  // echo  $mb_id;
}elseif(isset($_SESSION['kakao_mb_id'])){
  $mb_ids = $_SESSION['kakao_mb_id'];
  $mb_ids = substr($mb_ids, 5);
  $sql = " SELECT * FROM oauth_member WHERE om_id = $mb_ids ";
  $result = mysqli_query($conn, $sql);
  $om = mysqli_fetch_assoc($result);
  $mb_id = $om['om_id'];
  // echo  $mb_id;
}else{
  ?>
  <script>
    alter("어느것도 로그인되지 않았습니다.");
    location.replace("./index.php");
  </script>
  <?php
}
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="css/css_select_station.css">
<link rel="stylesheet" href="css/css_my_one_page.css">
<link rel="stylesheet" href="css/css_member_update.css">
<link rel="stylesheet" href="css/css_noamlfont.css">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://unpkg.com/hangul-js" type="text/javascript"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
</head>
<body>
<?php
// echo $mb["mb_id"] ? $mb["mb_id"] : $om["om_id"];
// echo $mb["mb_name"] ? $mb["mb_name"] : $om["om_nickname"];
// echo $mb["mb_email"] ? $mb["mb_email"] : $om["om_email"];
?>

<div class="w3-container">
  <h3 class="h3">회원정보 수정</h3>

  <form id="pwForm" name="frm1" class="p_container_margin" action="register_update.php" method="post">
    <div id="userInfo_box">

      <span>아이디<input type="hidden" name="mode" value="modify"></span>
      <input class="input_id" type="text" id="id" name="id" readonly value="<?= $mb["mb_id"] ? $mb["mb_id"] : $om["om_id"] ?>">

      <label><span class="blue">*</span>현재 비밀번호</label>
      <input class="input_password" id="old_pw" name="old_pw" type="password" <?php echo ($mb["mb_id"] ? "" : "readonly") ?> required >

      <label><span class="blue">*</span>새 비밀번호</label>
      <input class="input_new_password" name="mb_password" type="password" <?php echo ($mb["mb_id"] ? "" : "readonly") ?> required>

      <label><span class="blue">*</span>비밀번호 확인</label>
      <input class="input_new_exisit_password" name="mb_password_re" type="password" <?php echo ($mb["mb_id"] ? "" : "readonly") ?> required>

      <label>이름</label>
      <input class="input_name" type="text" id="name" name="mb_name" value="<?=$mb["mb_name"] ? $mb["mb_name"] : $om["om_nickname"] ?>"  readonly required>

      <label>이메일</label>
      <input class="input_email" type="text" id="email" name="mb_email" value="<?=$mb["mb_email"] ? $mb["mb_email"] : $om["om_email"] ?>"  readonly required>

      <label><span class="blue">*</span>주변 역 설정하기</label>
      <div id="station" style="display:flex;"><input class="input_station" type="text" id="pw2" value="<?=$mb['line_station'] ? $mb['line_station'] : $om['line_station']?>" required>
      <input class="w3-button w3-light-gray w3-round" type="button" id="selectStation_openBtn" value="역 검색"> </div>


      </div>
    </form>
    <p class="w3-center button_contatiner_margin">
      <button class="w3-button  w3-blue w3-ripple w3-margin-top w3-round" onclick="document.getElementById('pwForm').submit();">회원정보수정</button>
      <button type="button" class="w3-button w3-dark-gray w3-ripple w3-margin-top w3-round" onclick = "parent.changeIframeUrl('delete_userInfo.php?id= <?= $mb["mb_id"]?> &oid= <?= isset($om["om_id"]) ? $om["om_id"] : null ?> ')">회원 탈퇴</button>
    </p>

</div>
</body>
<script type="text/javascript">
  $(document).ready(function(){
    function selectStation_open() {
      parent.document.querySelector(".my_one_page_modal").classList.remove("hidden");
      parent.document.querySelector(".selectStation_modalBox").classList.remove("hidden");
      // parent.document.body.style.backgroundColor = "rgba(0, 0, 0, 0.6)";
    }
    document.getElementById("selectStation_openBtn").addEventListener("click", selectStation_open);
  });

</script>
</html>
<?php } ?>
