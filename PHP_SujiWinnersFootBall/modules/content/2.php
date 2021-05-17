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
    <div class="hl">
      <h1 class="color-primary center">아이들이 주인공인 위너스 풋볼 아카데미!</h1>
      <h4 class="center">"우리의 아이들의 <span class="color-orange">체력과 민첩성 그리고 균형감각 향상을 위해 </span>위너스 풋볼 아카데미에서 <span class="color-orange">도와드리겠습니다.</span>"</h4>
    </div>

    <h2>인사말</h2><span></span>
    <img class="fright mobilehidden" src="img/info.jpg" alt="회사 사진" style="width:30%;">
    <div class="textarea">
      <h4 class="color-primary">안녕하십니까? 위너스 풋볼 아카데미를 찾아주셔서 감사합니다.</h4>
      <p>위너스 풋볼 아카데미는 아이들에게 팀워크와 기본체력 그리고 협동심을 기르고 사회성 함양에 대해 가르치겠습니다.
        위너스 풋볼 아케데미는 300평 야외 전용 축구장과 100평 규모의 어린이 전용 실내축구장을 보유하여 궂은 날씨에 영향을 받지않고 수업을 진행 할 수 있으며,
        체육학을 전공한 석사, 학사, 선수출신 선생님들의 수준 높은 교육과 차원 높은 케어를 위해 끈임없이 노력하고 있습니다.
        <br><br>
        아이들이 편안하고 안전한 환경에서 운동할 수 있도록 항상 고민하고 건강한 신체발달과 건전한 인성발달을 책임지는 위너스 풋볼 아카데미가 되겠습니다.
      </p>
    </div>
    <div class="hl">
      <h4 class="fclear center" style="width:60%;">저희 위너스 풋볼 아카데미는 <span class="color-orange">축구에 대한 전문지식</span>과 노하우를 가지고
        <span class="style-p">아이들에게</span> 정성껏 가르치겠습니다.
        긴 글 읽어 주셔서 감사합니다.
      </h4>
    </div>
  </section>
  <section class="bg-gray" id="sub2">
    <h2>시설소개</h2><span></span>
    <div class="imgs">
      <div>
        <h4 class="center fts">&lt;실내 풋살장 1층&gt;</h4>
        <img class="center" src="img/siser.jpg" alt="침실 사진" style="width:90%;">
      </div><div>
        <h4 class="center fts">&lt;실내 풋살장 2층&gt;</h4>
        <img class="center" src="img/siser2.jpg" alt="화장실 사진" style="width:90%;">
      </div><div>
        <h4 class="center fts">&lt;실외 풋살장&gt;</h4>
        <img class="center" src="img/siser3.jpg" alt="화장실 사진" style="width:90%;">
      </div><div>
        <h4 class="center fts">&lt;주차장&gt;</h4>
        <img class="center" src="img/siser4.jpg" alt="화장실 사진" style="width:90%;">
      </div>
    </div>
  </section>
  <section class="bg-white" id="sub3">
    <h2>오시는 길</h2><span></span>
    <h4 class="center">약도</h4>
    <img class="center" src="img/ak.png" alt="" width="70%">
    <div class="imgs">
      <div>
        <h4 class="center">차량이용 및 주차</h4>
        <table class="information">
          <tbody>
            <tr>
              <th>내비게이션</th>
              <td>위너스 풋볼 아카데미, 경기도 용인시 수지로 18-2<br>건물 1층</td>
            </tr>
            <tr>
              <th>주차장</th>
              <td>건물 앞 전용주차장</td>
            </tr>
          </tbody>
        </table>
      </div><div>
        <h4 class="center">대중교통 및 도보</h4>
        <table class="information">
          <tbody>
            <tr>
              <th>버스</th>
              <td>수지 720-1번 탑승, 광교상현꿈에그린 하차, 팔당냉면 골목으로 직진 도보 5분 거리</td>
            </tr>
            <tr>
              <th>지하철</th>
              <td>신분당선 상현역에서 720-1번, 720-3번  광교상현꿈에그린 하차(팔당 냉면 앞)</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </section>
</main>
