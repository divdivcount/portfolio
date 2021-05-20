<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
  require_once("modules/db.php");
  /* ky : 내일 작업 예정입니다 건들지 말아주세요*/
  $pr_ida = Post("pr_ida", null);
  $mb_ida = Post("mb_ida", 'null');
  $om_ida = Post("om_ida", 'null');
?>
<?php
  if(empty($_SESSION['ss_mb_id']) && empty($_SESSION['naver_mb_id']) && empty($_SESSION['kakao_mb_id']) ){
    echo "<script>alert('로그인을 해주세요');</script>";
    exit;
  }else{
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="css/css_addProduct.css">
    <link rel="stylesheet" href="css/css_noamlfont.css">
    <link rel="stylesheet" href="css/css_metrocket_footer.css">
    <link rel="stylesheet" href="css/css_metrocket_header.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="theme-color" content="#ffffff">
    <link rel="apple-touch-icon" sizes="180x180" href="css/favicon_package_v0.16/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="css/favicon_package_v0.16/favicon.ico">
    <!-- <link rel="icon" type="image/png" sizes="16x16" href="css/favicon_package_v0.16/favicon-16x16.png"> -->
    <link rel="manifest" href="css/favicon_package_v0.16/site.webmanifest">
    <link rel="mask-icon" href="css/favicon_package_v0.16/safari-pinned-tab.svg" color="#5bbad5">
    <title></title>
  </head>
  <body>
    <div id="wrapPage">


    <!-- 상단 메뉴 부분 -->
    <?php require_once('metrocket_header.php'); ?>


    <div id = "wrapContainer_Box">
      <div id="pageTitle_box" class="radius_box">
        <div class="title_box" style="justify-content: space-between;">
          <h2 style="font-size:2.8rem">상품등록하기</h2>

          <!-- php 나 스크립트로 뜨게 해야하는 부분 추후 수정 -->
          <span><?= isset($mb) ? $mb["line_station"] : $om["line_station"]?></span>
          <?php
          //85
            $line = isset($mb) ? $mb["line_station"] : $om["line_station"];
            // echo $line;
            $pieces = explode("&nbsp;", $line);
            $linesa = $pieces[0];
            $stations = $pieces[1];
            // echo $linesa;
            $sql = "select l_id from line where l_name = '$linesa'";
            $result = mysqli_query($conn, $sql);
            $line = mysqli_fetch_assoc($result);
            $line["l_id"];
            $lines = $line["l_id"];
            // echo $lines;

          ?>
        </div>

      </div>

      <!-- 폼  -->
      <?php

      if($pr_ida > 0 && ($mb_ida ? $mb_ida : $om_ida)) : ?>
        <?php
          try{

            $update_select = new Product;
            $update_selects = $update_select->Product_update_search($pr_ida,$mb_ida,$om_ida);
          }catch(PDOException $e){
            echo $e;
          }
        ?>
      <form class="" action="addProduct_check.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="pr_ida" value="<?=$pr_ida?>" >
        <input type="hidden" name="mb_ida" value="<?=$mb_ida?>" >
        <input type="hidden" name="om_ida" value="<?=$om_ida?>" >
        <input type="hidden" name="mode" value="modify">
      <!-- 제목 입력 부분 -->
      <?php foreach ($update_selects as $u_select) : ?>
      <div id="insertTitle_box" class="radius_box" >

        <div class="title_box">
          <h2><d>*</d>제목입력</h2>
          <span>100자 이하로 입력해 주세요.</span>
        </div>

        <div class="content_box">
          <input id ="titleText" class="w3-input" type="text" name="title" value="<?=$u_select["pr_title"] ? $u_select["pr_title"] : ""?>" placeholder="제목을 입력해주세요."required>
          <input type="hidden" name="lines" value="<?=$lines?>">
          <input type="hidden" name="station" value="<?=$stations?>">
          <!-- php 추가예정  -->
          <div id="check_TitleCount"><span>0</span> / 100</div>
        </div>

      </div>

      <!-- 판매가 책정 부분 -->
      <div id="insertPrice_box" class="radius_box">

        <div class="title_box">
          <h2><d>*</d>판매가</h2>
        </div>

        <div class="content_box">
          <div class="priceInput_box">
            <input id ="price" name="price" class="w3-input" type="text" value="<?= $u_select["pr_price"] ? $u_select["pr_price"] : "" ?>" placeholder="숫자만 입력해주세요." onkeyup="inputNumberFormat(this)" required>
            &#8361;
          </div>

          <div class="priceCheck_box">
            <img id="priceCheckImg" src="<?php if($u_select["pr_check"] == 1){echo "img/priceCheckOnBtn.png";}elseif($u_select["pr_check"] == 2){echo "img/priceCheckOffBtn.png";} ?>"  alt="" onclick="checkPricepNegotiation();">
            <p id="priceCheckText" class='<?php if($u_select["pr_check"] == 1){echo "priceCheck_on";}elseif($u_select["pr_check"] == 2){echo "priceCheck_off";} ?>'>가격흥정가능</p>
            <input id="price_check" type="hidden" name="price_checking" value="<?php if($u_select["pr_check"] == 1){echo "1";}elseif($u_select["pr_check"] == 2){echo "2";} ?>">
          </div>
        </div>
      </div>

      <!-- 카테고리 선택 부분 -->
      <div id="insertCategory_box" class="radius_box">
        <div class="title_box">
          <h2><d>*</d>카테고리 설정 </h2>
          <span> 원하시는 카테고리를 설정해 주세요.</span>
        </div>

        <div class="content_box">
          <div class="categoryGrid_box">
            <label id="" class="categorylabel" <?php if($u_select["ca_name"] == '디지털/가전'){echo 'style="color: rgb(0, 153, 255)"';}else{} ?>><input type="radio" class="test" name="category"  <?php if($u_select["ca_name"] == '디지털/가전'){echo 'checked';}else{} ?>  value="디지털/가전" >디지털/가전</label>
            <label id="" class="categorylabel" <?php if($u_select["ca_name"] == '가구/인테리어'){echo 'style="color: rgb(0, 153, 255)"';}else{}?> ><input type="radio" class="test" name="category" <?php if($u_select["ca_name"] == '가구/인테리어'){echo 'checked';}else{} ?> value="가구/인테리어">가구/인테리어</label>
            <label id="" class="categorylabel" <?php if($u_select["ca_name"] == '유아동/유아도서'){echo 'style="color: rgb(0, 153, 255)"';}else{}?>><input type="radio" class="test" name="category" <?php if($u_select["ca_name"] == '유아동/유아도서'){echo 'checked';}else{} ?>value="유아동/유아도서">유아동/유아도서</label>
            <label id="" class="categorylabel" <?php if($u_select["ca_name"] == '생활/가공식품'){echo 'style="color: rgb(0, 153, 255)"';}else{}?> ><input type="radio" class="test" name="category" <?php if($u_select["ca_name"] == '생활/가공식품'){echo 'checked';}else{} ?> value="생활/가공식품">생활/가공식품</label>
            <label id="" class="categorylabel" <?php if($u_select["ca_name"] == '스포츠/레저'){echo 'style="color: rgb(0, 153, 255)"';}else{} ?>><input type="radio" class="test" name="category"  <?php if($u_select["ca_name"] == '스포츠/레저'){echo 'checked';}else{} ?>  value="스포츠/레저">스포츠/레저</label>
            <label id="" class="categorylabel" <?php if($u_select["ca_name"] == '여성잡화'){echo 'style="color: rgb(0, 153, 255)"';}else{} ?> ><input type="radio" class="test" name="category"   <?php if($u_select["ca_name"] == '여성잡화'){echo 'checked';}else{} ?>   value="여성잡화">여성잡화</label>
            <label id="" class="categorylabel" <?php if($u_select["ca_name"] == '여성의류'){echo 'style="color: rgb(0, 153, 255)"';}else{} ?> ><input type="radio" class="test" name="category"   <?php if($u_select["ca_name"] == '여성의류'){echo 'checked';}else{} ?>   value="여성의류">여성의류</label>
            <label id="" class="categorylabel" <?php if($u_select["ca_name"] == '남성패션/잡화'){echo 'style="color: rgb(0, 153, 255)"';}else{}?> ><input type="radio" class="test" name="category" <?php if($u_select["ca_name"] == '남성패션/잡화'){echo 'checked';}else{} ?>  value="남성패션/잡화">남성패션/잡화</label>
            <label id="" class="categorylabel" <?php if($u_select["ca_name"] == '게임/취미'){echo 'style="color: rgb(0, 153, 255)"';}else{} ?>><input type="radio" class="test" name="category"   <?php if($u_select["ca_name"] == '게임/취미'){echo 'checked';}else{} ?>    value="게임/취미">게임/취미</label>
            <label id="" class="categorylabel" <?php if($u_select["ca_name"] == '반려동물용품'){echo 'style="color: rgb(0, 153, 255)"';}else{} ?>><input type="radio" class="test" name="category"  <?php if($u_select["ca_name"] == '반려동물용품'){echo 'checked';}else{} ?>  value="반려동물용품">반려동물용품</label>
            <label id="" class="categorylabel" <?php if($u_select["ca_name"] == '도서/티켓/음반'){echo 'style="color: rgb(0, 153, 255)"';}else{}?>><input type="radio" class="test" name="category" <?php if($u_select["ca_name"] == '도서/티켓/음반'){echo 'checked';}else{} ?>   value="도서/티켓/음반">도서/티켓/음반</label>
            <label id="" class="categorylabel" <?php if($u_select["ca_name"] == '식물'){echo 'style="color: rgb(0, 153, 255)"';}else{} ?>><input type="radio" class="test" name="category"      <?php if($u_select["ca_name"] == '식물'){echo 'checked';}else{} ?>      value="식물">식물</label>
            <label id="" class="categorylabel" <?php if($u_select["ca_name"] == '기타 중고물품'){echo 'style="color: rgb(0, 153, 255)"';}else{}?> ><input type="radio" class="test" name="category" <?php if($u_select["ca_name"] == '기타 중고물품'){echo 'checked';}else{} ?>  value="기타 중고물품">기타 중고물품</label>
            <label id="" class="categorylabel" <?php if($u_select["ca_name"] == '뷰티/미용'){echo 'style="color: rgb(0, 153, 255)"';}else{} ?>><input type="radio" class="test" name="category"   <?php if($u_select["ca_name"] == '뷰티/미용'){echo 'checked';}else{} ?>    value="뷰티/미용">뷰티/미용</label>
          </div>
        </div>
      </div>

      <!-- 상품이미지 업로드 부분 -->
      <div id="insertImg_box" class="radius_box">
        <div class="title_box">
          <h2><d>*</d>상품이미지 </h2>
          <span> 최소 1장 이상의 이미지를 업로드 해주세요 (최대 6장 이하 업로드 가능)</span>
        </div>
        <?php
        $pr_imgs = $u_select["pr_img"];
        $pr_img = explode(",", $pr_imgs);
        ?>
        <div class="content_box">
          <div class="imgGrid_box">
            <?php
            for($img = 0; $img < 6; $img++) {
                if($img < count($pr_img)){
                  ?>
                  <div class="img_Item" style='background-image:url(<?= $pr_img[$img] ? "../files/$pr_img[$img]" : "../img/add_img.png" ?>)'></div>
                  <?php
                }else{
                  ?>
                    <div class="img_Item" style='background-image:url("../img/add_img.png")'></div>
                  <?php
                }
              ?>

            <?php } ?>
            <input type="file" id="real-input" name="files[]" class="image_inputType_file"  accept="image/jpeg,image/png,image/gif" style="display:none;"  multiple>
          </div>

        </div>
      </div>

      <!-- 상세설명 작성 부분  -->
      <div id="insertText_box" class="radius_box">

        <div class="title_box">
          <h2><d>*</d>상세설명</h2>
        </div>

        <div class="content_box">
          <textarea id ="explainText" name="explainText" rows="14" cols="80" style="width:100%; resize: none;"  placeholder="내용을 작성해 상품을 소개해 주세요."><?= $u_select["pr_explanation"] ? $u_select["pr_explanation"] : '' ?></textarea>
          <div id="check_explainTextCount"><span>0</span> / 1000</div>
        </div>

      </div>

    <div class="btn_box">
      <input class="w3-button w3-blue w3-round-large" type="submit" name="upload" value="수정 완료">
      <input class="w3-button w3-round-large" type="button" name="" value="취소">
      <input class="w3-button w3-darkgray w3-round-large" type="button" name="" value="삭제">
      </div>

      </form>
    <?php endforeach ?>
      <!-- 폼끝  -->
<?php else : ?>
  <form class="" action="addProduct_check.php" method="post" enctype="multipart/form-data">

  <!-- 제목 입력 부분 -->
  <div id="insertTitle_box" class="radius_box" >

    <div class="title_box">
      <h2><d>*</d>제목입력</h2>
      <span>100자 이하로 입력해 주세요.</span>
    </div>

    <div class="content_box">
      <input id ="titleText" class="w3-input" type="text" name="title" placeholder="제목을 입력해주세요."required>
      <input type="hidden" name="lines" value="<?=$lines?>">
      <input type="hidden" name="mode" value="insert">
      <input type="hidden" name="station" value="<?=$stations?>">
      <input type="hidden" name="mb" value="<?=isset($mb) ? $mb["mb_num"] : ''?>">
      <input type="hidden" name="om" value="<?=isset($om) ? $om["om_id"] : ''?>">
      <!-- php 추가예정  -->
      <div id="check_TitleCount"><span>0</span> / 100</div>
    </div>

  </div>

  <!-- 판매가 책정 부분 -->
  <div id="insertPrice_box" class="radius_box">

    <div class="title_box">
      <h2><d>*</d>판매가</h2>
    </div>

    <div class="content_box">
      <div class="priceInput_box">
        <input id ="price" name="price" class="w3-input" type="text" placeholder="숫자만 입력해주세요." onkeyup="inputNumberFormat(this)" required>
        &#8361;
      </div>

      <div class="priceCheck_box">
        <img id="priceCheckImg" src="img/priceCheckOnBtn.png" alt="" onclick="checkPricepNegotiation();">
        <p id="priceCheckText" class="priceCheck_on">가격흥정가능</p>
        <input id="price_check" type="hidden" name="price_checking" value="1">
      </div>
    </div>
  </div>

  <!-- 카테고리 선택 부분 -->
  <div id="insertCategory_box" class="radius_box">
    <div class="title_box">
      <h2><d>*</d>카테고리 설정 </h2>
      <span> 원하시는 카테고리를 설정해 주세요.</span>
    </div>

    <div class="content_box">
      <div class="categoryGrid_box">
        <label id="" class="categorylabel"><input type="radio" class="test" name="category" value="디지털/가전">디지털/가전</label>
        <label id="" class="categorylabel"><input type="radio" class="test" name="category" value="가구/인테리어">가구/인테리어</label>
        <label id="" class="categorylabel"><input type="radio" class="test" name="category" value="유아동/유아도서">유아동/유아도서</label>
        <label id="" class="categorylabel"><input type="radio" class="test" name="category" value="생활/가공식품">생활/가공식품</label>
        <label id="" class="categorylabel"><input type="radio" class="test" name="category" value="스포츠/레저">스포츠/레저</label>
        <label id="" class="categorylabel"><input type="radio" class="test" name="category" value="여성잡화">여성잡화</label>
        <label id="" class="categorylabel"><input type="radio" class="test" name="category" value="여성의류">여성의류</label>
        <label id="" class="categorylabel"><input type="radio" class="test" name="category" value="남성패션/잡화">남성패션/잡화</label>
        <label id="" class="categorylabel"><input type="radio" class="test" name="category" value="게임/취미">게임/취미</label>
        <label id="" class="categorylabel"><input type="radio" class="test" name="category" value="반려동물용품">반려동물용품</label>
        <label id="" class="categorylabel"><input type="radio" class="test" name="category" value="도서/티켓/음반">도서/티켓/음반</label>
        <label id="" class="categorylabel"><input type="radio" class="test" name="category" value="식물">식물</label>
        <label id="" class="categorylabel"><input type="radio" class="test" name="category" value="기타 중고물품">기타 중고물품</label>
        <label id="" class="categorylabel"><input type="radio" class="test" name="category" value="뷰티/미용">뷰티/미용</label>
      </div>
    </div>
  </div>

  <!-- 상품이미지 업로드 부분 -->
  <div id="insertImg_box" class="radius_box">
    <div class="title_box">
      <h2><d>*</d>상품이미지 </h2>
      <span> 최소 1장 이상의 이미지를 업로드 해주세요 (최대 6장 이하 업로드 가능)</span>
    </div>

    <div class="content_box">
      <div class="imgGrid_box">
        <div class="img_Item" style="background-image:url('../img/add_img.png')"></div>
        <div class="img_Item" style="background-image:url('../img/add_img.png')"></div>
        <div class="img_Item" style="background-image:url('../img/add_img.png')"></div>
        <div class="img_Item" style="background-image:url('../img/add_img.png')"></div>
        <div class="img_Item" style="background-image:url('../img/add_img.png')"></div>
        <div class="img_Item" style="background-image:url('../img/add_img.png')"></div>
        <input type="file" id="real-input" name="files[]" class="image_inputType_file"  accept="image/jpeg,image/png,image/gif" style="display:none" required multiple>

      </div>

    </div>
  </div>

  <!-- 상세설명 작성 부분  -->
  <div id="insertText_box" class="radius_box">

    <div class="title_box">
      <h2><d>*</d>상세설명</h2>
    </div>

    <div class="content_box">
      <textarea id ="explainText" name="explainText" rows="14" cols="80" style="width:100%; resize: none"; placeholder="내용을 작성해 상품을 소개해 주세요."></textarea>
      <div id="check_explainTextCount"><span>0</span> / 1000</div>
    </div>

  </div>

<div class="btn_box">
  <input class="w3-button w3-blue w3-round-large" type="submit" name="upload" value="완료">
  <input class="w3-button w3-round-large" type="button" name="" value="취소">
  </div>

  </form>
<?php endif ?>
    </div>
    <!-- 푸터 부분  -->
    <?php require_once 'metrocket_footer.php';?>
    </div>
  </body>
  <script type="text/javascript">
    const img_Item = document.getElementsByClassName('img_Item');
    const realInput = document.getElementById('real-input');
    const productImg = document.getElementsByClassName('productImg');


    // 사진 업로드 관련 함수적용
    var img = document.getElementById('test');
    for (var i = 0; i < 5; i++) {
      img_Item.item(i).addEventListener('click',()=>{
       realInput.click();
     });
    }

    //사진 업로드 함수
    realInput.addEventListener('change',function(){
      if (this.files.length > 6) {
        alert('사진은 6장만 등록이 가능합니다');
        realInput.value="";
      }

      for (var i = 0; i < 6; i++) {
        img_Item.item(i).style.background = 'url("img/add_img.png")';
        img_Item.item(i).style.backgroundSize ='100% 100%';
        img_Item.item(i).style.backgroundRepeat ="no-repeat";
      }

      for (var i = 0; i < this.files.length; i++) {
        if(this.files[i].type!='image/jpeg' && this.files[i].type!='image/png') {
          alert('jpg 및 png 이미지를 업로드해주세요');
          realInput.value="";
        }else{
          var url =""
          url = URL.createObjectURL(this.files[i]);
          img_Item.item(i).style.background = 'url(' + url + ')';
          img_Item.item(i).style.backgroundSize ='100% 100%';
          img_Item.item(i).style.backgroundRepeat ="no-repeat";
        }
      }
    })


    // 글자수 카운트 (상세설명쪽)
    $('#explainText').keyup(function (e){
    var content = $(this).val();
    $('#check_explainTextCount').html("<span>"+content.length+"</span> / 1000");    //글자수 실시간 카운팅

      if (content.length > 1000){
          alert("최대 1000자까지 입력 가능합니다.");
          $(this).val(content.substring(0, 1000));
          $('#check_explainTextCount').html("<span>1000</span> / 1000");
      }
    });

    // 글자수 카운트 (제목쪽)
    $('#titleText').keyup(function (e){
    var content = $(this).val();
    $('#check_TitleCount').html("<span>"+content.length+"</span> / 100");    //글자수 실시간 카운팅

      if (content.length > 100){
          alert("최대 100자까지 입력 가능합니다.");
          $(this).val(content.substring(0, 100));
          $('#check_TitleCount').html("<span>100</span> / 100");
      }
    });

    const categorylabel = document.getElementsByClassName('categorylabel');


    for (var i = 0; i < 14; i++) {

      categorylabel.item(i).addEventListener('click',(event)=>{
        for (var j = 0; j < 14; j++) {
            categorylabel.item(j).style.color='#3b3b3b';
        }
        event.target.parentNode.style.color='#0099ff';
     });
    }

    function inputNumberFormat(obj) {
    obj.value = comma(uncomma(obj.value));
    }
    function comma(str) {
        str = String(str);
        return str.replace(/(\d)(?=(?:\d{3})+(?!\d))/g, '$1,');
    }
    function uncomma(str) {
        str = String(str);
        return str.replace(/[^\d]+/g, '');
    }


    //가격흥정가능 버튼 on off 제어
    function checkPricepNegotiation() {
      var priceCheckImg = document.getElementById('priceCheckImg');
      var priceCheckText = document.getElementById('priceCheckText');
      var price_check = document.getElementById('price_check');

      if (priceCheckText.className == "priceCheck_on"){
        priceCheckImg.src = "img/priceCheckOffBtn.png";
        priceCheckText.className = "priceCheck_off"
        price_check.value = "2";
      }
      else {
        priceCheckImg.src ="img/priceCheckOnBtn.png";
        priceCheckText.className = "priceCheck_on"
        price_check.value = "1";
      }

    }
  </script>
  <script type="text/javascript">




  </script>
</html>
<?php } ?>
