<!-- cookie까지 자바스크립트 -->
<?php
require_once('modules/notification.php');
$var = $_REQUEST["var"];
$id = $_REQUEST["id"];
$qty = $_REQUEST["qty"];

echo $var,$id,$qty;
session_start();
$_SESSION["cart"][$var][$id]["qty"] = $qty;
// header("Location:User_basket.php?");
userGoNow("User_basket.php?");
?>
