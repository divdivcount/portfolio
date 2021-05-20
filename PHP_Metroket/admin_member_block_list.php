<?php
  require_once("modules/admin.php");
  $dao = new Member;
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
  <link rel="stylesheet" href="css/admin_member_list.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
  <div class="container">
    <div class="search">
      <form action="admin_member_block_list.php" method="get" id="fromid">
        <input type="text" placeholder="전체 회원 검색" name="s_value">
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
          <th>회원 이름</th>
          <th>회원 아이디</th>
          <th>인증 받은 이메일</th>
          <th>가입일</th>
          <th>해당 위치(호선, 역)</th>
          <th>신고 수</th>
        </tr>
        <?php
              try {
                $s_value = Get('s_value', null);
                if(empty($s_value) == true){
                  $result = $dao->mem_SelectPageLength($pid, 8, 'admin','null','');
                  $list = $dao->mem_SelectPageList($result['current'], 8, 'admin','null','');
                  // echo "none";
                }else{
                  $result = $dao->mem_SelectPageLength($pid, 8,  'admin','null',$s_value);
                  $list = $dao->mem_SelectPageList($result['current'], 8, 'admin','null',$s_value);
                  // echo "go";
                  // echo $s_value;
                }
              } catch (PDOException $e) {
                $result = null;
                $list = null;
               echo $e->getMessage();
              }
            ?>

              <?php foreach ($list as $admin_lists): ?>
                <tr style="cursor:pointer;" onclick="location.href='admin_member_detail.php?all=<?=$admin_lists["mb_name"]?>&mball=<?=$admin_lists["mb_id"]?>'">
                  <td><?=$admin_lists["mb_name"]?></td>
                  <td><?=$admin_lists["mb_id"]?></td>
                  <td><?=$admin_lists["mb_email"]?></td>
                  <td><?=substr($admin_lists["mb_datetime"], 0, 10)?></td>
                  <td><?=$admin_lists["line_station"]?></td>
                  <td><?=$admin_lists["rep_count"]?></td>
                </tr>
              <?php endforeach; ?>
        </table>

        <div id="pagenation_box">
          <?php
            if($result['start'] < $result['current'] ) :?>
              <a class="abtn" href="admin_member_block_list.php?p=<?=($pid - 1)?>&s_value=<?=$s_value?>">&lt;</a>
            <?php endif ?>

            <?php for($i=$result['start']; $i<=$result['end']; $i++): ?>
              <a class="abtn <?php if($i === (int)$result['current']) echo 'current' ?>" href="?p=<?= $i ?>&s_value=<?=$s_value?>"><?= $i ?></a>
            <?php endfor ?>

            <?php if( $result['end'] > $result['current']) : ?>
              <a class="abtn" href="admin_member_block_list.php?p=<?=($pid + 1)?>&s_value=<?=$s_value?>">&gt;</a>
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
