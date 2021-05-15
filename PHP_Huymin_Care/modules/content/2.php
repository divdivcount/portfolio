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
      <h1 class="color-primary center">어르신이 주인공인 더 사랑 효민 요양원</h1>
      <h4 class="center">"부모님이 우리를 <span class="color-orange">정직하고 아름답게 키워주셨으니</span> 이제 우리가 부모님의 <span class="color-orange">인생을 아름답게 꾸며 드려야 합니다.</span>"</h4>
    </div>

    <h2>인사말</h2><span></span>
    <img class="fright mobilehidden" src="img/insa.jpg" alt="요양원 사진" style="width:30%;">
    <div class="textarea">
      <h4 class="color-primary">안녕하십니까? 더 사랑 효민 요양원을 찾아주셔서 감사합니다.</h4>
      <p>더 사랑 효민 요양센터는 최신시설과 내집같은 편안함, 축적된 전문 지식,
        노하우로 편안함을 증진하며 개별 맞춤간호를 합니다.
        뇌졸중, 치매 등 노인성 질환으로 어려움을 겪고 계신 분들에게
        체계적이고 편안한 전문 간호를 제공 하는 노인 전문 요양센터 입니다.
        오랜 기간 노인 간호에 종사한 간호지식과 노하우를 십분 발휘 하여
        어르신을 편안하게 모시겠습니다.<br><br>
        어르신이 편안하게 대접받고 자손을 위해 살아온 보람을 느끼게하는 사회가
        되는데 일조하는 그런 센터가 되겠습니다.
      </p>
      <h4 class="color-primary">더 사랑 효민 요양원 만의 특징</h4>
      <ol>
        <li>내 집같이 편안합니다.</li>
        <li>어르신을 안전하게 모실수있는 시설을 갖추었습니다.</li>
        <li>효를 기본으로 하는 노인 전문 간호사가 있습니다.</li>
        <li>개별적인 맞춤 요양을 제공합니다.</li>
        <li>매일 신선한 식재료를 제공하여 어르신들에 건강식단을 책임집니다.</li>
        <li>외부강사를 초빙하여 어르신들의 흥을 돋구어 즐거움을 드립니다.</li>
        <li>다양한 인지자극 프로그램으로 어르신들의 잔존기능을 유지시켜 드립니다.</li>
      </ol>
    </div>
    <div class="hl">
      <h4 class="fclear center" style="width:60%;">저희 더 사랑 효민 요양센터에서는 <span class="color-orange">노인간호 전문지식</span>과 노하우를 가지고
        <span class="style-p">자식된 마음</span>으로 정성껏 섬기겠습니다.
        긴 글 읽어 주셔서 감사합니다.
      </h4>
    </div>
  </section>
  <section class="bg-gray" id="sub2">
    <h2>시설소개</h2><span></span>
    <div class="imgs">
      <div>
        <h4 class="center fts">&lt;남자침실/여자침실&gt;</h4>
        <img class="center" src="img/siser.jpg" alt="침실 사진" style="width:90%;">
      </div><div>
        <h4 class="center fts">&lt;남자화장실/여자화장실&gt;</h4>
        <img class="center" src="img/to.jpg" alt="화장실 사진" style="width:90%;">
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
              <td>더사랑효민요양센터, 경기도 용인시 수지구 현암로 95 현대프라자 5층 504호</td>
            </tr>
            <tr>
              <th>주차장</th>
              <td>현대프라자 지하주차장</td>
            </tr>
          </tbody>
        </table>
      </div><div>
        <h4 class="center">대중교통 및 도보</h4>
        <table class="information">
          <tbody>
            <tr>
              <th>버스</th>
              <td>동백 390번 대지중학교 하차, 새터마을 입구 방향으로 도보 5분거리</td>
            </tr>
            <tr>
              <th>지하철</th>
              <td>분당선 오리역에서 39번, 39-1번 죽전1동 새터마을 입구(신현앞) 하차</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </section>
</main>
