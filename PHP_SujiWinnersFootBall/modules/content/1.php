<?php
/*
FileName: 1.php
Modified Date: 20190926
Description: 서브:공지사항 글보기
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
    <h2><?= $post['title'] ?></h2><span></span>
    <small>작성: <?= $post['date'] ?></small>
    <small>조회: <?= $post['hit']+1 ?></small>
    <br><br>
    <p>
      <?= $post['content'] ?>
    </p>
    <?php if(!empty($post['file'])) : ?>
      <h4>첨부파일</h4>
      <a href="download.php?fname=<?= $post['file'] ?>"><?= $post['realfile'] ?></a>
    <?php endif ?>
  </section>
</main>
