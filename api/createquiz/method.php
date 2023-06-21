<?php
require_once "../conndb/connect.php";
class Auth
{

	public  function showError($message)
	{
		global $connapp;
		$response=array(
							'status' => 1,
							'message' =>'Something Went Wrong..',
							'data' => $message
						);
		header('Content-Type: application/json');
		echo json_encode($response);
	}



	public function createQuiz($username,$password)
	{
		global $conn;

		$sql = "INSERT INTO mdl_quiz (course, name, intro,timeopen, timeclose)
		VALUES ('$password', '$username','$username', 0, 0);
		
		SET @quizId = LAST_INSERT_ID();
		INSERT INTO mdl_course_modules (course, module, instance, section, added)
		VALUES ($password, (SELECT id FROM mdl_modules WHERE name = 'quiz'), @quizId, 1, UNIX_TIMESTAMP());
		
		SET @latestSection = (SELECT MAX(section) FROM mdl_course_sections WHERE course = $password)+1;
INSERT INTO mdl_course_sections (course, section, name)
VALUES ($password, @latestSection, '$username');";

try{
	$stmt = $conn->prepare($sql);
	if($stmt->execute()){
		while($row=$stmt->fetch(PDO::FETCH_ASSOC))
		{
			$data[]=$row;
		}
		$response=array(
							'status' => 0,
							'message' =>'Success',
							'data' => ''
						);
		header('Content-Type: application/json');
		echo json_encode($response);
	} else{
		$response=array(
			'status' => 1,
			'message' =>'Something went wrong. Please try again later.'
		);
header('Content-Type: application/json');
echo json_encode($response);
	}

}catch(PDOException $e) {
echo "Error: " . $e->getMessage();
echo $sql;
}
	
		
	}

}

 ?>