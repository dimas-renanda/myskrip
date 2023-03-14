<?php
require_once "method.php";
$regist = new Auth();
$request_method=$_SERVER["REQUEST_METHOD"];
switch ($request_method) {
	case 'POST':
		//validate username
		if(empty(trim($_POST["username"]))){
			$username_err = "Please enter a username.";
		} else{
			// Prepare a select statement
			$sql = "SELECT id FROM user WHERE username = :username";
		
			// Prepare statement
			$stmt = $connapp->prepare($sql);
		
			// Bind parameters
			$stmt->bindParam(':username', $param_username, PDO::PARAM_STR);
		
			// Set parameters
			$param_username = trim($_POST["username"]);
		
			// Attempt to execute the prepared statement
			if($stmt->execute()){
				/* store result */
				if($stmt->rowCount() == 1){
					$username_err = "This username is already taken.";
				} else{
					$username = trim($_POST["username"]);
				}
			} else{
				echo "Oops! Something went wrong. Please try again later.";
			}
		}
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }	

	    // Validate confirm password
		if(empty(trim($_POST["cpassword"]))){
			$confirm_password_err = "Please confirm password.";     
		} else{
			$confirm_password = trim($_POST["cpassword"]);
			if(empty($password_err) && ($password != $confirm_password)){
				$confirm_password_err = "Password did not match.";
			}
		}

		    //validate name
			if(empty(trim($_POST["name"]))){
				$name_err = "Mohon isi name Anda .";     
			}
			else{
				$name = trim($_POST["name"]);
			}

			//insert if no error

			if(empty($username_err) && empty($password_err) && empty($name_err)){
        
				// Prepare an insert statement
				$regist->RegistOi($username,$name,$password,$confirm_password);
				
			}    

			break; 
	default:
		// Invalid Request Method
			header("HTTP/1.0 405 Method Not Allowed");
			break;
		break;
}




?>