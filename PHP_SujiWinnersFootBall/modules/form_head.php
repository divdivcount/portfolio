<?php
/*
FileName: form_head.php
Modified Date: 20190902
Description: 폼: 헤더
*/
// Load Modules
require_once($_SERVER['DOCUMENT_ROOT'].'/modules/module_protect.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/modules/form_check.php');

// Parameter

// Functions

// Process
?>
<?php if(UserPage()) : ?>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
  <script src="script/navigation.js"></script>
  <link href="css/css_sub2.css" rel="stylesheet" type="text/css">
  <link href="css/size1366.css" rel="stylesheet" type="text/css" media="screen and (max-width: 1366px)">
  <link href="css/size600.css" rel="stylesheet" type="text/css" media="screen and (max-width: 900px)">
  <title>수지 위너스 풋볼아카데미</title>
  <meta property="og:type" content="website">
  <meta name="description" content="경기도 용인시 상현동 수지로 18-2">
  <meta property="og:title" content="위너스 풋볼 아카데미">
  <meta property="og:image" content="https://blogpfthumb-phinf.pstatic.net/MjAyMDEyMjlfOTYg/MDAxNjA5MjM4NzM2Mjc1.xLsnYYCq8QreIHzghDmqQAys5V1KLjfD7wwXBnP0GGIg.0eJ1R_CEBZ0syET5vTSI2MKiWcm6dC3Dvl_LPeq883gg.JPEG.ckdrbs74/KakaoTalk_20201229_194356756.jpg?type=w161">
  <meta property="og:description" content="경기도 용인시 상현동 수지로 18-2">
  <meta property="og:url" content="https://www.sujiwinnersfootball.com/">
  <meta name="naver-site-verification" content="2aae5afe9788016ca67488c4886521b289012a1e" />
  <link rel="canonical" href="https://www.sujiwinnersfootball.com/">
<?php elseif(AdminPage()) : ?>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
  <link href="/css/administrator.css" rel="stylesheet" type="text/css">
<?php endif ?>
<!-- <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script> -->
