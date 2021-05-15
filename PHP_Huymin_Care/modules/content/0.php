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
    <h2 class="slogan">어르신들이 행복해지는 이곳 <span>효민 요양원</span>에 오신 것을 환영합니다!</h2>
    <div class="flex reverse">
      <div class="flex flex-4p10 mobileslice">
        <div class="flex-half">
          <h4 class="style-p">전화상담</h4><small class="tool">031-266-1774</small>
        </div>
        <div class="flex-half">
          <h4 class="style-p">방문가능시간</h4><small class="tool">09:00~18:00<br>연중무휴</small>
        </div>
        <div class="flex-full">
          <h4 class="style-p">이메일</h4><small class="tool"><a href="mailto:esm1008@naver.com">esm1008@naver.com</a></small>
        </div>
        <div class="flex-full">
          <small>Fax: 031-266-1775</small>
          <small>Phone: 010-4741-2164</small>
        </div>
      </div>
      <div class="flex flex-6p10 mobileslice">
        <div class="flex-half-half mobileslice">
          <img src="img/whe.png" class="effect-color" onclick="location.href='sub.php?p=2#sub3'">
          <small class="tool">요양원 위치</small>
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
          <small class="tool">입소안내</small>
        </div>
      </div>
    </div>
  </section>

  <section class="bg-gray center">
    <h2>효민 프로그램</h2><span class="center"></span>
    <br>
    <div class="flex">
      <div class="flex-half-half mobileslice">
        <div class="effectbox">
          <img src="img/program2.jpg" title="클릭하시면 원본크기로 보실 수 있습니다."onclick="doImgPop('img/program2.jpg')" />
          <strong>민요교실</strong>
          <p>민요를 같이 부르고 신나는 율동체조를 하는 시간입니다.</p>
        </div>
      </div>
      <div class="flex-half-half mobileslice">
        <div class="effectbox">
          <img src="img/program3.jpg" title="클릭하시면 원본크기로 보실 수 있습니다."onclick="doImgPop('img/program3.jpg')" />
          <strong>노래교실</strong>
          <p>노래를 배우고 직접 노래를 부르면서 즐겁게 활동하는 시간입니다.</p>
        </div>
      </div>
      <div class="flex-half-half mobileslice">
        <div class="effectbox">
          <img src="img/program1.jpg" title="클릭하시면 원본크기로 보실 수 있습니다."onclick="doImgPop('img/program1.jpg')" />
          <strong>실버레크레이션</strong>
          <p>노래와 율동을 따라하시면서 체조를 하는 시간입니다.</p>
        </div>
      </div>
      <div class="flex-half-half mobileslice">
        <div class="effectbox">
          <img src="img/program4.jpg" title="클릭하시면 원본크기로 보실 수 있습니다."onclick="doImgPop('img/program4.jpg')" />
          <strong>박수치료</strong>
          <p>노래, 체조, 전도 등 여러가지 활동을 하는 시간입니다.</p>
        </div>
      </div>
    </div>
  </section>

  <?php if($result) : ?>
    <section class="bg-white center">
      <h2>공지사항</h2><span class="center"></span>
      <table id="board">
        <thead>
          <tr id="field">
            <th>번호</th>
            <th>제목</th>
            <th>작성일</th>
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
