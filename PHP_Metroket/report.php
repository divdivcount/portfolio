<!doctype html>
<html lang="ko">
<head>
<meta charset="utf-8">
<style>
.bigB{
  height:auto;
  padding: 2.7rem 3.0rem 5.0rem;
  border-radius: 20px;
  background-color: #ffffff;
}
.mother{
  margin:auto;
  display:grid;
  grid-template-columns:1fr;
  grid-template-rows:auto;
}
.reP{
  font-size:3.5rem;
  font-weight:500;
  color:#3b3b3b;
  font-family:"NotoSansKR_m";
  display: flex;
  align-items: center;
}
.reP img{
  margin-right: 1.0rem;
}
.conT{
  display:grid;
  grid-template-columns:1fr 1fr;
  font-size:2.0rem;
  color:#5b5b5b;
  font-family: "NotoSansKR_r";
  margin:auto;
  align-items: center;
}
.conT .conT_gridItem{
   margin: 2.5rem 0;
}
input[type=radio] {display:none;}

input[type=radio] + label {
display: inline-block;
cursor: pointer;
line-height: 22px;
padding-left: 27px;
background: url('img/check.png') left/22px no-repeat;
}

input[type=radio]:checked + label { background-image: url('img/checkIn.png'); }

.box{
  width:100%;
  height:200px;
  border-radius:20px;
  background-color:#f0f0f0;
  padding:20px;
  box-shadow:0px 3px 6px 0px rgba(0,0,0,0.16);
}
.textarea{
  width: 100%;
  font-size: 1.5rem;
  background-color:#f0f0f0;
  border:0px solid #f0f0f0;
  height: 20.0rem;
  outline: none;
  resize: none;
}
.reportBtn_box{
  display: flex;
  justify-content: space-around;
  margin: 3.0rem 0 5.0rem 0;
}
.button{
  width: 40%;
  max-width: 180px;
  height: 5.0rem;
  padding: 1.0rem 5.0rem;
  border-radius: 50px;
  box-shadow: 0 3px 6px 0 rgba(0, 0, 0, 0.16);
  background-color: #0088ff;
  border:0px solid;
  color:#ffffff;
  font-size: 2.0rem;
  font-family: "NotoSansKR_r";
}
.button2{
  width: 40%;
  max-width: 180px;
  height: 5.0rem;
  padding: 1.0rem 5.0rem;
  border-radius: 50px;
  box-shadow: 0 3px 6px 0 rgba(0, 0, 0, 0.16);
  background-color: #f0f0f0;
  border:0px solid;
  font-size: 2.0rem;
  font-family: "NotoSansKR_r";
 }
</style>
</head>
<body>
  <?php
  if(isset($_SESSION['ss_mb_id'])){
    $mb_ids = $_SESSION['ss_mb_id'];
    $sql = " SELECT * FROM member WHERE mb_id = '$mb_ids' ";
    $result = mysqli_query($conn, $sql);
    $mb = mysqli_fetch_assoc($result);
    $rep_mb = $mb['mb_num'];
  }elseif(isset($_SESSION['naver_mb_id'])){
    $mb_ids = $_SESSION['naver_mb_id'];
    $mb_ids = substr($mb_ids, 5);
    $sql = " SELECT * FROM oauth_member WHERE om_id = $mb_ids ";
    $result = mysqli_query($conn, $sql);
    $om = mysqli_fetch_assoc($result);
    $rep_mb = $om['om_id'];

  }elseif(isset($_SESSION['kakao_mb_id'])){
    $mb_ids = $_SESSION['kakao_mb_id'];
    $mb_ids = substr($mb_ids, 5);
    $sql = " SELECT * FROM oauth_member WHERE om_id = $mb_ids ";
    $result = mysqli_query($conn, $sql);
    $om = mysqli_fetch_assoc($result);
    $rep_mb = $om['om_id'];
  }
   ?>
  <div class="bigB">
    <div class=mother>
      <div class="closeBtn_box"><img src="img/cancle.png" class="" onclick="report_close()" style="width:2.3rem;height:2.3rem;cursor:pointer"></div>
      <div class=reP><img src="img/reP.png">신고하기</div><br>
	  <form action="test_php.php" method="get">
		<div class=conT>
			<div class="conT_gridItem"><input type="radio" id="che0" value="광고성/홍보성" name="check[]"/><label for="che0">광고성/홍보성</label></div>
			<div class="conT_gridItem"><input type="radio" id="che1" value="업자로 의심" name="check[]"/><label for="che1">업자로 의심</label></div>
			<div class="conT_gridItem"><input type="radio" id="che2" value="판매글이 아닌 글" name="check[]"/><label for="che2">판매글이 아닌 글</label></div>
			<div class="conT_gridItem"><input type="radio" id="che3" value="욕설/폭언" name="check[]"/><label for="che3">욕설/폭언</label></div>
			<div class="conT_gridItem"><input type="radio" id="che4" value="같은 내용 반복 게시" name="check[]"/><label for="che4">같은 내용 반복 게시</label></div>
			<div class="conT_gridItem"><input type="radio" id="che5" value="글과 사진이 연관이 없음" name="check[]"/><label for="che5">글과 사진이 연관이 없음</label></div>
			<div class="conT_gridItem"><input type="radio" id="che6" value="기타" name="check[]" /><label for="che6">기타</label></div>
		</div>


    <textarea name="otherReason" id="textarea_otherReason" placeholder="기타 사유를 입력해 주세요."  class="textarea" disabled=false></textarea>
    <input type="hidden" name="member_num" value="<?= $rep_mb ?>">
    <input type="hidden" name="member_num" value="<?= $rep_mb ?>">
    <div class="reportBtn_box">
      <button type="submit" class="w3-button w3-blue button">신고하기</button>
  		<button type="button" class="w3-button w3-light-grey button2" onclick="report_close()">취소</button>
    </div>

	   </form>
    </div>
  </div>
  </body>
  <script type="text/javascript">

    var rep_checkbox = document.getElementsByName('check[]');
    var otherReason = document.getElementById("che6")
    var textarea_otherReason =document.getElementById("textarea_otherReason");

    for(var i=0; i < rep_checkbox.length; i++){
      rep_checkbox[i].addEventListener("click",function(){

        if (otherReason.checked)
          textarea_otherReason.disabled = false;
        else
          textarea_otherReason.disabled = true;
      });
    }

  </script>
</html>
