<?php
  require_once("modules/db.php");
  $reasons = new Reasons;
  $mb_del = new Member;
  $om_del = new Oauths;
  $mb_id = Post("mb_id", 'null');
  $om_id = Post("om_id", 'null');
  // echo $mb_id;
  // echo $om_id;
  $sau = Post("sau", null);
  // echo $sau;
  if($sau == null){
    userGoto("사유를 선택해주세요", '');
    exit;
  }else{
    // echo "???";
    $reasons_del = $reasons->Reason_count($sau);
    // echo "???";
    if($mb_id != 'null'){
      $mb_dels = $mb_del->Member_Delete($mb_id);
    }elseif($om_id != 'null'){
      // echo "???";
      $om_del_select = $om_del->Om_select($om_id);
      foreach ($om_del_select as $om_del_selects) {
        // echo $om_del_selects["om_company"];
        // echo $om_del_selects["om_access_token"];
        $om_dels = $om_del->Oauth_Delete($om_id,$om_del_selects["om_company"],$om_del_selects["om_access_token"]);
      }

    }

    // echo "???";
    //api 회원 탈퇴 부분 정의 하기
  }

?>
