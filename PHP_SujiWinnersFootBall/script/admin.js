
$(document).ready(function(){
  var maxNum = 24;            // 폰트 사이즈 
  var nimNum = 14;            // 폰트 사이즈 
   
  $('.box-zoom .btn-zoomin').on('click', function () {
      // console.log(uiSize + 2)
      var ui_font = $(".box-news-body").css("font-size")
      var uiSize = Number(ui_font.replace(/[^0-9]/g,''));
          if (uiSize < maxNum)
          $('.box-news-body').css({'font-size': '+=2'});
          
  });
  $('.box-zoom .btn-zoomout').on('click', function () {
      // console.log(uiSize + 2)
      var ui_font = $(".box-news-body").css("font-size")
      var uiSize = Number(ui_font.replace(/[^0-9]/g,''));
          if (uiSize > nimNum)
          $('.box-news-body').css({'font-size': '-=2'});
          
  });
  
});
