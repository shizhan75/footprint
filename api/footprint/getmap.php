<?php
  include "function.php";

  $footprints = array();
  if (isset($_GET["username"])) {
    $footprints = getFootprints($_GET["username"]);
  }

  $result = array("footprints"=>$footprints);
  header('Content-Type: application/json; charset=UTF-8');
  echo json_encode($result, JSON_UNESCAPED_UNICODE);
?>