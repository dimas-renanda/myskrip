<?php

class Course extends Controller{
	public function index(){
		$data['judul'] = 'Daftar Course';
		$data['course'] = $this->model('Course_model')->getAllCourse();
		$this->view('templates/header', $data);
		$this->view('course/index', $data);
		$this->view('templates/foother');
	} 
	public function detail(){
		echo json_encode($this->model('Course_model')->getCourseByID($_POST['id']));
	}
	
	public function tambah(){
		if ($this->model('Mahasiswa_model')->tambahDataMahasiswa($_POST) > 0) {
			Flasher::setFlash('Data Mahasiswa Berhasil Ditambahkan', 'Sukses', 'fas fa-check-circle', 'success');
			header('Location: ' . BASEURL . '/mahasiswa');
			exit;
		} else {
			Flasher::setFlash('Data Mahasiswa Gagal Ditambahkan', 'Gagal', 'fas fa-times-circle', 'danger');
			header('Location: ' . BASEURL . '/mahasiswa');
			exit;
		}
	}

	public function delete($id = -99){
		if ($this->model('Mahasiswa_model')->hapusDataMahasiswa($id) > 0) {
			Flasher::setFlash('Data Mahasiswa Berhasil Dihapus', 'Sukses', 'fas fa-check-circle', 'warning');
			header('Location: ' . BASEURL . '/mahasiswa');
			exit;
		} 
		else if ($this->model('Mahasiswa_model')->hapusDataMahasiswa($id) == 0) {
			Flasher::setFlash('Tidak Ada Data Mahasiswa Tersebut', 'Gagal', 'fas fa-times-circle', 'danger');
			header('Location: ' . BASEURL . '/mahasiswa');
			exit;
		} 
		else if ($id < 0) {
			Flasher::setFlash('Tidak Ada Data Mahasiswa Tersebut', 'Gagal', 'fas fa-times-circle', 'danger');
			header('Location: ' . BASEURL . '/mahasiswa');
			exit;
		} 
		else{
			Flasher::setFlash('Data Mahasiswa Gagal Dihapus', 'Gagal', 'fas fa-times-circle', 'danger');
			header('Location: ' . BASEURL . '/mahasiswa');
			exit;
		}
	}

	public function ubah(){
		if($this->model('Mahasiswa_model')->ubahDataMahsiswa($_POST) > 0){
			Flasher::setFlash('Data Mahasiswa Berhasil Diubah', 'Sukses', 'fas fa-check-circle', 'success');
			header('Location: ' . BASEURL . '/mahasiswa');
			exit;
		} else {
			Flasher::setFlash('Data Mahasiswa Gagal Diubah', 'Gagal', 'fas fa-times-circle', 'danger');
			header('Location: ' . BASEURL . '/mahasiswa');
			exit;
		}
	}

	public function cari(){
		$data['judul'] = 'Daftar Course';
		$data['course'] = $this->model('Course_model')->cariDataCourse();
		$this->view('templates/header', $data);
		$this->view('course/index', $data);
		$this->view('templates/foother');
	}
}
