<?php
  set_include_path('/home/www/www/ns-home/htdocs/ntpuwww/admin/a8/org/a8-2/www/gallery');
  require_once("connection/connntpu.php");
  require_once("lib/json/json.php");
  $json = new Services_JSON();
//  $ct = $_GET['ct'];
  $c = $_GET['c'];
  $id = $_GET['id'];
//  if($ct != ''){
//    $sql1 = "SELECT `ct_show` FROM `club_type` WHERE `ct_number` = '$ct'";
//    $result1 = mysql_query($sql1);
//    $row_result1 = mysql_fetch_assoc($result1);
//    if($row_result1['ct_show'] == '0'){
//      $sql2 = "UPDATE `club_type` SET `ct_show` = 1 WHERE `ct_number` = '$ct'";
//    }else {
//      $sql2 = "UPDATE `club_type` SET `ct_show` = 0 WHERE `ct_number` = '$ct'";
//    }
//    mysql_query($sql2);
//  }
  if($c != ''){
    $sql0 = "SELECT DISTINCT `club_number` FROM `photo`";
    $result0 = mysql_query($sql0);
    $i = 0;
    while($row_result0 = mysql_fetch_assoc($result0)){
      $photo_club[$i] = $row_result0 ;
      $i++; 
    }
    $j = 0;
    $length = count($photo_club);
    foreach($photo_club as $item){
      if(isset($item['club_number']) && $item['club_number'] == $c ){
        $sql1 = "SELECT `c_show` FROM `club` WHERE `c_number` = '$c'";
        $result1 = mysql_query($sql1);
        $row_result1 = mysql_fetch_assoc($result1);
        if($row_result1['c_show'] == '0'){
          $sql2 = "UPDATE `club` SET `c_show` = 1 WHERE `c_number` = '$c'";
        }else {
          $sql2 = "UPDATE `club` SET `c_show` = 0 WHERE `c_number` = '$c'";
        }
        mysql_query($sql2);
        break;
      }else if ($j == $length - 1){
        $data['alert'] = 'yes';
      }
      $j++;
    }

  }
  $data['id'] = $id ;
  echo $json->encode( $data );
?> 