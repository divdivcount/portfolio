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
          <li>소개</li>
          <li><a style="color:#ffffff;" href="https://sujiwinnersfootball.com/sub.php?p=2#sub1">인사말</a></li>
          <li><a style="color:#ffffff;" href="https://sujiwinnersfootball.com/sub.php?p=2#sub2">시설소개</a></li>
          <li><a style="color:#ffffff;" href="https://sujiwinnersfootball.com/sub.php?p=2#sub3">오시는 길</a></li>
        </ul><ul>
          <li>교육과정</li>&nbsp;
          <li><a style="color:#ffffff;" href="https://sujiwinnersfootball.com/sub.php?p=3">교육과정</a></li>
        </ul><ul>
          <li><a style="color:#ffffff;" href="https://sujiwinnersfootball.com/sub.php?p=4"> 상담신청</a></li>
        </ul><ul>
          <li>게시판</li>
          <li><a style="color:#ffffff;" href="https://sujiwinnersfootball.com/sub.php?p=5">공지사항</a></li>
          <li><a style="color:#ffffff;" href="https://sujiwinnersfootball.com/sub.php?p=6">사진 갤러리</a></li>
	  <li><a style="color:#ffffff;" href="https://sujiwinnersfootball.com/sub.php?p=9">동영상 갤러리</a></li>
          <li><a style="color:#ffffff;" href="https://sujiwinnersfootball.com/sub.php?p=7">일정표</a></li>
        </ul>
      </section><section class="info">
	
		<p><a style="color:#aaa;" href="../geinjungbo.html" target="_blank">개인정보처리방침</a></p>
        <p>센터위치 : 경기도 용인시 상현동 수지로 18-2</p>
        <p>TEL : 031-897-6550 / FAX : 031-897-6551</p>
        <p>대표자:윤창균</p>
        <p>Phone : 010-5787-6550</p>
		<p>사업자 번호 : 494-86-02153</p>
        <p>&copy;2021 by Ky_tech</p>
      </section>
    </div>
  </footer>
<?php endif ?>
