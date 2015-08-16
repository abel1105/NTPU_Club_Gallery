<?php
require_once('connection/connntpu.php');
//inc
require_once("function/front_function.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!DOCTYPE html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<!--    <link href="lib/bootstrap-3.3.5-dist/css/bootstrap.min.css" rel="stylesheet">-->
		<link rel="stylesheet" type="text/css" href="lib/samsungGrid/normalize.css" />
		<link rel="stylesheet" type="text/css" href="lib/samsungGrid/component.css" />
		<link rel="stylesheet" type="text/css" href="lib/font-awesome-4.2.0/css/font-awesome.min.css" />
		<link rel="stylesheet" type="text/css" href="lib/off-canvasmenueffect/menu_sideslide.css" />
    <!-- gallery -->
		<link rel="stylesheet" type="text/css" href="lib/gallery/style.css" />
		<link rel="stylesheet" type="text/css" href="lib/gallery/elastislide.css" />
    <link rel="stylesheet" type="text/css" href="lib/jgallery/jgallery.min.css" />
		<link href="lib/nprogress/nprogress.css" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="css/front.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<!--    <script src="js/jquery1.11.2.min.js"></script>-->
		<script src="lib/nprogress/nprogress.js"></script>
		<script src="lib/modernizr/modernizr.custom.js"></script>
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

        <script src="lib/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
		<!-- pjax -->
		<script src="lib/pjax/jquery.pjax.js"></script>
    <!-- gallery -->
    <script type="text/javascript" src="lib/jgallery/jgallery.js"></script>
    <script type="text/javascript" src="lib/jgallery/touchswipe.min.js"></script>
		<script src="js/front.js"></script>

	</head>
	<body class="night">
<!--
		<div id="large-header" class="large-header">
			<canvas id="demo-canvas"></canvas>
		</div>
-->
		<div class="main">
			<div class="logo-wrap">
				<a data-pjax href="index.php">
					<img class="logo" src="image/back Logo.png">
				</a>
			</div>
			<div class="slideThree">
				<input type="checkbox" value="None" id="slideThree" name="check"/>
				<label for="slideThree" onclick="changeBodyColor();"></label>
			</div>
			<!--
			<div class="menu-wrap">
				<nav class="menu">
					<div class="icon-list">
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
										<a data-pjax href="index.php?c=<? echo $row_result2["c_number"]; ?>"><? echo $row_result2["c_name"]; ?></a>
									</li>
									<? } ?>
								</ul>
							</div>
						<? } ?>
					</div>
				</nav>
				<button class="close-button" id="close-button">Close Menu</button>
			</div>
			<button class="menu-button" id="open-button">Open Menu</button>
		-->
			<div id="container" class="container">
                <div class="club-wrap">
                    <img class="top_bar" src="image/bar00.png">
                    <? if( showct(1)) {?>
                    <a data-pjax href="index.php?ct=1">
                        <i class='fa fa-music<? activect(1) ?>' data-content="音樂性社團"></i>
                    </a>
                    <img class="top_bar" src="image/bar01.png">
                    <? } if( showct(2)) {?>
                    <a href="index.php?ct=2">
                        <i class='fa fa-bullhorn<? activect(2) ?>' data-content="康樂性社團"></i>
                    </a>
                    <img class="top_bar" src="image/bar02.png">
                    <? } if( showct(study)) {?>
                    <a href="index.php?ct=3">
                        <i class='fa fa-pencil<? activect(study) ?>' data-content="學藝性社團"></i>
                    </a>
                    <img class="top_bar" src="image/bar03.png">
                    <? } if( showct(4)) {?>
                    <a href="index.php?ct=4">
                        <i class='fa fa-futbol-o<? activect(4) ?>' data-content="體育性社團"></i>
                    </a>
                    <img class="top_bar" src="image/bar04.png">
                    <? } if( showct(5)) {?>
                    <a href="index.php?ct=5">
                        <i class='fa fa-heart<? activect(5) ?>' data-content="服務性社團"></i>
                    </a>
                    <img class="top_bar" src="image/bar05.png">
                    <? } if( showct(6)) {?>
                    <a data-pjax href="index.php?ct=6">
                        <i class='fa fa-users<? activect(6) ?>' data-content="學生自治組織"></i>
                    </a>
                    <img class="top_bar" src="image/bar06.png">
                    <? } if( showct(7)) {?>
                    <a href="index.php?ct=7">
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
								<a photo-pjax href="?ct=<?echo $_GET['ct'] ?>&p=<?echo $p_number?>" style="border-color: <? selectcolor($at_number) ?>">
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
                        <? } elseif ($_GET['c'] == '') {
							$result_func1 = loadimage(0, 30);
				            while( $row_result_func1 = mysql_fetch_assoc($result_func1) ) {
								$p_number = $row_result_func1['p_number'];
								$at_number = $row_result_func1['album_type_number'];
								$c_number = $row_result_func1['club_number'];
								$p_code = $row_result_func1['p_code'];
								$filename = $row_result_func1['filename'];
								?>
							<li class="photo" id="photo_<?echo $p_number?>" code="<?echo $p_code ?>" c="<? echo $c_number?>" at="<?echo $at_number?>" p="<?echo $p_number?>">
								<a photo-pjax href="?p=<?echo $p_number?>" style="border-color: <? selectcolor($at_number) ?>">
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
						<? }else { ?>
							<? while( $row_result_func5 = mysql_fetch_assoc($result_func5) ) {
								$p_number = $row_result_func5['p_number'];
								$at_number = $row_result_func5['album_type_number'];
								$c_number = $row_result_func5['club_number'];
								$p_code = $row_result_func5['p_code'];
								$filename = $row_result_func5['filename'];
								?>
							<li class="photo" id="photo_<?echo $p_number?>">
								<a photo-pjax href="?p=<?echo $p_number?>" style="border-color: <? selectcolor($at_number) ?>">
									<div class="image" style="background-image: url('image/<?echo $p_code ?>/<? echo $c_number?>/<?echo $at_number?>/<? echo $filename ?>');" alt="test">
										<img src="image/<?echo $p_code ?>/<? echo $c_number?>/<?echo $at_number?>/<? echo $filename ?>" style="width: 100%;">
										<? $sql_func2 = "SELECT `at_club`, `at_name` FROM `album_type` WHERE `at_number` ='".$row_result_func5['album_type_number']."'";
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
            <a class="<? if( $_GET['p'] == $p_number){ echo 'active-photo'; }?>" href="image/<?echo $p_code ?>/<? echo $c_number?>/<?echo $at_number?>/<? echo $filename ?>" data="<? echo $p_number?>"><img  src="image/<?echo $p_code ?>/<? echo $c_number?>/<?echo $at_number?>/thumb/<? echo $filename ?>" alt="<?echo $p_club ?> > <?echo $row_result_func6['at_name']?>" /></a>
            <? } ?>

          </div>
          <script type="text/javascript">
          $( function() {
            $.when(
              $( '#gallery' ).jGallery({
                "autostartAtImage": $('a.active-photo').index()+1,
                canClose: true,
                height: $(window).height(),
                slideshowInterval: '3s'
              })
            ).then(function(){
              
               <?if($_GET['ct'] != ''){ ?>
                $('div.nav span.fa.fa-times.jgallery-close.jgallery-btn.jgallery-btn-small').wrap('<a photo-pjax href="index.php?ct=<?echo $_GET['ct']?>"></a>');
              <? }else { ?>
                $('div.nav span.fa.fa-times.jgallery-close.jgallery-btn.jgallery-btn-small').wrap('<a photo-pjax href="index.php"></a>');
              <? } ?>
              $('.fa.resize.jgallery-btn.jgallery-btn-small.fa-search-plus').addClass('hidden-xs');
              $('.fa.change-mode.jgallery-btn.jgallery-btn-small.fa-expand').addClass('hidden-xs');
              $('.fa.fa-th.full-screen.jgallery-btn.jgallery-btn-small').addClass('hidden-xs');
              
            
            });
          } );
            
          </script>
          <? } ?>
        </div>
			</div><!-- /container -->
		<!-- gallery -->
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
