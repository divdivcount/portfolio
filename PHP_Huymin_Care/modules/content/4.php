<?php
/*
FileName: 4.php
Modified Date: 20190926
Description: 서브:상담신청
*/
require_once($_SERVER['DOCUMENT_ROOT'].'/modules/module_protect.php');
?>
<?php // Javascript ?>
<script src="/script/js_sub4.js" charset="utf-8"></script>
<?php // Lnb ?>
<div class="lnb">
  <table>
    <tbody>
      <tr>
        <td>Home</td>
        <td><?= $pagename ?></td>
      </tr>
    </tbody>
  </table>
</div>
<?php // Main ?>
<main>
  <section class="bg-white" id="sub1">
    <form id="sangdam" action="/consulting_upload.php" method="post">
      <div>
        <span>상담자 이름</span>
        <div><input type="text" name="name" value="" placeholder="성함"></div>
      </div>
      <div>
        <span>전화번호</span>
        <div><input type="text" name="phone" value="" placeholder="전화번호"></div>
      </div>
      <div>
        <span>상담 내용</span>
        <div><textarea name="content" rows="8" placeholder="상담내용을 입력해주세요."></textarea></div>
      </div>
    </form>
    <div>
      개인정보처리방침 동의<input type="checkbox"><br>
      <button class="style-s" type="button" onclick="open_pop()">전문보기</button><button class="style-p" type="button" onclick="submit(this)">상담 신청하기</button>
    </div>
  </section>
  <div id="popuplayer">
    <div>
      <strong>개인정보처리방침</strong>
      <section>
        <p>개인정보 취급 방침 동의</p>
        <p>개인정보의 수집 및 이용목적</p>
        <p>성명, 주소, 연락처 :  효민요양원의 의학정보 안내나 권유 등 서비스 이용 안내, 마케팅 메시지 전송을 활용한 홍보활동 동의.</p>
        <p>소식 및 고지사항 전달, 불만처리 등을 위한 원활한 의사소통 경로의 확보 등</p>
        <p>개인정보는 본인이 원하시는 경우 연락 주시면 삭제 가능합니다.</p>
      </section>
      <p>
        <button type="button" onclick="close_pop()">닫기</button>
      </p>
    </div>
  </div>
</main>
<?php // Fixed Popup ?>
<div id="popuplayer">
  <div>
    <strong>개인정보처리방침</strong>
    <section>
      <p>개인정보 취급 방침 동의</p>
      <p>개인정보의 수집 및 이용목적</p>
      <p>성명, 주소, 연락처 :  효민요양원의 의학정보 안내나 권유 등 서비스 이용 안내, 마케팅 메시지 전송을 활용한 홍보활동 동의.</p>
      <p>소식 및 고지사항 전달, 불만처리 등을 위한 원활한 의사소통 경로의 확보 등</p>
      <p>개인정보는 본인이 원하시는 경우 연락 주시면 삭제 가능합니다.</p>
    </section>
    <p>
      <button type="button" onclick="close_pop()">닫기</button>
    </p>
  </div>
</div>
