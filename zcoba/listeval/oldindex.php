<html>
    
<style type="text/css">
  .card-title{
    min-height: 50px;
  }
  .card-text {
    min-height: 60px;
  }
</style>
<div class="row" id="load_data">
<?php 
require_once "../conf/safety.php";
require_once "../assets/assets.php";
require_once "../condb/connect.php";

//SELECT course_name,eval_name,evaluation.created_at FROM `evaluation` JOIN courses where evaluation.courses_id = courses.id


$page = (isset($_GET['page']))? $_GET['page'] : 1;
$limit = 2; 
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
    <!-- <img src="<?php echo $foto; ?>" class="card-img-top" alt="gambar"> -->
    <div class="card-body">
      <h5 class="card-title"><?php echo $cname; ?></h5>
      <p class="card-text"><?php echo $ename; ?></p>
    </div>
    <div class="card-footer">
        <small class="text-muted"><?php echo $ceat; ?></small>
      </div>
  </div>
</div>
<?php } ?>

</div>


<?php

$stmt = $conn->prepare("SELECT count(*) AS jumlah FROM `evaluation` 
JOIN courses where evaluation.courses_id = courses.id LIMIT 1");

$stmt->execute(); 
$row = $stmt->fetch();
$total_records = $row['jumlah'];

?>
<nav class="mb-5 py-5">
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

</html>