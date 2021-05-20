<?php
function Get($param, $not) {
	return (isset($_GET[$param]) && !empty($_GET[$param]))?$_GET[$param]:$not;
}

function Post($param, $not) {
	return (isset($_POST[$param]) && !empty($_POST[$param]))?$_POST[$param]:$not;
}
?>
