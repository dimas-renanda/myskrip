<?php 
require_once "../conf/safety.php";
require_once "../assets/assets.php";
require_once "../evaluation/methodobe.php";
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
<h3>Quiz Evaluation</h3>
<hr>

<?php 

use PhpOffice\PhpSpreadsheet\Spreadsheet;

use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$downloadsheet = new Spreadsheet();

$sheet = $spreadsheet->getActiveSheet();


if (!empty($_POST['id'])) {

  if(empty($_POST['eval']) || $_POST['eval'] == '-' )
{
  $message = "Please select one option !"; 
$redirectUrl = 'http://'.$_SERVER['HTTP_HOST'].'/myskrip/zcoba/admin/?page=course'; 

echo '<script>';
echo 'document.addEventListener("DOMContentLoaded", function() {';
echo 'Swal.fire({';
echo '  title: "Warning!",';
echo '  text: "'. $message .'",';
echo '  icon: "warning",';
echo '  timer: 3000,';
echo '  timerProgressBar: true,';
echo '  showConfirmButton: false';
echo '}).then(function() {';
echo '  window.location.href = "'. $redirectUrl .'";'; 
echo '});';
echo '});';
echo '</script>';
}

    $sheet->setCellValue('A1', '#');
    $sheet->setCellValue('B1', 'Nrp');
    $sheet->setCellValue('C1', 'Nama');


    $cell  = 'D';
    $cname = $_POST['title'];



    $kodeunit = '15';

    $kodemk = extractCode($cname);
    $semester = extractSemesterValue($cname);
    $pr = extractYearValue($cname);
    // var_dump($semester);
    // var_dump($pr);
    //$periode = '2022S1';
    $periode = $pr.'S'.$semester;
    //echo $periode;

    echo 'Course ID: ',$cname;
    echo '<br>';
    // echo 'Course NumID: ',$_POST['id'];
    // echo '<br>';
    echo 'Course: ',extractCode($_POST['title']);
  //  echo '<br>';
    // echo 'Evaluation (Quiz ID) : ',$_POST['eval'];
    $chqnumber = curl_init();
    $urlchq  = 'http://'.$_SERVER['HTTP_HOST'].'/myskrip/api/quiz/quiz.php?id='.$_POST['eval'];

    $homepagechq = file_get_contents($urlchq);

    $jsonArrayResponsechq = json_decode($homepagechq, true);

    $result = current(array_filter($jsonArrayResponsechq['data'], function ($e) {
        return $e['total_questions'] ;
    }));

    extract($result);
    echo '<p>Number of quiz question : ',$total_questions,'</p>';

    $ch = curl_init();
    $url  = 'http://'.$_SERVER['HTTP_HOST'].'/myskrip/api/studentgrade/studentgrade.php?id='.$_POST['id']."&eval=".$_POST['eval'];

    $homepage = file_get_contents($url);

    $jsonArrayResponse = json_decode($homepage, true);

    $resultqname = current(array_filter($jsonArrayResponse['data'], function ($e) {
      return $e['quizname'] ;
  }));
  extract($resultqname);

  echo '<p >Assesment Detail : ','</p>';

$token = hasher("$periode,$kodeunit,$kodemk");
$chobe = curl_init();

$urlobe  = 'https://obe.petra.ac.id/serviceout.php?t=get_asesmen_list&kodemk='.$kodemk."&periode=".$kodeunit."&periode=".$periode.'&kodeunit=15&token='.$token;


if (!$homepageobe = @file_get_contents($urlobe)) {
  $error = error_get_last();
  //echo "HTTP request failed. Error was: " . $error['message'];
  $message = 'Data from obe not found !';
  echo '<script>';
  echo 'document.addEventListener("DOMContentLoaded", function() {';
  echo 'Swal.fire({';
  echo '  title: "Warning!",';
  echo '  text: "'. $message .'",';
  echo '  icon: "warning",';
  echo '  timer: 3000,';
  echo '  timerProgressBar: true,';
  echo '  showConfirmButton: false';
  echo '});';
  echo '});';
  echo '</script>';
} else {
  $jsonArrayResponseObe = json_decode($homepageobe, true);
  $searchString = $quizname;
$filteredarray = isObeEval($jsonArrayResponseObe,$searchString);


$arrsoal = array();
$arrmaxgrade = array();
var_dump($filteredarray);
//var_dump($searchString);
foreach($filteredarray as $data)
{

    if($data['name'] != "")
    {

        echo cleanHeader($data['name']) , '<br>';
        echo 'Number of questions in SIM OBE : ',count($data['soal']),'<br>';
        
        foreach ($data['soal'] as $key => $question) 
        {
            echo  $question . "<br>";
            array_push($arrsoal, $question);
            array_push($arrmaxgrade, extractMaxNumber($question));
            echo 'Max number for this question : '.extractMaxNumber($question) . "<br>";
        }
        echo '<br>';

    }
}
//var_dump($arrsoal);
echo "Everything went better than expected";
echo' <li><b>Assesment Available</b>  <span class="check">&#10004</span></li> ';
if (count($data['soal']) > $total_questions )
        {

          $message = "There are more questions in SIM OBE !"; // Your warning message

          echo '<script>';
          echo 'document.addEventListener("DOMContentLoaded", function() {';
          echo 'Swal.fire({';
          echo '  title: "Warning!",';
          echo '  text: "'. $message .'",';
          echo '  icon: "warning",';
          echo '  timer: 3000,';
          echo '  timerProgressBar: true,';
          echo '  showConfirmButton: false';
          echo '});';
          echo '});';
          echo '</script>';

          echo' <li><b>Number of Question</b>  <span class="cross">&#10006</span></li>';
          

        }
        if(count($data['soal']) < $total_questions)
        {
          $message = "There are less questions in SIM OBE !"; // Your warning message

          echo '<script>';
          echo 'document.addEventListener("DOMContentLoaded", function() {';
          echo 'Swal.fire({';
          echo '  title: "Warning!",';
          echo '  text: "'. $message .'",';
          echo '  icon: "warning",';
          echo '  timer: 3000,';
          echo '  timerProgressBar: true,';
          echo '  showConfirmButton: false';
          echo '});';
          echo '});';
          echo '</script>';

         echo' <li><b>Number of Question</b>  <span class="cross">&#10006</span></li>';

        }

        if(count($data['soal']) == $total_questions)
        {

          echo' <li><b>Number of Question</b>  <span class="check">&#10004</span></li>';
          $ind = 0;
          
          // foreach ($jsonArrayResponse['data'] as $data) 
          // {       
          //     if($data['answervalue'] > $arrmaxgrade[$ind])
          //     {
          //         echo' <li><b>Grade Requirement</b>  <span class="cross">&#10006</span> </li>';
          //         echo' <li><b>Maximum grade exceeds on number '.($ind+1).'</b></li>';
          //     }
          //     $ind++;
              
          // }
          $ind = 0;
        //   foreach ($jsonArrayResponse['data'] as $data) {

        //     $temparr = array();
        //     if ($ind == $total_questions-1)
        //     {
        //       $ind = 0;
        //     }
        //     if(isset($temp) ? !($temp == $data['username']) : true) {
    
        //       if($data['answervalue'] > $arrmaxgrade[$ind])
        //       {
        //           echo' <li><b>Grade Requirement</b>  <span class="cross">&#10006</span> </li>';
        //           echo' <li><b>Maximum grade exceeds on number '.($data['username']).'</b></li>';
        //       }
              
        //       $ind++;
                
    
        //     } elseif(isset($temp) ? ($temp == $data['username']) : true) {
        //       if ($ind == $total_questions-1)
        //       {
        //         $ind = 0;
        //       }
        //         $cell++;
        //         if($data['answervalue'] > $arrmaxgrade[$ind])
        //         {
        //             echo' <li><b>Grade Requirement</b>  <span class="cross">&#10006</span> </li>';
        //             echo' <li><b>Maximum grade exceeds on number '.($data['username']).'</b></li>';
        //         }
    
        //     }
    
        //     $temp = $data['username'];
        // }
          

        }


}

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

        if(isset($temp) ? !($temp == $data['username']) : true) {

            echo'<tr>';
            echo '<th scope="row">'.$no.'</th>';
            echo '<td>'.$data['username'].'</td>';

            echo '<td>'.$data['firstname'].' '.$data['lastname'].'</td>';
            echo '<td>'.$data['quizsubmitdate'].'</td>';
            echo '<td>'.intval($data['answervalue']*10).'</td>';


            $temparr['no']=$no;
            $temparr['nrp']=$data['username'];
            $temparr['name']=$data['firstname'].' '.$data['lastname'];

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



    $arraycoba = array();
    foreach($templatedata as $x)
    {
      foreach($x as $y)
      {
        $arraycoba[] = $y;
        
      }
    }

    echo 'Total data : ',count($arraycoba),'<br>';
    echo 'Total question : ',$total_questions,'<br>';


    echo '<br>';

    echo '</tr>';

    $downloadsheet->getActiveSheet()->setCellValue('A1', '#');
    $downloadsheet->getActiveSheet()->setCellValue('B1', 'Nrp');
    $downloadsheet->getActiveSheet()->setCellValue('C1', 'Nama');

    $cellnya = 'D';

    for ($x = 1; $x <= $total_questions; $x++) {

      
      $thead = $cellnya.'1';
      $downloadsheet->getActiveSheet()->setCellValue($thead, @$arrsoal[$x-1]);
      $cellnya++;

  }

  $tcel = 'A';
  $tindex = 2;

  for ($x = 0; $x < count($arraycoba); $x++) 
  {


    if ($x % ($total_questions + 3) == 0 && $x != 0 )
    {
         
      $tindex++;
      $tcel='A';
    }
    $downloadsheet->getActiveSheet()->setCellValue($tcel.$tindex,$arraycoba[$x]);
    $tcel++;
    
  }
  $totalrow = $tindex;
  $tindex++;
  $acel = 'D';
  for ($x = 1; $x <= $total_questions; $x++) {



    $thead = $cellnya.'1';
    $downloadsheet->getActiveSheet()->setCellValue($acel.$tindex, '=AVERAGE('.$acel.'2'.':'.$acel.$totalrow.')');

    $acel++;

}

  

  $downloadsheet->getActiveSheet()->setCellValue('A'.$tindex, 'Avg');

  $cname .='-'.$quizname;
  $cname .= '.xls';



    echo       '</tbody>
</table>';

echo '<div class = "py-3" >

<form class="form-signin" action ="method.php?context=save" method="POST" enctype="multipart/form-data">

           <div class="md-form mb-4">
              <input type="hidden" name="id" class="form-control validate"  value="'.$_POST['id'].'"" >
              <input type="hidden" name="eval" class="form-control validate"  value="'.$_POST['eval'].'" >
           </div>
    <button type="submit" name="save" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
    
</div>

</form>

<a href="file/'.$cname.'">
<button name="excel" class="btn btn-success "><i class="fa fa-download"></i> Download Excel </button>
</a>

</div>';


    $styleArray = array(
      'font'  => array(
           'bold'  => false,
           'size'  => 12,
           'name'  => 'Arial'
       ));      
    $downloadsheet->getDefaultStyle()->applyFromArray($styleArray);

    $writer = new Xlsx($downloadsheet);

    $writer->save('file/' . $cname );


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

?>
        
</div>

</body>
</html>