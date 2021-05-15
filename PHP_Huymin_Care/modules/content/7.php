<?php
/*
FileName: 7.php
Modified Date: 20190926
Description: 서브:일정표
*/
require_once($_SERVER['DOCUMENT_ROOT'].'/modules/module_protect.php');
?>
<?php // Lnb ?>
<div class="lnb">
  <table>
    <tbody>
      <tr>
        <td>Home</td>
        <td>게시판</td>
        <td><?= $pagename ?></td>
      </tr>
    </tbody>
  </table>
</div>
<?php // Main ?>
<main>
  <section class="bg-white" id="sub1">
    <h2><?= $year ?>년 <?= $month ?>월 효민 프로그램 일정표</h2><span></span>
    <div id="calendar">
      <table>
        <tbody>
          <?php $v = -$startDay+2; ?>
          <?php while($v <= $datemax) : ?>
            <tr>
              <th></th>
              <?php for($i=0; $i<7; $i++) : ?>
                <?php if($v+$i>0 && $v+$i<=$datemax) :?>
                  <th><?= ($v+$i).'일' ?></th>
                <?php else : ?>
                  <th></th>
                <?php endif ?>
              <?php endfor ?>
            </tr>
            <tr>
              <td>오전 인지활동<br>(10:30-11:40)</td>
              <?php for($i=0; $i<7; $i++) : ?>
                <?php if($v+$i>0 && $v+$i<=$datemax) :?>
                  <td><?= $dates[''.($v+$i)]['part1'] ?></td>
                <?php else : ?>
                  <td rowspan="3"></td>
                <?php endif ?>
              <?php endfor ?>
            </tr>
            <tr>
              <td>14:00-15:00</td>
              <?php for($i=0; $i<7; $i++) : ?>
                <?php if($v+$i>0 && $v+$i<=$datemax) :?>
                  <td><?= $dates[''.($v+$i)]['part2'] ?></td>
                <?php else : ?>

                <?php endif ?>
              <?php endfor ?>
            </tr>
            <tr>
              <td>오후 신체활동<br>(15:30-16:30)</td>
              <?php for($i=0; $i<7; $i++) : ?>
                <?php if($v+$i>0 && $v+$i<=$datemax) :?>
                  <td><?= $dates[''.($v+$i)]['part3'] ?></td>
                <?php else : ?>

                <?php endif ?>
              <?php endfor ?>
            </tr>
            <?php $v = $v+7; ?>
          <?php endwhile ?>
        </tbody>
      </table>
    </div>
    <ul>
      <li>미용봉사 있을 수 있습니다.(비정기적)</li>
      <li>매일 오전 10시 30분 국민 체조, 치매예방 체조 진행.</li>
      <li>프로그램은 센터 사정에 따라 변경 진행될 수 있습니다.</li>
    </ul>
  </section>
</main>
