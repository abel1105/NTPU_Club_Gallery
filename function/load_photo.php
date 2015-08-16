<?php
  set_include_path('/home/www/www/ns-home/htdocs/ntpuwww/admin/a8/org/a8-2/www/gallery');
  require_once("lib/json/json.php");
  require_once("connection/connntpu.php");
  header("Content-Type: application/json", true);
  $json = new Services_JSON();

  $p = $_GET['p'];
  $at = $_GET['at'];
  $data = array();
  $sql_query1 = "SELECT * FROM `photo` WHERE `album_type_number` =  '$at'";
  $result1 = mysql_query($sql_query1);
  while ($row_result_func1 = mysql_fetch_array($result1, MYSQL_NUM)){
    $data[] = $row_result_func1;
  }
  echo $json->encode($data);
?>
