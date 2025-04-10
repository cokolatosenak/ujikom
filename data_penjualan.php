<?php
include "koneksi.php";

// Ambil ID barang dari parameter GET (tetap ada karena mungkin digunakan untuk hal lain)
$ProdukID = isset($_GET['PenjualanID']) ? $_GET['PenjualanID'] : null;

// Jika ID barang ada, ambil data barang dari database (tetap ada)
if ($ProdukID) {
    $sql_produk = "SELECT * FROM produk WHERE ProdukID = $ProdukID";
    $result_produk = $koneksi->query($sql_produk);
    $barang = $result_produk->fetch_assoc();
} else {
    $barang = null;
}

// Ambil semua data barang untuk dropdown Produk (tetap ada)
$sql_semua_barang = "SELECT * FROM produk";
$result_semua_barang = $koneksi->query($sql_semua_barang);

// Ambil semua data toko untuk dropdown Nama Toko
$sql_semua_toko = "SELECT TokoID, NamaToko FROM toko";
$result_semua_toko = $koneksi->query($sql_semua_toko);


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
        font-family: 'Roboto', sans-serif;
        background-color: #f4cce9;
        color: white;
        padding-top: 100px;
    }

    .container {
        max-width: 800px;
        margin: 40px auto;
        padding: 20px;
        border-radius: 15px;
        background: linear-gradient(to bottom, #F8BBD0, #D17D98, #F8BBD0);
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
        margin-bottom: 20px;
        color: #56021f;
    }

    .header {
        background: linear-gradient(to bottom, #D17D98, #7D1C4D);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        padding: 0.5rem 0;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        z-index: 1000;
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

    tr:hover {
        background-color: rgba(255, 255, 255, 0.2);
    }

    .btn-success, .btn-primary {
        background: linear-gradient(to bottom, #D17D98, #7D1C4D);
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 0.5rem;
        border: none;
        transition: background-color 0.3s, transform 0.3s;
        font-size: 1rem;
        margin-top: 1rem;
    }

    .btn-success:hover, .btn-primary:hover {
        background: linear-gradient(to bottom, #F4CCEA, #D17D98);
        transform: scale(1.05);
    }
</style>

</head>
<body>
<header class="header p-4">
    <div class="d-flex justify-content-between align-items-center">
    <div class="text-lg font-weight-bold" style="color: #F3F7EC;">MAKE UP-IN</div>
        <nav class="nav">
            <a class="nav-link" href="tampil_produk.php">PRODUK</a>
            <a class="nav-link" href="data_penjualan.php">PENJUALAN</a>
            <a class="nav-link" href="detail_penjualan.php">DETAIL PENJUALAN</a>
        </nav>
    </div>
</header>
<div class="container mt-5">
    <h2>Tambah Data Penjualan</h2>
    <form action="update_penjualan.php" method="POST">
        <div class="form-group">
            <label for="ProdukID">Nama Produk:</label>
            <select name="ProdukID" id="ProdukID" class="form-control" required onchange="updateHarga()">
                <option value="">Pilih Produk</option>
                <?php while ($semua_barang = $result_semua_barang->fetch_assoc()): ?>
                    <option value="<?= $semua_barang['ProdukID'] ?>" <?= ($barang && $barang['ProdukID'] == $semua_barang['ProdukID']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($semua_barang['NamaProduk']) ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="Harga">Harga Produk:</label>
            <input type="number" id="Harga" name="Harga" class="form-control" value="<?= $barang ? $barang['Harga'] : '' ?>" required readonly>
        </div>

        <div class="form-group">
            <label for="Stok">Stok:</label>
            <input type="number" id="Stok" name="Stok" class="form-control" oninput="validasiStok()">
        </div>

        <div class="form-group">
            <label for="Subtotal">Subtotal:</label>
            <input type="text" id="Subtotal" name="Subtotal" class="form-control" readonly>
        </div>

        <div class="form-group">
            <label for="TanggalPenjualan">Tanggal Penjualan:</label>
            <input type="date" id="TanggalPenjualan" name="TanggalPenjualan" class="form-control" value="<?= $penjualan ? $penjualan['TanggalPenjualan'] : '' ?>" required>
        </div>

        <div class="form-group">
            <label for="TokoID">Nama Toko:</label>
            <select name="TokoID" id="TokoID" class="form-control" required>
                <option value="">Pilih Toko</option>
                <?php while ($semua_toko = $result_semua_toko->fetch_assoc()): ?>
                    <option value="<?= $semua_toko['TokoID'] ?>">
                        <?= htmlspecialchars($semua_toko['NamaToko']) ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Tambah Data</button>
        <a href="tampil_produk.php" class="btn btn-secondary">Kembali</a>
    </form>
</div>

<script>
    function updateHarga() {
        var produkID = document.getElementById("ProdukID").value;
        <?php
        $produk_harga = array();
        $result_harga = $koneksi->query("SELECT ProdukID, Harga FROM produk");
        while ($row = $result_harga->fetch_assoc()) {
            $produk_harga[$row['ProdukID']] = $row['Harga'];
        }
        echo "var hargaProduk = " . json_encode($produk_harga) . ";";
        ?>
        document.getElementById("Harga").value = hargaProduk[produkID] || '';
        validasiStok();
    }

    function validasiStok() {
        var produkID = document.getElementById("ProdukID").value;
        var stokInput = document.getElementById("Stok");
        var stokPenjualan = parseInt(stokInput.value) || 0;
        <?php
        $produk_stok = array();
        $result_stok = $koneksi->query("SELECT ProdukID, Stok FROM produk");
        while ($row = $result_stok->fetch_assoc()) {
            $produk_stok[$row['ProdukID']] = $row['Stok'];
        }
        echo "var stokProduk = " . json_encode($produk_stok) . ";";
        ?>
        var stokTersedia = parseInt(stokProduk[produkID]) || 0;

        if (stokPenjualan > stokTersedia) {
            alert("Stok tidak mencukupi. Stok tersedia: " + stokTersedia);
            stokInput.value = stokTersedia;
        }
        hitungSubtotal();
    }

    function hitungSubtotal() {
        var harga = document.getElementById("Harga").value;
        var stok = document.getElementById("Stok").value;
        var subtotal = harga * stok;
        document.getElementById("Subtotal").value = subtotal || '';
    }
</script>
</body>
</html>