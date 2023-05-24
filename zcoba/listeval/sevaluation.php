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
$resultname = current(array_filter($jsonArrayResponse['data'], function ($e) {
    return $e['cname'] ;
}));

extract($result);
extract($resultname);
$total_questions = $question_count;
echo 'Course: ',$cname;
echo '<br>';

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
<th scope="col">Nama</th> ';
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

        echo '<td>'.$data['name'].'</td>';
        echo '<td>'.($data['answervalue']*10).'</td>';


        $temparr['no']=$no;
        $temparr['nrp']=$data['username'];
        $temparr['name']=$data['name'];
        $nilaiq= explode(",", $data['answervalue']*10);




        foreach ($nilaiq as $dnilai) {
            array_push($temparr, $dnilai);
        }

        $no++;


    } elseif(isset($temp) ? ($temp == $data['username']) : true) {

        $cell++;

        echo '<td>'.($data['answervalue']*10).'</td>';


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






$downloadsheet->getActiveSheet()->setCellValue('A1', '#');
$downloadsheet->getActiveSheet()->setCellValue('B1', 'Nrp');
$downloadsheet->getActiveSheet()->setCellValue('C1', 'Nama');

$cellnya = 'D';

for ($x = 1; $x <= $total_questions; $x++) {


  $thead = $cellnya.'1';
  $downloadsheet->getActiveSheet()->setCellValue($thead, 'No '.$x);
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