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


$sheet->setCellValue('A1', '#');
$sheet->setCellValue('B1', 'Nrp');
$sheet->setCellValue('C1', 'Nama');

$cell  = 'D';
//$cname = $_POST['name'];


echo 'Course ID: ',$_GET['cid'];
echo '<br>';
echo 'Evaluation (Quiz ID) : ',$_GET['eid'];
echo '<br>';

$ch = curl_init();
$url  = "http://localhost/myskrip/zcoba/listeval/method.php?cid=".$_GET['cid']."&eid=".$_GET['eid'];
//echo $url;
$homepage = file_get_contents($url);
//var_dump($homepage);
$jsonArrayResponse = json_decode($homepage, true);



$result = current(array_filter($jsonArrayResponse['data'], function ($e) {
    return $e['question_count'] ;
}));
$resultname = current(array_filter($jsonArrayResponse['data'], function ($e) {
    return $e['cname'] ;
}));


//print_r($result);
extract($result);
extract($resultname);
$total_questions = $question_count;
echo 'Course: ',$cname;
echo '<br>';
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

        echo '<td>'.$data['name'].'</td>';
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
        $temparr['name']=$data['name'];

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
echo $arraycoba[$x],'   ';
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
//$downloadsheet->getActiveSheet()->fromArray($templatedata, null, 'A2');



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

$writer->save('mantap.xls');


$writer->save('file/' . $cname );
?>