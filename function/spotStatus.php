<?php
  set_include_path('/home/www/www/ns-home/htdocs/ntpuwww/admin/a8/org/a8-2/www/gallery');
  require_once("connection/connntpu.php");
  
  $ct = $_GET['ct'];
  $c = $_GET['c'];
  if($ct != ''){
    $sql1 = "SELECT `ct_show` FROM `club_type` WHERE `ct_number` = '$ct'";
    $result1 = mysql_query($sql1);
    $row_result1 = mysql_fetch_assoc($result1);
    if($row_result1['ct_show'] == '0'){
      $sql2 = "UPDATE `club_type` SET `ct_show` = 1 WHERE `ct_number` = '$ct'";
    }else {
      $sql2 = "UPDATE `club_type` SET `ct_show` = 0 WHERE `ct_number` = '$ct'";
    }
    mysql_query($sql2);
  }
  if($c != ''){
    $sql1 = "SELECT `c_show` FROM `club` WHERE `c_number` = '$c'";
    $result1 = mysql_query($sql1);
    $row_result1 = mysql_fetch_assoc($result1);
    if($row_result1['c_show'] == '0'){
      $sql2 = "UPDATE `club` SET `c_show` = 1 WHERE `c_number` = '$c'";
    }else {
      $sql2 = "UPDATE `club` SET `c_show` = 0 WHERE `c_number` = '$c'";
    }
    mysql_query($sql2);
  }



?> 