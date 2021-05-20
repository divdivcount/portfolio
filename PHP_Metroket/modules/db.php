<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'/modules/parameter.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/modules/db_dao.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/modules/mb_dao.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/modules/reply_dao.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/modules/oauth_dao.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/modules/dbconn.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/modules/strequ.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/modules/product_dao.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/modules/mem_del_reasons_dao.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/modules/product_image_dao.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/modules/interest_dao.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/modules/db_gallery.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/modules/module_protect.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/modules/product_history_dao.php');
	class ProLogin extends MetroDAO {
		private $session = false;

		public function SignedIn() {
			$this->Initalization();

			if(isset($_SESSION['ss_mb_id']) == 'admin' && isset($_SESSION['ip'])) {//세션유저, 세션 아이피가 있으면 TRUE

				// var_dump($_SESSION['ip'])."<br>";
				// var_dump($_SERVER['REMOTE_ADDR'])."<br>";
				// var_dump($_SESSION['ip'] != $_SERVER['REMOTE_ADDR'])."<br>";
				// var_dump(!$this->InternalIP())."<br>";
				// var_dump($_SESSION['ip'] != $_SERVER['REMOTE_ADDR'] && !$this->InternalIP())."<br>";
				if($_SESSION['ip'] != $_SERVER['REMOTE_ADDR'] && !$this->InternalIP()) {//세션[ip]와 접속한 ip가 다르 지정한 아이피와 다르면 false
					//세션 탈취?
					// session_unset($_SESSION['ss_mb_id'] == 'admin');
					session_destroy();
					return false;
				}
				return true;
			}
			return false;
		}
		//접속 아이피 지정
		public function InternalIP() {
			if(startsWith($_SERVER['REMOTE_ADDR'], '192.168.') || $_SERVER['REMOTE_ADDR'] === '127.0.0.1' || $_SERVER['REMOTE_ADDR'] === '::1' || $_SERVER['REMOTE_ADDR'] === '121.165.86.230') {//localhost
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
