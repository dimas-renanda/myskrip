<?php
// //Menggunakan objek mysqli membuat koneksi dan menyimpan nya dalam variabel $mysqli	
// // $mysqli = new mysqli($servername, $username, $password, $dbname);

// // Menggunakan mysqli konek db

// // $conn = new mysqli($servername, $username, $password);
// // if ($conn->connect_error) {
// //     die("Gagal Terkoneksi: " . $conn->connect_error);
// // }echo "Koneksi Method Mysqli Berhasil ";

//using clas

// class Database{
    
//   // CHANGE THE DB INFO ACCORDING TO YOUR DATABASE
//   private $db_host = 'localhost';
//   private $db_name = 'database_api';
//   private $db_username = 'root';
//   private $port = "3308";
//   private $db_password = '';
  
//   public function dbConnection(){
      
//       try{
//           $conn = new PDO('mysql:host='.$this->db_host.'; port=3308; dbname='.$this->db_name,$this->db_username,$this->db_password);
//           $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//           return $conn;
//       }
//       catch(PDOException $e){
//           echo "Connection error ".$e->getMessage(); 
//           exit;
//       }
        
//   }
// }

 ?>
 
<?php 
include 'credential.php';

// // pdo konek db
try {
  $conn = new PDO("mysql:host=$servername;dbname=$dbname; port=$port;", $username, $password);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) 
{
  echo "Connection failed: " . $e->getMessage();
}

try {
  $connapp = new PDO("mysql:host=$servername;dbname=obetools; port=$port;", $username, $password);
  // set the PDO error mode to exception
  $connapp->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) 
{
  echo "Connection failed: " . $e->getMessage();
}

?>