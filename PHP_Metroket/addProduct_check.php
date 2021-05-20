<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once("modules/notification.php");
require_once("modules/db.php");


// Parameter
// 호선과 역 둘로 나눠서 호선 id 가져와야함
$line = Post('lines', null);
// echo $line;
$station = Post("station", null);
$title = Post('title', null);
$price = Post('price', null);
$price_checking = Post('price_checking', null);
$category = Post('category', null);
$mb = Post('mb', null);
$om = Post('om', null);
$explainText = Post('explainText', null);

$pr_id = Post('pr_ida', null);
$mb_id = Post('mb_ida', 'null');
$om_id= Post('om_ida', 'null');
$mode = Post("mode", null);
// Functions
// echo $line."<br>";
// echo $title."<br>";
// echo $price."<br>";
// echo $price_checking."<br>";
// echo $category."<br>";
// echo $explainText."<br>";
// echo $mb ? $mb : $om."<br>";
// echo $om."<br>";
// Process
// echo $mode;
if($mode == null){
  userGoto("모드가 넘어오지 않았습니다.","");
  exit;
}
if($line == null){
  userGoto("역 등록이 되지 않았습니다.","My_one_page.php");
  exit;
}
if($station == null){
  userGoto("역 등록이 되지 않았습니다.","My_one_page.php");
  exit;
}
if($title == null){
  userGoto("상품 제목이 등록 되지 않았습니다.","");
  exit;
}
if($category == null){
  userGoto("카테고리가 체크 되지 않았습니다.","");
  exit;
}
if($explainText == null){
  userGoto("제품 설명란이 등록 되지 않았습니다.","");
  exit;
}

try {

  //제품을 먼저 추가 하고 pr_id를 불러 이미지 추가해야
  if($mode == 'insert'){
  $productObj = new Product();
  $results = $productObj->Product_title_search($title,$om,$mb);
  // echo $pr_img_id."<br>";
  foreach ($results as $rows) {
    // echo $rows['pr_title']."<br>";
    if($rows['pr_title'] == $title){
      userGoto("이미 한번 입력된 제목 입니다.", "addProduct.php");
    }
  }
  $ftime = time();
  $pm = ($mb ? $mb : $om).$title."val".$ftime;
  // echo $pm;
  // echo $pr_img_id ;


    $productObj->Upload('', 0, ['ca_name'=>$category,'mb_id'=>$mb,'om_id'=>$om,'l_id'=>$line,'pr_station' => $station,'pr_title'=>$title,'pr_price'=>$price ,'pr_explanation'=>$explainText, 'pr_check'=>$price_checking,'pr_img_id'=>$pm, 'pr_block'=>'1']);
    $result = $productObj->ProductAll($title,$om,$mb);
    foreach ($result as $row) {
      $pr = $row['pr_img_id'];
    }

    if($pr) {
      // echo $pr."<br>";
      // echo count($_FILES['files']['name'])."<br>";
      for($i=0; $i<count($_FILES['files']['name']); $i++) {
        if($_FILES['files']['type'][$i] == 'image/jpeg' || $_FILES['files']['type'][$i] == 'image/png' || $_FILES['files']['type'][$i] == 'image/gif') {
          // echo $i."<br>";
          if($i == 0){
            $y = 'y';
            // echo $y;
          }else{
            $y = 'n';
            // echo $y;
          }
          $productIMG = new Primg();
          $productIMG->Upload('files', $i, ['pr_img_id'=>$pm, "main_check" => $y]);
        }
      }
    }
    userGoNow('My_one_page.php');
    exit;
  }
  if($mode == "modify"){

      if($pr_id && $mb_id && $om_id){

        $productObjs = new Product();
        $delIMG = new Primg();

        $ftime = time();
        $pm = ($mb_id ? $mb_id : $om_id).$title."val".$ftime;
        $productObjs->Modify($pr_id,$mb_id, $om_id,['ca_name'=>$category,'l_id'=>$line,'pr_station' => $station,'pr_title'=>$title,'pr_price'=>$price ,'pr_explanation'=>$explainText, 'pr_check'=>$price_checking,'pr_img_id'=>$pm, 'pr_block'=>'1']);

        if($_FILES['files']['name'][0] !== '') {

          $result = $productObjs->ProductAll($title,$om_id,$mb_id);
          foreach ($result as $row) {
            $pr = $row['pr_img_id'];
          }
          if($pr) {
            // echo $pr."<br>";
            // echo count($_FILES['files']['name'])."<br>";
            $img_del = $productObjs->Product_img_code($pr_id, $mb_id, $om_id);
            foreach ($img_del as $del) {
              $delIMG->Delete($del["pr_img_id"]);
            }
            for($i=0; $i<count($_FILES['files']['name']); $i++) {
              if($_FILES['files']['type'][$i] == 'image/jpeg' || $_FILES['files']['type'][$i] == 'image/png' || $_FILES['files']['type'][$i] == 'image/gif') {
                // echo $i."<br>";
                    if($i == 0){
                      $y = 'y';
                      // echo $y;
                    }else{
                      $y = 'n';
                      // echo $y;
                    }

                  $productIMG = new Primg();
                  $productIMG->Upload('files', $i, ['pr_img_id'=>$pm, "main_check" => $y]);
              }
            }
          }
        }
        userGoto('제품이 성공적으로 수정되었습니다.', 'My_one_page.php');
        exit;
      }else{
        echo "모든값이 넘어오지 않았어";
        exit;
      }
    }
  } catch (Exception $e) {
    echo $e->getMessage();
    exit;
  }


?>
