<?php 
require_once "method.php";

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

<title>Student List</title>

<script>
    $(document).ready(function () {
$('#example').DataTable(
    {
        responsive: true
    }
);
});
window.addEventListener('DOMContentLoaded', event => {

// Toggle the side navigation
const sidebarToggle = document.body.querySelector('#sidebarToggle');
if (sidebarToggle) {
// Uncomment Below to persist sidebar toggle between refreshes
// if (localStorage.getItem('sb|sidebar-toggle') === 'true') {
//     document.body.classList.toggle('sb-sidenav-toggled');
// }
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
<h3>Student</h3>
<hr>


<?php 
$thedata = getStudentGrade();

echo '<table id ="example" class="table table-bordered table-striped text-center">
<thead>
<tr>
<th scope="col">No</th>';
    echo'
  
  <th scope="col">Nrp</th> 
  <th scope="col">Name</th>
  <th scope="col">Courses </th>
  <th scope="col">Assesment </th>
  <th scope="col">Question Number </th>
  <th scope="col">Grade</th>
  <th scope="col">Action</th>
</tr>
</thead>
<tbody>';


$no=1;


foreach ($thedata as $data) {

    echo'<tr>';
    echo '<th scope="row">'.$no.'</th>';
    $no++;

    echo '<td>'.$data['nrp'].'</td>';
    echo '<td>'.$data['name'].'</td>';
    echo '<td>'.$data['course_name'].'</td>';
    echo '<td>'.$data['eval_name'].'</td>';
    echo '<td>'.$data['qnumber'].'</td>';
    echo '<td>'.(number_format($data['grade_per_number'],1)).'</td>';
    echo '<td> <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#myModalEdit'.$data['nrp'].'-'.$data['courses_id'].'-'.$data['id'].'-'.$data['qnumber'].'"><i class="fa fa-edit"></i></button>
    </td>';

    echo '     
    <div id="myModalEdit'.$data['nrp'].'-'.$data['courses_id'].'-'.$data['id'].'-'.$data['qnumber'].'" class="modal fade" role="dialog">
    <div class="vertical-alignment-helper">
       <div class="modal-dialog" role="document">
          <div class="modal-content">
             <div class="modal-header text-center">
                <h4 class="modal-title w-100 font-weight-bold"><i class="fa fa-newspaper-o"> </i> Edit Grade</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
             </div>

            

             <div class="modal-body mx-3" method="POST">
                <form class="form-signin" action ="editstudent.php" method="POST">

             <div class="md-form mb-4">
             <i class="fa fa-newspaper-o prefix grey-text"> </i> <label for="inputrname">  Course  Name </label>
             <input type="text"  name="cname" class="form-control validate" value="'.$data['course_name'].'" readonly >
          </div>

          <div class="md-form mb-4">
          <i class="fa fa-newspaper-o prefix grey-text"> </i> <label for="inputrname">  Evaluation  Name </label>
          <input type="text"  name="ename" class="form-control validate" value="'.$data['eval_name'].'" readonly >
       </div>

    <div class="md-form mb-4">
    <i class="fa fa-newspaper-o prefix grey-text"> </i> <label for="inputrname">  Student  NRP </label>
    <input type="text" name="nrp" class="form-control validate"  value='.$data['nrp'].' readonly >
 </div>

 <div class="md-form mb-4">
 <i class="fa fa-newspaper-o prefix grey-text"> </i> <label for="inputrname">  Student  Name </label>
 <input type="text" name="studentname" class="form-control validate"  value='.$data['name'].' readonly >
</div>

<div class="md-form mb-4">
<i class="fa fa-newspaper-o prefix grey-text"> </i> <label for="inputrname">  Question Number </label>
<input type="text" name="questionnumber" class="form-control validate"  value='.$data['qnumber'].' readonly >
</div>

<div class="md-form mb-4">
<i class="fa fa-newspaper-o prefix grey-text"> </i> <label for="inputrname">  Grade Value </label>

<input type="hidden" name="cid" class="form-control validate"  value='.$data['courses_id'].' >
<input type="hidden" name="eid" class="form-control validate"  value='.$data['id'].' >
<input type="hidden" name="qnum" class="form-control validate"  value='.$data['qnumber'].' >
<input type="text"  name="enum" class="form-control validate" value="'.($data['grade_per_number']).'" >
</div>

       

                   <div class="modal-footer d-flex justify-content-center">
                      <button id="redit" class="btn btn-default btn-primary btn-block text-uppercase"><i class="fa fa-edit ">  </i> Edit</button>
                   </div>
                </form>
                  </div>
              </div>
          </div>
      </div>
    </div>';

//     echo '     
// <div id="myModalDelete'.$data['nrp'].'-'.$data['courses_id'].'-'.$data['id'].'-'.$data['qnumber'].'" class="modal fade" role="dialog">
// <div class="vertical-alignment-helper">
//    <div class="modal-dialog" role="document">
//       <div class="modal-content">
//          <div class="modal-header text-center">
//             <h4 class="modal-title w-100 font-weight-bold"><i class="fa fa-newspaper-o"> </i> Delete Student Grade</h4>
//             <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
//          </div>
//          <div class="modal-body mx-3" method="POST">
//             <form class="form-signin" action ="deletenews.php" method="POST">
//                <div class="md-form mb-4 text-center">
//                   <i class="fa fa-exclamation-triangle fa-3x prefix text-warning"> </i> <br><label for="inputrname">  Are you sure want to delete '.$data['course_name'].' ?</label>
//                   <input type="hidden" id="inputnid" name="nid" class="form-control validate"  value='.$data['id'].' >
//                </div>
//                <div class="modal-footer d-flex justify-content-center">
//                   <button id="redit" class="btn btn-default btn-danger btn-block text-uppercase"><i class="fa fa-trash ">  </i> Delete</button>
//                </div>
//             </form>
//               </div>
//           </div>
//       </div>
//   </div>
// </div>';

}


    echo '</tr>';
    echo  '</tbody>
                   </table>';

                  


?>

<!-- <p style="padding-bottom: 30px;"></p> -->


</div>

</body>
</html>