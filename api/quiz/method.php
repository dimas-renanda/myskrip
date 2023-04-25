<?php
require_once "../conndb/connect.php";
class Quiz
{

	public  function getQuizNumber()
	{
		global $conn;
		// execute the query



		$data=array();
		// $result=$mysqli->query($query);


		$stmt = $conn->query("SELECT COUNT(*) AS total_questions
		FROM mdl_question q
		JOIN mdl_question_categories qc ON qc.id = q.category
		JOIN mdl_quiz_slots qs ON qs.questionid = q.id
		JOIN mdl_quiz qz ON qz.id = qs.quizid");

		// while($data = $stmt->fetch(PDO::FETCH_ASSOC)){
		// 	print $data['shortname'] . '<br>';
		// }

		while($row=$stmt->fetch(PDO::FETCH_ASSOC))
		{
			$data[]=$row;
		}
		$response=array(
							'status' => 1,
							'message' =>'Get List Course Quiz Number Successfully.',
							'data' => $data
						);
		header('Content-Type: application/json');
		echo json_encode($response);
	}

	public function getSomeQuizNumber($id=0)
	{
		global $conn;
		// if($id != 0)
		// {
		// 	$query.=" WHERE id=".$id." LIMIT 1";
		// }
		$data=array();
		$stmt = $conn->query("SELECT COUNT(*) AS total_questions
		FROM mdl_question q
		JOIN mdl_question_categories qc ON qc.id = q.category
		JOIN mdl_quiz_slots qs ON qs.questionid = q.id
		JOIN mdl_quiz qz ON qz.id = qs.quizid
		WHERE qz.id = $id");

		// while($data = $stmt->fetch(PDO::FETCH_ASSOC)){
		// 	print $data['shortname'] . '<br>';
		// }
		while($row=$stmt->fetch(PDO::FETCH_ASSOC))
		{
			$data[]=$row;
		}
		$response=array(
							'status' => 1,
							'message' =>'Get List Some Course Number Successfully.',
							'data' => $data
						);
		header('Content-Type: application/json');
		echo json_encode($response);
		 
	}

}

 ?>