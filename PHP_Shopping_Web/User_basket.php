<?php
// Load Modules
require_once('modules/db.php');
$mb_id = $_SESSION['ss_mb_id'];
$sql = " select * from member where mb_id = TRIM('$mb_id') ";
$result = mysqli_query($conn, $sql);
$mb = mysqli_fetch_assoc($result);
mysqli_close($conn); // 데이터베이스 접속 종료
$num = 0;
$str = "";
?>
<!doctype html>
<html>
<head>
  <script type="text/javascript" src="https://service.iamport.kr/js/iamport.payment-1.1.5.js"></script>
  <?php require_once('modules/form_head.php'); ?>
  <style>
  .table {
    border-collapse: collapse;
    border-top: 3px solid #168;
    width:100%;
  }
  .table th {
    color: #168;
    background: #f0f6f9;
    text-align: center;
  }
  .table th, .table td {
    padding: 10px;
    border: 1px solid #ddd;
    text-align: center;
  }
  .table th:first-child, .table td:first-child {
    border-left: 0;
  }
  .table th:last-child, .table td:last-child {
    border-right: 0;
  }
  .table tr td:first-child{
    text-align: center;
  }
  .table caption{caption-side: bottom; display: none;}
    </style>
</head>
<body>

<?php
// $cart = explode(',', $_SESSION["cart"]);
// for ($i = 0; $i < count($cart); $i+=4) {
//
//         $var = $cart[$i];
//         if(!empty($var)){
//         $id = $cart[$i + 1];
//         $price = $cart[$i + 2];
//         $name = $cart[$i + 3];
//         $d[$var][$id]["price"] = $price;
//         $d[$var][$id]["name"] = $name;
//         $d[$var][$id]["qty"]++;
//       }
//     }

    ?>
      <table class= "table">
        <th>
        품목
        </th>
        <th>
        품목 아이디
        </th>
        <th>
          이미지
        </th>
        <th>
        제품 이름
        </th>
        <th>
        제품 가격
        </th>
        <th>
        수량
        </th>
        <th>
        처리
        </th>
        <?php
        if(empty($_SESSION["cart"])){
          echo "";
        }else{
          $d = $_SESSION["cart"];
        }
        if(empty($d)){
          ?>
          <tr>
            <td colspan="7"><img src="files/gibon/jangba.png"></td>
          </tr>
          <?php
        }else{
          $k = 0;
        foreach ($d as $cat_key => $cat_arr) {
            foreach ($cat_arr as $id_key => $id_val) {

                $k++;
              ?>
                <tr>
                  <td>
                <p style="margin-top:25px;">  <?= $cat_key ?></p>
                  </td>
                  <td>
                <p style="margin-top:25px;">  <?= $id_key ?></p>
                  </td>
                  <td>
                    <img src="<?= $id_val["img"] ?>" width="75px" height= "75px" />
                  </td>
                  <td>
                  <p style="margin-top:25px;"><?= $id_val["name"] ?></p>
                  </td>
                  <td>
                  <p style="margin-top:25px;"><?= $id_val["price"]*$id_val["qty"] ?>원</p>
                  </td>
                  <td>
                  <div style="margin-left: 200px; margin-top:25px; text-align:center; ">
                  <form action="User_changeqty.php?" method="get">
                      <input type="hidden" name="var" value="<?=$cat_key?>">
                      <input type="hidden" name="id" value="<?= $id_key ?>">

                      <input type="text" style="width:100px; text-align: center; float:left;" class="form-control" id="qty<?= $k ?>" name="qty" value="<?= $id_val["qty"] ?>" readonly/>
                      <input style="text-align: center; float:left;" class="btn btn-mini btn-primary" type="button" name="" value="^" onclick="document.getElementById('qty<?= $k ?>').value++"/>
                      <input style="text-align: center; float:left;" class="btn btn-mini btn-primary" type="button" name="" value="v" onclick="document.getElementById('qty<?= $k ?>').value--"/>
                      <input style="text-align: center; float:left;" class="btn btn-info btn-mini btn-primary" type="submit" value="수량변경" />
                  </div>
                  </form>
                  </td>
                  <td>
                  <input type="button" style="margin-top:25px;" class="btn btn-mini btn-danger" id="obj" value="삭제" onclick="javascript:location.href='User_cart_del.php?var=<?= $cat_key ?>&id=<?= $id_key ?>&name=<?= $id_val["name"] ?>'"/>
                  </td>
                </tr>
                  <?php
                    $pr_key = array($cat_key);
                    $pr_name = array($id_val["name"]);
                    foreach ($pr_key as $key => $prd_key) {
                    }
                      foreach($pr_name as $key => $prd_name) {
                        // echo "$key : $value".'<br />';
                      }

                    $str = $str.$prd_key.":".$prd_name.",";
                    $str_result = substr($str , 0, -1);
                    // print_r($pr_name);
                    $total= array($k =>$id_val["price"]*$id_val["qty"]);
                    foreach($total as $key => $value) {
                      // echo "$key : $value".'<br />';
                    }
                        $num = $num + $value;
                    // $num+= $value;
                  // $total= $id_val["price"]*$id_val["qty"];
                  // $num = implode(", ", $total);
                  // $name_array = explode(" ", $total);
                  //
                  // echo $name_array[0][1];
                  // $sum = 0;
                  // for($ie = 0; $ie < sizeof($total, 1); $ie++){
                  //
                  //   $sum += $total[$ie];
                  //
                  //
                  //   }
                }
              }
              echo "<td><p style='margin-top:16px;'>"."총금액"."</p></td>";
              echo "<td colspan='5' style='text-align:center;'><p style='margin-top:16px;'>".$num."원"."</p></td>";
?>
              <td>
                <button style='margin-top:5px;' class="btn btn-success btn-lg" id="check_module" type="button" >결제</button>
              </td>
        <?php
            }
            ?>
      </table>
      <!-- onclick="javascript:location.href='pay.php?price='" -->

      <?php if($mb['mb_num']){ ?>
      <script>
      $("#check_module").click(function () {
      var IMP = window.IMP; // 생략가능
      IMP.init('imp70544914');

      IMP.request_pay({
      pg: 'kakao', // version 1.1.0부터 지원.
      /*
      'kakao':카카오페이,
      html5_inicis':이니시스(웹표준결제)
      'nice':나이스페이
      'jtnet':제이티넷
      'uplus':LG유플러스
      'danal':다날
      'payco':페이코
      'syrup':시럽페이
      'paypal':페이팔
      */
      pay_method: 'card',
      /*
      'samsung':삼성페이,
      'card':신용카드,
      'trans':실시간계좌이체,
      'vbank':가상계좌,
      'phone':휴대폰소액결제
      */
      merchant_uid: 'merchant_' + new Date().getTime(),
      /*
      merchant_uid에 경우
      https://docs.iamport.kr/implementation/payment
      위에 url에 따라가시면 넣을 수 있는 방법이 있습니다.
      참고하세요.
      나중에 포스팅 해볼게요.
      */
      name: '<?= $str_result ?>',
      //결제창에서 보여질 이름
      amount: <?=$num ?>,
      //가격
      buyer_email: '<?=$mb["mb_email"]?>',
      buyer_name: '<?= $mb_id ?>',
      m_redirect_url: 'https://localhost/ky_project/User_basket.php'
      /*
      모바일 결제시,
      결제가 끝나고 랜딩되는 URL을 지정
      (카카오페이, 페이코, 다날의 경우는 필요없음. PC와 마찬가지로 callback함수로 결과가 떨어짐)
      */
      }, function (rsp) {
      console.log(rsp);
      if (rsp.success) {
      var msg = '결제가 완료되었습니다.';
      msg += '고유ID : ' + rsp.imp_uid;
      msg += '상점 거래ID : ' + rsp.merchant_uid;
      msg += '결제 금액 : ' + rsp.paid_amount;
      msg += '카드 승인번호 : ' + rsp.apply_num;
      location.href='User_cart_del.php?num=<?= $num ?>&mb_num=<?=$mb["mb_num"]?>&mb_id=<?=$mb_id?>';
      } else {
      var msg = '결제에 실패하였습니다.';
      msg += '에러내용 : ' + rsp.error_msg;
      }
      alert(msg);
      });
      });
      </script>
    <?php
      }else{
      ?>
        <script>
          alert("로그인해주세요");
          history.back();
        </script>
    <?php
    }
    ?>

    </body>
    </html>
