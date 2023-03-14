<?php
require_once "../conndb/connect.php";
class Auth
{

	public  function signIn($id=0,$pass='')
	{
		global $conn;
		// execute the query

		$data=array();
		// $result=$mysqli->query($query);


		$stmt = $conn->query("SELECT 
		username, password where username = $id and password = $pass ");

		// while($data = $stmt->fetch(PDO::FETCH_ASSOC)){
		// 	print $data['shortname'] . '<br>';
		// }

		while($row=$stmt->fetch(PDO::FETCH_ASSOC))
		{
			$data[]=$row;
		}
		$response=array(
							'status' => 1,
							'message' =>'Get List AuthSuccessfully.',
							'data' => $data
						);
		header('Content-Type: application/json');
		echo json_encode($response);
	}

	public function RegistOi($username,$name,$password,$confirm_password)
	{
		global $connapp;
		// if($id != 0)
		// {
		// 	$query.=" WHERE id=".$id." LIMIT 1";
		// }

		$saltsecret = trim('M00dle8ridgeTime0be'.date("Y-m-d"));
		$param_username = $username;
		$param_name = $name;
		$param_salt = password_hash($saltsecret, PASSWORD_DEFAULT);
		$param_password = password_hash($password, PASSWORD_DEFAULT);
		$param_created = date("Y-m-d H:i:s");
		$sql = "INSERT INTO user (username,name,salt,password,created_at) VALUES ('$param_username','$param_name','$param_salt','$param_password','$param_created')"; 
				try{
					$stmt = $connapp->prepare($sql);
					// Bind variables to the prepared statement as parameters
										// Set parameters
															//set salt for password
					// Attempt to execute the prepared statement
					if($stmt->execute()){
						// Redirect to login page
						// echo '<script type="text/javascript">'; 
						// echo 'alert("Akun Berhasil dibuat!");'; 
						// echo 'window.location.href = "mail_register.php";';
						// echo '</script>';
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
		
					// Close statement
					// mysqli_stmt_close($stmt);
				
			}catch(PDOException $e) {
				echo "Error: " . $e->getMessage();
				echo $sql;
			  }

		// while($data = $stmt->fetch(PDO::FETCH_ASSOC)){
		// 	print $data['shortname'] . '<br>';
		// }

		 
	}

}

 ?>