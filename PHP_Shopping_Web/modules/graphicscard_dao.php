    <?php

// Load Modules
require_once('db_dao.php');


// Parameter

// Functions
  //전체 출력 GraphicsCard정보
class GraphicsCard extends ProDAO {
	protected $quTable = 'graphicscard';
	protected $quTableId = 'id';
  protected $quTableFname = 'file';
  protected $fdir = 'files/graphicscard';
   }


?>
