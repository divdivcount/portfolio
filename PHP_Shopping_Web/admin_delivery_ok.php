<?php
// Load Modules
require_once('modules/notification.php');
require_once('modules/db.php');

//admin_ajax
$p_id_key = Get("p_id_key",null);//empty($_GET["p_id_key"]) ? "" : $_GET["p_id_key"];
$mb_num = Get("mb_num", null); //empty($_GET["mb_num"]) ? "" : $_GET["mb_num"];// 회원번호
$p_id = Get("p_id", null);//empty($_GET["p_id"]) ? "" : $_GET["p_id"];//주문번호
$besong= Get("besong", null);//empty($_GET["besong"]) ? "" : $_GET["besong"];//주문내용
// echo "<br>".$mb_num."<br>";
// echo "<br>".$p_id."<br>";
// echo "<br>".$besong."<br>";
if($mb_num&&$p_id&&$besong){
  $dao1 = new ProDAO();
  if(strcmp($besong,"반품 완료") == 0){
    $dao1->Admin_delivery($mb_num,$p_id,$besong,$p_id_key);
    // echo "<br>1<br>";
    // echo "<br>"."$p_id_key"."<br>";
  }else{
    $dao1->Admin_delivery($mb_num,$p_id,$besong);
    echo "2";
  }
  ?>
  <script>
      alert("배송 현황이 완료되었습니다.");
      history.back();
  </script>
  <?php
}else{
  // echo "Admin_delivery";
}
//payhistory
$id_key = Get("id_key",null);
$order_id_sel_rm = Get("order_id_sel_rm",null);//주문번호
$mb_num_sel_rm = Get("mb_num_sel_rm",null);// 회원번호
$mb_sel_rm  = Get("mb_sel_rm",null);//환불 처리중
$pu_banpum_check = Get("pu_banpum_check",null);//버튼 비활성화
$pu_banpum_check = 0;
if($order_id_sel_rm&&$mb_num_sel_rm&&$mb_sel_rm){
  $dao = new ProDAO();
  $dao->User_delivery($order_id_sel_rm,$mb_num_sel_rm,$mb_sel_rm, $pu_banpum_check,$id_key);
  ?>
  <script>
      alert("반품 신청이 완료되었습니다.");
      history.back();
  </script>
  <?php
}else{
  // echo "User_delivery";
}
?>
