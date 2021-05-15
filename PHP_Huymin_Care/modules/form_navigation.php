<?php
/*
FileName: form_navigation.php
Modified Date: 20190902
Description: 폼: 내비게이션
*/
// Load Modules
require_once($_SERVER['DOCUMENT_ROOT'].'/modules/module_protect.php');

// Parameter

// Functions

// Process
?>
<?php if(UserPage()) : ?>
  <header>
    <table>
      <tbody>
        <tr>
          <td class="logo">
            <a href="?p=0" class="logo">
              <img src="img/logo.png">
            </a>
          </td>
          <td class="hamberger">
            <input type="checkbox" id="menuicon">
            <label for="menuicon">
              <span></span>
              <span></span>
              <span></span>
            </label>
            <div class="sidebar">
              <input id="subbtn1" type="checkbox">
              <label for="subbtn1">요양원소개</label>
              <ul>
                <li><a href="?p=2#sub1">인사말</a></li>
                <li><a href="?p=2#sub2">시설소개</a></li>
                <li><a href="?p=2#sub3">오시는 길</a></li>
              </ul>
              <input id="subbtn2" type="checkbox">
              <label for="subbtn2">서비스 소개</label>
              <ul>
                <li><a href="?p=3#sub1">노인장기요양보험</a></li>
                <li><a href="?p=3#sub2">이용 안내</a></li>
              </ul>
              <input id="subbtn3" type="checkbox">
              <label for="subbtn3">상담신청</label>
              <ul>
                <li><a href="?p=4">상담신청</a></li>
              </ul>
              <input id="subbtn4" type="checkbox">
              <label for="subbtn4">게시판</label>
              <ul>
                <li><a href="?p=5">공지사항</a></li>
                <li><a href="?p=6">갤러리</a></li>
                <li><a href="?p=7">일정표</a></li>
                <li><a href="?p=8">생활시간표</a></li>
              </ul>
            </div>
          </td>
          <td class="nav">
            <ul>
              <li>
                <a href="?p=2">요양원소개</a>
                <ul>
                  <a href="?p=2#sub1"><li>인사말</li></a>
                  <a href="?p=2#sub2"><li>시설소개</li></a>
                  <a href="?p=2#sub3"><li>오시는 길</li></a>
                </ul>
              </li><li>
                <a href="?p=3">서비스 소개</a>
                <ul>
                  <a href="?p=3#sub1"><li>노인장기요양보험</li></a>
                  <a href="?p=3#sub2"><li>이용 안내</li></a>
                </ul>
              </li><li>
                <a href="?p=4">상담신청</a>
              </li><li>
                <a href="?p=5">게시판</a>
                <ul>
                  <a href="?p=5"><li>공지사항</li></a>
                  <a href="?p=6"><li>갤러리</li></a>
                  <a href="?p=7"><li>일정표</li></a>
                  <a href="?p=8"><li>생활시간표</li></a>
                </ul>
              </li>
            </ul>
          </td>
        </tr>
      </tbody>
    </table>
  </header>
<?php elseif(AdminPage()) : ?>
  <nav>
    <div class="logo">
      <img src="img/logo.png">
    </div>
    <div class="list">
      <a href="/board_list.php">공지 관리</a>
      <a href="/gallery_list.php">갤러리 관리</a>
      <a href="/calendar_list.php">시간표 관리</a>
      <a href="/consulting_list.php">상담 요청 목록</a>
      <a href="/sign-modify.php">비밀번호 변경</a>
      <a href="/sign-out.php">로그아웃</a>
    </div>
  </nav>
<?php endif ?>
