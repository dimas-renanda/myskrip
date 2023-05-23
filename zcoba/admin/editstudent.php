<?php 
require_once "../conf/safety.php";
require_once "../assets/assets.php";
require_once "../condb/connect.php";
if($_SERVER["REQUEST_METHOD"]=="POST")
{

$cid = $_POST['cid'];
$eid = $_POST['eid'];
$nrp = $_POST['nrp'];
$qnum = $_POST['qnum'];
$enum = $_POST['enum'];
 
  $sql_update = "UPDATE grade set `grade_per_number`= '$enum' 
  where courses_id = $cid AND
  evaluation_id=$eid AND
  nrp='$nrp' AND
  qnumber=$qnum";



  $stmt = $conn->prepare($sql_update);
  $stmt->execute();

  if ($stmt) 
  {

    echo '<script>
    Swal.fire({
        title: "Success!",
        text: "Student Grade Edited ...",
        icon: "success",
        showConfirmButton: true,
  </script>';

  $sql = " delete from student;
REPLACE INTO student (courses_id,nrp,name,grade)
 SELECT courses_id,nrp,name, SUM(grade_per_number) 
 AS total FROM grade 
 GROUP BY nrp, courses_id";
 $stmtt = $conn->prepare($sql);
 $stmtt->execute();

 if ($stmtt) 
  {

    echo '<script>
    Swal.fire({
        title: "Success !",
        text: "Student Grade Syncron ...",
        icon: "success",
        showConfirmButton: true,
        timer: 3000
    }).then(function() {
        window.location.href = "http://localhost/myskrip/zcoba/admin?page=student"; // Replace with your desired URL
    });
  </script>';
  }

  else{
    echo "<script>Something when wrong...');</script>";
    header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit;
  }

  }
  else{
    echo "<script>Something when wrong...');</script>";
    header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit;
  }


}
?>