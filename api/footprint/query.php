<?php
	include "function.php";

  $result = array();
  if (isset($_GET["id"])) {
    $result = getFootprintFromId($_GET["id"]);
  }
	
  header('Content-Type: application/json; charset=UTF-8');
  echo json_encode($result, JSON_UNESCAPED_UNICODE);
?>