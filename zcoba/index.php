<?php


require_once "conf/headhtml.php";
session_start();
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
  header("location: ./admin");
  exit;
}


?>

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
      <b><span style="font-size: 20px; margin: 10px;">Moodle Tools</span></b>
      </div>

            <h5 class="card-title text-center mb-5 fw-light fs-5">Sign In</h5>
            <form method="post" action="/myskrip/api/auth/login.php">
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
</body>



</html>
