<?php
session_start();
include "koneksi.php";

if (!isset($_SESSION['UserID'])) {
    echo json_encode(["success" => false, "message" => "Anda harus login untuk menyukai foto."]);
    exit();
}

$fotoID = isset($_POST['FotoID']) ? intval($_POST['FotoID']) : 0;
$userID = $_SESSION['UserID'];

if ($fotoID > 0) {
    // Periksa apakah user sudah menyukai foto
    $checkLike = mysqli_query($con, "SELECT * FROM likefoto WHERE FotoID = $fotoID AND UserID = $userID");
    if (mysqli_num_rows($checkLike) > 0) {
        // Hapus Like jika sudah ada
        mysqli_query($con, "DELETE FROM likefoto WHERE FotoID = $fotoID AND UserID = $userID");
        echo json_encode(["success" => true, "liked" => false]);
    } else {
        // Tambahkan Like
        mysqli_query($con, "INSERT INTO likefoto (FotoID, UserID) VALUES ($fotoID, $userID)");
        echo json_encode(["success" => true, "liked" => true]);
    }
} else {
    echo json_encode(["success" => false, "message" => "ID Foto tidak valid."]);
}
?>
