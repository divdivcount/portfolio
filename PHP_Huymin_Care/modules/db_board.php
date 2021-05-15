<?php
/*
FileName: db_board.php
Modified Date: 20190902
Description: YoYangBoard 클래스
*/
// Load Modules
require_once($_SERVER['DOCUMENT_ROOT'].'/modules/module_protect.php');

// Parameter

// Functions
class YoYangBoard extends YoYangDAO {
	protected $quTable = 'board';
	protected $quTableId = 'idx';
	protected $quTableFname = 'file';
	protected $quTableFrname = 'realfile';


	/*
		DB에 글 쓰기
		## parameter
		$name: 작성자 이름 (관리자만 쓰면 되는데 굳이?)
		$pw: 글 비밀번호
		$title: 글 제목
		$content: 글 본문
		$fileParamName: fparam
		$fileDir: 파일 저장 경로
		## return
		true
		## return error code
		ERR_NORMAL: 정의되지 않은 오류
		ERR_PDOERR: 데이터베이스에 의한 오류
		ERR_FILEERR
		ERR_FILETYPE
		ERR_FILEOVER
	*/
	/*
	글 보기 화면에 표시할 내용들을 불러옵니다.
	## parameter
	$bno: 글 번호
	## return
	$result[i]['idx']: 게시글 번호
	$result[i]['title']: 게시글 이름
	## exceptions
	PDOException
	CommonException
	*/

	public function PasswordVerify($id, $pw = null) {
		if(!$pw) {
			throw new CommonException('비밀번호를 입력하십시오.');
		}
		$this->openDB();
		$query = $this->db->prepare("select pw from $this->quTable where $this->quTableId=:id");
		$query->bindValue(":id", $id, PDO::PARAM_INT);
		$query->execute();
		$fetch = $query->fetch(PDO::FETCH_ASSOC);
		if(!$fetch) {
			throw new CommonException('게시물이 존재하지 않습니다.');
		}
		else if(!password_verify($pw, $fetch['pw'])) {
			throw new CommonException('비밀번호 불일치: '.$bno.'번 글');
		}
		return true;
	}

	public function execHit($id) {
		/*
			조회수를 1 올리는 작업을 수행합니다
			## parameter
			$id: 글 번호
			## return
			true
			## return error code
			ERR_PDOERR
			ERR_NORMAL
		*/
		$this->openDB();
		$query = $this->db->prepare("update $this->quTable set hit=hit+1 where $this->quTableId=:id");
		$query->bindValue(":id", $id);
		$query->execute();
	}
}

// Process
?>
