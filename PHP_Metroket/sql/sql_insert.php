<?php
    $host = 'localhost';
    $user = 'metro';
    $pw = 'metro20210316';
    $dbName = 'metro';
    $mysqli = new mysqli($host, $user, $pw, $dbName);
    $insert = array('양촌', '구래', '마산', '장기', '운양', '걸포북변', '사우(김포시청)', '풍무', '고촌', '김초공항');

    if($mysqli){
        echo "MySQL 접속 성공";
        for($i = 0; $i <= count($insert)-1; $i++){
          $s = $insert[$i];
          $ic = "insert into station(`s_id`,`l_id`, `s_name`, `s_station_id`) values (null,23,'$s',0)";
          if (mysqli_query($mysqli, $ic)) {
            echo "New record created successfully\n";
          } else {
            echo "Error: " . $ic . "<br>" . mysqli_error($mysqli);
          }
        }
        mysqli_close($mysqli);
    }else{
        echo "MySQL 접속 실패";
    }
?>
