var json;
var latest = 0;
var lock = false;

function makeImage(url, description) {
  var box = document.createElement('div');
  var obj = document.createElement('img');
  var objsmall = document.createElement('small');
  obj.onload = function () {
    var target = this.parentElement;
    setTimeout(function() {
      target.style.top = '0';
      target.style.opacity = '1';
    }, 200);
  }
  obj.setAttribute('src', '/img/gallery/'+url);
  objsmall.innerText = description;

  obj.onclick = function () {
    window.open(this.src);
  }
  /*
  obj.onclick = function () {
    var text = description;
    var img = '/img/gallery/'+url;
    var target = document.getElementById('imagelayer');
    target.style.display = 'block';
    var tin = target.getElementsByClassName('img')[0];
    tin.getElementsByTagName('span')[0].innerText = text;
    tin.getElementsByTagName('img')[0].setAttribute('src', img);
  }
  */
  box.appendChild(obj);
  box.appendChild(objsmall);
  document.getElementsByClassName('fourimg')[0].appendChild(box);
}

function loadDoc() {
  if(lock) return;
  if(!lock) lock = true;
  //getjson('/gallery_download.php?latest=' + latest, (json) => {
  getjson('/gallery_download.php?latest=' + latest, function (json) {
    if(navigator.userAgent.indexOf('Trident/') > -1) {
      json = JSON.parse(json);
    }
    if(json.len>0) {
      for(var i=0; i<json.url.length; i++) {
        makeImage(json.url[i], json.names[i]);
      }
      latest = json.latest -1;
      if(json.last) {
        document.getElementsByClassName('fourimg')[0].nextElementSibling.style.display = 'none';
        lock = true;
      }
      else {
        lock = false;
      }
    }
    else {
      document.getElementsByClassName('fourimg')[0].nextElementSibling.style.display = 'none';
      lock = true;
    }
  });
}

loadDoc();

function close_image(obj) {
  obj.parentElement.style.display = '';
}

/*
var screen_resize = function () {
  imagelayer.style.width = screen.innerWidth;
  imagelayer.style.height = screen.innerHeight;
  imagelayer.getElementsByTagName('img')[0].style.maxWidth = (screen.innerWidth-200)+'px';
  imagelayer.getElementsByTagName('img')[0].style.maxHeight = (screen.innerHeight-200)+'px';
}
var imagelayer = document.getElementById('imagelayer');
document.body.onload = screen_resize;
document.body.onchange = screen_resize;
*/
