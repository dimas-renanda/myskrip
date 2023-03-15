<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css">
  
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script>

    <title>News</title>

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
    // if (localStorage.getItem('sb|sidebar-toggle') === 'true') {
    //     document.body.classList.toggle('sb-sidenav-toggled');
    // }
    sidebarToggle.addEventListener('click', event => {
        event.preventDefault();
        document.body.classList.toggle('sb-sidenav-toggled');
        localStorage.setItem('sb|sidebar-toggle', document.body.classList.contains('sb-sidenav-toggled'));
    });
}

});
    </script>
</head>

<body>

<div class="col-md" style="padding-left: 20px; padding-top: 20px; padding-bottom: 20px; padding-right: 20px;">
<h3>Obe Tools File Input </h3>
<hr>

<div class="container">
    <div class="row justify-content-center">
    <div style="padding: 10px 20px;">
        <!-- <h3 style="margin-top: 5px;">Obe Tools File Input</h3> -->
        <!-- <hr style="margin-top: 5px;margin-bottom: 15px;"> -->

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
<?php        
require 'vendor/autoload.php';

 use PhpOffice\PhpSpreadsheet\Spreadsheet;
 use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
 if (isset($_POST['preview'])) {
            $tgl_sekarang = date('YmdHis'); // Ini akan mengambil waktu sekarang dengan format yyyymmddHHiiss
            $nama_file_baru = 'data' . $tgl_sekarang . '.xls';

            // Cek apakah terdapat file data.xlsx pada folder tmp
            if (is_file('../file/tmp/' . $nama_file_baru)) // Jika file tersebut ada
                unlink('../file/tmp/' . $nama_file_baru); // Hapus file tersebut

            $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION); // Ambil ekstensi filenya apa
            $tmp_file = $_FILES['file']['tmp_name'];

            if ($ext == "xls") {
                // Upload file yang dipilih ke folder tmp
                // dan rename file tersebut menjadi data{tglsekarang}.xlsx
                // {tglsekarang} diganti jadi tanggal sekarang dengan format yyyymmddHHiiss
                // Contoh nama file setelah di rename : data20210814192500.xlsx
                move_uploaded_file($tmp_file, '../file/tmp/' . $nama_file_baru);

                // $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                // $spreadsheet = $reader->load('tmp/' . $nama_file_baru); // Load file yang tadi diupload ke folder tmp
                // $sheet = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
$reader->setReadDataOnly(true);
$spreadsheet = $reader->load('../file/tmp/' . $nama_file_baru); // Load file yang tadi diupload ke folder tmp
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

</div>

</body>
</html>

