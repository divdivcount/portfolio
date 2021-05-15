<?php
/*
FileName: 2.php
Modified Date: 20190926
Description: 서브:요양원소개
*/
require_once($_SERVER['DOCUMENT_ROOT'].'/modules/module_protect.php');
?>
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
    <h2>생활시간표</h2><span></span>
    <table id="sub8">
      <thead>
        <tr>
          <th>시간</th>
          <th>내용</th>
          <th>생활안내</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>6:30~</td>
          <td>기상</td>
          <td>세안, 배설상태 확인, 옷 입기, 침상정리</td>
        </tr>
        <tr>
          <td class="si_td">7:20~</td>
          <td>아침식사</td>
          <td>식사, 투약지도, 구강관리, 배설관리</td>
        </tr>
        <tr>
          <td class="si_td">9:00~</td>
          <td>건강관리</td>
          <td>실내 환경정리,활력증후 측정</td>
        </tr>
        <tr>
          <td class="si_td">10:15~</td>
          <td>간식</td>
          <td></td>
        </tr>
        <tr>
          <td class="si_td">10:30~</td>
          <td>체조</td>
          <td>국민체조 따라하기, 트로트,국악 부르기</td>
        </tr>
        <tr>
          <td class="si_td">11:15~</td>
          <td>프로그램</td>
          <td>일일점검표, 교양활동, 인지활동</td>
        </tr>
        <tr>
          <td class="si_td">12:00~</td>
          <td>점심식사</td>
          <td>식사, 투약지도, 구강관리, 배설관리</td>
        </tr>
        <tr>
          <td class="si_td">1:00~</td>
          <td>휴식</td>
          <td></td>
        </tr>
        <tr>
          <td class="si_td">2:00~</td>
          <td>걷기운동, 목욕(화,금)</td>
          <td>목욕, 상처관리, 이미용 서비스</td>
        </tr>
        <tr>
          <td class="si_td">3:00~</td>
          <td>간식</td>
          <td></td>
        </tr>
        <tr>
          <td class="si_td">3:30~</td>
          <td>프로그램</td>
          <td>놀이치료</td>
        </tr>
        <tr>
          <td class="si_td">4:15~</td>
          <td>휴식</td>
          <td></td>
        </tr>
        <tr>
          <td class="si_td">5:00~</td>
          <td>저녁식사</td>
          <td>식사, 투약지도, 구강관리, 배설관리</td>
        </tr>
        <tr>
          <td class="si_td">6:30~</td>
          <td>건강관리</td>
          <td>청결지도, 피부관리</td>
        </tr>
        <tr>
          <td class="si_td">7:00~</td>
          <td>휴식</td>
          <td>TV시청 및 자유시간</td>
        </tr>
        <tr>
          <td class="si_td">9:00~</td>
          <td>취침</td>
          <td>간식, 취침 준비</td>
        </tr>
      </tbody>
    </table>
  </section>
</main>
