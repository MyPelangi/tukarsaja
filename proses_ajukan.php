<?php
    include("config.php");
    session_start();

    $id_barang1 = $_GET["id_barang1"];
    $id_barang2 = $_GET["pilih-barang"];
    $tambah_harga = $_GET["tambah_harga"];

    if($id_barang1 != $id_barang2){
        $sql = "INSERT INTO penawaran(id_barang1, id_barang2, tambah_harga)
                VALUES ('$id_barang1', '$id_barang2', '$tambah_harga')";
        $query = mysqli_query($conn,$sql) or die(mysqli_error($conn));

        $sql_penawaran = "SELECT * FROM penawaran ORDER BY id DESC";
        $query_penawaran = mysqli_query($conn,$sql_penawaran);
        if (mysqli_num_rows($query_penawaran) > 0) {
            while ($row = mysqli_fetch_assoc($query_penawaran)) {
                $id_penawaran = $row['id'];
                header("location: chat.php?id_penawaran=$id_penawaran");
            }
        }
    } else {
        echo '<script>alert("Gagal mengajukan penawaran!");</script>';
        header("location: view.php?id=$id_barang1");
    }
?>