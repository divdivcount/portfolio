<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/modules/module_protect.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/modules/db_dao.php');

  class Oauths extends MetroDAO {
    protected $quTable = 'oauth_member';
    protected $quTableId = 'om_id';

    public function Om_insert($mb_uid,$mb_token,$mb_nickname,$mb_email,$mb_profile_image,$mb_company) {
      $this->openDB();
      $query = $this->db->prepare("insert into $this->quTable values (:mb_uid, :mb_email, :mb_nickname, :mb_profile_image, :mb_token,:mb_company,null,null,null)");
      $query -> bindValue(":mb_uid", $mb_uid, PDO::PARAM_STR);
      $query -> bindValue(":mb_email", $mb_email, PDO::PARAM_STR);
      $query -> bindValue(":mb_nickname", $mb_nickname, PDO::PARAM_STR);
      $query -> bindValue(":mb_profile_image", $mb_profile_image, PDO::PARAM_STR);
      $query -> bindValue(":mb_token", $mb_token, PDO::PARAM_STR);
      $query -> bindValue(":mb_company", $mb_company, PDO::PARAM_STR);
      $query->execute();
    }

    public function Om_select($mb_uid) {
      // 회원 출력
      $this->openDB();
      $query = $this->db->prepare("select * from $this->quTable where om_id = $mb_uid");
      $query -> bindValue(":mb_uid", $mb_uid, PDO::PARAM_STR);
      $query->execute();
      $fetch = $query->fetchAll(PDO::FETCH_ASSOC);
      if($fetch){
        return $fetch;
      }
      else return null;
    }

    public function admin_Om_select($mb_uid) {
      // 회원 출력
      $this->openDB();
      $query = $this->db->prepare("select *, (select count(rep_mb.om_id) from member_declaration rep_mb where rep_mb.om_id = om_id) as rep_count from $this->quTable where om_id = :mb_uid");
      $query -> bindValue(":mb_uid", $mb_uid, PDO::PARAM_STR);
      $query->execute();
      $fetch = $query->fetchAll(PDO::FETCH_ASSOC);
      // var_dump($fetch);
      if($fetch){
        return $fetch;
      }
      else return null;
    }
    //이 위치가 아니지만 나중에 수정하겠습니다.
    public function memo_select($pr_id) {
      // 회원 출력
      $this->openDB();
      $query = $this->db->prepare("select DISTINCT(me_send_mb_id) from mb_om_memo where pr_id = :pr_id");
      $query -> bindValue(":pr_id", $pr_id, PDO::PARAM_INT);
      $query->execute();
      $fetch = $query->fetchAll(PDO::FETCH_ASSOC);
      // var_dump($fetch);
      if($fetch){
        return $fetch;
      }
      else return null;
    }

    public function admin_Om_block($om_id, $gap) {
      // echo $om_id;
      // echo $gap;
          $this->openDB();
          $query = $this->db->prepare("update $this->quTable set om_block=:gap where om_id=:om_id");
          $query->bindValue(':om_id', $om_id, PDO::PARAM_INT);
          $query->bindValue(':gap', $gap, PDO::PARAM_STR);
          // var_dump($query);
          return $query->execute();
        }

    public function Om_token_update($mb_token, $mb_id) {
          $this->openDB();
          $query = $this->db->prepare("update $this->quTable set om_access_token=:mb_token where om_id=:mb_id");
          $query->bindValue(':mb_token', $mb_token);
          $query->bindValue(':mb_id', $mb_id);
          return $query->execute();
        }



        public function Oauth_Delete($om_id, $om_company, $access) {
        try{
          // 회원 탈퇴
          $this->openDB();
          if($om_id != 'null'){
            if($om_company == 'naver'){
              define('NAVER_CLIENT_ID', 'qFL1MdijiIfEemYxHv9a');
              define('NAVER_CLIENT_SECRET', 'OlLqFEtna0'); // 네이버 접근 토큰 삭제
              // 네이버 접근 토큰 삭제
              $naver_curl = "https://nid.naver.com/oauth2.0/token?grant_type=delete&client_id=".NAVER_CLIENT_ID."&client_secret=".NAVER_CLIENT_SECRET."&access_token=".urlencode($access)."&service_provider=NAVER";
              $is_post = false;

              $ch = curl_init();
              curl_setopt($ch, CURLOPT_URL, $naver_curl);
              curl_setopt($ch, CURLOPT_POST, $is_post);
              curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
              $response = curl_exec ($ch);
              $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
              curl_close ($ch);
              if($status_code == 200) {
                $responseArr = json_decode($response, true);
                // 멤버 DB에서 회원을 탈퇴해주고 로그아웃(세션, 쿠키 삭제)
                if ($responseArr['result'] != 'success') {
                  echo "오류가 발생하였습니다. 네이버 내정보->보안설정->외부 사이트 연결에서 해당앱을 삭제하여 주십시오.1";

                }else {
                  $sql = "delete from oauth_member where om_id=$om_id";
                }
              } else {
                echo "오류가 발생하였습니다. 네이버 내정보->보안설정->외부 사이트 연결에서 해당앱을 삭제하여 주십시오.";
               }
            }elseif($om_company == 'kakao'){
              $access_token = $access;
              $UNLINK_API_URL = "https://kapi.kakao.com/v1/user/unlink";
              $opts = array( CURLOPT_URL => $UNLINK_API_URL, CURLOPT_SSL_VERIFYPEER => false, CURLOPT_SSLVERSION => 1, CURLOPT_POST => true, CURLOPT_POSTFIELDS => false, CURLOPT_RETURNTRANSFER => true, CURLOPT_HTTPHEADER => array( "Authorization: Bearer " . $access_token ) );
              $curlSession = curl_init();
              curl_setopt_array($curlSession, $opts);
              $accessUnlinkJson = curl_exec($curlSession);
              curl_close($curlSession);
              $unlink_responseArr = json_decode($accessUnlinkJson, true);
              $sql = "delete from oauth_member where om_id=$om_id";
            }
          }
          $query = $this->db->prepare($sql);
          $query->execute();
          if(isset($_SESSION['naver_mb_id'])) {
            unset($_SESSION['naver_mb_id']);// 모든 세션변수를 언레지스터 시켜줌
            if(empty($_SESSION['naver_mb_id'])) {
            }else{
            	session_destroy($_SESSION['naver_mb_id']); // 세션파괴
            }
          }elseif (isset($_SESSION['kakao_mb_id'])) {
            unset($_SESSION['kakao_mb_id']);// 모든 세션변수를 언레지스터 시켜줌
            if(empty($_SESSION['kakao_mb_id'])) {
            }else{
            	session_destroy($_SESSION['kakao_mb_id']); // 세션파괴
            }
          }
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
        public function admin_om_waring_send($mem_id,$admin,$time,$recive,$memo_text) {
          $this->openDB();
          $query = $this->db->prepare("update oauth_member set warning_count = warning_count + 1 where om_id = :mem_id");
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
