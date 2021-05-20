$(function(){
  $('.menu1').click(function () {
    $('.menu2').slideUp();
    if ($(this).children('.menu2').is(':hidden')) {
      $(this).children('.menu2').slideDown();
    } else {
      $(this).children('.menu2').slideUp();
    }
  })
})

$(function(){
  /* TRIGGER */
  $('.trigger').click(function(){
    $(this).toggleClass('active')
    $('.m-gnb').toggleClass('active')
  })

  $('.menu_li').click(function(){
    $('.m-gnb').removeClass('active')
    $('.trigger').removeClass('active')
  })

  // $('.container').on('click', function(e) {
  //   $('.m-gnb').removeClass('active')
  //   $('.trigger').removeClass('active')
  // })
})
