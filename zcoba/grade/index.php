<?php 
require_once 'method.php'

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



<title>Grade</title>

<script>
$(document).ready(function () {
$('#example').DataTable(
    
    {
        responsive: true
    }
);
});

window.addEventListener('DOMContentLoaded', event => {

const sidebarToggle = document.body.querySelector('#sidebarToggle');
if (sidebarToggle) {

sidebarToggle.addEventListener('click', event => {
    event.preventDefault();
    document.body.classList.toggle('sb-sidenav-toggled');
    localStorage.setItem('sb|sidebar-toggle', document.body.classList.contains('sb-sidenav-toggled'));
});
}

});


</script>
</head>

<body>
<div class="col-md" style="padding-left: 20px; padding-top: 20px; padding-bottom: 20px; padding-right: 20px;">
<h3>Student Grade Summary</h3>
<hr>

<?php 
$thedata = getGrade();

echo '<table id ="example" class="table table-bordered table-striped text-center">
<thead>
<tr>
<th scope="col">No</th>';
    echo'
  <th scope="col">Courses </th>
  <th scope="col">Nrp</th> 
  <th scope="col">Name</th>
  <th scope="col">Grade</th>
</tr>
</thead>
<tbody>';


$no=1;


foreach ($thedata as $data) {

    echo'<tr>';
    echo '<th scope="row">'.$no.'</th>';
    $no++;
    echo '<td>'.$data['course_name'].'</td>';

    echo '<td>'.$data['nrp'].'</td>';
    echo '<td>'.$data['name'].'</td>';
    echo '<td>'.($data['grade']).'</td>';
}
    echo '</tr>';
    echo  '</tbody>
                   </table>';


?>


<!-- <p style="padding-bottom: 30px;"></p> -->


    
</div>

</body>
</html>