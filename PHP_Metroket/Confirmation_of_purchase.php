<?php
  error_reporting(E_ALL);
  ini_set('display_errors', '1');
  require_once("modules/db.php");
  require_once("modules/notification.php");
  $product_history = new Product;
  $pr_id = Post("pr_id", 0);
  $member_checkId = Post("selectId", null);
  $admin = "admin";
  $time = date("Y-m-d H:i:s");
  $recive = '0000-00-00 00:00:00';
  $memo_text = "거래가 성공적으로 완료되었습니다. 내역은 마이페이지에서 확인 가능합니다.";
  // echo $pr_id;
  // echo $member_checkId;

  // echo $pr_id;
  // echo $member_checkId;
  if(!($pr_id && $member_checkId)){
    echo "<script>alert('구매자의 아이디를 선택 하지 않으셨습니다.');</script>";
    echo "<script>history.back();</script>";
    exit;
  }
  if(!(is_null($member_checkId))){
    $dao = new Member;
    $member = $dao->admin_Member_id_all_select($member_checkId);
    // var_dump($member);

    if(is_null($member)){
      // echo "이곳과";
      $dao = new Oauths;
      $other_member = $dao->admin_Om_select($member_checkId);
      $product_history->Product_status_update($pr_id,null,$other_member[0]["om_id"],$time);
      $dao->admin_om_waring_send($other_member[0]["om_id"], $admin, $time, $recive,$memo_text);
    }else{
      // echo "이곳";
      $product_history->Product_status_update($pr_id,$member[0]["mb_num"],null,$time);
      $dao->admin_waring_send($member[0]["mb_id"], $admin, $time, $recive,$memo_text);
    }
  }
  // userGoto("판매 완료 처리가 되었습니다.","");
 ?>
