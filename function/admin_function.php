<?php require_once('../connection/connntpu.php'); ?>
<?php require_once('../connection/ftp.php'); ?>
<?php
//setting
session_start();
if (!isset($_SESSION["loginMember"]) || ($_SESSION["loginMember"]=="")){
	header("Location: index.php");
}
if(isset($_GET['logout']) && ($_GET['logout'] == 'true')){
	unset($_SESSION['loginMember']);
	header("Location: index.php");
}
$actual_link = "$_SERVER[REQUEST_URI]";
$club_number=$_GET['club_number'];
$album_number=$_GET['album_number'];
$photo_number=$_GET['photo_number'];

//function 0 sideNav
$sql_query1 = "SELECT * FROM `club_type`";
$result1 = mysql_query($sql_query1);
$result3 = mysql_query($sql_query1);
//function 1 社團類別 與 社團
if(isset($_GET['club_number'])){
  $sql_func1 = "SELECT * FROM `club_type`, `club` WHERE `club_type`.`ct_number` = `club`.`c_type`  AND `club`.`c_number` = $club_number";
  $result_func1 = mysql_query($sql_func1);
  $row_result_func1 = mysql_fetch_assoc($result_func1);
}
//function 2 相簿類別 選取與社團一樣的
if(isset($_GET['club_number'])){
	//setting
	$page_max_records = 10; //預設每頁10筆
	$page_num = 1; //預設為第一頁
	if(isset($_GET["page"])){  //如果有翻頁 更新頁面
		$page_num = $_GET["page"];
	}
	$page_start_records = ($page_num - 1) * $page_max_records; //本頁開始筆數
	//SQL
  $sql_func2 = "SELECT `at_number`, `at_name`, `club_number`, `sort` FROM `album_type` WHERE `club_number` = $club_number ORDER BY `sort` DESC";
  $result_func2 = mysql_query($sql_func2);
  //function 3 限制頁面相簿比數
  if(isset($page_start_records) && isset($page_max_records)){
    $sql_func3 = "$sql_func2 LIMIT  $page_start_records , $page_max_records ";
    $result_func3 = mysql_query($sql_func3);
    $total_records = mysql_num_rows($result_func2); //總筆數
    $total_pages = ceil($total_records/$page_max_records); //總頁面
  }
}

//function 4 刪除相簿
if(isset($_POST['select_album_type']) && count($_POST['select_album_type']) > 0 ) {
  $delete_items  = "'";
	$delete_items .= implode("','" , $_POST['select_album_type']);
	$delete_items .= "'";
  $sql_func4 = "DELETE FROM `album_type` WHERE `at_number` in (  $delete_items )";
  $result_func4 = mysql_query($sql_func4);
  // 刪除整個相簿包含相片
  foreach ($_POST['select_album_type'] as $value) {
      require_once('../connection/ftp.php');
      $dir = "/www/gallery/image/".$row_result_func1['ct_code']."/$club_number/$value";
      // function 11 delete photo info in mysql
      $sql_func11 = "DELETE FROM `photo` Where `album_type_number` = $value";
      mysql_query($sql_func11);
      echo $dir;
      @ftp_chdir($conn, $dir);
      $files = ftp_nlist($conn, ".");
      foreach ($files as $file)
      {
        @ftp_delete($conn, $file);
      }
      @ftp_rmdir($conn, $dir);
  }
	if($result_func4 == false){
		$admin_status = 2;
	}else{
		$admin_status = 3;
	}
  header("Location: album_type.php?club_number=$club_number&status=$admin_status");
  exit;
}

//function 5 修改相簿
if(isset($_GET['club_number']) && ($_GET['status'] == 'edit' || $_GET['status'] == 'photo' || $_GET['status'] == 'add') ){
  $sql_func5 = "SELECT `at_number`, `at_name`, `at_club`, `club_number`, `sort` FROM `album_type` WHERE `at_number` = $album_number ";
  $result_func5 = mysql_query($sql_func5);
  $row_result_func5 = mysql_fetch_assoc($result_func5);
}

//function 6 瀏覽相簿後台照片
if(isset($_GET['album_number']) && $_GET['status'] == 'photo' ){
	//setting
	$page_max_records = 8;
	$page_num = 1; //預設為第一頁
	if(isset($_GET["page"])){  //如果有翻頁 更新頁面
		$page_num = $_GET["page"];
	}
	$page_start_records = ($page_num - 1) * $page_max_records; //本頁開始筆數
	//SQL
  $sql_func6 = "SELECT * FROM `photo` WHERE `album_type_number` = $album_number ORDER BY `time` DESC";
  $result_func6 = mysql_query($sql_func6);
	$total_records = mysql_num_rows($result_func6); //總筆數
	$total_pages = ceil($total_records/$page_max_records); //總頁面
  // function 7 限制照片數
  $sql_func7 = "$sql_func6 LIMIT  $page_start_records , $page_max_records ";
  $result_func7 = mysql_query($sql_func7);
}

//function 8 刪除照片
if(isset($_POST['select_photo']) && count($_POST['select_photo']) > 0 ) {
  $delete_items  = "'";
	$delete_items .= implode("','" , $_POST['select_photo']);
	$delete_items .= "'";
  $sql_func8 = "SELECT `p_number`, `filename` FROM `photo` WHERE `p_number` in ( $delete_items ) ";
  $result_func8 = mysql_query($sql_func8);
  while ($row_result_func8= mysql_fetch_assoc($result_func8)){
    //LOCAL版 $delete_path = "../image/" . $row_result_func1['ct_code'] ."/". $row_result_func1['c_number'] . "/" . $album_number ."/". $row_result_func8['filename'];
    //$delete_path = mb_convert_encoding($delete_path, 'big5', 'UTF-8'); // utf8化
    //LOCAL版 unlink($delete_path);
    $delete_path = "/www/gallery/image/" . $row_result_func1['ct_code'] ."/". $row_result_func1['c_number'] . "/" . $album_number ."/". $row_result_func8['filename'];
    //thumb
    $delete_thumb_path = "/www/gallery/image/" . $row_result_func1['ct_code'] ."/". $row_result_func1['c_number'] . "/" . $album_number ."/thumb/". $row_result_func8['filename'];
    //delete
    ftp_delete($conn, $delete_path);
    ftp_delete($conn, $delete_thumb_path);
  }
  // function 9 刪除後台資料庫
  $sql_func9 = "DELETE FROM `photo` WHERE `p_number` in (  $delete_items )";
  $Result1 = mysql_query($sql_func9);
	if($Result1 == false){
		$admin_status = 0;
	}else{
		$admin_status = 1;
	}
  header("Location: album.php?club_number=$club_number&album_number=$album_number&status=photo&page=". $_POST['page']."&admin=$admin_status");
  exit;
}
// function 10 修改照片名稱
if(isset($_GET['photo_number']) && $_GET['status']== 'edit'){
  $sql_func10 = "SELECT * FROM `photo` where `p_number` = $photo_number ";
  $result_func10 = mysql_query($sql_func10);
  $row_result_func10 = mysql_fetch_assoc($result_func10);
}
//function 12 新增相片

//如果沒有資料夾 自動產生樹狀資料夾
/*LOCAL版
function mkdir_tree($dir_path)
{
  $arr = explode('/',$dir_path);
  for($i = 0;$i<count($arr);$i++)
  {
    $path.=$arr[$i].'/';
    if(!is_dir($path))
    { mkdir($path); }
  }
}
*/
if(isset($_FILES['files'])){
  //LOCAL版// $file_path = "../image/".$row_result_func1['ct_code']."/".$row_result_func1['c_number']."/".$album_number."/";
  $file_path = "/www/gallery/image/".$row_result_func1['ct_code']."/".$row_result_func1['c_number']."/".$album_number."/";
  $thumb_path = "/www/gallery/image/".$row_result_func1['ct_code']."/".$row_result_func1['c_number']."/".$album_number."/thumb/";
  //$path = mb_convert_encoding($path, 'big5', 'UTF-8'); // utf8化
  $errors= array();
	$file_number = 1;
  function ImageResize (&$src, $x, $y) {
    $dst=imagecreatetruecolor($x, $y);
    $pals=ImageColorsTotal ($src);

    for ($i=0; $i<$pals; $i++) {
      $colors=ImageColorsForIndex ($src, $i);
      ImageColorAllocate ($dst, $colors['red'], $colors['green'], $colors['blue']);
    }

    $scX =(imagesx ($src)-1)/$x;
    $scY =(imagesy ($src)-1)/$y;
    $scX2 =intval($scX/2);
    $scY2 =intval($scY/2);

    for ($j = 0; $j < ($y); $j++) {
      $sY = intval($j * $scY);
      $y13 = $sY + $scY2;
      for ($i = 0; $i < ($x); $i++) {
        $sX = intval($i * $scX);
        $x34 = $sX + $scX2;
        $c1 = ImageColorsForIndex ($src, ImageColorAt ($src, $sX, $y13));
        $c2 = ImageColorsForIndex ($src, ImageColorAt ($src, $sX, $sY));
        $c3 = ImageColorsForIndex ($src, ImageColorAt ($src, $x34, $y13));
        $c4 = ImageColorsForIndex ($src, ImageColorAt ($src, $x34, $sY));
        $r = ($c1['red']+$c2['red']+$c3['red']+$c4['red'])/4;
        $g = ($c1['green']+$c2['green']+$c3['green']+$c4['green'])/4;
        $b = ($c1['blue']+$c2['blue']+$c3['blue']+$c4['blue'])/4;
        ImageSetPixel ($dst, $i, $j, ImageColorClosest ($dst, $r, $g, $b));
      }
    }
    return ($dst);
  }
  foreach($_FILES['files']['tmp_name'] as $key => $tmp_name ){
    $file_name = $_FILES['files']['name'][$key];
    $file_size =$_FILES['files']['size'][$key];
    $file_tmp =$_FILES['files']['tmp_name'][$key];
    $file_type=$_FILES['files']['type'][$key];
    $file_format = strrchr($file_name,"."); //取得副檔名
    $code_file_name = "AT".gmdate("YmdHis",time()+28800).rand(11,999); //產生亂數檔名
//    $headers = get_headers($file_tmp, 1);
    switch ($file_type)
    {
        case 'image/jpeg':
             $src = imagecreatefromjpeg($file_tmp);
        break;
        case 'image/gif':
             $src = imagecreatefromgif($file_tmp);
        break;
        case 'image/png':
             $src = imagecreatefrompng($file_tmp);
        break;
        default:
            die('不支援這種檔案類型');
    }
//    $src = imagecreatefromjpeg($_FILES['files']['tmp_name'][$key]);
    // get the source image's widht and hight
    $x = imagesx($src);
    $y = imagesy($src);
    if($file_size > 2097152){
      $errors[]='檔案請小於2MB';
    }
    if(empty($errors)==true){
      // assign thumbnail's widht and hight
      if($x > $y){
        $thumb_w = 500;
        $thumb_h = intval($y / $x * 500);
      }else{
        $thumb_h = 500;
        $thumb_w = intval($x / $y * 500);
      }
      $thumb = imagecreatetruecolor($thumb_w, $thumb_h);
      imagecopyresized($thumb, $src, 0, 0, 0, 0, $thumb_w, $thumb_h, $x, $y);
      imagejpeg($thumb, "/tmp/".$thumb_file_name.'.jpg');
 //     imagejpeg(ImageResize($src, $x, $y), "/tmp/".$thumb_file_name.'.jpg');
      if(@ftp_chdir($conn, $file_path)==false || @ftp_chdir($conn, $thumb_path)==false){  //LOCAL版if(is_dir($path)==false)
        //LOCAL版  mkdir_tree($file_path); //呼叫 產生樹狀資料夾
        @ftp_mkdir($conn, "/www/gallery/image/".$row_result_func1['ct_code']);
        @ftp_mkdir($conn, "/www/gallery/image/".$row_result_func1['ct_code']."/".$row_result_func1['c_number']);
        @ftp_mkdir($conn, "/www/gallery/image/".$row_result_func1['ct_code']."/".$row_result_func1['c_number'] . "/".$album_number);
        @ftp_mkdir($conn, "/www/gallery/image/".$row_result_func1['ct_code']."/".$row_result_func1['c_number'] . "/".$album_number."/thumb");
      }
      //LOCAL//move_uploaded_file($file_tmp,"$file_path/".$code_file_name.$file_format); //以電腦亂數檔名上傳
      if (ftp_put($conn, "$file_path/".$code_file_name.$file_format , $file_tmp , FTP_ASCII) and ftp_put($conn, "$file_path/"."thumb/".$code_file_name.$file_format , "/tmp/".$thumb_file_name.'.jpg' , FTP_ASCII)) {
        $imgurl= "../image/".$row_result_func1['ct_code']."/".$row_result_func1['c_number']."/".$album_number."/".$code_file_name.$file_format;
				$admin_status .= "<div class='grid'><img src='$imgurl' style='max-width: 100%; max-height: 160px; padding: 10px; /*object-fit: contain;*/'/>";
				$admin_status .= "檔案". $file_number ."成功上傳</div>";
				$file_number++;
      } else {
        $admin_status .= "檔案". $file_number ."上傳失敗</br>";
				$file_number++;
      }
      // MYSQL
      if ((isset($_POST["insert"])) && ($_POST["insert"] == "add")) {
        $insertSQL = "INSERT INTO `photo` (`p_number`, `p_name`, `p_club`, `p_code`, `club_number`, `album_type_number`, `filename`, `time`) VALUES (NULL," . "'".$file_name."'," . "'".$_POST['p_club']."', '".$_POST['p_code']."', '".$_POST['club_number'] . "','" . $_POST['album_type_number'] . "','". $code_file_name.$file_format . "', CURRENT_TIMESTAMP)";
				mysql_query($insertSQL) or die(mysql_error());
      }
    }else{
			$admin_status .= "<div class='grid'>檔案".$file_number."請小於2MB</div>";
			$file_number++;
		}
	}
}
//function 13 update album
if ((isset($_POST["update"])) && ($_POST["update"] == "edit") && ($_POST["status"] == "album")) {
  $updateSQL = "UPDATE `album_type` SET at_name='" . $_POST['at_name']."',at_club='".$_POST['at_club']."', club_number='" .$_POST['club_number'] . "',time= CURRENT_TIMESTAMP, sort='". $_POST['sort'] . "' WHERE at_number ='". $album_number . "'";

  $Result1 = mysql_query($updateSQL) or die(mysql_error());
	if($Result1 == false){
		$admin_status = 4;
	}else{
		$admin_status = 5;
	}

  $updateGoTo = "album_type.php?club_number=$club_number&status=$admin_status";
  header(sprintf("Location: %s", $updateGoTo));
}
//function 14 update photo
if ((isset($_POST["update"])) && ($_POST["update"] == "edit") && ($_POST["status"] == "photo")) {
  $updateSQL = "UPDATE `photo` SET p_name='" . $_POST['p_name']."' WHERE p_number ='". $photo_number . "'";

  $Result1 = mysql_query($updateSQL) or die(mysql_error());

 	$updateGoTo = "album.php?club_number=$club_number&album_number=$album_number&photo_number=$photo_number&status=photo";
	header(sprintf("Location: %s", $updateGoTo));
}
//function 15 album_type_add
if ((isset($_POST["insert"])) && ($_POST["insert"] == "add") && ($_POST["status"] == "album")) {
  $insertSQL = "INSERT INTO `album_type` (`at_number`, `at_name`, `at_club`, `club_number`, `time`, `sort`) VALUES (NULL," . "'".$_POST['at_name']."'," . "'".$_POST['at_club']."'," . "'".$_POST['club_number'] . "'," . "CURRENT_TIMESTAMP, '". $_POST['sort'] . "')";

  $Result1 = mysql_query($insertSQL) or die(mysql_error());
  if($Result1 == false){
		$admin_status = 0;
	}else{
		$admin_status = 1;
	}
  $insertGoTo = "album_type.php?club_number=".$club_number."&status=".$admin_status;
  header(sprintf("Location: %s", $insertGoTo));
}
// function 16 get differnece 社團 照片數 -> control.php
if ($_GET['status'] == 'control'){
	$sql_func16 = "SELECT count( `p_number` ) , `p_club` FROM `photo` GROUP BY `club_number` ORDER BY count( `p_number` ) DESC LIMIT 5";
	$result_func16 = mysql_query($sql_func16) or die(mysql_error());
}
//function 17 add club
if ((isset($_POST["insert"])) && ($_POST["insert"] == "add") && ($_POST["status"] == "club")) {
  $insertSQL = "INSERT INTO `club` (`c_number`, `c_name`, `c_type`, `time`) VALUES (NULL," . "'".$_POST['c_name']."'," . "'".$_POST['c_type']."',". "CURRENT_TIMESTAMP )";

  $Result1 = mysql_query($insertSQL) or die(mysql_error());
  if($Result1 == false){
		$admin_status = 0;
	}else{
		$admin_status = 1;
	}
  $insertGoTo = "control.php?status=control&admin=$admin_status";
  header(sprintf("Location: %s", $insertGoTo));
}
//function 18 19 20 21 delete club
if ((isset($_POST["insert"])) && ($_POST["insert"] == "delete") && ($_POST["status"] == "club")) {
	$club_number = $_POST['c_number'];
	//確認 c_type & ct_code
	$sql_func18 = "SELECT * FROM `club_type`, `club` WHERE `club_type`.`ct_number` = `club`.`c_type`  AND `club`.`c_number` = $club_number";
	$result_func18 = mysql_query($sql_func18);
	$row_result_func18 = mysql_fetch_assoc($result_func18);
	$club_type = $row_result_func18['c_type'];
	$ct_code = $row_result_func18['ct_code'];
	//查看 album_type 資料庫有沒有該 club 的相簿
	$sql_func19 = "SELECT `at_number` FROM `album_type` WHERE `club_number` = '$club_number'";
	$result_func19 = mysql_query($sql_func19);
	while($row_result_func19 = mysql_fetch_assoc($result_func19)){
		$album_type_number[] = $row_result_func19['at_number'];
	}
	//刪除照片 in 資料庫 & 後端
	if (isset($album_type_number)){
		foreach ($album_type_number as $value) {
	      require_once('../connection/ftp.php');
	      $dir = "/www/gallery/image/$ct_code/$club_number/$value";
	      // function 11 delete photo info in mysql
	      $sql_func11 = "DELETE FROM `photo` Where `album_type_number` = $value";
	      mysql_query($sql_func11);
	      echo $dir;
	      ftp_chdir($conn, $dir);
	      $files = ftp_nlist($conn, ".");
	      foreach ($files as $file)
	      {
	        ftp_delete($conn, $file);
	      }
	      ftp_rmdir($conn, $dir);
	  }
		$club_dir = "/www/gallery/image/$ct_code/$club_number";
		ftp_rmdir($conn, $club_dir);
	}
	// 刪除 album_type 資料庫
	$sql_func20 = "DELETE FROM `album_type` WHERE `club_number` = '".$_POST['c_number'] ."'";
	$result_func20 = mysql_query($sql_func20);
	//刪除 club 資料庫
	$sql_func21 = "DELETE FROM `club` WHERE `c_number` = '".$_POST['c_number'] ."'";
	$Result1 = mysql_query($sql_func21);
	if($Result1 == false){
		$admin_status = 3;
	}else{
		$admin_status = 2;
	}
	$insertGoTo = "control.php?status=control&admin=$admin_status";
	header(sprintf("Location: %s", $insertGoTo));
}
?>
