<?php
/*
FileName: board_list.php
Modified Date: 20190902
Description: 게시글 목록 프로그램
*/

// Load Modules
require_once('modules/error.php');
require_once('modules/notification.php');
require_once('modules/db.php');
require_once('modules/admin.php');

// Parameter
$pid = Get('p', 1);

// Functions

// Process
$boardObj = new YoYangVideoBoard($DBconfig['dburl'], $DBconfig['dbid'], $DBconfig['dbpw'], $DBconfig['dbtable'], $DBconfig['dbtype']);
?>
<!DOCTYPE html>
<html lang="ko" dir="ltr">
  <head>
    <?php require_once('modules/form_head.php'); ?>
    <title></title>
  </head>
  <body>
    <?php require_once('modules/form_navigation.php'); ?>
    <header>
      <h1>공지 관리</h1>
    </header>
    <main>
      <div>
        <?php
        try {
          $result = $boardObj->SelectPageLength($pid, 15);
          $list = $boardObj->SelectPageList($result['current'], 15);
        } catch (PDOException $e) {
          $result = null;
          $list = null;
        }
        ?>
        <form class="" action="/video_board_delete.php" method="post">
          <table id="board">
            <thead>
              <tr id="field">
                <th><input type="checkbox" class="hidden" id="all" value="all"><label for="all"></label></th>
                <th>번호</th>
                <th>제목</th>
                <th>작성일</th>
                <th>조회수</th>
                <th colspan="4">
                  <button type="submit" name="button">삭제</button>
                  <span></span>
                </th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($list as $row) : ?>
                <tr>
                  <td class="center"><input type="checkbox" name="id[]" class="hidden" id="<?= $row['idx'] ?>" value="<?= $row['idx'] ?>"><label for="<?= $row['idx'] ?>"></label></td>
                  <td class="center"><?= $row['idx'] ?></td>
                  <td><a href="/video_board_write.php?id=<?= $row['idx'] ?>"><?= $row['title'] ?></a></td>
                  <td class="center"><?= $row['date'] ?></td>
                  <td class="center"><?= $row['hit'] ?></td>
                </tr>
              <?php endforeach ?>
            </tbody>
          </table>
        </form>
        <br>
        <div class="center">
          <?php for($i=$result['start']; $i<=$result['end']; $i++): ?>
            <a class="abtn <?php if($i === (int)$result['current']) echo 'current' ?>" href="?p=<?= $i ?>"><?= $i ?></a>
          <?php endfor ?>
          <button type="button" name="button" onclick="location.href='/video_board_write.php'">글 작성</button>
        </div>
        <script type="text/javascript">
        var allbox = document.getElementById('all');
        var boxes = document.getElementsByName('id[]');
        var delbox = document.getElementById('field').getElementsByTagName('th');
        objectHV(
          [],
          [delbox[5]]
        );
        var checked = 0;
        for(var i=0;i<boxes.length; i++) {
          boxes[i].addEventListener('change', (e) => {
            if(e.target.checked) {
              checked++;
              if(checked == 15) {
                allbox.checked = true;
              }
              objectHV(
                [delbox[5]],
                [delbox[1], delbox[2], delbox[3], delbox[4]]
              );
            }
            else {
              checked--;
              if(allbox.checked) {
                allbox.checked = false;
              }
              if(checked <= 0) {
                objectHV(
                  [delbox[1], delbox[2], delbox[3], delbox[4]],
                  [delbox[5]]
                );
              }
            }
            delbox[5].getElementsByTagName('span')[0].innerText = checked + '개 선택됨.';
          });
        }
        allbox.addEventListener('change', (e) => {
          if(e.target.checked) {
            for(var i=0; i<boxes.length; i++) {
              boxes[i].checked = true;
            }
            checked = boxes.length;
            objectHV(
              [delbox[5]],
              [delbox[1], delbox[2], delbox[3], delbox[4]]
            );
          }
          else {
            for(var i=0; i<boxes.length; i++) {
              boxes[i].checked = false;
            }
            checked = 0;
            objectHV(
              [delbox[1], delbox[2], delbox[3], delbox[4]],
              [delbox[5]]
            );
          }
          delbox[5].getElementsByTagName('span')[0].innerText = checked + '개 선택됨.';
        });

        function objectHV(visible, invisible) {
          for(var i=0; i<visible.length; i++) {
            visible[i].style.display = '';
          }
          for(var i=0; i<invisible.length; i++) {
            invisible[i].style.display = 'none';
          }
        }
        </script>
      </div>
    </main>
  </body>
</html>
