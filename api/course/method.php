<?php
require_once "../conndb/connect.php";
class Course 
{

	public  function getCourse()
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

	public function getSomeCourse($id = 'null')
	{
		global $conn;
		//$query="SELECT * FROM mdl_course";
		// if($id != 0)
		// {
		// 	$query.=" WHERE id=".$id." LIMIT 1";
		// }
		$data=array();
		$stmt = $conn->query("SELECT DISTINCT c.id , c.fullname , c.shortname 
		FROM mdl_course c
		JOIN mdl_context ctx ON ctx.instanceid = c.id
		JOIN mdl_role_assignments ra ON ra.contextid = ctx.id
		JOIN mdl_user u ON u.id = ra.userid
		JOIN mdl_role r ON r.id = ra.roleid
		WHERE (r.shortname = 'editingteacher' OR r.shortname = 'coursecreator') AND u.email = '$id'");

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