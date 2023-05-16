<?php
require_once "../conndb/connect.php";
class Course 
{

	public  function getCourse()
	{
		global $conn;

		$data=array();

		$stmt = $conn->query("SELECT * from mdl_course");

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

	public  function getOneCourse($course = 'null')
	{
		global $conn;

		$data=array();

		$stmt = $conn->query("SELECT * from mdl_course where id = $course");

		while($row=$stmt->fetch(PDO::FETCH_ASSOC))
		{
			$data[]=$row;
		}
		$response=array(
							'status' => 1,
							'message' =>'Get List One Course Successfully.',
							'data' => $data
						);
		header('Content-Type: application/json');
		echo json_encode($response);
	}

	public function getSomeCourse($id = 'null')
	{
		global $conn;
		$data=array();
		$stmt = $conn->query("SELECT DISTINCT c.id , c.fullname , c.shortname 
		FROM mdl_course c
		JOIN mdl_context ctx ON ctx.instanceid = c.id
		JOIN mdl_role_assignments ra ON ra.contextid = ctx.id
		JOIN mdl_user u ON u.id = ra.userid
		JOIN mdl_role r ON r.id = ra.roleid
		WHERE (r.shortname = 'editingteacher' OR r.shortname = 'coursecreator') AND u.email = '$id'");

		while($row=$stmt->fetch(PDO::FETCH_ASSOC))
		{
			$data[]=$row;
		}
			$response=array(
								'status' => 1,
								'message' =>'Get List Course by user Successfully.',
								'data' => $data
							);
			header('Content-Type: application/json');
			echo json_encode($response);
		 
	}

	
}

 ?>