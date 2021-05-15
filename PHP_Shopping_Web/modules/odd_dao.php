<?php

// Load Modules
require_once('db_dao.php');


// Parameter

// Functions
 //전체 출력 Odd
  class Odd extends ProDAO {
	protected $quTable = 'odd';
	protected $quTableId = 'id';
  protected $quTableFname = 'file';
  protected $fdir = 'files/odd';
  }
  ?>
