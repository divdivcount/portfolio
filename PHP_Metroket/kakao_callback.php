<?php
  require_once("modules/db.php");
  require_once("modules/notification.php");
  $oauth = new Oauths;
  $returnCode = $_GET["code"]; // 서버로 부터 토큰을 발급받을 수 있는 코드를 받아옵니다
	$restAPIKey = "24c58b732b0414e7d5d850cdafc310b8"; // 본인의 REST API KEY를 입력해주세요
	$callbacURI = urlencode("https://metroket.kro.kr/kakao_callback.php"); // 본인의 Call Back URL을 입력해주세요

    $getTokenUrl = "https://kauth.kakao.com/oauth/token?grant_type=authorization_code&client_id=".$restAPIKey."&redirect_uri=".$callbacURI."&code=".$returnCode;

	$isPost = false;

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $getTokenUrl);
	curl_setopt($ch, CURLOPT_POST, $isPost);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	$headers = array();
	$loginResponse = curl_exec ($ch);
	$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	curl_close ($ch);

        $accessToken= json_decode($loginResponse)->access_token; //Access Token만 따로 뺌


	$header = "Bearer ".$accessToken; // Bearer 다음에 공백 추가
	$getProfileUrl = "https://kapi.kakao.com/v2/user/me";

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $getProfileUrl);
	curl_setopt($ch, CURLOPT_POST, $isPost);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	$headers = array();
	$headers[] = "Authorization: ".$header;
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

	$profileResponse = curl_exec ($ch);
	$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	curl_close ($ch);
	// var_dump($profileResponse); // Kakao API 서버로 부터 받아온 값
  $profileResponse = json_decode($profileResponse);
  $userid = $profileResponse->id;

  $result = $oauth->Om_select($userid);

  foreach ($result as $row) {
    $om_id = $row['om_id'];
    $om_token = $row['om_access_token'];
    $om_block = $row['om_block'];
  }
  if ($om_id == $userid) {
    if($om_block === 'y'){
      echo "<script>alert('관리자로 인해 차단 당한 아이디 입니다.');</script>";
      echo "<script>location.replace('./index.php');</script>";
      exit;
    }
    $update = $oauth->Om_token_update($accessToken, $userid); // 로그인
    $mb_company = 'kakao';
    $_SESSION['kakao_mb_id'] = $mb_company.$userid;
    if(isset($_SESSION['kakao_mb_id'])) { // 세션이 있다면 로그인 확인 페이지로 이동
      echo "<script>alert('로그인 되었습니다.');</script>";
      echo "<script>location.replace('./index.php');</script>";
    }else{
      echo "안됌";
    }
  }else{
    $mb_uid = $profileResponse->id;
    $mb_token = $accessToken;
    $mb_name = $profileResponse->properties->nickname;
    $mb_email = $profileResponse->kakao_account->email;
    $mb_profile_image = $profileResponse->properties->profile_image;
    $mb_company = 'kakao';
    // echo "<br>".$mb_uid."<br>";
    // echo $mb_token."<br>";
    // echo $mb_name."<br>";
    // echo $mb_email."<br>";
    // echo $mb_profile_image."<br>";
    // echo $mb_nickname."<br>";
    // echo $mb_company."<br>";
    if(isset($mb_email)){
      $mb_email = "메일을 선택 하지 않으셨습니다.";
    }else{
      $mb_email = "메일을 선택 하지 않으셨습니다.";
    }
    $OauthObj = $oauth->Om_insert($mb_uid,$mb_token,$mb_name,$mb_email,$mb_profile_image,$mb_company);
    $_SESSION['kakao_mb_id'] = $mb_company.$mb_uid;
    if(isset($_SESSION['kakao_mb_id'])) { // 세션이 있다면 로그인 확인 페이지로 이동
      echo "<script>alert('로그인 되었습니다.');</script>";
      echo "<script>location.replace('./index.php');</script>";
    }else{
      echo "안됌";
    }
  }

?>
