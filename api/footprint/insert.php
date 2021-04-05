<?php
	include "../../connectdb.php";

	$isUpdate = isset($_POST['id']);
	if ($isUpdate) {
		$id = $_POST['id'];
	}
	$user = $_POST['username'];
	$footprint = $_POST['footprint'];
	$lat = $_POST['lat'];
	$lng = $_POST['lng'];
	$country = $_POST['country'];
	$province = $_POST['province'];
	$time = $_POST['time'];
	$description = $_POST['description'];
	if ($isUpdate) {
		$sql = "UPDATE footprint SET user='$user', footprint='$footprint', country='$country', province='$province', latitude=$lat, longitude=$lng, _time='$time', description='$description' WHERE id='$id'";
	} else {
		$sql = "INSERT INTO footprint (user, footprint, country, province, latitude, longitude, _time, description) VALUES ('$user', '$footprint', '$country', '$province', $lat, $lng, '$time', '$description')";
	}
	$count = $dbh->exec($sql);
	if ($count === 1) {
		if (!$isUpdate) {
			$id = $dbh->lastInsertId();
		}
		$result = array("status"=>"success", "country"=>$country, "province"=>$province, "footprint"=>$footprint, "time"=>$time, "description"=>$description, "id"=>$id);
	} else {
		$result = array("status"=>"failed");
	}

	header('Content-Type: application/json; charset=UTF-8');
	echo json_encode($result, JSON_UNESCAPED_UNICODE);
?>