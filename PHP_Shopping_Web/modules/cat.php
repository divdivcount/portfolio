<?php
// Process
$cat = $_GET['var'];
if($cat == "cpu"){
	$dao = new Cpu();
	$link = "cpu";
	$url = "admin_ProductWrite.php?var=cpu&id=";
	$dir="files/cpu/";
  $product = "cpu";
}
else if($cat == "mainboard"){
	$dao = new MainBoard();
	$link = "mainboard";
	$url = "admin_ProductWrite.php?var=mainboard&id=";
	$dir="files/mainboard/";
  $product = "mainboard";
}else if($cat == "memory"){
	$dao = new Memory();
	$link = "memory";
	$url = "admin_ProductWrite.php?var=memory&id=";
	$dir="files/memory/";
  $product = "memory";
}
else if($cat == "odd"){
	$dao = new Odd();
	$link = "odd";
	$url = "admin_ProductWrite.php?var=odd&id=";
	$dir="files/odd/";
  $product = "odd";
}
else if($cat == "power"){
	$dao = new Power();
	$link = "power";
	$url = "admin_ProductWrite.php?var=power&id=";
	$dir="files/power/";
  $product = "power";
}
else if($cat == "graphicscard"){
	$dao = new GraphicsCard();
	$link = "graphicscard";
	$url = "admin_ProductWrite.php?var=graphicscard&id=";
	$dir="files/graphicscard/";
  $product = "graphicscard";
}
else if($cat == "cooler"){
	$dao = new Cooler();
	$link = "cooler";
	$url = "admin_ProductWrite.php?var=cooler&id=";
	$dir="files/cooler/";
  $product = "cooler";
}
else if($cat == "storage"){
	$dao = new Storage();
	$link = "storage";
	$url = "admin_ProductWrite.php?var=storage&id=";
	$dir="files/storage/";
  $product = "storage";
}else if($cat == "case"){
	$dao = new Case_board();
	$link = "case";
	$url = "admin_ProductWrite.php?var=case&id=";
	$dir="files/cases/";
  $product = "cases";
}
?>
