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

	public function RegistOi($username,$name,$password,$confirm_password)
	{
		global $connapp;

		$saltsecret = trim('M00dle8ridgeTime0be'.date("Y-m-dH:i:s"));
		$param_username = $username;
		$param_name = $name;
		$param_salt = password_hash($saltsecret, PASSWORD_DEFAULT);
		$param_password = password_hash($password, PASSWORD_DEFAULT);
		$param_created = date("Y-m-d H:i:s");
		$sql = "INSERT INTO user (username,name,salt,password,created_at) VALUES ('$param_username','$param_name','$param_salt','$param_password','$param_created')"; 
				try{
					$stmt = $connapp->prepare($sql);
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

	public function signIn($username,$password)
	{
		global $connapp;

		$sql = "SELECT id, username, password, salt , created_at FROM user WHERE username = :username LIMIT 1";

		try {
			$stmt = $connapp->prepare($sql);
	
			$stmt->execute([
				'username' => $username,
			]);
	
			if ($stmt->rowCount() == 1) {
				$result = $stmt->fetch(PDO::FETCH_ASSOC);
				$timeStamp = $result['created_at'];
				$timeStamp = date( "Y-m-dH:i:s", strtotime($timeStamp));
				$saltsecret = trim('M00dle8ridgeTime0be'.$timeStamp);
				if (password_verify($saltsecret, $result['salt']))
				{
	
					if (password_verify($password, $result['password']))
					{
						$response=array(
							'status' => 1,
							'message' =>'Success',
							'id' => $result['id'],
							'username' => $result['username'],
						);

						session_start();
						$_SESSION["loggedin"] = true;
						$_SESSION["id"] = $result['id'];
						$_SESSION["username"] = $result['username'];
						//echo '<script type="text/javascript">alert("Login Berhasil !");window.location.href="http://'.$domainnya.'/xradius/crossradius-admin/dashboard";</script>';
						echo '<script type="text/javascript">alert("Login Berhasil !");window.location.href="http://'.$_SERVER['HTTP_HOST'].'/myskrip/zcoba/admin";</script>';

					}
					else if (!password_verify($password, $result['password']))
					{

	
						$response=array(
							'status' => 1,
							'message' =>'Rejected',
						);
						header('Content-Type: application/json');
						echo json_encode($response);
	
					}
					else{
						$response=array(
							'status' => 1,
							'message' =>'Try again later',
						);
		header('Content-Type: application/json');
		echo json_encode($response);
	
					}
				}
	  
				else {
					$password_err = "";
					echo '<br>';
					echo 'Password Yang di Masukkan Salah !';
				}
	
			} else {
				$username_err = "Akun Tidak Terdaftar !";
			}
	
		} catch (PDOException $e) {
			$response=array(
				'status' => 1,
				'message' =>'Oops! Something went wrong. Please Try Again Later',
			);
			header('Content-Type: application/json');
			echo json_encode($response);
		}

		
		
	}

}

 ?>