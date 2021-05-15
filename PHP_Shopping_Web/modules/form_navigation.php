<?php
// Load Modules


// Parameter

// Functions

// Process
?>
<?php if(UserPage()) : ?>
  <header class="dheader">
    <div class="gnb_wrap">
      <div class="nav">
        <ul class="gnb">
          <li><a href="#">컴퓨터 부품</a>
            <ul class="submenu">
              <li><a style="cursor:pointer;" class="clicker" onclick="changeIframeUrl('User_list.php?var=cpu')">cpu</a></li>
              <li><a style="cursor:pointer;"class ="clicker" onclick="changeIframeUrl('User_list.php?var=mainboard')">mainboard</a></li>
              <li><a style="cursor:pointer;"class ="clicker" onclick="changeIframeUrl('User_list.php?var=power')">power</a></li>
              <li><a style="cursor:pointer;"class ="clicker" onclick="changeIframeUrl('User_list.php?var=case')">case</a></li>
              <li><a style="cursor:pointer;"class ="clicker" onclick="changeIframeUrl('User_list.php?var=cooler')">cooler</a></li>
              <li><a style="cursor:pointer;"class ="clicker" onclick="changeIframeUrl('User_list.php?var=odd')">Odd</a></li>
              <li><a style="cursor:pointer;"class ="clicker" onclick="changeIframeUrl('User_list.php?var=memory')">memory</a></li>
              <li><a style="cursor:pointer;"class ="clicker" onclick="changeIframeUrl('User_list.php?var=graphicscard')">graphicscard</a></li>
              <li><a style="cursor:pointer;"class ="clicker" onclick="changeIframeUrl('User_list.php?var=storage')">storage</a></li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </header>
<?php elseif(AdminPage()) : ?>
  <nav>
    <div class="logo">
      <img src="files/logo/logo.png">
    </div>
    <div class="list">
      <div id="nv_container">
      <ul>
          <li class="o_click">
             <a>제품 관리</a>
              <ul class="o_down">
                <li><a style="cursor:pointer;" class="clicker" onclick="changeIframeUrl('admin_list.php?var=cpu')">cpu</a></li>
                <li><a style="cursor:pointer;"class ="clicker" onclick="changeIframeUrl('admin_list.php?var=mainboard')">mainboard</a></li>
                <li><a style="cursor:pointer;"class ="clicker" onclick="changeIframeUrl('admin_list.php?var=power')">power</a></li>
                <li><a style="cursor:pointer;"class ="clicker" onclick="changeIframeUrl('admin_list.php?var=case')">case</a></li>
                <li><a style="cursor:pointer;"class ="clicker" onclick="changeIframeUrl('admin_list.php?var=cooler')">cooler</a></li>
                <li><a style="cursor:pointer;"class ="clicker" onclick="changeIframeUrl('admin_list.php?var=odd')">Odd</a></li>
                <li><a style="cursor:pointer;"class ="clicker" onclick="changeIframeUrl('admin_list.php?var=memory')">memory</a></li>
                <li><a style="cursor:pointer;"class ="clicker" onclick="changeIframeUrl('admin_list.php?var=graphicscard')">graphicscard</a></li>
                <li><a style="cursor:pointer;"class ="clicker" onclick="changeIframeUrl('admin_list.php?var=storage')">storage</a></li>
              </ul>
          </li>
      </ul>
      </div>
      <a class ="clicker" onclick="changeIframeUrl('admin_gallery_list.php')">배너 수정</a>
      <a class ="clicker" onclick="changeIframeUrl('admin_consulting_list.php')">상담 목록</a>
      <a class ="clicker" onclick="changeIframeUrl('admin_delivery.php')">배송 관리</a>
      <a class ="clicker" onclick="changeIframeUrl('admin_sign-modify.php')">비밀번호 변경</a>
      <a class ="clicker" href="admin_sign-out.php">로그아웃</a>
    </div>
  </nav>
  <script>
    $(document).ready(function(){
      $('.o_click').mouseover(function(){
        $('.o_down > li').stop().slideDown();
        $('.o_down > li').css('display','block');

      }).mouseleave(function(){
        $('.o_down > li').stop().slideUp();
      });
    });
  </script>
<?php endif ?>
