<?php 
session_start();
if (empty($_SESSION["loggedinsuperadmin"])) {
  header("location: index.php");
  exit;
}
?>