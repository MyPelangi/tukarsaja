<?php
    // session dimulai
    session_start();
    include("config.php");

    if (isset($_POST['login'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        if($username != '' && $password != ''){
            // query untuk mengecek apakah ada data user dengan username dan password yang dikirim dari form
            $sql = "SELECT * FROM pengguna WHERE username='$username' AND password='$password'";
            $query = mysqli_query($conn, $sql);
            $data = mysqli_fetch_assoc($query);// ambil data dari hasil query
            if(mysqli_num_rows($query) < 1){
                // buat sebuah cookie untuk menampung data pesan kesalahan
                setcookie("message", "Maaf, username atau password salah", time()+60);
                header("location: login.php");// redirect ke halaman login.php
            }else{
                echo $data['username'] . $data['password'];
                $_SESSION['username'] = $data['username'];// set session username
                $_SESSION['nama'] = $data['nama'];// set session nama
                setcookie("message","",time()-60);// delete cookie message
                header("location: index.php");// redirect ke halaman index.php
            }
        }else{
            setcookie("message", "Username atau Password kosong", time()+60);
            header("location: login.php");// redirect ke halaman login.php
        }  
    }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login - TukarSaja</title>
    <link rel="icon" type="image/png" href="images/favicon.png">
    <link rel="stylesheet" href="./css/style.css" />
  </head>

  <body>
    <div class="container">
      <div class="img">
        <!-- <img src="tukarsaja/images/logo2.png" alt="" /> -->
        <img src="img/img1.svg" />
      </div>

      <div class="login-container">
        <form method="post" action="login.php">
          <div class="isi-login">
            <div class="header">
              <h1>Masuk Akun</h1>
              <p>Hi, Selamat Datang!</p>
            </div>

            <div class="form-input">
              <label for="username">Username <span style="color: red">*</span></label
              ><br />
              <input type="text" name="username" placeholder="Username" /><br /><br />
            </div>

            <div class="form-input">
              <label for="password">Password <span style="color: red">*</span></label
              ><br />
              <input
                type="password"
                name="password"
                placeholder="Password"
              /><br /><br />
            </div>

            <input type="submit" name="login" value="MASUK" />

            <p class="daftar" style="color: #868686">
              Belum punya akun?
              <a href="register.php"><span style="color: #f88a00">Daftar</span></a>
            </p>
          </div>
        </form>
      </div>
    </div>

    <script type="text/javascript" src="js/login.js"></script>
  </body>
</html>