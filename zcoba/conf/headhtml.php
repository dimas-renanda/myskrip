<?php

//session_start();
 // hide all error
 error_reporting(0);
require_once "./assets/assets.php"
?>
<!DOCTYPE html>
<html>
	<head>
		<title>X-RADIUS <?= $hotspotname; ?></title>
		<meta charset="utf-8">
		<meta http-equiv="cache-control" content="private" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<!-- Tell the browser to be responsive to screen width -->
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- Theme color -->
		<meta name="theme-color" content="light" />
		<!-- Font Awesome -->
		<link rel="stylesheet" type="text/css" href="assets/css/font-awesome/css/font-awesome.min.css" />
		<!-- Mikhmon UI -->
		
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
		<!-- favicon -->
		<link rel="icon" href="http://localhost/myskrip/zcoba/assets/img/logo_stab.png" />

		<link rel="icon" href="http://localhost/myskrip/zcoba/assets/img/logo_stab.png">
		<!-- jQuery -->
		<script src="assets/js/jquery.min.js"></script>
		<!-- pace -->
		<link href="assets/css/pace.<?= $theme; ?>.css" rel="stylesheet" />
		<script src="assets/js/pace.min.js"></script>

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

<!-- <script type="text/javascript">
var timestamp = '<?=time();?>';
function updateTime(){
  $('#time').html(Date(timestamp));
  timestamp++;

  
}
$(function(){
  setInterval(updateTime, 1000);
});
</script> -->

<script src="time.js"></script>

	</head>
	<body > 
	
		<div class="wrapper">

			
