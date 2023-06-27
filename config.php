<?php
    //Informasi koneksi ke database
    $host = "localhost";
    $username = "root";
    $password = "";
    $database = "tukarsaja";

    //Membuat kooneksi ke database
    $conn = mysqli_connect($host, $username, $password, $database);

    // Memeriksa apakah koneksi berhasil atau tidak
    if (!$conn) {
        die("Koneksi database gagal: " . mysqli_connect_error());
    }
?>