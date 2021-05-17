<?php require_once($_SERVER['DOCUMENT_ROOT'].'/modules/module_protect.php'); ?>
<?php $pagename = '일정표'; ?>
<?php
// Load Modules
require_once('modules/error.php');
require_once('modules/notification.php');
require_once('modules/db.php');

// Parameter
$year = Get('year', date('Y'));
$month = Get('month', date('n'));
$year = (int)$year;
$month = (int)$month;

// Functions

// Process
$calendarObj = new YoYangCalendar('localhost', 'php', 'sm3548', 'phpdb', 'mysql');
$datemax = $calendarObj->getMaxDay($year, $month);
$dates = $calendarObj->SelectDateForm($year, $month);
$startDay = $calendarObj->getStartDay($year, $month);

$vdate = 1;
$pdate = 1;
$pagename = '일정표';
?>
