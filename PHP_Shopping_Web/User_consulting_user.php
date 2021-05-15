<?php
  // Load Modules
  require_once('modules/db.php');
  $mb_id = $_SESSION['ss_mb_id'];
  $sql = " select * from member where mb_id = TRIM('$mb_id') ";
  $result = mysqli_query($conn, $sql);
  $mb = mysqli_fetch_assoc($result);
  mysqli_close($conn); // 데이터베이스 접속 종료
?>
<!doctype html>
<html>
	<head>
    <link href="css/css_sub2.css" rel="stylesheet" type="text/css">
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="script/User_consulting.js" charset="utf-8"></script>
</head>
<body>
<main>
  <section class="bg-white" id="sub1">
    <form id="sangdam" action="./User_consulting_upload.php" method="post">
      <input type="hidden" name="mb_num" value="<?= $mb["mb_num"] ?>" readonly>
      <div>
        <span>상담자 이름</span>
        <div><input type="text" name="name" value="<?= $mb["mb_name"]?>" readonly></div>
      </div>
      <div>
        <span>이메일</span>
        <div><input type="text" name="email" value="<?= $mb["mb_email"]?>"  readonly/></div>
      </div>
      <div>
        <span>상담 내용</span>
        <div><textarea name="content" rows="8" placeholder="상담내용을 입력해주세요."></textarea></div>
      </div>
    </form>
    <div>
      개인정보처리방침 동의<input type="checkbox"><br>
      <button class="style-s" type="button" onclick="open_pop()">전문보기</button><button class="style-p" type="button" onclick="submit(this)">상담 신청하기</button>
    </div>
  </section>
  <div id="popuplayer">
    <div>
      <strong>개인정보처리방침</strong>
      <section>
        <p>개인정보 취급 방침 동의</p>
        <p>개인정보의 수집 및 이용목적</p>
        <p>성명, 주소, 연락처 :  안내나 권유 등 서비스 이용 안내, 마케팅 메시지 전송을 활용한 홍보활동 동의.</p>
        <p>소식 및 고지사항 전달, 불만처리 등을 위한 원활한 의사소통 경로의 확보 등</p>
        <p>개인정보는 본인이 원하시는 경우 연락 주시면 삭제 가능합니다.</p>
      </section>
      <p>
        <button type="button" onclick="close_pop()">닫기</button>
      </p>
    </div>
  </div>
</main>


</body>
</html>
