<?php
session_start();
if (!isset($_SESSION['UserID'])) {
    header("Location: index.php");
    exit();
}
include "koneksi.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $judul = $_POST['judul'];
    $deskripsi = $_POST['deskripsi'];
    $tanggal = $_POST['tanggal'];
    $albumID = $_POST['album'];
    $foto = $_FILES['foto'];
    $userID = $_SESSION['UserID'];

    $targetDir = "uploads/";
    $targetFile = $targetDir . basename($foto["name"]);

    if (move_uploaded_file($foto["tmp_name"], $targetFile)) {
        $query = "INSERT INTO foto (JudulFoto, DeskripsiFoto, TanggalUnggah, LokasiFoto, AlbumID, UserID) 
                  VALUES ('$judul', '$deskripsi', '$tanggal', '{$foto['name']}', '$albumID', '$userID')";
        if (mysqli_query($con, $query)) {
            header("Location: dashboard.php");
        } else {
            echo "Terjadi kesalahan: " . mysqli_error($con);
        }
    } else {
        echo "Gagal mengupload foto.";
    }
}
?>