<?php
  require_once('modules/db.php');
  $dao = new Oauths;

  $pr_id = $_POST['pr_id'] ? $_POST['pr_id'] : null;

  $want_member = $dao->memo_select($pr_id);

  if(!(is_null($want_member))){
    $other_member = $dao->admin_Om_select($want_member[0]["me_send_mb_id"]);

    if(is_null($other_member)){
      $dao = new Member;
      $member = $dao->admin_Member_id_all_select($want_member[0]["me_send_mb_id"]);
      // var_dump($member);
      if(is_null($member)){
        // echo "이곳과";
        $dao = new Oauths;
        $other_member = $dao->admin_Om_select($want_member[0]["me_send_mb_id"]);
      }else{
        // echo "이곳";
      }
    }

    echo '{"html":"';
    echo "<select id='selectID' class='fancy_SelectBuyerSelectBox'>";
    echo "<option value='0' selected='selected' data-skip='1'>구매자를 선택해주세요.</option>";
    foreach ($want_member as $rowaa) {
      echo "<option value='";
      echo isset($member[0]["mb_id"]) ? $member[0]["mb_id"] : (isset($other_member[0]["om_id"]) ? $other_member[0]["om_id"] : null);
      echo "' data-icon='";
      echo isset($member[0]["mb_image"]) ? $member[0]["mb_image"] : $other_member[0]["om_iamge_url"];
      echo "' data-html-text='".$rowaa["me_send_mb_id"]."'>";
      echo $rowaa["me_send_mb_id"];
      echo "</option>";
    }
    echo '</select>';
    echo "<input id='salePrid' type='hidden' value='".$pr_id."'>";
    echo '","emptyCheck":1}';
  }else{
    echo '{"html":"';
    echo "<div class='img_box'><img src='img/noResult.png'></div>";
    echo "<p>구매요청자가 없습니다.<br>구매 요청자가 있어야 판매완료가 가능합니다.</p>";
    echo "<input id='salePrid' type='hidden' value='".$pr_id."'>";
    echo '","emptyCheck":0}';
  }

 ?>
