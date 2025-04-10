<?php
// Mengimpor file koneksi.php yang berisi kode untuk koneksi ke database.
include "koneksi.php";

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Barang</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #80B9AD; /* Warna latar belakang utama */
        }
        .container {
            max-width: 800px;
            margin: 40px auto;
            padding: 20px;
            border-radius: 8px;
            background-color: #FDFFE2; /* Warna latar belakang kontainer */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #504B38; /* Warna teks judul */
        }
        .header {
            background-color: #538392; /* Warna navbar */
            position: fixed; /* Navbar tetap di atas */
            top: 0; /* Menempelkan navbar ke bagian atas viewport */
            left: 0; /* Memastikan navbar membentang dari kiri */
            width: 100%; /* Memastikan navbar membentang selebar viewport */
            z-index: 1000; /* Memastikan navbar berada di atas konten lain */
            padding: 15px; /* Padding untuk navbar */
        }
        .nav-link {
            color: #EBE5C2; /* Warna teks tautan navigasi */
        }
        .nav-link:hover {
            color: #212121; /* Warna teks tautan saat hover */
        }
        th {
            background-color: #B9B28A; /* Warna kolom judul */
            color: #D9DFC6;
            padding: 15px;
            text-align: left;
        }
        td {
            vertical-align: middle;
            padding: 15px;
            border-bottom: 1px solid #504B38; /* Warna border */
        }
        tr:hover {
            background-color: #FFFDF0; /* Warna saat hover pada baris */
        }
        
        .btn-success, .btn-primary {
            background-color: #538392; /* Warna tombol */
            border: none; /* Menghilangkan border */
            transition: background-color 0.3s, transform 0.3s; /* Transisi warna dan transform */
        }

        .btn-success:hover, .btn-primary:hover {
            background-color: #1A2130; /* Warna tombol saat hover */
        }
    </style>
</head>
<body>
<header class="header">
    <div class="d-flex justify-content-between align-items-center">
        <div class="text-lg font-weight-bold" style="color: #FDFFE2;">MAKE UP-IN</div>
        <nav class="nav">
            <a class="nav-link" href="tampil_produk.php">PRODUK</a>
            <a class="nav-link" href="data_penjualan.php">PENJUALAN</a>
            <a class="nav-link" href="detail_penjualan.php">DETAIL PENJUALAN</a>
        </nav>
    </div>
</header>
    <div class="container mt-5">
        <h2>Tambah Produk</h2>
        <?php if (isset($response)): ?>
            <div class="alert alert-info"><?= htmlspecialchars($response); ?></div>
        <?php endif; ?>

        <form action="insert.php" method="POST">
            <input type="hidden" name="action" value="create">
            <div class="form-group">
                <label for="ProdukID"></label>
                <input type="text" id="ProdukID" name="ProdukID" class="form-control" hidden>
            </div>

            <div class="form-group">
                <label for="NamaProduk">Nama Produk:</label>
                <input type="text" id="NamaProduk" name="NamaProduk" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="Harga">Harga Produk:</label>
                <input type="decimal" id="Harga" name="Harga" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="Stok">Stok:</label>
                <input type="number" id="Stok" name="Stok" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="TanggalMasuk">TanggalMasuk:</label>
                <input type="date" id="TanggalMasuk" name="TanggalMasuk" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary">Masukan Produk</button>
            <a href="tampil_produk.php" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>