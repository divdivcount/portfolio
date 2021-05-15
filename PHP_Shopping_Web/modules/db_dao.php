<?php

class ProDAO {
	// Field
	protected $db = null;
	protected $dburl = 'localhost';
	protected $dbid = 'prod';
	protected $dbpw = '1234';
	protected $dbtable = 'prodb';
	protected $dbtype = 'mysql';

	protected $quTable = 'tablename';
	protected $quTableId = 'id';
	protected $quTableName = '';
	protected $quTableFdate = '';
	protected $quTableFrname = '';
	protected $fdir = 'files';
  protected $fsize_limit = 50 * 1024 * 1024;


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
//제품 출력
	public function SelectAll($select = '*', $where = null) {
    $this->openDB();
    if($where){
			$query = $this->db->prepare("select $select from $this->quTable where $where");
		}else if($this->quTable == "member"){
			$query = $this->db->prepare("select mb_num from $this->quTable");
		}
    else{
			$query = $this->db->prepare("select id, name, manufacturer, info, date_format(date,'%Y-%m'), price, file from $this->quTable");
		}
    $query->execute();
    $fetch = $query->fetchAll(PDO::FETCH_ASSOC);
    if($fetch) return $fetch;
    else return null;
  }

// 제품 추가
	// public function listAdd($product, $name, $manufacturer, $info, $date, $price, $file){
	// 	$this->openDB();
	// 	try{
	// 		$sql1 = "insert into {$product} values (null, :name, :manufacturer, :info, :date,:price,:file)";
	// 	$sql = str_replace('"','',$sql1);
	// 		$query = $this->db->prepare($sql);
	// 	$query -> bindValue(":name", $name, PDO::PARAM_STR);
	// 	$query -> bindValue(":manufacturer", $manufacturer, PDO::PARAM_STR);
	// 	$query -> bindValue(":info", $info, PDO::PARAM_STR);
	// 	$query -> bindValue(":date", $date, PDO::PARAM_STR);
	// 	$query -> bindValue(":price", $price, PDO::PARAM_STR);
	// 	$query -> bindValue(":file", $file, PDO::PARAM_STR);
	// 		$query->execute();
	// 	}catch(PDOException $e){
	// 		exit($e ->getMessage());
	// 	}
	// }



	// 특정 아이디의 값 모두 불러오기
	public function SelectId($id) {
		$this->openDB();
		$query = $this->db->prepare("select * from $this->quTable where id=:id");
		$query->bindValue(":id", $id);
		$query->execute();
		$fetch = $query->fetch(PDO::FETCH_ASSOC);

		if(!$fetch) throw new CommonException('데이터가 존재하지 않습니다.');
		return $fetch;
	}
	// 제품 수정
	// public function listModify($product, $id, $name, $manufacturer, $info, $date, $price, $file){
	// 	try{
	// 	$this->openDB();
	// 	$sql = "update $product set name=:name, manufacturer = :manufacturer, info = :info, date = :date, price=:price, file = :file where id = :id";
	// 	$query = $this->db->prepare($sql);
	// 	$query -> bindValue(":id", $id, PDO::PARAM_INT);
	// 	$query -> bindValue(":name", $name, PDO::PARAM_STR);
	// 	$query -> bindValue(":manufacturer", $manufacturer, PDO::PARAM_STR);
	// 	$query -> bindValue(":info", $info, PDO::PARAM_STR);
	// 	$query -> bindValue(":date", $date, PDO::PARAM_STR);
	// 	$query -> bindValue(":price", $price, PDO::PARAM_STR);
	// 	$query -> bindValue(":file", $file, PDO::PARAM_STR);
	// 	$query->execute();
	// 	}catch(PDOException $e){
	// 	exit($e ->getMessage());
	// 	}
	// }
	//겔러리, 컨설팅, 제품 modify
	public function Modify($product=null,$fparam,$fnum,$id, $datArray) {
		if($product){
			if(!is_array($datArray)) throw new CommonException('잘못된 인수');//is_array($datArray) 배열검사
			$farray = null;
			if(is_string($fparam) && ($fparam != '')) {
				if(isset($_FILES[$fparam]) && $this->quTableFname != '') {
					if(is_array($_FILES[$fparam]['name'])) {
						$farray = $this->fileUploader([ //객체배열로 넣기
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
	      $farray = array(); //배열선언
	    }
	  else{
		    $dfield = '';
				$dvalue = '';
		    $first = true;
				// array_push($datArray,"file");
		    foreach($datArray as $key => $val) {

		      $dfield = ($first)?($dfield.$key.'=:'.$key):($dfield.','.$key.'=:'.$key);
		      // echo $dfield."datArray<br>";
					// echo $key."key<br>";
					// echo $val."<br>";
		      $first = false;
		    }
				foreach($farray as $key => $val) {
					$first = true;
					$dvalue = ($first)?($dvalue.':'.$key):($dvalue.',:'.$key);
					// echo $dvalue."datArray<br>";
					// echo $val."<br>";
					$first = false;
				}
		}
	// 			:namedatArray
	// name=:name,manufacturer=:manufacturerdatArray
	// :name,:manufacturerdatArray
	// name=:name,manufacturer=:manufacturer,info=:infodatArray
	// :name,:manufacturer,:infodatArray
	// name=:name,manufacturer=:manufacturer,info=:info,date=:datedatArray
	// :name,:manufacturer,:info,:datedatArray
	// name=:name,manufacturer=:manufacturer,info=:info,date=:date,price=:pricedatArray
	// :name,:manufacturer,:info,:date,:pricedatArray
			if(empty($dvalue)){
				$dfield = '';
				$first = true;
				$file='';
				foreach($datArray as $key => $val) {

					$dfield = ($first)?($dfield.$key.'=:'.$key):($dfield.','.$key.'=:'.$key);
					// echo $dfield."datArray<br>";
					// echo $key."key<br>";
					// echo $val."<br>";
					$first = false;
				}
			}else{
				$file=", file=$dvalue";
			}
			$this->openDB();
			$query = $this->db->prepare("update $this->quTable set $dfield $file where $this->quTableId=:id");
			print_r($query);
			$query->bindValue(':id', $id);
			foreach($datArray as $key => $val) {
				print_r($datArray);
				if(is_string($val)) {
					$query->bindValue(":$key", $val);
					// echo $val."<br>";
				}
				else if(is_int($val)) {
					$query->bindValue(":$key", $val, PDO::PARAM_INT);
					// echo $val."<br>";
				}
				else {
						$files = implode('', $val);
						$query->bindValue(":$key", $files);
				}
			}
			foreach($farray as $key => $val) {
				if(is_string($val)) {
					$query->bindValue(":$key", $val);
					// echo $key,$val."<br>";
					// print_r($query);
				}
				else if(is_int($val)) {
					$query->bindValue(":$key", $val, PDO::PARAM_INT);
					// echo $val."<br>";
					// print_r($query);
				}
				else {
					$query->bindValue(":$key", $val);
					// print_r($query);
				}
			}
			$query->execute();
		}else{
			$dfield = '';
			$first = true;
			foreach($datArray as $key => $val) {
				$dfield = ($first)?($dfield.$key.'=:'.$key):($dfield.','.$key.'=:'.$key);
				$first = false;
			}
		}
		$this->openDB();
		$query = $this->db->prepare("update $this->quTable set $dfield where $this->quTableId=:id");
		// print_r( $query)."<br>";
		$query->bindValue(':id', $id);
		foreach($datArray as $key => $val) {
			if(is_string($val)) {
				$query->bindValue(":$key", $val);
				// echo $key,$val."<br>";
			}
			else if(is_int($val)) {
				$query->bindValue(":$key", $val, PDO::PARAM_INT);
				// echo $key,$val."<br>";
			}
			else {
				if($this->quTable == "consulting"){
					$query->bindValue(":$key", $val);
				}else{
						$files = implode('', $val);
						$query->bindValue(":$key", $files);
						// print_r( $val)."<br>";
					}
			}
		}
		$query->execute();
	}
//제품, 컨설팅, 겔러리 삭제

public function Delete($id) {
try{
$this->openDB();

if($this->quTable == "consulting"){
	$query = $this->db->prepare("delete from $this->quTable where id=:id");
	// print_r($query);
	// echo "delete from $this->quTableFname where id=:id";
	$query->bindValue(":id", $id, PDO::PARAM_INT);
	$query->execute();
}else{
// 파일 삭제
if( $this->quTableFname !=  '') {
$query = $this->db->prepare("select file from $this->quTable where id=:id");
$query->bindValue(":id", $id, PDO::PARAM_INT);
$query->execute();
$fetch = $query->fetch(PDO::FETCH_ASSOC);
$fname = $fetch['file'];
if($fname != '') {
		if(file_exists("files/$this->quTable/".$fname)) {
			unlink("files/$this->quTable/".$fname);
			}
	}
}
}

	// 게시글 삭제
	$sql = "delete from $this->quTable where id=:id";
	$query = $this->db->prepare($sql);
	$query->bindValue(":id", $id, PDO::PARAM_INT);
	$query->execute();
	}catch(PDOException $e){
	exit($e ->getMessage());
		}
	}


	//페이지 내이션
  	public function SelectPageLength($cPage, $viewLen, $s_value) {
		$this->openDB();
	if (empty($s_value)){
		$query = $this->db->prepare("select count(*) from $this->quTable");
    } else {
		$where_field = ($this->quTable == "puhistory") ? "pr_now" : "name";
		$query = $this->db->prepare("select count(*) from $this->quTable where $where_field like :s_value");
		if(isset($s_value)){
			$query = $this->db->prepare("select count(*) from $this->quTable where $where_field like :s_value");
			if($this->quTable == "consulting"){
					$query = $this->db->prepare("select count(*) from $this->quTable");
			}
		}
		$query->bindValue(":s_value", "%$s_value%",  PDO::PARAM_STR);
	}
    $query->execute();
		// if($this->quTable == "cpu" && $s_value or $this->quTable == "mainboard" && $s_value or $this->quTable == "cases"&& $s_value or $this->quTable == "power" && $s_value or $this->quTable == "memory" && $s_value or
		// $this->quTable == "odd" && $s_value or $this->quTable == "storage"  && $s_value or $this->quTable == "graphicscard" && $s_value or $this->quTable == "cooler"  && $s_value){
		// 		$query = $this->db->prepare("select count(*) from $this->quTable where name  like  :s_value");
		// 	}else if($this->quTable == "puhistory"){
		// 			$query = $this->db->prepare("select count(*) from $this->quTable where pr_name  like  :s_value");
		// 			echo 4;
		// 	}else{
		// 	$query = $this->db->prepare("select count(*) from $this->quTable");
		// 	echo 3;
		// 	}
		//
		// if($s_value){
		// 	$query->bindValue(":s_value", "%$s_value%",  PDO::PARAM_STR);
		// }
		// else{
		//
		// }
		// $query->execute();
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

	public function SelectPageList($cPage, $viewLen,$s_value, $where = null) {
		$start = ($cPage * $viewLen) - $viewLen;
		if($this->quTable == "cpu" || $this->quTable == "mainboard" || $this->quTable == "cases" || $this->quTable == "power" || $this->quTable == "memory" || $this->quTable == "odd" ||  $this->quTable == "cooler" ||
		$this->quTable == "storage" || $this->quTable == "graphicscard"){
				if($s_value){
					$sql= "select id, name, manufacturer, info, date_format(date,'%Y-%m'),price, file from $this->quTable  where name  like  :s_value or manufacturer like :s_value order by $this->quTableId asc limit :start, :viewLen";
				}else{
					$sql= "select id, name, manufacturer, info, date_format(date,'%Y-%m'),price, file from $this->quTable  order by $this->quTableId asc limit :start, :viewLen";
				}
		}else{
				if($this->quTable == "consulting"){
					if($where){
						$sql = "select * from $this->quTable where $where order by $this->quTableId desc limit $start, $viewLen";
					}else{
						$sql= "select * from $this->quTable order by $this->quTableId desc limit $start, $viewLen";
					}
				}
		}
		$this->openDB();
		$query = $this->db->prepare($sql);
		$query->bindValue(":start", $start, PDO::PARAM_INT);
		$query->bindValue(":viewLen", $viewLen, PDO::PARAM_INT);
		if($s_value)$query->bindValue(":s_value", "%$s_value%",  PDO::PARAM_STR);
		// if($start_s_value)$query->bindValue(":start_s_value", "%$start_s_value%",  PDO::PARAM_STR);

		$query->execute();
		$fetch = $query->fetchAll(PDO::FETCH_ASSOC);
		try{
		if(!$fetch){
			// echo "결과 값이 없습니다.";
		}
		return $fetch;
		}catch(PDOException $e){
			exit($e ->getMessage());
		  }
	}

	public function SelectGallery($select = '*', $where = null) {
    $this->openDB();
    if($where) $query = $this->db->prepare("select * from $this->quTable where $where");
    else $query = $this->db->prepare("select * from $this->quTable");
    $query->execute();
    $fetch = $query->fetchAll(PDO::FETCH_ASSOC);
    if($fetch) return $fetch;
    else return null;
  }





	public function fileUploader($fdat) {
		//$ftime파일명에 붙이기 위해
		$ftime = time();
		$fnslice = explode('.', $fdat['name']); // 파일의 확장자를 알기위해 . 으로 나눈다 ex)[123.jpg]
		$ftype = end($fnslice);// 이제 확장자를 알기위해 마지막 배열의 값을 가져온다.
		$ftslice = explode('/', $fdat['tmp_name']);// tmp_name을 / 로 끊어서 배열로 만든다.
		if(count($ftslice) <= 1) {
			$ftslice = explode('\\', $fdat['tmp_name']);
		}
		$ftemp = end($ftslice); // 가져오면 php6999이런식으로 나옵니다.
		$fname_save = "file$ftime$ftemp.$ftype"; //file1604987763php6999.tmp.확장자
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

			if(!move_uploaded_file($fdat['tmp_name'], $this->fdir.'/'.$fname_save)) {
				throw new CommonException('파일 저장에 실패했습니다.');
			}

			// 리턴값 만들기
			$farray = array();//farray배열 선언
			if($this->quTableFname) { //$this->quTableFname이 있으면 farray[파일이름필드의 이름] = 임시파일명
				$farray[$this->quTableFname] = $fname_save; //farray[파일이름필드의 이름] = 임시파일명
			}
			if($this->quTableFrname) {//quTableFrname이 있으면
				$farray[$this->quTableFrname] = $fdat['name'];//quTableFrname을
			}
			if($this->quTableFdate) {//파일 저장 시간 테이블이 있으면
				$farray[$this->quTableFdate] = date('Y-m-d'); //파일 저당한 날짜를 현재시간으로
			}
			return $farray; //리턴
		}
		return null;
	}

//겔러리, 상담, 제품 등록
	public function Upload($product=null,$fparam, $fnum, $datArray) {//$fnum 다중업로드 처리를 위해 id값
		if(!is_array($datArray)) throw new CommonException('잘못된 인수');//is_array($datArray) 배열검사
		$farray = null;
		if(is_string($fparam) && ($fparam != '')) {
			if(isset($_FILES[$fparam]) && $this->quTableFname != '') {
				if(is_array($_FILES[$fparam]['name'])) {
					$farray = $this->fileUploader([ //객체배열로 넣기
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
			$farray = array(); //배열선언
		}
		$dfield = '';
		$dvalue = '';
		$first = true;
		foreach($datArray as $key => $val) {
			$dfield = ($first)?($dfield.$key):($dfield.','.$key);
			// echo $dfield."<br>"; //값을 뽑아서
			$dvalue = ($first)?($dvalue.':'.$key):($dvalue.',:'.$key);
			// echo $dvalue."<br>";//바인드처리
			$first = false;
		}
// name
// :name
// name,manufacturer
// :name,:manufacturer
// name,manufacturer,info
// :name,:manufacturer,:info
// name,manufacturer,info,date
// :name,:manufacturer,:info,:date
// name,manufacturer,info,date,price
// :name,:manufacturer,:info,:date,:price
		foreach($farray as $key => $val) {
			// print_r($val);
			$dfield = ($first)?($dfield.$key):($dfield.','.$key);
			// echo $dfield."<br>";
			$dvalue = ($first)?($dvalue.':'.$key):($dvalue.',:'.$key);
			// echo $dfield."<br>";
			$first = false;
		}

		$this->openDB();
		$query = $this->db->prepare("insert into $this->quTable ($dfield) values ($dvalue)"); //글 올리는 로직
		foreach($datArray as $key => $val) {
			if(is_string($val)) { //변수 유형이 문자열인지 확인
				$query->bindValue(":$key", $val);
			}
			else if(is_int($val)) {//변수 유형이 숫자인지 확인
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
///3개 합치는거 완성!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
//왜 테이블 여러개로 만들었지..테이블 낭비..
	public function SelectHistory($s_value,$start_s_value) {
		$this->openDB();
		if($this->quTable == "puhistory"){
			if($s_value && !$start_s_value){
				$sql= "select pu_id, id_key, pr_img, pr_name, pa, pr_qty, mb_num,pr_num,date_format(pr_now,'%Y-%m'),order_id,pu_besong,pu_banpum_check from $this->quTable  where pr_now  like  :s_value order by $this->quTableId asc";
			}elseif(!$s_value && $start_s_value){
				$sql= "select pu_id, id_key, pr_img, pr_name, pa, pr_qty, mb_num,pr_num,date_format(pr_now,'%Y-%m'),order_id,pu_besong,pu_banpum_check from $this->quTable  where pr_now  like  '%$start_s_value%' order by $this->quTableId asc";
				$s_value ="";
			}elseif($s_value && $start_s_value){
				// $sql= "select pu_id, id_key, pr_img, pr_name, pa, pr_qty, mb_num,pr_num,date_format(pr_now,'%Y-%m'),order_id from $this->quTable  where pr_now  like  :s_value order by $this->quTableId asc limit :start, :viewLen";
				//SELECT * FROM puhistory WHERE pr_now IN ( SELECT pr_now FROM puhistory WHERE DATE(pr_now) BETWEEN NOW() - INTERVAL 6 MONTH AND NOW() ); 6개월전 구매 목록 뽑아오기
				$sql = "select pu_id, id_key, pr_img, pr_name, pa, pr_qty, mb_num,pr_num,date_format(pr_now,'%Y-%m'),order_id,pu_besong,pu_banpum_check from puhistory where date_format(pr_now,'%Y-%m') between '$start_s_value' and '$s_value' order by date_format(pr_now,'%Y-%m') asc";
				$s_value ="";
			}else{
				$sql= "select pu_id, id_key, pr_img, pr_name, pa, pr_qty, mb_num,pr_num,date_format(pr_now,'%Y-%m'),order_id,pu_besong,pu_banpum_check from $this->quTable  order by date_format(pr_now,'%Y-%m') asc";
			}
		}else{
			$sql= "select * from $this->quTable  order by $this->quTableId asc";
		}
		$query = $this->db->prepare($sql);
		if($s_value)$query->bindValue(":s_value", "%$s_value%",  PDO::PARAM_STR);
		$query->execute();
		$fetch = $query->fetchAll(PDO::FETCH_ASSOC);
		try{
		if(!$fetch){
			// echo "결과 값이 없습니다.";
		}
		return $fetch;
		}catch(PDOException $e){
			exit($e ->getMessage());
			}
	}


	public function Gohistory($cat_key, $id_key, $pr_img, $pr_name, $pa, $pr_qty, $mb_num,$num,$now,$last_id) {
    $this->openDB();
    $query = $this->db->prepare("insert into $this->quTable values (:cat_key, :id_key, :pr_img, :pr_name, :pa,:pr_qty,:mb_num,:pr_num,:pr_now,0,DEFAULT,DEFAULT)");
		$query -> bindValue(":cat_key", $cat_key, PDO::PARAM_STR);
		$query -> bindValue(":id_key", $id_key, PDO::PARAM_STR);
		$query -> bindValue(":pr_img", $pr_img, PDO::PARAM_STR);
		$query -> bindValue(":pr_name", $pr_name, PDO::PARAM_STR);
		$query -> bindValue(":pa", $pa, PDO::PARAM_STR);
		$query -> bindValue(":pr_qty", $pr_qty, PDO::PARAM_STR);
		$query -> bindValue(":mb_num", $mb_num, PDO::PARAM_STR);
		$query -> bindValue(":pr_num", $num, PDO::PARAM_STR);
		$query -> bindValue(":pr_now", $now, PDO::PARAM_STR);
    $query->execute();
		// if($this->quTable == "puhistory"){
		// 	$this->quTable = "paygo";
		// 	$query = $this->db->prepare("insert into $this->quTable values (:mb_num,:pr_num)");
		// 	$query -> bindValue(":mb_num", $mb_num, PDO::PARAM_STR);
		// 	$query -> bindValue(":pr_num", $num, PDO::PARAM_STR);
		// 	$query->execute();
		// }
		if($last_id == 0){
			$last_id = $this->db->lastInsertId();//오토 인크리먼트로 가장 최근 값
		}
		// "update $this->quTable set order_id = {$last_id} where pu_id =$last_id = " . $this->db->lastInsertId();
		$this->db->exec("update $this->quTable set order_id = {$last_id} where pu_id = " . $this->db->lastInsertId());
		// echo "update $this->quTable set order_id = {$last_id} where pu_id = " . $this->db->lastInsertId();
		// exit;
		return $last_id;
  }

	public function UserSelectAll($mb_id, $mb_rating = null, $mb_p_num = null) {
		$this->openDB();
		if($mb_id && $mb_rating && $mb_p_num){
			// echo $mb_id."아이디 쿼리<br>";
			// echo $mb_rating."mb_rating쿼리<br>";
			// echo $mb_p_num."쿼리<br>";
			// echo "<br>"."go"."<br>";
			if($mb_p_num >= 1500000){
				$query = $this->db->prepare("update paygo set mem_rating_num = $mb_rating where mb_num = $mb_id");
				$query->execute();
				// echo "P";
			}else if($mb_p_num >= 999999){
				$query = $this->db->prepare("update paygo set mem_rating_num = $mb_rating where mb_num = $mb_id");
				$query->execute();
				// echo "G";
			}else if($mb_p_num > 50000){
				$query = $this->db->prepare("update paygo set mem_rating_num = $mb_rating where mb_num = $mb_id");
				$query->execute();
				// echo "S";
			}else if($mb_rating == 4){
				$query = $this->db->prepare("update paygo set mem_rating_num = 4 where mb_num = $mb_id");
				$query->execute();
				// echo "I";
			}
		}
		$query = $this->db->prepare("select m.mem_rating_name, m.mem_rating_num, p.mb_id, sum(p.pr_num) AS p_num FROM member_rating m, paygo p WHERE m.mem_rating_num = p.mem_rating_num and mb_num = $mb_id GROUP BY m.mem_rating_num order by m.mem_rating_num desc");
		$query->execute();
		$fetch = $query->fetchAll(PDO::FETCH_ASSOC);
		if($fetch){
			return $fetch;
		}
		else return null;
	}

 public function Admin_delivery($mb_num,$p_id,$besong,$p_id_key=null){
	 $this->openDB();
	 if(empty($p_id_key)){
	 $query = $this->db->prepare("update puhistory set pu_besong = '$besong' WHERE `mb_num` = $mb_num and `order_id` = $p_id");
 }else{
	 // echo "<br>"."$p_id_key"."123<br>";
	 $query = $this->db->prepare("update puhistory set pu_besong = '$besong' WHERE `mb_num` = $mb_num and `order_id` = $p_id and `id_key` = $p_id_key");
 }
	 $query->execute();
 }
 public function User_delivery($order_id_sel_rm,$mb_num_sel_rm,$mb_sel_rm, $pu_banpum_check,$id_key=null){
	 $this->openDB();
	if($id_key){
	 $query = $this->db->prepare("update puhistory set pu_besong = '$mb_sel_rm', pu_banpum_check = $pu_banpum_check WHERE `mb_num` = $mb_num_sel_rm and `order_id` = $order_id_sel_rm and `id_key` = $id_key");
 }else{
	 $query = $this->db->prepare("update puhistory set pu_besong = '$mb_sel_rm', pu_banpum_check = $pu_banpum_check WHERE `mb_num` = $mb_num_sel_rm and `order_id` = $order_id_sel_rm");
 }
	 $query->execute();
 }
}
?>
