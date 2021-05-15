<?php
/*
FileName: gallery_list.php
Modified Date: 20190905
Description: 갤러리 관리 페이지
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
$galleryObj = new YoYangGallery($DBconfig['dburl'], $DBconfig['dbid'], $DBconfig['dbpw'], $DBconfig['dbtable'], $DBconfig['dbtype']);
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
      <h1>갤러리 관리</h1>
    </header>
    <main>
      <div>
        <ul id="sub">
          <li><button type="button" name="button" onclick="list.openUploader()">추가</button></li><li><button type="button" name="button" onclick="list.openList()">변경 및 제거</button></li><li><button type="button" name="button" onclick="list.cancel()">선택취소</button></li><li><button type="button" name="button" onclick="list.dom.deleteForm.submit()">삭제</button></li><li id="len"></li>
        </ul>

        <form id="modifyForm" action="gallery_modify.php" method="post">
          <input type="text" name="id" class="hidden">
          <input type="text" name="description" class="hidden">
        </form>
        <form id="deleteForm" action="gallery_delete.php" method="post">
          <div id="gallery">
            <?php
            try {
              $page = $galleryObj->SelectPageLength($pid, 12);
              $result = $galleryObj->SelectPageList($page['current'], 12);
            }
            catch(Exception $e) {
              $page = null;
              $result = null;
            }
            ?>
            <?php if($page) : ?>
              <?php $i = 0; ?>
              <?php foreach($result as $row) : ?>
                <div>
                  <input type="checkbox" name="id[]" value="<?= $row['id'] ?>">
                  <label onclick="list.pick(<?= $i ?>)"></label>
                  <img src="/img/gallery/<?= $row['fname'] ?>" alt="">
                  <input type="text" name="description" onkeyup="backdoor(<?= $i ?>)" placeholder="<?= $row['description'] ?>">
                  <button type="button" name="button" onclick="list.modify(<?= $i++ ?>)" disabled>설명 수정</button>
                </div>
              <?php endforeach ?>
            <?php endif ?>
          </div>
          <!--
          <table id="gallery">
            <tbody>

              </tr>
              <tr>
                <td></td>
              </tr>
            </tbody>
          </table>
          -->
          <div class="center">
            <?php for($i=$page['start']; $i<=$page['end']; $i++) : ?>
              <a class="abtn<?= ($i === (int)$page['current'])?' current':'' ?>" href="/gallery_list.php?p=<?= $i ?>"><?= $i ?></a>
            <?php endfor ?>
          </div>
        </form>


        <form id="uploadForm" action="gallery_upload.php" method="post" enctype="multipart/form-data">
          <ul>
            <li>jpeg, png, gif 파일 업로드 가능(용량 제한 없음)</li>
            <li>다중 업로드 가능</li>
          </ul>
          <input type="file" name="files[]" value="" accept="image/jpeg,image/png,image/gif" onchange="imageURL(this)" multiple="multiple">
          <button type="submit" name="upload">업로드</button>
          <div class="imgs">

          </div>
        </form>
      </div>

      <script type="text/javascript">
      var domMain = document.getElementById('sub').getElementsByTagName('li');
      var list = {
        dom: {
          section: {
            upload: document.getElementById('uploadForm'),
            list: document.getElementById('deleteForm')
          },
          menuLine: {
            upload: domMain[0].children[0],
            list: domMain[1].children[0],
            del: domMain[2].children[0],
            cancel: domMain[3].children[0],
            count: document.getElementById('len')
          },
          boxes: {
            box: document.getElementById('gallery').getElementsByTagName('div'),
            getId: function(i) {
              return this.box[i].children[0];
            },
            getDescription: function(i) {
              return this.box[i].children[3];
            },
            getSubmit: function(i) {
              return this.box[i].children[4];
            }
          },
          modifyForm: {
            form: document.getElementById('modifyForm'),
            id: document.getElementById('modifyForm').children[0],
            description: document.getElementById('modifyForm').children[1]
          },
          deleteForm: document.getElementById('deleteForm')
        },
        count: 0,
        pick: function(i) {
          if(!this.dom.boxes.getId(i).checked) {
            this.dom.boxes.getId(i).checked = true;
            this.count++;
          }
          else {
            this.dom.boxes.getId(i).checked = false;
            this.count--;
          }
          this.refresh();
        },
        refresh: function() {
          if(this.count>0) {
            this.dom.menuLine.count.innerText = this.count + '개 선택됨.';
            this.dom.menuLine.del.style.display = '';
            this.dom.menuLine.cancel.style.display = '';
          }
          else {
            this.dom.menuLine.count.innerText = '';
            this.dom.menuLine.del.style.display = 'none';
            this.dom.menuLine.cancel.style.display = 'none';
          }
        },
        modify: function(i) {
          this.dom.modifyForm.id.value = this.dom.boxes.getId(i).value;
          this.dom.modifyForm.description.value = this.dom.boxes.getDescription(i).value;
          this.dom.modifyForm.form.submit();
        },
        check: function(i) {
          if(this.dom.boxes.getDescription(i).value == '') {
            this.dom.boxes.getSubmit(i).disabled = true;
          }
          else {
            this.dom.boxes.getSubmit(i).disabled = false;
          }
        },
        cancel: function() {
          for(var i=0; i<this.dom.boxes.box.length; i++) {
            this.dom.boxes.getId(i).checked = false;
          }
          this.count = 0;
          this.refresh();
        },
        openList: function() {
          this.dom.menuLine.upload.style.display = '';
          this.dom.section.upload.style.display = 'none';
          this.dom.menuLine.list.style.display = 'none';
          this.dom.section.list.style.display = '';
        },
        openUploader: function() {
          this.dom.menuLine.upload.style.display = 'none';
          this.dom.section.upload.style.display = '';
          this.dom.menuLine.list.style.display = '';
          this.dom.section.list.style.display = 'none';
        }
      };
      function backdoor(i) {
        list.check(i);
      }
      list.dom.menuLine.del.style.display = 'none';
      list.dom.menuLine.cancel.style.display = 'none';
      list.dom.menuLine.list.style.display = 'none';
      list.dom.section.upload.style.display = 'none';
      </script>

      <script type="text/javascript">
      initImages();

      function imageURL(input) {
        initImages();
        if (input.files && input.files.length>0) {
          document.getElementsByName('upload')[0].disabled = false;
          var onloadcallback = function(e) {
            //document.getElementsByTagName('img')[0].setAttribute('src', e.target.result);
            makeImage(e.target.result);
          };

          for(var i=0; i<input.files.length; i++) {
            var reader = new FileReader();
            reader.onload = onloadcallback;
            reader.readAsDataURL(input.files[i]);
          }
        }
      }

      function initImages() {
        document.getElementsByClassName('imgs')[0].innerHTML = '';
        document.getElementsByName('upload')[0].disabled = true;
      }

      function makeImage(src) {
        var box = document.createElement('div');
        var obj = document.createElement('img');
        var in1 = document.createElement('input');
        in1.setAttribute('placeholder', '사진 설명을 입력');
        in1.setAttribute('type', 'text');
        in1.setAttribute('name', 'names[]');
        obj.setAttribute('src', src);
        var cnter = document.getElementsByClassName('imgs')[0];
        box.appendChild(obj);
        box.appendChild(in1);
        cnter.appendChild(box);
      }
      </script>
    </main>
  </body>
</html>
