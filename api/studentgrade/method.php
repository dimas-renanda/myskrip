<?php
require_once "../conndb/connect.php";
class StudentGrade 
{

	public  function getStudentGrade()
	{
		global $conn;

		$data=array();

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

		$data=array();
		$stmt = $conn->query("SELECT u.id AS userid, u.username, u.firstname, u.lastname, 
		q.name AS quizname, 
		qas.questionid AS questionid, 
		qas.slot AS originalquestionid, 
		qas.questionid AS questionname, 
		qas.minfraction AS minfraction, 
		qas.maxfraction AS maxfraction, 
		CAST(MAX(qasd.value) AS DECIMAL(10,2)) AS max_mark,
		FROM_UNIXTIME(qa.timefinish) AS quizsubmitdate
	FROM mdl_quiz_attempts qa 
	JOIN mdl_user u ON qa.userid = u.id 
	JOIN mdl_quiz q ON qa.quiz = q.id 
	JOIN mdl_question_attempts qas ON qa.uniqueid = qas.questionusageid 
	JOIN mdl_question_attempt_steps qas_steps ON qas.id = qas_steps.questionattemptid
	JOIN mdl_question_attempt_step_data qasd ON qas_steps.id = qasd.attemptstepid
	WHERE q.course = $id 
		AND qa.state = 'finished' 
		AND qasd.name = '-mark' 
		AND qa.timefinish IS NOT NULL
		AND qas.questionid = (
			SELECT qas2.questionid 
			FROM mdl_question_attempts qas2
			WHERE qas2.id = qas.id
			GROUP BY qas2.questionid, qa.userid
			HAVING COUNT(DISTINCT qa.id) = 1
		)
	GROUP BY qa.id, qas.id
	ORDER BY u.username, q.name, qas.slot");

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

		$data=array();
		$stmt = $conn->query("SELECT
		quiza.userid,
		 u.username, u.firstname, u.lastname, 
		q.name AS quizname,
		quiza.quiz,
		quiza.id AS quizattemptid,
		quiza.attempt,
		quiza.sumgrades,
		qu.preferredbehaviour,
		qa.slot AS originalquestionid,
		qa.behaviour,
		qa.questionid,
		qa.variant,
		qa.maxmark,
		qa.minfraction,
		qa.flagged,
		qas.sequencenumber,
		qas.state,
		qas.fraction,
		FROM_UNIXTIME(qas.timecreated) AS quizsubmitdate,
		qas.userid,
		qasd.name,
		qasd.value,
		qa.questionsummary,
		qa.rightanswer,
		qa.responsesummary,
		CASE
			WHEN qas.state = 'gradedright' THEN qa.maxmark
			WHEN qas.state = 'gradedwrong' THEN qa.minfraction
            WHEN qas.state = 'gradedpartial' THEN qa.maxmark * qas.fraction
			WHEN qasd.name = '-mark' THEN qasd.value
			ELSE NULL
		END AS answervalue
	FROM mdl_quiz_attempts quiza
	JOIN mdl_user u ON quiza.userid = u.id 
	JOIN mdl_quiz q ON quiza.quiz = q.id 
	JOIN mdl_question_usages qu ON qu.id = quiza.uniqueid
	JOIN mdl_question_attempts qa ON qa.questionusageid = qu.id
	JOIN mdl_question_attempt_steps qas ON qas.questionattemptid = qa.id
	LEFT JOIN mdl_question_attempt_step_data qasd ON qasd.attemptstepid = qas.id
	WHERE q.course = $id AND q.id = '$eval' 
		AND (qasd.name = '-finish' OR qasd.name = '-mark')
		AND qas.fraction IS NOT NULL
		AND quiza.attempt = (
			SELECT MAX(quiza_inner.attempt)
			FROM mdl_quiz_attempts quiza_inner
			WHERE quiza_inner.userid = quiza.userid
				AND quiza_inner.quiz = quiza.quiz
		)
	ORDER BY u.username ASC");

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