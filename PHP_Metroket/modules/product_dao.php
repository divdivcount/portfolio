<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/modules/module_protect.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/modules/db_dao.php');

class Product extends MetroDAO {
  protected $quTable = 'product';
  protected $quTableId = 'pr_id';

    public function ProductAll($title, $om, $mb) {
      // echo "-----------------------------"."<br>";
      // echo $title."<br>";
      // echo $om."<br>";
      // echo $mb."<br>";
      // echo "-----------------------------"."<br>";
      // 회원 출력
      if($om == ''){
        $om = 'null';
        // echo $om."<br>";
      }elseif($mb == ''){
        $mb = 'null';
        // echo $mb."<br>";
      }
      $this->openDB();
      $query = $this->db->prepare("select * from $this->quTable where pr_title = '$title' and mb_id=$mb or om_id = '$om' and pr_block = 1");
      $query -> bindValue(":title", $title, PDO::PARAM_STR);
      $query->execute();
      $fetch = $query->fetchAll(PDO::FETCH_ASSOC);
      if($fetch){
        return $fetch;
      }
      else return null;
    }
    public function Product_title_search($title, $om, $mb) {
      // echo "-----------------------------"."<br>";
      // echo $title."<br>";
      // echo $om."<br>";
      // echo $mb."<br>";
      // echo "-----------------------------"."<br>";
      if($om == ''){
        $om = 'null';
      }elseif($mb == ''){
        $mb = 'null';
      }
      $this->openDB();
      $query = $this->db->prepare("select * from $this->quTable where pr_title = '$title' and mb_id=$mb or om_id = '$om' and pr_block = 1");
      $query -> bindValue(":title", $title, PDO::PARAM_STR);
      $query->execute();
      $fetch = $query->fetchAll(PDO::FETCH_ASSOC);
      if($fetch){
        return $fetch;
      }
      else return null;
    }

    public function Product_img_code($pr_id, $mb, $om) {

      $this->openDB();
      if($mb != 'null' && $om == 'null'){
        $query = $this->db->prepare("select p.pr_img_id from product p where pr_id = :pr_id and mb_id=:mb and om_id is null and pr_block = 1");
        $query -> bindValue(":mb", $mb, PDO::PARAM_INT);
      }elseif($mb == 'null' && $om != 'null'){
        $query = $this->db->prepare("select p.pr_img_id from product p where pr_id = :pr_id and om_id=:om and mb_id is null and pr_block = 1");
        $query -> bindValue(":om", $om, PDO::PARAM_INT);
      }
      $query -> bindValue(":pr_id", $pr_id, PDO::PARAM_INT);
      $query->execute();
      $fetch = $query->fetchAll(PDO::FETCH_ASSOC);
      if($fetch){
        return $fetch;
      }
      else return null;
    }

    public function Product_update_search($pr_id, $mb, $om) {

      $this->openDB();
      if($mb != 'null' && $om == 'null'){
        $query = $this->db->prepare("select p.pr_id,p.ca_name,p.l_id,p.pr_station,p.pr_title,p.pr_price,p.pr_explanation,p.pr_check,group_concat(pi.pr_img) as pr_img from product p left outer join product_img pi on pi.pr_img_id = p.pr_img_id where pr_id = :pr_id and mb_id=:mb and om_id is null and pr_block = 1");
        $query -> bindValue(":mb", $mb, PDO::PARAM_INT);
      }elseif($mb == 'null' && $om != 'null'){
        $query = $this->db->prepare("select p.pr_id,p.ca_name,p.l_id,p.pr_station,p.pr_title,p.pr_price,p.pr_explanation,p.pr_check,group_concat(pi.pr_img) as pr_img from product p left outer join product_img pi on pi.pr_img_id = p.pr_img_id where pr_id = :pr_id and om_id=:om and mb_id is null and pr_block = 1");
        $query -> bindValue(":om", $om, PDO::PARAM_INT);
      }
      $query -> bindValue(":pr_id", $pr_id, PDO::PARAM_INT);
      $query->execute();
      $fetch = $query->fetchAll(PDO::FETCH_ASSOC);
      if($fetch){
        return $fetch;
      }
      else return null;
    }
    // 거래 완료 작성중
    public function Product_status_update($pr_id, $mb_id, $om_id,$date) {
      // 회원 정보 1명 찾기
      $this->openDB();
      $query = $this->db->prepare("update product set pr_status = '거래완료' where pr_id = :pr_id");
      $query->bindValue(":pr_id", $pr_id, PDO::PARAM_INT);
      $query->execute();
      // var_dump($query);
      $query = $this->db->prepare("
        select
         p.pr_id,
         p.pr_title,
         pi.pr_img,
        (select count(i.in_hit) from interest i where i.pr_id = p.pr_id) as i_count,
         p.pr_station,
         p.pr_price,
         p.pr_status
        from
          product p
          left join product_img pi ON p.pr_img_id = pi.pr_img_id
          left join line l ON p.l_id = l.l_id
          left join interest ia on ia.pr_id = p.pr_id
        where
          pi.main_check = 'y'
          and pr_block = 1
          and p.pr_id = :pr_id
      ");
      $query->bindValue(":pr_id", $pr_id, PDO::PARAM_INT);
      $query->execute();

      while ($fetch = $query->fetch(PDO::FETCH_ASSOC)) {
        $status = $fetch['pr_status'];
        echo $status;
        if($status === '거래완료') {
          $query = $this->db->prepare("insert into product_history values (null, :pr_id,'{$fetch['pr_title']}' ,'{$fetch['pr_img']}',{$fetch['i_count']},'{$fetch['pr_station']}','{$fetch['pr_price']}','{$fetch['pr_status']}',:mb_id,:om_id,:date) ");
          $query->bindValue(":pr_id", $pr_id, PDO::PARAM_INT);
          $query->bindValue(":mb_id", $mb_id, PDO::PARAM_STR);
          $query->bindValue(":om_id", $om_id, PDO::PARAM_INT);
          $query->bindValue(":date", $date, PDO::PARAM_STR);
        }
      }
        $query->execute();
      var_dump($query);
    }

    public function Product_block_update($pr_id, $gap) {
      // 회원 정보 1명 찾기
      $this->openDB();
      $query = $this->db->prepare("update product set pr_block = :gap where pr_id = :pr_id");
      $query->bindValue(":pr_id", $pr_id, PDO::PARAM_INT);
      $query->bindValue(":gap", $gap, PDO::PARAM_INT);
      $query->execute();
    }



    public function admin_product_list_detail($mb_id,$om_id,$pr_id) {
      $this->openDB();
  		// echo "--------------------------------<br>";
  		// echo $mb_id."<br>";
  		// echo $om_id."<br>";
  		// echo $p_id."<br>";
  		// echo $p_title."<br>";
  		// echo "--------------------------------<br>";
      $query = $this->db->prepare(
  "select
  	count(member_declaration.pr_id) as rep_count,
    product.pr_id,
    product.pr_check,
    product.om_id,
    product.mb_id,
    product_img.pr_img,
    product.l_id,
  	case
      when member.mb_num is not null
      then member.line_station
      when oauth_member.om_id is not null
      then oauth_member.line_station
      else null
    end as profile_station,
  	case
      when member.mb_num is not null
      then member.mb_num
      when oauth_member.om_id is not null
      then oauth_member.om_id
      else null
    end as profile_id,
    case
      when member.mb_num is not null
      then member.mb_name
      when oauth_member.om_id is not null
      then oauth_member.om_nickname
      else null
    end as profile_name,
    case
      when member.mb_num is not null
      then member.mb_image
      when oauth_member.om_id is not null
      then oauth_member.om_image_url
      else null
    end as profile_img,
    product.pr_title,
    product.ca_name,
    product.pr_status,
  	product.pr_block,
    product.pr_price,
    count(interest.in_hit=1) as i_count,
    count(case
      when myAccountInfo.myAccountType='mb'
      then interest.mb_id
      when myAccountInfo.myAccountType='om'
      then interest.om_id
      else null
    end=myAccountInfo.myID) as mem_i_check,
    product.pr_explanation,
    myAccountInfo.myAccountType,
    myAccountInfo.myID
  from
    product left join
    (select
      product_img.pr_img_id,
      group_concat(product_img.pr_img) as pr_img
    from
      product_img
    group by
      product_img.pr_img_id
    ) as product_img on
      product.pr_img_id=product_img.pr_img_id left join
      member_declaration on
  	product.pr_id = member_declaration.pr_id left join
    member on
      product.mb_id=member.mb_num left join
    oauth_member on
      product.om_id=oauth_member.om_id left join
    (select
      interest.pr_id,
      interest.mb_id,
      interest.om_id,
      interest.in_hit
    from
      interest
    ) as interest on
      interest.pr_id=product.pr_id,
    (select
      :accountID as myID,
      :accountType as myAccountType
    ) as myAccountInfo
  where
    product.pr_id=:pr_id
  group by
    product.pr_id"
  		);
      $query -> bindValue(":pr_id", $pr_id, PDO::PARAM_INT);
  		if($mb_id !== 'null') {
  			$query -> bindValue(":accountType", 'mb', PDO::PARAM_STR);
  			$query -> bindValue(":accountID", $mb_id, PDO::PARAM_INT);
  		} else if($om_id !== 'null') {
  			$query -> bindValue(":accountType", 'om', PDO::PARAM_STR);
  			$query -> bindValue(":accountID", $om_id, PDO::PARAM_INT);
  		} else {
  			$query -> bindValue(":accountID", null, PDO::PARAM_INT);
  			$query -> bindValue(":accountType", null, PDO::PARAM_STR);
  		}
      $query->execute();
      $fetch = $query->fetchAll(PDO::FETCH_ASSOC);
  		// var_dump($fetch);
      if($fetch){
        return $fetch;
      }
      else return null;
    }

    public function admin_product_del($pr_id) {
      $this->openDB();
      $query = $this->db->prepare("select pr_img_id from product where pr_id=:id");
      $query->bindValue(":id", $pr_id, PDO::PARAM_INT);
      $query->execute();
      $fetch = $query->fetch(PDO::FETCH_ASSOC);
      // var_dump($fetch);

      $query = $this->db->prepare("select pr_img from product_img where pr_img_id=:id");
      $query->bindValue(":id", $fetch['pr_img_id'], PDO::PARAM_STR);
      $query->execute();
      while ($fetch = $query->fetch(PDO::FETCH_ASSOC)) {
        $fname = $fetch['pr_img'];
        // var_dump($fname);
        if($fname != '') {
          if(file_exists("files/".$fname)) {
            // echo "삭제";
            unlink("files/".$fname);
          }
        }
      }

      $query = $this->db->prepare("delete from $this->quTable where pr_id=:id");
      $query->bindValue(":id", $pr_id, PDO::PARAM_STR);
      $query->execute();

    }

    //페이지 내이션
    	public function admin_SelectPageLength($cPage, $viewLen, $mb_id, $om_id, $s_value= null) {
  			$this->openDB();
  		    if($mb_id == 'null' && $om_id == 'null'){
    				if(empty($s_value) == true){
    					$query = $this->db->prepare("select count(*) from $this->quTable where pr_block = 2 ");
    					// var_dump($query);
    				}else{
    					$query = $this->db->prepare("select count(*) from product p left join line l ON p.l_id = l.l_id where concat(pr_title,pr_station,l_name) like :s_value and pr_block = 2 order by pr_id");
    					$query->bindValue(":s_value", "%$s_value%",  PDO::PARAM_STR);
    					// var_dump($query);
    				}
  			}
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

  	public function admin_SelectPageList($cPage, $viewLen, $mb_id, $om_id, $s_value = null) {
  		$this->openDB();
  		$start = ($cPage * $viewLen) - $viewLen;
  		// echo $start."<br>";
  		// echo $viewLen;
  		// echo $mb_id;
  		// echo $om_id;
  			if($mb_id == 'null' && $om_id == 'null'){
  						if(empty($s_value) == true){
  							$sql = "select p.pr_id,p.pr_title,p.pr_date,(select count(i.in_hit) from interest i where i.pr_id = p.pr_id) as i_count,l.l_name,p.pr_station,(select count(rep_mb.pr_id) from member_declaration rep_mb where rep_mb.pr_id = p.pr_id) as rep_count from product p left outer join line l ON p.l_id = l.l_id where pr_block = 2 order by pr_id asc limit :start, :viewLen";
  							$query = $this->db->prepare($sql);
  						}else{
  							// echo "2??";
  							$sql = "select p.pr_id,p.pr_title,p.pr_date,(select count(i.in_hit) from interest i where i.pr_id = p.pr_id) as i_count,l.l_name,p.pr_station,(select count(rep_mb.pr_id) from member_declaration rep_mb where rep_mb.pr_id = p.pr_id) as rep_count from product p left join line l ON p.l_id = l.l_id where concat(p.pr_title,p.pr_station,l.l_name) like :s_value and pr_block = 2 order by pr_id asc limit :start, :viewLen";
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
  					}else{}

  		$query = $this->db->prepare($sql);
  		$query->bindValue(":start", $start, PDO::PARAM_INT);
  		$query->bindValue(":viewLen", $viewLen, PDO::PARAM_INT);
  		$query->bindValue(":mb_id", $mb_id,  PDO::PARAM_STR);
  		$query->bindValue(":om_id", $om_id,  PDO::PARAM_STR);
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
}
  ?>
