  <?php

// Load Modules
require_once('db_dao.php');


// Parameter

// Functions
 //Case 제품출력
  class Case_board extends ProDAO {

	protected $quTable = 'cases';
	protected $quTableId = 'id';
  protected $quTableFname = 'file';
  protected $fdir = 'files/cases';
  }
  ?>
