<?php 
require_once "../conf/safety.php";
require_once "../conf/bjorka.php";
require_once "../conf/conn.php";
require_once "../assets/assets.php";

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css">
  
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script>

    <title>CS</title>

    <script>
        $(document).ready(function () {
    $('#example').DataTable(
        {
            responsive: true
        }
    );
});
    </script>
</head>

<body>

<div class="col-md" style="padding-left: 20px; padding-top: 20px; padding-bottom: 20px; padding-right: 20px;">
<h3>Grade List</h3>
<hr>




<p style="padding-bottom: 30px;"></p>


isi disini
    
</div>

</body>
</html>