<?php
/*
FileName: 6.php
Modified Date: 20190926
Description: 서브:갤러리
*/
require_once($_SERVER['DOCUMENT_ROOT'].'/modules/module_protect.php');
?>
<?php // Javascript ?>
<script type="text/javascript" src="script/getjson.js"></script>
<script src="/script/js_sub6.js" charset="utf-8"></script>
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
    <div class="fourimg">

    </div>
    <button class="style-p" type="button" onclick="loadDoc()">불러오기</button>
  </section>
</main>
<?php // Fixed Popup ?>
<div id="imagelayer">
  <div class="img">
    <span></span>
    <img>
  </div>
  <div class="close" onclick="close_image(this)"></div>
</div>
