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


$sheet->setCellValue('A1', '#');
$sheet->setCellValue('B1', 'Nrp');
$sheet->setCellValue('C1', 'Nama');

$cell  = 'D';


echo 'Course ID: ',$_GET['cid'];
echo '<br>';
echo 'Evaluation (Quiz ID) : ',$_GET['eid'];
echo '<br>';

$ch = curl_init();
$url  = 'http://'.$_SERVER['HTTP_HOST'].'/myskrip/zcoba/listeval/method.php?cid='.$_GET['cid']."&eid=".$_GET['eid'];

$homepage = file_get_contents($url);

$jsonArrayResponse = json_decode($homepage, true);

$result = current(array_filter($jsonArrayResponse['data'], function ($e) {
    return $e['question_count'] ;
}));
extract($result);
$resultname = current(array_filter($jsonArrayResponse['data'], function ($e) {
    return $e['cname'] ;
}));
extract($resultname);
$resultqname = current(array_filter($jsonArrayResponse['data'], function ($e) {
    return $e['quizname'] ;
}));
extract($resultqname);

$kodeunit = '15';

$kodemk = extractCode($cname);
$semester = extractSemesterValue($cname);
$pr = extractYearValue($cname);
// var_dump($semester);
// var_dump($pr);
//$periode = '2022S1';
$periode = $pr.'S'.$semester;
//echo $periode;


$total_questions = $question_count;
echo 'Course: ',$cname;
echo '<br>';
echo 'Quiz Name: ',$quizname;
echo '<br>';

echo '<p class="md-5">Number of quiz question : ',$total_questions,'</p>';

$token = hasher("$periode,$kodeunit,$kodemk");
$chobe = curl_init();

$urlobe  = 'https://obe.petra.ac.id/serviceout.php?t=get_asesmen_list&kodemk='.$kodemk."&periode=".$kodeunit."&periode=".$periode.'&kodeunit=15&token='.$token;


if (!$homepageobe = @file_get_contents($urlobe)) {
    $error = error_get_last();
    echo "HTTP request failed. Error was: " . $error['message'];
  } else {
    $jsonArrayResponseObe = json_decode($homepageobe, true);
    $searchString = $quizname;
  $filteredarray = isObeEval($jsonArrayResponseObe,$searchString);
  
  
  $arrsoal = array();
  $arrmaxgrade = array();
  
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
  //var_dump($arrmaxgrade);
  echo "Details :";
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
            //var_dump($jsonArrayResponse);
            foreach ($jsonArrayResponse['data'] as $data) 
            {       
              //echo $arrmaxgrade[$data['qnumber']-1];
                if($data['answervalue'] > $arrmaxgrade[$data['qnumber']-1])
                {
                    echo' <li><b>Grade Requirement</b>  <span class="cross">&#10006</span> </li>';
                    echo' <li><b>Maximum grade exceeds on number '.$data['qnumber'].' with student NRP : '.$data['username'].'</b></li>';
                }
               
                
            }
        //    foreach ($jsonArrayResponse['data'] as $data) {
 
        //      $temparr = array();
        //      if ($ind == $total_questions-1)
        //      {
        //        $ind = 0;
        //      }
        //      if(isset($temp) ? !($temp == $data['username']) : true) {
     
        //        if($data['answervalue'] > $arrmaxgrade[$ind])
        //        {
        //            echo' <li><b>Grade Requirement</b>  <span class="cross">&#10006</span> </li>';
        //            echo' <li><b>Maximum grade exceeds on number '.($data['username']).'</b></li>';
        //        }
               
        //        $ind++;
                 
     
        //      } elseif(isset($temp) ? ($temp == $data['username']) : true) {

        //          $cell++;
        //          if($data['answervalue'] > $arrmaxgrade[$ind])
        //          {
        //              echo' <li><b>Grade Requirement</b>  <span class="cross">&#10006</span> </li>';
        //              echo' <li><b>Maximum grade exceeds on number '.($data['username']).'</b></li>';
        //          }
     
        //      }
     
        //      $temp = $data['username'];
        //  }
  
          }
  
  }

    // echo '<li><b>Grade Requirement</b>  <span class="cross">&#10006</span></li>','<br>';


    // echo '<li><b>Grade Requirement</b>  <span class="check">&#10004</span></li>','<br>';

echo '<table id ="example" class="table table-bordered table-striped text-center">
<thead>
<tr>
<th scope="col">No</th>';
echo'
<th scope="col">Nrp </th>
<th scope="col">Nama</th> ';
for ($x = 1; $x <= $total_questions; $x++) {
    echo '<th scope="col">No ',$x,'</th>';
}

echo'
</tr>
</thead>
<tbody>';

$no=1;
$indexnumber = 0;

foreach ($jsonArrayResponse['data'] as $data) {

    $temparr = array();


    if(isset($temp) ? !($temp == $data['username']) : true) {

        echo'<tr>';
        echo '<th scope="row">'.$no.'</th>';
        echo '<td>'.$data['username'].'</td>';

        echo '<td>'.$data['name'].'</td>';


         echo '<td>'.($data['answervalue']).'</td>';
        
        


        $temparr['no']=$no;
        $temparr['nrp']=$data['username'];
        $temparr['name']=$data['name'];
        $nilaiq= explode(",", $data['answervalue']);


        // else{
        //     echo '<td>'.($data['answervalue']*10).'</td>';
        // }



        foreach ($nilaiq as $dnilai) {
            array_push($temparr, $dnilai);
        }

        $no++;
        $indexnumber++;


    } elseif(isset($temp) ? ($temp == $data['username']) : true) {




            echo '<td>'.($data['answervalue']).'</td>';
        
        
        $cell++;

        


        $nilaiq= explode(",", $data['answervalue']);


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

//echo 'Total data : ',count($arraycoba),'<br>';
echo 'Total question : ',$total_questions,'<br>';

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
//$downloadsheet->getActiveSheet()->setCellValue($acel.$tindex, '=AVERAGE('.$acel.'2'.':'.$acel.$totalrow.')');
$downloadsheet->getActiveSheet()->setCellValue($acel.$tindex, '0');

$acel++;

}



$downloadsheet->getActiveSheet()->setCellValue('A'.$tindex, 'Avg');

$cname .= ' - ' . $quizname;
$cname .= '.xls';


echo       '</tbody>
</table>';

echo '<div class = "py-3" >


<a href="file/'.$cname.'">
<button name="excel" class="btn btn-success "><i class="fa fa-save"></i> Download Excel </button>
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
?>