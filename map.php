<?php
  include "check_login.php";

  global $session_username;
?>

<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<title>Uguisudani - Map</title>
  <link href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.bootcss.com/jvectormap/2.0.3/jquery-jvectormap.min.css" rel="stylesheet">
  <link href="https://cdn.bootcss.com/Buttons/2.0.0/css/buttons.css" rel="stylesheet">
  <link rel="stylesheet" href="https://unpkg.com/metismenu/dist/metisMenu.min.css">
  <style type="text/css">
    body {
      padding: 0;
      margin: 0;
    }
    #footprint-map {
      position: absolute;
      width: 100%;
      height: 100%;
    }
    .jvectormap-tip {
      font-family: 'Source Sans Light', 'Apple LiSung Light', 'STHeiti Light', 'SimSun', sans-serif;
      font-size: 16px;
      opacity: 0.75;
      padding: 6px;
    }
    #btnShowSideMenu {
      position: absolute;
      z-index: 900;
      top: 8px;
      left: 8px;
      width: 32px;
      height: 32px;
      margin: 0;
      padding: 0;
    }
    #footprint-map .jvectormap-zoomin,
    #footprint-map .jvectormap-zoomout {
      position: fixed;
      top: auto;
      left: auto;
      right: 16px;
      width: 16px;
      height: 16px;
      background: #ffffff;
      color: #4c4c4c;
      font-size: 24px;
      font-weight: 200;
      border: 1px solid #cccccc;
    }
    #footprint-map .jvectormap-zoomin {
      bottom: 64px;
    }
    #footprint-map .jvectormap-zoomout {
      bottom: 40px;
    }

    .sidebar-nav {
      position: fixed;
      width: 280px;
      height: 100vh;
      background: #ffffff;
    }
    .sidebar-nav ul {
      margin: 0;
      padding: 0;
      list-style: none;
    }
    .sidebar-nav .metismenu {
      display: flex;
      flex-direction: column;
    }
    .sidebar-nav .metismenu>li {
      position: relative;
      display: flex;
      flex-direction: column;
      border-bottom: 1px solid rgba(0, 0, 0, 0.12);
    }
    .sidebar-nav .metismenu .metismenu-header {
      position: relative;
      display: block;
      padding: 24px 15px;
      transition: all .3s ease-out;
      text-decoration: none;
      color: #616161;
      outline-width: 0;
    }
    .sidebar-nav .metismenu a {
      position: relative;
      display: block;
      padding: 13px 15px;
      transition: all .3s ease-out;
      text-decoration: none;
      color: #616161;
      outline-width: 0;
    }
    .sidebar-nav .metismenu ul a {
      padding: 10px 15px 10px 30px;
    }
    .sidebar-nav .metismenu ul ul a {
      padding: 10px 15px 10px 45px;
    }
    .sidebar-nav .metismenu a:hover,
    .sidebar-nav .metismenu a:focus,
    .sidebar-nav .metismenu a:active {
      text-decoration: none;
      color: #f8f9fa;
      background: #0b7285;
    }
    .overlay {
      position: fixed;
      width: 100vw;
      height: 100vh;
      background: rgba(0, 0, 0, 0.7);
      z-index: 998;
    }
  </style>
</head>
<body>
	<div id="footprint-map"></div>
  <button type="button" class="btn btn-default" aria-label="Menu" id="btnShowSideMenu">
    <span class="glyphicon glyphicon-menu-hamburger" aria-hidden="true"></span>
  </button>
  <div class="overlay" style="display: none">
    <nav class="sidebar-nav">
      <ul class="metismenu" id="menu1">
        <li class="metismenu-header">
        <span class="glyphicon glyphicon-home" aria-hidden="true"></span>&nbsp;&nbsp;Uguisudani
        </li>
        <li class="mm-active">
          <a class="has-arrow" href="#">Maps</a>
          <ul>
            <li>
              <a href="map.php?map=china">China</a>
              <a href="map.php?map=japan">Japan</a>
            </li>
            </ul>
        </li>
        <li><a href="footprint.php">Footprint manager</a></li>
        <li><a href="logout.php">Logout</a></li>
      </ul>
    </nav>
  </div>
  
  <script src="https://cdn.bootcss.com/jquery/3.1.0/jquery.min.js"></script>
  <script src="https://unpkg.com/metismenu"></script>
  <script src="js/lib/jquery-jvectormap-2.0.3.min.js"></script>
  <script src="js/lib/map-china.js"></script>
  <script src="js/lib/map-japan.js"></script>
  <script src="js/map-plugin.js"></script>
  <script type="text/javascript">
    $(function() {
      $("#menu1").metisMenu({ toggle: false });
      $('.overlay').click((e) => {
        if (e.offsetX <= $('.sidebar-nav')[0].offsetWidth) return;
        $('.overlay').hide();
        $('#btnShowSideMenu').show();
      });
      $('#btnShowSideMenu').click(() => {
        $('.overlay').show();
        $('#btnShowSideMenu').hide();
        return false;
      });

      let urlSearchParams = new URLSearchParams(window.location.search);
      let urlUserId = urlSearchParams.get('userId');
      let userId = urlUserId != null ? urlUserId : '<?php echo $session_username;?>';
      let countryId = urlSearchParams.get('map');
      let supportedCountries = new Set(['china', 'japan']);
      if (!supportedCountries.has(countryId)) {
        countryId = 'china';
      }
      $.getJSON(`api/footprint/getmap.php?username=${userId}`, function(data) {
        console.log(data); // for debug
        new window.MapPlugin({
          container: $('#footprint-map'),
          countryId: countryId,
          footprints: data.footprints,
        });
      });
    });
  </script>
</body>
</html>