<?php
// Load Modules
require_once('modules/db.php');
require_once('modules/cat.php');
$result = $dao ->SelectAll();
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
			}
			.navbar-inverse .navbar-collapse, .navbar-inverse .navbar-form {
    border-color: #86b00e;
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
        <?php require_once('modules/page_search.php'); ?>
				<div>
					<nav class="navbar navbar-inverse">
					  <div class="container-fluid">
								<form class="navbar-form" action="User_list.php" method="get">
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
				</div>
				<?php foreach ($list as $row) : ?>
					<ul class="list">
					<li class="list-li check_field"><input type="checkbox" name="id[]" class="hidden" id="<?= $row['id'] ?>" value="<?= $row['id'] ?>"><label for="<?= $row['id'] ?>"></label></li>
					<li class="hidden"><?= $row['id'] ?></li>
					<li class="list-li image_box"><img src="<?= $dir.$row['file'] ?>" width="124px" height="124px" /></li>
					<div class="text_field">
						<li class="list-li name_field"><?= $row['name'] ?></li>
						<li class="list-li info_text"><?= $row['info'] ?></li>
						<li class="list-li date_text">등록일시 :<?= $row["date_format(date,'%Y-%m')"] ?></li>
					</div>
						<li class="vertical"><?= $row['price'] ?>원</li>
						<input type="button" class="button vertical btn btn-primary btn-lg" id="obj" value="담기" onclick="javascript:location.href='User_cart.php?var=<?=$link?>&img=<?= $dir.$row['file'] ?>&id=<?= $row['id'] ?>&price=<?= $row['price'] ?>&name=<?= $row['name'] ?>'"/>
					</ul>
				<?php endforeach ?>
			</div>
			<div class="center">
          <?php for($i=$result['start']; $i<=$result['end']; $i++): ?>
            <a class="abtn <?php if($i === (int)$result['current']) echo 'current' ?>" href="?var=<?=$link?>&p=<?= $i ?>&s_value=<?=$s_value?>"><?= $i ?></a>
          <?php endfor ?>
        </div>
		</div>
		<div id="footer">
			<?php
			 ?>
		</div>
	</body>
</html>
