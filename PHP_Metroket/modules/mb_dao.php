<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/modules/module_protect.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/modules/db_dao.php');

  class Member extends MetroDAO {
    protected $quTable = 'member';
    protected $quTableId = 'mb_num';
    protected $quTableFname = 'mb_image';
    protected $fdir = 'files';

    public function Member_Delete($mb_id) {
    try{
      // 회원 탈퇴
      $this->openDB();
      // var_dump($mb_id != 'null');
      // var_dump($om_id == 'null');
      if($mb_id != 'null'){
        $sql = "delete from member where mb_id='$mb_id'";
        echo "회원 탈퇴";
      }
      $query = $this->db->prepare($sql);
      $query->execute();
      ?>
      <script>
        alert("지금까지 메트로켓을 사랑 해주셔서 감사합니다.");
        window.top.location.href = "../index.php";
      </script>
      <?php
      }catch(PDOException $e){
      exit($e ->getMessage());
      }
    }

    public function Member_all_select($mb_id) {
      // 회원 번호 찾기 User_page 회원번호 찾는데 사용합니다.
      $this->openDB();
      $query = $this->db->prepare("select * from member where mb_num =:mb_num");
      $query->bindValue(":mb_num", $mb_id, PDO::PARAM_INT);
      $query->execute();
      $fetch = $query->fetchAll(PDO::FETCH_ASSOC);
      if($fetch){
        return $fetch;
      }
      else return null;
    }

    public function admin_Member_all_select($mb_id) {
      // 회원 번호 찾기 User_page 회원번호 찾는데 사용합니다.
      $this->openDB();
      $query = $this->db->prepare("select *,(select count(rep_mb.mb_id) from member_declaration rep_mb where rep_mb.mb_id = m.mb_num) as rep_count from member m where mb_num =:mb_num");
      $query->bindValue(":mb_num", $mb_id, PDO::PARAM_INT);
      $query->execute();
      $fetch = $query->fetchAll(PDO::FETCH_ASSOC);
      if($fetch){
        return $fetch;
      }
      else return null;
    }

    public function admin_Member_id_all_select($mem_id) {
      // 회원 번호 찾기 User_page 회원번호 찾는데 사용합니다.
      $this->openDB();
      $query = $this->db->prepare("select *,(select count(rep_mb.mb_id) from member_declaration rep_mb where rep_mb.mb_id = m.mb_num) as rep_count from member m where mb_id =:mb_id");
      $query->bindValue(":mb_id", $mem_id, PDO::PARAM_STR);
      $query->execute();
      $fetch = $query->fetchAll(PDO::FETCH_ASSOC);
      // var_dump($fetch);
      if($fetch){
        return $fetch;
      }
      else return null;
    }

    public function Member_Search($mb_name, $mb_email) {
      // 회원 번호 찾기 User_page 회원번호 찾는데 사용합니다.
      $this->openDB();
      $query = $this->db->prepare("select mb_id from member where mb_name ='$mb_name' and mb_email = '$mb_email'");
      $query->execute();
      $fetch = $query->fetchAll(PDO::FETCH_ASSOC);
      if($fetch){
        return $fetch;
      }
      else return null;
    }

    public function Member_Select($mb_id) {
    	// 회원 정보 1명 찾기
    	$this->openDB();
    	$query = $this->db->prepare("select mb_id from member where mb_num = $mb_id");
    	$query->execute();
    	$fetch = $query->fetchAll(PDO::FETCH_ASSOC);
    	if($fetch){
    		return $fetch;
    	}
    	else return null;
    }

    public function Delete_mbImg($id) {
  		try{
  			$this->openDB();

  			// 파일 삭제
  			if( $this->quTableFname !=  '') {

  				$query = $this->db->prepare("select mb_image from $this->quTable where mb_num=:id");
  				$query->bindValue(":id", $id, PDO::PARAM_STR);
  				$query->execute();

  				while ($fetch = $query->fetch(PDO::FETCH_ASSOC)) {
            if ($fetch['mb_image'] != "img/normal_profile.png") {
    					$fname = $fetch['mb_image'];
    					// var_dump($fname);
    					if($fname != '') {
    						if(file_exists("files/".$fname)) {
    							// echo "삭제";
    							unlink("files/".$fname);
    						}
    					}
            }else{
              return null;
            }
  				}
  			}
  		}catch(PDOException $e){
  			exit($e ->getMessage());
  		}
  	}

    public function Member_nickname_update($mb_num, $mb_name) {
    	// 회원 정보 1명 찾기
    	$this->openDB();
    	$query = $this->db->prepare("update member set mb_name = :mb_name where mb_num = :mb_num");
      $query->bindValue(":mb_num", $mb_num, PDO::PARAM_INT);
      $query->bindValue(":mb_name", $mb_name, PDO::PARAM_STR);
    	$query->execute();
    }

    //페이지 내이션
      public function mem_SelectPageLength($cPage, $viewLen, $mb_id, $om_id, $s_value= null) {
        $this->openDB();
          // echo "여긴가?";
          if($mb_id == 'null' && $om_id == 'null' && $s_value == null){
              if(empty($s_value) == true){
                // echo "여긴가?2";
                $query = $this->db->prepare("select sum(cnt) from
                    (
                        select count(*) as cnt from member m where mb_operation = 2 and mb_email_certify != '0000-00-00 00:00:00'
                        Union all
                        select count(*) as cnts from oauth_member o ) as s
                  ");
                }
            }elseif($mb_id === 'admin'){
                if(empty($s_value) == true){
                  // echo "여긴가?2";
                  $query = $this->db->prepare("select sum(cnt) from
                    (
                        select count(*) as cnt from member m where mb_operation = 2 and mb_email_certify != '0000-00-00 00:00:00' and mb_block = 'y'
                        Union all
                        select count(*) as cnts from oauth_member o where om_block = 'y') as s
                  ");
                }else{
                    // echo "여긴가?3";
                    $query = $this->db->prepare("
                    select sum(cnt) from
                    ( select count(*) as cnt from member m where mb_operation = 2 and concat(m.mb_id,m.mb_name,m.line_station) like :s_value and mb_email_certify != '0000-00-00 00:00:00' and mb_block = 'y'
                      Union all
                      select count(*) as cnts from oauth_member o where concat(o.om_id,o.om_nickname,o.line_station) like :s_value and om_block = 'y') as s
                    ");
                    $query->bindValue(":s_value", "%$s_value%",  PDO::PARAM_STR);
                  }
            }else{
                // echo "여긴가?4";
                $query = $this->db->prepare("
                select sum(cnt) from
                ( select count(*) as cnt from member m where mb_operation = 2 and concat(m.mb_id,m.mb_name,m.line_station) like :s_value and mb_email_certify != '0000-00-00 00:00:00'
                  Union all
                  select count(*) as cnts from oauth_member o where concat(o.om_id,o.om_nickname,o.line_station) like :s_value ) as s
                ");
                $query->bindValue(":s_value", "%$s_value%",  PDO::PARAM_STR);
              }


      $query->execute();
      $fetch = $query->fetch(PDO::FETCH_ASSOC);
      $countLen = $fetch['sum(cnt)'];

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

    public function mem_SelectPageList($cPage, $viewLen, $mb_id, $om_id, $s_value = null) {
      $this->openDB();
      $start = ($cPage * $viewLen) - $viewLen;
      // echo $start."<br>";
      // echo $viewLen;
      // echo $mb_id;
      // echo $om_id;


          if($mb_id == 'null' && $om_id == 'null' && $s_value == null){
                if(empty($s_value) == true){
                  $sql = "
                  (select m.mb_name, m.mb_id, m.mb_email, m.mb_datetime, m.line_station, (select count(rep_mb.mb_id) from member_declaration rep_mb where rep_mb.mb_id = m.mb_num) as rep_count from member m where mb_operation = 2 and mb_email_certify != '0000-00-00 00:00:00')
                    union all
                  (select o.om_nickname, o.om_id, o.om_email, o.om_datetime, o.line_station, (select count(rep_mb.om_id) from member_declaration rep_mb where rep_mb.om_id = o.om_id) as rep_count from oauth_member o)
                  limit :start, :viewLen";
                  $query = $this->db->prepare($sql);
                }
              }elseif($mb_id === 'admin'){
                  if(empty($s_value) == true){
                    // echo "여긴가?11112";
                   $sql = "
                       (select m.mb_name, m.mb_id, m.mb_email, m.mb_datetime, m.line_station, (select count(rep_mb.mb_id) from member_declaration rep_mb where rep_mb.mb_id = m.mb_num) as rep_count from member m where mb_operation = 2 and mb_email_certify != '0000-00-00 00:00:00' and mb_block = 'y')
                         union all
                       (select o.om_nickname, o.om_id, o.om_email, o.om_datetime, o.line_station, (select count(rep_mb.om_id) from member_declaration rep_mb where rep_mb.om_id = o.om_id) as rep_count from oauth_member o where om_block = 'y')
                       limit :start, :viewLen";
                    $query = $this->db->prepare($sql);
                  }else{
                      // echo "여긴가?3";
                      $sql = "
                          (select m.mb_name, m.mb_id, m.mb_email, m.mb_datetime, m.line_station, (select count(rep_mb.mb_id) from member_declaration rep_mb where rep_mb.mb_id = m.mb_num) as rep_count from member m where mb_operation = 2 and concat(m.mb_id,m.mb_name) like :s_value and mb_email_certify != '0000-00-00 00:00:00' and mb_block = 'y')
                          union all
                          (select o.om_nickname, o.om_id, o.om_email, o.om_datetime, o.line_station, (select count(rep_mb.om_id) from member_declaration rep_mb where rep_mb.om_id = o.om_id) as rep_count from oauth_member o where concat(o.om_id,o.om_nickname) like :s_value and om_block = 'y')
                          limit :start, :viewLen";
                      $query = $this->db->prepare($sql);
                      if($s_value)$query->bindValue(":s_value", "%$s_value%",  PDO::PARAM_STR);
                    }
              }else{
                // echo "2??";
                $sql = "
                  (select m.mb_name, m.mb_id, m.mb_email, m.mb_datetime, m.line_station, (select count(rep_mb.mb_id) from member_declaration rep_mb where rep_mb.mb_id = m.mb_num) as rep_count from member m where mb_operation = 2 and concat(m.mb_id,m.mb_name, m.mb_email) like :s_value and mb_email_certify != '0000-00-00 00:00:00')
                  union all
                  (select o.om_nickname, o.om_id, o.om_email, o.om_datetime, o.line_station, (select count(rep_mb.om_id) from member_declaration rep_mb where rep_mb.om_id = o.om_id) as rep_count from oauth_member o where concat(o.om_id,o.om_nickname, o.om_email) like :s_value)
                limit :start, :viewLen";
                $query = $this->db->prepare($sql);
                if($s_value)$query->bindValue(":s_value", "%$s_value%",  PDO::PARAM_STR);
              }

      $query->bindValue(":start", $start, PDO::PARAM_INT);
      $query->bindValue(":viewLen", $viewLen, PDO::PARAM_INT);


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

    public function admin_Member_Search($mb_name, $mb_id) {
      // 회원 번호 찾기 User_page 회원번호 찾는데 사용합니다.
      $this->openDB();
      $query = $this->db->prepare("
        (select m.mb_name,m.mb_image ,m.mb_id, m.mb_email, m.mb_datetime, m.mb_block,m.line_station,m.warning_count ,(select count(rep_mb.mb_id) from member_declaration rep_mb where rep_mb.mb_id = m.mb_num) as rep_count from member m where mb_operation = 2 and mb_name = :mb_name and mb_id = :mb_id)
          Union all
          (select o.om_nickname,o.om_image_url ,o.om_id, o.om_email, o.om_datetime, o.om_block,o.line_station,o.warning_count ,(select count(rep_mb.om_id) from member_declaration rep_mb where rep_mb.om_id = o.om_id) as rep_count from oauth_member o where om_nickname = :mb_name and om_id = :mb_id)
      ");
      $query->bindValue(":mb_name","$mb_name",  PDO::PARAM_STR);
      $query->bindValue(":mb_id", $mb_id,  PDO::PARAM_STR);
      $query->execute();

      $fetch = $query->fetchAll(PDO::FETCH_ASSOC);
      if($fetch){
        return $fetch;
      }
      else return null;
    }

    public function admin_mb_block($mb_id, $gap) {
      // echo $mb_id;
      // echo $gap;
          $this->openDB();
          $query = $this->db->prepare("update $this->quTable set mb_block=:gap where mb_id=:mb_id");
          $query->bindValue(':mb_id', $mb_id, PDO::PARAM_STR);
          $query->bindValue(':gap', $gap, PDO::PARAM_STR);
          // var_dump($query);
          return $query->execute();
        }

        public function admin_waring_send($mem_id,$admin,$time,$recive,$memo_text) {
          $this->openDB();
          $query = $this->db->prepare("update member set warning_count = warning_count + 1 where mb_id = :mem_id");
          $query -> bindValue(":mem_id", $mem_id, PDO::PARAM_STR);
          $query->execute();
          $query = $this->db->prepare("insert into mb_om_memo values (null, :mem_id, :admin, :time, :recive ,:memo_text, null)");
          $query -> bindValue(":mem_id", $mem_id, PDO::PARAM_STR);
          $query -> bindValue(":admin", $admin, PDO::PARAM_STR);
          $query -> bindValue(":time", $time, PDO::PARAM_STR);
          $query -> bindValue(":recive", $recive, PDO::PARAM_STR);
          $query -> bindValue(":memo_text", $memo_text, PDO::PARAM_STR);
          $query->execute();

        }
  }
