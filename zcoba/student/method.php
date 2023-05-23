
<?php 
require_once "../conf/safety.php";
require_once "../condb/connect.php";

function getStudentGrade()
{

global $conn;

		$data=array();

		$stmt = $conn->query("SELECT grade.courses_id, grade.nrp, grade.name, courses.course_name , evaluation.eval_name , grade.qnumber ,grade.grade_per_number
		FROM grade
		JOIN courses ON grade.courses_id = courses.id
		JOIN evaluation ON grade.evaluation_id = evaluation.id
		ORDER by course_name,nrp");

		while($row=$stmt->fetch(PDO::FETCH_ASSOC))
		{
			$data[]=$row;
		}
		$response=$data;
		return($response);
}

?>