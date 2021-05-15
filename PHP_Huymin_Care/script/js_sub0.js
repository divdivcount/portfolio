var now_img, next_img, now_ment, next_ment;
var fade_change = null;
var timer = null;
$(document).ready(function(){
  fade_change = function() {
    now_img = $("div.pageimg img:eq(0)");
    next_img = $("div.pageimg img:eq(1)");
    now_ment = $("div.pageimg>table td:eq(0)");
    next_ment = $("div.pageimg>table td:eq(1)");
    now_ment.removeClass("active");
    next_img.addClass("active");
    $("div.pageimg img:eq(3)").after(now_img);
    setTimeout(function(){
      now_img.removeClass("active");
      now_ment.removeClass("visible");
      setTimeout(function(){
        next_ment.addClass("visible");
        setTimeout(function(){
          next_ment.addClass("active");
          $("div.pageimg>table td:eq(3)").after(now_ment);
        }, 100);
      }, 1000);
    }, 1000);
  };

  timer = setInterval(fade_change, 7500);

  // 마우스를 올렸을 때 메인 이미지 전환을 막는 코드입니다.
  /*
  $("div.pageimg").hover(function(){
      clearInterval(timer);
  }, function(){
      timer = setInterval(fade_change,3000);
  });
  */
});

//이미지 클릭시 확대
function doImgPop(img){
 img1= new Image();
 img1.src=(img);
 imgControll(img);
}

function imgControll(img){
 if((img1.width!=0)&&(img1.height!=0)){
    viewImage(img);
  }
  else{
     controller="imgControll('"+img+"')";
     intervalID=setTimeout(controller,20);
  }
}

function viewImage(img){
 W=img1.width;
 H=img1.height;
 O="width="+W+",height="+H+",scrollbars=yes";
 imgWin=window.open("","",O);
 imgWin.document.write("<html><head><title>이미지 확대</title></head>");
 imgWin.document.write("<body topmargin=0 leftmargin=0>");
 imgWin.document.write("<img src="+img+" onclick='self.close()' style='cursor:pointer;' title ='클릭하시면 창이 닫힙니다.'>");
 imgWin.document.close();
}
