<?php

// Load Modules
require_once('db_dao.php');


// Parameter

// Functions
//전체 출력 GraphicsCard정보
class Pay_history extends ProDAO {
protected $quTable = 'puhistory';
protected $quTableId = 'pu_id';

  public function Gopay($mb_num,$num, $rating ,$mb_id) {
    $this->openDB();
    echo "<br>".$mb_num."쿼리<br>";
    echo "<br>".$num."쿼리<br>";
    echo "<br>".$mb_id."쿼리<br>";
    $query = $this->db->prepare("insert into paygo (mb_num, mb_id, pr_num, mem_rating_num) values (:mb_num,:mb_id,:pr_num,:rating)");
    $query -> bindValue(":mb_num", $mb_num, PDO::PARAM_STR);
    $query -> bindValue(":pr_num", $num, PDO::PARAM_STR);
    $query -> bindValue(":mb_id", $mb_id, PDO::PARAM_STR);
    $query -> bindValue(":rating", $rating, PDO::PARAM_STR);
    $query->execute();
  }

  public function GoSelectAll($mb_num) {
    $this->openDB();
    $query = $this->db->prepare("select * from paygo where mb_num = $mb_num");
    $query->execute();
    $fetch = $query->fetchAll(PDO::FETCH_ASSOC);
    if($fetch) return $fetch;
    else return null;
  }
  public function Pu_SelectAll($mb_num) {
    $this->openDB();
    $query = $this->db->prepare("select * from puhistory where mb_num = $mb_num");
    $query->execute();
    $fetch = $query->fetchAll(PDO::FETCH_ASSOC);
    if($fetch) return $fetch;
    else return null;
  }
  public function BesongSelectAll($mb_num) {
    $this->openDB();
    $query = $this->db->prepare("select COUNT(DISTINCT(order_id)) from puhistory where mb_num = $mb_num  and pu_besong = '배송중'");
    $query->execute();
    $fetch = $query->fetchAll(PDO::FETCH_ASSOC);
    if($fetch) return $fetch;
    else return null;
  }
}
?>
