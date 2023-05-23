<?php 
require_once "../conf/safety.php";
require_once "../assets/assets.php";
require_once '../conf/adminsidebar/assets.php' ;
require_once "../condb/connect.php";

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
<style type="text/css">
      .card-title{
        min-height: 50px;
      }
      .card-text {
        min-height: 60px;
      }
    </style>
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
                    <a class="list-group-item list-group-item-action list-group-item-light p-3" href="../admin?page=file"><i class="fa fa-newspaper-o"></i> OBE File Input</a>
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

                <div class="col-md" style="padding-left: 20px; padding-top: 20px; padding-bottom: 20px; padding-right: 20px;">
<h3>Evaluation List</h3>
<hr>

    <div class="row" id="load_data">
    <?php 

    
    //SELECT course_name,eval_name,evaluation.created_at FROM `evaluation` JOIN courses where evaluation.courses_id = courses.id
    
    
    $page = (isset($_GET['page']))? $_GET['page'] : 1;
    $limit = 8; 
    (int) $limit_start = intval(($page - 1)) * intval($limit);
    $no = intval($limit_start) + intval(1);
    
    $stmt = $conn->query("SELECT courses.course_id,course_name,eval_name,evaluation.id,evaluation.created_at FROM `evaluation` 
    JOIN courses where evaluation.courses_id = courses.id
    ORDER BY course_name ASC LIMIT $limit_start, $limit");
    
    while ($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
      $cid = $row["course_id"];
      $cname = $row["course_name"];
      $ename = $row["eval_name"];
      $eid = $row["id"];
      $ceat = $row["created_at"];
      if (strlen($cname) > 60) {
        $cname = substr($cname, 0, 60) . "...";
      }
    
    ?>
    
    
    <div class="col-sm-3 mb-5 py-3 px-4">
      
      <div class="card">
      <!-- <a href="google.com" style="text-decoration:none;color: #000000;"> -->
        <div class="card-body">
          <h5 class="card-title"><?php echo $cname; ?></h5>
          <p class="card-text"><?php echo $ename; ?></p>
          <button class="btn btn-danger float-end mb-3" data-bs-toggle="modal" data-bs-target="#myModalDelete<?php echo $cid.'-'.$eid; ?>"><i class="fa fa-trash"></i></button>
        </div>
        <!-- </a> -->
        <div class="card-footer">
            <small class="text-muted"><?php echo $ceat; ?></small>
          </div>
      </div>
    </div>


      
<?php 
 echo '     
  <div id="myModalDelete'.$cid.'-'.$eid.'" class="modal fade" role="dialog">
  <div class="vertical-alignment-helper">
     <div class="modal-dialog" role="document">
        <div class="modal-content">
           <div class="modal-header text-center">
              <h4 class="modal-title w-100 font-weight-bold"><i class="fa fa-newspaper-o"> </i> Delete Student Grade</h4>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
           </div>
           <div class="modal-body mx-3" method="POST">
              <form class="form-signin" action ="deleteeval.php" method="POST">
                 <div class="md-form mb-4 text-center">
                    <i class="fa fa-exclamation-triangle fa-3x prefix text-warning"> </i> <br><label for="inputrname">  Are you sure want to delete '.$cname.'  '.$ename.' ?</label>
                    <input type="hidden" id="inputnid" name="cid" class="form-control validate"  value='.$cid.' >
                    <input type="hidden" id="inputnid" name="eid" class="form-control validate"  value='.$eid.' >
                 </div>
                 <div class="modal-footer d-flex justify-content-center">
                    <button id="redit" class="btn btn-default btn-danger btn-block text-uppercase"><i class="fa fa-trash ">  </i> Delete</button>
                 </div>
              </form>
                </div>
            </div>
       </div>
   </div>
  </div>';
?>


    <?php } ?>
    
    </div>
    
    
    <?php
    
    $stmt = $conn->prepare("SELECT count(*) AS jumlah FROM `evaluation` 
    JOIN courses where evaluation.courses_id = courses.id LIMIT 1");
    
    $stmt->execute(); 
    $row = $stmt->fetch();
    $total_records = $row['jumlah'];
    
    ?>
    <nav class="mb-5 ">
      <ul class="pagination justify-content-center">
        <?php
          $jumlah_page = ceil($total_records / $limit);
          $jumlah_number = 1; //jumlah halaman ke kanan dan kiri dari halaman yang aktif
          $start_number = ($page > $jumlah_number)? $page - $jumlah_number : 1;
          $end_number = ($page < ($jumlah_page - $jumlah_number))? $page + $jumlah_number : $jumlah_page;
          
          if($page == 1){
            echo '<li class="page-item disabled"><a class="page-link" href="#">First</a></li>';
            echo '<li class="page-item disabled"><a class="page-link" href="#"><span aria-hidden="true">&laquo;</span></a></li>';
          } else {
            $link_prev = ($page > 1)? $page - 1 : 1;
            echo '<li class="page-item"><a class="page-link" href="?page=1">First</a></li>';
            echo '<li class="page-item"><a class="page-link" href="?page='.$link_prev.'" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>';
          }
     
          for($i = $start_number; $i <= $end_number; $i++){
            $link_active = ($page == $i)? ' active' : '';
            echo '<li class="page-item '.$link_active.'"><a class="page-link" href="?page='.$i.'">'.$i.'</a></li>';
          }
     
          if($page == $jumlah_page){
            echo '<li class="page-item disabled"><a class="page-link" href="#"><span aria-hidden="true">&raquo;</span></a></li>';
            echo '<li class="page-item disabled"><a class="page-link" href="#">Last</a></li>';
          } else {
            $link_next = ($page < $jumlah_page)? $page + 1 : $jumlah_page;
            echo '<li class="page-item"><a class="page-link" href="?page='.$link_next.'" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>';
            echo '<li class="page-item"><a class="page-link" href="?page='.$jumlah_page.'">Last</a></li>';
          }
        ?>
      </ul>
    </nav>
    
  
               



            </div>
        </div>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <?php echo '<script src="http://'.$_SERVER['HTTP_HOST'].'/myskrip/zcoba/conf/adminsidebar/js/scripts.js">'; ?>
        <script src="js/scripts.js"></script>
</html>
