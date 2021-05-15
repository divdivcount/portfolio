<?php
// Load Modules
require_once('modules/db.php');
require_once('modules/notification.php');
$dao = new Pay_history();
// print_r($_SESSION["cart"]);
// $cart = explode(',', $_SESSION["cart"]);
// for ($i = 0; $i < count($cart); $i+=4) {
//
//         $var = $cart[$i];
//         if(!empty($var)){
//         $id = $cart[$i + 1];
//         $price = $cart[$i + 2];
//         $name = $cart[$i + 3];
//         $d[$var][$id]["price"] = $price;
//         $d[$var][$id]["name"] = $name;
//         $d[$var][$id]["qty"]++;
//       }
//     }
$mb_num =Get("mb_num",null);//empty($_REQUEST["mb_num"]) ? "" : $_REQUEST["mb_num"];
$mb_id = Get("mb_id",null);//empty($_REQUEST["mb_id"]) ? "" : $_REQUEST["mb_id"];
$num = Get("num",null);//empty($_REQUEST["num"]) ? "" : $_REQUEST["num"];
$var =Get("var",null);//empty($_REQUEST["var"]) ? "" : $_REQUEST["var"];
$id =Get("id",null);//empty($_REQUEST["id"]) ? "" : $_REQUEST["id"];
$name =Get("name",null);// empty($_REQUEST["name"]) ? "" : $_REQUEST["name"];

// unset($d[$var][$id]);
// $_SESSION["cart"] = "";
// if(!($id && $var && $name)){
//   header("Location:basket.php");
// }else{
//  unset($_SESSION["cart"][$var][$id]);
//   // foreach ($d as $cat_key => $cat_arr) {
//   //     foreach ($cat_arr as $id_key => $id_val) {
//   //       for ($i = 0; $i < $id_val["qty"]; $i++) {
//   //           $_SESSION["cart"] .= "$cat_key,$id_key,$id_val[price],$id_val[name],";
//   //       }
//   //     }
//   //   }
//     header("Location:basket.php");
// }
if(!($id && $var && $name)){
  $timestamp = strtotime("Now");
  $now = date("Y-m-d H:i:s", $timestamp);
  $d = empty($_SESSION["cart"]) ? "" : $_SESSION["cart"];
  $last_id = 0;
  foreach ($d as $cat_key => $cat_arr) {
      foreach ($cat_arr as $id_key => $id_val) {
         $pr_img = $id_val["img"];
         echo $pr_img;
         $pr_name = $id_val["name"];
         $pr_qty = $id_val["qty"];
         $pa = $id_val["price"]*$id_val["qty"];
        ?>
        <table>
        <tr>
          <td>
          <?= $cat_key ?>
          </td>
          <td>
          <?= $id_key ?>
          </td>
          <td>
            <img src="<?= $pr_img ?>" width="75px" height= "75px" />
          </td>
          <td>
          <?= $pr_name ?>
          </td>
          <td>
          <?= $pa ?>
          </td>
          <td>
          <input type="text" id="qty<?= $k ?>" name="qty" value="<?= $pr_qty ?>" readonly/>
          </td>
        </tr>
      </table>
        <?php

        $last_id = $dao -> Gohistory($cat_key, $id_key, $pr_img, $pr_name, $pa, $pr_qty, $mb_num,$num,$now,$last_id);
        //구매 이력을 데베로 넣을때 하나씩 들어감
        //문제 1 총 합계가 계속 들어가는 문제
        //테이블은 나눠서 하는것인가
      }
    }
    $m_dao = new ProDAO();
    $m_result = $m_dao ->UserSelectAll($mb_num);
    $rating = 4;
    ?>
    <!-- 결제를 하면 등급이 찍힘 -->
    <?php foreach($m_result as $m_row){
      $m_row["mem_rating_name"]."m_등급<br>";
      $m_row["p_num"]."m_총 값<br>";
      $m_row["mb_id"]."m_아이디<br>";
      echo $m_row["mem_rating_name"]."m_등급<br>";
      echo $m_row["p_num"]."m_총 값<br>";
      echo $m_row["mb_id"]."m_아이디<br>";
      if($m_row["p_num"] >= 1500000){
        $rating = 1;
      }elseif($m_row["p_num"] >= 999999){
        $rating = 2;
      }elseif($m_row["p_num"] > 50000){
        $rating = 3;
      }else{
        $rating = 4;
      }
    }
    ?>
    <?php
    echo $mb_num."<br>";
    echo $num."<br>";
    echo $mb_id."<br>";
    echo "<br>등급".$rating."등급<br>";
    $dao -> Gopay($mb_num,$num,$rating ,$mb_id);
    unset($_SESSION["cart"]);
    // header("Location:User_basket.php");
    userGoNow("User_basket.php");

}else{
  unset($_SESSION["cart"][$var][$id]);
  if(empty($_SESSION["cart"][$var])) {
    unset($_SESSION["cart"][$var]);
  }
  userGoNow("User_basket.php");
}
?>
