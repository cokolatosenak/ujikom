<?php
session_start();
if (isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #F8F3D9; /* Mengatur warna latar belakang */
        }

        .login-container {
            margin-top: 100px; /* Mengurangi margin atas agar lebih ke tengah */
        }

        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .login-header img {
            max-width: 100px; /* Ukuran logo */
            margin-bottom: 15px;
        }

        .card {
            background-color: rgba(255, 255, 255, 0.9); /* Latar belakang kartu dengan transparansi */
            border-radius: 15px; /* Sudut melengkung pada kartu */
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1); /* Bayangan lembut pada kartu */
        }

        h2 {
            color: #504B38; /* Warna teks judul */
            font-weight: bold; /* Tebal font judul */
        }

        .form-group label {
            color: #504B38; /* Warna label */
        }

        .btn-primary {
            background-color: #B9B28A; /* Warna tombol */
            border: none; /* Menghilangkan border */
        }

        .btn-primary:hover {
            background-color: #504B38; /* Warna tombol saat hover */
        }

        .alert {
            border-radius: 5px; /* Sudut melengkung pada alert */
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 login-container">
                <div class="login-header">
                    <?php if (file_exists('logo.png')): ?>
                        <img src="logo.png" alt="Logo">
                    <?php endif; ?>
                    <h2>Login</h2>
                </div>
                <div class="card">
                    <div class="card-body">
                        <?php
                        if (isset($_SESSION['error'])) {
                            echo '<div class="alert alert-danger">' . $_SESSION['error'] . '</div>';
                            unset($_SESSION['error']);
                        }
                        ?>
                        <form action="proses_login.php" method="POST">
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" class="form-control" id="username" name="username" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Login</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>