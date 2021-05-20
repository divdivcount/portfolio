<?php
require_once('modules/db.php');
?>
  <div class="selectStation_modalBox hidden">
    <div class="closeBtn_box_2"><img src="img/cancle.png" class="selectStation_closeBtn" onclick="selectStation_close()"></div>

    <form  id="selectMetro_box" action="station_update.php" method="post">
      <input type="hidden" name="mode" value="modify">
      <input type="hidden" name="mbs_id"  value="<?= isset($mb["mb_id"]) ? $mb["mb_id"] : 'null' ?>">
      <input type="hidden" name="om_id"  value="<?= isset($om["om_id"]) ? $om["om_id"] : 'null' ?>">

      <div class="title_line">
      </div>

      <div class="input_line">

        <div id="bothFind_item">

        <div class="find_item">
          <span>호선을 선택해 주세요.</span>
          <select name="ctg_name" id="selectID" class="w3-select">
            <option value="">선택</option>
            <option value="all">전체</option>
            <?php
            $sql = " select * from line";
            $select_station_result = mysqli_query($conn, $sql);
            while ($row = mysqli_fetch_assoc($select_station_result)) {
            ?>
            <option value="<?=$row["l_id"]?>"><?=$row["l_name"]?></option>
          <?php }
          mysqli_close($conn);
          ?>
          </select>
        </div>

        <div class="find_item">
          <span>지하철역을 입력해주세요.</span>

          <div style="display:flex"><input id="auto" class="w3-input highlight" name="station" value='' type="text"><div style="width:1.3rem;margin:auto"><img src="img\loupe.png" alt=""></div></div>
        </div>

        </div>

        <button type="submit" class="w3-button w3-blue w3-ripple w3-round-xlarge close_pop">등록</button>
      </div>
    </form>

  </div>
<script type="text/javascript">
$(document).ready(function(){ // html 문서를 다 읽어들인 후
  

    $('#selectID').on('change', function(){
        if(this.value !== ""){
            var optVal = $(this).find(":selected").val();
            //alert(optVal);
            $.post('autosearch.php',{optVal:optVal}, function(data) {
              let source = $.map($.parseJSON(data), function(item) { //json[i] 번째 에 있는게 item 임.
                chosung = "";
                //Hangul.d(item, true) 을 하게 되면 item이 분해가 되어서
                //["ㄱ", "ㅣ", "ㅁ"],["ㅊ", "ㅣ"],[" "],["ㅂ", "ㅗ", "ㄲ"],["ㅇ", "ㅡ", "ㅁ"],["ㅂ", "ㅏ", "ㅂ"]
                //으로 나오는데 이중 0번째 인덱스만 가지고 오면 초성이다.
                full = Hangul.disassemble(item).join("").replace(/ /gi, "");	//공백제거된 ㄱㅣㅁㅊㅣㅂㅗㄲㅇㅡㅁㅂㅏㅂ
                Hangul.d(item, true).forEach(function(strItem, index) {

                  if(strItem[0] != " "){	//띄어 쓰기가 아니면
                    chosung += strItem[0];//초성 추가

                  }
                });


                return {
                  label : chosung + "|" + (item).replace(/ /gi, "") +"|" + full, //실제 검색어랑 비교 대상 ㄱㅊㅂㅇㅂ|김치볶음밥|ㄱㅣㅁㅊㅣㅂㅗㄲㅇㅡㅁㅂㅏㅂ 이 저장된다.
                  value : item,
                  chosung : chosung,
                  full : full
                }
              });
              $("#auto").autocomplete({
                        source : source,	// source 는 자동 완성 대상
                        select : function(event, ui) {	//아이템 선택시
                          console.log(ui.item.label + " 선택 완료");

                        },
                        focus : function(event, ui) {	//포커스 가면
                          return false;//한글 에러 잡기용도로 사용됨
                        },
              }).autocomplete( "instance" )._renderItem = function( ul, item ) {
              //.autocomplete( "instance" )._renderItem 설절 부분이 핵심
                  return $( "<li>" )	//기본 tag가 li로 되어 있음
                    .append( "<div>" + item.value + "</div>" )	//여기에다가 원하는 모양의 HTML을 만들면 UI가 원하는 모양으로 변함.
                    .appendTo( ul );	//웹 상으로 보이는 건 정상적인 "김치 볶음밥" 인데 내부에서는 ㄱㅊㅂㅇㅂ,김치 볶음밥 에서 검색을 함.
               };
        })
      }
    })
  });


  $("#auto").on("keyup",function(){	//검색창에 뭔가가 입력될 때마다
  input = $("#auto").val();	//입력된 값 저장
  $( "#auto" ).autocomplete( "search", Hangul.disassemble(input).join("").replace(/ /gi, "") );	//자모 분리후 띄어쓰기 삭제
  })

</script>
