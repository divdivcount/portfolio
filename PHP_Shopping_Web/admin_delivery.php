<?php
// Load Modules
require_once("modules/admin.php");
// $mb_id = $_SESSION['ss_mb_id'];
// $sql = " select * from member where mb_id = TRIM('$mb_id') ";
// $result = mysqli_query($conn, $sql);
// $mb = mysqli_fetch_assoc($result);
// mysqli_close($conn); // 데이터베이스 접속 종료

$link = "admin_delivery";
$dao = new Pay_history();
$start_s_value = empty($_REQUEST["start_s_value"]) ? "" : $_REQUEST["start_s_value"];
$s_value = empty($_REQUEST["s_value"]) ? "" : $_REQUEST["s_value"];
$result = $dao ->SelectHistory($s_value, $start_s_value);
// echo $result["mb_num"];
$pid = Get('p', 1);

?>

<!doctype html>
<html>
	<head>
		<?php require_once('modules/form_head.php'); ?>
		<title></title>
    <style>
    .table {
      border-collapse: collapse;
      border-top: 3px solid #168;
      width:100%;
      text-align: center;
    }
    .table th {
      color: #168;
      background: #f0f6f9;
      text-align: center;
    }
    .table th, .table td {
      padding: 10px;
      border: 1px solid #ddd;
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
    #mb_imp3{text-align:center; border:none; margin: 0; padding: 0; font-size:16px;}
      </style>
	</head>
	<body>
		<div id="header">

		</div>
		<div id="content_container">
			<div id="navigation">

			</div>
			<div>
      		<div>
      			<form action="admin_delivery.php" method="get">
      				<input id="kk" type="hidden"  name="var" value="<?=$link?>">
              <input id="kk" type="month" name="start_s_value" value=""><span>~</span>
      				<input id="kk" type="month" id="currnetMonth" name="s_value" value="">
      				<input type="submit" value="검색">
      		  </form>
      		</div>
          <div>
            <!-- 제이쿼리로 두번 클릭시 데이터 값 가져오기 -->
						<?php
						// $request_body = file_get_contents('php://input');
						// $info = json_decode(stripcslashes($request_body), true);
						//  print_r( $info["mb_num"]);

						$mb_p_num = Post("mb_p_num",null);//empty($_POST["mb_p_num"]) ? "" : $_POST["mb_p_num"];
						echo $mb_p_num;
						 ?>
						 <div class="col-lg-12" id="mb_imp3" ></div>
						<div class="col-lg-12" id="mb_imp2" ></div>
          </div>
        <?php $priv_order_id = 0; ?>
    				<?php foreach ($result as $row) : ?>
              <?php
                    if ($priv_order_id != $row["order_id"]) {
                    		if ($priv_order_id != 0) {
                    			echo "이 주문 건의 총액: ", $priv_total."<br>";
                    		}
                    		echo "새 주문 건 시작"."\t<span class=''>구매 일시:".$row["date_format(pr_now,'%Y-%m')"]."</span>"."<br>";
                    	}
                        $priv_order_id = $row["order_id"];
                        $priv_total = $row["pr_num"];

                        // echo $row["pr_num"];
                      ?>
									<table id="mb_imp" width="100%" class="table table-bordered table-hover text-center">
										<thead>
											<tr>
												<th>회원 번호</th>
												<th>주문 번호</th>
												<th>제품 번호</th>
												<th>물품 아이디</th>
												<th>물품 이름</th>
												<th>주문 수량</th>
												<th>구매 가격</th>
												<th>구매 일시</th>
												<th>배송 현황</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td><?= $row["mb_num"] ?></td>
												<td><?= $row['order_id'] ?></td>
												<td><?= $row['id_key'] ?></td>
												<td><?= $row['pu_id'] ?></td>
												<td><?= $row['pr_name'] ?></td>
												<td><?= $row['pr_qty'] ?></td>
												<td><?= $row['pa'] ?></td>
												<td><?= $row["date_format(pr_now,'%Y-%m')"] ?></td>
												<td><?= $row["pu_besong"] ?></td>
											</tr>
										</tbody>
									</table>
                    <!-- <ul class="list">
          					<li class="">주문 번호 :<?//= $row['order_id'] ?></li>
                    <li class="">물품 아이디 : <?//= $row['pu_id'] ?></li>
          					<li class="list-li image_box"><img src="<?//= $row['pr_img'] ?>" width="124px" height="124px" /></li>
          					<div class="text_field">
          						<li class="list-li name_field"><?//=$row['pr_name'] ?></li>
          						<li class="list-li info_text">주문수량 :<?//= $row['pr_qty'] ?></li>

          					</div>
          						<li class="vertical"><?//= $row['pa'] ?>원</li>
          					</ul> -->
            <?php endforeach; ?>
            <?php
            if(empty($priv_total)){
              echo "";
            }else{
              echo "이 주문 건의 총액: ", $priv_total."<br>";
            }
            ?>

			</div>
		</div>
		<div id="footer">
			<?php
			 ?>
		</div>
    <div class="row">
</div>
    <script>

    // 테이블의 Row 클릭시 값 가져오기
		$("#mb_imp tr").click(function(){

			var str = "";
			var tdArr = new Array();	// 배열 선언

			// 현재 클릭된 Row(<tr>)
			var tr = $(this);
			var td = tr.children("td");

			// tr.text()는 클릭된 Row 즉 tr에 있는 모든 값을 가져온다.
			// console.log("클릭한 Row의 모든 데이터 : "+tr.text());

			// 반복문을 이용해서 배열에 값을 담아 사용할 수 도 있다.
			td.each(function(i){
				tdArr.push(td.eq(i).text());
			});

			console.log("배열에 담긴 값 : "+tdArr);

			// td.eq(index)를 통해 값을 가져올 수도 있다.
			var mb_num = td.eq(0).text();
			var order_id = td.eq(1).text();
			var id_key = td.eq(2).text();
			var pu_id = td.eq(3).text();
			var pr_name = td.eq(4).text();
			var pr_qty = td.eq(5).text();
			var pa = td.eq(6).text();
			var date = td.eq(7).text();
			var be = td.eq(8).text();

			// str +=	"<table class='table'><th>회원 번호</th><th>주문 번호</th><th>물품 번호</th><th>물품 이름</th><th>주문 수량</th><th>구매 가격</th><th>구매 일시</th><tr><td><font color='red'>" + mb_num + "</font></td>" +
			// 		"<td><font color='red'>" + order_id + "</font></td>" +
			// 		"<td><font color='red'>" + pu_id + "</font></td>" +
			// 		"<td><font color='red'>" + pr_name + "</font></td>" +
			// 		"<td><font color='red'>" + pr_qty + "</font></td>" +
			// 		"<td><font color='red'>" + pa + "</font></td>" +
			// 		"<td><font color='red'>" + date + "</font></td></tr></table>"
			// $("#ex1_Result1").html(" * 클릭한 Row의 모든 데이터 = " + tr.text());
			$("#mb_imp2").html(str);
			
			$.ajax({
				url: 'admin_delivery_ajax.php',
				type:'post',
				data :{ mb_p_num: mb_num, order_p_id: order_id, pu_p_id : pu_id, p_id_key : id_key ,pr_p_name : pr_name, pr_p_qty : pr_qty, p_pa : pa, p_date : date, p_be : be},
				success :function(data){
					$('#mb_imp3').html(data);
				},
				error: function(err) {
						alert();
				}
			});
			// $.post(
			//  "admin_delivery_ajax.php",//
			//  { mb_p_num: mb_num, order_p_id: order_id, pu_p_id : pu_id, p_id_key : id_key ,pr_p_name : pr_name, pr_p_qty : pr_qty, p_pa : pa, p_date : date, p_be : be},
			//  function(data){
			// 	 $('#mb_imp3').html(data);
			//  }
		 // );
		});

</script>
	</body>
</html>
