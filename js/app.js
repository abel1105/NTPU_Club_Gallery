function select_all(obj, name){
  var select_items = document.getElementsByName(name);
  for(var i=0; i <= select_items.length; i++){
    select_items[i].checked = obj.checked;
  }
}
// adjustable pie chart
function sliceSize(dataNum, dataTotal) {
  return (dataNum / dataTotal) * 360;
}
function showphoto() {
  $('.grid img').each(function(){
    var imgHeight = $(this).outerHeight();
    var imgWidth = $(this).outerWidth();
    var gridWidth = 220;
    var gridHeight = 160;//$(this).parent().height();
    console.log(imgHeight, imgWidth);
    $(this).css('margin-top',(gridHeight - imgHeight)/2 ).css('margin-bottom',(gridHeight - imgHeight)/2 ).css('margin-left',(gridWidth - imgWidth)/2 ).css('margin-right',(gridWidth - imgWidth)/2 );
  })
}
function addSlice(sliceSize, pieElement, offset, sliceID, color) {
  $(pieElement).append("<div class='slice " + sliceID + "'><span></span></div>");
  var offset = offset - 1;
  var sizeRotation = -179 + sliceSize;
  $("." + sliceID).css({
    "transform": "rotate(" + offset + "deg) translate3d(0,0,0)"
  });
  $("." + sliceID + " span").css({
    "transform": "rotate(" + sizeRotation + "deg) translate3d(0,0,0)",
    "background-color": color
  });
}
function footerAtDown(){
  var sideNavOffset = $('#sideNav').outerHeight(true); // 原先 footerOffset 在125行
  var wrapOffset = $('#wrap').outerHeight(true);
  if(sideNavOffset > footerOffset ){
    $('#footer').css('margin-top', sideNavOffset-footerOffset+10);
  }else if(sideNavOffset >　wrapOffset　) {
    $('#footer').css('margin-top', sideNavOffset-wrapOffset);
  }else{
    $('#footer').css('margin-top', 10);
  }
}
function iterateSlices(sliceSize, pieElement, offset, dataCount, sliceCount, color) {
  var sliceID = "s" + dataCount + "-" + sliceCount;
  var maxSize = 179;
  if (sliceSize <= maxSize) {
    addSlice(sliceSize, pieElement, offset, sliceID, color);
  } else {
    addSlice(maxSize, pieElement, offset, sliceID, color);
    iterateSlices(sliceSize - maxSize, pieElement, offset + maxSize, dataCount, sliceCount + 1, color);
  }
}
var Status = {};
function saveStatus(key, value){
  Status[key] = value;
  localStorage.setItem('status', JSON.stringify(Status));
}
function addcolor(e){
  $('body').removeClass().addClass(e);
  saveStatus('color', e);
  $('.toolbox').on('inserted.bs.popover', function () {
    $('select#changeColor option[value="'+e+'"]').prop('selected', true);
  })
};
if(localStorage.getItem('status') != undefined){
  var getStatus = localStorage.getItem('status');
  addcolor(JSON.parse(getStatus).color);
  toggleMenu(JSON.parse(getStatus).togglemenu);
  $('body').show();
}
function toggleMenu(e) {
  function show(){
    $('#sideNav').show();
    $('#wrap').css('margin-left', 235);
    saveStatus('togglemenu', 'show');
  }
  function hide(){
    $('#sideNav').hide();
    $('#wrap').css('margin-left', 20);
    saveStatus('togglemenu', 'hide');
  }
  if( e == 'hide'){ hide();}
  else if(e == 'show'){ show(); }
  else if(!$('#sideNav').is(":hidden")){ hide(); }
  else{ show();}
};
function createPie(dataElement, pieElement) {
  var listData = [];
  $(dataElement + " span").each(function() {
    listData.push(Number($(this).html()));
  });
  var listTotal = 0;
  for (var i = 0; i < listData.length; i++) {
    listTotal += listData[i];
  }
  var offset = 0;
  var color = [
    "cornflowerblue",
    "olivedrab",
    "orange",
    "tomato",
    "crimson",
    "purple",
    "turquoise",
    "forestgreen",
    "navy",
    "gray"
  ];
  for (var i = 0; i < listData.length; i++) {
    var size = sliceSize(listData[i], listTotal);
    iterateSlices(size, pieElement, offset, i, 0, color[i]);
    $(dataElement + " li:nth-child(" + (i + 1) + ")").css("border-color", color[i]);
    offset += size;
  }
}
// 檢查是否pjax請求
function gplus_is_pjax(){
   return array_key_exists('HTTP_X_PJAX', $_SERVER) && $_SERVER['HTTP_X_PJAX'] === 'true';
}
function pushSpotStatus(ct_number,c_number,id){
  $.ajax({
    data: {ct: ct_number, c: c_number},
    type: 'GET',
    dataType: 'json',
    contentType: "charset=utf-8",
    url: '../function/spotStatus.php',
    success: function(data) {
    }
  })
  if (jQuery('#'+id).hasClass('active')){
    jQuery('#'+id).removeClass('active').addClass('noactive');  
  }else{
    jQuery('#'+id).removeClass('noactive').addClass('active');
  }
  }
// initial pjax
  $(document).pjax('a[data-pjax]', '#wrap', {fragment:'#wrap', timeout:5000});
  //progress bar
  $(document).on('pjax:start', function() { NProgress.start(); });
  $(document).on('pjax:end',   function() { NProgress.done();  });
jQuery(document).ready(function($) {
  
  // click club_type and toggle club
  $('div.club_type_title').click(function() {
    $(this).parent().children('ul').toggle();
    if($(this).children('span.club_type_span').hasClass('collapsed')){
      $(this).children('span.club_type_span').removeClass('collapsed');
    }else{
      $(this).children('span.club_type_span').addClass('collapsed');
    }
    footerAtDown();
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
  // initial toobox
  $('.toolbox').popover({ html : true, content: '<div style="text-align: center;"> 背景</br><select id= "changeColor" onchange="addcolor(value)"><option value="color">正常</option><option value="blue">藍色</option><option value="grey">灰色</option><option value="green">綠色</option><option value="daynight">黑藍</option></select></br>功能表</br><button class="blueBtn" onclick="toggleMenu()">toggle</button></div>'});

  // add bootstrap icon in club_type
  $('.club_type:eq(0) div.club_type_title').prepend("<span class='glyphicon glyphicon-cog' aria-hidden='true'></span>")
  $('.club_type:eq(1) div.club_type_title').prepend("<span class='glyphicon glyphicon-music' aria-hidden='true'></span>");
  $('.club_type:eq(2) div.club_type_title').prepend("<span class='glyphicon glyphicon-bullhorn' aria-hidden='true'></span>");
  $('.club_type:eq(3) div.club_type_title').prepend("<span class='glyphicon glyphicon-pencil' aria-hidden='true'></span>");
  $('.club_type:eq(4) div.club_type_title').prepend("<span class='glyphicon glyphicon-tree-deciduous' aria-hidden='true'></span>");
  $('.club_type:eq(5) div.club_type_title').prepend("<span class='glyphicon glyphicon-heart' aria-hidden='true'></span>");
  $('.club_type:eq(6) div.club_type_title').prepend("<span class='glyphicon glyphicon-user' aria-hidden='true'></span>");
  $('.club_type:eq(7) div.club_type_title').prepend("<span class='glyphicon glyphicon-glass' aria-hidden='true'></span>");

})

// view photo
$(document).on('ready pjax:end', function() {
  footerOffset = $('#footer').offset().top;
  footerAtDown();
  
  $(window).on('resize',function() { 
    footerAtDown();
  })
  var imgLoad = imagesLoaded( $('.grid img') );
  imgLoad.on( 'always', function( instance ) {
    showphoto();
  });
  $('.widget .grid img, .widget div.grid span.glyphicon-eye-open').click(function(){
    var imgurl = $(this).closest('.grid').children('img').attr('src');
    var imgname = $(this).closest('.grid').children('img').attr('name');
    $(this).closest('.grid').prepend("<div class='showImg'><span class='glyphicon glyphicon-remove ftr removeImg' aria-hidden='true' style='font-size:20px; margin: 10px;''></span><img name='"+imgname+"' src='"+imgurl+" 'style='width: 100%; height: 400px; padding: 10px; object-fit: contain; margin-top: 10px;'><h3>"+imgname+"</h3></div>");
    $('span.removeImg').click(function(){
      $('div.showImg').hide();
    });
  });
});
