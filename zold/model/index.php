<?php

 ?>

<?php 

require_once 'model_course.php';

// if($_SERVER["REQUEST_METHOD"]=="POST")
// {
// $rin = $_POST['name'];
// $rip = $_POST['phone'];
// //$rit = $_POST['alamat'];
// if (!empty($rin) && !empty($rip))
// {
//     $ppl = new TheUser();
//     $ppl -> insert_people($rin,$rip);
// }
// else{
//     header('Location: ' . $_SERVER['HTTP_REFERER']);
// }
// }

$corse = new MoodleCourse();

$corse ->getCourse();

?>