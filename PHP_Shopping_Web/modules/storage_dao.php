  <?php

// Load Modules
require_once('db_dao.php');


// Parameter

// Functions
 //전체 출력 Storage정보
 class Storage extends ProDAO {
	protected $quTable = 'storage';
	protected $quTableId = 'id';
  protected $quTableFname = 'file';
  protected $fdir = 'files/storage';

 }
  ?>
