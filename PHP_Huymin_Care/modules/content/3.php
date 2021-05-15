<?php
/*
FileName: 3.php
Modified Date: 20190926
Description: 서브:서비스 소개
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
      <h1 class="color-primary center">노인장기요양보험제도란?</h1>
      <div class="textarea">
        <h3>의의</h3><span></span>
        <p>고령이나 노인성 질병 등으로 일상생활을 혼자서 수행하기 어려운 이들에게 신체활동 및 일상생활 지원 등의
            서비스를 제공하여 노후 생활의 안정과 그 가족의 부담을 덜어주기 위한 사회보험제도
        </p>
        <h3>주요내용</h3><span></span>
        <h4>신청대상</h4>
        <p>소득수준과 상관없이 노인장기요양보험 가입자(국민건강보험 가입자와 동일)와 그 피부양자</p>
        <p>의료급여수급권자로서 65세 이상 노인과 65세 미만의 노인성 질병이 있는 자</p>
        <h4>급여대상</h4>
        <p>65세 이상 노인 또는 치매, 중풍, 파킨스병 등 노인성 질병을 앓고 있는 65세 미만인 자 중 6개월 이상의 기간 동안 일상생활을 수행하기 어려워 장기요양서비스가 필요하다고 인정되는 자 </p>
        <p>장기요양등급 : 1등급, 2등급, 3등급, 4등급, 5등급</p>
        <table id="sub3">
          <thead>
            <tr>
              <th>등급구분</th>
              <th>판정기준</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>장기요양1등급</td>
              <td>일상생활에서 전적으로 다른 사람의 도움이 필요한 자로서 장기요양인정점수가 95점 이상인 자</td>
            </tr>
            <tr>
              <td>장기요양2등급</td>
              <td>일상생활에서 상당 부분 다른 사람의 도움이 필요한 자로서 장기요양인정점수가 75점 이상
                95점 미만인 자
              </td>
            </tr>
            <tr>
              <td>장기요양3등급</td>
              <td>일상생활에서 부분적으로 다른 사람의 도움이 필요한 자로서 장기요양인정점수가 60점 이상
                75점 미만인 자
              </td>
            </tr>
            <tr>
              <td>장기요양4등급</td>
              <td>일상생활에서 일정부분 다른 사람의 도움이 필요한 자로서 장기요양인정점수가 51점 이상 60점 미만인 자</td>
            </tr>
            <tr>
              <td>장기요양5등급</td>
              <td>치매환자로서 장기요양인정점수가 45점 이상 51점 미만인 자</td>
            </tr>
          </tbody>
        </table>
        <ul style=" margin-bottom:30px;">
          <h3>장기요양인정 및 서비스 이용절차</h3><span></span>
          <li style="line-height :30px;">① (공단 각 지사별 장기요양센터) 신청 → ② (공단직원) 방문조사 → ③ (등급판정위원회) 장기요양 인정 및 등급판정 → ④ (장기요양센터) 장기요양인정서 및 표준장기요양이용계획서 통보 → ⑤ (장기요양기관) 서비스 이용</li>
        </ul>
        <div id="list_img">
          <img class="center" src="img/sub1.png" alt="">
        </div>
        <h3>급여내용</h3><span></span>
        <ul style="list-style-position:outside;">
          <h4>시설급여</h4>
          <ul style="list-style-position:outside;">
            <li>요양시설에 장기간 입소하여 신체활동 지원 등 제공</li>
          </ul>
          <h4>재가급여</h4>
          <ul style="list-style-position:outside;">
            <li>가정을 방문하여 신체활동 및 가사활동 등 지원, 목욕, 간호 등 제공, 주간보호센터 이용, 복지용구 구입 또는 대여</li>
          </ul>
          <h4>특별현금급여</h4>
          <ul style="list-style-position:outside;">
            <li style="line-height :30px;">장기요양 인프라가 부족한 가정, 천재지변, 신체 · 정신 또는 성격 등 그 밖의 사유로 장기요양기관이 제공하는 장기요양급여를 이용하기 어렵다고 인정하는 경우 가족요양비 지급</li>
          </ul>
          <h3>장기요양기관</h3><span></span>
          <ul style="list-style-position:outside;">
            <li style="line-height :30px;">시설급여 제공기관(노인복지법상 노인요양시설 및 노인요양공동생활가정), 재가급여 제공기관(노인복지법상 재가노인복지시설 및 노인장기요양보험법상 재가장기요양기관) → 시 · 군 · 구청장의 지정 또는 설치신고
              장기요양요원: 요양보호사, 간호사 등
            </li>
          </ul>
        </ul>
        <h3>재원조달방식</h3><span></span>
        <ul style="list-style-position:outside;">
          <h4>장기요양보험료(‘16년) : 건강보험료액의 6.55%</h4>
          <ul style="list-style-position:outside; line-height :30px;">
            <li>노인장기요양보험 가입자는 국민건강보험 가입자와 동일, 건강보험료와 통합징수</li>
            <li>장기요양보험료율: 보건복지부장관 소속 장기요양위원회의 심의를 거쳐 대통령령으로 명시</li>
          </ul>
          <h4>국가지원</h4>
          <ul style="list-style-position:outside;  line-height :30px;">
            <li>장기요양보험료율 예상수입액의 20% 부담(국고)</li>
            <li style="line-height :30px;">의료급여수급권자의 장기요양급여비용, 의사소견서 발급비용, 방문간호지시서 발급비용 중 공단이 부담하여야할 비용 및 관리운영비의 전액을 국가와 지방자치단체가 분담</li>
          </ul>
          <h4>본인일부부담</h4>
          <ul style="list-style-position:outside; line-height :30px;">
            <li>시설급여 20%(비급여: 식재료비, 이미용료 등은 본인부담), 재가급여 15%</li>
            <li>의료급여수급권자 등 저소득층은 각각 1/2로 경감(시설 10%, 재가 7.5%)</li>
            <li>기초생활수급권자는 무료</li>
          </ul>
        </ul>
      </div>
    </div>
  </section>
  <section class="bg-gray" id="sub2">
    <h3>이용 안내</h3><span></span>
    <div class="anne_container">
      <div class="anne">
        <h4>입소 대상</h4>
        <ul>
          <li>치매,중풍 등의 노인성 질환으로 거동이 불편한 분</li>
          <li>병원에서 퇴원 후 전문 간병이 필요한 분</li>
          <li>전문 요양이 필요한 분</li>
          <li>장기요양등급 인정자</li>
        </ul>
      </div>
      <div class="anne">
        <h4>상담 방법</h4>
        <ul>
          <li>방문 신청</li>
          <li>이메일 또는 전화 신청</li>
          <li>홈페이지 문의 신청</li>
        </ul>
      </div>
      <div class="anne">
        <h4>입소시 준비 물품</h4>
        <ul>
          <li>표준 이용 계획서 1부</li>
          <li>요양 인정서 사본 1부</li>
          <li>홈의류 및 기타 개인 소지품</li>
          <li>가족관계 증명서, 신분증</li>
        </ul>
      </div>
    </div>
  </section>
</main>
