<?php
require_once "../conndb/connect.php";
class Course 
{

	public  function getGrade()
	{
		global $conn;
		// execute the query



		$data=array();
		// $result=$mysqli->query($query);


		$stmt = $conn->query("SELECT * from mdl_course");

		// while($data = $stmt->fetch(PDO::FETCH_ASSOC)){
		// 	print $data['shortname'] . '<br>';
		// }

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

	public function getSomeGrade($id=0)
	{
		global $conn;
		$query="SELECT * FROM mdl_course";
		// if($id != 0)
		// {
		// 	$query.=" WHERE id=".$id." LIMIT 1";
		// }
		$data=array();
		$stmt = $conn->query("SELECT * from mdl_course where id = $id");

		// while($data = $stmt->fetch(PDO::FETCH_ASSOC)){
		// 	print $data['shortname'] . '<br>';
		// }
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

public function getMaxGrade($id=0)
{
	global $conn;
	// if($id != 0)
	// {
	// 	$query.=" WHERE id=".$id." LIMIT 1";
	// }
	$data=array();
	$stmt = $conn->query("	SELECT u.id AS userid, u.username, u.firstname, u.lastname, 
	q.name AS quizname, 
	qas.questionid AS questionid, 
	qas.slot AS originalquestionid, 
	qas.questionid AS questionname, 
	qas.maxmark AS maxmark, 
	qas.minfraction AS minfraction, 
	qas.maxfraction AS maxfraction, 
	qa.sumgrades AS grade 
FROM mdl_quiz_attempts qa 
JOIN mdl_user u ON qa.userid = u.id 
JOIN mdl_quiz q ON qa.quiz = q.id 
JOIN mdl_question_attempts qas ON qa.uniqueid = qas.questionusageid 
WHERE q.course = $id AND qa.state = 'finished' 
ORDER BY u.username, q.name, qas.slot");

	// while($data = $stmt->fetch(PDO::FETCH_ASSOC)){
	// 	print $data['shortname'] . '<br>';
	// }
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



}

 ?>