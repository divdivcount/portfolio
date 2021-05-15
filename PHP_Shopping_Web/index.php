<?php
// Load Modules
	require_once('modules/db.php');
?>
<!doctype html>
<html>
	<head>
		<?php require_once('modules/form_head.php'); ?>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
		<style>
				.slider .indicators .indicator-item {
					background-color: #666666;
					border: 3px solid #ffffff;
					-webkit-box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.16), 0 2px 10px 0 rgba(0, 0, 0, 0.12);
					-moz-box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.16), 0 2px 10px 0 rgba(0, 0, 0, 0.12);
					box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.16), 0 2px 10px 0 rgba(0, 0, 0, 0.12);
				}
				.slider .indicators .indicator-item.active {
					background-color: #ffffff;
				}
				.slider {
					width: 100%;
					margin: 0 auto;
				}
				.slider .indicators {
					bottom: 60px;
					z-index: 100;
				/* text-align: left; */
				}
				.caption{
					margin-top:100px;
				}
		</style>
		<title></title>
	</head>
	<body>
		<div id="content_container">
					<?php
							if(empty($_SESSION['ss_mb_id'])){
								echo "";
							}else{
								$mb_id = $_SESSION['ss_mb_id'];
								$sql = " select * from member where mb_id = TRIM('$mb_id') ";
								$result = mysqli_query($conn, $sql);
								$mb = mysqli_fetch_assoc($result);

								mysqli_close($conn); // 데이터베이스 접속 종료
							}

					?>
					<table>
						<tr>
							<td style="width:200px; height:83px;">
								<a href="index.php"><img src="files/logo/logo.png" width="100%" height="64px;"/></a>
							</td>
								<?php
									 	if(isset($mb['mb_num'])){
											echo "<td style='float:right; margin-top:20px;'>".$mb['mb_name']."님"."&nbsp;<a href='./logout.php'>로그아웃</a>"."&nbsp;<a href='./User_page.php'>마이페이지</a>"."</td>";
										}else {
											echo "<td style='float:right; margin-top:20px;'><a href='./login.php'>login</a></td>";
										}
								 ?>
						</tr>
					</table>
					<?php
					$galleryObj = new Gallery;
					$result = $galleryObj ->SelectGallery();
				 ?>
					<div class="slider">
				     <ul class="slides">
							 <?php if($result) : ?>
							 <?php foreach($result as $row) : ?>
				       <li>
								 <img src="files/gallery/<?= $row['file'] ?>" alt="" width="100%" height="auto">
				         <div class="caption center-align">
				           <h3><?= $row['description'] ?></h3>
				         </div>
				       </li>
							 <?php endforeach ?>
						 <?php else : ?>
							 <li>
								 <img src="files/Noimg/noimg.png" alt="" width="100%" height="auto">
								 <div class="caption center-align">
									 <h3>이미지가 없습니다.</h3>
								 </div>
							 </li>
						 <?php endif ?>
				     </ul>
				  </div>
					<?php require_once('modules/form_navigation.php'); ?>
					<div class="click_box">
							<iframe style="float:left;" frameborder="0"  id="main_frame" src="User_list.php?var=cpu" height="800px" width="80%"></iframe>
					</div>
									<!--세션, 코드번호 담기,
										if (empty($_SESSION["cart"])) {
										    $_SESSION["cart"] = "";
										}
										$_SESSION["cart"] .= "구분코드(테이블이),물품이,수량,가격"

										$cart = explode(',', $_SESSION["cart"]);

										for ($i = 0; $i < count($cart); $i+=4) {
										    if ($cart[$i] == "CPU") {
										        echo $cart[$i + 1]; // 물품코드
										        echo $cart[$i + 2]; // 수량
														echo $cart[$i + 2]; // 수량
														echo $cart[$i + 2]; // 수량
										    }
										}
									-->
		<div id="footer">
		</div>
		<script>
		function changeIframeUrl(url){
			document.getElementById("main_frame").src = url;
		}
		$(document).ready(function(){
		  $('.slider').slider();
		});
		</script>

	</body>
</html>
