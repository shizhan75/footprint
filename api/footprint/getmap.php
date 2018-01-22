<?php
  include "function.php";

  $map = array(
    "北京市"=>"BJ",
    "天津市"=>"TJ",
    "河北省"=>"HE",
    "山西省"=>"SX",
    "内蒙古自治区"=>"NM",
    "辽宁省"=>"LN",
    "吉林省"=>"JL",
    "黑龙江省"=>"HL",
    "上海市"=>"SH",
    "江苏省"=>"JS",
    "浙江省"=>"ZJ",
    "安徽省"=>"AH",
    "福建省"=>"FJ",
    "江西省"=>"JX",
    "山东省"=>"SD",
    "河南省"=>"HA",
    "湖北省"=>"HB",
    "湖南省"=>"HN",
    "广东省"=>"GD",
    "广西壮族自治区"=>"GX",
    "海南省"=>"HI",
    "重庆市"=>"CQ",
    "四川省"=>"SC",
    "贵州省"=>"GZ",
    "云南省"=>"YN",
    "西藏自治区"=>"XZ",
    "陕西省"=>"SN",
    "甘肃省"=>"GS",
    "青海省"=>"QH",
    "宁夏回族自治区"=>"NX",
    "新疆维吾尔自治区"=>"XJ",
    "香港特别行政区"=>"XG",
    "澳门特别行政区"=>"AM",
    "台湾省"=>"TW"
  );

  $footprints = array();
  if (isset($_GET["username"])) {
    $data = getFootprints($_GET["username"]);

    foreach ($data as $fp) {
      $province = isset($map[$fp["province"]])? $map[$fp["province"]] : "OTHER";

      $footprints[] = array(
        "latLng"      =>  array($fp["lat"], $fp["lng"]), 
        "name"        =>  $fp["footprint"], 
        "province"    =>  $province,
        "time"        =>  $fp["time"],
        "description" =>  $fp["description"]
      );
    }
    
  }

  $result = array("cityInfo"=>$footprints);
  header('Content-Type: application/json; charset=UTF-8');
  echo json_encode($result, JSON_UNESCAPED_UNICODE);
?>