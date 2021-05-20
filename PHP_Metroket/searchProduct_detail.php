<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once('modules/db.php');
try{
  $dao = new Product;
  $member = new Member;
  $replyobject = new Reply;
  $interest = new Interest;
  $pr_id = Get("id", 0);
  $pr_title = Get("title",0);
  $replys = $replyobject->reply_select($pr_id);
  $i = 0;
}catch(PDOException $e){
    echo $e;
  }
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="css/bxslider-4-4.2.12/src/css/jquery.bxslider.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="css/css_login.css">
    <link rel="stylesheet" href="css/css_searchProduct_detail.css">
    <link rel="stylesheet" href="css/css_noamlfont.css">
    <link rel="stylesheet" href="css/reply.css">
    <link rel="stylesheet" href="css/css_metrocket_footer.css">
    <link rel="stylesheet" href="css/css_metrocket_header.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/bxslider/4.2.12/jquery.bxslider.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://unpkg.com/hangul-js" type="text/javascript"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="apple-touch-icon" sizes="180x180" href="css/favicon_package_v0.16/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="css/favicon_package_v0.16/favicon.ico">
    <!-- <link rel="icon" type="image/png" sizes="16x16" href="css/favicon_package_v0.16/favicon-16x16.png"> -->
    <link rel="manifest" href="css/favicon_package_v0.16/site.webmanifest">
    <link rel="mask-icon" href="css/favicon_package_v0.16/safari-pinned-tab.svg" color="#5bbad5">
  </head>
  <body>
  <div id="wrapPage">
    <?php $imgdao = $dao->searchProduct_detail(isset($mb) ? $mb["mb_num"] : 'null', isset($om) ? $om["om_id"] : 'null',$pr_id, $pr_title); ?>
    <!-- 슬라이드 이미지 -->
    <?php foreach ($imgdao as $row) : ?>

    <?php
      $pr_imgs = $row["pr_img"];
      $pr_img = explode(",", $pr_imgs);
      // var_dump($pr_img);
      // print_r( $row);
    ?>
    <!-- 모달팝업 (hidden여부로 팝업) -->
    <div class="modal hidden">
      <div class="bg">          <!-- 백그라운드 잡는 부분  -->
        <div class="fix_page">  <!-- 화면가운데 fix로 잡는 부분  -->

          <div class="report_modalBox hidden">            <!-- 콘텐츠 들어가는부분 -->
            <?php require_once('report.php'); ?>
          </div>

          <div class="arrivalTime_modalBox hidden" action="">
            <div class="closeBtn_box"><img src="img/cancle.png" class="" onclick="arrivalTime_close()" style="width:2.3rem;height:2.3rem;cursor:pointer"></div>
            <div class="arrivalTime_contentBox">
              <div id="bothFind_item">
                <div class="find_item">
                  <span>출발역을 입력해주세요.</span>
                  <input type="text" id="auto" class="w3-input highlight" value="" name="departure_station" placeholder="여긴 검색하는부분">
                </div>

                <div class="find_item">
                  <span>도착역</span>
                  <input type="text" id="arrival_station" class="w3-input highlight" value="<?= substr($row["profile_station"],(strpos($row["profile_station"],';')+1)) ?>" name ="arrival_station" readonly>
                  <!-- <div style="display:flex"><input id="auto" class="w3-input highlight"   type="text"><div style="width:1.3rem;margin:auto"><img src="img\loupe.png" alt=""></div></div> -->
                </div>
              </div>
              <div id="arr_imgBox">
                <img src="img/rocket.png" style="width:7.1rem;height:3.8rem" alt="">
              </div>

              <div class="timeResult hidden">
                <span>소요시간</span>
                <div id="requiredTime">00:00</div>
                <div id="requiredTime_detail">오전 00:00 ~ 오후 00:00</div>
              </div>
              <div class="search_arrivalTime">
                <button type="button" class="w3-button w3-blue w3-round-large" id="arrivalTime_btn">검색</button>
              </div>
            </div>

          </div>

          <div class="requestTrade_modalBox hidden">
            <div class="requestTrade_imgBox">
              <div class="img_box" style="margin:0;width:12.0rem;height:12.0rem" ><img src="img/question.png" alt="">                            </div>
            </div>
            <div class="requestTrade_contentBox">

              <h3>[거래요청하기]</h3>

              <p><span>"<?=$row["pr_title"]?>"</span><br>요청하기를 누르면 판매자에게 쪽지가 전달됩니다.</p>

              <div class="requestTrade_btnLine">
                <form  action="memo_requestTrade.php" method="post">

                  <input type="hidden" name= "id" value="<?=$row["pr_id"]?>">
                  <!-- 받는 회원아이디 -->
                  <?php $member = $member->Member_all_select($row["mb_id"]);?>
                  <input type="hidden" name="me_recv_mb_id" value="<?=  $member[0]["mb_id"] ?  $member[0]["mb_id"] : $row["om_id"] ?>" id="me_recv_mb_id" readonly required class="frm_input required" size="47"></br>
                  <!-- 내용 -->
                  <input type="hidden" name="me_memo" value="<?=isset($mb) ? $mb['mb_id'] : $om['om_nickname'] ?> 님이 거래를 요청했습니다.">
                  <button type="button" class="w3-button w3-round-xlarge w3-gray" onclick="requestTrade_close()">취소하기</button>
                  <button type="submit" class="w3-button w3-round-xlarge w3-blue">요청하기</button>
                </form>
              </div>

            </div>

          </div>
        </div>
      </div>
    </div>
    <!-- 상단 메뉴 부분 -->
    <?php require_once('metrocket_header.php');?>
    <div id="wrapContainer_Box">
      <!-- <div id="pageTitle_box" class="radius_box">
        <h2>품목 상세보기</h2>
        <span>채팅하기를 이용해 판매자와 대화할 수 있습니다.</span>
      </div> -->


      <!-- 메인상품을 감싸는 박스  -->
      <div id="mainProduct_box">
        <!-- 메인상품 이미지나오는 부분 -->
        <div id="slideImg_box">

          <div class="bxslider">
            <?php for($img = 0; $img < count($pr_img); $img++) { ?><div><img src="files/<?= $pr_img[$img] ?>" alt="" ></div><?php } ?>
          </div>

          <div id="customPager">

          </div>
        </div>



        <!-- 상품 이미지제외한 정보 및 버튼 있는 부분 -->
        <div id="mainProduct_information">
          <!-- 판매유저 정보 및 신고버튼 -->
          <div class="userProfile_line">

            <div class="userProfile">
              <!-- 사람사진 -->
              <div class="profileImg">
                <img class=" w3-circle" src="<?= isset($row["profile_img"]) ?($row["profile_img"] == 'img/normal_profile.png' ? $row["profile_img"] : ( strpos($row["profile_img"], "http") === 0 ?  $row["profile_img"] : 'files/'.$row["profile_img"] )) : "" ?>" alt="">
              </div>

              <!-- 이름이랑 호선  -->
              <div class="pr_namestation">
                <p><?= $row["profile_name"] ?></p>

                <div class="imgPlusText">
                  <div class="img_box"><img src="img/maps-and-flags.png" alt=""></div>
                  <span><?= $row["profile_station"] ?></span>
                </div>

              </div>
            </div>

            <!-- 신고하기 버튼  -->
            <div id="reportBtn_box" class="imgPlusText" onclick="report_open()">
              <div class="img_box"><img src="img/siren.png" alt=""></div>
              <span>신고하기</span>
            </div>
          </div>

          <!-- 상품 및 유저 정보 + 부가기능 부분  -->
          <div id="productInfo_title">

            <!-- 두번째줄 -->
            <div class="productTitle_line">
              <p><?= $row["pr_title"] ?></p>
            </div>

            <!-- 세번째줄  -->
            <div class="productPrice_line">
              <div class="imgPlusText">
                <div class="img_box" style="width:2.5rem;height:2.5rem"><img src="img/tag.png" alt=""></div>
                <span><?= $row["pr_price"] ?>원</span>
                <!-- 가격제안 가능여부 -->
                <div class="checkPricepNegotiation"><?php if($row["pr_check"] == 1){echo "(가격제안 가능)";}else{echo "(가격제안 불가능)";} ?></div>
              </div>

            </div>

            <!-- 4번째줄 -->
            <div class="productCategory_line">

              <!-- 카테고리 내용 -->
              <div class="pr_category">
                <?= $row["ca_name"] ?> · 관심 <?= $row["i_count"] ?>
              </div>


            </div>
          </div>


        <!-- 상품 설명  -->
          <div id="productInfo_text" >
            <p>
              <?= $row["pr_explanation"] ?>
            </p>

            <!-- 여러버튼 모아둔 부분  -->
            <div id="extraBtn_box">

              <!-- 여기 관심등록 -->
              <button type="button" class="w3-button w3-round-large w3-light-gray" onclick="registerInterest()">
                <div  class="img_box" style="width:1.9rem;height:1.9rem;margin:0"> <img src="<?php if($row["mem_i_check"] == 0){echo "img/staroff_19x19.png";}elseif($row["mem_i_check"] == 1){echo "img/star_19x19.png";} ?>" id="star_btn" data-value="<?=$row["mem_i_check"] ? $row["mem_i_check"] : 0 ?>" alt="" ></div>
              </button>

              <!-- 도착시간 확인 버튼 -->
              <button type="button" class="w3-button w3-round-large w3-light-gray" onclick="arrivalTime_open()">
                <div class="img_box" style="width:1.9rem;height:1.9rem"><img src="img/flag.png" alt=""></div>
                <span>도착시간</span>
              </button>

              <!-- 쪽지보낵 버튼 -->
              <button type="button" class="w3-button w3-round-large w3-light-gray">
                <div class="img_box" style="width:1.5rem;height:2.1rem"><img src="img/chat.png" alt=""></div>
                <span><a href="./memo_form.php?me_recive_mb_id=<?php
                try{
                  $member = new Member;
                  if($row['mb_id']){
                    $mb_name = $member->Member_Select($row['mb_id'] ? $row['mb_id'] : null);
                    echo trim($mb_name[0]['mb_id']);
                  }else{
                    echo trim("sir".$row['om_id']);
                  }

                }catch(PDOException $e){
                    echo $e;
                  }
                ?>&id=<?=$row["pr_id"]?>" class="td_btn" onclick="win_memo(this.href); return false;">쪽지보내기</a></span>
              </button>

              <button type="button" onclick="requestTrade_open()" class="talk w3-button w3-round-large w3-blue">
                <div class="img_box" style="width:2.1rem;height:2.1rem"><img src="img/talk.png" alt=""></div>
                <span>거래요청</span>
              </button>
            </div>
          </div>

        </div>
      </div>








      <?php
       $piec = explode("&nbsp;", $row["profile_station"]);
       // echo $piec[1];
       $sameProduct = $dao->same_searchProduct($row["l_id"],$piec[1],$row["ca_name"]);?>
      <?php $panmejaProduct = $dao->panpeja_searchProduct($row["mb_id"]? $row["mb_id"] : 'null', $row["om_id"] ? $row["om_id"] : 'null' );?>
    <?php endforeach ?>
    <!-- 댓글이 들어가야하는 부분입니다. -->
    <!-- 댓글 시작 -->
    <div id="reply_container">

      <div class="reply_view">
        <?php if(isset($replys)) : ?>
          <h3>댓글 <?=$replys[0]["reply_count"];?> </h3>
        <?php foreach ($replys as $reple) : ?>

          <!-- 댓글올라오면 생기는 부분 (유저이름 시간 댓글내용 삭제기능 ) -->
          <div class="dat_view">
            <div class="rep_profile">

              <div class="rep_imgLine">
                <?php $ch = is_null($reple["mb_img"]) ? 0 : 1;
                ?>
                <b><?php if($ch > 0) : ?>
                  <img src="<?= isset($reple["mb_img"]) ?
                ( $reple["mb_img"] != "img/normal_profile.png" ?
                ( strpos($reple["mb_img"], "http") === 0 ? $reple["mb_img"] : "files/".$reple["mb_img"] ): $reple["mb_img"])
                 : $reple["mb_img"] ?>"></b>
               <?php endif ?>
              </div>

              <div class="rep_textLine">
                <div class="member_num"><b><?=$reple['mb_id']?></b></div>
                <div class="reple_date"><?=$reple['date']?></div>
              </div>

            </div>

            <div class="" id="rep_del">
              <?php $i++ ?>
              <form method="get" name ="rep_form<?=$i?>" id="rep_form<?=$i?>" action="reply_delete.php">
                <input type="hidden" name="rno" value="<?=$reple['idx']?>" />
                <input type="hidden" name="b_no" value="<?=$pr_id?>">
                <a onclick="document.getElementById('rep_form<?=$i?>').submit();"><?= isset($mb["mb_num"]) ? ($mb["mb_id"] == $reple['mb_id'] ? "댓글 삭제" : "" ) : (isset($om) ? ($om["om_id"] == $reple['mb_id'] ? "댓글 삭제" : "") : ""); ?></a>
              </form>
            </div>
          </div>

          <div class="reple_text">
            <?php echo nl2br("$reple[content]"); ?>
          </div>


        <?php endforeach ?>
        <?php endif?>
      </div>

        <div class="dat_ins">
          <input type="hidden" name="bno" class="bno" value="<?=$pr_id?>">
          <input type="hidden" name="mb_id" id="mb_id" class="mb_dat_user" value=<?=isset($mb) ? $mb["mb_num"] : 'null' ?>>
          <input type="hidden" name="om_id" id="om_id" class="om_dat_user" value=<?=isset($om) ? $om["om_id"] : 'null'?>>

          <div class="replyInsert_box" style="margin-top:10px;">
            <textarea name="content" class="rep_con" id="rep_con" placeholder="댓글을 입력해주세요."></textarea>
            <div id="check_replyCount"><span>0</span> / 100</div>
          </div>

          <div class="rep_submitbtn_box"><button id="rep_btn" class="rep_btn w3-button w3-round-large w3-blue">댓글 등록</button></div>



        </div>
      </div>
      <!-- 댓글 끝 -->

      <!-- 다른 상품 소개 타이틀 -->
      <div class="otherProduct_title"><h3>이 상품과 비슷한 상품</h3></div>
      <!-- 상품 그리드 박스 -->
      <!-- 다른 상품들 노출되는 부분임 -->
      <div class="otherProduct_gridBox">

        <!-- 기타 상품 정보  -->
        <?php foreach ($sameProduct as $rows) : ?>
        <a href="searchProduct_detail.php?id=<?=$rows['pr_id']?>&title=<?=$rows['pr_title']?>"><div class="otherProduct_content">

          <!-- 이미지 부분 -->
          <div class="otherProduct_content_img">
            <img src="files/<?=$rows["pr_img"]?>" class="radiusTop" alt="">
          </div>

          <!-- 상품 내용 -->
          <div class="otherProduct_content_text radiusBottom">

            <!-- 제목 -->
            <div class="otherProduct_content_text_title_line">
              <span><?=$rows["pr_title"]?></span>
            </div>

            <!-- 가격 -->
            <div class="otherProduct_content_text_price_line">
              <span><?=$rows["pr_price"]?></span>
            </div>

            <!-- 역 위치 -->
            <div class="otherProduct_content_text_station_line">
              <span><?=$rows["line_name"]?> <?=$rows["pr_station"]?></span>
            </div>

            <!-- 카테고리 및 관심 수 부분  -->
            <div class="otherProduct_content_text_category_line">
              <span><?=$rows["ca_name"]?></span>
              <span>관심<?=$rows["i_count"]?></span>
            </div>

          </div>
        </div></a>
      <?php endforeach ?>
      </div><!-- 그리드 박스의 끝  -->

      <!-- 다른 상품 소개 타이틀 -->
      <div class="otherProduct_title"><h3>판매자의 다른상품</h3></div>
      <!-- 상품 그리드 박스 -->
      <!-- 다른 상품들 노출되는 부분임 -->
      <div class="otherProduct_gridBox">

        <!-- 기타 상품 정보  -->
        <?php foreach ($panmejaProduct as $product) : ?>
        <a href="searchProduct_detail.php?id=<?=$product['pr_id']?>&title=<?=$product['pr_title']?>"><div class="otherProduct_content">

          <!-- 이미지 부분 -->
          <?php	if ($product["pr_status"] ==="거래완료") :?>
						<div class="otherProduct_content_img radiusTop">
							<div id="overlay"><span>거래 완료</span></div>
							<img src="files/<?=$product["pr_img"]?>" class="radiusTop" alt="">
						</div>
					<?php else: ?>
						<div class="otherProduct_content_img radiusTop">
							<img src="files/<?=$product["pr_img"]?>" class="radiusTop" alt="">
						</div>
					<?php endif ?>

          <!-- 상품 내용 -->
          <div class="otherProduct_content_text radiusBottom">

            <!-- 제목 -->
            <div class="otherProduct_content_text_title_line">
              <span><?=$product["pr_title"]?></span>
            </div>

            <!-- 가격 -->
            <div class="otherProduct_content_text_price_line">
              <span><?=$product["pr_price"]?></span>
            </div>

            <!-- 역 위치 -->
            <div class="otherProduct_content_text_station_line">
              <span><?=$product["line_name"]?> <?=$product["pr_station"]?></span>
            </div>

            <!-- 카테고리 및 관심 수 부분  -->
            <div class="otherProduct_content_text_category_line">
              <span><?=$product["ca_name"]?></span>
              <span><?=$product["i_count"]?></span>
            </div>

          </div>
        </div></a>
      <?php endforeach ?>
      </div><!-- 그리드 박스의 끝  -->
    </div>
    <!-- 푸터 부분  -->
    <?php require_once 'metrocket_footer.php';?>
    <script type="text/javascript">
    let departure_stationID="";
    let arrival_stationID="";

    var slider = $('.bxslider');
    var slider_bx =null;

      $(document).ready(function(){

        //도착역 미리 검색후 지정
        var stationName = $('#arrival_station').val();
        $.ajax({
            url:'searchStation_odsayAPI.php', //request 보낼 서버의 경로
            type:'post', // 메소드(get, post)
            data:{station:stationName,return_result:'s_num'}, //보낼 데이터
            success: function(data) {
                //서버로부터 정상적으로 응답이 왔을 때 실행
                var json_data= JSON.parse(data);
                arrival_stationID=json_data[0];
            },
            error: function(err) {
              // alert("관심 상품을 등록하기 위해서 로그인을 먼저 해주세요");
              // history.back();
            }
        });


        var bxslider_img = document.querySelector(".bxslider").getElementsByTagName('img');
        //이미지가 하나이상일때 설정
        if (bxslider_img.length > 1) {
          slider_bx = slider.bxSlider( {
              mode: 'horizontal',// 가로 방향 수평 슬라이드
              speed: 500,        // 이동 속도를 설정
              pager: true,      // 현재 위치 페이징 표시 여부 설정
              pagerCustom: $("#customPager"),
              moveSlides: 1,     // 슬라이드 이동시 개수
              auto: true,        // 자동 실행 여부
              autoHover: false,   // 마우스 호버시 정지 여부
              controls: true    // 이전 다음 버튼 노출 여부
          });

        //이미지가 하나일때 설정  (슬라이드 기능 거의 off)
        }else{
          slider_bx = slider.bxSlider( {
              mode: 'horizontal',// 가로 방향 수평 슬라이드
              speed: 500,        // 이동 속도를 설정
              pager: true,      // 현재 위치 페이징 표시 여부 설정
              pagerCustom: $("#customPager"),
              moveSlides: 1,     // 슬라이드 이동시 개수
              auto: false,        // 자동 실행 여부
              preventDefaultSwipeX: false, // 손가락이 스핑할 때 터치 스크린이 x축이동 여부
              touchEnabled:false, //슬라이더에 터치 swipe 전환을 허용 여부
              autoHover: false,   // 마우스 호버시 정지 여부
              controls: true    // 이전 다음 버튼 노출 여부
          });
        }

        // 이미지 선택해서 슬라이드 넘기는 부분 함수
        bxSetting();
        let today = new Date();
    });
    // ↑ document.ready 끝나는 부분

    //로그인여부 확인하는 함수
    function check_login() {
      let mb_id = "<?= isset($mb) ? $mb["mb_num"] : 'null' ?>";
      let om_id = "<?= isset($om) ? $om["om_id"] : 'null' ?>";

      if (mb_id != 'null' || om_id != 'null')
        return true;
      else
        return false;
    }


    $("#rep_btn").click(function() {
      if (check_login()) {
        $.ajax({
          url : "reply_ok.php",
          type : "get",
          data : {
            "bno" : $(".bno").val(),
            "mb_id" : $(".mb_dat_user").val(),
            "om_id" : $(".om_dat_user").val(),
            "rep_con" : $(".rep_con").val()
          },
          success : function(data) {
          alert("댓글이 작성되었습니다");
          location.reload();
        },
        error : function(e){
          // alert("로그인을 먼저 해주세요");
          // location.repleace("./index.php");
        }
        });
      }else
        alert("댓글을 등록하기 위해서 로그인을 먼저 해주세요");
    })

    //관심상품 클릭시 값넘어가는거
    var star_btn = document.getElementById('star_btn');

    function registerInterest() {
      let values =star_btn.dataset.value;
      let pr_id = "<?= $pr_id ?>";
      let mb_id = "<?= isset($mb) ? $mb["mb_num"] : 'null' ?>";
      let om_id = "<?= isset($om) ? $om["om_id"] : 'null' ?>";

      if (mb_id != 'null' || om_id != 'null') {
        if (star_btn.dataset.value == 0) {
          $.ajax({
              url:'search_detail_ajax.php', //request 보낼 서버의 경로
              type:'post', // 메소드(get, post)
              data:{values:"0", pr_id : pr_id, mb_id:mb_id, om_id:om_id}, //보낼 데이터
              success: function(data) {
                  //서버로부터 정상적으로 응답이 왔을 때 실행
                  $('#star_btn').html(data);
                  star_btn.src ="img/star_19x19.png";
                  star_btn.dataset.value = 1;
              },
              error: function(err) {
                // alert("관심 상품을 등록하기 위해서 로그인을 먼저 해주세요");
                // history.back();
              }
          });
        }
        else if (star_btn.dataset.value == 1) {
          $.ajax({
              url:'search_detail_ajax.php', //request 보낼 서버의 경로
              type:'post', // 메소드(get, post)
              data:{values:"1", pr_id : pr_id, mb_id:mb_id,om_id:om_id}, //보낼 데이터
              success: function(data) {
                  //서버로부터 정상적으로 응답이 왔을 때 실행
                  star_btn.src = "img/staroff_19x19.png";
                  star_btn.dataset.value = 0;
              },
              error: function(err) {
                  //서버로부터 응답이 정상적으로 처리되지 못햇을 때 실행
                  // alert("관심 상품을 등록하기 위해서 로그인을 먼저 해주세요");
                  // history.back();
              }
          });
        }
      }else {
        alert("관심 상품을 등록하기 위해서 로그인을 먼저 해주세요");
      }

    }

    var win_memo = function(href) { // 쪽지 팝업창
      if (check_login()) {
        var new_win = window.open(href, 'win_memo', 'left=100,top=100,width=620,height=600,scrollbars=1');
        new_win.focus();
      }else
        alert("쪽지기능을 이용하시려면 로그인을 먼저 해주세요");
    }

    // 신고하기모달팝업 관련 함수
    function report_open() {
      if (check_login()) {
        document.querySelector(".modal").classList.remove("hidden");
        document.querySelector(".report_modalBox").classList.remove("hidden");
      }else
        alert("신고기능을 이용하시려면 로그인을 먼저 해주세요");
    }
    function report_close() {
      document.querySelector(".modal").classList.add("hidden");
      document.querySelector(".report_modalBox").classList.add("hidden");
    }

    // 도착시간 모달팝업 관련 함수
    function arrivalTime_open() {
      if (check_login()) {
        document.querySelector(".modal").classList.remove("hidden");
        document.querySelector(".arrivalTime_modalBox").classList.remove("hidden");
      }else
        alert("도착시간을 확인하시려면 로그인을 먼저 해주세요");
    }
    function arrivalTime_close() {
      document.querySelector(".modal").classList.add("hidden");
      document.querySelector(".arrivalTime_modalBox").classList.add("hidden");
    }

    // 거래요청 모달팝업 관련 함수
    function requestTrade_open() {
      if (check_login()) {
        document.querySelector(".modal").classList.remove("hidden");
        document.querySelector(".requestTrade_modalBox").classList.remove("hidden");
      }else
        alert("거래를 요청하시려면 로그인을 먼저 해주세요");
    }
    function requestTrade_close() {
      document.querySelector(".modal").classList.add("hidden");
      document.querySelector(".requestTrade_modalBox").classList.add("hidden");
    }

    // 글자수 카운트 (댓글쪽)
    $('#rep_con').keyup(function (e){
    var content = $(this).val();
    $('#check_replyCount').html("<span>"+content.length+"</span> / 100");    //글자수 실시간 카운팅

      if (content.length > 100){
          alert("최대 100자까지 입력 가능합니다.");
          $(this).val(content.substring(0, 100));
          $('#check_replyCount').html("<span>100</span> / 100");
      }
    });

    function bxSetting() {
        var customPager = document.querySelector('#customPager');
        <?php foreach ($imgdao as $row) : ?>

        <?php
          $pr_imgs = $row["pr_img"];
          $pr_img = explode(",", $pr_imgs);
          // var_dump($pr_img);
          // print_r( $row);
        ?>

        <?php
          for($img = 0; $img < count($pr_img); $img++) {
            $pr_img_src[$img] = addslashes("files/") . $pr_img[$img];
          }
        ?>

        <?php endforeach ?>
        var makediv="";
        var pr_img_src = <?php echo json_encode($pr_img_src,JSON_UNESCAPED_SLASHES);?>;
        for (var i = 0; i < 6; i++) {
          if (i < pr_img_src.length)
            makediv += '<a href data-slide-index ="'+ i +'"><img src="' + pr_img_src[i] +'"></a>';
          else
            makediv += '<a><img src="img/empty_pr.png"></a>';
        }
        customPager.innerHTML = makediv;
    }


    //검색버튼 눌럿을때 odsay 지하철경로관련api를 호출하는 페이지 호출후  도착시간 불러옴
    $("#arrivalTime_btn").click(function() {
      $.ajax({
        url : "subwayPath_odsayAPI.php",
        type : "post",
        data : {
          departure_stationID : departure_stationID,
          arrival_stationID : arrival_stationID
        },
        success : function(data) {
          let today = new Date();
          var requiredTime =data;
          var requiredHour = Math.floor(data / 60);
          var requiredMin = data % 60;
          var arrivalTime_string="";
          var arrivalHour = today.getHours() + requiredHour;
          var arrivalMin = today.getMinutes() + requiredMin;

          if (arrivalMin > 60) {
            arrivalHour++;
            arrivalMin -= 60;
          }

          //다음날으로 넘어갈때
          if (arrivalHour > 24) {
            arrivalTime_string += "다음날 ";
            arrivalHour -= 24;
          }

          //ex 9분 -> 09분
          if (arrivalMin < 10)
            arrivalMin = "0" + arrivalMin;

          //오후 오전 구분
          if (arrivalHour > 12)
            arrivalTime_string += "오후 " + (arrivalHour-12) + ":" + arrivalMin;
          else
            arrivalTime_string += "오전 " + arrivalHour + ":" + arrivalMin;

          //ex 9:9 -> 09:09
          if (requiredHour < 10)
            requiredHour = "0" + requiredHour;
          if (requiredMin < 10)
            requiredMin = "0" + requiredMin;

          document.getElementById('requiredTime').innerHTML = requiredHour+":"+requiredMin;
          document.getElementById('requiredTime_detail').innerHTML = today.toLocaleTimeString().slice(today.toLocaleTimeString().lengt,-3)+ " ~ " + arrivalTime_string;
          document.querySelector(".timeResult").classList.remove("hidden");
          document.querySelector(".search_arrivalTime").classList.add("hidden");
        },
        error : function(e){
          alert("로그인을 먼저 해주세요");
          location.repleace("./index.php");
        }
      });
    })

    $(document).ready(function(){
      var auto_complete = $("#auto");
      var auto_complete_object =null;

      auto_complete_object=auto_complete.autocomplete({
        source : "",	// source 는 자동 완성 대상
      });

    $('#auto').on('keyup', function(){
      if(this.value !== ""){
        var station = $('#auto').val();
        // 오디세이 역 검색 api 호출해주는 php 페이지 호출
        $.post('searchStation_odsayAPI.php',{station:station,return_result:'s_name'},function(data) {
            var station_object = $.parseJSON(data);
            let source = $.map(station_object.stationName,function(item,i) { //json[i] 번째 에 있는게 item 임.
              chosung = "";
              //Hangul.d(item, true) 을 하게 되면 item이 분해가 되어서
              //["ㄱ", "ㅣ", "ㅁ"],["ㅊ", "ㅣ"],[" "],["ㅂ", "ㅗ", "ㄲ"],["ㅇ", "ㅡ", "ㅁ"],["ㅂ", "ㅏ", "ㅂ"]
              //으로 나오는데 이중 0번째 인덱스만 가지고 오면 초성이다.
              full = Hangul.disassemble(item).join("").replace(/ /gi, "");	//공백제거된 ㄱㅣㅁㅊㅣㅂㅗㄲㅇㅡㅁㅂㅏㅂ
              Hangul.d(item, true).forEach(function(strItem, index) {

                if(strItem[0] != " "){	//띄어 쓰기가 아니면
                  chosung += strItem[0];//초성 추가
                }
              });
                return {
                  label : chosung + "|" + (item).replace(/ /gi, "") +"|" + full, //실제 검색어랑 비교 대상 ㄱㅊㅂㅇㅂ|김치볶음밥|ㄱㅣㅁㅊㅣㅂㅗㄲㅇㅡㅁㅂㅏㅂ 이 저장된다.
                  value : item,
                  chosung : chosung,
                  full : full,
                  index : i
                }
              });

          // 검색 키워드자동완성 실질적 선언부분
          auto_complete_object=auto_complete.autocomplete({
            source : source,	// source 는 자동 완성 대상
            select : function(event, ui) {	//아이템 선택시
              console.log(ui.item.label + " 선택 완료");
              departure_stationID= station_object.stationID[ui.item.index];
            },
            focus : function(event, ui) {	//포커스 가면
              return false;//한글 에러 잡기용도로 사용됨
            },
          }).autocomplete( "instance" )._renderItem = function( ul, item ) {
          //.autocomplete( "instance" )._renderItem 설절 부분이 핵심
              return $( "<li>" )	//기본 tag가 li로 되어 있음
                .append( "<div>" + item.value + "</div>" )	//여기에다가 원하는 모양의 HTML을 만들면 UI가 원하는 모양으로 변함.
                .appendTo( ul );	//웹 상으로 보이는 건 정상적인 "김치 볶음밥" 인데 내부에서는 ㄱㅊㅂㅇㅂ,김치 볶음밥 에서 검색을 함.
          };
        })
      }
    })
  });
  $("#auto").on("keyup",function(){	//검색창에 뭔가가 입력될 때마다
   input = $("#auto").val();	//입력된 값 저장
   // $( "#auto" ).autocomplete( "search", Hangul.disassemble(input).join("").replace(/ /gi, "") );	//자모 분리후 띄어쓰기 삭제
  })



    </script>
  </div>
  </body>

</html>
