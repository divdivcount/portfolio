<?php
  // Load Modules
    require_once('modules/db.php');
    if(empty($_SESSION['ss_mb_id'])){
      echo "";
    }else{
      $mb_id = $_SESSION['ss_mb_id'];
      $sql = " select * from member where mb_id = TRIM('$mb_id') ";
      $result = mysqli_query($conn, $sql);
      $mb = mysqli_fetch_assoc($result);
      mysqli_close($conn); // 데이터베이스 접속 종료
    }
    // //회원 등급 표시
    // $m_dao = new ProDAO();
    // $m_result = $m_dao ->UserSelectAll($mb["mb_num"]);
    // //회원 배송 카운트
    // $b_dao = new Pay_history();
    // $b_result = $b_dao->BesongSelectAll($mb["mb_num"]);
    // foreach ($b_result as $b_row) {
    // }
    // $c_dao = new Consulting();
    // $c_result=$c_dao->Consulting_Member_Search($mb["mb_num"]);
    // foreach ($c_result as $row) {
    // }
if(empty($mb_id)){
?>
<script type="text/javascript">
  alert("로그인이 필요합니다.");
  location.href = "login.php";
</script>
<table>
  <tr>
    <td style="width:200px; height:83px;">
      <a href="index.php"><img src="files/logo/logo.png" width="100%" height="64px;"/></a>
    </td>
      <?php
          if(isset($mb['mb_num'])){
          }else {
            echo "<td style='float:right; margin-top:20px;'><a href='./login.php'>login</a></td>";
          }
       ?>
  </tr>
</table>
<?php
}else{
?>
<?php
//회원 등급 표시
$m_dao = new ProDAO();
$m_result = $m_dao ->UserSelectAll($mb["mb_num"]);
//회원 배송 카운트
$b_dao = new Pay_history();
$b_result = $b_dao->BesongSelectAll($mb["mb_num"]);
foreach ($b_result as $b_row) {
}
$c_dao = new Consulting();
$c_result=$c_dao->Consulting_Member_Search($mb["mb_num"]);
foreach ($c_result as $row) {
}
if(empty($m_result)){
  $m_rating="";
}else{
  foreach ($m_result as $m_row){
    $mb_p_num = $m_row["p_num"];
    // echo "<br>".$m_rating."<br>";
    // echo "<br>".$mb_p_num."<br>";
  }
}
$ms_dao = new Pay_history();
$ms_result = $ms_dao -> GoSelectAll($mb["mb_num"]);
if(empty($ms_result)){
  $u_total_rating_name = empty($u_total_rating_name) ? "12" : $u_total_rating_name;
  $mbs_num = empty($mbs_num) ? "" : $mbs_num;
}else{
foreach ($ms_result as $m_row) {
	$mbs_num = $m_row["mb_num"];
	$mbs_rating = $m_row["mem_rating_num"];
	// $mb_p_num = $m_row["pr_num"];
}
// echo $mbs_rating."Goif<br>";
//맴버 테이블의 mb_num을 가져옴
// echo $mb["mb_num"]."mb 넘";
// echo $mbs_num."GoSelectAll<br>";

//paygo 에 있는 유저 아이디 값을 가져옴
$mss_dao = new Member();
// echo $mb["mb_num"];
$mss_result = $mss_dao ->Member_Search($mb["mb_num"]);
if($mss_result == ""){

}else{
  foreach ($mss_result as $mss_row) {
    $mbss_num = $mss_row["mb_num"];
  }
}

// echo $mbss_num."<br>";
// echo $mb_p_num."UserSelectAll<br>";
$mb_p_nums = empty($mb_p_num) ? "" : $mb_p_num;
if($mb_p_nums >= 1500000){
	$mb_rating = 1;
	// echo "<br>"."P";
}else if($mb_p_nums >= 999999){
	$mb_rating = 2;
	// echo "<br>"."G";
}else if($mb_p_nums > 50000){
	$mb_rating = 3;
  // echo "<br>"."S";
}else if($mbs_rating == 4){
	$mb_rating = 4;
	// echo "<br>"."I";
}else{

}
$mb_ratings = empty($mb_rating) ? "" : $mb_rating;
// echo "<br>".$mb_ratings."UserSelectAll 들어가는<br>";
$u_dao = new ProDAO();
$u_result = $u_dao ->UserSelectAll($mbs_num, $mb_ratings, $mb_p_nums);
foreach($u_result as $u_row){
  $u_total_rating_name = $u_row["mem_rating_name"];
  // echo "<br>".$u_row["p_num"]."<br>";
}
// echo  "<br>".$u_total_rating_name."등급";
}
?>
<!doctype html>
<html>
  <head>
    <?php require_once('modules/form_head.php'); ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
  </head>
  <body>
    <table>
      <tr>
        <td style="width:200px; height:83px;">
          <a href="index.php"><img src="files/logo/logo.png" width="100%" height="64px;"/></a>
        </td>
        <td style="float:right; margin-top:20px;"><?= $mb['mb_name']."님"."\t"?>&nbsp;<a href='./logout.php'>로그아웃</a></td>
      </tr>
    </table>
    <div class="u_main_wrap">
      <div class="u_nav">
        <div class="u_nav_Tocks">
          <h4>나의 Toks</h4>
        </div>
        <div class="u_nav_wrap">
            <ul>
              <li>
                <p style="font-weight:bold; margin-bottom:10px;">나의 쇼핑</p>
              </li>
              <li>
              <?php if(empty($mbss_num)){}else{if($mb["mb_num"] === $mbss_num){ ?>
              <a style="cursor:pointer;" class="clicker" onclick="changeIframeUrl('./User_rating.php?mb=<?=$mb['mb_id']?>&mb_rating=<?= $u_total_rating_name ?>&mb_p_num=<?= $mb_p_nums ?>')">나의 맴버쉽</a>
            <?php }else{} } ?>
              </li>
              <li>
                <a style="cursor:pointer;" class="clicker" onclick="changeIframeUrl('./User_basket.php')">장바구니</a>
              </li>
              <li>
                <a style="cursor:pointer;" class="clicker" onclick="changeIframeUrl('./User_payhistory.php')">구매목록</a>
              </li>
            </ul>
        </div>
        <div class="u_nav_wrap">
            <ul>
              <li>
                <p style="font-weight:bold; margin-bottom:15px;">나의 정보</p>
              </li>
              <li>
                <a style="cursor:pointer;" class="clicker" onclick="changeIframeUrl('./register.php?mode=modify')">회원정보수정</a>
              </li>
              <li>
                <a style="cursor:pointer;" class="clicker" onclick="changeIframeUrl('./User_leave.php?mb=<?=$mb['mb_id']?>')">회원탈퇴</a>
              </li>
            </ul>
        </div>
        <div class="u_nav_wrap">
            <ul>
              <li>
                <p style="font-weight:bold; margin-bottom:15px;">나의 문의</p>
              </li>
              <li>
                <a style="cursor:pointer;" class="clicker" onclick="changeIframeUrl('./User_consulting_user.php')">상담신청</a>
              </li>
            </ul>
        </div>
      </div>
      <div class="u_gnb">
        <div class="u_gnb_wrap">
          <h6>나의 등급</h6>
          <?php if($mb["mb_num"] === $mbs_num) : ?>
            <h3><?=$u_total_rating_name?></h3>
          <?php endif ?>
        </div>
        <div class="u_gnb_wrap">
          <h6>배송중</h6>
          <h3><?=$b_row["COUNT(DISTINCT(order_id))"]?></h3>
        </div>
        <div class="u_gnb_wrap">
          <h6>할인쿠폰</h6>
        </div>
        <div class="u_gnb_wrap">
          <h6>상담 신청</h6>
          <h3><?=$row["count(`statok`)"]?></h3>
        </div>
      </div>
    </div>
    <div class"u_iframe">
      <iframe id="main_frame" frameborder="0" align="left" src="./User_basket.php" height="800px" width="80%"></iframe>
    </div>
    <script>
    function changeIframeUrl(url){
      document.getElementById("main_frame").src = url;
    }
    $(document).ready(function(){
      $('.slider').slider();
    });
    </script>
  </body>
</html>
<?php
}
?>
