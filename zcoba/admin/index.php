<?php 
require_once "../conf/safety.php";
require_once "../assets/assets.php";
require_once '../conf/adminsidebar/assets.php' ;


?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Moodle bridge tools</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
        <?php echo '<link href="http://'.$_SERVER['HTTP_HOST'].'/myskrip/zcoba/conf/adminsidebar/css/styles.css" rel="stylesheet">'; ?>
<!-- pacee loading -->
        <script src="https://cdn.jsdelivr.net/npm/pace-js@latest/pace.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pace-js@1.2.4/themes/blue/pace-theme-flash.css">
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
    if (localStorage.getItem('sb|sidebar-toggle') === 'true') {
        document.body.classList.toggle('sb-sidenav-toggled');
    }
    sidebarToggle.addEventListener('click', event => {
        event.preventDefault();
        document.body.classList.toggle('sb-sidenav-toggled');
        localStorage.setItem('sb|sidebar-toggle', document.body.classList.contains('sb-sidenav-toggled'));
    });
}

});

    </script>
    </head>
        <div class="d-flex" id="wrapper">
            <!-- Sidebar-->
            <div class="border-end bg-white" id="sidebar-wrapper">
                <div class="sidebar-heading border-bottom bg-light mb-1"><a class="navbar-brand" href="">
  &nbsp;
      <?php echo ''; ?>Moodle Tools</a></div>
      <center>
      <img class="" src="../assets/img/logo_s.png" alt="Logo" height="50">
      </center>
                <div class="list-group list-group-flush">
                
                <a class="list-group-item list-group-item-action list-group-item-light p-3" href="../admin?page=course"><i class="fa fa-server"></i> Course List</a>
                    <a class="list-group-item list-group-item-action list-group-item-light p-3" href="../admin?page=assesment"><i class="fa fa-newspaper-o"></i> Assesment</a>
                    <a class="list-group-item list-group-item-action list-group-item-light p-3" href="../admin?page=student"><i class="fa fa-comments-o" aria-hidden="true"></i> Student</a>
                    <a class="list-group-item list-group-item-action list-group-item-light p-3" href="../listeval/index.php"><i class="fa fa-user-times" aria-hidden="true"></i> Evaluation</a>
                    <a class="list-group-item list-group-item-action list-group-item-light p-3" href="../admin?page=grade"><i class="fa fa-tachometer" aria-hidden="true"></i> Grade</a>

                </div>
            </div>
            <!-- Page content wrapper-->
            <div id="page-content-wrapper">
                <!-- Top navigation-->
                <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
                    <div class="container-fluid mb-0">
                    
                        <button class="btn  bg-transparent " id="sidebarToggle"><i class="fa fa-bars"></i></button>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav ms-auto mt-2 mt-lg-0">
                                <!-- <li class="nav-item active"><a class="nav-link" href="#!">Home</a></li>
                                <li class="nav-item"><a class="nav-link" href="#!">Link</a></li> -->
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user-circle"></i> <?php echo $_SESSION['username']; ?></a>
                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="../logout/"><i class="fa fa-sign-out"></i> Logout</a>
                                     
                                        <!-- <div class="dropdown-divider"></div> -->

                                        
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    
                </nav>
                <!-- Page content-->


                <?php 
                $content = @$_GET['page'];
                                if ($content=='course')
                                {
                                    require_once '../course/course.php';
                                }
                                elseif($content=='assesment')
                                {
                                    require_once '../assesment/assesment.php';
                                }
                                elseif($content=='eval')
                                {
                                    require_once '../listeval/index.php';
                                }
                                elseif($content=='student')
                                {
                                    require_once '../student/index.php';
                                }
                                elseif($content=='grade')
                                {
                                    require_once '../grade/index.php';
                                }
                                else{

                                    echo'
                                    <div class="container-fluid">
                                    <h1 class="mt-4">Welcome to Moodle Tools !</h1>
                                    <p>The starting state of the menu will appear collapsed on smaller screens, and will appear non-collapsed on larger screens. When toggled using the button below, the menu will change.</p>
                
                                    
                                </div>';
                                require_once 'sidebar.php';
                                }
                 ?>



            </div>
        </div>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <?php echo '<script src="http://'.$_SERVER['HTTP_HOST'].'/myskrip/zcoba/conf/adminsidebar/js/scripts.js">'; ?>
        <script src="js/scripts.js"></script>
</html>
