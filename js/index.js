
$(document).ready(function(){
  // header bar 높이
  var barSize = document.querySelector("#header").offsetHeight;
  // 버튼에 따른 이동할 Y 좌표
  var targetInfos = {
    '#p0': document.querySelector("#wrap_container").offsetTop,
    '#p2': document.querySelector("#content_container").offsetTop-barSize,
    '#p3': document.querySelector("#skills_container").offsetTop-barSize,
    '#p4': document.querySelector("#project_container").offsetTop-barSize,
    '#p5': document.querySelector("#contact_container").offsetTop-barSize
  };
  for(const [ button, targetY ] of Object.entries(targetInfos)) {
    // 버튼에 리스너 등록
    $(button).click(function(e) {
      e.preventDefault();
      window.scroll({
        top: targetY,
        behavior:'smooth'
      });
    });
  }
});
