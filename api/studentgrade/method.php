<?php
require_once "../conndb/connect.php";
class Course 
{

	public  function getStudentGrade()
	{
		global $conn;
		// execute the query



		$data=array();
		// $result=$mysqli->query($query);


		//$stmt = $conn->query("SELECT * from mdl_course");

		// while($data = $stmt->fetch(PDO::FETCH_ASSOC)){
		// 	print $data['shortname'] . '<br>';
		// }

		// while($row=$stmt->fetch(PDO::FETCH_ASSOC))
		// {
		// 	$data[]=$row;
		// }
		$response=array(
							'status' => 1,
							'message' =>'Please input ID or operation !',
							'data' => $data
						);
		header('Content-Type: application/json');
		echo json_encode($response);
	}

	public function getSomeStudentGrade($id=0)//id jadi user
	{
		global $conn;
		// if($id != 0)
		// {
		// 	$query.=" WHERE id=".$id." LIMIT 1";
		// }
		$data=array();
		$stmt = $conn->query("SELECT 
		c.fullname AS 'Course Name',
		q.name AS 'Quiz Name',
		u.username AS 'Username',
		u.firstname AS 'First Name',
		u.lastname AS 'Last Name',
		qa.timefinish AS 'Time Finish',
		qa.sumgrades AS 'Total Score'
	FROM 
		mdl_quiz q
	INNER JOIN 
		mdl_course c ON q.course = c.id
	INNER JOIN 
		mdl_user u ON u.id = $id
	INNER JOIN 
		mdl_quiz_attempts qa ON q.id = qa.quiz AND qa.userid = u.id");

		// while($data = $stmt->fetch(PDO::FETCH_ASSOC)){
		// 	print $data['shortname'] . '<br>';
		// }
		while($row=$stmt->fetch(PDO::FETCH_ASSOC))
		{
			$data[]=$row;
		}
		$response=array(
							'status' => 1,
							'message' =>'Get List Some Student Grade Successfully.',
							'data' => $data
						);
		header('Content-Type: application/json');
		echo json_encode($response);
		 
	}

	public function getSomeStudentMarkGrade($id=0)//id jadi course with param mark=true on call
	{
		global $conn;
		// if($id != 0)
		// {
		// 	$query.=" WHERE id=".$id." LIMIT 1";
		// }
		$data=array();
		$stmt = $conn->query("SELECT u.id AS userid, u.username, u.firstname, u.lastname, 
		q.name AS quizname, 
		qas.questionid AS questionid, 
		qas.slot AS originalquestionid, 
		qas.questionid AS questionname, 
		qas.minfraction AS minfraction, 
		qas.maxfraction AS maxfraction, 
		SUM(CAST(qas_steps.fraction AS DECIMAL(10,2)) * CAST(qas_steps.state AS DECIMAL(10,2))) AS grade,
		qasd.name AS answername, 
		qasd.value AS answervalue
 FROM mdl_quiz_attempts qa 
 JOIN mdl_user u ON qa.userid = u.id 
 JOIN mdl_quiz q ON qa.quiz = q.id 
 JOIN mdl_question_attempts qas ON qa.uniqueid = qas.questionusageid 
 JOIN mdl_question_attempt_steps qas_steps ON qas.id = qas_steps.questionattemptid
 JOIN mdl_question_attempt_step_data qasd ON qas_steps.id = qasd.attemptstepid
 WHERE q.course = $id AND qa.state = 'finished' and qasd.name = '-mark'
 GROUP BY qa.id, qas.id, qasd.id
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
							'message' =>'Get List Some Student Mark Grade Successfully.',
							'data' => $data
						);
		header('Content-Type: application/json');
		echo json_encode($response);
		 
	}

	public function getSomeStudentMarkGradeEval($id=0,$eval=0)//id jadi course with param mark=true on call
	{
		global $conn;
		// if($id != 0)
		// {
		// 	$query.=" WHERE id=".$id." LIMIT 1";
		// }
		$data=array();
		$stmt = $conn->query("SELECT u.id AS userid, u.username, u.firstname, u.lastname, 
		q.name AS quizname, 
		qas.questionid AS questionid, 
		qas.slot AS originalquestionid, 
		qas.questionid AS questionname, 
		qas.minfraction AS minfraction, 
		qas.maxfraction AS maxfraction, 
		SUM(CAST(qas_steps.fraction AS DECIMAL(10,2)) * CAST(qas_steps.state AS DECIMAL(10,2))) AS grade,
		qasd.name AS answername, 
		qasd.value AS answervalue
 FROM mdl_quiz_attempts qa 
 JOIN mdl_user u ON qa.userid = u.id 
 JOIN mdl_quiz q ON qa.quiz = q.id 
 JOIN mdl_question_attempts qas ON qa.uniqueid = qas.questionusageid 
 JOIN mdl_question_attempt_steps qas_steps ON qas.id = qas_steps.questionattemptid
 JOIN mdl_question_attempt_step_data qasd ON qas_steps.id = qasd.attemptstepid
 WHERE q.course = $id AND q.id = '$eval' AND qa.state = 'finished' and qasd.name = '-mark'
 GROUP BY qa.id, qas.id, qasd.id
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
							'message' =>'Get List Some Student Mark Grade Eval Successfully.',
							'data' => $data
						);
		header('Content-Type: application/json');
		echo json_encode($response);
		 
	}



}

 ?>