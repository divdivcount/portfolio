<?php

// Load Modules
require_once('db_dao.php');


// Parameter

// Functions

	class Member extends ProDAO {
			protected $quTable = 'member';
			protected $quTableId = 'mb_num';

			public function Member_Delete($mb_num) {
			try{
				// 회원 탈퇴
				$this->openDB();
				$sql = "delete from member where mb_num=$mb_num";
				$query = $this->db->prepare($sql);
				$query = $this->db->prepare($sql);
				$query->execute();
				?>
				<script>
					alert("아이디가 삭제되었습니다.");
					window.top.location.href = "../ky_project/index.php";
				</script>
				<?php
				}catch(PDOException $e){
				exit($e ->getMessage());
				}
			}

			public function Member_Search($mb_num, $mb_id=null) {
				// 회원 번호 찾기 User_page 회원번호 찾는데 사용합니다.
				$this->openDB();
				if($mb_id){
					$query = $this->db->prepare("select * from member where mb_id like '$mb_id'");
				}else{
					$query = $this->db->prepare("select * from paygo where mb_num like $mb_num");
				}
				$query->execute();
				$fetch = $query->fetchAll(PDO::FETCH_ASSOC);
				if($fetch){
					return $fetch;
				}
				else return null;
			}

			// public function Member_Select($mb_id) {
			// 	// 회원 정보 1명 찾기
			// 	$this->openDB();
			// 	$query = $this->db->prepare("select * from member where mb_id like '$mb_id'");
			// 	$query->execute();
			// 	$fetch = $query->fetchAll(PDO::FETCH_ASSOC);
			// 	if($fetch){
			// 		return $fetch;
			// 	}
			// 	else return null;
			// }

			// public function Member_Join($mb_id, $mb_password, $mb_name, $mb_email, $mb_gender, $mb_datetime) {
			// 	// 회원 번호 찾기
			// 	$this->openDB();
			// 	$query = $this->db->prepare("");
			// 	$query->execute();
			// }

			public function Member_Rating() {
				// 회원 등급 출력
				$this->openDB();
				$query = $this->db->prepare("select * from member_rating");
				$query->execute();
				$fetch = $query->fetchAll(PDO::FETCH_ASSOC);
				if($fetch){
					return $fetch;
				}
				else return null;
			}
}
?>
