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
    <? include_once('../function/amchart/amchart.php') ?> 
  </head>
  <body class="color">
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
            <span id="spot_ct_<? echo $row_result1['ct_number']?>" class="spot <? if($row_result1["ct_show"]==0){echo noactive;}else{echo active;}?>"  onclick="pushSpotStatus('<? echo $row_result1['ct_number']?>','',this.id)"></span>
          </div>
          <ul class="club" style="display: none;">
            <?
            $sql_query2 = "SELECT * FROM `club` WHERE c_type = '".$row_result1['ct_number']."' ";
            $result2 = mysql_query($sql_query2);
            while($row_result2 = mysql_fetch_assoc($result2)){ ?>
            <li class="club_<? echo $row_result2["c_number"]; ?>">
              <a data-pjax href="album_type.php?club_number=<? echo $row_result2["c_number"]; ?>"><? echo $row_result2["c_name"]; ?></a>
              <span id="spot_c_<? echo $row_result2['c_number']?>" class="spot <? if($row_result2["c_show"]==0){echo noactive; }else{echo active;}?>" onclick="pushSpotStatus('', '<? echo $row_result2['c_number']?>',this.id)"></span> 
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
              <table width="100%">
        				<tbody>
        					<tr>
        						<td>
        							<p class="page_path">現在位置：<? echo $row_result_func1['ct_name'] ." > ". $row_result_func1['c_name'] ." > ".$row_result_func5['at_name'] ?></p>
                      <div class="ftr">
                        <? if ($page_num != 1){ ?>
                          <a data-pjax href="album.php?club_number=<? echo $club_number ?>&album_number=<? echo $album_number ?>&status=photo&page=<? echo $page_num - 1 ?>"><button class="p_button">上一頁</button></a>
                        <? } ?>
                        &nbsp;&nbsp;
                        <? if($page_num < $total_pages){?>
                          <a data-pjax href="album.php?club_number=<? echo $club_number ?>&album_number=<? echo $album_number ?>&status=photo&page=<? echo $page_num + 1 ?>" ><button class="p_button">下一頁</button></a>
                        <? } ?>
                      </div>
        						</td>
        					</tr>
        					<tr>
        						<td>
                      <div class="squared_check ftl">
                        <input type="checkbox" name="all_select" id="all_select" onclick="select_all(this, 'select_photo[]')" title="選擇/取消 全部檔案" >全選
                        <label for="all_select"></label>
                      </div>
        							&nbsp;&nbsp;
                      <a data-pjax href="album_type.php?club_number=<? echo $club_number ?>"><button class="b_button">返回</button></a>
                      &nbsp;&nbsp;
                      <a data-pjax href="album_add.php?club_number=<? echo $club_number ?>&album_number=<?echo $album_number ?>&status=add"><button class="s_button">新增</button></a>
                      &nbsp;&nbsp;
        							<input class="e_button confirm" type='button' value="刪除"/>
        							<sapn style="float: right; font-size: 15px; margin-top: 5px;">共<? echo $total_records ?>項資料，目前顯示第 <?echo $page_num ?> 頁，共<?echo $total_pages ?>頁 </span>
        						</td>
        					</tr>
        				</tbody>
  			      </table>
            </div>
            <div class="widget">
      				<form id="form_delete" method="post" action="" name="form_delete" style="margin: 5px;" onsubmit="return check_form_photo_delete();">
        				<? while(  $row_result_func7 = mysql_fetch_assoc($result_func7)){ ?>
        					<div class="grid">
                    <span class="glyphicon glyphicon-eye-open" aria-hidden="true" style="width: 0; height: 0;"></span>
        						<img name="<?echo $row_result_func7['p_name'] ?>" src="../image/<?echo $row_result_func1['ct_code']?>/<?echo $row_result_func1['c_number'] ?>/<? echo $row_result_func7['album_type_number'] ?>/<? echo $row_result_func7['filename']?>" style=" max-height: 160px; max-width: 100%; padding: 10px; /*object-fit: contain;*/"/>
        							<input type="checkbox" name="select_photo[]" class="select_photo" title="選擇/取消 檔案" value="<? echo $row_result_func7['p_number'] ?>" />
        							<i><? if( mb_strlen($row_result_func7['p_name'],"utf-8")>=9){echo mb_substr($row_result_func7['p_name'],0,9,"utf-8").'...'; }else{echo $row_result_func7['p_name'];} ?> </i>
        						<a data-pjax href="album_edit.php?club_number=<?echo $club_number ?>&album_number=<? echo $album_number?>&photo_number=<? echo $row_result_func7['p_number'] ?>&status=edit">
        							<input class="o_button" type="button" value="修改" />
        						</a>
        					</div>
        				<? } ?>
                <input type="hidden" name="page" value="<? echo $page_num ?>"/>
      				</form>
      			</div>
          </div>
		    </div>
      </div>
      
      
      <script>
      $(".confirm").confirm({
        text: "您確定要刪除勾選的照片? 照片一但刪除就不可復原。",
        confirm: function() {
          $('#form_delete' ).submit();
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
