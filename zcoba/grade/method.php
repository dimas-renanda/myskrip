
<?php 
require_once "../conf/safety.php";
require_once "../condb/connect.php";

function getGrade()
{

global $conn;

		$data=array();

		$stmt = $conn->query("SELECT courses_id,nrp,name,grade, course_name FROM student 
        JOIN courses where student.courses_id = courses.id");

		while($row=$stmt->fetch(PDO::FETCH_ASSOC))
		{
			$data[]=$row;
		}
		$response=$data;
		//header('Content-Type: application/json');
		return($response);
}

//getGrade();
?>