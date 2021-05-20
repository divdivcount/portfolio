<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once('modules/db.php');
require_once('modules/notification.php');

try{
  $interest = new Interest;
  $val = Post("values", null);
  $pr_id = Post("pr_id", null);
  $mb_id = Post("mb_id", 'null');
  $om_id = Post("om_id", 'null');
  // echo $val."val<br>";
  // echo $pr_id."pr_id<br>";
  // echo $mb_id."mb_id<br>";
  // echo $om_id."om_id<br>";
  if($mb_id == 'null' && $om_id == 'null'){
    ?>
    <script>
      alert("관심 상품을 등록하기 위해서 로그인을 먼저 해주세요");
      //로그인 모달창 띄우기
      location.reload();
    </script>
    <?php
    exit;
  }else{


    $inters = $interest->in_delete($pr_id, $mb_id, $om_id);


  }
}catch(PDOException $e){
    echo $e;
  }

?>
