<?php
  require_once("modules/db.php");
  require_once("modules/notification.php");
  error_reporting(E_ALL);
  ini_set('display_errors', '1');
  $type = null;
  if(isset($_SESSION['ss_mb_id'])){
    $id = $_SESSION['ss_mb_id'];
    $type = 'MB';
    $sql = " select * from member where mb_id = TRIM('$id') ";
  }elseif(isset($_SESSION['naver_mb_id'])){
    $id = substr($_SESSION['naver_mb_id'], 5);
    $type = 'OM';
    $sql = " select * from oauth_member where om_id = TRIM($id) ";
  }elseif(isset($_SESSION['kakao_mb_id'])){
    $id = substr($_SESSION['kakao_mb_id'], 5);
    $type = 'OM';
    $sql = " select * from oauth_member where om_id = TRIM($id) ";
  }else{
    // 꺼즈어
?>
    <script>
      alert('로그인 후 이용할 수 있습니다.');
      history.back();
    </script>
<?php
    exit;
  }
  $result = mysqli_query($conn, $sql);
  // 멤버 정보 가져오기
  $memberInfo = mysqli_fetch_assoc($result);

  // 댓글 가져오기
  $rno = $_GET['rno']; // 댓글 번호
  $bno = $_GET['b_no']; // pr_id
  $sql = "select * from reply where idx=$rno";
  $replys = mysqli_query($conn, $sql);
  $replyss = mysqli_fetch_assoc($replys);

  // 제품 정보 가져오기
  $sql = "select * from product where pr_id=$bno";
  $pro_board = mysqli_query($conn, $sql);
  $pro_boards = mysqli_fetch_assoc($pro_board);

  if($type === 'MB' && $memberInfo['mb_num'] === $replyss['mb_id']);
  else if($type === 'OM' && $memberInfo['om_id'] === $replyss['om_id']);
  else {
?>
      <script>
        alert('본인의 댓글이 아닙니다.');
        history.back();
      </script>
<?php
    exit;
  }
  // echo $all_id."all_id";
  // echo $replyss['mb_id'];
  // echo $replyss['om_id'];
  // var_dump($all_id == $replyss['mb_id']);
  // var_dump($all_id == $replyss['om_id']);
  $sql = mq("delete from reply where idx=$rno");
  userGoto("댓글이 삭제되었습니다.","");
?>
