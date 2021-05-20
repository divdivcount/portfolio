<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
    require_once('modules/db.php');
    $dao = new Product_history;
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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="css/css_noamlfont.css">
<link rel="stylesheet" href="css/css_buy_sangpum.css">
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
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
          $result = $dao->SelectPageLength($pid, 4, isset($mb_id) ? $mb_id : 'null', isset($om_id) ? $om_id : 'null','');
          $list = $dao->SelectPageList($result['current'], 4, isset($mb_id) ? $mb_id : 'null', isset($om_id) ? $om_id : 'null','');
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


      <!-- 상품 정보  -->
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
            <div class="pr_station"><?= $row['pr_station'] ?></div>
          </div>


        </div>
      </div>
    <?php endforeach ?>

    <div id="pagenation_box">
        <?php
        if($result['start'] < $result['current'] ) :?>
          <a class="abtn" href="buy_sangpum.php?p=<?=($pid - 1)?>">&lt;</a>
        <?php endif ?>

        <?php for($i=$result['start']; $i<=$result['end']; $i++): ?>
          <a class="abtn <?php if($i === (int)$result['current']) echo 'current' ?>" href="?p=<?= $i ?>"><?= $i ?></a>
        <?php endfor ?>

        <?php if( $result['end'] > $result['current']) : ?>
          <a class="abtn" href="buy_sangpum.php?p=<?=($pid + 1)?>">&gt;</a>
        <?php endif ?>
      </div>
      <?php else: ?>

        <div id="empty_page">
          <img src="img/sad_back.png" alt="">
          <h4>EMPTY</h4>
          <p>
            <span>고객님의 구매 상품정보가 비어있습니다.</span><br>
            구매 상품을 올리면 정보가 보여집니다.
          </p>
        </div>

    <?php endif; ?>

		</div>

	</div>

  <script>
  </script>
</body>
</html>
<?php } ?>
