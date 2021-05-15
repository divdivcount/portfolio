<?php
/*
FileName: calendar_list.php
Modified Date: 20190909
Description: 일정표 수정 페이지
*/

// Load Modules
require_once('modules/error.php');
require_once('modules/notification.php');
require_once('modules/db.php');
require_once('modules/admin.php');

// Parameter
$year = Get('year', date('Y'));
$month = Get('month', date('n'));
$year = (int)$year;
$month = (int)$month;

// Functions

// Process
$calendarObj = new YoYangCalendar($DBconfig['dburl'], $DBconfig['dbid'], $DBconfig['dbpw'], $DBconfig['dbtable'], $DBconfig['dbtype']);
$datemax = $calendarObj->getMaxDay($year, $month);
//$dates = $calendarObj->SelectDate('*', $year, $month);
$dates = $calendarObj->SelectDateForm($year, $month);
//$dates = $calendarObj->SelectDate('dt', "dt=$year-$month-%");
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
      button{
        display:initial;
      }
    </style>
  </head>
  <body>
    <?php require_once('modules/form_navigation.php'); ?>
    <header>
      <h1>시간표 관리</h1>
    </header>
    <main>
      <div>
        <ul id="sub">
          <li>
            <form action="calendar_list.php" method="get" id="lmove">
              <input type="text" name="year" value="<?= $year ?>">
              <select name="month">
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12">12</option>
              </select>
              <script type="text/javascript">
              document.getElementsByTagName('option')[<?= $month ?>-1].selected = true;
              </script>
            </form>
          </li><li><button type="button" onclick="document.getElementById('lmove').submit()">이동</button></li><li><button type="button" onclick="document.getElementById('lok').submit()">적용</button></li>
        </ul>
        <form action="calendar_update.php?year=<?= $year ?>&month=<?= $month ?>" method="post" id="lok">
          <table id="calendar">
            <thead>
              <tr>
                <th>년</th>
                <th>월</th>
                <th>일</th>
                <th>오전 활동(10:30-11:40)</th>
                <th>14:00-15:00</th>
                <th>오후 활동(15:30-16:30)</th>
              </tr>
            </thead>
            <tbody>
              <?php for($day=1; $day<=$datemax; $day++) : ?>
                <tr>
                  <td><?= $year ?></td>
                  <td><?= $month ?></td>
                  <td><?= $day ?></td>
                  <?php if($dates) : ?>
                    <td><div class="inputbox">
                      <input type="text" name="part1[]" value="<?= $dates["$day"]['part1'] ?>">
                    </div></td>
                    <td><div class="inputbox">
                      <input type="text" name="part2[]" value="<?= $dates["$day"]['part2'] ?>">
                    </div></td>
                    <td><div class="inputbox">
                      <input type="text" name="part3[]" value="<?= $dates["$day"]['part3'] ?>">
                    </div></td>
                  <?php else : ?>
                    <td><div class="inputbox">
                      <input type="text" name="part1[]" value="">
                    </div></td>
                    <td><div class="inputbox">
                      <input type="text" name="part2[]" value="">
                    </div></td>
                    <td><div class="inputbox">
                      <input type="text" name="part3[]" value="">
                    </div></td>
                  <?php endif ?>
                </tr>
              <?php endfor ?>
              <tr>
                <td colspan="6"></td>
              </tr>

            </tbody>
          </table>
        </form>
      </div>
    </main>
  </body>
</html>
