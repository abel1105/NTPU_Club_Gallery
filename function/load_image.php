<?
set_include_path('/home/www/www/ns-home/htdocs/ntpuwww/admin/a8/org/a8-2/www/gallery');
require_once("lib/json/json.php");
header("Content-Type: application/json", true);
$json = new Services_JSON();

$hostname_connntpu = "www.cdc.ntpu.edu.tw";
$database_connntpu = "gallery"; //ntpuextra
$username_connntpu = "abel"; //ntpuextra //career
$password_connntpu = "528941"; //ntpu66212 //cdc520
$connntpu = mysql_connect($hostname_connntpu, $username_connntpu, $password_connntpu);
mysql_select_db($database_connntpu, $connntpu) or die("Couldn't Create Database: $database_connntpu");
mysql_query("set names utf8");

function loadimage($start, $count){
  $sql = "SELECT `c_number` FROM `club` WHERE `c_show` = 1";
    $result_sql = mysql_query($sql);
    $c_number = '';
    $i = 1;
    while($row_result = mysql_fetch_assoc($result_sql)){
      if ($i == 1){
        $i++;
      }else{
        $c_number .= ", ";
      }
      $c_number .= $row_result['c_number'];
    }
    $sql_func1 = "SELECT * FROM ( SELECT * FROM `photo` WHERE `club_number` in ($c_number) ORDER BY `time` DESC LIMIT $start, $count ) AS T2, `album_type` WHERE `at_number` = `album_type_number` ORDER BY RAND()";
    $result_func1 = mysql_query($sql_func1);
  return $result_func1;
}
$data = array();
if (isset($_GET['start']) && isset($_GET['count'])){
  $start = intval($_GET['start']);
  $count = intval($_GET['count']);
  $result_func1 = loadimage($start, $count);
  while ($row_result_func1 = mysql_fetch_array($result_func1, MYSQL_NUM)){
    $data[] = $row_result_func1;
  }
  //$data = utf8_encode( $data);
  echo $json->encode($data);
}
?>
