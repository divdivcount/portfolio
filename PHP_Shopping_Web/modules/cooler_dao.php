 <?php

// Load Modules
require_once('db_dao.php');


// Parameter

// Functions
//Cooler 출력
 class Cooler extends ProDAO {
	protected $quTable = 'cooler';
	protected $quTableId = 'id';
  protected $quTableFname = 'file';
  protected $fdir = 'files/cooler';
 }
  ?>
