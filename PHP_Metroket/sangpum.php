<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
    require_once('modules/db.php');
    require_once('modules/notification.php');
    $dao = new Product;
    $pid = Get('p', 1);

  if(empty($_SESSION['ss_mb_id']) && empty($_SESSION['naver_mb_id']) && empty($_SESSION['kakao_mb_id']) ){
        echo "<script>alert('로그인을 해주세요');</script>";
        echo "<script>location.replace('./index.php');</script>";
  }else{

    if(isset($_SESSION['ss_mb_id'])){
      $mb_ids = $_SESSION['ss_mb_id'];
      $sql = " SELECT * FROM member WHERE mb_id = '$mb_ids' ";
      $result = mysqli_query($conn, $sql);
      $mb = mysqli_fetch_assoc($result);
      $mb_id = $mb['mb_num'];
    }elseif(isset($_SESSION['naver_mb_id'])){
      $mb_ids = $_SESSION['naver_mb_id'];
      $mb_ids = substr($mb_ids, 5);
      $sql = " SELECT * FROM oauth_member WHERE om_id = $mb_ids ";
      $result = mysqli_query($conn, $sql);
      $om = mysqli_fetch_assoc($result);
      $om_id = $om['om_id'];

    }elseif(isset($_SESSION['kakao_mb_id'])){
      $mb_ids = $_SESSION['kakao_mb_id'];
      $mb_ids = substr($mb_ids, 5);
      $sql = " SELECT * FROM oauth_member WHERE om_id = $mb_ids ";
      $result = mysqli_query($conn, $sql);
      $om = mysqli_fetch_assoc($result);
      $om_id = $om['om_id'];
    }else{
      ?>
      <script>
        alter("어느것도 로그인되지 않았습니다.");
        location.replace("./index.php");
      </script>
      <?php
    }
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="css/css_noamlfont.css">
<link rel="stylesheet" href="css/css_sangpum.css">
<link rel="stylesheet" href="css/jquery.tzSelect/tzSelect/jquery.tzSelect.css">
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.3/jquery.min.js"></script>
<script src="css/jquery.tzSelect\tzSelect/jquery.tzSelect.js"></script>


<style>

</style>
</head>
<body>
	<div class="w3-content w3-container">

    <!-- 제목 -->
    <h3 class="h3">판매 내역</h3>
    <?php
      try {
          // $start_s_value = empty($_REQUEST["start_s_value"]) ? "" : $_REQUEST["start_s_value"];
          // $s_value = empty($_REQUEST["s_value"]) ? "" : $_REQUEST["s_value"];
          // if($start_s_value){
          // 	$result = $dao->SelectPageLength($pid, 10, $s_value, $start_s_value);
          //   $list = $dao->SelectPageList($result['current'], 10,$s_value, $start_s_value);
          // }else{
          $result = $dao->SelectPageLength($pid, 4, isset($mb_id) ? $mb_id : 'null', isset($om_id) ? $om_id : 'null','','');
          $list = $dao->SelectPageList($result['current'], 4, isset($mb_id) ? $mb_id : 'null', isset($om_id) ? $om_id : 'null','','');
        // }
      } catch (PDOException $e) {
        $result = null;
        $list = null;
       echo $e->getMessage();
      }
    ?>

    <?php if ($list): ?>
    <!-- 상품 나오는 박스  -->
		<div class="productList_box">

      <?php foreach ($list as $row) : ?>

      <div class="productInfo_box">

        <!-- 상품 이미지  -->
        <div class="productInfo_part_img">
          <div class="img_box"><img src="files/<?= $row['pr_img'] ?>" width="100%" height="100%" /></div>
        </div>

        <!--   상품 관련 텍스트정보 -->
        <div class="productInfo_part_text">

          <!-- 1. 제목라인 -->
          <div class="productTitle_line">

            <!-- 제목 -->
            <div class="pr_title"><?= $row['pr_title'] ?></div>

            <!-- 버튼들 -->
            <div class="pr_buttons" data-sell_check ="<?= $row['pr_status'] ?>">
              <button type="button" class="reviseProduct_btn w3-button w3-blue w3-round" onclick="updateProduct(<?=$row["pr_id"]?>,<?=isset($mb) ? $mb["mb_num"] : 'null'?>, <?= isset($om) ? $om["om_id"] : 'null' ?>)">수정하기</button>
              <button type="button" class="completeSale_btn w3-button w3-light-grey w3-round" onclick="selectBuyer_open(<?=$row['pr_id']?>)">판매완료</button>
              <form method="post" style="display:flex">
                <input type="hidden" name="pr_id" value="<?=$row['pr_id']?>">
                <button type="submit" name="product_del" id="product_del" class="deleteProduct_btn w3-button w3-dark-grey w3-round">삭제하기</button>
                <button type="button" id="updateBuyer_btn" class="updateBuyer_btn w3-button w3-indigo w3-round" onclick="changeBuyer_open(<?=$row['pr_id']?>)">판매수정</button>
              </form>
            </div>
          </div>
          <!--  2. 판매여부 라인 -->
          <div class="checkSale_line">
            <?= $row['pr_status'] ?>
          </div>

          <!-- 3. 상품가격라인 -->
          <div class="productPrice_line">
            <?= $row['pr_price'] ?>
          </div>

          <!-- 4. 별점과 역정보 라인 -->
          <div class="productRecommendation_line">

            <!-- 별점  -->
            <div class="pr_starcount"><img src="img\star_19x19.png" style="width:1.9rem;height:1.9rem"><?=$row['i_count'] ?></div>

            <!-- 역 -->
            <div class="pr_station"><?= $row['l_name'] ?> <?= $row['pr_station'] ?></div>
          </div>

          <div class="hidden">
            <?= $row['pr_id'] ?>
          </div>

        </div>

      </div>
    <?php endforeach ?>



    <div id="pagenation_box"class="w3-center">
        <?php
        if($result['start'] < $result['current'] ) :?>
          <a class="abtn" href="sangpum.php?p=<?=($pid - 1)?>">&lt;</a>
        <?php endif ?>

        <?php for($i=$result['start']; $i<=$result['end']; $i++): ?>
          <a class="abtn <?php if($i === (int)$result['current']) echo 'current' ?>" href="?p=<?= $i ?>"><?= $i ?></a>
        <?php endfor ?>

        <?php if( $result['end'] > $result['current']) : ?>
          <a class="abtn" href="sangpum.php?p=<?=($pid + 1)?>">&gt;</a>
        <?php endif ?>
    </div>
    <?php else: ?>

      <div id="empty_page">
        <img src="img/sad_back.png" alt="">
        <h4>EMPTY</h4>
        <p>
          <span>고객님의 상품정보가 비어있습니다.</span><br>
          판매 상품을 올리면 정보가 보여집니다.
        </p>
      </div>

  <?php endif; ?>

		</div>

	</div>
  <?php
    function product_del(){
      $dao = new Product;

      $pr_id = Post("pr_id", null);
      $dao->admin_product_del($pr_id);
    }
    if(array_key_exists('product_del',$_POST))
    {
      product_del();
      userGoto("상품을 삭제 하셨습니다", "");
    }
   ?>
  <script>

    //   판매여부에따라 버튼 출력 방식
    var reviseProduct_btn = document.getElementsByClassName('reviseProduct_btn');
    var completeSale_btn = document.getElementsByClassName('completeSale_btn');
    var deleteProduct_btn =   document.getElementsByClassName('deleteProduct_btn');
    var updateBuyer_btn =   document.getElementsByClassName('updateBuyer_btn');
    var pr_buttons = document.getElementsByClassName('pr_buttons');

    window.onload = function() {
      for (var i = 0; i < pr_buttons.length; i++) {
        if (pr_buttons.item(i).dataset.sell_check == "판매중") { //판매 완료가 false(0)이면  삭제버튼 감추기
          completeSale_btn.item(i).style.display="block";
          reviseProduct_btn.item(i).style.display="block";
          deleteProduct_btn.item(i).style.display="none";
          updateBuyer_btn.item(i).style.display="none";
        }else if (pr_buttons.item(i).dataset.sell_check == "거래완료") { //판매 완료가 true(1)이면  수정 및 판매완료 버튼 감추기
          completeSale_btn.item(i).style.display="none";
          reviseProduct_btn.item(i).style.display="none";
          deleteProduct_btn.item(i).style.display="block";
          updateBuyer_btn.item(i).style.display="block";
        }
      }
    };

    // 판매완료클릭시 구매자선택 모달팝업 오픈
    function selectBuyer_open(p_id) {
      var pr_id = p_id;
      // $.ajax({
      //     url:'return_buyerList.php', //request 보낼 서버의 경로
      //     type:'post', // 메소드(get, post)
      //     data:{pr_id:pr_id}, //보낼 데이터
      //     success: function(data) {
      //       var contact = JSON.parse(data);
      //       parent.document.getElementById('selectBuyer_selectBox').innerHTML = contact.html;
      //       if(contact.emptyCheck == 0){
      //         parent.document.getElementById("selectBuyer_complete_btn").classList.add("hidden");
      //         parent.document.getElementById("selectBuyer_cancle_btn").classList.remove("hidden");
      //       }else if (contact.emptyCheck == 1) {
      //         parent.document.getElementById("selectBuyer_complete_btn").classList.remove("hidden");
      //         parent.document.getElementById("selectBuyer_cancle_btn").classList.add("hidden");
      //       }else{
      //         alert("오류가발생했습니다")
      //       }
      //     },
      //     error: function(err) {
      //         //서버로부터 응답이 정상적으로 처리되지 못햇을 때 실행
      //         alert(err);
      //     }
      // });
      // parent.createSelectBox_changeBuyerModal();
        parent.createSelectBox_selectBuyerModal(pr_id);
        parent.document.querySelector(".my_one_page_modal").classList.remove("hidden");
        parent.document.querySelector(".selectBuyer_modalBox").classList.remove("hidden");
    }


    // 판매수정클릭시 구매자선택 모달팝업 오픈
    function changeBuyer_open(p_id) {
      var pr_id = p_id;
      parent.createSelectBox_changeBuyerModal(pr_id);
    }


    function updateProduct(pr_id, mb_id, om_id) {
      $("#upadteId").submit();
      $.ajax({
          url:'addProduct.php', //request 보낼 서버의 경로
          type:'post', // 메소드(get, post)
          data:{pr_ida : pr_id, mb_ida:mb_id, om_ida:om_id}, //보낼 데이터
          success: function(data) {
              //서버로부터 정상적으로 응답이 왔을 때 실행
              var form = document.createElement('form');
              form.setAttribute('method', 'post');
              form.setAttribute('action', "./addProduct.php");
              form.setAttribute('target', "_top");
               var objs, objs2, objs3;
               objs = document.createElement('input');
               objs.setAttribute('type', 'hidden');
               objs.setAttribute('name', 'pr_ida');      // 받을 네이밍
               objs.setAttribute('value', pr_id);       // 넘길 파라메터
               form.appendChild(objs);

               objs2 = document.createElement('input');
               objs2.setAttribute('type', 'hidden');
               objs2.setAttribute('name', 'mb_ida');      // 받을 네이밍
               objs2.setAttribute('value', mb_id);       // 넘길 파라메터
               form.appendChild(objs2);

               objs3 = document.createElement('input');
               objs3.setAttribute('type', 'hidden');
               objs3.setAttribute('name', 'om_ida');      // 받을 네이밍
               objs3.setAttribute('value', om_id);       // 넘길 파라메터
               form.appendChild(objs3);


               document.body.appendChild(form);
               form.submit();
          },
          error: function(err) {
            alert("오류가 떴다");
          }
      });
      // window.parent.location.replace("./addProduct.php");
    }
  </script>
</body>
</html>
<?php } ?>
