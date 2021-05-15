<?php
// Load Modules
require_once("modules/admin.php");
require_once('modules/cat.php');
$result1 = $dao ->SelectAll();
$pid = Get('p', 1);

?>
<!doctype html>
<html>
	<head>
		<?php require_once('modules/form_head.php'); ?>
		<title></title>
		<style>
			.navbar-inverse{
				background-color:#86b00e;
				border-color:#86b00e;
				width:100%;
			}
			.navbar-inverse .navbar-collapse, .navbar-inverse .navbar-form {
		border-color: #86b00e;
		}
		.navbar-form > div{
			border:none;
		}
		</style>
	</head>
	<body>
		<div id="header">

		</div>
		<div id="content_container">
			<div id="navigation">
			</div>
			<div>
					<nav class="navbar navbar-inverse">
						  <div class="container-fluid">
							<form class="navbar-form navbar-left" action="admin_list.php" method="get">
								<div class="input-group">
									<input id="kk" type="hidden"  name="var" value="<?=$link?>">
									<input id="kk" class="form-control" type="text"  name="s_value" placeholder="Search">
								<div class="input-group-btn">
								<button class="btn btn-default" type="submit">
								 <i class="glyphicon glyphicon-search"></i>
								 </button>
							 </div>
						 </div>
					 </div>
				 </nav>
							</form>
						<form class="" action="admin_listdel.php?var=<?= $link ?>" method="post">
						  <table id="board">
							<thead>
							  <tr id="field">
								<th class="text-center"><input type="checkbox" class="hidden" id="all" value="all"><label for="all"></label></th>
								<th class="text-center">번호</th>
								<th class="text-center">이미지</th>
								<th class="text-center">이름</th>
								<th class="text-center">제조사</th>
								<th class="text-center">제품 정보</th>
								<th class="text-center">등록 날짜</th>
								<th class="text-center">가격</th>
								<th colspan="7">
								  <button type="submit" name="button">삭제</button>
								  <span></span>
								</th>
							  </tr>
							</thead>
							<tbody>
								<?php require_once('modules/page_search.php'); ?>
							  <?php foreach($list as $row) : ?>
								<tr>
									<td class="center"><input type="checkbox" name="id[]" class="hidden" id="<?= $row['id'] ?>" value="<?= $row['id'] ?>"><label for="<?= $row['id'] ?>"></label></td>
									<td class="center"><a href="<?=$url.$row['id'] ?>"><?= $row['id'] ?></td>
									<td class="center"><img src="<?= $dir.$row['file'] ?>" width="64px" height="64px" /></td>
									<td class="center"><?= $row['name'] ?></td>
									<td class="center"><?= $row['manufacturer'] ?></td>
									<td class="center"><?= $row['info'] ?></li>
									<td class="center"><?= $row["date_format(date,'%Y-%m')"] ?></td>
									<td class="center"><?= $row['price'] ?></td>
								</tr>
							  <?php endforeach ?>
							</tbody>
						  </table>
						</form>
						<br/>
						   <div class="center">
						  <?php for($i=$result['start']; $i<=$result['end']; $i++): ?>
							<a class="abtn <?php if($i === (int)$result['current']) echo 'current' ?>" href="?var=<?=$link?>&p=<?= $i ?>&s_value=<?=$s_value?>"><?= $i ?></a>
						  <?php endfor ?>
						  <button type="button" name="button" onclick="location.href='admin_ProductWrite.php'">상품 등록</button>
						</div>
					</div>
		</div>
		<div id="footer">
		</div>
<?php require_once('modules/checkbox.php'); ?>
	</body>
</html>
