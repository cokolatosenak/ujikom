<?php
include "koneksi.php";

// Inisialisasi variabel pencarian
$search = isset($_GET['search']) ? $_GET['search'] : '';
$PenjualanID = isset($_GET['PenjualanID']) ? $_GET['PenjualanID'] : null;

// Query SQL dengan kondisi pencarian dan pengurutan tanggal
$sql = "SELECT penjualan.*, produk.NamaProduk FROM penjualan INNER JOIN produk ON penjualan.ProdukID = produk.ProdukID";

if (!empty($search)) {
    $sql .= " WHERE produk.NamaProduk LIKE '%$search%'"; // Perbaikan di sini
}

if ($PenjualanID) {
    $sql .= " WHERE PenjualanID = $PenjualanID";
}

$sql .= " ORDER BY TanggalPenjualan DESC"; // DESC untuk terbaru ke terlama

$query = mysqli_query($koneksi, $sql);
$result = mysqli_fetch_all($query, MYSQLI_ASSOC);

// Periksa apakah hasil query kosong
$found = !empty($result);

// Hitung total jumlah dan subtotal
$totalJumlah = 0;
$totalSubtotal = 0;
foreach ($result as $row) {
    $totalJumlah += $row['Stok'];
    $totalSubtotal += $row['Subtotal'];
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Penjualan</title>
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

    .container {
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

    h2 {
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

    .btn-secondary {
        background: linear-gradient(to bottom, #D17D98, #7D1C4D);
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 0.5rem;
        border: none;
        transition: background-color 0.3s, transform 0.3s;
        font-size: 1rem;
        margin-top: 1rem;
    }

    .btn-secondary:hover {
        background: linear-gradient(to bottom, #F4CCEA, #D17D98);
        transform: scale(1.05);
    }

    .input-group .form-control {
        border-radius: 0.5rem;
        border-color: #D17D98;
        transition: border-color 0.3s;
    }

    .input-group .form-control:focus {
        border-color: #7D1C4D;
        box-shadow: 0 0 0 3px rgba(219, 125, 152, 0.5);
    }

    .input-group-append .btn {
        border-radius: 0.5rem;
        background: linear-gradient(to bottom, #D17D98, #7D1C4D);
        color: white;
        border: none;
        transition: background-color 0.3s;
    }

    .input-group-append .btn:hover {
        background: linear-gradient(to bottom, #F4CCEA, #D17D98);
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
    <h2>Detail Penjualan</h2>
    <div class="row mb-3">
        <div class="col-md-6">
            <form method="GET" action="detail_penjualan.php" class="form-inline">
                <div class="input-group">
                    <input type="text" name="search" id="search" class="form-control" placeholder="Cari Nama Produk..." value="<?= htmlspecialchars($search) ?>">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-primary">Cari</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama Produk</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Subtotal</th>
                <th>Tanggal Penjualan</th>
                <th>Nama Toko</th>
            </tr>
            </thead>
            <tbody>
                <?php if ($found): ?>
                    <?php foreach ($result as $row): ?>
                        <tr>
                            <td><?= $row['NamaProduk'] ?></td>
                            <td><?= $row['Harga'] ?></td>
                            <td><?= $row['Stok'] ?></td>
                            <td><?= $row['Subtotal'] ?></td>
                            <td><?= $row['TanggalPenjualan'] ?></td>
                            <td><?= $row['NamaToko'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center">Barang yang Anda cari tidak ada.</td>
                    </tr>
                <?php endif; ?>
            </tbody><tfoot>
                <tr>
                    <td colspan="3" class="text-right"><strong>Total:</strong></td>
                    <td><?= $totalSubtotal ?></td>
                    <td></td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
        <a href="index.php" class="btn btn-secondary">Kembali</a>
    </div>
</body>
</html>