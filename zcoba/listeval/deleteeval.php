<?php 
require_once "../conf/safety.php";
require_once "../assets/assets.php";
require_once "../condb/connect.php";
if($_SERVER["REQUEST_METHOD"]=="POST")
{

$cid = $_POST['cid'];
$eid = $_POST['eid'];
 
  $sql_update = "DELETE FROM evaluation WHERE id = $eid AND courses_id = $cid ";



  $stmt = $conn->prepare($sql_update);
  $stmt->execute();

  if ($stmt) 
  {

    $sqld = "DELETE FROM grade WHERE courses_id = $cid ";
    $stmtt = $conn->prepare($sqld);
    $stmtt->execute();

    if ($stmtt)
    {
      $sqlds = "DELETE FROM student WHERE courses_id = $cid ";
    $stmtts = $conn->prepare($sqlds);
    $stmtts->execute();

if ($stmtts) {
  echo '<script>
      Swal.fire({
          title: "Success !",
          text: "Evaluation and Grade Deleted ... ",
          icon: "success",
          showConfirmButton: true,
          timer: 10000
      }).then(function() {
          window.location.href = "http://localhost/myskrip/zcoba/listeval/index.php"; // Replace with your desired URL
      });
    </script>';
}
else{
  echo "<script>Something when wrong...');</script>";
  header('Location: ' . $_SERVER['HTTP_REFERER']);
          exit;
}
      
    }



  }



}
?>