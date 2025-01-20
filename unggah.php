<?php
session_start();
if (!isset($_SESSION['UserID'])) {
    header("Location: index.php");
    exit();
}
include "koneksi.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unggah Foto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container my-5">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="text-dark">Selamat Datang, <?php echo htmlspecialchars($_SESSION['Username']); ?></h1>
        <a href="logout.php" class="btn btn-danger">Logout</a>
    </div>
    <hr>

    <!-- Form Unggah Foto -->
    <div class="card shadow">
        <div class="card-header bg-success text-white">
            <h3 class="mb-0">Unggah Foto Baru</h3>
        </div>
        <div class="card-body">
            <form action="upload.php" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="judul" class="form-label">Judul Foto</label>
                    <input type="text" id="judul" name="judul" class="form-control" placeholder="Masukkan judul foto" required>
                </div>
                <div class="mb-3">
                    <label for="deskripsi" class="form-label">Deskripsi Foto</label>
                    <textarea id="deskripsi" name="deskripsi" class="form-control" rows="4" placeholder="Masukkan deskripsi foto" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="tanggal" class="form-label">Tanggal Unggah</label>
                    <input type="date" id="tanggal" name="tanggal" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="foto" class="form-label">Upload Foto</label>
                    <input type="file" id="foto" name="foto" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="album" class="form-label">Pilih Album</label>
                    <select name="album" id="album" class="form-select" required>
                        <?php
                        $query = "SELECT * FROM album";
                        $result = mysqli_query($con, $query);
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<option value='{$row['AlbumID']}'>{$row['NamaAlbum']}</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="text-end">
                    <button type="submit" class="btn btn-success">Unggah</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
