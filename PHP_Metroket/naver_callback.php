<?php
 // NAVER LOGIN
require_once("modules/db.php");
require_once("modules/notification.php");
$oauth = new Oauths;
define('NAVER_CLIENT_ID', '');
define('NAVER_CLIENT_SECRET', '');
define('NAVER_CALLBACK_URL', 'https://metroket.kro.kr/naver_callback.php');
if ($_SESSION['naver_state'] != $_GET['state']) {
  // 오류가 발생하였습니다. 잘못된 경로로 접근 하신것 같습니다.
 } $naver_curl = "https://nid.naver.com/oauth2.0/token?grant_type=authorization_code&client_id=".NAVER_CLIENT_ID."&client_secret=".NAVER_CLIENT_SECRET."&redirect_uri=".urlencode(NAVER_CALLBACK_URL)."&code=".$_GET['code']."&state=".$_GET['state']; // 토큰값 가져오기
 $is_post = false; $ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $naver_curl);
curl_setopt($ch, CURLOPT_POST, $is_post);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec ($ch);
$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close ($ch);
if($status_code == 200) {
  $responseArr = json_decode($response, true);
  $_SESSION['naver_access_token'] = $responseArr['access_token'];
  $_SESSION['naver_refresh_token'] = $responseArr['refresh_token']; // 토큰값으로 네이버 회원정보 가져오기
  $me_headers = array( 'Content-Type: application/json', sprintf('Authorization: Bearer %s', $responseArr['access_token']) );
  $me_is_post = false;
  $me_ch = curl_init();
  curl_setopt($me_ch, CURLOPT_URL, "https://openapi.naver.com/v1/nid/me");
  curl_setopt($me_ch, CURLOPT_POST, $me_is_post);
  curl_setopt($me_ch, CURLOPT_HTTPHEADER, $me_headers);
  curl_setopt($me_ch, CURLOPT_RETURNTRANSFER, true);
  $me_response = curl_exec ($me_ch); $me_status_code = curl_getinfo($me_ch, CURLINFO_HTTP_CODE);
  curl_close ($me_ch);
  $me_responseArr = json_decode($me_response, true);
  if ($me_responseArr['response']['id']) { // 회원아이디
    $mb_uid = $me_responseArr['response']['id']; // 회원가입 DB에서 회원이 있으면(이미 가입되어 있다면) 토큰을 업데이트 하고 로그인함

    $result = $oauth->Om_select($mb_uid);

    foreach ($result as $row) {
      $om_id = $row['om_id'];
      $om_token = $row['om_access_token'];
      $om_block = $row['om_block'];
    }
    if ($om_id == $mb_uid) {
      // $om_id == $mb_uid멤버 DB에 토큰값 업데이트
      // if($om_token != $responseArr['access_token']){
        //기존 데이터가 변경 될 수 있기 때문에 다시 불러 update 처리
        if($om_block === 'y'){
          echo "<script>alert('관리자로 인해 차단 당한 아이디 입니다.');</script>";
          echo "<script>location.replace('./index.php');</script>";
          exit;
        }
        $update = $oauth->Om_token_update($responseArr['access_token'], $mb_uid); // 로그인
      // }else{
      $mb_company = 'naver';
      $_SESSION['naver_mb_id'] = $mb_company.$mb_uid;
      if(isset($_SESSION['naver_mb_id'])) { // 세션이 있다면 로그인 확인 페이지로 이동
        echo "<script>alert('로그인 되었습니다.');</script>";
        echo "<script>location.replace('./index.php');</script>";
      }
      // }
    } // 회원정보가 없다면 회원가입
      else { // 회원아이디
      $mb_token = $responseArr['access_token'];
      $mb_uid = $me_responseArr['response']['id'];
      $mb_name = $me_responseArr['response']['name'];
      $mb_nickname = $me_responseArr['response']['nickname']; // 닉네임
      $mb_email = $me_responseArr['response']['email']; // 이메일
      $mb_profile_image = $me_responseArr['response']['profile_image']; // 프로필 이미지
      $mb_company = 'naver';
      // echo $mb_uid."<br>";
      // echo $mb_token."<br>";
      // echo $mb_name."<br>";
      // echo $mb_nickname."<br>";
      // echo $mb_email."<br>";
      // echo $mb_profile_image."<br>";
      $OauthObj = $oauth->Om_insert($mb_uid,$mb_token,$mb_nickname,$mb_email,$mb_profile_image,$mb_company);
      // 멤버 DB에 토큰과 회원정보를 넣고 로그인
      $_SESSION['naver_mb_id'] = $mb_company.$mb_uid;
      // echo $_SESSION['naver_mb_id'];
      if(isset($_SESSION['naver_mb_id'])) { // 세션이 있다면 로그인 확인 페이지로 이동
      	echo "<script>alert('로그인 되었습니다.');</script>";
      	echo "<script>location.replace('./index.php');</script>";
      }
    }
  } else {
    echo "회원정보를 가져오지 못했습니다.";
  }
} else {
    echo "토큰값을 가져오지 못했습니다.";
   }
?>
