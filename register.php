<?php
  session_start();
  include("config.php");

  if (isset($_POST['daftar'])) {
      date_default_timezone_set("Asia/Jakarta");

      $email = htmlentities(strip_tags(trim($_POST['email'])));
      $password = htmlentities(strip_tags(trim($_POST['password'])));
      $username = htmlentities(strip_tags(trim($_POST['username'])));
      $nama = htmlentities(strip_tags(trim($_POST['nama'])));
      $alamat = htmlentities(strip_tags(trim($_POST['alamat'])));
      $notelp = htmlentities(strip_tags(trim($_POST['notelp'])));
      $error_message = "";

      if (strlen($username) < 3) {
          $error_message .= "Username setidaknya harus 3 karakter";
      }

      $username = mysqli_real_escape_string($conn, $username);
      $query = "SELECT * FROM pengguna WHERE username='$username'";
      $result = mysqli_query($conn, $query);
      $num_rows = mysqli_num_rows($result);
      if ($num_rows >= 1) {
          $error_message .= "Username sudah terdaftar";
      }

      if ($error_message === "") {
          $sql = "INSERT INTO pengguna(username, nama, alamat, no_tlp, email, password)
                  VALUES ('$username', '$nama', '$alamat', '$notelp', '$email', '$password')";
          $query = mysqli_query($conn, $sql) or die(mysqli_error($conn));

          header("location: login.php");
      }
  }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Daftar Akun - TukarSaja</title>
    <link rel="stylesheet" href="./css/style.css" />
    <link rel="icon" type="image/png" href="images/favicon.png">
  </head>

  <body>
    <div class="container">
      <div class="img">
        <img src="img/img2.svg" />
      </div>

      <div class="login-container">
        <form method="post" action="register.php">
          <div class="isi-login">
          <div class="header">
              <h1>Daftar Akun</h1>
              <p>Hi, Selamat Datang!</p>
            </div>

            <div class="form-input">
            <label for="email">Email <span style="color: red">*</span></label
              ><br />
              <input type="text" name="email" placeholder="Email" /><br /><br />
            </div>

            <div class="form-input">
              <label for="password"
                >Password <span style="color: red">*</span></label
              ><br />
              <input
                type="password"
                name="password"
                placeholder="Password"
              /><br /><br />
              <label for="username">Username
                <span style="color: red">*</span>
              </label><br />
              <input
                type="text"
                name="username"
                placeholder="Username"
              />
              <?php
                if (isset($error_message) && $error_message !== "") {
                  echo "<br /><span style='color: red; font-size: 12px;'>$error_message</span>";
                }                       
              ?>
              <br /><br />
            </div>

            <div class="form-input">
              <label for="nama"
                >Nama lengkap <span style="color: red">*</span></label
              ><br />
              <input
                type="text"
                name="nama"
                placeholder="Nama Lengkap"
              /><br /><br />
            </div>

            <div class="form-input">
              <label for="alamat"
                >Alamat <span style="color: red">*</span></label
              ><br />
              <input
                type="text"
                name="alamat"
                placeholder="Alamat"
              /><br /><br />
            </div>

            <div class="form-input">
              <label for="notelp"
                >Nomor Telepon <span style="color: red">*</span></label
              ><br />
              <input
                type="text"
                name="notelp"
                placeholder="Nomor Telepon"
              /><br /><br />
            </div>

            <input type="submit" name="daftar" value="DAFTAR" />
          </div>
        </form>
      </div>
    </div>

    <script type="text/javascript" src="js/regist2.js"></script>
  </body>
</html>
