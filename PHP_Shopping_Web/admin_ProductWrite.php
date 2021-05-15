<?php
// Load Modules
require_once("modules/admin.php");


if(empty($_POST['product'])){
	Post("product","");
}else{
	Post("product",null);
}
$id = Get('id', 0);
?>

<!doctype html>
<html>
	<head>
		<title></title>
	</head>
	<style>
	select {

	    -webkit-appearance: none;  /* 네이티브 외형 감추기 */
	    -moz-appearance: none;
	    appearance: none;
	    background: url('https://farm1.staticflickr.com/379/19928272501_4ef877c265_t.jpg') no-repeat 95% 50%;  /* 화살표 모양의 이미지 */
	}

	/* IE 10, 11의 네이티브 화살표 숨기기 */
	select::-ms-expand {
	    display: none;
	}
	select {

    width: 200px; /* 너비설정 */
    padding: .5em .5em; /* 여백으로 높이 설정 */
    font-family: inherit;  /* 폰트 상속 */
    background: url('https://farm1.staticflickr.com/379/19928272501_4ef877c265_t.jpg') no-repeat 95% 50%; /* 네이티브 화살표를 커스텀 화살표로 대체 */
    border: 1px solid #999;
    border-radius: 0px; /* iOS 둥근모서리 제거 */
    -webkit-appearance: none; /* 네이티브 외형 감추기 */
    -moz-appearance: none;
    appearance: none;
}

	</style>
	<?php require_once('modules/form_head.php'); ?>
	<body>
		<?php
			try {
				?>
		<?php if((int)$id > 0): ?>
			<?php require_once('modules/cat.php'); ?>
			<?php $row = $dao ->SelectId($id);?>
		<form class="" action="admin_listmodify.php?var=<?= $link ?>&id=<?=$row["id"]?>" method="post" enctype="multipart/form-data">
			<div style="border:none" class="form-group">
				<label for="prod">제품</label>
				<input id="prod" class="form-control" type="text"  value="<?=$link?>" readonly/>
			</div style="border:none">
			<div style="border:none" class="form-group">
				<label for="name">제품 이름</label>
				<input id="name" class="form-control" value="<?= $row["name"]?>" type="text" size=10 name="name">
			</div>
			<div  style="border:none" class="form-group">
				<label for="com">제조사</label>
				<input id="com" class="form-control" value="<?= $row["manufacturer"]?>" type="text" size=10  name="manufacturer">
			</div>
			<div style="border:none" class="form-group">
				<label for="info">정보</label>
				<input id="info" class="form-control"  value="<?= $row["info"]?>" type="text" size=10  name="info">
			</div>
			<div style="border:none" class="form-group">
				<label for="date">제조일자</label>
				<input id="date" class="form-control" value="<?= $row["date"]?>"  type="date" size=60 name="date">
			</div>
			<div style="border:none" class="form-group">
				<label for="pay">가격</label>
				<input id="pay" class="form-control" value="<?= $row["price"]?>" type="text" size=60 name="price">
			</div>
			<div style="border:none" class="form-group">
				<label for="file"><div><b>현재 등록 사진</b><br/><img src="<?=$dir.$row['file']?>" width="128px" height="128px"><br/><b>파일명 : </b><?= $row['file']?></div></label>
				<input id="file" class="form-control" type="file" name="upload_file[]">
			</div>
					<input type="submit" class="btn btn-success" type="submit" value="수정">
		</from>
		<?php else :?>
		<form  action="admin_ProductWrite.php" method="post">
			<select id="select_box" name="product">
				 <option value="cpu" selected="selected">Cpu</option>
				 <option value="cooler">Cooler</option>
				 <option value="mainboard">Mainboard</option>
				 <option value="memory">Memory</option>
				 <option value="graphicscard">GraphicsCard</option>
				 <option value="storage">Storage</option>
				 <option value="cases">Case</option>
				 <option value="power">Power</option>
				 <option value="odd">Odd</option>
				 <input class="btn btn-success" type="submit" value="선택">
			</select>
		</form>
			<?php
			//error_reporting(0);
			?>
			<form  method="post" action='admin_ProductInsert.php' enctype="multipart/form-data">
			<?php
				if(Post("product",null) == "cpu"){
					$name = "cpu";
				}else if(Post("product",null) == "mainboard"){
					$name = "mainboard";
				} else if(Post("product",null) == "cooler"){
					$name = "cooler";
				} else if(Post("product",null) == "memory"){
					$name = "memory";
				} else if(Post("product",null) == "graphicscard"){
					$name = "graphicscard";
				} else if(Post("product",null) == "storage"){
					$name = "storage";
				}else if(Post("product",null) == "cases"){
					$name = "cases";
				}else if(Post("product",null) == "power"){
					$name = "power";
				}else if(Post("product",null) == "odd"){
					$name = "odd";
				}else{
					$name="";
				}
			?>
			<div style="border:none" class="form-group">
				<label for="prod">제품</label>
			 	<input id="prod" class="form-control" type="text" value="<?=$name?>" name="<?=$name?>" readonly/>
			</div style="border:none">
			<div style="border:none" class="form-group">
				<label for="name">제품 이름</label>
				<input id="name" class="form-control" type="text" size=10 name="name">
			</div>
			<div  style="border:none" class="form-group">
				<label for="com">제조사</label>
				<input id="com" class="form-control" type="text" size=10  name="manufacturer">
			</div>
			<div style="border:none" class="form-group">
				<label for="info">정보</label>
				<input id="info" class="form-control" type="text" size=10  name="info">
			</div>
			<div style="border:none" class="form-group">
				<label for="date">제조일자</label>
				<input id="date" class="form-control" type="date" size=60 name="date">
			</div>
			<div style="border:none" class="form-group">
				<label for="pay">가격</label>
				<input id="pay" class="form-control" type="text" size=60 name="price">
			</div>
			<div style="border:none" class="form-group">
				<label for="file">사진</label>
				<input id="file" class="form-control" type="file" name="upload_file[]">
			</div>
		<input type="submit" class="btn btn-success btn-lg" value="등록">
		<input type="reset" class="btn btn-sm btn-danger" value="다시쓰기">
		</form>
		<?php endif ?>
		<?php
	}
	catch (PDOException $e) {
		echo '데이터베이스가 작동하지 않음.';
	}
	catch (Exception $e) {
		echo $e->getMessage();
	}
	?>
	</body>
</html>
