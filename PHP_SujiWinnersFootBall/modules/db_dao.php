<?php
/*
FileName: db_dao.php
Modified Date: 20190906
Description: YoYangDAO 클래스
*/
// Load Modules
require_once($_SERVER['DOCUMENT_ROOT'].'/modules/module_protect.php');

// Parameter

// Functions
class YoYangDAO {
	// Field
	protected $db = null;
	protected $dburl = 'localhost';
	protected $dbid = 'php';
	protected $dbpw = 'sm3548';
	protected $dbtable = 'phpdb';
	protected $dbtype = 'mysql';

	protected $quTable = 'tablename';
	protected $quTableId = 'id';
	protected $quTableFname = '';
	protected $quTableFdate = '';
	protected $quTableFrname = '';
	protected $fdir = 'upload_file';

	// 2MB
	protected $fsize_limit = 50 * 1024 * 1024;

	public function __construct() {
		/*
			생성자, db 설정을 미리 마쳐둡니다.
			## parameter
			$argv[0]: db host url
			$argv[1]: db id
			$argv[2]: db password
			$argv[3]: db table name
			$argv[4]: db type(mysql, mariadb)
			## return
			없음
			## return error code
			ERR_OK: 정상
			ERR_NORMAL: 정의되지 않은 오류
			ERR_PDOERR: 데이터베이스에 의한 오류
		*/
		$argv = array();
    $size = func_num_args();
    for($i=0; $i<$size; $i++) {
        $argv[] = func_get_arg($i);
    }

		if(!empty($argv[0]) && is_string($argv[0])) {
			$this->dburl = $argv[0];
		}
		if(!empty($argv[1]) && is_string($argv[1])) {
			$this->dbid = $argv[1];
		}
		if(!empty($argv[2]) && is_string($argv[2])) {
			$this->dbpw = $argv[2];
		}
		if(!empty($argv[3]) && is_string($argv[3])) {
			$this->dbtable = $argv[3];
		}
		if(!empty($argv[4]) && is_string($argv[4])) {
			$this->dbtype = $argv[4];
		}
	}

	protected function openDB() {
		/*
			db가 열려있지 않으면 오픈합니다.
			## parameter
			없음
			## return
			없음
			## return error code
			없음
		*/
		if($this->db) return;

		$profile = '';
		if($this->dbtype === 'mysql') {
			$profile = "mysql:host=$this->dburl; dbname=$this->dbtable";
		}
		else if($this->dbtype === 'mariadb') {
			$profile = "mysql:host=$this->dburl; dbname=$this->dbtable; port=3306; charset=utf8";
		}
		else {
			throw new PDOException('존재하지 않는 db type');
		}

		$this->db = new PDO($profile, $this->dbid, $this->dbpw);
		$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}

	protected function fileRemover($fname) {

	}

	protected function fileUploader($fdat) {
		//$ftime
		$ftime = time();
		$fnslice = explode('.', $fdat['name']);
		$ftype = end($fnslice);
		$ftslice = explode('/', $fdat['tmp_name']);
		if(count($ftslice) <= 1) {
			$ftslice = explode('\\', $fdat['tmp_name']);
		}
		$ftemp = end($ftslice);
		$fname_save = "file$ftime$ftemp.$ftype";
		if($fdat['name'] != '' && $fdat['error'] == 0) {
			// 업로드 파일 확장자 검사 (필요시 확장자 추가)
			if($ftype=="html" ||
			$ftype=="htm" ||
			$ftype=="php" ||
			$ftype=="php3" ||
			$ftype=="inc" ||
			$ftype=="pl" ||
			$ftype=="cgi" ||
			$ftype=="txt" ||
			$ftype=="TXT" ||
			$ftype=="asp" ||
			$ftype=="jsp" ||
			$ftype=="phtml" ||
			$ftype=="js" ||
			$ftype=="") {
				throw new CommonException('허용되지 않은 파일 형식입니다.');
			}
			// 파일 용량을 검사합니다
			if($fdat['size'] > $this->fsize_limit) {
				throw new CommonException('파일 용량이 허가 용량을 넘습니다.');
			}
			// 임시 파일을 ../../upload_file 로 옮겨서 저장합니다.
			if(!move_uploaded_file($fdat['tmp_name'], $_SERVER['DOCUMENT_ROOT'].'/'.$this->fdir.'/'.$fname_save)) {
				throw new CommonException('파일 저장에 실패했습니다.');
			}

			// 리턴값 만들기
			$farray = array();
			if($this->quTableFname) {
				$farray[$this->quTableFname] = $fname_save;
			}
			if($this->quTableFrname) {
				$farray[$this->quTableFrname] = $fdat['name'];
			}
			if($this->quTableFdate) {
				$farray[$this->quTableFdate] = date('Y-m-d');
			}
			return $farray;
		}
		return null;
	}

	/*
	(private)파일 업로드를 시도하고 결과를 리턴합니다.
	## parameter
	$fparam: form의 파일 파라미터 이름
	## return
	true
	false
	## return error code
	*/

	public function Upload($fparam, $fnum, $datArray) {
		if(!is_array($datArray)) throw new CommonException('잘못된 인수');
		$farray = null;
		if(is_string($fparam) && ($fparam != '')) {
			if(isset($_FILES[$fparam]) && $this->quTableFname != '') {
				if(is_array($_FILES[$fparam]['name'])) {
					$farray = $this->fileUploader([
						'name' => $_FILES[$fparam]['name'][$fnum],
						'tmp_name' => $_FILES[$fparam]['tmp_name'][$fnum],
						'size' => $_FILES[$fparam]['size'][$fnum],
						'type' => $_FILES[$fparam]['type'][$fnum],
						'error' => $_FILES[$fparam]['error'][$fnum]
					]);
				}
				else {
					$farray = $this->fileUploader([
						'name' => $_FILES[$fparam]['name'],
						'tmp_name' => $_FILES[$fparam]['tmp_name'],
						'size' => $_FILES[$fparam]['size'],
						'type' => $_FILES[$fparam]['type'],
						'error' => $_FILES[$fparam]['error']
					]);
				}
			}
		}
		if($farray === null) {
			$farray = array();
		}
		$dfield = '';
		$dvalue = '';
		$first = true;
		foreach($datArray as $key => $val) {
			$dfield = ($first)?($dfield.$key):($dfield.','.$key);
			$dvalue = ($first)?($dvalue.':'.$key):($dvalue.',:'.$key);
			$first = false;
		}
		foreach($farray as $key => $val) {
			$dfield = ($first)?($dfield.$key):($dfield.','.$key);
			$dvalue = ($first)?($dvalue.':'.$key):($dvalue.',:'.$key);
			$first = false;
		}

		$this->openDB();
		$query = $this->db->prepare("insert into $this->quTable ($dfield) values ($dvalue)");
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
		foreach($farray as $key => $val) {
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

	public function Modify($id, $datArray) {
		/*
			DB에 글 수정
			## parameter
			$bno: 글 번호
			$name: 작성자 이름 (관리자만 쓰면 되는데 굳이?)
			$pw: 글 비밀번호
			$title: 글 제목
			$content: 글 본문
			## return
			true
			## return error code
			ERR_NOEQUPW
			ERR_NORMAL: 정의되지 않은 오류
			ERR_PDOERR: 데이터베이스에 의한 오류
		*/
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

	public function Delete($id) {
		/*
			글 보기 화면에 표시할 내용들을 불러옵니다.
			## parameter
			$bno: 글 번호
			## return
			true
			## return error code
			ERR_PDOERR: 데이터베이스의 오류
			ERR_NORMAL: 정의되지 않은 오류
		*/
		// 파일 삭제를 위해 파일명 가져옴
		$this->openDB();
		// 파일 삭제
		if($this->quTableFname != '') {
			$query = $this->db->prepare("select $this->quTableFname from $this->quTable where $this->quTableId=:id");
			$query->bindValue(":id", $id);
			$query->execute();
			$fetch = $query->fetch(PDO::FETCH_ASSOC);
			$fname = $fetch[$this->quTableFname];
			if($fname != '') {
				if(file_exists('../../upload_file/'.$fname)) {
					unlink('../../upload_file/'.$fname);
				}
					if($this->quTable == 'gallery'){
					if(file_exists('img/gallery/'.$fname)) {
						echo $fname;
						unlink('img/gallery/'.$fname);
					}
				}
			}
		}
		// 게시글 삭제
		$query = $this->db->prepare("delete from $this->quTable where $this->quTableId=:id");
		$query->bindValue(":id", $id);
		$query->execute();
	}

	public function SelectAll($select = '*', $where = null) {
		$this->openDB();
		if($where) $query = $this->db->prepare("select $select from $this->quTable where $where");
		else $query = $this->db->prepare("select $select from $this->quTable");
		$query->execute();
		$fetch = $query->fetchAll(PDO::FETCH_ASSOC);
		if($fetch) return $fetch;
		else return null;
	}

	public function GalleryListFive($select = '*', $where = null) {
		$this->openDB();
		if($where) $query = $this->db->prepare("select $select from $this->quTable where $where");
		else $query = $this->db->prepare("select $select from $this->quTable order by id desc limit 0, 4");
		$query->execute();
		$fetch = $query->fetchAll(PDO::FETCH_ASSOC);
		if($fetch) return $fetch;
		else return null;
	}

	public function SelectPageLength($cPage, $viewLen, $where = null) {
		/*
			페이지에 표시할 인덱스 번호 시작점과 종료점 정보를 리턴합니다.
			## parameter
			$current: 페이지 번호
			## return
			$result['count']: 총 글 개수
			$result['page']: 인덱스의 총 개수
			$result['start']: 표시할 인덱스의 시작점
			$result['end']: 표시할 인덱스의 종료점
			$result['current']: 현재 인덱스 교정 결과(범위 교정할 필요 없으면 current 리턴)
		*/
		$this->openDB();
		if($where) $query = $this->db->prepare("select count(*) from $this->quTable where $where");
		else $query = $this->db->prepare("select count(*) from $this->quTable");
		$query->execute();
		$fetch = $query->fetch(PDO::FETCH_ASSOC);
		$countLen = $fetch['count(*)'];

		// 페이지의 총 개수가 몇개인가
		$plen = ($countLen != 0)?$countLen/((int)$viewLen):1;
		$plen = ceil($plen);
		// 표시할 페이지 시작점은 몇번인가
		$pstart = (
			($cPage-2<1)?1:(
				($cPage+2>$plen)?(
					($plen-4>1)?($plen-4):1
				):($cPage-2)
			)
		);
		// 현재 페이지 번호가 몇번인가
		$pcurnt = ((1>$cPage)?1:(($cPage>$plen)?$plen:$cPage));

		return [
			"count" => $countLen,
			"page" => $plen,
			"start" => $pstart,
			"end" => ($pstart+4>$plen)?$plen:$pstart+4,
			"current" => $pcurnt
		];
	}

	public function SelectIdList($id, $viewLen, $select = '*', $where = null) {
		/*
			갤러리에 표시할 사진들의 정보
			## parameter
			$bno: 글 번호
			## return
			$result[i]['id']: 등록번호
			$result[i]['description']: 사진 설명
			$result[i]['fname']: 파일 이름
			$result[i]['fsize']: 파일 크기
			## exceptions
			PDOException
			CommonException
		*/
		$this->openDB();
		if((int)$id == 0) {
			if($where) $query = $this->db->prepare("select $select from $this->quTable where $where order by $this->quTableId desc limit 0, :len");
			else $query = $this->db->prepare("select $select from $this->quTable order by $this->quTableId desc limit 0, :len");
		}
		else {
			if($where) $query = $this->db->prepare("select $select from $this->quTable where $where, $this->quTableId<=:start order by $this->quTableId desc limit 0, :len");
			else $query = $this->db->prepare("select $select from $this->quTable where $this->quTableId<=:start order by $this->quTableId desc limit 0, :len");
			$query->bindValue(":start", (int)$id, PDO::PARAM_INT);
		}
		$query->bindValue(':len', (int)$viewLen, PDO::PARAM_INT);
		$query->execute();
		$fetch = $query->fetchAll(PDO::FETCH_ASSOC);

		if(!$fetch) throw new CommonException('데이터가 존재하지 않습니다.');
		return $fetch;
	}

	public function SelectPageList($cPage, $viewLen, $select = '*', $where = null) {
		/*
			(private)파일 업로드를 시도하고 결과를 리턴합니다.
			## parameter
			$cPage: 요청 페이지 번호
			$viewLen: 한 페이지 당 표시할 객체 개수
			## return
			$array['count']: 글 개수
			$array['page']: 페이지 개수
			$array['start']: 페이지 표시 시작점
			$array['end']: 페이지 표시 종료점
			$array['current']: 현재 페이지
			## exception
		*/
		/*
			페이지에 표시할 게시글 목록 15개의 정보를 리턴합니다.
			## parameter
			$page: 페이지 번호
			## return
			$result[i]['idx']: 게시글 번호
			$result[i]['title']: 게시글 이름
			## return error code
			ERR_PDOERR
			ERR_NORMAL
		*/
		/*
			갤러리에 표시할 사진들의 정보
			## parameter
			$bno: 글 번호
			## return
			$result[i]['description']: 등록번호
			$result[i]['description']: 사진 설명
			$result[i]['fname']: 파일 이름
			$result[i]['fsize']: 파일 크기
			## exceptions
			PDOException
			CommonException
		*/
		$start = ($cPage * $viewLen) - $viewLen;

		$this->openDB();
		if($where) $query = $this->db->prepare("select $select from $this->quTable where $where order by $this->quTableId desc limit :start, :viewLen");
		else $query = $this->db->prepare("select $select from $this->quTable order by $this->quTableId desc limit :start, :viewLen");
		$query->bindValue(":start", $start, PDO::PARAM_INT);
		$query->bindValue(":viewLen", $viewLen, PDO::PARAM_INT);
		$query->execute();
		$fetch = $query->fetchAll(PDO::FETCH_ASSOC);

		if(!$fetch) throw new CommonException('데이터가 존재하지 않습니다.');
		return $fetch;
	}

	public function SelectId($id, $select = '*') {
		// 특정 아이디의 값 모두 불러오기
		$this->openDB();
		$query = $this->db->prepare("select $select from $this->quTable where $this->quTableId=:id");
		$query->bindValue(":id", $id);
		$query->execute();
		$fetch = $query->fetch(PDO::FETCH_ASSOC);

		if(!$fetch) throw new CommonException('데이터가 존재하지 않습니다.');
		return $fetch;
	}

	public function SelectRealFile($fname)
	{
		/*
			업로드로 인해 변경된 파일 이름을 원래 파일명으로 바꿔서 반환합니다.
			## parameter
			$fname: upload_file에 업로드된 파일 이름
			## return
			$realfile: 실제 파일명
			## return error code
			ERR_PDOERR
			ERR_NORMAL
		*/
		$this->openDB();
		$query = $this->db->prepare("select $this->quTableFrname from $this->quTable where $this->quTableFname=:file");
		$query->bindValue(":file", $fname);
		$query->execute();
		$fetch = $query->fetch(PDO::FETCH_ASSOC);

		if(!$fetch) throw new CommonException('파일이 존재하지 않습니다.');
		return $fetch['realfile'];
	}
}

// Process
?>
