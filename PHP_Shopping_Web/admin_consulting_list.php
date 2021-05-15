<?php
// Load Modules
require_once("modules/admin.php");

// Parameter
$pid = Get('p', 1);

// Functions

// Process
$consultObj = new Consulting();
try {
  $nokpg = $consultObj->SelectPageLength($pid, 15, " ",'statok=false');
} catch (Exception $e) {

}
try {
  $nokpglist = $consultObj->SelectPageList($nokpg['current'], 15," ",'statok=false');
} catch (Exception $e) {

}

try {
  $okpglist = $consultObj->SelectPageList(1, 5," ",'statok=true');
} catch (Exception $e) {

}
$nokarr = [];
$okarr = [];
?>
<!DOCTYPE html>
<html lang="ko" dir="ltr">
  <head>
    <link href="css/css_sub2.css" rel="stylesheet" type="text/css">
    <link href="css/admin_cul.css" rel="stylesheet" type="text/css">
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <title></title>
    <style media="screen">
      tr.clicked {
        background-color: #0df;
      }
    </style>
  </head>
  <body>
    <main>
      <div>
        <table id="consulting">
          <thead>
            <tr>
              <th colspan="6"><h3>대기중인 상담</h3></th>
            </tr>
            <tr>
              <th>번호</th>
              <th>등록한 시간</th>
              <th>완료된 시간</th>
              <th>신청자이름</th>
              <th>이메일</th>
              <th>내용보기</th>
            </tr>
          </thead>
          <tbody>
            <form class="" action="admin_consulting_delete.php" method="post">
              <?php $i = 0; //아래 스크립트를 위해 i를 0 값으로?>
              <?php if(!empty($nokpglist)) : ?>
                <?php foreach($nokpglist as $row) : ?>
                  <?php array_push($nokarr, $row['content']); ?>
                  <!-- 전체 선택읠 위해 $i를 0으로  -->
                  <tr>
                    <td class="hidden"><input type="checkbox" name="id[]" value="<?= $row['id'] ?>"></td>
                    <td onclick="selector.select(<?= $i ?>)"><?= $row['id'] ?></td>
                    <td onclick="selector.select(<?= $i ?>)"><?= $row['dt'] ?></td>
                    <td onclick="selector.select(<?= $i ?>)"></td>
                    <td onclick="selector.select(<?= $i ?>)"><?= $row['name'] ?></td>
                    <td onclick="selector.select(<?= $i ?>)"><?= $row['email'] ?></td>
                    <td><button type="button" onclick="contents.shownok(<?= $i++ //i 값 증가?>)">보기</button></td>
                  </tr>
                <?php endforeach ?>
              <?php endif ?>
            </form>
          </tbody>
          <thead>
            <tr>
              <th colspan="6"><h3>최근 완료한 상담</h3></th>
            </tr>
          </thead>
          <tbody>
            <?php $i = 0; ?>
            <?php if(!empty($okpglist)) : //완료된 상담 부분?>
              <?php foreach($okpglist as $row) : ?>
                <?php array_push($okarr, $row['content']); ?>
                <tr>
                  <td><?= $row['id'] ?></td>
                  <td><?= $row['dt'] ?></td>
                  <td><?= $row['dtok'] ?></td>
                  <td><?= $row['name'] ?></td>
                  <td><?= $row['email'] ?></td>
                  <td><button type="button" onclick="contents.showok(<?= $i++ ?>)">보기</button></td>
                </tr>
              <?php endforeach ?>
            <?php endif ?>
          </tbody>
        </table>
        <?php if(!empty($okpg)) : ?>
          <?php for($i=$okpg['start']; $i<=$okpg['end']; $i++) : ?>
            <a class="abtn <?php if($i === (int)$result['current']) echo 'current' ?>" href="?p=<?= $i ?>"><?= $i ?></a>
          <?php endfor ?>
        <?php endif ?>
        <button disabled type="button" name="button" onclick="selector.execDel()">부적절한 기록 삭제</button>
        <button disabled type="button" name="button" onclick="selector.execChange()">상담완료</button>
        <span id="counter"></span>
      </div>
    </main>
    <script type="text/javascript">
    //보기 버튼 부분
      var contents = {
        nokpg: [],
        okpg: [],
        shownok: function (i) {
          alert(this.nokpg[i]);
        },
        showok: function (i) {
          alert(this.okpg[i]);
        }
      }
      <?php foreach($nokarr as $o ) : ?>
      contents.nokpg.push('<?= "$o" ?>');
      <?php  ?>
      <?php endforeach ?>
      <?php foreach($okarr as $o) : ?>
      contents.okpg.push('<?= "$o" ?>');
      <?php endforeach ?>
    </script>

    <script type="text/javascript">

    var selector = {
      //제발 되라 하..
      // 부적절 기록 삭제
      // 상담 완료로 변경
      // 기록 선택 또는 선택취소
      dom: {
        form: document.getElementsByTagName('form')[0],
        submitbtn: document.getElementsByName('button'),
        counter: document.getElementById('counter'),
        checkbox: document.getElementsByTagName('input')
      },
      count: 0,
      select: function(i) {
        if(!this.dom.checkbox[i].checked) {//checkbox[i] 번째 체크가 되지 않아 있으면
          this.dom.checkbox[i].parentElement.parentElement.setAttribute('class', 'clicked'); //selector.dom.checkbox[i](input).td.tr에 클래스 값을 클릭트로 넣어줌
          this.dom.checkbox[i].checked = true; // 체크박스의 값을 트루로 변경
          this.count++; //카운트 증가
        }
        else {
          this.dom.checkbox[i].parentElement.parentElement.setAttribute('class', ''); //selector.dom.checkbox[i](input).td.tr에 클래스 값을 ''
          this.dom.checkbox[i].checked = false; // 체크박스의 값을 거짓으로 변경
          this.count--;//카운트 감소
        }
        if(this.count == 0) { // selector의 count 값이 0이면
          this.dom.submitbtn[0].disabled = true; //selector.dom.submitbtn[0].disabled 값을 트루로 (버튼 비활성화)
          this.dom.submitbtn[1].disabled = true; //selector.dom.submitbtn[1].disabled 값을 트루로(버튼 비활성화)
          this.dom.counter.innerText = ''; //<span id="counter"></span> 에 '' 열 넣기
        }
        else {
          this.dom.submitbtn[0].disabled = false;//selector.dom.submitbtn[0].disabled 값을 false로 (버튼 활성화)
          this.dom.submitbtn[1].disabled = false;//selector.dom.submitbtn[1].disabled 값을 false로 (버튼 활성화)
          this.dom.counter.innerText = this.count + '개 선택됨'; //<span id="counter"></span> 에 selector.count에  this.count값을 넣는다.
        }
      },
      execDel: function() {
        this.dom.form.submit(); //selector.dom.form(document.getElementsByTagName('form')[0]).submit();
      },
      execChange: function() {
        this.dom.form.action = 'admin_consulting_checked.php';
        this.dom.form.submit();
      }
    };
    </script>
  </body>
</html>
