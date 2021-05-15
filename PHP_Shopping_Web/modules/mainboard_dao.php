  <?php

// Load Modules
require_once('db_dao.php');


// Parameter

// Functions
class MainBoard extends ProDAO {
			protected $quTable = 'mainboard';
			protected $quTableId = 'id';
      protected $quTableFname = 'file';
      protected $fdir = 'files/mainboard';
}

  ?>
