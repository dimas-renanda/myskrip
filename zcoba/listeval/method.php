
<?php 

require_once "../condb/connect.php";


$cid = $_GET['cid'];
$eid = $_GET['eid'];
//$cname = $_GET['name'];
 
// echo $cid, '  ',$eid;





$conn;

$data=array();
$stmt = $conn->query(" SELECT courses.id,courses.course_name AS cname,evaluation_id,evaluation.eval_name AS quizname,nrp AS username,name,question_count,qnumber,grade_per_number AS answervalue 
from grade JOIN evaluation ON grade.evaluation_id = evaluation.id 
JOIN courses ON grade.courses_id = courses.id WHERE grade.courses_id = $cid AND evaluation_id = $eid order by nrp");

while($row=$stmt->fetch(PDO::FETCH_ASSOC))
{
    $data[]=$row;
}
$response=array(
                    'status' => 1,
                    'message' =>'Get List Some Student Mark Grade Eval Successfully.',
                    'data' => $data
                );
header('Content-Type: application/json');
echo json_encode($response);

?>

