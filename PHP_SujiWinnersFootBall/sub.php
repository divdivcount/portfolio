<?php require_once('modules/contents.php'); ?>
<!doctype html>
<html>
	<head>
		<?php require_once('modules/form_head.php'); ?>
		<title></title>
	</head>
	<body>
		<?php require_once('modules/form_navigation.php'); ?>
		<?php if((int)$page == 0) : ?>
			<div class="pageimg">
				<img class="active" src="img/main/main1.jpg" alt="image1" />
				<img src="img/main/main2.png" alt="image2" />
				<img src="img/main/main4.jpeg" alt="image3" />
				<img src="img/main/main5.jpg" alt="image3" />
				<table class="map">
					<tr>
						<td class="active visible"><h1>모두가 행복해지는 이곳 수지 위너스 풋볼아카데미 입니다.</h1>
							<h2></h2>
						</td>
						<td><h1>아이들을 위해 최선을 다하겠습니다.</h1>
							<h2></h2>
						</td>
						<td><h1>기본기부터 전문기술까지 하나 놓치지 않고 가르치겠습니다.</h1>						
						</td>
						<td><h1>오늘도 좋은 하루가 되면 좋겠습니다.</h1>
						</td>
					</tr>
				</table>
			</div>
			
		<?php else : ?>
			<div class="pageimg">
				<img class="active" src="img/menu.png">
				<table class="map">
					<tr>
						<td class="active visible"><h1><?= $pagename ?></h1></td>
					</tr>
				</table>
			</div>
		<?php endif ?>
		<?php require_once('modules/content/'.$page.'.php'); ?>
		<?php require_once('modules/form_footer.php'); ?>
	</body>
</html>
