<?php require_once('connection/connntpu.php'); ?>
<?
if($_GET['p'] == ''){
	header('Location: index.php');
}
?>
<?
//inc
include("function/front_function.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <!--<link href="lib/bootstrap-3.3.5-dist/css/bootstrap.min.css" rel="stylesheet">-->
		<link rel="stylesheet" type="text/css" href="lib/samsungGrid/normalize.css" />
		<link rel="stylesheet" type="text/css" href="lib/samsungGrid/component.css" />
		<link rel="stylesheet" type="text/css" href="lib/font-awesome-4.2.0/css/font-awesome.min.css" />
		<link rel="stylesheet" type="text/css" href="lib/off-canvasmenueffect/menu_sideslide.css" />
		<link rel="stylesheet" type="text/css" href="css/front.css" />
		<link href="lib/nprogress/nprogress.css" rel="stylesheet">
		<!-- gallery -->
		<link rel="stylesheet" type="text/css" href="lib/gallery/style.css" />
		<link rel="stylesheet" type="text/css" href="lib/gallery/elastislide.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
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

	</head>
	<body class="night">
		<div id="large-header" class="large-header">
			<canvas id="demo-canvas"></canvas>
		</div>
		<div class="main">
			<div class="logo-wrap">
				<a data-pjax href="index.php">
					<img class="logo" src="image/back Logo.png">
				</a>
			</div>
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
			<div id="container" class="container">
				<script id="img-wrapper-tmpl" type="text/x-jquery-tmpl">
					<div class="rg-image-wrapper">
						{{if itemsCount > 1}}
							<div class="rg-image-nav">
								<a href="#" class="fa fa-chevron-left rg-image-nav-prev"></a>
								<a href="#" class="fa fa-chevron-right rg-image-nav-next"></a>
							</div>
						{{/if}}
						<div class="rg-image"></div>
						<div class="rg-loading"></div>
						<div class="rg-caption-wrapper">
							<div class="rg-caption" style="display:none;">
								<p></p>
							</div>
						</div>
					</div>
				</script>
				<section class="showphoto">
				<? if(isset($_GET['p']) && ($_GET['p'] != '')){ ?>
					<div id="rg-gallery" class="rg-gallery">
						<div class="rg-thumbs">
							<!-- Elastislide Carousel Thumbnail Viewer -->
							<div class="es-carousel-wrapper">
								<div class="es-nav">
									<span class="fa fa-chevron-left es-nav-prev"></span>
									<span class="fa fa-chevron-right es-nav-next"></span>
								</div>
								<div class="es-carousel">
									<ul>
										<? while ( $row_result_func3 = mysql_fetch_assoc($result_func3) ) {
											$p_number = $row_result_func3['p_number'];
											$at_number = $row_result_func3['album_type_number'];
											$c_number = $row_result_func3['club_number'];
											$p_code = $row_result_func3['p_code'];
											$filename = $row_result_func3['filename'];
											?>
										<li id="photo_<?echo $p_number ?>">
											<a href="#">
												<img src="image/<?echo $p_code ?>/<? echo $c_number?>/<?echo $at_number?>/<? echo $filename ?>" data-large="image/<?echo $p_code ?>/<? echo $c_number?>/<?echo $at_number?>/<? echo $filename ?>" alt="image_<?echo $p_number?>" data-description="<? ?>" />
											</a>
										</li>
										<? } ?>
									</ul>
								</div>
							</div>
							<!-- End Elastislide Carousel Thumbnail Viewer -->
						</div><!-- rg-thumbs -->
					</div><!-- rg-gallery -->
				<? } ?>
				</section>
			</div><!-- /container -->
		<!-- pjax -->
		<script src="lib/pjax/jquery.pjax.js"></script>
		<script src="js/front.js"></script>
		<!-- gallery -->
		<script src="lib/gallery/jquery.tmpl.min.js"></script>
		<script src="lib/gallery/jquery.easing.1.3.js"></script>
		<script src="lib/gallery/jquery.elastislide.js"></script>
		<script src="lib/gallery/gallery.js"></script>
		<!-- phot -->
		<script src="lib/masonry/masonry.pkgd.min.js"></script>
		<script src="lib/imagesloaded/imagesloaded.pkgd.min.js"></script>
		<script src="lib/samsungGrid/classie.js"></script>
		<script src="lib/colorfinder/colorfinder-1.1.js"></script>
		<script src="lib/samsungGrid/gridScrollFx.js"></script>
		<!-- menu -->
		<script src="lib/off-canvasmenueffect/main.js"></script>
		<!-- Animated background -->
		<script src="lib/animatedbackground/TweenLite.min.js"></script>
		<script src="lib/animatedbackground/EasePack.min.js"></script>
		<script src="lib/animatedbackground/rAF.js"></script>
		<script src="lib/animatedbackground/demo-1.js"></script>
	</body>
  <script src="lib/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
</html>
