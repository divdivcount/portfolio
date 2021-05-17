<?php
/*
FileName: 3.php
Modified Date: 20190926
Description: 서브:서비스 소개
*/
require_once($_SERVER['DOCUMENT_ROOT'].'/modules/module_protect.php');
?>
<?php // javascript ?>
<script src="/script/js_sub0.js" charset="utf-8"></script>
<?php // Main ?>
<main>
  <section class="bg-white center">
    <h2 class="slogan">모두가 즐거워하는 이곳 <span>위너스 풋볼 아카데미</span>에 오신 것을 환영합니다!</h2>
    <div class="flex reverse">
      <div class="flex flex-4p10 mobileslice">
        <div class="flex-half">
          <h4 class="style-p">전화상담</h4><small class="tool">031-897-6550</small>
        </div>
        <div class="flex-half">
          <h4 class="style-p">방문가능시간</h4><small class="tool">13:00~20:00<br>일요일, 공휴일 휴무</small>
        </div>
        <div class="flex-half">
          <a href="https://blog.naver.com/ckdrbs74"><h4 class="style-p">블로그 이동</h4></a><small class="tool"></small>
        </div>
		<div class="flex-half">
		  <a href="https://cafe.naver.com/sujiwinnersfootball"><h4 class="style-p">카페 이동</h4></a><small class="tool"></small>
        </div>
		

		
      </div>
      <div class="flex flex-6p10 mobileslice">
        <div class="flex-half-half mobileslice">
          <img src="img/whe.png" class="effect-color" onclick="location.href='sub.php?p=2#sub3'">
          <small class="tool">아카데미 위치</small>
        </div>
        <div class="flex-half-half mobileslice">
          <img src="img/sang.png" class="effect-color" onclick="location.href='sub.php?p=4'">
          <small class="tool">상담</small>
        </div>
        <div class="flex-half-half mobileslice">
          <img src="img/lil.png" class="effect-color" onclick="location.href='sub.php?p=7'">
          <small class="tool">프로그램 일정</small>
        </div>
        <div class="flex-half-half mobileslice">
          <img src="img/iso.png" class="effect-color" onclick="location.href='sub.php?p=3'">
          <small class="tool">안내</small>
        </div>
      </div>
    </div>
  </section>

  <section class="bg-gray center">

    <h2>사진 갤러리</h2><span class="center"></span>
    <br>
    <?php if($result2) : ?>

    <div class="flex">
      <?php foreach($result2 as $rows) :?>
      <div class="flex-half-half mobileslice">
        <div class="effectbox">
          <img src="img/gallery/<?=$rows["fname"]?>" width="100%" height="100%" title="클릭하시면 원본크기로 보실 수 있습니다."onclick="doImgPop('img/gallery/<?=$rows["fname"]?>')" />
          <p style="margin-top:20px;"><?=$rows["description"]?></p>
        </div>
      </div>
        <?php endforeach ?>
    </div>
  <?php endif ?>
  </section>

  <?php if($result) : ?>
    <section class="bg-white center">
      <h2>공지사항</h2><span class="center"></span>
      <table id="board">
        <thead>
          <tr id="field">
            <th>번호</th>
            <th>제목</th>
            <th class="td_container">작성일</th>
            <th>조회수</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($list as $row) : ?>
            <tr>
              <td class="center"><a href="/sub.php?p=1&id=<?= $row['idx'] ?>"><?= $row['idx'] ?></a></td>
              <td><a href="/sub.php?p=1&id=<?= $row['idx'] ?>"><?= $row['title'] ?></a></td>
              <td class="center"><a href="/sub.php?p=1&id=<?= $row['idx'] ?>"><?= $row['date'] ?></a></td>
              <td class="center"><a href="/sub.php?p=1&id=<?= $row['idx'] ?>"><?= $row['hit'] ?></a></td>
            </tr>
          <?php endforeach ?>
        </tbody>
      </table>
    </section>
  <?php endif ?>
</main>
