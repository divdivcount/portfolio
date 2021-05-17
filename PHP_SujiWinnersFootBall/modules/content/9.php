<?php
/*
FileName: 5.php
Modified Date: 20190926
Description: 서브:공지사항
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
    <?php if($list) : ?>
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
              <td class="center"><a href="/sub.php?p=8&id=<?= $row['idx'] ?>"><?= $row['idx'] ?></a></td>
              <td><a href="/sub.php?p=8&id=<?= $row['idx'] ?>"><?= $row['title'] ?></a></td>
              <td class="center"><a href="/sub.php?p=8&id=<?= $row['idx'] ?>"><?= $row['date'] ?></a></td>
              <td class="center"><a href="/sub.php?p=8&id=<?= $row['idx'] ?>"><?= $row['hit'] ?></a></td>
            </tr>
          <?php endforeach ?>
        </tbody>
      </table>
    <?php else : ?>
      <h2 class="center">게시물이 존재하지 않습니다.</h2>
    <?php endif ?>
    <?php if($result) : ?>
      <div>
        <?php for($i=$result['start']; $i<=$result['end']; $i++): ?>
          <a class="style-p <?php if($i === (int)$result['current']) echo 'current' ?>" href="?p=9&bp=<?= $i ?>"><?= $i ?></a>
        <?php endfor ?>
      </div>
    <?php endif ?>
  </section>
</main>
