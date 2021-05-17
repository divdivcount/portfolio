<?php
/*
FileName: db_calendar.php
Modified Date: 20190909
Description: YoYangCalendar 클래스
*/
// Load Modules
require_once($_SERVER['DOCUMENT_ROOT'].'/modules/module_protect.php');

// Parameter

// Functions
class YoYangCalendar extends YoYangDAO {
	protected $quTable = 'calendar';
	protected $quTableId = 'id';

	public function ModifyDate($year, $month, $day, $datArray) {
		$dfield = '';
		$first = true;
		foreach($datArray as $key => $val) {
			$dfield = ($first)?($dfield.$key.'=:'.$key):($dfield.','.$key.'=:'.$key);
			$first = false;
		}

		$this->openDB();
		$query = $this->db->prepare("update $this->quTable set $dfield where dt=:dt");
		$query->bindValue(':dt', "$year-$month-$day");
		foreach($datArray as $key => $val) {
			if(is_string($val)) {
				$query->bindValue(":$key", $val);
			}
			else if(is_int($val)) {
				$query->bindValue(":$key", $val, PDO::PARAM_INT);
			}
			else {
				$query->bindValue(":$key", $val);
			}
		}
		$query->execute();
	}

	public function SelectDateForm($year, $month) {
		$this->openDB();
		$query = $this->db->prepare("select day(dt), part1, part2, part3 from $this->quTable where year(dt)=:year and month(dt)=:month");
		$query->bindValue(':year', (int)$year, PDO::PARAM_INT);
		$query->bindValue(':month', (int)$month, PDO::PARAM_INT);
		$query->execute();
		$fetch = $query->fetchAll(PDO::FETCH_ASSOC);
		if(!$fetch) {
			return null;
		}
		$arr = [];
		foreach ($fetch as $row) {
			$arr[$row['day(dt)']] = ['part1' => $row['part1'], 'part2' => $row['part2'], 'part3' => $row['part3']];
		}
		return $arr;
	}


	public function SelectDate($select = '*', $year = null, $month = null, $day = null) {
		$this->openDB();
		$first = false;
		$yearok = (is_numeric($year))?'year(dt) = :year':null;
		$monthok = (is_numeric($month))?'month(dt) = :month':null;
		$dayok = (is_numeric($day))?'month(dt) = :day':null;
		if($yearok) {
			if($first) {
				$where = $where.' and '.$yearok;
			}
			else {
				$where = $yearok;
				$first = true;
			}
		}
		if($monthok) {
			if($first) {
				$where = $where.' and '.$monthok;
			}
			else {
				$where = $monthok;
				$first = true;
			}
		}
		if($dayok) {
			if($first) {
				$where = $where.' and '.$dayok;
			}
			else {
				$where = $dayok;
				$first = true;
			}
		}
		$query = $this->db->prepare("select $select from $this->quTable where $where");
		if($yearok) {
			$query->bindValue(':year', (int)$year, PDO::PARAM_INT);
		}
		if($monthok) {
			$query->bindValue(':month', (int)$month, PDO::PARAM_INT);
		}
		if($dayok) {
			$query->bindValue(':day', (int)$day, PDO::PARAM_INT);
		}
		$query->execute();
		$fetch = $query->fetchAll(PDO::FETCH_ASSOC);
		if($fetch) {
			foreach ($fetch as $row) {
				$row['dt'];
			}
		}
		return null;
		return ($fetch)?$fetch:null;
	}

	public function getMaxDay($year, $month) {
	  $yun = false;
	  if(($year % 4 == 0) && ($year % 100 != 0) || ($year % 400 == 0)) {
	    $yun = true;
	  }
	  switch($month) {
	    case 2:
	    if($yun) return 29;
	    else return 28;
	    case 1:
	    case 3:
	    case 5:
	    case 7:
	    case 8:
	    case 10:
	    case 12:
	    return 31;
	    case 4:
	    case 6:
	    case 9:
	    case 11:
	    return 30;
	    default:
	  }
	  return null;
	}

	public function getStartDay($year, $month) {
		$y1 = floor(((int)$year)/100);
		$y2 = ((int)$year)%100;
		$m = (int)$month;
		$d = 1;
		if($m == 2) {
			$y2--;
			$m += 12;
		}

		$p1 = 1;
		$p2 = floor((13*($m+1))/5);
		$p3 = $y2;
		$p4 = floor($y2/4);
		$p5 = floor($y1/4);
		$p6 = 2 * $y1;
		$r = ($p1 + $p2 + $p3 + $p4 + $p5 - $p6)%7;
		/*
		if($m == 2) {
			$md = $this->getMaxDay($year, $month);
			if($md == 28) {
				$r = $r + 2;
			}
			else {
				$r++;
			}
		}
		*/
		/*
		if($r<0) return $r+8;
		if($r==0) return 7;
		if($r>7) {

		}*/
		//$r = (( $d + floor(13*($m+1)/5) + $y + floor($y2/4) - $y1 + $y2 )%7)+1;
		return ($r<=0)?(($r==0)?7:$r+8):$r;//($r!=0)?$r:7;
	}
}

// Process

?>
