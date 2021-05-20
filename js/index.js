$(document).ready(function () {
  // 버튼에 따른 이동할 Y 좌표
  var targetInfos = {
    '.p0': function () {
      return document.querySelector("#wrap_container").offsetTop;
    },
    '.p2': function () {
      return document.querySelector("#content_container").offsetTop;
    },
    '.p3': function () {
      // header bar 높이
      var barSize = document.querySelector("#header").offsetHeight;
      return document.querySelector("#skills_container").offsetTop - barSize
    },
    '.p4': function () {
      // header bar 높이
      var barSize = document.querySelector("#header").offsetHeight;
      return document.querySelector("#project_container").offsetTop - barSize
    },
    '.p5': function () {
      // header bar 높이
      var barSize = document.querySelector("#header").offsetHeight;
      return document.querySelector("#contact_container").offsetTop - barSize
    }
  };
  for (const [button, targetY] of Object.entries(targetInfos)) {
    // 버튼에 리스너 등록
    $(button).click(function (e) {
      e.preventDefault();
      window.scroll({
        top: targetY(),
        behavior: 'smooth'
      });
    });
  }

  $(window).scroll(function () {
    var num = $(this).scrollTop(); //스크롤바 수직 위치를 반환
    if (num >= 1080) { //해더의 기본 위치 0 스크롤이 360으로 가면 나머지 실행
      $(".trigger span").css("background-color", "#000");
      var windowWidth = $(window).width();
      if (windowWidth < 768) {
        //창 가로 크기가 500 미만일 경우
      } else {
        $("#header").css("background-color", "#fff");
        $("#header").css("box-shadow", "0 5px 10px 0 rgba(0, 0, 0, 0.15)");
        $("#header").css("height", "100px");
        $(".nav > ul > li > a").css("color", "#2d2d2d");
        $("#header").css("transition", "0.5s");
        $('.nav > ul > li > a').hover(function () {
          $(this).css('font-stretch', 'normal');
          $(this).css('font-style', 'normal');
          $(this).css('letter-spacing', 'normal');
          $(this).css('text-align', 'left');
          $(this).css('color', '#6b5892');
          $(this).css('text-decoration', 'underline #6b5892');
          $(this).css('text-underline-position', 'under');
          $(this).css('font-weight', 'bold');
        }, function () {
          $(this).css('color', '#2d2d2d');
          $(this).css('text-decoration', 'none');
        });
      }

    } else {
      $(".nav > ul > li > a").css("color", "#fff");
      $("#header").css("background-color", "rgba(0,0,0,0)");
      $("#header").css("height", "0px");
      $(".trigger span").css("background-color", "#fff");
      $('.nav > ul > li > a').hover(function () {
        $(this).css('font-stretch', 'normal');
        $(this).css('font-style', 'normal');
        $(this).css('letter-spacing', 'normal');
        $(this).css('text-align', 'left');
        $(this).css('color', '#6b5892');
        $(this).css('text-decoration', 'underline #6b5892');
        $(this).css('text-underline-position', 'under');
        $(this).css('font-weight', 'bold');
      }, function () {
        $(this).css('color', '#fff');
        $(this).css('text-decoration', 'none');
      });
    }
  });
  /* TRIGGER */
  $('.trigger').click(function () {
    $(this).toggleClass('active')
    $('.gnb').toggleClass('active')
  })

  $('.menu_li').click(function () {
    $('.gnb').removeClass('active')
    $('.trigger').removeClass('active')
  })
});
