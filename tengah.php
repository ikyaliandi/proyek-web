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
</head>
<body>
    <p>Selamat Datang <?php echo htmlspecialchars($_SESSION['Username']); ?> | <a href="logout.php">Logout</a></p>
    <hr>

    <h3>Unggah Foto Baru</h3>
    <form action="upload.php" method="POST" enctype="multipart/form-data">
        <label for="judul">Judul Foto:</label>
        <input type="text" id="judul" name="judul" placeholder="Masukkan judul foto" required><br><br>
        <label for="deskripsi">Deskripsi Foto:</label>
        <textarea id="deskripsi" name="deskripsi" rows="4" placeholder="Masukkan deskripsi foto" required></textarea><br><br>
        <label for="tanggal">Tanggal Unggah:</label>
        <input type="date" id="tanggal" name="tanggal" required><br><br>
        <label for="foto">Upload Foto:</label>
        <input type="file" id="foto" name="foto" required><br><br>
        <label for="album">Album:</label>
        <select name="album" id="album" required>
            <?php
            $query = "SELECT * FROM album";
            $result = mysqli_query($con, $query);
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<option value='{$row['AlbumID']}'>{$row['NamaAlbum']}</option>";
            }
            ?>
        </select><br><br>
        <button type="submit">Submit</button>
    </form>
    <hr>
    <h3>Foto yang Telah Diupload</h3>
    <table border="1">
        <thead>
            <tr>
                <th>No</th>
                <th>Foto</th>
                <th>Judul Foto</th>
                <th>Deskripsi Foto</th>
                <th>Tanggal</th>
                <th>Album</th>
                <th>User Upload</th>
                <th>Jumlah Like</th>
                <th>Jumlah Komentar</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        <?php
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

                    $result = mysqli_query($con, $query);

                    if (!$result) {
                        die("Query Error: " . mysqli_error($con));
                    }

                    $no = 1;
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>
                                <td>{$no}</td>
                                <td><img src='uploads/{$row['LokasiFoto']}' width='100'></td>
                                <td>{$row['JudulFoto']}</td>
                                <td>{$row['DeskripsiFoto']}</td>
                                <td>{$row['TanggalUnggah']}</td>
                                <td>{$row['NamaAlbum']}</td>
                                <td>{$row['Username']}</td>
                                <td>{$row['JumlahLike']}</td>
                                <td>{$row['JumlahKomentar']}</td>
                                <td>
                                    <a href='edit.php?id={$row['FotoID']}'>Edit</a> | 
                                    <a href='delete.php?id={$row['FotoID']}' onclick='return confirmDelete()'>Delete</a>
                                </td>
                            </tr>";
                        $no++;
                    }
        ?>
        </tbody>
        <?php
            if (isset($_SESSION['message'])) {
                echo "<p>{$_SESSION['message']}</p>";
                unset($_SESSION['message']);
            }
        ?>
        <script>
            function confirmDelete() {
                return confirm("Apakah Anda yakin ingin menghapus foto ini?");
            }
        </script>
    </table>
</body>
</html>