<?php
/*
FileName: config.php
Modified Date: 20190923
Description: Configuration
*/
// Load Modules
require_once($_SERVER['DOCUMENT_ROOT'].'/modules/module_protect.php');

// Parameter

$DBconfig = [
  'dburl' => 'localhost',
  'dbid' => 'php',
  'dbpw' => 'sm3548',
  'dbtable' => 'phpdb',
  'dbtype' => 'mysql'
];
$Homeid = '';
$HomepwHash = '';
?>
