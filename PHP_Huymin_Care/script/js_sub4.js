var open_pop;
var close_pop;

$(document).ready(function(){
  open_pop = function() {
    $("#popuplayer").fadeIn("fast");
  }
  close_pop = function() {
    $("#popuplayer").fadeOut("fast");
  }
});

function submit(obj) {
  if(obj.parentElement.getElementsByTagName('input')[0].checked) {
    obj.parentElement.previousElementSibling.submit();
  }
  else {
    alert('개인정보처리방침에 동의해 주십시오.');
  }
}
