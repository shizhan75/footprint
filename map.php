<?php
  include "check_login.php";

  global $session_username;
?>

<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<title>Map</title>
  <link href="https://cdn.bootcss.com/jvectormap/2.0.3/jquery-jvectormap.min.css" rel="stylesheet">
  <link href="https://cdn.bootcss.com/Buttons/2.0.0/css/buttons.css" rel="stylesheet">
  <style type="text/css">
    body {
      padding: 0;
      margin: 0;
    }
    #china-map {
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
    #nav {
      position: absolute;
      z-index: 1000;
      top: 10px;
      left: 50px;
      margin: 0;
      padding: 0;
    }
  </style>
</head>
<body>
	<div id="china-map"></div>
  <div id="nav"><button id="btnNav" type="button" class="button button-primary button-pill">Set my footprint</button></div>
  
  <script src="https://cdn.bootcss.com/jquery/3.1.0/jquery.min.js"></script>
  <script src="js/jquery-jvectormap-2.0.3.min.js"></script>
  <script src="js/jquery-jvectormap-cn-merc.js"></script>
  <script type="text/javascript">
    var provinceCode = {
      "CN-54": "XZ", 
      "CN-62": "GS", 
      "CN-52": "GZ", 
      "CN-53": "YN", 
      "CN-50": "CQ", 
      "CN-51": "SC", 
      "CN-31": "SH", 
      "CN-32": "JS", 
      "CN-33": "ZJ", 
      "CN-14": "SX", 
      "CN-": "FJ", 
      "CN-12": "TJ", 
      "CN-13": "HE", 
      "CN-11": "BJ", 
      "CN-34": "AH", 
      "CN-36": "JX", 
      "CN-37": "SD", 
      "CN-41": "HA", 
      "CN-43": "HN", 
      "CN-42": "HB", 
      "CN-45": "GX", 
      "CN-44": "GD", 
      "CN-46": "HI", 
      "CN-65": "XJ", 
      "CN-64": "NX", 
      "CN-63": "QH", 
      "CN-15": "NM", 
      "CN-61": "SN", 
      "CN-23": "HL", 
      "CN-22": "JL", 
      "CN-21": "LN"
    }, 
    provinceInfo = {
      "XZ": "西藏", 
      "GS": "甘肃", 
      "GZ": "贵州", 
      "YN": "云南", 
      "CQ": "重庆", 
      "SC": "四川", 
      "SH": "上海", 
      "JS": "江苏", 
      "ZJ": "浙江", 
      "SX": "山西", 
      "FJ": "福建", 
      "TJ": "天津", 
      "HE": "河北", 
      "BJ": "北京", 
      "AH": "安徽", 
      "JX": "江西", 
      "SD": "山东", 
      "HA": "河南", 
      "HN": "湖南", 
      "HB": "湖北", 
      "GX": "广西", 
      "GD": "广东", 
      "HI": "海南", 
      "XJ": "新疆", 
      "NX": "宁夏", 
      "QH": "青海", 
      "NM": "内蒙古", 
      "SN": "陕西", 
      "HL": "黑龙江", 
      "JL": "吉林", 
      "LN": "辽宁"
    };

    $(function() {
      $('#btnNav').click(function() {
        window.location = 'footprint.php';
        return false;
      });

      $.getJSON('api/footprint/getmap.php?username=<?php echo $session_username;?>', function(data) {

        console.log(data);

        function getProvinceVisitedCities(data) {
          var info = {};
          for (var province in provinceInfo) {
            info[province] = [];
          }

          data.cityInfo.forEach(function(city, index) {
            if (city.province in info) {
              info[city.province].push(index);
            }
          });
          return info;
        }

        function getProvinceVisited(codes, visitedCities) {
          var visited = {};
          for (var province in codes) {
            visited[province] = (visitedCities[codes[province]].length > 0)? 1 : 0;
          }
          return visited;
        }

        function clearMarkers(map, markers) {
          var obj = {};
          markers.forEach(function(marker) {
            obj[marker] = false;
          });
          map.setSelectedMarkers(obj);
        }

        function highlightProvince(map, province, cities) {
          map.clearSelectedMarkers();
          map.setSelectedMarkers(cities[province]);
        }

        var provinceVisitedCities, provinceVisited, map;

        provinceVisitedCities = getProvinceVisitedCities(data);
        provinceVisited = getProvinceVisited(provinceCode, provinceVisitedCities);
        console.log(provinceVisitedCities);

        map = new jvm.Map({
          container: $('#china-map'),
          map: 'cn_merc',
          backgroundColor: '#B0C4DE',
          markers: data.cityInfo,

          series: {
            regions: [{
              scale: ['#FFFFFF', '#FF9933'],
              attribute: 'fill',
              values: provinceVisited,
              min: 0,
              max: 1
            }]
          },
          markerStyle: {
            initial: {
              fill: '#33FF00',
              r: 4
            },
            selected: {
              fill: '#CA0020',
              r: 4
            }
          },

          onMarkerTipShow: function(event, label, index) {
            var name = data.cityInfo[index]['name'],
                times = data.cityInfo[index]['time'],
                description = data.cityInfo[index]['description'],
                content = name;

            if (times !== '') {
              content += ' - ' + times;
            }
            if (description !== '') {
              content += '<br>' + description;
            }
            label.html(content);
          },
          onMarkerClick: function(event, code) {
            // window.location.href = "gallery.html?code=" + code;
          },
          onMarkerOver: function(event, code) {
            var province = data.cityInfo[parseInt(code)].province;
            if (province in provinceInfo) {
              highlightProvince(map, province, provinceVisitedCities);
            } else {
              map.setSelectedMarkers(code);
            }
          },

          onRegionTipShow: function(event, label, code) {
            label.html(provinceInfo[provinceCode[code]]);
          },
          onRegionClick: function(event, code) {
            // window.location.href = "gallery.html?code=" + data.provinceName[code];
          },
          onRegionOver: function(event, code) {
            highlightProvince(map, provinceCode[code], provinceVisitedCities);
          },
          onRegionOut: function(event, code) {
            clearMarkers(map, provinceVisitedCities[provinceCode[code]]);
          }
        });
      });
    });
  </script>
</body>
</html>