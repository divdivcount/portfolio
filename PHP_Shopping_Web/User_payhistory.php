<?php
// Load Modules
require_once('modules/db.php');
require_once('modules/notification.php');
// 맴버 전체 출력 dao
// $m_dao = new Member();
// $m_result = $m_dao ->SelectAll();
// foreach($m_result as $m_row){
//   $mb_e = $m_row["mb_num"].",";
//   // echo $mb_e;
//   // $mb_result = substr($mb_e , 0, -1);
//   // echo $mb_result;
// }
// 세션 값 아이디 하나 불러오는 mysqli
$mb_id = $_SESSION['ss_mb_id'];
$sql = " select * from member where mb_id = TRIM('$mb_id') ";
$result = mysqli_query($conn, $sql);
$mb = mysqli_fetch_assoc($result);
mysqli_close($conn); // 데이터베이스 접속 종료

$link = "payhistory";
$dao = new Pay_history();
$start_s_value = empty($_REQUEST["start_s_value"]) ? "" : $_REQUEST["start_s_value"];
$s_value = empty($_REQUEST["s_value"]) ? "" : $_REQUEST["s_value"];
$result = $dao ->SelectHistory($s_value, $start_s_value);
// echo $result["mb_num"];
$u_delivery = "반품접수됨";
$pid = Get('p', 1);
if(!$mb['mb_num']){
?>
  <script>
    alert("로그인이 필요합니다.");
    history(location.href="login.php");
  </script>
<?php }else{ ?>
<!doctype html>
<html>
	<head>
		<?php require_once('modules/form_head.php'); ?>
		<title></title>
	</head>
	<body>
		<div id="header">

		</div>
		<div id="content_container">
			<div id="navigation">

			</div>
			<div>
        <?php if($mb['mb_num']/*1*/){ ?>

          		<div>
          			<form action="User_payhistory.php" method="get">
          				<input id="kk" type="hidden"  name="var" value="<?=$link?>">
                  <input id="kk" type="month" name="start_s_value" value=""><span>~</span>
          				<input id="kk" type="month" id="currnetMonth" name="s_value" value="">
          				<input type="submit" value="검색">
          		  </form>
                <!-- <script>
                  document.getElementById('currnetMonth').value= new Date().toISOString().slice(0, 7);
                </script> -->
          		</div>

            <?php $priv_order_id = 0; ?>
        				<?php foreach ($result as $row) : ?>

                  <!--current_id = 0 -->
                  <?php
                      if($mb['mb_num'] == $row["mb_num"]){
                        // if ($priv_order_id != $row["order_id"]) {
                      	// 	echo "새 주문 건 시작";
                      	// }
                        //   $priv_order_id = $row["order_id"];
                        if ($priv_order_id != $row["order_id"]) {
                        		if ($priv_order_id != 0) {
                        			echo "이 주문 건의 총액: ", $priv_total."<br>";
                              $pu_banpum  = $row["pu_banpum_check"];
                        		}

                            ?>
                            <?php
                        		echo "새 주문 건 시작"."\t<span class=''>구매 일시:".$row["date_format(pr_now,'%Y-%m')"]."</span>"."<br>";
                        	}
                            $priv_order_id = $row["order_id"];
                            $priv_total = $row["pr_num"];

                            // echo $row["pr_num"];
                          ?>

                        <ul class="list">
                      <div style="width:25%; height:50px;"class="text_field">
              					<li class="list-li">주문 번호 :<?= $row['order_id'] ?></li>
                        <br>
                        <br>
                        <br>
                        <li class="list-li">물품 아이디 : <?= $row['pu_id'] ?></li>
                      </div>
              					<li class="list-li image_box"><img src="<?= $row['pr_img'] ?>" width="124px" height="124px" /></li>
              					<div class="text_field">
              						<li class="list-li name_field"><?= $row['pr_name'] ?></li>
              						<li class="list-li date_text">주문수량 :<?= $row['pr_qty'] ?></li>
              					</div>
              						<li class="vertical"><?= $row['pa'] ?>원</li>
                          <li class="vertical">주문상태 :<?= $row['pu_besong'] ?></li>
                          <form action="admin_delivery_ok.php" method="get">
                            <input type="hidden" name="order_id_sel_rm" value="<?=$row["order_id"]?>">
                            <input type="hidden" name="mb_num_sel_rm" value="<?=$row["mb_num"]?>">
                            <input type="hidden" name="mb_sel_rm" value="<?=$u_delivery?>">
                            <input type="hidden" name="pu_banpum_check" value="<?=$row["pu_banpum_check"]?>">
                            <input type="hidden" name="id_key" value="<?= $row["id_key"] ?>">
                            <input style="margin-top:20px;" id="<?=$row["order_id"]?>" onclick="ban_check(this.id)" <?php if($row["pu_banpum_check"] > 0){echo "class='button_joinus btn btn-sm btn-primary'" ;}else{echo "class='btn btn-sm btn-primary' disabled='disabled' ";} ?> type="submit"  value="반품신청">
                          </form>
              					</ul>
                        <?php

                        ?>
                    <?php  } ?>
                    <?php endforeach; ?>
                      <?php
                      if(empty($priv_total)){
                        echo "";
                      }else{
                        echo "이 주문 건의 총액: ", $priv_total."<br>";
                        ?>
                        <!-- <form action="admin_delivery_ok.php" method="get">
                          <input type="hidden" name="order_id_sel_rm" value="<?=$row["order_id"]?>">
                          <input type="hidden" name="mb_num_sel_rm" value="<?=$row["mb_num"]?>">
                          <input type="hidden" name="mb_sel_rm" value="<?=$u_delivery?>">
                          <input id="<?=$row["order_id"]?>" onclick="ban_check(this.id)" <?php if($row["pu_banpum_check"] > 0){echo "class='button_joinus btn btn-sm btn-primary'" ;}else{echo "class='btn btn-sm btn-primary' disabled='disabled' ";} ?> type="submit" value="반품신청">
                        </form> -->

                        <script>
                        function ban_check(clicked_id){
                          var button_joinus = document.getElementById(clicked_id);
                        }
                        </script>

                        <?php
                      }

          }else{
            ?>
            <script>
              alert("로그인이 필요합니다");
            </script>
            <?php
            userGoNow("login.php");
              // header("Location:login.php");
          }
             ?>
			</div>
		</div>
		<div id="footer">
			<?php
			 ?>
		</div>
  <?php }?>

	</body>
</html>
