<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css">
  
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script>

    <title>News</title>

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
<h3>Course List</h3>
<hr>



<p style="padding-bottom: 30px;"></p>


<?php 


$ch = curl_init();
    $url  = 'http://'.$_SERVER['HTTP_HOST'].'/myskrip/api/course/course.php?id='.$_SESSION['username'];
    $homepage = file_get_contents($url);
    //var_dump($homepage);
    $jsonArrayResponse = json_decode($homepage,true);

echo '<table id ="example" class="table table-bordered table-striped text-center">
<thead>
<tr>
<th scope="col">No</th>';
 // <th scope="col">Id</th>
  //echo' <th scope="col">Course ID</th>';
  echo'
  <th scope="col">Course </th>
  <th scope="col">Course Name</th>
<th scope="col">Action</th>
</tr>
</thead>
<tbody>';
$no=1;
              foreach ($jsonArrayResponse['data'] as $data) {


          echo '<tr>';
          echo '<th scope="row">'.$no.'</th>';
          $no++;
         //  echo '<th scope="row">'.$data['id'].'</th>';
         // echo '<td>'.$data['id'].'</td>';
          echo '<td>'.$data['fullname'].'</td>';
          echo '<td>'.$data['shortname'].'</td>';
          echo '<td >      <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#myModal'.$data['id'].'"><i class="fa fa-eye"></i></button>';
          //<button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#myModaldelete'.$data['id'].'"><i class="fa fa-trash"></i></button>
          echo '</td>';


          
        echo'</tr>';

echo '      <!-- List Evaluation -->
<div id="myModal'.$data['id'].'" class="modal fade" role="dialog">
<div class="vertical-alignment-helper">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header text-center">
            <h4 class="modal-title w-100 font-weight-bold"><i class="fa fa-newspaper-o"> </i> Evaluation</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body mx-3" method="POST">
            <form class="form-signin" action ="../evaluation/index.php" method="POST" enctype="multipart/form-data">
               <div class="md-form mb-4">
                  <i class="fa fa-newspaper-o prefix grey-text"> </i> <label for="inputrname">  Course Full Name </label>
                  <input type="hidden" name="id" class="form-control validate"  value='.$data['id'].' >
                  <input type="text"  name="title" class="form-control validate" value="'.$data['fullname'].'" readonly>
               </div>

               <div class="md-form mb-4">
               <i class="fa fa-file-text prefix grey-text">  </i> <label for="inputrusername"> Course Short Name </label>
               <input type="text"  name="name" class="form-control validate" value="'.$data['shortname'].'" readonly>
            </div>';

echo '
               <div class="md-form mb-4">
               <i class="fa fa-file-text prefix grey-text">  </i> <label for="inputrusername"> Assesment </label>
               <select name="eval" class="form-select" aria-label="Default select example">
               <option selected>-</option>';

               $ch = curl_init();

   
    $evalurl  = 'http://'.$_SERVER['HTTP_HOST'].'/myskrip/api/evaluation/evaluation.php?id='.$data['id'];


    $dataeval = file_get_contents($evalurl);
    //var_dump($homepage);
    $jsonArrayEvalResponse = json_decode($dataeval,true);
foreach ($jsonArrayEvalResponse['data'] as $dataev) {
   echo '<option value="'.$dataev['Quiz ID'].'">'.$dataev['Quiz Name'].'</option>';
}

 echo'              
             </select>
            </div>';

echo '
               <div class="modal-footer d-flex justify-content-center">
                  <button id="redit" class="btn btn-default btn-dark btn-block text-uppercase"><i class="fa fa-edit prefix grey-text">  </i> Get Assesment</button>
               </div>
            </form>
              </div>
          </div>
      </div>
  </div>
</div>';


echo '      <!-- Delete News -->
<div id="myModaldelete'.$data['id'].'" class="modal fade" role="dialog">
<div class="vertical-alignment-helper">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header text-center">
            <h4 class="modal-title w-100 font-weight-bold"><i class="fa fa-newspaper-o"> </i> Delete News</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body mx-3" method="POST">
            <form class="form-signin" action ="deletenews.php" method="POST">
               <div class="md-form mb-4 text-center">
                  <i class="fa fa-exclamation-triangle fa-3x prefix text-warning"> </i> <br><label for="inputrname">  Are you sure want to delete '.$data['fullname'].' ?</label>
                  <input type="hidden" id="inputnid" name="nid" class="form-control validate"  value='.$data['id'].' >
               </div>
               <div class="modal-footer d-flex justify-content-center">
                  <button id="redit" class="btn btn-default btn-danger btn-block text-uppercase"><i class="fa fa-trash ">  </i> Delete</button>
               </div>
            </form>
              </div>
          </div>
      </div>
  </div>
</div>';

      }
      echo       '</tbody>
</table>';
?>
    
</div>

</body>
</html>

