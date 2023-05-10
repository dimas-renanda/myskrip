<?php
require_once "../conndb/connect.php";
class Evaluation 
{

	public  function getEval()
	{
		global $conn;

		$data=array();

		$stmt = $conn->query("SELECT 
		c.id,
		c.shortname,
		q.id AS 'Quiz ID',
		q.name AS 'Quiz Name'
	FROM 
		mdl_quiz q
	INNER JOIN 
		mdl_course_modules cm ON q.id = cm.instance
	INNER JOIN 
		mdl_modules m ON cm.module = m.id
	INNER JOIN 
		mdl_course c ON cm.course = c.id
	WHERE 
		m.name = 'quiz'");

		while($row=$stmt->fetch(PDO::FETCH_ASSOC))
		{
			$data[]=$row;
		}
		$response=array(
							'status' => 1,
							'message' =>'Get List Course Successfully.',
							'data' => $data
						);
		header('Content-Type: application/json');
		echo json_encode($response);
	}

	public function getSomeEval($id=0)
	{
		global $conn;
		$data=array();
		$stmt = $conn->query("SELECT 
		q.id AS 'Quiz ID',
		q.name AS 'Quiz Name'
	FROM 
		mdl_quiz q
	INNER JOIN 
		mdl_course_modules cm ON q.id = cm.instance
	INNER JOIN 
		mdl_modules m ON cm.module = m.id
	INNER JOIN 
		mdl_course c ON cm.course = c.id
	WHERE 
		m.name = 'quiz'  AND c.id = $id");

		while($row=$stmt->fetch(PDO::FETCH_ASSOC))
		{
			$data[]=$row;
		}
		$response=array(
							'status' => 1,
							'message' =>'Get List Course Evaluation Successfully.',
							'data' => $data
						);
		header('Content-Type: application/json');
		echo json_encode($response);
		 
	}

}

 ?>