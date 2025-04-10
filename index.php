<?php
// Mengimpor file koneksi.php yang berisi kode untuk koneksi ke database.
session_start();
include("koneksi.php");

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Produk</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet"/>
    <style>
    body {
        font-family: 'Roboto', sans-serif;
        background-color: #f4cce9; /* Warna latar belakang (Paling terang) */
        color: #56021f; /* Warna teks body (Paling gelap) */
        margin: 0;
        padding: 0;
    }

    .header {
        background-color: #7d1c4d; /* Warna latar belakang header (Gelap kedua) */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        position: sticky;
        top: 0;
        z-index: 1000;
    }

    .main-title {
        font-size: 2.5rem;
        font-weight: bold;
        color: #56021f; /* Mengubah warna teks judul utama (Paling gelap) */
        text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.2);
        animation: fadeIn 1s ease-in;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }

    .divider {
        height: 2px;
        background-color: #56021f; /* Mengubah warna garis pemisah (Paling gelap) */
        margin: 1rem 0;
    }

    .nav-link {
        color: #56021f; /* Mengubah warna teks tautan navigasi (Paling gelap) */
        transition: color 0.3s, transform 0.3s;
    }

    .nav-link:hover {
        color: #d17d98; /* Mengubah warna saat hover (Menengah terang) */
        transform: scale(1.1);
    }

    .container {
        background: linear-gradient(to bottom, #F4CCEA, #D17D98);
        padding: 30px;
        border-radius: 15px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        animation: slideIn 0.5s ease-in-out;
    }

    @keyframes slideIn {
        from {
            transform: translateY(-20px);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    .img-fluid {
        border-radius: 15px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        max-width: 100%;
        height: auto;
    }

    .welcome-row {
        display: flex;
        align-items: center;
    }

    .welcome-text {
        flex: 1;
        margin-right: 20px;
    }

    .welcome-image {
        flex-shrink: 0;
        max-width: 450px;
        margin-left: auto;
    }
</style>
</head>
<body>
    <header class="header p-4">
        <div class="container d-flex justify-content-between align-items-center">
            <div class="text-lg font-weight-bold">MAKE UP-IN</div>
            <nav class="nav">
                <a class="nav-link" href="tampil_produk.php">PRODUK</a>
                <a class="nav-link" href="data_penjualan.php">PENJUALAN</a>
                <a class="nav-link" href="detail_penjualan.php">DETAIL PENJUALAN</a>
                <a class="nav-link" href="logout.php">LOGOUT</a>
            </nav>
        </div>
    </header>
    <main class="container my-5">
        <div class="row welcome-row">
            <div class="col-lg-6 welcome-text">
                <h1 class="main-title">Selamat Datang</h1>
                <div class="divider"></div>
                <p>Halo, selamat datang di website gudang mie^^</p>
            </div>
            <div class="col-lg-6 welcome-image">
                <img src="mekap.jpeg" alt="" class="img-fluid">
            </div>
        </div>
    </main>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>