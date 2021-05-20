<?php
// Load Modules
require_once('modules/db.php');
require_once('modules/notification.php');
?>
<?php
// NAVER LOGIN
 define('NAVER_CLIENT_ID', 'qFL1MdijiIfEemYxHv9a');
 //define('NAVER_CLIENT_SECRET', '클아이언트 시크릿');
 define('NAVER_CALLBACK_URL', 'https://metroket.kro.kr/naver_callback.php');
$naver_state = md5(microtime() . mt_rand());
$_SESSION['naver_state'] = $naver_state;
$naver_apiURL = "https://nid.naver.com/oauth2.0/authorize?response_type=code&client_id=".NAVER_CLIENT_ID."&redirect_uri=".urlencode(NAVER_CALLBACK_URL)."&state=".$naver_state;
// echo $_SESSION['naver_mb_id'];
?>
<?php
 $restAPIKey = "24c58b732b0414e7d5d850cdafc310b8"; //본인의 REST API KEY를 입력해주세요
 $callbacURI = urlencode("https://metroket.kro.kr/kakao_callback.php"); //본인의 Call Back URL을 입력해주세요
 $kakaoLoginUrl = "https://kauth.kakao.com/oauth/authorize?client_id=".$restAPIKey."&redirect_uri=".$callbacURI."&response_type=code";
?>
<?php if(!(isset($_SESSION['ss_mb_id'])|| isset($_SESSION['naver_mb_id'])|| isset($_SESSION['kakao_mb_id']))) { // 로그인 세션이 있을 경우 로그인 화면 ?>
  <form action="./login_check.php" method="post" class="container">
      <div class="login-box">
        <div id="logoimg_box"><img src="img/metrocket.png" alt=""></div>
        <div id ="login">회원로그인</div>
        <div class="textbox">
        <input type="text" placeholder="아이디" name="mb_id">
        </div>
      <div class="textbox">
        <input type="password" placeholder="비밀번호" name="mb_password">
      </div>

          <div class="submitBtn">
            <input type="submit" id ="loginbtn" value="로그인">
          </div>

          <a class="text_center" href="findIdPW.php">아이디 / 비밀번호 찾기</a>

          <div id="boundarybox">
            <div class="line"></div>
            <div style="width:20%;font-size:1.5rem;" >또는</div>
            <div class="line"></div>
          </div>

          <!-- 소셜 로그인 아이콘 부분 -->
          <div id="imgbox">
            <a href="<?=$naver_apiURL;?>"><img src="img/naver.png" style="width:5.0rem;height:5.0rem"></a>
            <a href="<?= $kakaoLoginUrl;?>"><img src="img/kakao.png"  style="width:5.0rem;height:5.0rem"></a>
            <!-- <img src="img/google.png" alt=""> -->
          </div>
          <a class="text_center" href="signup_agreement.php">아직 회원이 아니신가요? 회원가입</a>
        </div>
  </form>



<?php } else { // 로그인 세션이 없을 경우 로그인 완료 화면 ?>
  <?php
  if(isset($_SESSION['ss_mb_id'])) {
    $mb_id = $_SESSION['ss_mb_id'];
    $sql = " select * from member where mb_id = TRIM('$mb_id') ";
    $result = mysqli_query($conn, $sql);
    $mb = mysqli_fetch_assoc($result);
    // mysqli_close($conn); // 데이터베이스 접속 종료
  ?>
    <script type="text/javascript">
      document.querySelector(".modal_header").classList.add("hidden");
    </script>

  <?php
  }elseif(isset($_SESSION['naver_mb_id'])) {
    $naver_mb_id = $_SESSION['naver_mb_id'];
    echo "123";
    $sql = " select * from oauth_member where om_id = TRIM($naver_mb_id) ";
    $result = mysqli_query($conn, $sql);
    $naver = mysqli_fetch_assoc($result);
    // mysqli_close($conn); // 데이터베이스 접속 종료
    ?>
      <script type="text/javascript">
        document.querySelector(".modal_header").classList.add("hidden");
      </script>

    <?php
  }elseif (isset($_SESSION['kakao_mb_id'])) {
    $kakao_mb_id = $_SESSION['kakao_mb_id'];

    $sql = " select * from oauth_member where om_id = TRIM($kakao_mb_id) ";
    $result = mysqli_query($conn, $sql);
    $kakao = mysqli_fetch_assoc($result);

    // mysqli_close($conn); // 데이터베이스 접속 종료
    ?>
      <script type="text/javascript">
      document.querySelector(".modal_header").classList.add("hidden");
      </script>
    <?php
  }else{
    echo "통과하지 못했어";
  }
 } ?>
