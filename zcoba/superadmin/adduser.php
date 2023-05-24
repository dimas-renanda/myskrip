<?php 
require_once 'condb/connect.php';
	function regist($username,$name,$password,$confirm_password)
	{
		global $conn;

		$saltsecret = trim('M00dle8ridgeTime0be'.date("Y-m-dH:i:s"));
		$param_username = $username;
		$param_name = $name;
		$param_salt = password_hash($saltsecret, PASSWORD_DEFAULT);
		$param_password = password_hash($password, PASSWORD_DEFAULT);
		$param_created = date("Y-m-d H:i:s");
		$sql = "INSERT INTO user (username,name,salt,password,created_at) VALUES ('$param_username','$param_name','$param_salt','$param_password','$param_created')"; 
				try{
					$stmt = $conn->prepare($sql);
					if($stmt->execute()){
						while($row=$stmt->fetch(PDO::FETCH_ASSOC))
						{
							$data[]=$row;
						}
                        echo '<script>
                        Swal.fire({
                            title: "Success !",
                            text: "New User Created ...",
                            icon: "success",
                            showConfirmButton: true,
                            timer: 3000
                        }).then(function() {
                            window.location.href = "http://'.$_SERVER['HTTP_HOST'].'/myskrip/zcoba/superadmin/dashboard.php?page=addUser"; // Replace with your desired URL
                        });
                      </script>';
					} else{
                        echo '<script>
                        Swal.fire({
                            title: "Error !",
                            text: "Failed  ...",
                            icon: "error",
                            showConfirmButton: true,
                            timer: 3000
                        }).then(function() {
                            window.location.href = "http://'.$_SERVER['HTTP_HOST'].'/myskrip/zcoba/admin?page=student"; // Replace with your desired URL
                        });
                      </script>';
					}
				
			}catch(PDOException $e) {
				echo "Error: " . $e->getMessage();
				echo $sql;
			  }

	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css">
  
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script>

<title>Student List</title>

<script>
    $(document).ready(function () {
$('#example').DataTable(
    {
        responsive: true
    }
);
});
window.addEventListener('DOMContentLoaded', event => {

// Toggle the side navigation
const sidebarToggle = document.body.querySelector('#sidebarToggle');
if (sidebarToggle) {
// Uncomment Below to persist sidebar toggle between refreshes
// if (localStorage.getItem('sb|sidebar-toggle') === 'true') {
//     document.body.classList.toggle('sb-sidenav-toggled');
// }
sidebarToggle.addEventListener('click', event => {
    event.preventDefault();
    document.body.classList.toggle('sb-sidenav-toggled');
    localStorage.setItem('sb|sidebar-toggle', document.body.classList.contains('sb-sidenav-toggled'));
});
}

});
</script>
</head>

<body>
<div class="col-md" style="padding-left: 20px; padding-top: 20px; padding-bottom: 20px; padding-right: 20px;">
<h3>Add User</h3>
<hr>

<div class="container">
<form method="post" action="">
              <div class="form-group mb-3">
              <label for="floatingInput">Username / Email address</label>
                <input type="text" class="form-control" name="username" placeholder="name@example.com" required>
                
              </div>
              <div class="form-group mb-3">
              <label for="Name">Name</label>
                <input type="text" class="form-control" name="name" placeholder="Teacher" required>
                
              </div>
              <div class="form-group mb-3">
              <label for="floatingPassword">Password</label>
                <input type="password" class="form-control" name="password" placeholder="Password" required>
                
              </div>
              <div class="form-group mb-3">
              <label for="floatingPassword">Confirm Password</label>
                <input type="password" class="form-control" name="cpassword" placeholder="Confirm Password"required>
                
              </div>

                <button class="btn btn-primary btn-login text-uppercase fw-bold" type="submit">Regist</button>
        

              <hr class="my-4">


</div>
</div>
</body>

<?php 
  
  if ($_SERVER['REQUEST_METHOD'] == 'POST')
  {
    regist($_POST['username'],$_POST['name'],$_POST['password'],$_POST['cpassword']);
  }
  
  ?>

</html>