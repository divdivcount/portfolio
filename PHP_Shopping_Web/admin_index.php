<?php
// Load Modules
require_once("modules/admin.php");
$id = $_SESSION['user'];
?>
<!DOCTYPE html>
<html lang="ko" dir="ltr">
  <head>
    <link href="css/css_sub2.css" rel="stylesheet" type="text/css">
    <?php require_once('modules/form_head.php'); ?>
    <title></title>
  </head>
  <body>
    <?php require_once('modules/form_navigation.php'); ?>
    <header>
      <div style="float:left;" id="openweathermap-widget-23"></div>
      <h1> <span style="float:right; color:#fff;"><?= $id ?>관리자</span></h1>
    </header>
    <main>
      <iframe id="admin_frame" align="right" frameBorder="" src="admin_gallery_list.php" height="800px" width="100%"></iframe>
    </main>
    <script>
    function changeIframeUrl(url){
      document.getElementById("admin_frame").src = url;
    }
    </script>
    <!-- api  -->
    <script>
    window.myWidgetParam ? window.myWidgetParam : window.myWidgetParam = [];
    window.myWidgetParam.push({id: 23,cityid: '1835848',appid: '80a6055a68971e9a096d9da722f2d850',units: 'metric',containerid: 'openweathermap-widget-23',  });
    (function() {var script = document.createElement('script');script.async = true;
    script.charset = "utf-8";script.src = "//openweathermap.org/themes/openweathermap/assets/vendor/owm/js/weather-widget-generator.js";
    var s = document.getElementsByTagName('script')[0];s.parentNode.insertBefore(script, s);  })();
    </script>
  </body>
</html>
