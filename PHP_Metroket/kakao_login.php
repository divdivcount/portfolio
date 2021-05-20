<?php
 $restAPIKey = "24c58b732b0414e7d5d850cdafc310b8"; //본인의 REST API KEY를 입력해주세요
 $callbacURI = urlencode("https://metroket.kro.kr/kakao_callback.php"); //본인의 Call Back URL을 입력해주세요
 $kakaoLoginUrl = "https://kauth.kakao.com/oauth/authorize?client_id=".$restAPIKey."&redirect_uri=".$callbacURI."&response_type=code";
?>
<!DOCTYPE html>
<html>
 <head>
  <meta charset="utf-8"/>
 </head>
 
 <body>
  <a href="<?= $kakaoLoginUrl ?>">
   <img src="img/kakao.png" />
  </a>
 </body>
</html>
