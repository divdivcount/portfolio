<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/modules/module_protect.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/modules/db_dao.php');

  class Reply extends MetroDAO {
    protected $quTable = 'reply';
    protected $quTableId = 'idx';


    public function reply_select($pr_id) {
      // 회원 출력
      $this->openDB();
      $query = $this->db->prepare("select r.idx,(select count(idx) from reply where pr_id = r.pr_id)as reply_count,(case when r.mb_id is not null then (select m.mb_image from member m where m.mb_num = r.mb_id) when r.om_id is not null then (select om_image_url from oauth_member o where o.om_id = r.om_id) else null end) as mb_img, (case when r.mb_id is not null then (select m.mb_id from member m where m.mb_num = r.mb_id) when r.om_id is not null then (select om_id from oauth_member o where o.om_id = r.om_id) else null end) as mb_id, r.date, r.content from reply r where pr_id= :pr_id order by idx desc");
      $query -> bindValue(":pr_id", $pr_id, PDO::PARAM_INT);
      $query->execute();
      $fetch = $query->fetchAll(PDO::FETCH_ASSOC);
      // var_dump($fetch);
      if($fetch){
        return $fetch;
      }
      else return null;
    }

  }
