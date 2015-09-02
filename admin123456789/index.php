<?php require_once('../connection/connntpu.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
if (!isset($_SESSION["loginMember"]) || ($_SESSION["loginMember"]==""))
{
	if(isset($_POST["username"]) && isset($_POST["passwd"])){
		$sql_query = "SELECT * FROM `admin`";
		$result = mysql_query($sql_query);
		while($row_result = mysql_fetch_assoc($result)){
      $username = $row_result["username"];
      $passwd = $row_result["passwd"];
      if(($_POST["username"]==$username) && (md5($_POST["passwd"]) == $passwd)) {
        $_SESSION["loginMember"]=$username;
        header("Location: control.php?status=control"); 
        break;
      }else{
  //      header("Location: index.php");
        echo "<script type='text/javascript'>alert('錯誤帳號或密碼');</script>";
        //break;
      }
    }
	}
}else{
	header("Location: control.php?status=control");
}
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <link href="../lib/bootstrap-3.3.5-dist/css/bootstrap.min.css" rel="stylesheet">
    <style type="text/css">
    input[type='text'], input[type='password']{
      border: 0px;
      background-color: #E48396;
      margin: 5px;
      color: #fff;
      height: 30px;
      font-family: 'futura';
      font-size: 21px;
      padding: 10px;
      width: 180px;
    }
    input:-webkit-autofill, textarea:-webkit-autofill, select:-webkit-autofill {
      background-color: #E48396 !important;
      color: #fff !important;
    }
    input.s_button{
      border: none;
      width: 55px;
      height: 30px;
      border-radius: 11px;
      color: #fff;
      -webkit-transition: background-color 0.2s;
      -o-transition: background-color 0.2s;
      transition: background-color 0.2s;
    }
    input.s_button, button.s_button {
      background-color: #26A69A;
    }
    input.s_button:hover , button.s_button:hover {
      background-color: #004D40;
    }
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="../js/check_form_function.js"></script>
	</head>
	<body style="background-color: #282C34; background-size: cover;">
		<div id="main">
			<div id="container" style="position: fixed;top: 0;bottom: 0;left: 0; right: 0;">
				<div id="form" style="height: 100%; margin: 0 auto; text-align: center;">
					<img style="max-width: 100%; margin: 0 auto; margin-top: 50px; max-height: 60%" src="../image/back_logo.png">
					<form id="form_login" name="form_login" method="post" action="" style="margin: 20px 40px 10px 40px;">
            <div style="margin: 0 auto; max-width: 200px;">
              <input type="text" name="username" id="username" class="login_text" style="width: 100%; margin: 0 auto;"/>
  						<input type="password" name="passwd" id="passwd" class="login_text" style="margin: 15px auto; width:100%"/>
  						<input class="s_button" id="btn_login" type="submit" value="登入" style="margin: 30px 0;">
            </div>
          </form>
				</div>
			</div>
		</div>
	</body>
  <script src="../lib/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
</html>
