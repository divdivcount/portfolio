<?php
	require_once('modules/parameter.php');
	require_once('modules/db_consulting.php');
	require_once('modules/db_dao.php');
	require_once('modules/cpu_dao.php');
	require_once('modules/mb_dao.php');
	require_once('modules/mainboard_dao.php');
	require_once('modules/memory_dao.php');
	require_once('modules/power_dao.php');
	require_once('modules/storage_dao.php');
	require_once('modules/cooler_dao.php');
	require_once('modules/odd_dao.php');
	require_once('modules/case_dao.php');
	require_once('modules/graphicscard_dao.php');
	require_once('modules/dbconn.php');
	require_once('modules/db_gallery.php');
	require_once('modules/pay_dao.php');
	require_once('modules/strequ.php');
	class ProLogin extends ProDAO {
		private $session = false;
		private function PasswordVerify($id, $pw) {
			$this->openDB();
			$query = $this->db->prepare("select pw from admin where id=:id");
			$query->bindValue(':id', $id);
			$query->execute();
			$result = $query->fetch(PDO::FETCH_ASSOC);
			$pwhash = $result['pw'];
			// echo "<br>해쉬값".password_verify($pw, $pwhash); 0true , 1false

			if(password_verify($pw, $pwhash)) {
				return true;
			}
			return false;
		}

		public function PasswordChange($old, $new) {
			if($this->SignedIn()) {
				$id = $_SESSION['user'];
				if($this->PasswordVerify($id, $old)) {
					$newhash = password_hash($new, PASSWORD_DEFAULT);
					// 새로 받은 비밀번호를 해쉬값으로 변경
					//아이디를 찾아 pw 값 변경
					$this->openDB();
					$query = $this->db->prepare("update admin set pw=:pw where id=:id");
					$query->bindValue(':id', $id);
					$query->bindValue(':pw', $newhash);
					return $query->execute();
				}
			}
			return false;
		}

		public function SignIn($id, $pw) {
			if($this->SignedIn()) {
				return true;
			}
		if($this->PasswordVerify($id, $pw) && $this->InternalIP()) {
				$_SESSION['user'] = $id;
				$_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];//사이트에 접속한 ip를 세션 아이피에 담음
				return true;
			}
			else {
				return false;
			}
		}

		public function SignedIn() {
			$this->Initalization();
			if(isset($_SESSION['user']) && isset($_SESSION['ip'])) {//세션유저, 세션 아이피가 있으면 TRUE
				if($_SESSION['ip'] != $_SERVER['REMOTE_ADDR'] && !$this->InternalIP()) {//세션[ip]와 접속한 ip가 다르 지정한 아이피와 다르면 false
					//세션 탈취?
					session_destroy();
					return false;
				}
				return true;
			}
			return false;
		}
		//접속 아이피 지정
		private function InternalIP() {
			if(startsWith($_SERVER['REMOTE_ADDR'], '192.168.') || $_SERVER['REMOTE_ADDR'] === '127.0.0.1' || $_SERVER['REMOTE_ADDR'] === '::1') {//localhost
				return true;//startsWith(접속한 ip, 192.168)가 같으면 true
			}
			return false;
		}

		private function Initalization() {
			if(!$this->session) {
				$this->session = true;
			}
		}
	}

	// Process
	header('Content-Type: text/html; charset=utf-8'); // utf-8인코딩
?>
