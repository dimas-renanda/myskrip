<?php 
require_once "../conf/safety.php";
require_once "../assets/assets.php";
require_once "../condb/connect.php";

$crs = $_POST['id'];
$evl = $_POST['eval'];

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
		header('Content-Type: application/json');
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

function saveEvaluation($eid,$cid,$en,$ca)
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
    
}

function saveStudent($sid,$cid,$nrp,$grd)
{
    
}

function saveGrade($cid,$eid,$nrp,$nama,$qc,$gpn)
{
    
}

$content = @$_GET['context'];
if ($content=='save')
{
    echo 'get save be4rhasil';
    echo $_POST['id'];echo $_POST['eval'];

    if(checkCourse(intval($_POST['id'])))
    {
        echo 'ada yang sama tidak tersave';
    }
    else{
        saveCourses();
    }

 
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