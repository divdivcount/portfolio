<?php
// Load Modules
	require_once("modules/admin.php");

?>
<?php
	if(isset($_REQUEST["cpu"]) ? $_REQUEST["cpu"] : '' == "cpu"){
		$product = "cpu";
		$dao = new Cpu();
	}else if(isset($_REQUEST["cases"]) ? $_REQUEST["cases"] : '' == "cases"){
		$product = "cases";
		$dao = new Case_board();
	}else if(isset($_REQUEST["cooler"]) ? $_REQUEST["cooler"] : '' == "cooler"){
		$product = "cooler";
		$dao = new Cooler();
	}else if(isset($_REQUEST["mainboard"]) ? $_REQUEST["mainboard"] : '' == "mainboard"){
		$product = "mainboard";
		$dao = new MainBoard();
	}else if(isset($_REQUEST["memory"]) ? $_REQUEST["memory"] :'' == "memory"){
		$product = "memory";
		$dao = new Memory();
	}else if(isset($_REQUEST["odd"]) ? $_REQUEST["odd"] : '' == "odd"){
		$product = "odd";
		$dao = new Odd();
	}else if(isset($_REQUEST["power"]) ? $_REQUEST["power"] : '' == "power"){
		$product = "power";
		$dao = new Power();
	}else if(isset($_REQUEST["storage"]) ? $_REQUEST["storage"] :''== "storage"){
		$product = "storage";
		$dao = new Storage();
	}else if(isset($_REQUEST["graphicscard"]) ? $_REQUEST["graphicscard"] :'' == "graphicscard"){
		$product = "graphicscard";
		$dao = new GraphicsCard();
	}else{
		?>
				<script>
						alert("모든 항목이 빈칸 없이 입력되어야 합니다.");
						history.back();
				</script>
		<?php
	}
	try{
		if(strcmp($product, "cpu") == 0 or strcmp($product, "cases") == 0 or strcmp($product, "cooler") == 0 or strcmp($product, "mainboard") == 0 or strcmp($product, "mainboard") == 0
		or strcmp($product, "memory") == 0 or strcmp($product, "odd") == 0 or strcmp($product, "power") == 0 or strcmp($product, "storage") == 0 or strcmp($product, "graphicscard") == 0){
			$name = $_REQUEST["name"];
			$manufacturer = $_REQUEST["manufacturer"];
			$info = $_REQUEST["info"];
			$date = $_REQUEST["date"];
			$price = $_REQUEST["price"];

			// require_once('admin_upload.php');
			if($product && $name && $manufacturer && $info && $date && $price){
				// $dao;
				// $dao -> listAdd($product, $name, $manufacturer, $info, $date, $price, $files);
				$dao->Upload($product,'upload_file', 0, ['name'=>$name ,'manufacturer'=>$manufacturer,'info'=>$info,'date'=>$date,'price'=>$price]);
?>
				<script>
					alert("등록되었습니다.");
					location.href = document.referrer;
				</script>
<?php
			}
			else{
?>
				<script>
						alert("모든 항목이 빈칸 없이 입력되어야 합니다.");
						history.back();
				</script>
<?php
			}
	}else{}
}catch(PDOException $e){
		exit($e ->getMessage());
	}
?>
