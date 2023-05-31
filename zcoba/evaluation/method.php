
<?php 
require_once "../conf/safety.php";
require_once "../assets/assets.php";
require_once "../condb/connect.php";

$crs = $_POST['id'];
$evl = $_POST['eval'];

function checkCourse()
{

    global $conn;

			$sql = "SELECT id FROM courses WHERE id = :id";
		

			$stmt = $conn->prepare($sql);
		

			$stmt->bindParam(':id', $x, PDO::PARAM_STR);
		

			$x = trim($_POST['id']);
		

			if($stmt->execute()){

				if($stmt->rowCount() == 1){
					$username_err = "This username is already taken.";
                    return true;
				} else{
					return false;
				}
			} else{
				return true;
			}
}

function checkEval()
{

    global $conn;

			$sql = "SELECT id FROM evaluation WHERE id = :id";
		

			$stmt = $conn->prepare($sql);
		

			$stmt->bindParam(':id', $x, PDO::PARAM_STR);
		

			$x = trim($_POST['eval']);
		

			if($stmt->execute()){

				if($stmt->rowCount() == 1){
					$username_err = "Quiz ini sudah pernah dibuat.";
                    return true;
				} else{
					return false;
				}
			} else{
				return true;
			}
}

function saveCourses()
{
    $ch = curl_init();
    $url  = 'http://'.$_SERVER['HTTP_HOST'].'/myskrip/api/course/course.php?course='.$_POST['id'];
    $homepage = file_get_contents($url);

    $jsonArrayResponse = json_decode($homepage, true);

    $result = current(array_filter($jsonArrayResponse['data'], function ($e) {
        return $e['fullname'] ;
    }));
  extract($result);

        global $conn;
        $by = $_SESSION['username'];
        $ts = date("Y-m-d H:i:s");
        $crs = $_POST['id'];
		$sql = "INSERT INTO courses (id,course_id,course_name,created_by,created_at) VALUES ('".intval($crs)."','".intval($crs)."','".$fullname."','$by','".$ts."')"; 
				try{
					$stmt = $conn->prepare($sql);
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

					} else{
						$response=array(
							'status' => 1,
							'message' =>'Something went wrong. Please try again later.'
						);
					}
				
			}catch(PDOException $e) {
				echo "Error: " . $e->getMessage();
                echo "<script>const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                      confirmButton: 'btn btn-success',
                      cancelButton: 'btn btn-danger'
                    },
                    buttonsStyling: true
                  })
                  
                  swalWithBootstrapButtons.fire({
                    title: 'Are you sure?',
                    text: 'You wont be able to revert this!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'No, cancel!',
                    reverseButtons: true
                  }).then((result) => {
                    if (result.isConfirmed) {
                      swalWithBootstrapButtons.fire(
                        'Deleted!',
                        'Your file has been deleted.',
                        'success'
                      )
                    } else if (
                      /* Read more about handling dismissals below */
                      result.dismiss === Swal.DismissReason.cancel
                    ) {
                      swalWithBootstrapButtons.fire(
                        'Cancelled',
                        'Your imaginary file is safe :)',
                        'error'
                      )
                    }
                  })</script>";
			  }

}

function saveEvaluation()
{
      $ch = curl_init();
    $url  = 'http://'.$_SERVER['HTTP_HOST'].'/myskrip/api/studentgrade/studentgrade.php?id='.$_POST['id']."&eval=".$_POST['eval'];
    $homepage = file_get_contents($url);
    $jsonArrayResponse = json_decode($homepage, true);

    $result = current(array_filter($jsonArrayResponse['data'], function ($e) {
      return $e['quizname'] ;
  }));

extract($result);

    global $conn;
    $ts = date("Y-m-d H:i:s");
    $crs = $_POST['id'];
    $evl = $_POST['eval'];

    $sql = "INSERT INTO evaluation (id,courses_id,eval_name,created_at) VALUES ('".intval($evl)."','".intval($crs)."','".$quizname."','".$ts."')"; 
    try{
      $stmt = $conn->prepare($sql);
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

      } else{
        $response=array(
          'status' => 1,
          'message' =>'Something went wrong. Please try again later.'
        );

      }
    
  }catch(PDOException $e) {
    echo "Error: " . $e->getMessage();

            echo "<script>const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                  confirmButton: 'btn btn-success',
                  cancelButton: 'btn btn-danger'
                },
                buttonsStyling: true
              })
              
              swalWithBootstrapButtons.fire({
                title: 'Are you sure?',
                text: 'You wont be able to revert this!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true
              }).then((result) => {
                if (result.isConfirmed) {
                  swalWithBootstrapButtons.fire(
                    'Deleted!',
                    'Your file has been deleted.',
                    'success'
                  )
                } else if (
                  /* Read more about handling dismissals below */
                  result.dismiss === Swal.DismissReason.cancel
                ) {
                  swalWithBootstrapButtons.fire(
                    'Cancelled',
                    'Your imaginary file is safe :)',
                    'error'
                  )
                }
              })</script>";
    }
    
}

function saveStudent()
{

  global $conn;
  $sql = " delete from student;
  REPLACE INTO student (courses_id,nrp,name,grade)
   SELECT courses_id,nrp,name, SUM(grade_per_number) 
   AS total FROM grade 
   GROUP BY nrp, courses_id"; 
  try{
    $stmt = $conn->prepare($sql);
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

    } else{
      $response=array(
        'status' => 1,
        'message' =>'Something went wrong. Please try again later.'
      );

    }
  
}catch(PDOException $e) {
  echo "Error: " . $e->getMessage();

  echo '<script>
  Swal.fire({
      title: "Error !",
      text: "Redirecting in 3 seconds...",
      icon: "error",
      showConfirmButton: true,
      timer: 3000
  }).then(function() {
      window.location.href = "http://'.$_SERVER['HTTP_HOST'].'/myskrip/zcoba/"; // Replace with your desired URL
  });
</script>';
  }



  echo '<script>
  Swal.fire({
      title: "Success!",
      text: "Redirecting in 3 seconds...",
      icon: "success",
      showConfirmButton: true,
      timer: 3000
  }).then(function() {
      window.location.href = "http://'.$_SERVER['HTTP_HOST'].'/myskrip/zcoba/"; // Replace with your desired URL
  });
</script>';
  
}


function checkGrade()
{

  global $conn;

  $crs = $_POST['id'];
  $evl = $_POST['eval'];

  $sql = "SELECT courses_id, evaluation_id FROM grade WHERE courses_id = '$crs' AND evaluation_id = '$evl'";

			$stmt = $conn->prepare($sql);
		
			if($stmt->execute()){

				if($stmt->rowCount() >= 1){

          global $conn;
  $sql = " DELETE from grade where courses_id = '$crs' AND evaluation_id = '$evl' "; 
  try{
    $stmt = $conn->prepare($sql);
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

      echo json_encode($response);
    } else{
      $response=array(
        'status' => 1,
        'message' =>'Something went wrong. Please try again later.'
      );

    }
  
}catch(PDOException $e) {
  echo "Error: " . $e->getMessage();
  echo '<script>
  Swal.fire({
      title: "Error !",
      text: "Redirecting in 3 seconds...",
      icon: "error",
      showConfirmButton: true,
      timer: 3000
  }).then(function() {
      window.location.href = "http://'.$_SERVER['HTTP_HOST'].'/myskrip/zcoba/"; // Replace with your desired URL
  });
</script>';
  }



  echo '<script>
  Swal.fire({
      title: "Success!",
      text: "Redirecting in 3 seconds...",
      icon: "success",
      showConfirmButton: true,
      timer: 3000
  }).then(function() {
      window.location.href = "http://'.$_SERVER['HTTP_HOST'].'/myskrip/zcoba/"; // Replace with your desired URL
  });
</script>';

				} else{
          return false;
				}
			} else{
				echo "Oops! Something went wrong. Please try again later.";
        return true;
			}
}

function saveGrade()
{
  checkGrade();
  
  $ch = curl_init();
  $url  = 'http://'.$_SERVER['HTTP_HOST'].'/myskrip/api/studentgrade/studentgrade.php?id='.$_POST['id']."&eval=".$_POST['eval'];

  $homepage = file_get_contents($url);

  $jsonArrayResponse = json_decode($homepage, true);

  $chqnumber = curl_init();
  $urlchq  = 'http://'.$_SERVER['HTTP_HOST'].'/myskrip/api/quiz/quiz.php?id='.$_POST['eval'];

  $homepagechq = file_get_contents($urlchq);

  $jsonArrayResponsechq = json_decode($homepagechq, true);


  $result = current(array_filter($jsonArrayResponsechq['data'], function ($e) {
    return $e['total_questions'];
}));


extract($result);

foreach ($jsonArrayResponse['data'] as $data) {

    $temparr = array();
    $cobatemplate= array();



    if(isset($temp) ? !($temp == $data['username']) : true) {


        $temparr['nrp']=$data['username'];
        $temparr['name']=$data['firstname'].' '.$data['lastname'];


        $nilaiq= explode(",", $data['answervalue']*10);


        array_push($cobatemplate, $data['username'], $data['firstname'].' '.$data['lastname'], $data['answervalue']*10);





        foreach ($nilaiq as $dnilai) {
            array_push($temparr, $dnilai);
            
        }

    } elseif(isset($temp) ? ($temp == $data['username']) : true) {


        array_push($cobatemplate,explode(",", $data['answervalue']*10));

        $nilaiq= explode(",", $data['answervalue']*10);




        foreach ($nilaiq as $dnilai) {
            array_push($temparr, $dnilai);
           
        }





    }

    $temp = $data['username'];
    $templatedata[] = $temparr;
}

$arraycoba = array();
foreach($templatedata as $x)
{
  foreach($x as $y)
  {
    $arraycoba[] = $y;
    
  }
}

global $conn;
$ts = date("Y-m-d H:i:s");
$crs = $_POST['id'];
$evl = $_POST['eval'];


$sql = "INSERT INTO grade (courses_id,evaluation_id,nrp,name,question_count,qnumber,grade_per_number) VALUES ('".intval($crs)."','".intval($evl)."',:nrp,:nama,'".intval($total_questions)."',:qnum,:gpn)"; 
try{
  $q = $conn->prepare($sql);

$currentGroup = '';
  foreach ($jsonArrayResponse['data'] as $student){

  
      $a = array (':nrp'=>$student['username'],
                  ':nama'=>$student['firstname'].' '.$student['lastname'],
                  ':gpn'=>$student['answervalue']*10,
                  ':qnum'=>$student['originalquestionid'],);

      if ($q->execute($a)) {          
          } else {
              
              echo $q->errorCode();
              }
  }
  echo '<script>
  Swal.fire({
      title: "Success!",
      text: "Redirecting in 3 seconds...",
      icon: "success",
      showConfirmButton: true,
      timer: 3000
  }).then(function() {
      window.location.href = "http://'.$_SERVER['HTTP_HOST'].'/myskrip/zcoba/"; // Replace with your desired URL
  });
</script>';
  
  }
  catch(PDOException $e) {
      echo $e->getMessage();
      }

$currentGroup = '';

    
 }

function closeConn()
{
  global $conn;
  $conn = null;
}

$content = @$_GET['context'];
if ($content=='save')
{

    if(checkCourse(intval($_POST['id'])))
    {

        if(!checkEval(intval($_POST['id'])))
        {
          saveEvaluation();


            saveGrade();

          saveStudent();
        }
        else{

          saveGrade();
          saveStudent();
        }

    }
    else{
        saveCourses();
        if(!checkEval(intval($_POST['id'])))
        {
          saveEvaluation();
          saveGrade();
          saveStudent();
        }
        else{

          saveGrade();
          saveStudent();
        }
    }

    closeConn();

 
}
elseif($content=='file')
{
    require_once '../file/file.php';
}
elseif($content=='eval')
{
    require_once '../evaluation/index.php';
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

}

?>

</html>
