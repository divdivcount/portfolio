<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/modules/module_protect.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/modules/db_dao.php');

  class Reasons extends MetroDAO {
    protected $quTable = 'reasons_for_withdrawal';
    protected $quTableId = 'reason_id';

    public function Reason_select() {
      // 회원 번호 찾기 User_page 회원번호 찾는데 사용합니다.
      $this->openDB();
      $query = $this->db->prepare("select reason_id, reasons_string from reasons_for_withdrawal");
      $query->execute();
      $fetch = $query->fetchAll(PDO::FETCH_ASSOC);
      if($fetch){
        return $fetch;
      }
      else return null;
    }

    public function Reason_count($sau) {
      // 회원 번호 찾기 User_page 회원번호 찾는데 사용합니다.
      $this->openDB();
      $query = $this->db->prepare("update reasons_for_withdrawal set reason_count = reason_count + 1 where reason_id = $sau");
      $query->execute();
    }


}
