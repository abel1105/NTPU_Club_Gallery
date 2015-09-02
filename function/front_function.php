
<?
set_include_path('/home/www/www/ns-home/htdocs/ntpuwww/admin/a8/org/a8-2/www/gallery');
require_once('connection/connntpu.php');
require_once("lib/json/json.php");
$json = new Services_JSON();
//show menu
$sql_query1 = "SELECT * FROM `club_type`";
$result1 = mysql_query($sql_query1);
$result3 = mysql_query($sql_query1);
// get params
$query  = explode('&', $_SERVER['QUERY_STRING']);
if(isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING'] != ''){
  $params = array();

  foreach( $query as $param )
  {
    list($name, $value) = explode('=', $param, 2);
    if($name == '_pjax'){
    }else{
      $params[urldecode($name)][] = urldecode($value);
    }
  }
//  print_r($params);
}
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
  $sql_query2 = "SELECT DISTINCT `c_type` FROM `club` WHERE `c_show` = 1 ";
  $result2 = mysql_query($sql_query2);
  $j =0;
  while($row_result2 = mysql_fetch_assoc($result2)){
    $club_data[$j] = $row_result2;
    $j++;
  }
  foreach ($club_data as $item){
    if (isset($item['c_type']) && $item['c_type'] == $i){
      return true;
    }
  }
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
// [搜尋]
if (isset($params['c']) && ($params['c'] != '')){
  $count_c = count($params['c']);
  for($i =0; $i < $count_c; $i++){
    // function 4 查看club number對應的社團名子
    $sql_func4[$i] = "SELECT * FROM `club` WHERE `c_number` = '". $params['c'][$i] . "'";
    $result_func4[$i] = mysql_query($sql_func4[$i]);
    $row_result_func4[$i] = mysql_fetch_assoc($result_func4[$i]);
    //function 5 查看 社團下 有多少相簿 然後各取一筆資料
    $sql_func5[$i] = "SELECT * FROM ( SELECT * FROM `photo` WHERE `album_type_number` IN ( SELECT DISTINCT `album_type_number` FROM `photo` WHERE `club_number` = '".$params['c'][$i] . "') ORDER BY RAND( ) ) AS T GROUP BY `album_type_number` ORDER BY `time` DESC";
    $result_func5[$i] = mysql_query($sql_func5[$i]);
  }
}
if (isset($params['ct'][0]) && ($params['ct'][0] != '')){
  //function 7 查看社團類別下的社團 
  $sql_func7 = "SELECT * FROM(SELECT * FROM `photo` WHERE `album_type_number` in (SELECT `at_number` FROM `album_type` WHERE `club_number` in ( SELECT `c_number` FROM `club` WHERE `c_type`= ". $params['ct'][0] ." and `c_show` = 1)) ORDER BY RAND())as T GROUP BY `album_type_number` ORDER BY `time` DESC";
  
  $result_func7 = mysql_query($sql_func7);
}

//function 8 [搜尋]查詢開放的社團分類下開放的社團
$sql_func8 = "SELECT * FROM `club`,`club_type` WHERE `c_show` = 1 and `ct_number` = `c_type` ORDER BY `ct_number` ASC";
$result_func8 = mysql_query($sql_func8);
$i = 0;
while($row_result_func8 = mysql_fetch_assoc($result_func8)){
  $available_club[$i] = $row_result_func8 ;
  $i++;
};

//function 9 [搜尋]查詢開放的社團分類下開放的社團的社團活動
$sql_func9 = "SELECT `c_number`,`c_show`,`c_name`,`at_number`,`at_name` FROM `club`,`album_type`,`club_type` WHERE `album_type`.`club_number` = `club`.`c_number` and `ct_number` = `c_type` and `c_show` = 1 ORDER BY `c_number` ASC";
$result_func9 = mysql_query($sql_func9);
$i = 0;
while($row_result_func9 = mysql_fetch_assoc($result_func9)){
  $available_album_type[$i] = $row_result_func9 ;
  $i++;
};
//[搜尋]
if (isset($params['at']) && ($params['at'] != '')){
  $count_at = count($params['at']);
  for($i =0; $i < $count_at; $i++){
    // function 10 查看album number 對應的一個隨機photo
    $sql_func10[$i] = "SELECT * FROM `photo` WHERE `album_type_number` = '". $params['at'][$i] . "' ORDER BY RAND() LIMIT 0,1";
    $result_func10[$i] = mysql_query($sql_func10[$i]);
    
  }
}
//[搜尋]
if (isset($params['start']) && ($params['start'] != '') && isset($params['end']) && ($params['end'] != '')){
  // function 11 查看album的最後修改時間
  $sql_func11 = "SELECT `at_number` FROM `album_type`, `club` WHERE `album_type`.`club_number` = `club`.`c_number` and `c_show` = 1 and `album_type`.`time` BETWEEN '".$params['start'][0]."' AND '".$params['end'][0]." 23:59:59'";
  $result_func11 = mysql_query($sql_func11);
  $i = 0;
  while($row_result_func11 = mysql_fetch_assoc($result_func11)){
    $time_at[$i] = $row_result_func11;
    $i++;
  }
  $count_time_at = count($time_at);
  for($i =0; $i < $count_time_at; $i++){
    // function 12 查看album number 對應的一個隨機photo
    $sql_func12[$i] = "SELECT * FROM `photo` WHERE `album_type_number` = '". $time_at[$i]['at_number'] . "' ORDER BY RAND() LIMIT 0,1";
    $result_func12[$i] = mysql_query($sql_func12[$i]);
  }
}
?>


