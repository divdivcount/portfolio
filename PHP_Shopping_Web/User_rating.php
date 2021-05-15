<?php
// Load Modules
require_once('modules/db.php');

//유저페이지에서 3개값 받아옴
$mb_p_num =Get("mb_p_num",null);// empty($_REQUEST["mb_p_num"]) ? "" :  $_REQUEST["mb_p_num"];
$mb = Get("mb",null);//empty($_REQUEST["mb"]) ? "" :  $_REQUEST["mb"];
$mb_rating = Get("mb_rating",null);//empty($_REQUEST["mb_rating"]) ? "" :  $_REQUEST["mb_rating"];

$dao = new Member();
$result = $dao -> Member_Rating();

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
		<table class="table">
			<thead class="text-center">
				<tr>
						<th class="text-center">아이디</th>
						<th class="text-center">등급</th>
						<th class="text-center">내 결제 금액</th>
				</tr>
			</thead>
			<tbody class="text-center">
				<td><?=$mb?></td>
				<td><?=$mb_rating?></td>
				<td><?=$mb_p_num?></td>
			</tbody>
		</table>

		<table class="table text-center">
			<thead>
				<tr>
						<th class="text-center">등급</th>
						<th class="text-center">조건</th>
						<th class="text-center">설명</th>
						<th class="text-center">혜택</th>
				</tr>
			</thead>
		<?php foreach ($result as $row): ?>
				<tbody>
					<td class="text-center"><?=$row["mem_rating_name"]?></td>
					<td><?=$row["mem_rating_condition"]?></td>
					<td><?=$row["mem_rating_description"]?></td>
					<td><?=$row["mem_rating_benefit"]?></td>
				</tbody>

		<?php endforeach; ?>
		</table>
	</body>
</html>
