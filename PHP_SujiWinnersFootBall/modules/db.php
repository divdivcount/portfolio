<?php
/*
FileName: db.php
Modified Date: 20190906
Description: YoYang DB 모듈 정의
*/
// Load Modules
require_once($_SERVER['DOCUMENT_ROOT'].'/modules/module_protect.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/modules/config.php');

// Parameter

// Functions
require_once($_SERVER['DOCUMENT_ROOT'].'/modules/json.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/modules/parameter.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/modules/db_dao.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/modules/db_board.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/modules/db_video_board.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/modules/db_gallery.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/modules/db_consulting.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/modules/db_calendar.php');

class CommonException extends Exception {}

class YoYangLogin extends YoYangDAO {

	private $session = false;
	private function PasswordVerify($id, $pw) {
		$this->openDB();
		$query = $this->db->prepare("select pw from admin where id=:id");
		$query->bindValue(':id', $id);
		$query->execute();
		$result = $query->fetch(PDO::FETCH_ASSOC);
		$pwhash = $result['pw'];
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
			$_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
			return true;
		}
		else {
			return false;
		}
	}

	public function SignedIn() {
		$this->Initalization();
	  if(isset($_SESSION['user']) && isset($_SESSION['ip'])) {
	    if($_SESSION['ip'] != $_SERVER['REMOTE_ADDR'] && !$this->InternalIP()) {
	      //세션 탈취?
	      session_destroy();
				return false;
	    }
	    return true;
	  }
	  return false;
	}

	private function InternalIP() {
	  if(startsWith($_SERVER['REMOTE_ADDR'], '172.30.') || $_SERVER['REMOTE_ADDR'] === '127.0.0.1' || $_SERVER['REMOTE_ADDR'] === '::1') {
	    return true;
	  }
	  return false;
	}

	private function Initalization() {
		if(!$this->session) {
			session_start();
			$this->session = true;
		}
	}
}

// Process
header('Content-Type: text/html; charset=utf-8'); // utf-8인코딩

// mysqli 방식 (PDO로 교체 예정)
/*
$db = new mysqli("localhost","php","sm3548","phpdb");
$db->set_charset("utf8");

function mq($sql)
{
	global $db;
	return $db->query($sql);
}
*/
?>
