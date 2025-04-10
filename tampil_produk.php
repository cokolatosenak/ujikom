<?php
include "koneksi.php";

// Inisialisasi variabel pencarian
$search = isset($_GET['search']) ? $_GET['search'] : '';
$pesan = isset($_GET['pesan']) ? $_GET['pesan'] : ''; // Ambil pesan dari URL

// Query SQL dengan kondisi pencarian dan pengurutan
$sql = "SELECT * FROM produk";

if (!empty($search)) {
    $sql .= " WHERE NamaProduk LIKE '%$search%'";
}

// Tambahkan klausa ORDER BY untuk mengurutkan berdasarkan TanggalMasuk secara descending (terbaru di atas)
$sql .= " ORDER BY TanggalMasuk DESC";

$query = mysqli_query($koneksi, $sql);
$result = mysqli_fetch_all($query, MYSQLI_ASSOC);

// Periksa apakah hasil query kosong
$found = !empty($result);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Produk</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
    body {
        font-family: 'Roboto', sans-serif;
        background-color: #f4cce9;
        color: #56021f;
        padding-top: 100px;
    }

    .header {
        background: linear-gradient(to bottom, #D17D98, #7D1C4D);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        margin: auto;
        z-index: 1000;
        padding: 24px;
    }

    .header .nav-link {
        color: #56021f;
        transition: color 0.3s, transform 0.3s;
        padding: 0.5rem 1rem;
        border-radius: 0.5rem;
        font-size: 0.9rem;
    }

    .header .nav-link:hover {
        color: #d17d98;
        transform: scale(1.1);
    }

    .data-container {
        max-width: 1000px;
        margin: 40px auto 20px;
        background: linear-gradient(to bottom, #F8BBD0, #D17D98, #F8BBD0);
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

    h1 {
        text-align: center;
        margin-bottom: 30px;
        color: #56021f;
        font-weight: bold;
    }

    table {
        font-size: 1.1rem;
        border-collapse: collapse;
        width: 100%;
        margin-top: 20px;
    }

    th {
        background: linear-gradient(to bottom, #D17D98, #7D1C4D);
        color: white;
        padding: 15px;
        text-align: left;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
    }

    td {
        vertical-align: middle;
        padding: 15px;
        border-bottom: 1px solid #704264;
        transition: background-color 0.3s;
    }

    tr:hover td {
        background-color: rgba(255, 255, 255, 0.2);
    }

    .nav-link {
        color: #56021f;
        transition: color 0.3s, transform 0.3s;
        padding: 0.5rem 1rem;
        border-radius: 0.5rem;
        font-size: 0.9rem;
    }

    .nav-link:hover {
        color: #d17d98;
        transform: scale(1.1);
    }

    .btn-secondary {
            background-color: #538392; /* Warna tombol */
            border: none; /* Menghilangkan border */
        }

        .btn-secondary:hover {
            background-color: #1A2130; /* Warna tombol saat hover */

        }
        .btn-success, .btn-primary {
            background-color: #538392; /* Warna tombol */
            border: none; /* Menghilangkan border */
            transition: background-color 0.3s, transform 0.3s; /* Transisi warna dan transform */
        }

        .btn-success:hover, .btn-primary:hover {
            background-color: #1A2130; /* Warna tombol saat hover */
        }

        .input-group .form-control {
            border-radius: 20px; /* Sudut melengkung pada input */
            border: 1px solid #B9B28A; /* Border input */
            transition: border-color 0.3s; /* Transisi border */
        }

        .input-group .form-control:focus {
            border-color: #504B38; /* Warna border saat fokus */
            box-shadow: 0 0 5px rgba(80, 75, 56, 0.5); /* Bayangan saat fokus */
        }

        .input-group-append .btn {
            border-radius: 20px; /* Sudut melengkung pada tombol cari */
        }

    .popup {
        display: none;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background-color: #f9f9f9;
        border: 1px solid #ccc;
        padding: 20px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        z-index: 1001;
        border-radius: 10px;
    }

    .overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 1000;
    }

    .popup-content {
        margin-bottom: 15px;
        color: #56021f;
    }

    .popup-buttons {
        text-align: right;
    }

    .popup-buttons button {
        margin-left: 10px;
        padding: 8px 15px;
        border: none;
        border-radius: 0.5rem;
        cursor: pointer;
        transition: background-color 0.3s;
        font-size: 0.9rem;
    }

    .popup-buttons button.ok-btn {
        background: linear-gradient(to bottom, #D17D98, #7D1C4D);
        color: white;
    }

    .popup-buttons button.ok-btn:hover {
        background: linear-gradient(to bottom, #F4CCEA, #D17D98);
    }

    .popup-buttons button.cancel-btn {
        background: linear-gradient(to bottom, #F4CCEA, #D17D98);
        color: #56021f;
    }

    .popup-buttons button.cancel-btn:hover {
        background: linear-gradient(to bottom, #D17D98, #7D1C4D);
    }
</style>


</head>
<body>
    <?php if ($pesan == 'gagal_fk'): ?>
        <div class="overlay" id="overlay"></div>
        <div class="popup" id="popup">
            <div class="popup-content">
                <p>Data tidak bisa dihapus karena masih terdapat di Detail Penjualan.</p>
            </div>
            <div class="popup-buttons">
                <button onclick="closePopup()" class="ok-btn">OK</button>
            </div>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                document.getElementById('overlay').style.display = 'block';
                document.getElementById('popup').style.display = 'block';
            });

            function closePopup() {
                document.getElementById('overlay').style.display = 'none';
                document.getElementById('popup').style.display = 'none';
                window.location.href = 'tampil_produk.php'; // Redirect untuk menghilangkan parameter pesan
            }
        </script>
    <?php elseif ($pesan == 'sukses'): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            Data berhasil dihapus.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php elseif ($pesan == 'gagal'): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            Data gagal dihapus.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

<header class="header p-4">
    <div class="container d-flex justify-content-between align-items-center">
        <div class="text-lg font-weight-bold" style="color: #F3F7EC;">MAKE UP-IN</div>
        <nav class="nav">
            <a class="nav-link" href="tampil_produk.php">PRODUK</a>
            <a class="nav-link" href="data_penjualan.php">PENJUALAN</a>
            <a class="nav-link" href="detail_penjualan.php">DETAIL PENJUALAN</a>
        </nav>
    </div>
</header>

<div class="data-container">
    <h1>Daftar Produk</h1>
    <div class="row mb-3">
        <div class="col-md-6">
            <form method="GET" action="tampil_produk.php" class="form-inline">
                <div class="input-group">
                    <input type="text" name="search" id="search" class="form-control" placeholder="Cari Nama Produk..." value="<?= htmlspecialchars($search) ?>">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-primary">Cari</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-md-6 text-right">
            <a href="data_produk.php" class="btn btn-success">Tambah Data</a>
            <a href="index.php" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
    <table class="table table-bordered table-hover">
        <tr>
            <th>No</th>
            <th>Nama Produk</th>
            <th>Harga Produk</th>
            <th>Stok</th>
            <th>Tanggal Masuk</th>
            <th>AKSI</th>
        </tr>
        <tbody>
            <?php if ($found): ?>
                <?php $i = 1; foreach ($result as $produk): ?>
                    <tr>
                        <td><?= $i++; ?></td>
                        <td><?= htmlspecialchars($produk['NamaProduk']) ?></td>
                        <td><?= htmlspecialchars($produk['Harga']) ?></td>
                        <td><?= htmlspecialchars($produk['Stok']) ?></td>
                        <td><?= htmlspecialchars($produk['TanggalMasuk']) ?></td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="edit.php?id=<?= $produk["ProdukID"] ?>" class="btn btn-warning btn-sm mr-2">Edit</a>
                                <a href="delete.php?id=<?= $produk["ProdukID"] ?>" class="btn btn-danger btn-sm mr-2" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="text-center">Produk yang Anda cari tidak ada.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>