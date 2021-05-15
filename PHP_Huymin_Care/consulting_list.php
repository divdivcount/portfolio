<?php
/*
FileName: consulting_list.php
Modified Date: 20190906
Description: 상담 요청 관리 페이지
*/

// Load Modules
require_once('modules/error.php');
require_once('modules/notification.php');
require_once('modules/db.php');
require_once("modules/admin.php");

// Parameter
$pid = Get('p', 1);

// Functions

// Process
$consultObj = new YoYangConsulting($DBconfig['dburl'], $DBconfig['dbid'], $DBconfig['dbpw'], $DBconfig['dbtable'], $DBconfig['dbtype']);
try {
  $nokpg = $consultObj->SelectPageLength($pid, 15, 'statok=false');
} catch (Exception $e) {

}
try {
  $nokpglist = $consultObj->SelectPageList($nokpg['current'], 15, '*', 'statok=false');
} catch (Exception $e) {

}
try {
  $okpglist = $consultObj->SelectPageList(1, 5, '*', 'statok=true');
} catch (Exception $e) {

}
$nokarr = [];
$okarr = [];
?>
<!DOCTYPE html>
<html lang="ko" dir="ltr">
  <head>
    <?php require_once('modules/form_head.php'); ?>
    <title></title>
    <style media="screen">
      tr.clicked {
        background-color: #0df;
      }
    </style>
  </head>
  <body>
    <?php require_once('modules/form_navigation.php'); ?>
    <header>
      <h1>상담 요청 목록</h1>
    </header>
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
              <th>전화번호</th>
              <th>내용보기</th>
            </tr>
          </thead>
          <tbody>
            <form class="" action="consulting_delete.php" method="post">
              <?php $i = 0; ?>
              <?php if(!empty($nokpglist)) : ?>
                <?php foreach($nokpglist as $row) : ?>
                  <?php array_push($nokarr, $row['content']); ?>
                  <tr>
                    <td class="hidden"><input type="checkbox" name="id[]" value="<?= $row['id'] ?>"></td>
                    <td onclick="selector.select(<?= $i ?>)"><?= $row['id'] ?></td>
                    <td onclick="selector.select(<?= $i ?>)"><?= $row['dt'] ?></td>
                    <td onclick="selector.select(<?= $i ?>)"></td>
                    <td onclick="selector.select(<?= $i ?>)"><?= $row['name'] ?></td>
                    <td onclick="selector.select(<?= $i ?>)"><?= $row['phone'] ?></td>
                    <td><button type="button" onclick="contents.shownok(<?= $i++ ?>)">보기</button></td>
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
            <?php if(!empty($okpglist)) : ?>
              <?php foreach($okpglist as $row) : ?>
                <?php array_push($okarr, $row['content']); ?>
                <tr>
                  <td><?= $row['id'] ?></td>
                  <td><?= $row['dt'] ?></td>
                  <td><?= $row['dtok'] ?></td>
                  <td><?= $row['name'] ?></td>
                  <td><?= $row['phone'] ?></td>
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
      <?php foreach($nokarr as $o) : ?>
      contents.nokpg.push('<?= "$o" ?>');
      <?php endforeach ?>
      <?php foreach($okarr as $o) : ?>
      contents.okpg.push('<?= "$o" ?>');
      <?php endforeach ?>
    </script>

    <script type="text/javascript">

    var selector = {
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
        if(!this.dom.checkbox[i].checked) {
          this.dom.checkbox[i].parentElement.parentElement.setAttribute('class', 'clicked');
          this.dom.checkbox[i].checked = true;
          this.count++;
        }
        else {
          this.dom.checkbox[i].parentElement.parentElement.setAttribute('class', '');
          this.dom.checkbox[i].checked = false;
          this.count--;
        }
        if(this.count == 0) {
          this.dom.submitbtn[0].disabled = true;
          this.dom.submitbtn[1].disabled = true;
          this.dom.counter.innerText = '';
        }
        else {
          this.dom.submitbtn[0].disabled = false;
          this.dom.submitbtn[1].disabled = false;
          this.dom.counter.innerText = this.count + '개 선택됨';
        }
      },
      execDel: function() {
        this.dom.form.submit();
      },
      execChange: function() {
        this.dom.form.action = '/consulting_checked.php';
        this.dom.form.submit();
      }
    };
    var dom = {
      form: document.getElementsByTagName('form')[0],
      submitbtn: document.getElementsByName('button'),
      counter: document.getElementById('counter')
    }
    var counter = {
      select: 0
    }
    </script>
  </body>
</html>
