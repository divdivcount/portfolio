<html>
    <head>
        <meta charset="utf-8">
        <title>아이디/비밀번호찾기</title>
        <link rel="stylesheet" href="css/css_findIdPw.css">
        <link rel="stylesheet" href="css/css_noamlfont.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="theme-color" content="#ffffff">
        <link rel="apple-touch-icon" sizes="180x180" href="css/favicon_package_v0.16/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="css/favicon_package_v0.16/favicon-32x32.ico">
        <!-- <link rel="icon" type="image/png" sizes="16x16" href="css/favicon_package_v0.16/favicon-16x16.png"> -->
        <link rel="manifest" href="css/favicon_package_v0.16/site.webmanifest">
        <link rel="mask-icon" href="css/favicon_package_v0.16/safari-pinned-tab.svg" color="#5bbad5">
    </head>
    <body>
        <div class="wrap">
            <div class="form-wrap">
                <div class="imgbox">
                  <img src="/img/metrocket.png" alt="">
                </div>

                <!-- 상단 아이디 및 비밀번호 찾기 버튼 -->
                <div id="imgbtn_box">
                  <img id = "findid_btn" src="img/findid_top_btn_on.png" onclick="findId()">
                  <img id = "findpw_btn" src="img/findpw_top_btn_off.png" onclick="findPw()">
                </div>

                <!-- 아이디 찾는 폼 부분 -->
                <form id="findId" action="findidpw_check.php" class="input-group" method="post">

                  <!-- 이름 -->
                  <div class="inputbox">
                    <div class="textbox"><div class="bluedot">*</div>이름</div>
                    <input type="text" name ="mb_name" class="input-field" required >
                  </div>

                  <!-- 이메일 -->
                  <!-- 이메일 -->
                  <div class="inputbox">
                    <div class="textbox"><div class="bluedot">*</div>이메일</div>
                      <!-- 이메일 폼 부분 재구성함 수정 요함  -->
              					<input type="text" class="first_email" name="first_email" value="" > <div style="font-family:'NotoSansKR_m';color:#3b3b3b;font-size: 1.8rem;">@</div>
              					<input type="text" class="second_email" name="second_email" value="">

                        <!-- 이메일 선택 select 박스 -->
              					<select class="selbox" onchange="email(0)" class="" name="">
              						<option value="direct">직접입력</option>
              						<option value="naver.com">naver.com</option>
              						<option value="gmail.com">gmail.com</option>
                          <option value="hanmail.net">hanmail.net</option>
                          <option value="nate.com">nate.com</option>
                          <option value="yahoo.co.kr">yahoo.co.kr</option>
                          <option value="yahoo.com">yahoo.com</option>
                          <option value="dreamwiz.com">dreamwiz.com</option>
                          <option value="daum.net">daum.net</option>
              					</select>
                  </div>

                  <!-- 아이디 찾기 버튼 -->
                  <div class="submitBtn_box">
                    <input type="submit" class="submitBtn" value="아이디 찾기">
                  </div>
                </form>

                <!-- 비밀번호 찾는 폼 부분 -->
                <form id="findPw" action="findidpw_check.php" class="input-group" method="post">

                  <!-- 이름 -->
                  <div class="inputbox">
                    <div class="textbox"><div class="bluedot">*</div>이름</div>
                    <input type="text"  name="mb_names" class="input-field_2" required>
                  </div>

                  <!-- 아이디 -->
                  <div class="inputbox">
                    <div class="textbox"><div class="bluedot">*</div>아이디</div>
                    <input type="text"  name="userId" class="input-field_2" required>
                  </div>

                  <!-- 이메일 -->
                  <div class="inputbox">
                    <div class="textbox"><div class="bluedot">*</div>이메일</div>
                      <!-- 이메일 폼 부분 재구성함 수정 요함  -->
              					<input type="text" class="first_email" name="first_email" value="" > <div style="font-family:'NotoSansKR_m';color:#3b3b3b;font-size: 1.8rem;">@</div>
              					<input type="text" class="second_email" name="second_email" value="">

                        <!-- 이메일 선택 select 박스 -->
              					<select class="selbox" onchange="email(1)" class="" name="">
              						<option value="direct">직접입력</option>
              						<option value="naver.com">naver.com</option>
              						<option value="gmail.com">gmail.com</option>
                          <option value="hanmail.net">hanmail.net</option>
                          <option value="nate.com">nate.com</option>
                          <option value="yahoo.co.kr">yahoo.co.kr</option>
                          <option value="yahoo.com">yahoo.com</option>
                          <option value="dreamwiz.com">dreamwiz.com</option>
                          <option value="daum.net">daum.net</option>
              					</select>
                  </div>

                  <!-- 비밀번호 찾기 버튼 -->
                  <div class="submitBtn_box">
                    <input type="submit" class="submitBtn" value="비밀번호 찾기">
                  </div>
                </form>

            </div>
        </div>

    </body>
  <script  type="text/javascript">
      var id_form = document.getElementById("findId");
      var pw_form = document.getElementById("findPw");
      var findid_btn =document.getElementById("findid_btn");
      var findpw_btn =document.getElementById("findpw_btn");

      function findId(){
        findid_btn.src = "img/findid_top_btn_on.png";
        findpw_btn.src = "img/findpw_top_btn_off.png";
        id_form.style.visibility="visible";
        pw_form.style.visibility="hidden";
      }
      function findPw(){
        findid_btn.src = "img/findid_top_btn_off.png";
        findpw_btn.src = "img/findpw_top_btn_on.png";
        id_form.style.visibility="hidden";
        pw_form.style.visibility="visible";
      }

      // 이메일 선택 select 박스에 자동으로 텍스트 적용하는 함수
      function email(i) {
        var selbox= document.getElementsByClassName('selbox');
        var secondText = document.getElementsByClassName('second_email');
        var domainText ="";
        if (selbox.item(i).selectedIndex > 0) {
          domainText = selbox.item(i).options[selbox.item(i).selectedIndex].value;
          secondText.item(i).value = domainText;
        }else{
          secondText.item(i).value = "";
        }
      }


  </script>
</html>
