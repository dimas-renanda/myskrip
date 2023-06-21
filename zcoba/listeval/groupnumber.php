<?php 
require_once "../conf/safety.php";
require_once "../assets/assets.php";
require_once "../condb/connect.php";
if($_SERVER["REQUEST_METHOD"]=="POST")
{

$mx = $_POST['max']/100;
$fqn = $_POST['fqnumber'];
$tqn = $_POST['tqnumber'];
$cid = $_POST['cid'];
$eid = $_POST['eid'];

//echo $mx,' ',$fqn,' ',$tqn,' ',$cid,' ',$eid,' ';
 
//exit;
// $sql_update = "update grade a
// inner join grade b on a.id <> b.id
//   set a.grade_per_number = b.grade_per_number
// where a.qnumber in ($fqn,$tqn) and b.qnumber in ($fqn,$tqn) 
// AND a.nrp = '$nrp'
// AND b.nrp = '$nrp'
// AND a.courses_id = $cid
// AND b.courses_id = $cid
// AND a.evaluation_id = $eid
// AND b.evaluation_id = $eid";

$sql_update = "update grade a
inner join grade b on a.id <> b.id
  set a.grade_per_number = (a.grade_per_number + b.grade_per_number) * $mx
where a.qnumber in ($fqn,$tqn) and b.qnumber in ($fqn,$tqn) 
AND a.nrp = b.nrp 
AND a.courses_id = $cid
AND b.courses_id = $cid
AND a.evaluation_id = $eid
AND b.evaluation_id = $eid;

update grade set question_count = question_count-1
where courses_id = $cid
AND evaluation_id = $eid;

delete from grade 
where qnumber = $tqn
AND courses_id = $cid
AND evaluation_id = $eid;";


  $stmt = $conn->prepare($sql_update);
  $stmt->execute();

 
if ($stmt) {
  echo '<script>
      Swal.fire({
          title: "Success !",
          text: "Student Grade Groupped ... ",
          icon: "success",
          showConfirmButton: true,
          timer: 10000
      }).then(function() {
          window.location.href = "http://'.$_SERVER['HTTP_HOST'].'/myskrip/zcoba/listeval/index.php"; // Replace with your desired URL
      });
    </script>';
  //echo $sql_update;
}
else{
  echo "<script>Something when wrong...');</script>";
  header('Location: ' . $_SERVER['HTTP_REFERER']);
          exit;
}
      
    



  



}
?>