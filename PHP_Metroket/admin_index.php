<?php
// Load Modules
error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once("modules/admin.php");
?>
<!DOCTYPE html>
<html lang="ko">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/admin_index.css">
  <script src="https://code.jquery.com/jquery-latest.min.js"></script>
  <script src="Y_custom.js"></script>
  <title>Metroket Admin</title>
</head>
<body>

  <div class="container">
    <div class="header">
      <!-- 모바일 메뉴바 div -->
      <div class="m-gnb">
        <div class="m-menu">
          <div>Metroket Admin</div>
          <div>메트로켓 관리자 페이지</div>
          <ul id="ac">
            <li class="menu1">
              <a href="#">게시글 관리</a>
              <ul class="menu2">
                <li><a href="#" onclick="changeIframeUrl('admin_product_list.php')" class="menu_li">전체 게시글 관리</a></li>
                <li><a onclick="changeIframeUrl('admin_product_blind.php')" class="menu_li">가리기한 게시글</a></li>
              </ul>
            </li>
            <li class="menu1">
              <a href="#">회원관리</a>
              <ul class="menu2">
                <li class="menu_li"><a href="#" class="menu_li" onclick="changeIframeUrl('admin_member_list.php')">회원관리</a></li>
                <li class="menu_li"><a href="#" class="menu_li" onclick="changeIframeUrl('admin_member_block_list.php')">차단당한 회원 관리</a></li>
              </ul>
            </li>
            <li class="menu1">
              <a href="#">배너 변경</a>
              <ul class="menu2">
                <li class="menu_li"><a href="#" class="menu_li" onclick="changeIframeUrl('admin_gallery_list.php')">배너 변경하기</a></li>
              </ul>
            </li>
          </ul>

        </div>
        <!-- 메뉴 아이콘 -->
        <div class="trigger">
          <span></span>
          <span></span>
          <span></span>
        </div>
      </div>
      <!-- 모바일 메뉴 끝 -->
      <div>게시판관리</div>
      <ul>
        <li>프로필</li>
        <li><a href='./logout.php'>로그아웃</a></li>
      </ul>
    </div>

    <div class="menu">
      <div>Metroket Admin</div>
      <div>메트로켓 관리자 페이지</div>
      <div>
        <ul id="ac">
          <li class="menu1">
            <a href="#">게시글 관리</a>
            <ul class="menu2">
              <li><a href="#" onclick="changeIframeUrl('admin_product_list.php')" class="menu_li">전체 게시글 관리</a></li>
              <li><a onclick="changeIframeUrl('admin_product_blind.php')">가리기한 게시글</a></li>
            </ul>
          </li>
          <li class="menu1">
            <a href="#">회원관리</a>
            <ul class="menu2">
              <li><a href="#" onclick="changeIframeUrl('admin_member_list.php')">회원관리</a></li>
              <li><a href="#" onclick="changeIframeUrl('admin_member_block_list.php')">차단당한 회원 관리</a></li>
            </ul>
          </li>
          <li class="menu1">
            <a href="#">배너 변경</a>
            <ul class="menu2">
              <li><a href="#" onclick="changeIframeUrl('admin_gallery_list.php')">배너 변경하기</a></li>
            </ul>
          </li>
        </ul>
      </div>
    </div>

    <div class="content">
      <iframe src="admin_product_list.php" width="100%" iframespacing=0 marginheight=0 marginwidth=0 scrolling="no" vspace=0 hspace=0
        style="float:left; border: none; height: 100vh;" id="main_frame"></iframe>
    </div>
  </div>

  <script>
    function changeIframeUrl(url) {
      document.getElementById("main_frame").src = url;
    }
  </script>

</body>
</html>
