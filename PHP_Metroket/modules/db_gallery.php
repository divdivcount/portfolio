<?php
// Load Modules
// Parameter
require_once($_SERVER['DOCUMENT_ROOT'].'/modules/module_protect.php');
// Functions
class Gallery extends MetroDAO {
	protected $quTable = 'gallery';
	protected $quTableId = 'id';
	protected $quTableFname = 'fname';
	protected $quTableFdate = 'fdate';
	protected $fdir = 'files/gallery';


// Process

public function Gallery_Select() {
	// 회원 번호 찾기 User_page 회원번호 찾는데 사용합니다.
	$this->openDB();
	$query = $this->db->prepare("select description ,fname from gallery order by id desc limit 0, 4");
	$query->execute();
	$fetch = $query->fetchAll(PDO::FETCH_ASSOC);
	// var_dump($fetch);
	if($fetch){
		return $fetch;
	}
	else return null;
}

public function Gallery_Modify($id, $datArray) {

	$dfield = '';
	$first = true;
	foreach($datArray as $key => $val) {
		$dfield = ($first)?($dfield.$key.'=:'.$key):($dfield.','.$key.'=:'.$key);
		$first = false;
	}

	$this->openDB();
	$query = $this->db->prepare("update $this->quTable set $dfield where $this->quTableId=:id");
	$query->bindValue(':id', $id);
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

public function Gallery_Delete($id) {

	// 파일 삭제를 위해 파일명 가져옴
	$this->openDB();
	// 파일 삭제
	if($this->quTableFname != '') {
		$query = $this->db->prepare("select $this->quTableFname from $this->quTable where $this->quTableId=:id");
		$query->bindValue(":id", $id);
		$query->execute();
		$fetch = $query->fetch(PDO::FETCH_ASSOC);
		$fname = $fetch['fname'];
		var_dump($fname);
		if($fname != '') {
			var_dump(file_exists('files/gallery/'.$fname));
			if(file_exists('files/gallery/'.$fname)) {
				unlink('files/gallery/'.$fname);
			}
		}
	}
	// 게시글 삭제
	$query = $this->db->prepare("delete from $this->quTable where $this->quTableId=:id");
	$query->bindValue(":id", $id);
	$query->execute();
}
}
?>
