<?php
  require_once("modules/admin.php");
  $dao = new Product;
  $pid = Get('p', 1);
  // echo $_SESSION["ss_mb_id"];
  //   var_dump(isset($_SESSION['ss_mb_id']) && $_SESSION['ss_mb_id'] !== 'admin');
  if(isset($_SESSION['ss_mb_id']) && $_SESSION['ss_mb_id'] !== 'admin'){
    echo "<script>alert('로그인을 해주세요');</script>";
    echo "<script>location.replace('./index.php');</script>";
    exit;
  }
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <style media="screen">
      tbody tr:hover{background-color:orange};
    </style>
  </head>
  <body>
    <div>
      <form action="admin_product_list.php" method="get">
        <input type="hidden" name="p" value="<?=$pid?>">
        <input type="text" name="s_value" >
        <input type="submit" value="검색하기">
      </form>
    </div>
    <div>
        <table style="width : 100%;">
            <thead style="width : 100%;">
              <tr>
                <th>
                  글 제목
                </th>
                <th>
                  해당 위치(호선, 역)
                </th>
                <th>
                  작성 일자
                </th>
                <th>
                  관심 수
                </th>
                <th>
                  신고 수
                </th>
              </tr>
            </thead>
            <?php
              try {
                $s_value = Get('s_value', null);
                if(empty($s_value) == true){
                  $result = $dao->SelectPageLength($pid, 8, 'null','null','','');
                  $list = $dao->SelectPageList($result['current'], 8, 'null','null','','');
                  // echo "none";
                }else{
                  $result = $dao->SelectPageLength($pid, 8,  'null','null',$s_value,'');
                  $list = $dao->SelectPageList($result['current'], 8, 'null','null',$s_value,'');
                  // echo "go";
                  // echo $s_value;
                }
              } catch (PDOException $e) {
                $result = null;
                $list = null;
               echo $e->getMessage();
              }
            ?>
            <tbody style="width : 100%;">
              <?php foreach ($list as $admin_list): ?>
                <tr style="cursor:pointer;" onclick="location.href='admin_product_detail.php?id=<?=$admin_list["pr_id"]?>'">
                  <td><?=$admin_list["pr_title"]?></td>
                  <td><?=$admin_list["l_name"]?> <?=$admin_list["pr_station"]?></td>
                  <td><?=$admin_list["pr_date"]?></td>
                  <td><?=$admin_list["i_count"]?></td>
                  <td><?=$admin_list["rep_count"]?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div id="pagenation_box"class="w3-center">
        <?php
        if($result['start'] < $result['current'] ) :?>
          <a class="abtn" href="admin_product_list.php?p=<?=($pid - 1)?>&s_value=<?=$s_value?>">&lt;</a>
        <?php endif ?>

        <?php for($i=$result['start']; $i<=$result['end']; $i++): ?>
          <a class="abtn <?php if($i === (int)$result['current']) echo 'current' ?>" href="?p=<?= $i ?>&s_value=<?=$s_value?>"><?= $i ?></a>
        <?php endfor ?>

        <?php if( $result['end'] > $result['current']) : ?>
          <a class="abtn" href="admin_product_list.php?p=<?=($pid + 1)?>&s_value=<?=$s_value?>">&gt;</a>
        <?php endif ?>
    </div>
  </body>
</html>
