<?php
  error_reporting(E_ALL);
  ini_set('display_errors', '1');
  require_once("modules/admin.php");
  $dao = new Product;
  $pid = Get('p', 1);

  if(isset($_SESSION['ss_mb_id']) && $_SESSION['ss_mb_id'] !== 'admin'){
    echo "<script>alert('로그인을 해주세요');</script>";
    echo "<script>location.replace('./index.php');</script>";
    exit;
  }
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="css/admin_product_list.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
  <div class="container">
    <div class="search">
      <form action="admin_product_list.php" method="get" id="fromid">
        <input type="text" placeholder="제목, 작성자, 호선, 역 등 검색" name="s_value">
        <input type="hidden" name="p" value="<?=$pid?>">
      </form>
    </div>
    <div class="search_button">
      <button type="button" id="btn_search" onclick="btn_s()">검색하기</button>
    </div>
    <div class="content">
      <div class="content_table">
        <p>게시글</p>
        <table>
        <tr>
          <th>글 제목</th>
          <th>해당 위치(호선, 역)</th>
          <th>작성 일자</th>
          <th>관심 수</th>
          <th>신고 수</th>
        </tr>
        <?php
          try {
            $s_value = Get('s_value', null);
            if(empty($s_value) == true){
              $result = $dao->admin_SelectPageLength($pid, 8, 'null','null','');
              $list = $dao->admin_SelectPageList($result['current'], 8, 'null','null','');
              // echo "none";
            }else{
              $result = $dao->admin_SelectPageLength($pid, 8,  'null','null',$s_value);
              $list = $dao->admin_SelectPageList($result['current'], 8, 'null','null',$s_value);
              // echo "go";
              // echo $s_value;
            }
          } catch (PDOException $e) {
            $result = null;
            $list = null;
           echo $e->getMessage();
          }
        ?>

        <?php foreach ($list as $admin_list): ?>
          <tr class="content_tr" style="cursor:pointer;" onclick="location.href='admin_product_detail.php?id=<?=$admin_list["pr_id"]?>'">
            <td><?=$admin_list["pr_title"]?></td>
            <td><?=$admin_list["l_name"]?> <?=$admin_list["pr_station"]?></td>
            <td><?=substr($admin_list["pr_date"], 0, 10)?></td>
            <td><?=$admin_list["i_count"]?></td>
            <td><?=$admin_list["rep_count"]?></td>
          </tr>
        <?php endforeach; ?>
        </table>

        <div id="pagenation_box">
          <?php
        if($result['start'] < $result['current'] ) :?>
          <a class="abtn" href="admin_product_list.php?p=<?=($pid - 1)?>">&lt;</a>
          <?php endif ?>

          <?php for($i=$result['start']; $i<=$result['end']; $i++): ?>
          <a class="abtn <?php if($i === (int)$result['current']) echo 'current' ?>" href="?p=<?= $i ?>"><?= $i ?></a>
          <?php endfor ?>

          <?php if( $result['end'] > $result['current']) : ?>
          <a class="abtn" href="admin_product_list.php?p=<?=($pid + 1)?>">&gt;</a>
          <?php endif ?>
      </div>
    </div>
  </div>
</div>
  <script type="text/javascript">
    function btn_s() {
      document.getElementById("fromid").submit();
    }
  </script>
</body>
</html>
