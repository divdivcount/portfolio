<?php
/*
FileName: board_write.php
Modified Date: 20190902
Description: 게시글 작성 페이지
*/
// Load Modules
require_once('modules/error.php');
require_once('modules/notification.php');
require_once('modules/db.php');
require_once('modules/admin.php');

// Parameter
$id = Get('id', 0);

// Functions

// Process
$boardObj = new YoYangBoard($DBconfig['dburl'], $DBconfig['dbid'], $DBconfig['dbpw'], $DBconfig['dbtable'], $DBconfig['dbtype']);
?>
<!DOCTYPE html>
<html lang="ko" dir="ltr">
  <head>
    <?php require_once('modules/form_head.php'); ?>
    <title>관리자 페이지: 공지 관리</title>
    <link rel="stylesheet" href="/css/administrator.css">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script> 
    <script type="text/javascript" src="editor/ckeditor/ckeditor.js"></script>
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
            ?>
            <?php if((int)$id > 0): ?>
              <?php $board = $boardObj->SelectId($id); ?>
              <form class="" action="/board_writeok.php?id=<?= $board['idx'] ?>" method="post" enctype="multipart/form-data">
                <div><input type="text" name="title" value="<?= $board['title'] ?>" placeholder="제목" maxlength="100" required></div>
                <div><textarea id="editor1" name="content" rows="8" placeholder="내용" required><?= $board['content'] ?></textarea></div>
                <script>
                // Replace the <textarea id="editor1"> with a CKEditor 4
                // instance, using default configuration.
                CKEDITOR.replace('editor1',{filebrowserUploadUrl: '/editor/upload.php', contentsCss:'p{margin:0;}' })
                </script>
                <div><input type="file" value="1" name="upload_file"></div>
                <div><button type="submit" name="button">올리기</button></div>
              </form>
            <?php else : ?>
              <form class="" action="/board_writeok.php" method="post" enctype="multipart/form-data">
                <div><input type="text" name="title" value="" placeholder="제목" maxlength="100" required></div>
                <div><textarea id="editor1" name="content" rows="8" placeholder="내용" required></textarea></div>
                <script>
                // Replace the <textarea id="editor1"> with a CKEditor 4
                // instance, using default configuration.
                CKEDITOR.replace('editor1',{filebrowserUploadUrl: '/editor/upload.php', contentsCss:'p{margin:0;}' })
                </script>
                <div><input type="file" value="1" name="upload_file[]"></div>
                <div><button type="submit" name="button">올리기</button></div>
              </form>
            <?php endif ?>
            <?php
          }
          catch (PDOException $e) {
            echo '데이터베이스가 작동하지 않음.';
          }
          catch (Exception $e) {
            echo $e->getMessage();
          }
          //userGoto('데이터베이스 오류.', '');
          //userGoto('게시물이 존재하지 않습니다.', '');
          //userGoto('정의되지 않은 오류.', '');
        ?>
      </div>
    </main>
  </body>
</html>
