<?php
  require_once($_SERVER['DOCUMENT_ROOT'].'/modules/module_protect.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/modules/db_dao.php');

  class Interest extends MetroDAO {
    protected $quTable = 'interest';
    protected $quTableId = 'in_id';

    public function in_insert($pr_id,$mb_id,$om_id, $in_hit) {
      $this->openDB();
      if($mb_id != 'null'){
        $query = $this->db->prepare("insert into $this->quTable (pr_id, mb_id, in_hit) values (:pr_id, :mb_id, :in_hit)");
        $query -> bindValue(":mb_id", $mb_id, PDO::PARAM_INT);
      }else if($om_id != 'null'){
        $query = $this->db->prepare("insert into $this->quTable (pr_id, om_id, in_hit) values (:pr_id, :om_id, :in_hit)");
        $query -> bindValue(":om_id", $om_id, PDO::PARAM_INT);
      }
      $query -> bindValue(":pr_id", $pr_id, PDO::PARAM_INT);
      $query -> bindValue(":in_hit", $in_hit, PDO::PARAM_INT);
      $query->execute();
    }

    public function in_select($pr_id,$mb_id,$om_id) {
      $this->openDB();
      if($mb_id != 'null' && $om_id == 'null'){
        // echo $pr_id."pr_id_dao<br>";
        // echo $mb_id."mb_id_dao<br>";
        // echo $om_id."om_id_dao<br>";
        $query = $this->db->prepare("select * from $this->quTable where pr_id = :pr_id  and mb_id= :mb_id and om_id is null");
        $query -> bindValue(":mb_id", $mb_id, PDO::PARAM_INT);
        $query -> bindValue(":pr_id", $pr_id, PDO::PARAM_INT);
      }else if($om_id != 'null' && $mb_id == 'null'){
        $query = $this->db->prepare("select * from $this->quTable where pr_id = :pr_id and om_id = :om_id and mb_id is null");
        $query -> bindValue(":om_id", $om_id, PDO::PARAM_INT);
        $query -> bindValue(":pr_id", $pr_id, PDO::PARAM_INT);
      }

      $query->execute();
      $fetch = $query->fetchAll(PDO::FETCH_ASSOC);
      // var_dump($fetch);
      if($fetch){
        return $fetch;
      }
      else return null;
    }

    public function in_update($pr_id,$mb_id,$om_id,$in_hit) {
      // echo $pr_id."<br>";
      // echo $mb_id."<br>";
      // echo $om_id."<br>";
      // echo $in_hit."<br>";
      $this->openDB();
      if($mb_id != 'null'){
        $query = $this->db->prepare("update $this->quTable set in_hit=:in_hit where pr_id=:pr_id and mb_id=:mb_id");
        $query -> bindValue(":mb_id", $mb_id, PDO::PARAM_INT);
      }else if($om_id != 'null'){
        $query = $this->db->prepare("update $this->quTable set in_hit=:in_hit where pr_id=:pr_id and om_id=:om_id");
        $query -> bindValue(":om_id", $om_id, PDO::PARAM_INT);
        echo "통과";
      }
      $query -> bindValue(":pr_id", $pr_id, PDO::PARAM_INT);
      $query -> bindValue(":in_hit", $in_hit, PDO::PARAM_INT);
      $query->execute();
    }

    public function in_delete($pr_id,$mb_id,$om_id) {
      $this->openDB();
      if($mb_id != 'null'){
        $query = $this->db->prepare("delete from $this->quTable where pr_id=:pr_id and mb_id=:mb_id");
        $query -> bindValue(":mb_id", $mb_id, PDO::PARAM_INT);
      }else if($om_id != 'null'){
        $query = $this->db->prepare("delete from $this->quTable  where pr_id=:pr_id and om_id=:om_id");
        $query -> bindValue(":om_id", $om_id, PDO::PARAM_INT);
      }
      $query -> bindValue(":pr_id", $pr_id, PDO::PARAM_INT);
      $query->execute();
    }




}
