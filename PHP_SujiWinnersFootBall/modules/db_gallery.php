<?php
/*
FileName: db_gallery.php
Modified Date: 20190902
Description: YoYangGallery 클래스
*/
// Load Modules
require_once($_SERVER['DOCUMENT_ROOT'].'/modules/module_protect.php');

// Parameter

// Functions
class YoYangGallery extends YoYangDAO {
	protected $quTable = 'gallery';
	protected $quTableId = 'id';
	protected $quTableFname = 'fname';
	protected $quTableFdate = 'fdate';
	protected $fdir = 'img/gallery';
}

// Process

?>
