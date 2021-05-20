<?php
  require_once("modules/admin.php");
  $mb_id = Get("id", 'null');
  $om_id = Get("om", 'null');
  // echo $mb_id;
  if($mb_id != 'null'){
    $members = new Member();
    $member  = $members->admin_Member_id_all_select($mb_id);
  }
  // echo $om_id;
  $dao = new Product;
  $pid = Get('p', 1);
?>
<!DOCTYPE html>
<html lang="ko" dir="ltr">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="css/admin_member_detail.css">
  <style type="text/css">
    body {
      overflow-y: hidden;
      background: #fff;
    }
  </style>
</head>
<body>
  <div class="board-content">
    <!-- 제목 -->
    <?php
        try {
            // $start_s_value = empty($_REQUEST["start_s_value"]) ? "" : $_REQUEST["start_s_value"];
            // $s_value = empty($_REQUEST["s_value"]) ? "" : $_REQUEST["s_value"];
            // if($start_s_value){
            // 	$result = $dao->SelectPageLength($pid, 10, $s_value, $start_s_value);
            //   $list = $dao->SelectPageList($result['current'], 10,$s_value, $start_s_value);
            // }else{
            $result = $dao->SelectPageLength($pid, 8, isset($member[0]['mb_num']) ? $member[0]['mb_num'] : 'null', $om_id,'','');
            $list = $dao->SelectPageList($result['current'], 8, isset($member[0]['mb_num']) ? $member[0]['mb_num'] : 'null', $om_id,'','');
          // }
        } catch (PDOException $e) {
          $result = null;
          $list = null;
         echo $e->getMessage();
        }
    ?>
    <?php if ($list): ?>
    <!-- 상품 나오는 박스  -->
    <p>
      <?=isset($list[0]["mb_name"]) ? $list[0]["mb_name"] : $list[0]["om_nickname"]?>님의 게시글
    </p>
    <table>
      <tr>
        <th>글 제목</th>
        <th>해당 위치(호선, 역)</th>
        <th>작성 일자</th>
        <th>관심 수</th>
        <th>신고 수</th>
      </tr>
      <?php foreach ($list as $rows) : ?>
        <tr class="content_tr" style="cursor:pointer;" onclick="location.href='admin_product_detail.php?id=<?=$admin_list['pr_id']?>'">
          <td><?= $rows['pr_title'] ?></td>
          <td><?= $rows['l_name'] ?> <?= $rows['pr_station'] ?></td>
          <td><?=substr($rows["pr_date"], 0, 10)?></td>
          <td><?=$rows['i_count'] ?></td>
          <td><?=$rows["rep_count"]?></td>
        </tr>
    <?php endforeach ?>
    </table>


      <div id="pagenation_box" class="w3-center">
        <?php
          if($result['start'] < $result['current'] ) :?>
        <a class="abtn" href="admin_member_detail_sangpum.php?p=<?=($pid - 1)?>&id=<?=$mb_id?>&om=<?=$om_id?>">&lt;</a>
        <?php endif ?>

        <?php for($i=$result['start']; $i<=$result['end']; $i++): ?>
        <a class="abtn <?php if($i === (int)$result['current']) echo 'current' ?>"
          href="?p=<?= $i ?>&id=<?=$mb_id?>&om=<?=$om_id?>"><?= $i ?></a>
        <?php endfor ?>

        <?php if( $result['end'] > $result['current']) : ?>
        <a class="abtn" href="admin_member_detail_sangpum.php?p=<?=($pid + 1)?>&id=<?=$mb_id?>&om=<?=$om_id?>">&gt;</a>
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
</body>

</html>
