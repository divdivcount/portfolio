  <?php

// Load Modules
require_once('db_dao.php');


// Parameter

// Functions
  //전체 출력 Power정보
 class Power extends ProDAO {
	protected $quTable = 'power';
	protected $quTableId = 'id';
  protected $quTableFname = 'file';
  protected $fdir = 'files/power';
 }
  ?>
