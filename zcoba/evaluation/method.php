<?php 
require_once "../conf/safety.php";

function saveCourses()
{

    $ch = curl_init();
    $url  = "http://localhost/myskrip/api/studentgrade/studentgrade.php?id=".$_POST['id']."&eval=".$_POST['eval'];
    //echo $url;
    $homepage = file_get_contents($url);
    //var_dump($homepage);
    $jsonArrayResponse = json_decode($homepage, true);

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

 

}

function saveEvaluation($eid,$cid,$en,$ca)
{
    
}

function saveStudent($sid,$cid,$nrp,$grd)
{
    
}

function saveGrade($cid,$eid,$nrp,$nama,$qc,$gpn)
{
    
}

$content = @$_GET['context'];
if ($content=='save')
{
    echo 'get save be4rhasil';
    echo $_POST['id'];echo $_POST['eval'];
    saveCourses();
}
elseif($content=='file')
{
    require_once '../file/file.php';
}
elseif($content=='eval')
{
    require_once '../evaluation/index.php';
}
elseif($content=='student')
{
    require_once '../student/index.php';
}
elseif($content=='grade')
{
    require_once '../grade/index.php';
}
else{

    echo'
    <div class="container-fluid">
    <h1 class="mt-4">Welcome to OBE tools !</h1>
    <p>The starting state of the menu will appear collapsed on smaller screens, and will appear non-collapsed on larger screens. When toggled using the button below, the menu will change.</p>
    <p>
        Make sure to keep all page content within the
        <code>#page-content-wrapper</code>
        . The top navbar is optional, and just for demonstration. Just create an element with the
        <code>#sidebarToggle</code>
        ID which will toggle the menu when clicked.
    </p> 

    
</div>';
}

?>