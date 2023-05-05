<?php
/*
 *  Copyright (C) 2018 Laksamadi Guko.
 *
 *  This program is free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

require_once "conf/headhtml.php";
session_start();
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
  header("location: ./dashboard");
  exit;
}

//session_start();

?>



<!-- <div style="padding-top: 5%;"  class="login-box">
  <div class="card"> -->
    <!-- <div class="card-header">
      <h3><?= $_please_login ?></h3>
    </div> -->
    <!-- <div class="card-body">
      <div class="text-center pd-5">
        <img src="assets/img/logo_s.png" height="100" alt="XNET Logo">
      </div>
      <div  class="text-center">
      <b><span style="font-size: 25px; margin: 10px;">Moodle Tools</span></b>
      </div>
      <center>
        <?php //require_once "signin.php"; ?>
      <form autocomplete="off" action="signin.php" method="post">
      <table class="table" style="width:90%">
        <tr>
          <td class="align-middle text-center">
            <input style="width: 100%; height: 35px; font-size: 16px;" class="form-control" type="text" name="username" id="_username" placeholder="Username" required="1" autofocus>
          </td>
        </tr>
        <tr>
          <td class="align-middle text-center">
            <input style="width: 100%; height: 35px; font-size: 16px;" class="form-control" type="password" name="password" placeholder="Password" required="1">
          </td>
        </tr>
        <tr>
          <td class="align-middle text-center">
            <input style="width: 100%; margin-top:20px; height: 35px; font-weight: bold; font-size: 17px;" class="btn-login bg-primary pointer" type="submit" name="login" value="Login">
          </td>
        </tr>
        <tr>
          <td class="align-middle text-center">
            <?= $error; ?>
          </td>
        </tr>
      </table>
      </form>
      </center>
    </div>
  </div>
</div> -->
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

<!-- =========================================================================== -->
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

              <div class="d-grid mb-2">
                <a class="btn btn-secondary btn-login text-uppercase fw-bold" href="register.php">

                  <!-- <i class="fab fa-google me-2"></i> -->
                  Register 
           
                </a>
              </div>

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
