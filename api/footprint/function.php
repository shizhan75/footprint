<?php
  include dirname(__FILE__)."/../../connectdb.php";

  function getFootprints($username) {
    global $dbh;
    $footprints = array();

    $sql = "SELECT footprint, province, latitude, longitude, _time, description, id FROM footprint WHERE user='$username'";
    $sth = $dbh->prepare($sql);
    if ($sth->execute()) {
      while ($row = $sth->fetch()) {
        $footprint = $row[0];
        $province = $row[1];
        $lat = $row[2];
        $lng = $row[3];
        $time = $row[4];
        $description = $row[5];
        $id = $row[6];

        $footprints[] = array(
          "id"=>$id,
          "lat"=>$lat, 
          "lng"=>$lng, 
          "footprint"=>$footprint, 
          "province"=>$province, 
          "time"=>$time, 
          "description"=>$description
        );
      }
    }

    return $footprints;
  }
?>