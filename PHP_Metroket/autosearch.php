<?php
require_once("modules/db.php");
$ajax = Post("optVal",null);
    $return_arr = array();
    if($ajax != 'all'){
      $sql = "select l.l_name, s.s_name from line l left outer join station s on l.l_id = s.l_id where l.l_id = $ajax";
    }else{
      $sql = "select l.l_name, s.s_name from line l left outer join station s on l.l_id = s.l_id";
    }
    $result = mysqli_query($conn, $sql);
    while($row = mysqli_fetch_assoc($result)){
        $return_arr[] =  $row['s_name'];
    }
    echo json_encode($return_arr, JSON_UNESCAPED_UNICODE);
    mysqli_close($conn);
?>
