$(function(){
	$('td.nav li').mouseenter(function() {
		$(this).children('ul').stop().slideDown(400);
	});
	$('td.nav li').mouseleave(function() {
		$(this).children('ul').stop().slideUp(400);
	});
});
$(function(){
	$(window).scroll(function(){ 
		   var num = $(this).scrollTop(); //스크롤바 수직 위치를 반환
		   if( num > 360 ){ //해더의 기본 위치 0 스크롤이 360으로 가면 나머지 실행
			  $("header").css("background-color","#fff");
			  $("header").css("height","100px");
			  $("header > table > tbody > tr > .nav > ul > li > a").css("color","#000");
		   }
		   else{
			$("header > table > tbody > tr > .nav > ul > li > a").css("color","#fff");
			$("header").css("background-color","rgba(0,0,0,0)");
			$("header").css("height","0px");
		   }
	  });
	});
