$(document).ready(function(){
  $("#p0").click(function(){
    var menuHeight = document.querySelector("#wrap_container").offsetHeight;
    var location = document.querySelector("#wrap_container").offsetTop;
    window.scrollTo({top:location - menuHeight, behavior:'smooth'});
  });
  $("#p2").click(function(){
    var menuHeight = document.querySelector("#header_container").offsetHeight;
    var location = document.querySelector("#content_container").offsetTop;
    window.scrollTo({top:location - menuHeight, behavior:'smooth'});
  });
  $("#p3").click(function(){
    var menuHeight = document.querySelector("#header_container").offsetHeight;
    alert(menuHeight);
    var location = document.querySelector("#skills_container").offsetTop;
    alert(location);
    window.scrollTo({top:location - menuHeight, behavior:'smooth'});
  });
  $("#p4").click(function(){
    var menuHeight = document.querySelector("#header_container").offsetHeight;
    var location = document.querySelector("#project_container").offsetTop;
    window.scrollTo({top:location - menuHeight, behavior:'smooth'});
  });
  $("#p5").click(function(){
    var menuHeight = document.querySelector("#header_container").offsetHeight;
    var location = document.querySelector("#contact_container").offsetTop;
    window.scrollTo({top:location - menuHeight, behavior:'smooth'});
  });

})
var menuHeight = document.querySelector("body").offsetHeight;
alert(menuHeight);
var location = document.querySelector("#about_container").offsetTop;
alert(location);
