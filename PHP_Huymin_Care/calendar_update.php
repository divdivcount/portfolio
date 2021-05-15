<?php
/*
FileName: calendar_update.php
Modified Date: 20190909
Description: 일정표 적용 및 수정
*/
// Load Modules
require_once("modules/error.php");
require_once("modules/notification.php");
require_once("modules/db.php");
require_once('modules/admin.php');

// Parameter
$year = Get('year', null);
$month = Get('month', null);
$part1 = Post('part1', null);
$part2 = Post('part2', null);
$part3 = Post('part3', null);

// Functions

// Process
try {
  if(!($year && $month && $part1 && $part2 && $part3)) {
    UserGoto('잘못된 인수.', '');
  }

  $calendarObj = new YoYangCalendar($DBconfig['dburl'], $DBconfig['dbid'], $DBconfig['dbpw'], $DBconfig['dbtable'], $DBconfig['dbtype']);
  $year = (int)$year;
  $month = (int)$month;
  $datemax = $calendarObj->getMaxDay($year, $month);
  if(count($part1) != $datemax ) {
    if(count($part1) != count($part2)) {
      if(count($part2) != count($part3)) {
        UserGoto('잘못된 인수.', '');
      }
    }
  }

  $dates = $calendarObj->SelectDateForm($year, $month);
  for($i=0; $i<$datemax; $i++) {
    $day = $i+1;
    if(isset($dates["$day"])) {
      $calendarObj->ModifyDate($year, $month, $day, ['part1' => $part1[$i], 'part2' => $part2[$i], 'part3' => $part3[$i]]);
    }
    else {
      $calendarObj->Upload(null, 0, ['dt' => "$year-$month-$day", 'part1' => $part1[$i], 'part2' => $part2[$i], 'part3' => $part3[$i]]);
    }
  }
} catch (Exception $e) {
  echo $e->getMessage();
  exit();
}
userGoNow('/calendar_list.php');
?>
