<?php
  include "check_login.php";

  global $session_username;
?>

<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<title>Uguisudani - Map</title>
  <link href="css/lib/bootstrap-3.3.7.min.css" rel="stylesheet">
  <link href="css/lib/jquery-jvectormap-2.0.3.min.css" rel="stylesheet">
  <link href="css/lib/buttons-2.0.0.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/lib/metisMenu-3.0.6.min.css">
  <link rel="stylesheet" href="css/sidemenu.css">
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
  </style>
</head>
<body>
	<div id="footprint-map"></div>
  
  <script src="js/lib/jquery-3.1.0.min.js"></script>
  <script src="js/lib/metisMenu-3.0.6.min.js"></script>
  <script src="js/lib/jquery-jvectormap-2.0.3.min.js"></script>
  <script src="js/lib/map-china.js"></script>
  <script src="js/lib/map-japan.js"></script>
  <script src="js/map-plugin.js"></script>
  <script src="js/sidemenu.js"></script>
  <script type="text/javascript">
    $(function() {
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