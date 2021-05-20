<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
    require_once('modules/db.php');
    $dao = new Interest;
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
<link rel="stylesheet" href="css/css_gansim_sangpum.css">
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<style>

</style>
</head>
<body>
	<div class="w3-content w3-container">

    <!-- 제목 -->
    <h3 class="h3">관심목록 내역</h3>
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

            <!-- 관심버튼 -->
              <?php $imgdao = $dao->searchProduct_detail(isset($mb) ? $mb["mb_num"] : 'null', isset($om) ? $om["om_id"] : 'null',$row['pr_id'], $row['pr_title']); ?>
            <div class="pr_buttons">
              <?php foreach ($imgdao as $rows) : ?>
              <img id="star_btn" src="<?php if($rows["mem_i_check"] == 0){echo "img/staroff_30x30png.png";}elseif($rows["mem_i_check"] == 1){echo "img/star_30x30.png";} ?>" data-value="<?=$rows["mem_i_check"]?>"
            <?php endforeach ?>
             data-pr_id="<?= $row['pr_id'] ?>" onclick="check_interest(this)" />
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
            <div class="pr_starcount">
              <div style="display:flex"><img src="img\star_19x19.png"></div>
              <?=$row['i_count'] ?>
            </div>

            <!-- 역 -->
            <div class="pr_station"><?= $row['l_name'] ?> <?= $row['pr_station'] ?></div>
          </div>

          <div class="hidden">
            <?= $row['pr_id'] ?>
          </div>

        </div>
      </div>
    <?php endforeach ?>

    <div id="pagenation_box">
        <?php
        if($result['start'] < $result['current'] ) :?>
          <a class="abtn" href="gansim_sangpum.php?p=<?=($pid - 1)?>">&lt;</a>
        <?php endif ?>

        <?php for($i=$result['start']; $i<=$result['end']; $i++): ?>
          <a class="abtn <?php if($i === (int)$result['current']) echo 'current' ?>" href="?p=<?= $i ?>"><?= $i ?></a>
        <?php endfor ?>

        <?php if( $result['end'] > $result['current']) : ?>
          <a class="abtn" href="gansim_sangpum.php?p=<?=($pid + 1)?>">&gt;</a>
        <?php endif ?>
      </div>
      <?php else: ?>
        <div id="empty_page">
          <img src="img/sad_back.png" alt="">
          <h4>EMPTY</h4>
          <p>
            <span>고객님의 관심 상품 정보가 비어있습니다.</span><br>
            다른 상품을 관심등록 하시면 관련 정보가 보여집니다.
          </p>
        </div>

    <?php endif; ?>

		</div>

	</div>

  <script>
  //관심상품 클릭시 값넘어가는거
  var star_btn = document.getElementById('star_btn');
  function check_interest(e) {
    let pr_id =  e.dataset.pr_id;
    let mb_id = "<?= isset($mb) ? $mb["mb_num"] : 'null' ?>";
    let om_id = "<?= isset($om) ? $om["om_id"] : 'null' ?>";
    if (star_btn.dataset.value == 1) {
      $.ajax({
          url:'gansim_del_ajax.php', //request 보낼 서버의 경로
          type:'post', // 메소드(get, post)
          data:{pr_id : pr_id, mb_id:mb_id,om_id:om_id}, //보낼 데이터
          success: function(data) {
              //서버로부터 정상적으로 응답이 왔을 때 실행
              location.reload(true);
          },
          error: function(err) {
              //서버로부터 응답이 정상적으로 처리되지 못햇을 때 실행
              alert("관심 상품을 등록하기 위해서 로그인을 먼저 해주세요");
              history.back();
          }
      });
    // let values =star_btn.dataset.value;
    // let pr_id = "";
    // pr_id = e.dataset.pr_id;
    // if (star_btn.dataset.value == 0) {
    //   $.ajax({
    //       url:'search_detail_ajax.php', //request 보낼 서버의 경로
    //       type:'post', // 메소드(get, post)
    //       data:{values:"0", pr_id : pr_id}, //보낼 데이터
    //       success: function(data) {
    //           //서버로부터 정상적으로 응답이 왔을 때 실행
    //           $('#star_btn').html(data);
    //           star_btn.src ="img/star_30x30.png";
    //           star_btn.dataset.value = 1;
    //       },
    //       error: function(err) {
    //         alert("관심 상품을 등록하기 위해서 로그인을 먼저 해주세요");
    //         history.back();
    //       }
    //   });
    // }
    // else if (star_btn.dataset.value == 1) {
    //   $.ajax({
    //       url:'search_detail_ajax.php', //request 보낼 서버의 경로
    //       type:'post', // 메소드(get, post)
    //       data:{values:"1", pr_id : pr_id}, //보낼 데이터
    //       success: function(data) {
    //           //서버로부터 정상적으로 응답이 왔을 때 실행
    //           star_btn.src = "img/staroff_30x30.png";
    //           star_btn.dataset.value = 0;
    //       },
    //       error: function(err) {
    //           //서버로부터 응답이 정상적으로 처리되지 못햇을 때 실행
    //           alert("관심 상품을 등록하기 위해서 로그인을 먼저 해주세요");
    //           history.back();
    //       }
    //   });
    // }
}}

  </script>
</body>
</html>
<?php } ?>
