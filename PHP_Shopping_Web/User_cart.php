<?php
require_once('modules/notification.php');
session_start();
$var =$_REQUEST["var"];
$id = $_REQUEST["id"];
$price = $_REQUEST["price"];
$name = $_REQUEST["name"];
$img = $_REQUEST["img"];
echo $var;
// unset($_SESSION["cart"]);
// if (empty($_SESSION["cart"])) {
//     $_SESSION["cart"] = array();
// }
// $_SESSION["cart"]["cpu"] = 3;
// if (empty($_SESSION["cart"])) {1
//     $_SESSION["cart"] = "";
// }
// $item_array_id = array_column($_SESSION["cart"],"item_id");
// if(!in_array($id, $item_array_id){
//   $_SESSION["cart"] .= "$var,$id,$price,$name,";
// }
// $_SESSION["cart"] .= "$var,$id,$price,$name,";2
if (isset($_SESSION["cart"][$var][$id])){
    $_SESSION["cart"][$var][$id]["qty"]++;
} else {
    $_SESSION["cart"][$var][$id] = array();
    $_SESSION["cart"][$var][$id]["img"] = $img;
    $_SESSION["cart"][$var][$id]["price"] = $price;
    $_SESSION["cart"][$var][$id]["name"] = $name;
    $_SESSION["cart"][$var][$id]["qty"] = 1;
}
// unset($_SESSION["cart"]);
// header("Location:User_list.php?var=$var");
userGoNow("User_list.php?var=$var");
?>
