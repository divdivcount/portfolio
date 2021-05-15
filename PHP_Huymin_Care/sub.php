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
				<img src="img/main/main2.jpg" alt="image2" />
				<img src="img/main/main4.jpg" alt="image3" />
				<img src="img/main/main5.jpg" alt="image3" />
				<table class="map">
					<tr>
						<td class="active visible"><h1>유명해지기 위해 110년을 기다렸다. 가능한 한 오래 그 유명세를 즐기고 싶다.</h1>
							<h2>루이스 칼망 - 기네스북 최장수 인물 인물로 등재된 후</h2>
						</td>
						<td><h1>100세까지 살고 싶게 만드는 모든 것들을 포기하면, 100세까지 살 수 있다.</h1>
							<h2>우디 앨런</h2>
						</td>
						<td><h1>나이가 드니까 안 노는게 아니다. 놀지 않기 때문에 나이가 드는 것이다.</h1>
							<h2>조지 버나드 쇼</h2>
						</td>
						<td><h1>나이 드는 게 비극적인 이유는, 우리가 사실은 젊기 때문이다.</h1>
							<h2>오스카 와일드</h2>
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
