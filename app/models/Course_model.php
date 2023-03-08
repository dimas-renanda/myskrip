<?php 
class Course_model{
	private $db;

	public function __construct(){
		$this->db = new Database;
	}

	public function getAllCourse(){
		$this->db->query('SELECT * FROM mdl_course');
		return $this->db->resultSet();
	}
	public function getCourseByID($id){
		$this->db->query('SELECT * FROM mdl_course WHERE id=:id');
		$this->db->bind('id', $id);
		return $this->db->single();
	}
	// public function tambahDataMahasiswa($data){
	// 	$query = "INSERT INTO mahasiswa VALUES
	// 			('', :nama, :npm, :email, :jurusan, '')";
	// 	$this->db->query($query);
	// 	$this->db->bind('nama', $data['nama']);
	// 	$this->db->bind('npm', $data['npm']);
	// 	$this->db->bind('email', $data['email']);
	// 	$this->db->bind('jurusan', $data['jurusan']);
	// 	$this->db->execute();

	// 	return $this->db->rowCount();
	// }
	// public function hapusDataMahasiswa($id){
	// 	$query = "DELETE FROM mahasiswa WHERE id=:id";
	// 	$this->db->query($query);
	// 	$this->db->bind('id', $id);
	// 	$this->db->execute();
	// 	return $this->db->rowCount();
	// }
	// public function ubahDataMahsiswa($data){
	// 	$query = "UPDATE mahasiswa SET
	// 		nama=:nama,
	// 		npm=:npm,
	// 		email=:email,
	// 		jurusan=:jurusan
	// 		WHERE id=:id";
	// 	$this->db->query($query);
	// 	$this->db->bind('id', $data['id']);
	// 	$this->db->bind('nama', $data['nama']);
	// 	$this->db->bind('npm', $data['npm']);
	// 	$this->db->bind('email', $data['email']);
	// 	$this->db->bind('jurusan', $data['jurusan']);
	// 	$this->db->execute();
	// 	return $this->db->rowCount();
	// }

	public function cariDataCourse(){
		$keyword = $_POST['keyword'];
		$query = "SELECT * FROM mdl_course WHERE shortname LIKE :keyword";
		$this->db->query($query);
		$this->db->bind('keyword', "%$keyword%");
		$this->db->execute();
		return $this->db->resultSet();
	}
}
