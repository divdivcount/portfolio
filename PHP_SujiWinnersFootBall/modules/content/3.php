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
      <h1 class="color-primary center"></h1>
      <div class="textarea">
        <h3>교육시간</h3><span></span>
        <p style="display:inline;">
          <img class="circle_img" src="img/curcle.png" alt="교육시간" width="20%" />
          <table style="margin-top: 70px;" id="sub3">
            <thead>
              <tr>
                <th class="td_container"></th>
                <th>프로그램 및 시간</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>체조</td>
                <td>기본 체조 및 몸풀기[5분]</td>
              </tr>
              <tr>
                <td>레크리에이션</td>
                <td>운동전의 흥미유발 및 집중효과[15분]
                </td>
              </tr>
              <tr>
                <td>기술훈련</td>
                <td>볼 감각운동, 축구 기본기, 전문기술[30분]
                </td>
              </tr>
              <tr>
                <td>축구게임</td>
                <td>협동심, 자신감, 집중력, 활동력 증진효과[20분]</td>
              </tr>
            </tbody>
          </table>
        </p>
        <div style="clear:both">

        </div>
        <h3>교육을 통한 성장</h3><span></span>
        <h4>축구 기술</h4>
        <p>선수 출신 선생님들의 전문적인 축구교육으로 개인 축구기술 향상</p>
        <h4>자신감</h4>
        <p>축구(운동)을 통해 뭐든 할 수 있다는 자신감 향상</p>
        <h4>성격</h4>
        <p>소극적이고 내성적인 아이가 친구들과 함꼐 뒤고 도와가며 운동하면서 점차 외향적이고 적극적인 성격으로 변화</p>
        <h4>단체 성</h4>
        <p>개인적이고 자기 자신만 알던 아이가 팀 워크를 중요시하는 축구를 배우면서 나 혼자가 아닌 ‘우리’라는 단체성을 느끼게 됨</p>
        <h3>교육 대상</h3><span></span>
        <table id="sub3">
          <thead>
            <tr>
              <th class="td_container">교육대상</th>
              <th>교육시간</th>
              <th>교육장소</th>
              <th>교육인원</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>유치 부 (6 ~ 7세)</td>
              <td>60분</td>
              <td>수지 위너스 전용 축구센터</td>
              <td>6명 ~ 12명</td>
            </tr>
            <tr>
              <td>초등 부(1 ~ 6학년)</td>
              <td>70분</td>
              <td>수지 위너스 전용 축구센터</td>
              <td>8명 ~ 12명</td>
            </tr>
          </tbody>
        </table>
        <h3>부상 및 보험</h3><span></span>
        <h4>부상을 당한 학생</h4>
        <p>1. 축구교육시간에 한 명이라도 부상이 있는 아이들은 팀 담당선생님이 확인 후 작은 부상일 경우 그 자리에서 바로 응급처치를 하며 병원에 갈 큰 부상이라면  부모님께 상황보고 후 당일 병원으로 데려가 전문의에게 의뢰합니다.</p>
        <p>(추가 설명 : 병원에 부모님께서 직접 아이와 동행하여 진료 받습니다.)</p>
        <p>2. 저희 클럽에는 축구교육시간에 부상을 당한 학생(회원)은 보험적용이 되어 모든 진료비를 보험 처리해 드립니다.</p>
        <h4>병원진찰 및 치료를 받았을 시</h4>
        <p>1. 총 병원 진료비 영수증</p>
        <p>2. 주민등록 등본 1통</p>
        <p>3. 보험료 받으실 통장 앞면 복사본 1통</p>
        <p>총 3개의 서류를 담당선생님께 제출하시면 됩니다.</p>
        <p>보험료 송금은 서류 제출 후 10일 안에 처리됩니다.</p>
      </div>
    </div>
  </section>
</main>
