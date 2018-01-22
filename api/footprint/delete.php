<?php
	include "../../connectdb.php";

	$user = $_GET['username'];
	$id = $_GET['id'];
	$sql = "DELETE FROM footprint WHERE user='$user' AND id='$id'";
	$count = $dbh->exec($sql);
	if ($count === 1) {
		$result = array("status"=>"success");
	} else {
		$result = array("status"=>"failed");
	}

	header('Content-Type: application/json; charset=UTF-8');
	echo json_encode($result, JSON_UNESCAPED_UNICODE);
?>