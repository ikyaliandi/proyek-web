<?php
session_start();
if (!isset($_SESSION['UserID'])) {
    header("Location: index.php");
    exit();
}

include "koneksi.php";

if (isset($_GET['id'])) {
    $fotoID = intval($_GET['id']);
    
    // Ambil data foto berdasarkan ID
    $query = "SELECT * FROM foto WHERE FotoID = ?";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "i", $fotoID);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $foto = mysqli_fetch_assoc($result);
    
    if (!$foto) {
        $_SESSION['message'] = "Foto tidak ditemukan.";
        header("Location: dashboard.php");
        exit();
    }
    mysqli_stmt_close($stmt);
} else {
    $_SESSION['message'] = "ID foto tidak ditemukan.";
    header("Location: dashboard.php");
    exit();
}

// Proses update data
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $judul = $_POST['judul'];
    $deskripsi = $_POST['deskripsi'];
    $tanggal = $_POST['tanggal'];
    $album = intval($_POST['album']);
    
    // Handle file upload jika ada
    $lokasiFotoBaru = $foto['LokasiFoto']; // Default ke foto lama
    if (!empty($_FILES['foto']['name'])) {
        $targetDir = "uploads/";
        $fileName = basename($_FILES['foto']['name']);
        $targetFilePath = $targetDir . $fileName;
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
        
        // Validasi tipe file
        $allowedTypes = array('jpg', 'jpeg', 'png', 'gif');
        if (in_array(strtolower($fileType), $allowedTypes)) {
            // Upload file baru
            if (move_uploaded_file($_FILES['foto']['tmp_name'], $targetFilePath)) {
                $lokasiFotoBaru = $fileName; // Update lokasi file baru
            } else {
                $_SESSION['message'] = "Gagal mengunggah foto baru.";
                header("Location: dashboard.php");
                exit();
            }
        } else {
            $_SESSION['message'] = "Format file tidak valid. Hanya JPG, JPEG, PNG, dan GIF yang diperbolehkan.";
            header("Location: dashboard.php");
            exit();
        }
    }
    
    // Update data ke database
    $query = "UPDATE foto SET JudulFoto = ?, DeskripsiFoto = ?, TanggalUnggah = ?, AlbumID = ?, LokasiFoto = ? WHERE FotoID = ?";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "sssisi", $judul, $deskripsi, $tanggal, $album, $lokasiFotoBaru, $fotoID);
    
    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['message'] = "Foto berhasil diperbarui.";
    } else {
        $_SESSION['message'] = "Gagal memperbarui data foto.";
    }
    mysqli_stmt_close($stmt);
    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Foto</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background: #ffffff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        .form-control, .form-select {
            margin-bottom: 15px;
        }
        .form-label {
            font-weight: bold;
        }
        .btn {
            width: 100%;
        }
        .img-preview {
            display: block;
            max-width: 100%;
            margin: 15px auto;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
    </style>
</head>
<body>

<div class="container">
    <h3 class="text-center mb-4">Edit Foto</h3>
    <form action="" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="judul" class="form-label">Judul Foto:</label>
            <input type="text" id="judul" name="judul" class="form-control" value="<?php echo htmlspecialchars($foto['JudulFoto']); ?>" required>
        </div>

        <div class="mb-3">
            <label for="deskripsi" class="form-label">Deskripsi Foto:</label>
            <textarea id="deskripsi" name="deskripsi" class="form-control" rows="4" required><?php echo htmlspecialchars($foto['DeskripsiFoto']); ?></textarea>
        </div>

        <div class="mb-3">
            <label for="tanggal" class="form-label">Tanggal Unggah:</label>
            <input type="date" id="tanggal" name="tanggal" class="form-control" value="<?php echo htmlspecialchars($foto['TanggalUnggah']); ?>" required>
        </div>

        <div class="mb-3">
            <label for="album" class="form-label">Album:</label>
            <select name="album" id="album" class="form-select" required>
                <?php
                $query = "SELECT * FROM album";
                $result = mysqli_query($con, $query);
                while ($row = mysqli_fetch_assoc($result)) {
                    $selected = ($row['AlbumID'] == $foto['AlbumID']) ? "selected" : "";
                    echo "<option value='{$row['AlbumID']}' $selected>{$row['NamaAlbum']}</option>";
                }
                ?>
            </select>
        </div>

        <div class="mb-3 text-center">
            <label for="foto" class="form-label">Foto Sebelumnya:</label><br>
            <img src="uploads/<?php echo htmlspecialchars($foto['LokasiFoto']); ?>" class="img-preview" alt="Foto Sebelumnya">
        </div>

        <div class="mb-3">
            <label for="foto" class="form-label">Upload Foto Baru:</label>
            <input type="file" id="foto" name="foto" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        <a href="dashboard.php" class="btn btn-secondary mt-2">Batal</a>
    </form>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
