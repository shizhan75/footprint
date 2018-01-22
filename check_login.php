<?php
  session_start();
  if (isset($_SESSION["state"]) && $_SESSION["state"] == 'login' && isset($_SESSION["username"])) {
    $session_username = $_SESSION["username"];
  } elseif (isset($_COOKIE["username"])) {
  	$_SESSION['state'] = 'login';
    $_SESSION['username'] = $_COOKIE["username"];
    $session_username = $_SESSION["username"];
  } else {
    header("Location: login.php");
    exit;
  }
?>