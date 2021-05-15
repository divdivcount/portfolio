
function getjson(url, callback) {
  var req = new XMLHttpRequest();
  req.open('GET', url);
  req.responseType = 'json';
  req.send();
  req.onload = function() {
    var userAgent = navigator.userAgent.toLowerCase();
    if(userAgent.indexOf('Tridemt')>-1 || userAgent.indexOf('MSIE')>-1) {
      callback(JSON.parse(req.response));
    }
    else {
      callback(req.response);
    }
  }
}
