<?php 
require_once "../conf/safety.php";
require_once "../assets/assets.php";
require '../file/vendor/autoload.php';
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

<title>Evaluation </title>

<style>

.cross {
  color: red;
}

.check {
  color: #00ff00;
}

</style>

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
<h3>Quiz Evaluation</h3>
<hr>

<!-- <p style="padding-bottom: 30px;"></p> -->

<?php 


// Import the core class of PhpSpreadsheet
use PhpOffice\PhpSpreadsheet\Spreadsheet;

// Import the Xlsx writer class
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Create a new Spreadsheet object
$spreadsheet = new Spreadsheet();
$downloadsheet = new Spreadsheet();
// Retrieve the current active worksheet
$sheet = $spreadsheet->getActiveSheet();

// Set cell A1 with the "#" string value



if (!empty($_POST['id'])) {

  if(!empty($_GET['save']))
{
  echo 'Berhasil Masuk Save !' ;
}

    $sheet->setCellValue('A1', '#');
    $sheet->setCellValue('B1', 'Nrp');
    $sheet->setCellValue('C1', 'Nama');

    $cell  = 'D';

    echo 'Course ID: ',$_POST['id'];
    echo '<br>';
    echo 'Course: ',$_POST['name'];
    echo '<br>';
    echo 'Evaluation (Quiz ID) : ',$_POST['eval'];
    echo '<br>';

    $ch = curl_init();
    $url  = "http://localhost/myskrip/api/studentgrade/studentgrade.php?id=".$_POST['id']."&eval=".$_POST['eval'];
    //echo $url;
    $homepage = file_get_contents($url);
    //var_dump($homepage);
    $jsonArrayResponse = json_decode($homepage, true);

    $result = current(array_filter($jsonArrayResponse['data'], function ($e) {
      return $e['quizname'] ;
  }));
  extract($result);

  echo '<p class="">Quiz Name : ',$quizname,'</p>';

    $chqnumber = curl_init();
    $urlchq  = "http://localhost/myskrip/api/quiz/quiz.php?id=".$_POST['eval'];
    //echo $urlchq;
    $homepagechq = file_get_contents($urlchq);
    //var_dump($homepagechq);
    $jsonArrayResponsechq = json_decode($homepagechq, true);
    //var_dump($jsonArrayResponsechq);
    $result = current(array_filter($jsonArrayResponsechq['data'], function ($e) {
        return $e['total_questions'] ;
    }));

    //print_r($result);
    extract($result);
    //var_dump($qnumber);
    echo '<p class="md-5">Number of quiz question : ',$total_questions,'</p>';

    echo '<li><b>Course Available</b>  <span class="cross">&#10006</span></li>
<li><b>Assesment Available</b>  <span class="cross">&#10006</span></li>
<li><b>Number of Question</b>  <span class="check">&#10004</span></li>
<li><b>Grade requirement</b>  <span class="check">&#10004</span></li>','<br>';

    echo '<table id ="example" class="table table-bordered table-striped text-center">
<thead>
<tr>
<th scope="col">No</th>';
    echo'
  <th scope="col">Nrp </th>
  <th scope="col">Nama</th> <th scope="col">Submited at</th>';
    for ($x = 1; $x <= $total_questions; $x++) {
        echo '<th scope="col">No ',$x,'</th>';
    }

    echo'
</tr>
</thead>
<tbody>';

    $no=1;


    foreach ($jsonArrayResponse['data'] as $data) {

        $temparr = array();

        // $temparr['nrp']=$data['username'];
        // $temparr['name']=$data['firstname'].' '.$data['lastname'];
        // $temparr['nomor']=$data['answervalue']*10;

        if(isset($temp) ? !($temp == $data['username']) : true) {
            //$templatedata[]=',';

            //echo $data['firstname'];

            //  echo '<th scope="row">'.$data['id'].'</th>';
            // echo '<td>'.$data['id'].'</td>';
            echo'<tr>';
            echo '<th scope="row">'.$no.'</th>';
            echo '<td>'.$data['username'].'</td>';

            echo '<td>'.$data['firstname'].' '.$data['lastname'].'</td>';
            echo '<td>'.$data['quizsubmitdate'].'</td>';
            echo '<td>'.intval($data['answervalue']*10).'</td>';

            // $sheet->setCellValue('A'.$no, $no-1);
            //$templatedata[]=$data['username'];
            //$sheet->setCellValue('B'.$no, $data['username']);
            //$templatedata[]=$data['firstname'].' '.$data['lastname'];
            //$sheet->setCellValue('C'.$no, $data['firstname'].' '.$data['lastname']);
            //$templatedata[]=$data['answervalue']*10;
            //$sheet->setCellValue($cell.$no, $data['answervalue']*10);

            $temparr['no']=$no;
            $temparr['nrp']=$data['username'];
            $temparr['name']=$data['firstname'].' '.$data['lastname'];

            //$temparr['nomor']=$data['answervalue']*10;
            $nilaiq= explode(",", $data['answervalue']*10);




            foreach ($nilaiq as $dnilai) {
                array_push($temparr, $dnilai);
            }

            $no++;






        } elseif(isset($temp) ? ($temp == $data['username']) : true) {

            $cell++;


            echo '<td>'.intval($data['answervalue']*10).'</td>';



            $nilaiq= explode(",", $data['answervalue']*10);




            foreach ($nilaiq as $dnilai) {
                array_push($temparr, $dnilai);
            }





        }

        $temp = $data['username'];
        $templatedata[] = $temparr;
    }

    //var_dump($templatedata);
    //var_dump($temparr);

    $arraycoba = array();
    foreach($templatedata as $x)
    {
      foreach($x as $y)
      {
        $arraycoba[] = $y;
        
      }
    }
    //var_dump($arraycoba);
    echo 'Total data : ',count($arraycoba),'<br>';
    echo 'Total question : ',$total_questions,'<br>';
    // foreach($arraycoba as $y)
    // {
    
    //   echo  $y,'   ';
    
     
    
    // }
    
    for ($x = 0; $x < count($arraycoba); $x++) 
    {


      if ($x % ($total_questions + 3) == 0 )
      {
        echo '<br>'; ///indexalphabetditambahjadirow kebaawah
      }
      echo $arraycoba[$x],'   ';

    }
    
    echo '<br>';







    foreach ($templatedata as $data) {

        //echo @$data['nrp'],' ',@$data['name'],' ',@$data['nomor'],' ';

    }
    echo '</tr>';

    $hasilnilai = 0;
    $cellnya = 'A';
    $downloadsheet->getActiveSheet()->setCellValue('A1', '#');
    $downloadsheet->getActiveSheet()->setCellValue('B1', 'Nrp');
    $downloadsheet->getActiveSheet()->setCellValue('C1', 'Nama');
    $downloadsheet->getActiveSheet()->fromArray($templatedata, null, 'A2');



    echo       '</tbody>
</table>';

echo '<div class = "py-3" >

<form class="form-signin" action ="method.php?context=save" method="POST" enctype="multipart/form-data">

           <div class="md-form mb-4">
              <input type="hidden" name="id" class="form-control validate"  value="'.$_POST['id'].'"" >
              <input type="hidden" name="eval" class="form-control validate"  value="'.$_POST['eval'].'" >
           </div>
    <br>
    <button type="submit" name="save" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
    <button type="submit" name="excel" class="btn btn-success "><i class="fa fa-save"></i> Download Excel </button>
</div>

</form>



</div>';

    // Write a new .xlsx file
    $writer = new Xlsx($downloadsheet);

    // Save the new .xlsx file
    $writer->save('create-xlsx-files.xls');

    


    
    
    

}

elseif (empty($_POST['id']))
{
    echo "<script>const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
          confirmButton: 'btn btn-success',
          cancelButton: 'btn btn-danger'
        },
        buttonsStyling: true
      })
      
      swalWithBootstrapButtons.fire({
        title: 'Are you sure?',
        text: 'You wont be able to revert this!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, cancel!',
        reverseButtons: true
      }).then((result) => {
        if (result.isConfirmed) {
          swalWithBootstrapButtons.fire(
            'Deleted!',
            'Your file has been deleted.',
            'success'
          )
        } else if (
          /* Read more about handling dismissals below */
          result.dismiss === Swal.DismissReason.cancel
        ) {
          swalWithBootstrapButtons.fire(
            'Cancelled',
            'Your imaginary file is safe :)',
            'error'
          )
        }
      })</script>";
    echo 'Evaluation List';
}

    
// echo '      <!-- Alert -->
// <div id="myModalAlert" class="modal fade" role="dialog">
// <div class="vertical-alignment-helper">
//    <div class="modal-dialog" role="document">
//       <div class="modal-content">
//          <div class="modal-header text-center">
//             <h4 class="modal-title w-100 font-weight-bold"><i class="fa fa-newspaper-o"> </i> Delete News</h4>
//             <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
//          </div>
//          <div class="modal-body mx-3" method="POST">
//             <form class="form-signin" action ="deletenews.php" method="POST">
//                <div class="md-form mb-4 text-center">
//                   <i class="fa fa-exclamation-triangle fa-3x prefix text-warning"> </i> <br><label for="inputrname">  Are you sure want to delete  ?</label>
//                   <input type="hidden" id="inputnid" name="nid" class="form-control validate"  value="0" >
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

?>
        
</div>

</body>
</html>