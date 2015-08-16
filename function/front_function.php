
<?
set_include_path('/home/www/www/ns-home/htdocs/ntpuwww/admin/a8/org/a8-2/www/gallery');
require_once('connection/connntpu.php');
require_once("lib/json/json.php");
$json = new Services_JSON();
//show menu
$sql_query1 = "SELECT * FROM `club_type`";
$result1 = mysql_query($sql_query1);
$result3 = mysql_query($sql_query1);
//color function
function selectcolor($e){
  if ($e % 7 == 0) {  echo "#E6546A"; }
  elseif ($e % 7 == 1) { echo "#DF3854"; }
  elseif ($e % 7 == 2) { echo "#F26D47"; }
  elseif ($e % 7 == 3) { echo "#E85C5D"; }
  elseif ($e % 7 == 4) { echo "#D22F15"; }
  elseif ($e % 7 == 5) { echo "#ED657B"; }
  elseif ($e % 7 == 6) { echo "#ED9BAB"; }
}
// 判斷社團類別下的社團有沒有show
function showct($i) {
    $sql_query2 = "SELECT `ct_show` FROM `club_type` WHERE `ct_number` = '$i'";
    $result2 = mysql_query($sql_query2);
    $row_result2 = mysql_fetch_assoc($result2);
    return $row_result2['ct_show'];
}
// 判斷現在社團類別 並給予顏色
function activect($i) {
    if($_GET['ct'] == $i ){
        echo " active";
    }
}

// function 1 loadimage
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
    $sql_func1 = "SELECT * FROM ( SELECT * FROM `photo` WHERE `club_number` in ($c_number) ORDER BY `time` DESC LIMIT $start, $count ) AS T2 ORDER BY RAND()";
    $result_func1 = mysql_query($sql_func1);
    return $result_func1;
  }
if (isset($_GET['start']) && isset($_GET['count'])){
  $start = intval($_GET['start']);
  $count = intval($_GET['count']);
   $result_func1 = loadimage($start, $count);
   $data = array();
   while ($row_result_func1 = mysql_fetch_array($result_func1, MYSQL_NUM)) {
     $data[] = $row_result_func1;
   }
   return $result_func1;//$json->encode( $data );
}
if (isset($_GET['p']) && ($_GET['p'] != '')){
  // function 2 依點選的相片去選取相片
  $sql_func2 = "SELECT * FROM `photo` WHERE `p_number`= '". $_GET['p'] ."'";
  $result_func2 = mysql_query($sql_func2);
  $row_result_func2 = mysql_fetch_assoc($result_func2);
  // function 3 選取 點選照片後 該相簿裡的其他相片
  $sql_func3 ="SELECT * FROM `photo` WHERE `album_type_number` = '". $row_result_func2['album_type_number']."' ";
  $result_func3 = mysql_query($sql_func3);
  // function 6 選取 活動名稱 對應相片
  $sql_func6 = "SELECT `at_name` FROM `album_Type` WHERE `at_number` = '". $row_result_func2['album_type_number']."' ";
  $result_func6 = mysql_query($sql_func6);
  $row_result_func6 = mysql_fetch_assoc($result_func6);
  
}

if (isset($_GET['c']) && ($_GET['c'] != '')){
  // function 4 查看club number對應的社團名子
  $sql_func4 = "SELECT * FROM `club` WHERE `c_number` = '". $_GET['c'] . "'";
  $result_func4 = mysql_query($sql_func4);
  $row_result_func4 = mysql_fetch_assoc($result_func4);
  //function 5 查看 社團下 有多少相簿 然後各取一筆資料
  $sql_func5 = "SELECT * FROM ( SELECT * FROM `photo` WHERE `album_type_number` IN ( SELECT DISTINCT `album_type_number` FROM `photo` WHERE `club_number` = '".$_GET['c'] . "') ORDER BY RAND( ) ) AS T GROUP BY `album_type_number` ORDER BY `time` DESC";
  $result_func5 = mysql_query($sql_func5);
}
if (isset($_GET['ct']) && ($_GET['ct'] != '')){
  //function 7 查看社團類別下的社團 
  $sql_func7 = "SELECT * FROM(SELECT * FROM `photo` WHERE `album_type_number` in (SELECT `at_number` FROM `album_type` WHERE `club_number` in ( SELECT `c_number` FROM `club` WHERE `c_type`= ". $_GET['ct'] ." and `c_show` = 1)) ORDER BY RAND())as T GROUP BY `album_type_number` ORDER BY `time` DESC";
  
  $result_func7 = mysql_query($sql_func7);
}
?>
