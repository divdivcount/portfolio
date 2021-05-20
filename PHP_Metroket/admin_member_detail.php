<?php
  require_once("modules/admin.php");

  $member_id = Post('id', null);
  $oauth_id = Post('om', null);
  $name = Get('all', null);
  $mb_om = Get('mball', null);

  if($member_id != null){
    $dao = new Member();
    $member = $dao->admin_Member_all_select($member_id);
  }elseif($oauth_id != null){
    $dao = new Oauths();
    $other_member = $dao->admin_Om_select($oauth_id);
  }elseif ($name != null && $mb_om != null) {
    $dao = new Member();
    $listc = $dao->admin_Member_Search($name, $mb_om);
  }else{
    // echo "오류가 발생";
  }
  $list_all = (isset($member) ? ($member ? $member : null) :
              (isset($other_member) ? ($other_member ? $other_member : null) :
              (isset($listc) ? ($listc ? $listc : null) : "값이 없습니다.")));
// var_dump($list_all);
if(!(is_null($listc))){
  $dao = new Oauths;
  // echo $listc[0]['mb_id'];
  $other_member = $dao->admin_Om_select($listc[0]['mb_id']);
  // var_dump($other_member);
  if(is_null($other_member)){
        $dao = new Member();
        $member  = $dao->admin_Member_id_all_select($listc[0]['mb_id']);
        // var_dump($member);
  }else{
      // echo "??";
  }
}else{
  $listc = null;
}
  // var_dump($list_all)."<br>";
  // echo $member_id."<br>";
  // echo $oauth_id."<br>";
  if(isset($_SESSION['ss_mb_id']) && $_SESSION['ss_mb_id'] !== 'admin'){
    echo "<script>alert('로그인을 해주세요');</script>";
    echo "<script>location.replace('./index.php');</script>";
    exit;
  }

?>
<!DOCTYPE html>
<html lang="ko" dir="ltr">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="css/admin_member_detail.css">
</head>
<body>
  <?php foreach ($list_all as $row):?>
  <?php
      // echo "--------------------------------------------<br>";
      //   var_dump(strpos($row["mb_image"], "http"));
      // echo "--------------------------------------------<br>";
      ?>
  <div class="member-container">
    <!-- 유저 프로필 뽑히는 곳 -->
    <div class="member-content">
      <img
        src="<?= isset($row["mb_image"]) ? ($row["mb_image"] != "img/normal_profile.png" ? (strpos($row["mb_image"], "http") === 0 ? $row["mb_image"] : "files/".$row["mb_image"]) : $row["mb_image"]) : $row["om_image_url"] ?>">
      <span class="content-info">
        <ul>
          <li>이름</li>
          <li>이메일</li>
          <li>주변 역</li>
          <li>신고 수</li>
          <li>경고 수</li>
        </ul>
        <ul>
          <li><?= isset($row["mb_name"]) ? $row["mb_name"] : $row["om_nickname"] ?></li>
          <li><?= isset($row["mb_email"]) ? $row["mb_email"] : $row["om_email"]?></li>
          <li><?=$row["line_station"]?></li>
          <li><?=$row["rep_count"]?></li>
          <li><?=$row["warning_count"]?></li>
        </ul>
      </span>
    </div>
    <!-- 버튼 제어 하는 곳 -->
    <div class="member-button">
      <form method="post">
        <input type="hidden" name="mem_id" value="<?=isset($row["mb_id"]) ? $row["mb_id"] : null ?>">
        <input type="hidden" name="mom_id" value="<?=isset($row["om_id"]) ? $row["om_id"] : null ?>">
        <input type="hidden" name="gap"
          value="<?= (isset($row["mb_block"]) ? $row["mb_block"] : $row["om_block"] ) == 'n' ? 'y' : 'n' ?>">
        <input type="submit" name="mem_block" id="mem_block"
          value="<?= (isset($row["mb_block"]) ? $row["mb_block"] : $row["om_block"] ) == 'n' ? '차단하기' : '차단해체' ?>" />
      </form>
      <form method="post">
        <input type="hidden" name="mem_id" value="<?=isset($row["mb_id"]) ? $row["mb_id"] : null ?>">
        <input type="hidden" name="mom_id" value="<?=isset($row["om_id"]) ? $row["om_id"] : null ?>">
        <input type="submit" name="warning_send" id="warning_send" value="경고 보내기" />
      </form>
    </div>
    <!-- 해당 회원 게시글 나오는 곳 -->
    <div class="member-board">
      <iframe width="100%" height="100%" src="admin_member_detail_sangpum.php?id=<?=isset($member[0]["mb_id"]) ? $member[0]["mb_id"] : 'null'?>&om=<?=isset($other_member[0]["om_id"]) ? $other_member[0]["om_id"] : 'null'?>" frameborder="0" style="float:left;" id="main_frame" 
        ></iframe>
    </div>
  </div>
  <?php endforeach ?>
  <?php
  //맴버 차단
      function mem_block(){
        $mem_id = Post("mem_id",null);
        $om_id = Post('mom_id', null);
        $gap = Post("gap",null);
        // echo $mem_id;
        // echo $om_id;
        // echo $gap;
        //쿼리 짜고 함수 지정
        if(!(is_null($mem_id))){
          $dao = new Member;
          $member = $dao->admin_Member_id_all_select($mem_id);
          // var_dump($member);
          if(is_null($member)){
            // echo "이곳과";
            $dao = new Oauths;
            $other_member = $dao->admin_Om_select($mem_id);
            $dao->admin_Om_block($other_member[0]["om_id"], $gap);
          }else{
            // echo "이곳";
            $dao->admin_mb_block($member[0]["mb_id"], $gap);
          }
        }elseif (!(is_null($om_id))) {
          // echo "저곳";
          $dao = new Oauths;
          $oauth = $dao->admin_Om_select($om_id, $gap);
          $dao->admin_Om_block($oauth[0]["om_id"], $gap);
        }
      }
      if(array_key_exists('mem_block',$_POST))
      {
        $gap = Post("gap",null);
        mem_block();
          if($gap == 'y'){
            userGotoGo("회원을 차단 하셨습니다", "");
          }else{
            userGotoGo("회원을 차단해체 하셨습니다", "");
          }
      }
      //경고 보내기
      function warning_send(){
        $mem_id = Post("mem_id",null);
        $om_id = Post('mom_id', null);
        $admin = "admin";
        $time = date("Y-m-d H:i:s");
        $recive = '0000-00-00 00:00:00';


        //쿼리 짜고 함수 지정
        if(!(is_null($mem_id))){
          $dao = new Member;
          $member = $dao->admin_Member_id_all_select($mem_id);
          // var_dump($member);
          if(is_null($member)){
            // echo "이곳과";

            $dao = new Oauths;
            $other_member = $dao->admin_Om_select($mem_id);
            $warning_count =  $other_member[0]['warning_count']+1;
            // echo $warning_count;
            $memo_text = "고객님의 현재 경고를 받은 수는".$warning_count."개 입니다.\n불 합리하다 생각하신다면 실시간 상담을 통하여 메세지를 보내주세요.";
            $dao->admin_om_waring_send($other_member[0]["om_id"], $admin, $time, $recive,$memo_text);
          }else{
            // echo "이곳";
            $warning_count =  $member[0]['warning_count']+1;
            // echo $warning_count;
            $memo_text = "고객님의 현재 경고를 받은 수는".$warning_count."개 입니다.\n불 합리하다 생각하신다면 실시간 상담을 통하여 메세지를 보내주세요.";
            $dao->admin_waring_send($member[0]["mb_id"], $admin, $time, $recive,$memo_text);
          }
        }elseif (!(is_null($om_id))) {
          // echo "저곳";
          $dao = new Oauths;
          $oauth = $dao->admin_om_waring_send($om_id, $admin, $time, $recive,$memo_text);
        }
      }
      if(array_key_exists('warning_send',$_POST))
      {
        warning_send();
        userGoto("경고 메세지를 보내셨습니다", "");
      }
    ?>
</body>

</html>
