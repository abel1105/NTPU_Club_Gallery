<?php
require_once('connection/connntpu.php');

?>

        <?require_once("function/front_function.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<head>
    <title>臺北大學社團活動相簿</title>
    <meta property="og:title" content="臺北大學社團活動相簿" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="http://www.ntpu.edu.tw/extra/gallery/index.php"/>
    <meta property="og:image" content="http://www.ntpu.edu.tw/extra/gallery/image/back_logo.png" />
    <meta property="og:description" content="國立臺北大學 課外活動組 社團活動相簿網站" />
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <link href="lib/bootstrap-3.3.5-dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="lib/bootstrap-datapicker/css/bootstrap-datetimepicker.min.css">
		<link rel="stylesheet" type="text/css" href="lib/samsungGrid/normalize.css" />
		<link rel="stylesheet" type="text/css" href="lib/samsungGrid/component.css" />
		<link rel="stylesheet" type="text/css" href="lib/font-awesome-4.2.0/css/font-awesome.min.css" />
		<link rel="stylesheet" type="text/css" href="lib/off-canvasmenueffect/menu_sideslide.css" />
    <!-- gallery -->
		<link rel="stylesheet" type="text/css" href="lib/gallery/style.css" />
		<link rel="stylesheet" type="text/css" href="lib/gallery/elastislide.css" />
    <link rel="stylesheet" type="text/css" href="lib/jgallery/jgallery.min.css" />
		<link href="lib/nprogress/nprogress.css" rel="stylesheet">
    <!-- chosen -->
    <link rel="stylesheet" type="text/css" href="lib/chosen/chosen.css" />
		<link rel="stylesheet" type="text/css" href="css/front.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <!-- bootstrap -->
    <script src="lib/bootstrap-datapicker/js/moment-with-locales.min.js"></script>
    <script src="lib/bootstrap-3.3.5-dist/js/transition.js"></script>
    <script src="lib/bootstrap-3.3.5-dist/js/collapse.js"></script>
    <script src="lib/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
    <script src="lib/bootstrap-datapicker/js/bootstrap-datetimepicker.min.js"></script>
		<script src="lib/nprogress/nprogress.js"></script>
		<script src="lib/modernizr/modernizr.custom.js"></script>
    <!-- chosen -->
    <script src="lib/chosen/chosen.jquery.js"></script>
    <script src="lib/chosen/chosen.proto.js"></script>
		<script>
			(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
			(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
			m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
			})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

			ga('create', 'UA-65602649-1', 'auto');
			ga('send', 'pageview');

		</script>
		<!--[if IE]>
			<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->

        
		<!-- pjax -->
		<script src="lib/pjax/jquery.pjax.js"></script>
    <!-- gallery -->
    <script type="text/javascript" src="lib/jgallery/jgallery.js"></script>
    <script type="text/javascript" src="lib/jgallery/touchswipe.min.js"></script>
		<script src="js/front.js"></script>
    <script src="//load.sumome.com/" data-sumo-site-id="b5dce7256cabf394a582aa17c7c13cd6c876b3b99da8e932e5562ae33a53caa7" async="async"></script>
<!--    <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-55d7dd4a6316bc47" async="async"></script>-->
<?php 
  if(isset($_GET['p']) && ($_GET['p'] != '')){
    $bodyClass = "image";
  } else {
    $bodyClass = "front";
  } 
?>
	</head>
	<body class="night <?echo $bodyClass ?>"> 
<!--
		<div id="large-header" class="large-header">
			<canvas id="demo-canvas"></canvas>
		</div>
-->
		<div class="main">
			<div class="logo-wrap">
				<a data-pjax href="index.php">
					<img class="logo" src="image/back_logo.png">
				</a>
			</div>
			<div class="slideThree">
				<input type="checkbox" value="None" id="slideThree" name="check"/>
				<label for="slideThree" onclick="changeBodyColor();"></label>
			</div>
			<div id="container" class="container">
                <div class="club-wrap">
                    <img class="top_bar" src="image/bar00.png">
                    <? if( showct(1)) {?>
                    <a data-pjax href="index.php?ct=1">
                        <i class='fa fa-music<? activect(1) ?>' data-content="音樂性社團"></i>
                    </a>
                    <img class="top_bar" src="image/bar01.png">
                    <? } if( showct(2)) {?>
                    <a data-pjax href="index.php?ct=2">
                        <i class='fa fa-bullhorn<? activect(2) ?>' data-content="康樂性社團"></i>
                    </a>
                    <img class="top_bar" src="image/bar02.png">
                    <? } if( showct(3)) {?>
                    <a data-pjax href="index.php?ct=3">
                        <i class='fa fa-pencil<? activect(3) ?>' data-content="學藝性社團"></i>
                    </a>
                    <img class="top_bar" src="image/bar03.png">
                    <? } if( showct(4)) {?>
                    <a data-pjax href="index.php?ct=4">
                        <i class='fa fa-futbol-o<? activect(4) ?>' data-content="體育性社團"></i>
                    </a>
                    <img class="top_bar" src="image/bar04.png">
                    <? } if( showct(5)) {?>
                    <a data-pjax href="index.php?ct=5">
                        <i class='fa fa-heart<? activect(5) ?>' data-content="服務性社團"></i>
                    </a>
                    <img class="top_bar" src="image/bar05.png">
                    <? } if( showct(6)) {?>
                    <a data-pjax href="index.php?ct=6">
                        <i class='fa fa-users<? activect(6) ?>' data-content="學生自治組織"></i>
                    </a>
                    <img class="top_bar" src="image/bar06.png">
                    <? } if( showct(7)) {?>
                    <a data-pjax href="index.php?ct=7">
                        <i class='fa fa-glass<? activect(7) ?>'data-content="校友會"></i>
                    </a>
                    <img class="top_bar" src="image/bar07.png">
                    <? } ?>
                </div>
                <div class="club-title">
                    <h2>社團相片一覽</h2>
                </div>
				<section class="grid-wrap">
					<ul class="grid swipe-right" id="grid">
						<div class="loading-animation">
                            <svg width="70" height="70" viewBox="-70 -70 140 140" class="svg">
                              <circle r="37"></circle>
                              <circle r="0"></circle>
                            </svg>
						</div>
<!--
            <div class="load-anim">
              <div class="load-anim-icon">
              </div>
            </div>
-->
						<? if($_GET['ct'] != ''){  ?>
							<? while( $row_result_func7 = mysql_fetch_assoc($result_func7) ) {
								$p_number = $row_result_func7['p_number'];
								$at_number = $row_result_func7['album_type_number'];
								$c_number = $row_result_func7['club_number'];
								$p_code = $row_result_func7['p_code'];
								$filename = $row_result_func7['filename'];
								?>
                <li class="photo" id="photo_<?echo $p_number?>">
                  <a photo-pjax href="index.php?ct=<?echo $_GET['ct'] ?>&p=<?echo $p_number?>" style="border-color: <? selectcolor($at_number) ?>">
                    <div class="image" style="background-image: url('image/<?echo $p_code ?>/<? echo $c_number?>/<?echo $at_number?>/<? echo $filename ?>');" alt="test">
                      <img src="image/<?echo $p_code ?>/<? echo $c_number?>/<?echo $at_number?>/<? echo $filename ?>" style="width: 100%;">
                      <? $sql_func2 = "SELECT `at_club`, `at_name` FROM `album_type` WHERE `at_number` ='".$row_result_func7['album_type_number']."'";
                      $result_func2 = mysql_query($sql_func2);
                      $row_result_func2 = mysql_fetch_assoc($result_func2);
                      ?>
                      <h3 style="background: <? selectcolor($at_number) ?>"><?echo $row_result_func2['at_name']?></h3>
                      <span style="background: <? selectcolor($at_number) ?>"><? echo $row_result_func2['at_club']?></span>
                    </div>
                  </a>
                </li>
              <? } ?>
            <? } if (isset($params['at']) || isset($params['c']) || (isset($params['start']) && ($params['start'] != '') && isset($params['end']) && ($params['end'] != ''))) { ?>
              <? for($i =0; $i < $count; $i++){ ?>
                <? while( $row_result_func5[$i] = mysql_fetch_assoc($result_func5[$i]) ) {
                  $p_number[$i] = $row_result_func5[$i]['p_number'];
                  $at_number[$i] = $row_result_func5[$i]['album_type_number'];
                  $c_number[$i] = $row_result_func5[$i]['club_number'];
                  $p_code[$i] = $row_result_func5[$i]['p_code'];
                  $filename[$i] = $row_result_func5[$i]['filename'];
                  ?>
                  <li class="photo" id="photo_<?echo $p_number[$i]?>">
                    <a photo-pjax href="index.php?p=<?echo $p_number[$i]?>" style="border-color: <? selectcolor($at_number[$i]) ?>">
                      <div class="image" style="background-image: url('image/<?echo $p_code[$i] ?>/<? echo $c_number[$i]?>/<?echo $at_number[$i]?>/<? echo $filename[$i] ?>');" alt="test">
                        <img src="image/<?echo $p_code[$i] ?>/<? echo $c_number[$i]?>/<?echo $at_number[$i]?>/<? echo $filename[$i] ?>" style="width: 100%;">
                        <? $sql_func2[$i] = "SELECT `at_club`, `at_name` FROM `album_type` WHERE `at_number` ='".$row_result_func5[$i]['album_type_number']."'";
                        $result_func2[$i] = mysql_query($sql_func2[$i]);
                        $row_result_func2[$i] = mysql_fetch_assoc($result_func2[$i]);
                        ?>
                        <h3 style="background: <? selectcolor($at_number[$i]) ?>"><?echo $row_result_func2[$i]['at_name']?></h3>
                        <span style="background: <? selectcolor($at_number[$i]) ?>"><? echo $row_result_func2[$i]['at_club']?></span>
                      </div>
                    </a>
                  </li>
                <? } ?>
              <? } ?>
						<? }if( empty($params) || (count($params) == 0) || isset($params['p'])) { ?> 
              <? $result_func1 = loadimage(0, 30);
				        while( $row_result_func1 = mysql_fetch_assoc($result_func1) ) {
								$p_number = $row_result_func1['p_number'];
								$at_number = $row_result_func1['album_type_number'];
								$c_number = $row_result_func1['club_number'];
								$p_code = $row_result_func1['p_code'];
								$filename = $row_result_func1['filename'];
								?>
                <li class="photo" id="photo_<?echo $p_number?>" code="<?echo $p_code ?>" c="<? echo $c_number?>" at="<?echo $at_number?>" p="<?echo $p_number?>">
                  <a photo-pjax href="index.php?p=<?echo $p_number?>" style="border-color: <? selectcolor($at_number) ?>">
                    <div class="image" style="background-image: url('image/<?echo $p_code ?>/<? echo $c_number?>/<?echo $at_number?>/<? echo $filename ?>');" alt="test">
                      <img src="image/<?echo $p_code ?>/<? echo $c_number?>/<?echo $at_number?>/<? echo $filename ?>" style="width: 100%;">
                      <? $sql_func2 = "SELECT `at_club`, `at_name` FROM `album_type` WHERE `at_number` ='".$row_result_func1['album_type_number']."'";
                      $result_func2 = mysql_query($sql_func2);
                      $row_result_func2 = mysql_fetch_assoc($result_func2);
                      ?>
                      <h3 style="background: <? selectcolor($at_number) ?>"><?echo $row_result_func2['at_name']?></h3>
                      <span style="background: <? selectcolor($at_number) ?>"><? echo $row_result_func2['at_club']?></span>
                    </div>
                  </a>
                </li>
              <? } ?>
            <? } ?>
					</ul>
				</section>
        <div id="photo">
          <? if(isset($_GET['p']) && ($_GET['p'] != '')){ ?>
          <div id="gallery">
            <? while ( $row_result_func3 = mysql_fetch_assoc($result_func3) ) {
              $p_number = $row_result_func3['p_number'];
              $p_club = $row_result_func3['p_club'];
              $at_number = $row_result_func3['album_type_number'];
              $c_number = $row_result_func3['club_number'];
              $p_code = $row_result_func3['p_code'];
              $p_name = $row_result_func3['p_name'];
              $filename = $row_result_func3['filename'];
            ?>
            <a class="<? if( $_GET['p'] == $p_number){ echo 'active-photo'; }?>" href="image/<?echo $p_code ?>/<? echo $c_number?>/<?echo $at_number?>/<? echo $filename ?>" data="<? echo $p_number?>"><img  src="image/<?echo $p_code ?>/<? echo $c_number?>/<?echo $at_number?>/thumb/<? echo $filename ?>" alt="<?echo $p_club ?> &raquo; <?echo $row_result_func6['at_name']?>" /></a>
            <? } ?>

          </div>
          <script type="text/javascript">
          $( function() {
            $.when(
              $( '#gallery' ).jGallery({
                "autostartAtImage": $('a.active-photo').index()+1,
                canClose: true,
                height: $(window).height(),
                slideshowInterval: '3s',
                thumbnailsFullScreen: false,
                tooltipToggleThumbnails: '顯示/隱藏縮圖',
                tooltipZoom: '放大',
                tooltipSlideshow: '幻燈片',
                tooltipRandom: '隨機',
                tooltipClose: '關閉',
                tooltipFullScreen: '全螢幕',
                closeGallery: function() { 
                  $('body').attr('style', '');
                  $('.sumome-image-sharer').hide();
                  $('.sumome-share-client-wrapper').show();
                },
                showGallery: function() {
                  $('.sumome-image-sharer').show();
                  $('.sumome-share-client-wrapper').hide();
                }
              })
            ).then(function(){
              $('.fa.resize.jgallery-btn.jgallery-btn-small.fa-search-plus').addClass('hidden-xs');
              $('.fa.change-mode.jgallery-btn.jgallery-btn-small.fa-expand').addClass('hidden-xs');
              $('.fa.fa-th.full-screen.jgallery-btn.jgallery-btn-small').addClass('hidden-xs');
              $('body').css('overflow', 'hidden');
            });
          } );
            
          </script>
          <? } ?>
        </div>
        <script>
          $(document).on('ready pjax:end', function(){
            <?if($_GET['ct'] != ''){ ?>
                $('div.nav span.fa.fa-times.jgallery-close.jgallery-btn.jgallery-btn-small').wrap('<a photo-pjax href="index.php?ct=<?echo $_GET['ct']?>"></a>');
                console.log('ct');
              <? } elseif ( ($_GET['p'] != '') or $_SERVER['QUERY_STRING'] == ''){ ?>
                $('div.nav span.fa.fa-times.jgallery-close.jgallery-btn.jgallery-btn-small').wrap('<a photo-pjax href="index.php"></a>');
                console.log('p');
              <? }else { ?>
                $('div.nav span.fa.fa-times.jgallery-close.jgallery-btn.jgallery-btn-small').wrap('<a photo-pjax href="index.php?<?echo $_SERVER['QUERY_STRING']?>"></a>');
                console.log('query');
              <? } ?>
          });
        </script>
			</div><!-- /container -->
		<!-- gallery -->
      <div class="theme-config hidden-xs">
        <div class="theme-config-box">
          <div class="spin-icon">
            <i class="fa fa-search"></i>
          </div>
            <div class="skin-setttings">
              <div class="title">搜尋</div>
              <div class="setings-item">
                <form id="search" method="get" onsubmit="return checksearchform();">
                  <select class="search club_search form-control" name="c" data-placeholder="請選擇社團名稱" >
                    <option></option>
                    <?
                      function getct_name($element){ return $element['ct_name']; }
                      $ct_name = array_map('getct_name', $available_club);
                      $ct_count = array_count_values($ct_name);
                      $count = 0; 
                      foreach($available_club as $club_data){ 
                        if($count == 0) {
                          echo '<optgroup label="'.$club_data['ct_name'].'">';
                        }
                          echo '<option value="'.$club_data['c_number'].'">'.$club_data['c_name'].'</option>';
                          $count++;
                        if($ct_count[$club_data['ct_name']] == $count) {
                          echo '</optgroup>';
                          $count = 0;
                        }
                      } 
                    ?>
                  </select>
                  <p></p>
                  <select class="search activity_search form-control" name="at" data-placeholder="請選擇活動名稱" multiple>
                    <?
                      function getc_name($element){ return $element['c_name']; }
                      $c_name = array_map('getc_name', $available_album_type);
                      $c_count = array_count_values($c_name);
                      $count = 0; 
                      foreach($available_album_type as $album_type_data){ 
                        if($count == 0) {
                          echo '<optgroup label="'.$album_type_data['c_name'].'">';
                        }
                          echo '<option value="'.$album_type_data['at_number'].'">'.$album_type_data['at_name'].'</option>';
                          $count++;
                        if($c_count[$album_type_data['c_name']] == $count) {
                          echo '</optgroup>';
                          $count = 0;
                        }
                      } 
                    ?>
                  </select>
                  <p></p>
                  <input type='text' class="form-control" name='start' placeholder="最後修改起始日期" id='date1'/>
                  <p></p>
                  <input type='text' class="form-control" name='end' placeholder="最後修改結束日期" id='date2'/>
                  <button class="search_btn" type="submit">篩選</button>
                  <i class="reset" onclick='resetform()'>重置</i>
                </form>
              </div>          
            </div>
        </div>
    </div>
      <script>
        $(function(){
          $(".activity.search").chosen({no_results_text: "找不到您輸入的內容"});
          $(".club_search").chosen({no_results_text: "找不到您輸入的內容", allow_single_deselect: true});
          $('.spin-icon').click(function () {
            $(".theme-config-box").toggleClass("show");
          });
          $(".club_search").chosen().change(function(){
            if($('.club_search :selected').text() != ''){
              $('.activity_search optgroup').each(function(){
                if($(this).attr('label') != $('.club_search :selected').text()){
                  $(this).attr('disabled', '');
                }else{
                  $(this).removeAttr('disabled');
                }
              });
              $(".activity_search").trigger("chosen:updated");  
            }else {
              if($('.activity_search').val() == null){
                console.log('0');
                $('.club_search option').each(function(){
                  $(this).removeAttr('disabled');
                })
                $(".club_search").trigger("chosen:updated"); 
                $('.activity_search optgroup').each(function(){
                  $(this).removeAttr('disabled');
                });
                $(".activity_search").trigger("chosen:updated");
              }
            }
          });
          $(".activity_search").chosen().change(function(){
            if($('.activity_search').val() != null ){
              console.log($('.activity_search').val());
              $('.club_search option').each(function(){
                if($(this).text() != $('.activity_search :selected').closest('optgroup').attr('label')){
                  $(this).attr('disabled', '');
                }else{
                  $(this).removeAttr('disabled');
                }
              });
              $(".club_search").trigger("chosen:updated");  
              $('.activity_search optgroup').each(function(){
                if($(this).attr('label') != $('.activity_search :selected').closest('optgroup').attr('label')){
                  $(this).attr('disabled', '');
                }else{
                  $(this).removeAttr('disabled');
                }
              });
              $(".activity_search").trigger("chosen:updated");  
            }else {
              if($('.club_search').val() == null){
                console.log('00');
                $('.club_search option').each(function(){
                  $(this).removeAttr('disabled');
                });
                $('.activity_search optgroup').each(function(){
                  $(this).removeAttr('disabled');
                });
                $(".club_search").trigger("chosen:updated");
                $(".activity_search").trigger("chosen:updated");
              }
            }
          });
        })
        function checksearchform (){
          console.log($('.club_search').val());
          console.log($('.activity_search').val());
          console.log($('#date1').val());
          console.log($('#date2').val());
          var errorMsg = "";
          if($('#date1').val() != '' && $('#date2').val() == '' ){
            errorMsg += "\n請輸入結束日期";
          }
          if($('#date1').val() == '' && $('#date2').val() != '' ){
            errorMsg += "\n請輸入起始日期";
          }
          if(!$('.club_search').val() && !$('.activity_search').val() && !$('#date1').val() && !$('#date2').val()){
            errorMsg += "\n請輸入篩選條件";  
          }
          if (errorMsg == "") {
            $('#search').find('input').each(function() {
                var input = $(this);
                if (!input.val()) {
                  input.prop('disabled', true);
                }
            });
            $('#search').find('select').each(function() {
                var select = $(this);
                if (!select.val()) {
                  select.prop('disabled', true);
                }
            });
            return true;
          }
          else {
            alert(errorMsg);
            return false;
          }
        }
      </script>
      <script type="text/javascript">
            $(function () {
                $('#date1').datetimepicker({
                  locale: 'zh-tw',
                  format: 'YYYY-MM-DD'
                });
                $('#date2').datetimepicker({
                  locale: 'zh-tw',
                  format: 'YYYY-MM-DD',
                  useCurrent: false
                });
                $("#date1").on("dp.change", function (e) {
                  $('#date2').data("DateTimePicker").minDate(e.date);
                });
                $("#date2").on("dp.change", function (e) {
                  $('#date1').data("DateTimePicker").maxDate(e.date);
                });
                
            });
      </script>
		<!--

		<script src="lib/gallery/jquery.tmpl.min.js"></script>
		<script src="lib/gallery/jquery.easing.1.3.js"></script>
		<script src="lib/gallery/jquery.elastislide.js"></script>
		<script src="lib/gallery/gallery.js"></script>-->
		<!-- scroll -->
		<!--<script src="lib/fancy-scroll/jquery.fancy-scroll.min.js"></script>-->
		<!-- photo -->
		<script src="lib/masonry/masonry.pkgd.min.js"></script>
		<script src="lib/imagesloaded/imagesloaded.pkgd.min.js"></script>
		<script src="lib/samsungGrid/classie.js"></script>
<!--		<script src="lib/colorfinder/colorfinder-1.1.js"></script>-->
		<script src="lib/samsungGrid/gridScrollFx.js"></script>
		<!-- menu -->
		<!--<script src="lib/off-canvasmenueffect/main.js"></script>-->
		<!-- Animated background -->
		<!--<script src="lib/animatedbackground/TweenLite.min.js"></script>
		<script src="lib/animatedbackground/EasePack.min.js"></script>
		<script src="lib/animatedbackground/rAF.js"></script>
		<script src="lib/animatedbackground/demo-1.js"></script>-->
	</body>
</html>
