<?php
// Load Modules
require_once('db_dao.php');

// Parameter

// Functions
class Consulting extends ProDAO {
	protected $quTable = 'consulting';
	protected $quTableId = 'id';

	public function Consulting_Member_Search($mb_num) {
		//회원의 상담 신청 했을 시 카운트
		$this->openDB();
		$query = $this->db->prepare("select count(`statok`) from `consulting` where statok = 0 and mb_num = $mb_num");
		$query->execute();
		$fetch = $query->fetchAll(PDO::FETCH_ASSOC);
		if($fetch){
			return $fetch;
		}
		else return null;
	}



}

// Process

?>
