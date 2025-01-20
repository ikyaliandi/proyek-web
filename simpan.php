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
    <title>Galeri Foto</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <style>
        .photo-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s;
        }
        .photo-card:hover {
            transform: scale(1.02);
        }
        .photo-card img {
            max-height: 200px;
            object-fit: cover;
            width: 100%;
        }
        .photo-card .card-body {
            padding: 1rem;
        }
        .photo-card .card-body h5 {
            margin-bottom: 0.5rem;
        }
    </style>
</head>
<!-- Breadcrumb Begin -->
<div class="breadcrumb-option spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="bo-links">
                        <a href="dashboard.php"><i class="fa fa-home"></i> Home</a>
                        <span>Picture</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->

<body>
<div class="container my-4">
    <h3 class="text-center mb-4">Galeri Foto</h3>

    <!-- Formulir Pencarian -->
    <form method="GET" action="" class="mb-4">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Cari berdasarkan judul atau deskripsi foto..." value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
            <button type="submit" class="btn btn-primary">Cari</button>
            <a href="?" class="btn btn-secondary">All</a>
        </div>
    </form>

    <div class="row g-3">
        <?php
            // Ambil kata kunci pencarian
            $search = isset($_GET['search']) ? mysqli_real_escape_string($con, $_GET['search']) : '';

            // Query dengan filter pencarian
            $query = "SELECT 
                        foto.FotoID, 
                        foto.JudulFoto, 
                        foto.DeskripsiFoto, 
                        foto.TanggalUnggah, 
                        foto.LokasiFoto, 
                        album.NamaAlbum, 
                        user.Username, 
                        (SELECT COUNT(*) FROM likefoto WHERE likefoto.FotoID = foto.FotoID) AS JumlahLike, 
                        (SELECT COUNT(*) FROM komentarfoto WHERE komentarfoto.FotoID = foto.FotoID) AS JumlahKomentar
                    FROM foto
                    INNER JOIN album ON foto.AlbumID = album.AlbumID
                    INNER JOIN user ON foto.UserID = user.UserID";

            // Tambahkan filter jika ada pencarian
            if (!empty($search)) {
                $query .= " WHERE foto.JudulFoto LIKE '%$search%' OR foto.DeskripsiFoto LIKE '%$search%'";
            }

            $result = mysqli_query($con, $query);

            if (!$result) {
                die("Query Error: " . mysqli_error($con));
            }

            // Tampilkan hasil
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<div class='col-md-4 col-lg-3'>
                        <div class='photo-card'>
                            <img src='uploads/{$row['LokasiFoto']}' alt='{$row['JudulFoto']}'>
                            <div class='card-body'>
                                <h5 class='card-title'>{$row['JudulFoto']}</h5>
                                <p class='card-text text-muted'>{$row['DeskripsiFoto']}</p>
                                <p class='card-text'><small><strong>Album:</strong> {$row['NamaAlbum']}</small></p>
                                <p class='card-text'><small><strong>Upload oleh:</strong> {$row['Username']}</small></p>
                                <p class='card-text'><small><strong>Likes:</strong> {$row['JumlahLike']} | <strong>Komentar:</strong> {$row['JumlahKomentar']}</small></p>
                                <div class='d-flex justify-content-between'>
                                    <a href='edit.php?id={$row['FotoID']}' class='btn btn-sm btn-primary'>Edit</a>
                                    <a href='delete.php?id={$row['FotoID']}' class='btn btn-sm btn-danger' onclick='return confirmDelete()'>Hapus</a>
                                </div>
                            </div>
                        </div>
                    </div>";
            }
        ?>
    </div>

    <?php
        // Tampilkan pesan jika ada
        if (isset($_SESSION['message'])) {
            echo "<div class='alert alert-info mt-4'>{$_SESSION['message']}</div>";
            unset($_SESSION['message']);
        }
    ?>
</div>
<script>
    function confirmDelete() {
        return confirm("Apakah Anda yakin ingin menghapus foto ini?");
    }
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
