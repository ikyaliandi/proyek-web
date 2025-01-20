<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <style>
        /* Reset default styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: #ffffff; /* Full putih */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #333;
        }

        .login-container {
            background-color: #17a636; /* Warna hijau gelap agak menyala */
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
            border: 4px solid #333333; /* Border hitam gelap (tidak terlalu pekat) */
        }

        .login-form h2 {
            text-align: center;
            margin-bottom: 1.5rem;
            font-size: 1.8rem;
            color: #000000; /* Ubah warna teks Login menjadi hitam */
            font-weight: bold; /* Bold hanya pada teks Login */
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            color: #000000; /* Ubah warna teks label (Username dan Password) menjadi hitam */
            font-weight: normal; /* Hapus bold pada label Username dan Password */
        }

        .input-group {
            margin-bottom: 1rem;
        }

        .form-control {
            width: 100%;
            padding: 0.8rem;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1rem;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .form-control:focus {
            border-color: #138227; /* Warna hijau lebih gelap dan menyala */
            box-shadow: 0 0 8px rgba(19, 130, 39, 0.3); /* Efek shadow hijau lebih gelap */
            outline: none;
        }

        .btn-primary {
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

        .btn-primary:hover {
            background-color: #333333; /* Warna hitam lebih terang saat hover */
            transform: translateY(-2px);
        }

        .text-center {
            text-align: center;
        }

        a {
            color: #ffffff; /* Warna teks link putih */
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        .mt-3 {
            margin-top: 1rem;
        }

        .mt-3 span {
            color: #000000; /* Teks 'Belum punya akun?' hitam pekat */
        }

        .mt-3 a {
            color: #ffffff; /* Teks 'Daftar di sini' putih */
        }

        @media (max-width: 480px) {
            .login-container {
                padding: 1.5rem;
            }

            .login-form h2 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-form">
            <h2>Login</h2>
            <form action="login.php" method="POST">
                <label for="Username" class="form-label">Username</label>
                <div class="input-group">
                    <input type="text" name="Username" class="form-control" id="Username" placeholder="Masukkan username" required>
                </div>
                <div class="mb-3">
                    <label for="Password" class="form-label">Password</label>
                    <div class="input-group">
                        <input type="password" name="Password" class="form-control" id="Password" placeholder="Masukkan password" required>
                    </div>
                </div>
                <button type="submit" class="btn-primary">Login</button>
            </form>
            <p class="mt-3 text-center"><span>Belum punya akun? </span><a href="register.php">Daftar di sini</a></p>
        </div>
    </div>
</body>
</html>
