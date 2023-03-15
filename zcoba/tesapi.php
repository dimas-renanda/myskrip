<?php 
// function rupiah($angka){
	
// 	$hasil_rupiah = "Rp " . number_format($angka,2,',','.');
// 	return $hasil_rupiah;
 
// }
// $jsonmoney = file_get_contents('http://10.10.10.232:38700/GetPayments');

// $totmoney = json_decode($jsonmoney,true);
//         $alluser = count($totmoney["Data"]);
// // echo($totmoney['Data'][0]['Id']);

// $resulttotalmoney = 0;
// foreach (@$totmoney as $to)
// {
//     foreach(@$to as $total)
//     {
//         $resulttotalmoney += $total['Amount'];
//         echo $total['Amount'];
//         echo "<br>";
//     };
// }


// echo rupiah($resulttotalmoney);

//security
// $saltsecret = trim('M00dle8ridgeTime0be'.date("Y-m-dH:i:s"));
// $hashed = password_hash($saltsecret, PASSWORD_DEFAULT);
// echo $saltsecret,'<br>';
// echo $hashed;

//login
require_once "../api/conndb/connect.php";


//dummy password
$password = 'surabaya';
$username = 'dimasrenanda@gmail.com';


    $sql = "SELECT id, username, password, salt , created_at FROM user WHERE username = :username LIMIT 1";

    try {
        $stmt = $connapp->prepare($sql);

        $stmt->execute([
            'username' => $username,
        ]);

        if ($stmt->rowCount() == 1) {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            //echo $result['password'];
            //echo '<br>';
            $timeStamp = $result['created_at'];
            $timeStamp = date( "Y-m-dH:i:s", strtotime($timeStamp));
            //echo trim($timeStamp);
            $saltsecret = trim('M00dle8ridgeTime0be'.$timeStamp);
            //echo $saltsecret;
            //echo '<br>';
            //echo $result['salt'];
            //var_dump(password_verify($saltsecret, $result['salt']));
            if (password_verify($saltsecret, $result['salt']))
            {
                ///session_start();

                // $_SESSION["loggedin"] = true;
                // $_SESSION["id"] = $result['id'];
                // $_SESSION["username"] = $result['username'];
                //echo '<br>';
                //echo 'Salted OK !';

                if (password_verify($password, $result['password']))
                {
                    ///session_start();
    
                    // $_SESSION["loggedin"] = true;
                    // $_SESSION["id"] = $result['id'];
                    // $_SESSION["username"] = $result['username'];

                    // echo '<br>';
                    // echo 'Pass OK Berhasil!!!!';
                    // echo '<br>';
                    $response=array(
                        'status' => 1,
                        'message' =>'Success',
                        'id' => $result['id'],
                        'username' => $result['username'],
                    );
    header('Content-Type: application/json');
    echo json_encode($response);
                }
                else if (!password_verify($password, $result['password']))
                {
                    // echo '<br>';
                    // echo 'Pass Rejected !';
                    // echo '<br>';

                    $response=array(
                        'status' => 1,
                        'message' =>'Rejected',
                    );
    header('Content-Type: application/json');
    echo json_encode($response);

                }
                else{
                    // echo '<br>';
                    // echo 'Something went wrong !';

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

                //
                echo '<br>';
                echo 'Password Yang di Masukkan Salah !';
            }

        } else {
            $username_err = "Akun Tidak Terdaftar !";
        }

       // echo 'sudah  konek';echo '<br>';

    } catch (PDOException $e) {
        $response=array(
            'status' => 1,
            'message' =>'Oops! Something went wrong. Please Try Again Later',
        );
header('Content-Type: application/json');
echo json_encode($response);
    }


?>