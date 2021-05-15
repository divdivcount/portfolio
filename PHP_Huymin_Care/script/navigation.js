$(function(){
	$('td.nav li').mouseenter(function() {
		$(this).children('ul').stop().slideDown(400);
	});
	$('td.nav li').mouseleave(function() {
		$(this).children('ul').stop().slideUp(400);
	});
});
