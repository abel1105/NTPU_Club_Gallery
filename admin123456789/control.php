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
    <script src="../lib/jquery_cookie/jquery.cookie.js"></script>
    <? include_once('../function/amchart/amchart.php') ?> 
  </head>
  <body class="color" style="display:none;">
    <div id="topNav">
      <div class="logo">
        <a data-pjax href="control.php?status=control">
          <img src="../image/back_logo.png">
        </a>
      </div>
      <div class="loginbar">
        <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
        <span class="hello"><? echo "您好".$_SESSION["loginMember"]; ?></span>
        &nbsp;&nbsp;
        <a class="toolbox" href="#" data-toggle="popover" data-placement="bottom">
          <span class="glyphicon glyphicon-wrench" aria-hidden="true"></span>
        </a>
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
              <span id="spot_c_<? echo $row_result2['c_number']?>" class="spot <? if($row_result2["c_show"]==0){echo noactive; }else{echo active;}?>" onclick="pushSpotStatus('<? echo $row_result2['c_number']?>',this.id)"></span> 
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
            <? if(isset($_GET['admin'])) { ?>
              <? if($_GET['admin'] == '1') { ?>
                <div class="widget" style="background-color: rgba(38,166,154,0.5);">
                  <? echo "新增社團成功" ?>
                </div>
              <? } elseif($_GET['admin'] == '0') { ?>
                <div class="widget" style="background-color: rgba(244,67,54,0.5);">
                  <? echo "新增社團失敗"; ?>
                </div>
              <? } elseif($_GET['admin'] == '2') { ?>
                <div class="widget" style="background-color: rgba(38,166,154,0.5);">
                  <? echo "刪除社團成功"; ?>
                </div>
              <? } elseif($_GET['admin'] == '3') { ?>
                <div class="widget" style="background-color: rgba(244,67,54,0.5);">
                  <? echo "刪除社團失敗"; ?>
                </div>
              <? } ?>
            <? } ?>
            <div class="widget">
              <form method="post" name="create_club" onsubmit="return check_form_add_club();">
                <b class="title">新增社團</b>
                &nbsp;&nbsp;
                <span>社團名稱：</span>
                <input id="c_name" type="text" name="c_name">
                &nbsp;&nbsp;
                <span>社團分類：</span>
                <select id="c_type" name="c_type">
                  <option value="">-----社團分類 -----</option>
                  <option value="1">音樂性社團</option>
                  <option value="2">康樂性社團</option>
                  <option value="3">學藝性社團</option>
                  <option value="4">體育性社團</option>
                  <option value="5">服務性社團</option>
                  <option value="6">學生自治組織</option>
                  <option value="7">校友會</option>
                </select>
                &nbsp;&nbsp;
                <input class="s_button" type="submit" value="新增"/>
                <input type="hidden" name="insert" value="add" />
                <input type="hidden" name="status" value="club" />
              </form>
              <form name="delete_club" action="" method="post" onsubmit="return check_form_delete_club();">
                <b class="title">刪除社團</b>
                &nbsp;&nbsp;
                <span>社團名稱：</span>
                <select id="club_name" name="c_number">
                  <option value="">-----請選擇欲刪除的社團名稱 -----</option>
                  <? while($row_result3 = mysql_fetch_assoc($result3)){ ?>
                    <optgroup label="<? echo $row_result3["ct_name"]; ?>">
                      <?
                      $sql_query4 = "SELECT * FROM `club` WHERE c_type = '".$row_result3['ct_number']."'";
                      $result4 = mysql_query($sql_query4);
                      while($row_result4 = mysql_fetch_assoc($result4)){ ?>
                        <option value="<? echo $row_result4["c_number"]; ?>" label="<? echo $row_result4["c_name"]; ?>"><? echo $row_result4["c_name"]; ?></option>
                      <? } ?>
                    </optgroup>
                  <? } ?>
                </select>
                &nbsp;&nbsp;
                <input class="e_button confirm" type="submit" value="刪除" />
                <input type="hidden" name="insert" value="delete" />
                <input type="hidden" name="status" value="club" />
              </form>
            </div>
          </div>
          <div class="col-md-4">
            <div class="widget tac">
              <b class="title">前五大社團上傳照片數</b>
              <div id="topchart"></div>
            </div>
          </div>
          <div class="col-md-8">
            <div class="widget tac">
              <b class="title">一星期訪客數</b>
              <div id="visitchart"></div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="widget tac">
              <b class="title">一星期新舊訪客比率</b>
              <div id="return_newchart"></div>
            </div>
          </div>
          <div class="col-md-8">
            <div class="widget tac">
              <b class="title">一星期彈出率與新工作階段率</b>
              <div id="bouncechart"></div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="widget tac">
              <b class="title">一個月瀏覽裝置比率</b>
              <div id="devicechart"></div>
            </div>
          </div>
        </div>
      </div>
      <? include_once('../function/amchart/bounce.php') ?>
      <? include_once('../function/amchart/top.php') ?>
      <? include_once('../function/amchart/return&new.php') ?>
      <? include_once('../function/amchart/visit.php') ?>
      <? include_once('../function/amchart/device.php') ?>
      <script>
      $(".confirm").confirm({
        text: "您確定要刪除該社團? 該社團底下的照片跟資料庫都會一併消失，不可復原。",
        confirm: function() {
          $( "form:eq(1)" ).submit();
        },
        cancel: function() {
          // nothing to do
        },
        confirmButton: "確定",
        cancelButton: "取消",
        confirmButtonClass: "btn-danger",
        cancelButtonClass: "btn-default",
      });
      </script>
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
