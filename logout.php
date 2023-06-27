<?php
    session_start();// session dimulai
    session_destroy();// hapus session
    header("location: index.php");// redirect ke halaman index.php
?>