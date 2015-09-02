function selectcolor(e){
  if (e % 7 == 0) {  return "#E6546A"; }
  else if (e % 7 == 1) { return "#DF3854"; }
  else if (e % 7 == 2) { return "#F26D47"; }
  else if (e % 7 == 3) { return "#E85C5D"; }
  else if (e % 7 == 4) { return "#D22F15"; }
  else if (e % 7 == 5) { return "#ED657B"; }
  else if (e % 7 == 6) { return "#ED9BAB"; }
}
function changephoto(){
  $('i.fa.fa-chevron-left').click(function(){
    $('.active-photo').removeClass('active-photo').prev().addClass('active-photo');
  })
  $('i.fa.fa-chevron-right').click(function(){
    $('.active-photo').removeClass('active-photo').next().addClass('active-photo');
  })
  photoHeight(); 
}
function changeBodyColor(){
  if($('body').hasClass('light')){
    $('body').removeClass('light').addClass('night');
    localStorage.setItem('bg', 'night');
  }else{
    $('body').removeClass('night').addClass('light');
    localStorage.setItem('bg', 'light');
  }
}
function clubtitle(){
    var activetext = $('i.fa.active').attr('data-content');
    if ($('i.fa.active')){
        $('.club-title h2').text(activetext);
    }
    $('i.fa').mouseenter(function(){
        var text = $(this).attr('data-content');
        $('img.top_bar').removeClass('hover');
        $(this).parent().prev().addClass('hover');
        $(this).parent().next().addClass('hover');
        $('.club-title h2').text(text);
    });
    $('i.fa').mouseleave(function(){
        $('img.top_bar').removeClass('hover');
        if ($('i.fa.active').length){
            $('.club-title h2').text(activetext);
        }else{
            $('.club-title h2').text('社團相片一覽');
        }
    });
}
function photoHeight(){
  $('.active-photo').css('height', $('.photo-all').height());
  $('li.photo-wrap.active-photo img').removeAttr('style').css({'max-height': '100%', 'display': 'inherit'});
}
$(window).on('load resize pjax:end',function(){
  photoHeight();
})
jQuery(document).ready(function($) {
    var bg = localStorage.getItem('bg');
    if(bg == 'light'){
        $('body').removeClass('night').addClass('light');
        $('#slideThree').prop('checked',false);
    }else {
        $('body').removeClass('light').addClass('night');
        $('#slideThree').prop('checked',true);
    }
  // initial club type title
    clubtitle();
  // initial when not pjax
  initpage();
  function initpage(){
    if ( window.location.pathname == "/extra/gallery/index.php" || window.location.pathname == "/extra/gallery/"){
      new GridScrollFx( document.getElementById( 'grid' ), {
        viewportFactor : 0.4
      } );
      imageloop();
    }
    else {
    //  GALLERY();   /***************************/
    }
  }
  // initial pjax
  if ($.support.pjax) {
    $(document).pjax('a[data-pjax]', '#container', {fragment:'#container', timeout:5000});
      
    $(document).pjax('a[photo-pjax]', '#photo', {fragment:'#photo', timeout:5000, scrollTo: false});
      
    
    //progress bar
    $(document).on('pjax:start', function() {
      NProgress.start();
    });
    $(document).on('pjax:end',   function() {
      ga('set', 'location', window.location.href);
      ga('send', 'pageview');
      NProgress.done();
      clubtitle();
      if ($('#photo').text().trim() == ''){
        $('body').removeClass('image').addClass('front');
      }else {
        $('body').removeClass('front').addClass('image');
      }
      if ( window.location.pathname == "/extra/gallery/index.php"){
       new GridScrollFx( document.getElementById( 'grid' ), {
         viewportFactor : 0.4
       } );
      }
    });
  }
  // click club_type and toggle club
  $('div.club_type_title').click(function() {
    $(this).parent().children('ul').toggle();
    if($(this).children('span.club_type_span').hasClass('collapsed')){
      $(this).children('span.club_type_span').removeClass('collapsed');
    }else{
      $(this).children('span.club_type_span').addClass('collapsed');
    }
  })
  //add club active class when click
  $('ul.club li a').click(function(){
    $('ul.club li.active').removeClass('active');
    $('.club_type.active').removeClass('active');
    $(this).parent().addClass('active');
  });
  $('span.control').closest('.club_type').click(function(){
    $('ul.club li.active').removeClass('active');
    $(this).addClass('active');
  });
  $('.logo').click(function(){
    $('ul.club li.active').removeClass('active');
    $('span.control').closest('.club_type').addClass('active');
  })

  // add bootstrap icon in club_type
  $('.club_type:eq(0) span.club_type_span').prepend("<i class='fa fa-music'></i>");
  $('.club_type:eq(1) span.club_type_span').prepend("<i class='fa fa-bullhorn'></i>");
  $('.club_type:eq(2) span.club_type_span').prepend("<i class='fa fa-pencil'></i>");
  $('.club_type:eq(3) span.club_type_span').prepend("<i class='fa fa-futbol-o'></i>");
  $('.club_type:eq(4) span.club_type_span').prepend("<i class='fa fa-heart'></i>");
  $('.club_type:eq(5) span.club_type_span').prepend("<i class='fa fa-users'></i>");
  $('.club_type:eq(6) span.club_type_span').prepend("<i class='fa fa-glass'></i>");

    function loadphoto(){
        $('li.photo').click(function(){
            at = $(this).attr('at');
            p = $(this).attr('p');
            $.ajax({
                data: {at: at , p: p},
                type: 'GET',
                dataType: 'json',
                contentType: 'charset=utf-8',
                url: 'function/load_photo.php',
                success: function(data){
                  for(var i in data) {

                  }
                }
            })
        })
    }
  function imageloop(){
    imagestart = 30, imagecount = 30, checkajax = true;
    imagesLoaded( document.getElementById('grid'), function( instance ) {
      $(window).scroll(function () {
        if ( checkajax && location.search == ''){
          if ($(window).scrollTop() >= $(document).height() - $(window).height()) {
            $.ajax({
              data: {start: imagestart , count: imagecount},
              type: 'GET',
              dataType: 'json',
              contentType: "charset=utf-8",
              url: 'function/load_image.php',
              success: function(data) {
                if (jQuery.isEmptyObject(data)){
                  checkajax = false;
                  NProgress.done();
                }
                else{
                  for(var i in data) {
                    var random = (Math.floor(Math.random() * 5) + 2 ) * 100;
                    var rows = data[i];
                    var p_number = rows[0];
                    var p_name = rows[1];
                    var p_club = rows[2];
                    var p_code = rows[3];
                    var c_number = rows[4];
                    var at_number = rows[5];
                    var filename = rows[6];
                    var at_name = rows[9];
                    var at_club = rows[10];
                    var appendhtml = '<li class="photo"><a photo-pjax href="?p='+p_number+'" style="border-color:'+ selectcolor(at_number)+'">';
                    appendhtml += '<div class="image" style="background-image: url(\'image/'+ p_code+ '/'+ c_number +'/' + at_number+ '/'+ filename+'\');" alt="test">';
                    appendhtml += '<img src="image/'+ p_code +'/'+ c_number+'/'+ at_number+'/'+filename +'" style="width:100%;">';
                    appendhtml += '<h3 style="background:' + selectcolor(at_number)+ '">'+ at_name +'</h3>';
                    appendhtml += '<span style="background:'+selectcolor(at_number)+'">'+at_club+'</span></div></a></li>';
                    $('ul.grid').append(appendhtml);
                  }
                  imagestart += 30;
                  new GridScrollFx( document.getElementById( 'grid' ), {
                    viewportFactor : 0.4
                  } );
                }
              }
            })
          }
        }
      });
    });
    // Trigger whenever ajax start
   $(document).ajaxStart(function() {
       NProgress.start();
   });
   // Complete the NProcess when ajax end
   $(document ).ajaxComplete(function() {
       NProgress.done();
   });
  }
});
