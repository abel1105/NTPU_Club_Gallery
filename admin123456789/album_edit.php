<?php require_once('../connection/connntpu.php'); ?>
<?php require_once('../connection/ftp.php'); ?>
<?
//inc
include("../function/admin_function.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>社團相簿管理系統</title>
    <link href="../lib/bootstrap-3.3.5-dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../lib/nprogress/nprogress.css" rel="stylesheet">
    <link href="../css/admin.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="../lib/nprogress/nprogress.js"></script>
    <script src="../lib/jquery.confirm/jquery.confirm.min.js"></script>
    <script src="../js/check_form_function.js"></script>
  </head>
  <body>
    <div id="topNav">
      <div class="logo">
        <a data-pjax href="control.php?status=control">
          <img src="../image/back logo.png">
        </a>
      </div>
      <div class="loginbar">
        <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
        <span class="hello"><? echo "您好".$_SESSION["loginMember"]; ?></span>
        &nbsp;&nbsp;
        <a href="?logout=true">
          <button class="m_button">登出系統</button>
        </a>
      </div>
    </div>
    <div id="sideNav">
      <div class="club_type">
        <div class="club_type_title">
          <span class="control">
            <a data-pjax href="control.php?status=control">控制台</a>
          </span>
        </div>
      </div>
      <?
        while($row_result1 = mysql_fetch_assoc($result1)){
      ?>
        <div class="club_type">
          <div class="club_type_title">
            <span class="club_type_span"><? echo $row_result1["ct_name"]; ?></span>
          </div>
          <ul class="club" style="display: none;">
            <?
            $sql_query2 = "SELECT * FROM `club` WHERE c_type = '".$row_result1['ct_number']."' ";
            $result2 = mysql_query($sql_query2);
            while($row_result2 = mysql_fetch_assoc($result2)){ ?>
            <li class="club_<? echo $row_result2["c_number"]; ?>">
              <a data-pjax href="album_type.php?club_number=<? echo $row_result2["c_number"]; ?>"><? echo $row_result2["c_name"]; ?></a>
            </li>
            <? } ?>
          </ul>
        </div>
      <? } ?>
    </div>
    <div id="wrap">
      <div class="content container">
        <div class="row">
          <div class="col-md-12">
            <div class="widget">
              <table width="100%"  border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td>
                    <p>現在位置：
                      <? echo $row_result_func1['ct_name'] ." > ". $row_result_func1['c_name'] ." > " .$row_result_func5['at_name'] ." > ". $row_result_func10['p_name']; ?>
                    </p>
                  </td>
                </tr>
              </table>
            </div>
            <div class="widget">
              <div style="text-align: center;">
                <img src="../image/<?echo $row_result_func1['ct_code']?>/<?echo $row_result_func1['c_number'] ?>/<? echo $row_result_func10['album_type_number'] ?>/<? echo $row_result_func10['filename']?>" style=" max-width: 100%; height: 300px; padding: 10px; object-fit: contain;"/>
              </div>
              <form action="" method="post" name="edit_photo_form" onsubmit="return check_form();">
                <table width="100%">
                  <tr align="center" >
                    <td width="30%" height="29" align="right" >相片名稱：</td>
                    <td width="70%" align="left">
                      <input name="p_name" type="text" id="p_name" value="<?echo $row_result_func10['p_name'] ?>" size="40"/>
                    </td>
                  </tr>
                  <tr align="center">
                    <td height="29" align="right">功能：</td>
                    <td align="left">
                      <input class="s_button" name="add" type="submit" id="add" value="修改" title="修改此筆資料" />
                      <input class="e_button" name="reset" type="reset" id="reset" value="重設" title="重設此頁資料" />
                      <input class="b_button" name="back" type="button" id="back" value="回上頁" title="回到上一頁" onclick="history.go(-1)" />
                    </td>
                  </tr>
                </table>
                <input type="hidden" name="update" value="edit" />
                <input type="hidden" name="status" value="photo" />
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div id="footer">
      <span class="copyright">Copyright © 2015&nbsp;·&nbsp;</span>
      <a href="https://www.facebook.com/chiling.lee.75" target="_blank" title="Abel Lee">Abel Lee&nbsp; ·&nbsp; </a>
      <span class="site">國立臺北大學&nbsp;學務處課外活動指導組&nbsp;社團相簿管理系統</span>
    </div>
  </body>
  <script src="../lib/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
  <script src="../lib/imagesloaded/imagesloaded.pkgd.min.js"></script>
  <script src="../lib/pjax/jquery.pjax.js"></script>
  <script src="../js/app.js"></script>
  <script>
    $('ul.club li.club_<? echo $club_number ?>').addClass('active');
    <? if(isset($_GET['club_number'])){ ?>
    $('div.club_type_title:eq(<? echo $row_result_func1['ct_number'] ?>)').parent().children('ul').toggle();
    $('div.club_type_title:eq(<? echo $row_result_func1['ct_number'] ?>)').children('span.club_type_span').addClass('collapsed');
    <? } ?>
  </script>
</html>
