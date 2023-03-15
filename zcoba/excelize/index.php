<?php 

require 'vendor/autoload.php';

// use PhpOffice\PhpSpreadsheet\Spreadsheet;
// use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
// $reader->setReadDataOnly(true);
// $spreadsheet = $reader->load("data.xls");
// $sheet = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
//var_dump($sheet);



                        // foreach ($sheet as $row) { // Lakukan perulangan dari data yang ada di excel
                        //     // Ambil data pada excel sesuai Kolom
                        //     $nis = $row['A']; // Ambil data NIS
                        //     $nama = $row['B']; // Ambil data nama
                        //     $jenis_kelamin = $row['C']; // Ambil data jenis kelamin
                        //     $telp = $row['D']; // Ambil data telepon
                        //     $alamat = $row['E']; // Ambil data alamat

                        //     // Cek jika semua data tidak diisi
                        //     if ($nis == "" && $nama == "" && $jenis_kelamin == "" && $telp == "" && $alamat == "")
                        //         continue; // Lewat data pada baris ini (masuk ke looping selanjutnya / baris selanjutnya)

                        //     // Cek $numrow apakah lebih dari 1
                        //     // Artinya karena baris pertama adalah nama-nama kolom
                        //     // Jadi dilewat saja, tidak usah diimport
                        //     if ($numrow > 1) {
                        //         // Validasi apakah semua data telah diisi
                        //         $nis_td = (!empty($nis)) ? "" : " style='background: #E07171;'"; // Jika NIS kosong, beri warna merah
                        //         $nama_td = (!empty($nama)) ? "" : " style='background: #E07171;'"; // Jika Nama kosong, beri warna merah
                        //         $jk_td = (!empty($jenis_kelamin)) ? "" : " style='background: #E07171;'"; // Jika Jenis Kelamin kosong, beri warna merah
                        //         $telp_td = (!empty($telp)) ? "" : " style='background: #E07171;'"; // Jika Telepon kosong, beri warna merah
                        //         $alamat_td = (!empty($alamat)) ? "" : " style='background: #E07171;'"; // Jika Alamat kosong, beri warna merah

                        //         // Jika salah satu data ada yang kosong
                        //         if ($nis == "" or $nama == "" or $jenis_kelamin == "" or $telp == "" or $alamat == "") {
                        //             $kosong++; // Tambah 1 variabel $kosong
                        //         }

                        //         echo "<tr>";
                        //         echo "<td" . $nis_td . ">" . $nis . "</td>";
                        //         echo "<td" . $nama_td . ">" . $nama . "</td>";
                        //         echo "<td" . $jk_td . ">" . $jenis_kelamin . "</td>";
                        //         echo "<td" . $telp_td . ">" . $telp . "</td>";
                        //         echo "<td" . $alamat_td . ">" . $alamat . "</td>";
                        //         echo "</tr>";
                        //     }

                        //     $numrow++; // Tambah 1 setiap kali looping
                        // }

                //echo "</table></div>";

///////////////////////batasssssssss

                // Buat sebuah div untuk alert validasi kosong
                // echo "<br><br> <div id='kosong' class='alert alert-danger'>
				// 	Semua data belum diisi, Ada <span id='jumlah_kosong'></span> data yang belum diisi.
                // </div>";

                // echo "<div class='table-responsive'>
                //     <table class='table table-bordered'>
                //         <tr>
                //             <th colspan='5' class='text-left'>Preview Data</th>
                //         </tr>
                //         <tr>
                //             <th>#</th>
                //             <th>NRP</th>
                //             <th>Nama</th>
                //             <th>Telepon</th>
                //             <th>Alamat</th>
                //         </tr>";

                        

        //                 $numrow = 1;
        //                 $kosong = 0;
        //                 foreach ($sheet as $row) { // Lakukan perulangan dari data yang ada di excel
        //                     // Ambil data pada excel sesuai Kolom
        //                     $nis = $row['A']; // Ambil data NIS
        //                     $nama = $row['B']; // Ambil data nama
        //                     $jenis_kelamin = $row['C']; // Ambil data jenis kelamin
        //                     $telp = $row['D']; // Ambil data telepon
        //                     $alamat = $row['E']; // Ambil data alamat

        //                     // Cek jika semua data tidak diisi
        //                     if ($nis == "" && $nama == "" && $jenis_kelamin == "" && $telp == "" && $alamat == "")
        //                         continue; // Lewat data pada baris ini (masuk ke looping selanjutnya / baris selanjutnya)

        //                     // Cek $numrow apakah lebih dari 1
        //                     // Artinya karena baris pertama adalah nama-nama kolom
        //                     // Jadi dilewat saja, tidak usah diimport
        //                     if ($numrow > 1) {
        //                         // Validasi apakah semua data telah diisi
        //                         $nis_td = (!empty($nis)) ? "" : " style='background: #E07171;'"; // Jika NIS kosong, beri warna merah
        //                         $nama_td = (!empty($nama)) ? "" : " style='background: #E07171;'"; // Jika Nama kosong, beri warna merah
        //                         $jk_td = (!empty($jenis_kelamin)) ? "" : " style='background: #E07171;'"; // Jika Jenis Kelamin kosong, beri warna merah
        //                         $telp_td = (!empty($telp)) ? "" : " style='background: #E07171;'"; // Jika Telepon kosong, beri warna merah
        //                         $alamat_td = (!empty($alamat)) ? "" : " style='background: #E07171;'"; // Jika Alamat kosong, beri warna merah

        //                         // Jika salah satu data ada yang kosong
        //                         if ($nis == "" or $nama == "" or $jenis_kelamin == "" or $telp == "" or $alamat == "") {
        //                             $kosong++; // Tambah 1 variabel $kosong
        //                         }

        //                         echo "<tr>";
        //                         echo "<td" . $nis_td . ">" . $nis . "</td>";
        //                         echo "<td" . $nama_td . ">" . $nama . "</td>";
        //                         echo "<td" . $jk_td . ">" . $jenis_kelamin . "</td>";
        //                         echo "<td" . $telp_td . ">" . $telp . "</td>";
        //                         echo "<td" . $alamat_td . ">" . $alamat . "</td>";
        //                         echo "</tr>";
        //                     }

        //                     $numrow++; // Tambah 1 setiap kali looping
        //                 }

        //         echo "</table></div>";

        //         // Cek apakah variabel kosong lebih dari 0
        //         // Jika lebih dari 0, berarti ada data yang masih kosong
        //         if ($kosong > 0) {
        // ?>

<?php
        //         } else { // Jika semua data sudah diisi
        //             echo "<hr style='margin-top: 0;'>";

        //             // Buat sebuah tombol untuk mengimport data ke database
        //             echo "<button type='submit' name='import' class='btn btn-success'>IMPORT</button>";
        //         }

        //         echo "</form>";





?>

<!DOCTYPE html>
<html>
<head>
    <title>Manual Obe File Input </title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

</head>
<body>
<div class="container">
    <div class="row justify-content-center">
    <div style="padding: 10px 20px;">
        <h3 style="margin-top: 5px;">Obe Tools File Input</h3>
        <hr style="margin-top: 5px;margin-bottom: 15px;">

        <form method="post" action="" enctype="multipart/form-data">
            <a href="Format.xlsx">Download Format</a> &nbsp;|&nbsp;
            <a href="index.php">Reset</a>
            <br><br>

            <div class="clearfix">
                <div class="float-left" style="margin-right: 5px;">
                    <input type="file" name="file" class="form-control">
                </div>
                <br>
                <button type="submit" name="preview" class="btn btn-primary">PREVIEW</button>
            </div>

        </form>
<?php         if (isset($_POST['preview'])) {
            $tgl_sekarang = date('YmdHis'); // Ini akan mengambil waktu sekarang dengan format yyyymmddHHiiss
            $nama_file_baru = 'data' . $tgl_sekarang . '.xls';

            // Cek apakah terdapat file data.xlsx pada folder tmp
            if (is_file('tmp/' . $nama_file_baru)) // Jika file tersebut ada
                unlink('tmp/' . $nama_file_baru); // Hapus file tersebut

            $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION); // Ambil ekstensi filenya apa
            $tmp_file = $_FILES['file']['tmp_name'];

            if ($ext == "xls") {
                // Upload file yang dipilih ke folder tmp
                // dan rename file tersebut menjadi data{tglsekarang}.xlsx
                // {tglsekarang} diganti jadi tanggal sekarang dengan format yyyymmddHHiiss
                // Contoh nama file setelah di rename : data20210814192500.xlsx
                move_uploaded_file($tmp_file, 'tmp/' . $nama_file_baru);

                // $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                // $spreadsheet = $reader->load('tmp/' . $nama_file_baru); // Load file yang tadi diupload ke folder tmp
                // $sheet = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
$reader->setReadDataOnly(true);
$spreadsheet = $reader->load('tmp/' . $nama_file_baru); // Load file yang tadi diupload ke folder tmp
$sheet = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);


                // Cek apakah variabel kosong lebih dari 0
                // Jika lebih dari 0, berarti ada data yang masih kosong

            } ?>
       <hr>
        <div class="col-sm-10">
        <table class="table table-striped table-hover rounded">
    <thead class="bg-primary text-light">
        <tr>
            <?php foreach ($sheet[1] as $header): ?>
                <th><?= $header ?></th>
            <?php endforeach ?>
        </tr>
    </thead>
    <tbody>
        <?php for ($i = 2; $i <= count($sheet); $i++): ?>
            <tr>
                <?php foreach ($sheet[$i] as $cell): ?>

                   
                    <td ><a href="api/gradestudent/student.php?id=<?php echo $cell;?>"> <?= $cell ?></a></td>  
                    
                <?php endforeach ?>
            </tr>
        <?php endfor  ?>
    </tbody>
</table>


        </div>
    </div>
</div>
            <?php  
            
}
            ?>




 

</body>
</html>



