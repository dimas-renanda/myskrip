<?php

 error_reporting(0);
 session_start();
if (isset($_SESSION["loggedinsuperadmin"]) && $_SESSION["loggedin"] === true) {
  header("location: dashboard.php");
  exit;
}
require_once "assets/assets.php";
require_once 'condb/connect.php';


function login($x,$y)
{
  global $conn;

  $username = $x;
  $password = $y;

  $sql = "SELECT id, username, password, salt , created_at FROM superadmin WHERE username = :username LIMIT 1";

  try {
    $stmt = $conn->prepare($sql);

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
          $_SESSION["loggedinsuperadmin"] = true;
          $_SESSION["id"] = $result['id'];
          $_SESSION["usernameadmin"] = $result['username'];
          //echo '<script type="text/javascript">alert("Login Berhasil !");window.location.href="http://'.$domainnya.'/xradius/crossradius-admin/dashboard";</script>';
          echo '<script type="text/javascript">alert("Login Berhasil !");window.location.href="http://'.$_SERVER['HTTP_HOST'].'/myskrip/zcoba/superadmin/dashboard.php";</script>';

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
?>
<!DOCTYPE html>
<html>
	<head>
	<html>	
  <title>Moodle Bridge Admin <?= $hotspotname; ?></title>
		<meta charset="utf-8">
		<meta http-equiv="cache-control" content="private" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<!-- Tell the browser to be responsive to screen width -->
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- Theme color -->
		<meta name="theme-color" content="light" />
		<!-- Font Awesome -->
		<link rel="stylesheet" type="text/css" href="assets/css/font-awesome/css/font-awesome.min.css" />
		<!-- Mikhmon UI -->
		
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
		<!-- favicon -->
		<link rel="icon" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/myskrip/zcoba/assets/img/logo_stab.png" />

		<link rel="icon" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/myskrip/zcoba/assets/img/logo_stab.png">
		<!-- jQuery -->
		<script src="assets/js/jquery.min.js"></script>
		<!-- pace -->
		<link href="assets/css/pace.<?= $theme; ?>.css" rel="stylesheet" />
		<script src="assets/js/pace.min.js"></script>

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

	</head>
	<body > 
	
		<div class="wrapper">
<style>
  body {
  background: #007bff;
  background: linear-gradient(to right, #0062E6, #33AEFF);
}

.btn-login {
  font-size: 0.9rem;
  letter-spacing: 0.05rem;
  padding: 0.75rem 1rem;
}

.btn-google {
  color: white !important;
  background-color: #ea4335;
}

.btn-facebook {
  color: white !important;
  background-color: #3b5998;
}
</style>

  <div class="container">
    <div class="row">
      <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
        <div class="card border-0 shadow rounded-3 my-5">
          <div class="card-body p-4 p-sm-5">

          <div class="text-center pd-5">
        <img src="assets/img/logo_s.png" height="100" alt="Moodle OBE Logo">
      </div>
      <div  class="text-center">
      <b><span style="font-size: 20px; margin: 10px;">MT Admin</span></b>
      </div>

            <h5 class="card-title text-center mb-5 fw-light fs-5">Sign In</h5>
            <form method="post" action="">
              <div class="form-floating mb-3">
                <input type="text" class="form-control" name="username" placeholder="name@example.com">
                <label for="floatingInput">Email address</label>
              </div>
              <div class="form-floating mb-3">
                <input type="password" class="form-control" name="password" placeholder="Password">
                <label for="floatingPassword">Password</label>
              </div>

              <div class="d-grid">
                <button class="btn btn-primary btn-login text-uppercase fw-bold" type="submit">Sign
                  in</button>
              </div>
              <br>


              <hr class="my-3">
              <!--<div class="d-grid">
                <button class="btn btn-facebook btn-login text-uppercase fw-bold" type="submit">
                  <i class="fab fa-facebook-f me-2"></i> Sign in with Facebook
                </button>
              </div> -->
            </form>



          </div>
        </div>
      </div>
    </div>
  </div>

  <?php 
  
  if ($_SERVER['REQUEST_METHOD'] == 'POST')
  {
    login($_POST['username'],$_POST['password']);
  }
  
  ?>




</html>
