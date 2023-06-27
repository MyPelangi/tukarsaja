<?php
    include("config.php");
    session_start();

    if (isset($_POST['unggah'])) {
        date_default_timezone_set("Asia/Jakarta");
        // print_r($_FILES); die();
        $tmp_file = $_FILES['foto']['tmp_name'];
        $nm_file = $_FILES['foto']['name'];
        $ukuran_file = $_FILES['foto']['size'];

        $nama = $_POST['nama'];
        $id_kategori = $_POST['kategori'];
        $kondisi = $_POST['kondisi'];
        $harga = $_POST['harga'];
        $deskripsi = $_POST['deskripsi'];
        $metode = $_POST['metode'];
        $username = $_SESSION['username'];
        $size = 10000000; // limit 10 MB (ukuran byte)

        if($ukuran_file > $size) {
            echo '<script>if (confirm("Gagal upload! <br>Ukuran Maksimal 10MB, saat ini ukuran file '.$ukuran_file.'<br><br>Upload ulang?")) {
                            window.location.href = "upload.php";
                        } else {
                            window.location.href = "index.php";
                        }</script>';
        } else {
            if ($nm_file) {
                $dir = "file/$nm_file";
                move_uploaded_file($tmp_file, $dir);
                $foto = file_get_contents($_FILES['foto']['tmp_name']);
                $foto = base64_encode($foto);
                $sql = "INSERT INTO barang(nama, foto, nama_file, harga, id_kategori, deskripsi, kondisi, username, metode)
                VALUES ('$nama', '$foto', '$nm_file', '$harga', '$id_kategori', '$deskripsi', '$kondisi', '$username', '$metode')";
                $query = mysqli_query($conn, $sql) or die(mysqli_error($conn));
                $message = "Barangmu berhasil diupload!";
                echo '<script>alert("' . $message . '");</script>';
                header("location: index.php");
            } else {
                echo '<script>if (confirm("Gagal upload!<br><br>Upload ulang?")) {
                                window.location.href = "upload.php";
                            } else {
                                window.location.href = "index.php";
                            }</script>';
            }
        }
    }
?>

<!DOCTYPE html>

<html lang="en" dir="ltr">
   <head>
      <meta charset="utf-8">
      <title>Upload Barangmu! - TukarSaja</title>
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
      <link rel="stylesheet" href="style_upload.css">
      <link rel="stylesheet" href="style.css">
      <link rel="icon" type="image/png" href="images/favicon.png">
 
    </head>
    <body>
        <!-- Header -->
        <header class="header shop" style="margin: 0px">
                <!-- Header Inner -->
                <div class="header-inner">
                        <div class="container">
                        <div class="row">
                            <div class="col-lg-2 col-md-2 col-12">
                                <!-- Logo -->
                                <div class="logo">
                                    <a href="index.php">
                                        <img src="images/logo2.png" class="logo-normal">
                                    </a>
                                </div>
                                <!--/ End Logo -->
                                <div class="mobile-nav"></div>
                            </div>
                            <div class="col-lg-8 col-md-7 col-12">
                            </div>
                            <div class="col-lg-2 col-md-3 col-12">
                                <nav class="navbar navbar-expand-lg">
                                    <div class="navbar-collapse">	
                                        <div class="nav-inner">	
                                            <ul class="nav main-menu menu navbar-nav">
                                                <li class="active">
                                                    <a href="upload.php">
                                                        <img class="colored-icon" src="https://cdn-icons-png.flaticon.com/512/860/860826.png">
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#">
                                                        <img class="colored-icon" src="https://cdn-icons-png.flaticon.com/512/1077/1077035.png">
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="logout.php">
                                                        <img class="colored-icon" src="https://cdn.icon-icons.com/icons2/2941/PNG/512/logout_icon_183821.png">
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </nav>
                            </div>
                        </div>
                        </div>
                    </div>
                    <!--/ End Header Inner -->
            </header>
            <!--/ End Header -->
        <form method="post" action="upload.php" enctype="multipart/form-data">
            <h3>Detail Barang</h3>
            <div class="wrapcontainer">
                <div class="container">
                    <div class="container-image">
                        <p class="foto">Unggah Foto Produkmu</p>
                        <div class="wrapper">
                            <div class="image">
                                <img id="output">
                            </div>
                            <div class="content">
                                <div class="icon"><i class="fas fa-cloud-upload-alt"></i></div>
                                <div class="text">Belum ada foto yang dipilih!</div>
                            </div>
                            <!-- <div id="cancel-btn"><i class="fas fa-times"></i></div> -->
                            <div class="file-name">Nama File Di sini</div>
                        </div>
                        <!-- <button onclick="defaultBtnActive()" id="custom-btn">Pilih Foto</button> -->
                        <input id="default-btn" type="file" name="foto" accept="image/*" onchange="loadFile(event)">
                    </div>
                </div>
                <div class="container">
                    <div class="container-form">
                        <div class="form-group">
                            <label for="namabarang" class="form-label">Nama Barang</label>
                            <input type="text" class="form-control shadow-none" name="nama" placeholder="Nama barangmu">
                        </div>
             
                        <h4>Tentang Barang</h4>
                        <p>Kategori</p>
                        <select class="form-control shadow-none selectpicker" name="kategori">
                            <option selected disabled value="default">Kategori</option>
                            <?php
                                $sql_kategori = "SELECT * FROM kategori ORDER BY nama ASC";
                                $query_kategori = mysqli_query($conn, $sql_kategori);
                                if (!$query_kategori) {
                                    die('Could not get data: ' . mysqli_error($conn));
                                } else {
                                    while ($row = mysqli_fetch_assoc($query_kategori)) {
                                        echo '<option value="' . $row['id'] . '">' . $row['nama'] . '</option>';
                                    }
                                }
                            ?>
                        </select><br>
                        <p>Kondisi</p>
                        <select class="form-control shadow-none" name="kondisi">
                            <option selected disabled value="default">Kondisi</option>
                            <option value="Baru">Baru</option>
                            <option value="Jarang Dipakai">Jarang Dipakai</option>
                            <option value="Sering Dipakai">Sering Dipakai</option>
                        </select><br>
                        <label for="harga" class="form-label">Harga</label><br>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Rp</span>
                            </div>
                            <input type="text" class="form-control shadow-none" placeholder="Harga" name="harga">
                        </div>
              
                        <label for="deskripsi" class="form-label">Deskripsi (Pilihan)</label><br>
                        <textarea class="form-control shadow-none" name="deskripsi" placeholder="Jelaskan apa yang kamu ingin jual dan masukan setiap detail yang memungkinkan penjual menjadi tertarik atas barangmu. Orang menyukai barang dengan cerita di dalamnya!"></textarea>
                        <br>
    
                        <label for="dealmethod" class="dealmethod">Metode Tukar</label><br>
                        <input type="checkbox" name="metode" value="Ambil di tempat">
                        <label for="codmethod">Ambil di tempat</label><br>
                        <input type="checkbox" name="metode" value="Kirim lewat ekspedisi">
                        <label for="ekspedisimethod">Kirim lewat ekspedisi</label><br>
                        <p></p>
                        <center><input type="submit" class="unggah" name="unggah" value="Unggah"></center>
                    </div>
                </div><br><br>
            </div>
        </form>

        <script>
        var loadFile = function(event) {
            var reader = new FileReader();
            reader.onload = function(){
                var output = document.getElementById('output');
                output.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        };
        </script>
    </body>
</html>