<?php

// Load Modules
require_once($_SERVER['DOCUMENT_ROOT'].'/modules/module_protect.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/modules/db_dao.php');


// Parameter

// Functions
//Case 제품출력
class Primg extends MetroDAO {

protected $quTable = 'product_img';
protected $quTableId = 'pr_img_id';
protected $quTableFname = 'pr_img';
protected $quTableFdate = 'fdate';
protected $fdir = 'files';




}
?>
