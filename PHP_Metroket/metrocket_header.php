<?php
    if(!(empty($_SESSION['ss_mb_id']) || empty($_SESSION['naver_mb_id']) || empty($_SESSION['kakao_mb_id']))){
        echo "123";
    }else{
      if(isset($_SESSION['ss_mb_id'])){
        $mb_id = $_SESSION['ss_mb_id'];
        $sql = " select * from member where mb_id = TRIM('$mb_id') ";
        $result = mysqli_query($conn, $sql);
        $mb = mysqli_fetch_assoc($result);
      }elseif(isset($_SESSION['naver_mb_id'])){
        $om_id = $_SESSION['naver_mb_id'];
        $om_id = substr($om_id, 5);
        $sql = " select * from oauth_member where om_id = TRIM($om_id) ";
        $result = mysqli_query($conn, $sql);
        $om = mysqli_fetch_assoc($result);
      }elseif(isset($_SESSION['kakao_mb_id'])){
        $oms_id = $_SESSION['kakao_mb_id'];
        $oms_id = substr($oms_id, 5);
        // echo $oms_id;
        $sql = " select * from oauth_member where om_id = TRIM($oms_id) ";
        $result = mysqli_query($conn, $sql);
        $om = mysqli_fetch_assoc($result);
      }
    }
?>
<!-- 최상단 로고 및 상단메뉴 -->
    <div id="topMenu_box">
      <!-- 상단 로고 -->
      <div class="imgbox_1">
        <a href="index.php"><img src="img\mainlogo02_158x32.png" alt=""></a>
      </div>

      <!-- 상단 툴바 -->
      <div id="topToolbar_box">
        <?php
          if(isset($mb['mb_num'])){
            $sql = " SELECT COUNT(me_recive_datetime) AS cnt FROM mb_om_memo WHERE me_recive_mb_id = '{$mb["mb_id"]}' and me_recive_datetime = '0000-00-00 00:00:00' ";
            // echo $sql."<br>";
            $result_memo = mysqli_query($conn, $sql);
            $memo_cnt = mysqli_fetch_assoc($result_memo);
            echo "<ul>"."&nbsp;";
            // echo $om["line_station"]."line_station";
            // var_dump($mb["line_station"] == null );
            // var_dump($om["line_station"] == null );
            if($mb["line_station"] == null){
              echo "<a href='#' onclick='line_station()'><li>상품등록</li></a>";
            }else{
              echo "<a href='./addProduct.php'><li>상품등록</li></a>";
            }
            echo "&nbsp;<a href='./memo.php?kind=recive' onclick='win_memo(this.href); return false;'><li>". ($memo_cnt['cnt'] > 0 ? '<img src="img/new_button.png">' : '') ."쪽지함</li></a>"."&nbsp;<a href='My_one_page.php'><li>마이페이지</li></a>"."&nbsp;<a href='./logout.php'><li>로그아웃</li></a>"."</ul>";
            // echo "일반 아이디";
          }elseif(isset($om['om_id'])){
            $sql = " SELECT COUNT(me_recive_datetime) AS cnt FROM mb_om_memo WHERE me_recive_mb_id = '{$om["om_id"]}' and me_recive_datetime = '0000-00-00 00:00:00' ";
            // echo $sql."<br>";
            $result_memo = mysqli_query($conn, $sql);
            $memo_cnt = mysqli_fetch_assoc($result_memo);
            echo "<ul>"."&nbsp;";
            // var_dump($mb["line_station"] == null );
            // var_dump($om["line_station"] == null );
            if($om["line_station"] == null){
              echo "<a href='#' onclick='line_station()'><li>상품등록</li></a>";
            }else{
              echo "<a href='./addProduct.php'><li>상품등록</li></a>";
            }
            echo "&nbsp;<a href='./memo.php?kind=recive' onclick='win_memo(this.href); return false;'><li>". ($memo_cnt['cnt'] > 0 ? '<img src="img/new_button.png">' : '') ."쪽지함</li></a>"."&nbsp;<a href='My_one_page.php'><li>마이페이지</li></a>"."&nbsp;<a href='./oauth_logout.php'><li>로그아웃</li></a>"."</ul>";
            // echo "네이버 아이디";
          }else {
            echo "<ul><li class='openBtn'>로그인</li></ul>";
          }
         ?>
      </div>
    </div>

    <div class="modal_header hidden">
      <div class="bg">
        <div class="test_modal">

          <div class="modalBox">

            <div class="closeBtn_box"><img src="img/cancle.png" class="closeBtn"></div>

            <?php require_once('login.php'); ?>
          </div>

        </div>
      </div>
    </div>

    <script type="text/javascript">

    $(document).ready(function(){ // html 문서를 다 읽어들인 후

      //헤더 로그인 메뉴쪽 모달팝업 제어 함수
      function login_open() {
        document.querySelector(".modal_header").classList.remove("hidden");
      }
      function login_close() {
        document.querySelector(".modal_header").classList.add("hidden");
      }

      if (document.querySelector(".openBtn")) {
        document.querySelector(".openBtn").addEventListener("click", login_open);
      }
      document.querySelector(".closeBtn").addEventListener("click", login_close);
    });

    function line_station() {
       alert("마이페이지에서 역 선택을 먼저 등록 해주세요.");
       location.replace("My_one_page.php");
     }
     var win_memo = function(href) { // 쪽지 팝업창
     var new_win = window.open(href, 'win_memo', 'left=100,top=100,width=620,height=600,scrollbars=1');
     new_win.focus();
     }

    </script>
