<?php
    // Mulai sesi
    session_start();

    // Menyertakan koneksi ke database
    include "koneksi.php";

    // Proses saat tombol "register" ditekan
    if (isset($_POST['register'])) {
        // Mengambil data dari form
        $NamaLengkap = mysqli_real_escape_string($con, $_POST['NamaLengkap']);
        $Username = mysqli_real_escape_string($con, $_POST['Username']);
        $Email = mysqli_real_escape_string($con, $_POST['Email']);
        $Password = !empty($_POST["Password"]) ? md5($_POST["Password"]) : null;
        $Alamat = mysqli_real_escape_string($con, $_POST['Alamat']);

        // Validasi password
        if ($Password === null) {
            die("Password tidak boleh kosong!");
        }

        // Query untuk memasukkan data ke database
        $sql = "INSERT INTO user (NamaLengkap, Username, Email, Password, Alamat) 
                VALUES ('$NamaLengkap', '$Username', '$Email', '$Password', '$Alamat')";

        // Menjalankan query
        if (mysqli_query($con, $sql)) {
            $_SESSION['message'] = "Akun berhasil dibuat!";
            header("Location: index.php"); // Redirect ke halaman lain setelah sukses
            exit();
        } else {
            echo "Terjadi kesalahan: " . mysqli_error($con);
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
        /* Reset default styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: #f7f7f7;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #333;
        }

        .register-container {
            background-color: #17a636; /* Warna hijau */
            color: #ffffff; /* Warna teks putih untuk kontras */
            padding: 3rem;
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
            border: 4px solid #333333; /* Border hitam di sisi tabel */
        }

        .register-container h2 {
            text-align: center;
            margin-bottom: 2rem;
            font-size: 2rem;
            color: #000000; /* Warna teks hitam */
            font-weight: bold; /* Bold hanya pada teks "Daftar" */
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            color: #000000; /* Warna teks hitam */
            margin-bottom: 0.5rem;
            display: block;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 0.8rem;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1rem;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .form-group input:focus,
        .form-group textarea:focus {
            border-color: #ffffff;
            box-shadow: 0 0 5px rgba(255, 255, 255, 0.3);
            outline: none;
        }

        .btn {
            width: 100%;
            padding: 0.8rem;
            background-color: #000000; /* Warna tombol hitam */
            border: none;
            color: #ffffff; /* Warna teks putih */
            font-size: 1rem;
            font-weight: bold;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .btn:hover {
            background-color: #333333; /* Warna hitam lebih terang saat hover */
            transform: translateY(-2px);
        }

        .text-center {
            text-align: center;
        }

        .text-center p {
            color: #000000; /* Warna hitam pekat untuk teks "Sudah punya akun?" */
            font-weight: normal; /* Tidak bold */
            margin-top: 1.5rem; /* Menambahkan jarak atas */
        }

        .text-center a {
            color: #ffffff; /* Warna putih untuk link "Login di sini" */
            text-decoration: none;
            font-weight: bold;
        }

        .text-center a:hover {
            text-decoration: underline;
        }

        @media (max-width: 480px) {
            .register-container {
                padding: 2rem;
            }

            .register-container h2 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>

    <div class="register-container">
        <h2>Daftar</h2>
        <form action="" method="POST">
            <div class="form-group">
                <label for="NamaLengkap">Nama Lengkap</label>
                <input class="form-control" type="text" name="NamaLengkap" id="NamaLengkap" placeholder="Nama Lengkap" required />
            </div>

            <div class="form-group">
                <label for="Username">Username</label>
                <input class="form-control" type="text" name="Username" id="Username" placeholder="Username" required />
            </div>

            <div class="form-group">
                <label for="Email">Email</label>
                <input class="form-control" type="email" name="Email" id="Email" placeholder="Alamat Email" required />
            </div>

            <div class="form-group">
                <label for="Password">Password</label>
                <input class="form-control" type="password" name="Password" id="Password" placeholder="Password" required />
            </div>

            <div class="form-group">
                <label for="Alamat">Alamat</label>
                <textarea class="form-control" name="Alamat" id="Alamat" placeholder="Alamat Lengkap" rows="3" required></textarea>
            </div>

            <input type="submit" class="btn" name="register" value="Daftar" />
        </form>
        <p class="text-center">Sudah punya akun? <a href="login.php">Login di sini</a></p>
    </div>

</body>
</html>
