<?php
/*
FileName: form_Mfooter.php
Modified Date: 20190920
Description: 폼: 푸터
*/
// Load Modules
require_once($_SERVER['DOCUMENT_ROOT'].'/modules/module_protect.php');

// Parameter

// Functions

// Process
?>
<?php if(UserPage()) : ?>
  <footer>
    <div class="guide">
      <img src="../img/logo2.png" alt="">
      <section class="sitemap1">
        <ul>
          <li>요양원소개</li>
          <li>인사말</li>
          <li>시설소개</li>
          <li>오시는 길</li>
        </ul><ul>
          <li>서비스소개</li>
          <li>노인장기요양보험</li>
          <li>이용안내</li>
        </ul><ul>
          <li>상담신청</li>
        </ul><ul>
          <li>게시판</li>
          <li>공지사항</li>
          <li>갤러리</li>
          <li>일정표</li>
        </ul>
      </section><section class="info">
        <p>센터위치 : 경기도 용인시 죽전동 현암로 95 현대프라자 504호 / TEL : 031-266-1774 / FAX : 031-266-1775</p>
        <p>대표자:이선민 / TEL : 010-4741-2164 / Email:esm1008@naver.com</p>
        <p>&copy;2019 by tec-k.</p>
      </section>
    </div>
  </footer>
<?php endif ?>
