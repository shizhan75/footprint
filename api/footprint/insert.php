<?php
	include "../../connectdb.php";

	$user = $_POST['username'];
	$footprint = $_POST['footprint'];
	$lat = $_POST['lat'];
	$lng = $_POST['lng'];
	$province = $_POST['province'];
	$time = $_POST['time'];
	$description = $_POST['description'];
	$sql = "INSERT INTO footprint (user, footprint, province, latitude, longitude, _time, description) VALUES ('$user', '$footprint', '$province', $lat, $lng, '$time', '$description')";
	$count = $dbh->exec($sql);
	if ($count === 1) {
		$result = array("status"=>"success", "province"=>$province, "footprint"=>$footprint, "time"=>$time, "description"=>$description, "id"=>$dbh->lastInsertId());
	} else {
		$result = array("status"=>"failed");
	}

	header('Content-Type: application/json; charset=UTF-8');
	echo json_encode($result, JSON_UNESCAPED_UNICODE);
?>