<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>

<?php 
require_once "../conf/safety.php";
require_once "../assets/assets.php";
require_once "../condb/connect.php";

$crs = $_POST['id'];
$evl = $_POST['eval'];

echo "";


      
    echo 'Evaluation List';

function checkCourse()
{

    global $conn;

			$sql = "SELECT id FROM courses WHERE course_id = :id";
		

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
    $url  = "http://localhost/myskrip/api/course/course.php?course=".$_POST['id'];
    //echo $url;
    $homepage = file_get_contents($url);
    //var_dump($homepage);
    $jsonArrayResponse = json_decode($homepage, true);

    $result = current(array_filter($jsonArrayResponse['data'], function ($e) {
        return $e['shortname'] ;
    }));

   // print_r($result);
  extract($result);
    //var_dump($shortname);
//     //var_dump($qnumber);
//     echo '<p class="md-5">Number of quiz question : ',$total_questions,'</p>';

//     echo '<li><b>Course Available</b>  <span class="cross">&#10006</span></li>
// <li><b>Assesment Available</b>  <span class="cross">&#10006</span></li>
// <li><b>Number of Question</b>  <span class="check">&#10004</span></li>
// <li><b>Grade requirement</b>  <span class="check">&#10004</span></li>','<br>';

        global $conn;
        $by = $_SESSION['username'];
        $ts = date("Y-m-d H:i:s");
        $crs = $_POST['id'];
        echo $crs;
		$sql = "INSERT INTO courses (id,course_id,course_name,created_by,created_at) VALUES ('".intval($crs)."','".intval($crs)."','".$shortname."','$by','".$ts."')"; 
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
						header('Content-Type: application/json');
						echo json_encode($response);
					} else{
						$response=array(
							'status' => 1,
							'message' =>'Something went wrong. Please try again later.'
						);
		//header('Content-Type: application/json');
		echo json_encode($response);
					}
				
			}catch(PDOException $e) {
				echo "Error: " . $e->getMessage();
				echo $sql;
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
    $url  = "http://localhost/myskrip/api/studentgrade/studentgrade.php?id=".$_POST['id']."&eval=".$_POST['eval'];
    //echo $url;
    $homepage = file_get_contents($url);
    //var_dump($homepage);
    $jsonArrayResponse = json_decode($homepage, true);

    $result = current(array_filter($jsonArrayResponse['data'], function ($e) {
      return $e['quizname'] ;
  }));

 // print_r($result);
extract($result);


    global $conn;
    echo $quizname;
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
        //header('Content-Type: application/json');
        echo json_encode($response);
      } else{
        $response=array(
          'status' => 1,
          'message' =>'Something went wrong. Please try again later.'
        );
//header('Content-Type: application/json');
echo json_encode($response);
      }
    
  }catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
    echo $sql;
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
  $sql = "  INSERT INTO student (courses_id,nrp,name,grade)
  SELECT courses_id,nrp,name, SUM(grade_per_number) 
  AS total FROM grade 
  GROUP BY nrp"; 
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
      //header('Content-Type: application/json');
      echo json_encode($response);
    } else{
      $response=array(
        'status' => 1,
        'message' =>'Something went wrong. Please try again later.'
      );
//header('Content-Type: application/json');
echo json_encode($response);
    }
  
}catch(PDOException $e) {
  echo "Error: " . $e->getMessage();
  echo $sql;
  echo '<script>
  Swal.fire({
      title: "Error !",
      text: "Redirecting in 3 seconds...",
      icon: "error",
      showConfirmButton: true,
      timer: 3000
  }).then(function() {
      window.location.href = "http://localhost/myskrip/zcoba/"; // Replace with your desired URL
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
      window.location.href = "http://localhost/myskrip/zcoba/"; // Replace with your desired URL
  });
</script>';
  
 
    
}

function saveGrade()
{

  
  $ch = curl_init();
  $url  = "http://localhost/myskrip/api/studentgrade/studentgrade.php?id=".$_POST['id']."&eval=".$_POST['eval'];
  //echo $url;
  $homepage = file_get_contents($url);
  //var_dump($homepage);
  $jsonArrayResponse = json_decode($homepage, true);

  $chqnumber = curl_init();
  $urlchq  = "http://localhost/myskrip/api/quiz/quiz.php?id=".$_POST['eval'];
  //echo $urlchq;
  $homepagechq = file_get_contents($urlchq);
  //var_dump($homepagechq);
  $jsonArrayResponsechq = json_decode($homepagechq, true);
  //var_dump($jsonArrayResponsechq);

  $result = current(array_filter($jsonArrayResponsechq['data'], function ($e) {
    return $e['total_questions'];
}));

// print_r($result);
extract($result);

echo $total_questions;

foreach ($jsonArrayResponse['data'] as $data) {

    $temparr = array();
    $cobatemplate= array();

    // $temparr['nrp']=$data['username'];
    // $temparr['name']=$data['firstname'].' '.$data['lastname'];
    // $temparr['nomor']=$data['answervalue']*10;

    if(isset($temp) ? !($temp == $data['username']) : true) {
        //$templatedata[]=',';

        //echo $data['firstname'];

        //  echo '<th scope="row">'.$data['id'].'</th>';
        // echo '<td>'.$data['id'].'</td>';
        //echo'<tr>';
       // echo '<th scope="row">'.$no.'</th>';
       // echo '<td>'.$data['username'].'</td>';

       // echo '<td>'.$data['firstname'].' '.$data['lastname'].'</td>';
        //echo '<td>'.$data['quizsubmitdate'].'</td>';
       // echo '<td>'.intval($data['answervalue']*10).'</td>';

        // $sheet->setCellValue('A'.$no, $no-1);
        //$templatedata[]=$data['username'];
        //$sheet->setCellValue('B'.$no, $data['username']);
        //$templatedata[]=$data['firstname'].' '.$data['lastname'];
        //$sheet->setCellValue('C'.$no, $data['firstname'].' '.$data['lastname']);
        //$templatedata[]=$data['answervalue']*10;
        //$sheet->setCellValue($cell.$no, $data['answervalue']*10);

        //$temparr['no']=$no;
        $temparr['nrp']=$data['username'];
        $temparr['name']=$data['firstname'].' '.$data['lastname'];

        //$temparr['nomor']=$data['answervalue']*10;

        //$nilaiq= explode(",", $data['answervalue']*10);
        $nilaiq= explode(",", $data['answervalue']*10);

        //$cobatemplate[] = $data['username'];
       // $cobatemplate[] = $data['firstname'].' '.$data['lastname'];
        //$cobatemplate[] = $data['answervalue']*10;

        array_push($cobatemplate, $data['username'], $data['firstname'].' '.$data['lastname'], $data['answervalue']*10);





        foreach ($nilaiq as $dnilai) {
            array_push($temparr, $dnilai);
            // array_push($temparr, "+");
        }

        $no++;






    } elseif(isset($temp) ? ($temp == $data['username']) : true) {

        $cell++;


        //echo '<td>'.intval($data['answervalue']*10).'</td>';

        //$cobatemplate[] = explode(",", $data['answervalue']*10);

        array_push($cobatemplate,explode(",", $data['answervalue']*10));

        $nilaiq= explode(",", $data['answervalue']*10);




        foreach ($nilaiq as $dnilai) {
            array_push($temparr, $dnilai);
            //array_push($temparr, "+");
        }





    }

    $temp = $data['username'];
    $templatedata[] = $temparr;
}
//var_dump($templatedata);
$arraycoba = array();
foreach($templatedata as $x)
{
  foreach($x as $y)
  {
    $arraycoba[] = $y;
    
  }
}
//var_dump($arraycoba);
echo count($arraycoba);
foreach($arraycoba as $y)
{

  echo  $y;

 
  
  
}

echo '<br>';


global $conn;
echo $quizname;
$ts = date("Y-m-d H:i:s");
$crs = $_POST['id'];
$evl = $_POST['eval'];

$sql = "INSERT INTO grade (courses_id,evaluation_id,nrp,name,question_count,grade_per_number) VALUES ('".intval($crs)."','".intval($evl)."',:nrp,:nama,'".intval($total_questions)."',:gpn)"; 
try{
  $q = $conn->prepare($sql);
// Initialize an empty string to store the current group of numbers
$currentGroup = '';
  foreach ($jsonArrayResponse['data'] as $student){

    if (is_numeric($value)) {
      // If the value is numeric, append it to the current group
      $currentGroup .= $value . ' ';
  } else {
      // If the value is not numeric, check if there is a current group to print
      if (!empty($currentGroup)) {
          echo rtrim($currentGroup) . '<br>'; // Print the current group
          $currentGroup = ''; // Reset the current group
      }
      echo $value . '<br>'; // Print the non-numeric value on a new line
  }
  
      $a = array (':nrp'=>$student['username'],
                  ':nama'=>$student['firstname'].' '.$student['lastname'],
                  ':gpn'=>$student['answervalue'],);

      if ($q->execute($a)) {          
          // Query succeeded.
          } else {
              // Query failed.
              echo $q->errorCode();
              }
      // close the database connection
      //$conn = null;
      echo "Insert Complete!";
  }
  echo '<script>
  Swal.fire({
      title: "Success!",
      text: "Redirecting in 3 seconds...",
      icon: "success",
      showConfirmButton: true,
      timer: 3000
  }).then(function() {
      window.location.href = "http://localhost/myskrip/zcoba/"; // Replace with your desired URL
  });
</script>';
  
  }
  catch(PDOException $e) {
      echo $e->getMessage();
      }

// Initialize an empty string to store the current group of numbers
$currentGroup = '';

// Iterate over the array
foreach ($arraycoba as $value) {
    if (is_numeric($value)) {
        // If the value is numeric, append it to the current group
        $currentGroup .= $value . ' ';
    } else {
        // If the value is not numeric, check if there is a current group to print
        if (!empty($currentGroup)) {
            echo rtrim($currentGroup) . '<br>'; // Print the current group
            $currentGroup = ''; // Reset the current group
        }
        echo $value . '<br>'; // Print the non-numeric value on a new line
    }
}
    
}

function closeConn()
{
  global $conn;
  $conn = null;
}

$content = @$_GET['context'];
if ($content=='save')
{
    echo 'get save be4rhasil';
    echo $_POST['id'];echo $_POST['eval'];

    if(checkCourse(intval($_POST['id'])))
    {
        echo 'Course sudah tersedia';

        if(!checkEval(intval($_POST['id'])))
        {
          saveEvaluation();
          saveGrade();
          saveStudent();
        }
        else{
          echo 'eval pernah dibuat silahkan hapus terlebih dahulu, melanjutkan ke save grade';

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
          echo 'eval pernah dibuat silahkan hapus terlebih dahulu, melanjutkan ke save grade';

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

    echo'
    <div class="container-fluid">
    <h1 class="mt-4">Welcome to OBE tools !</h1>
    <p>The starting state of the menu will appear collapsed on smaller screens, and will appear non-collapsed on larger screens. When toggled using the button below, the menu will change.</p>
    <p>
        Make sure to keep all page content within the
        <code>#page-content-wrapper</code>
        . The top navbar is optional, and just for demonstration. Just create an element with the
        <code>#sidebarToggle</code>
        ID which will toggle the menu when clicked.
    </p> 

    
</div>';
}

?>

</html>