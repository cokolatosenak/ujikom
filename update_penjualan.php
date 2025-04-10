<?php
include "koneksi.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ProdukID = $_POST['ProdukID'];
    $Harga = $_POST['Harga'];
    $Stok = $_POST['Stok'];
    $TanggalPenjualan = $_POST['TanggalPenjualan'];
    $TokoID = $_POST['TokoID'];
    $Subtotal = $_POST['Subtotal'];

    // Validasi awal
    if (empty($TanggalPenjualan) || empty($TokoID) || $Stok <= 0) {
        echo "<script>alert('Data tidak lengkap atau stok tidak valid.'); window.location.href='data_penjualan.php';</script>";
        exit();
    }

    // Ambil info produk (NamaProduk & Stok saat ini)
    $sql_get_produk = "SELECT NamaProduk, Stok AS StokTersedia FROM produk WHERE ProdukID = $ProdukID";
    $result_get_produk = $koneksi->query($sql_get_produk);

    if ($result_get_produk && $result_get_produk->num_rows > 0) {
        $row_produk = $result_get_produk->fetch_assoc();
        $NamaProduk = $row_produk['NamaProduk'];
        $StokTersedia = $row_produk['StokTersedia'];
    } else {
        echo "<script>alert('Produk tidak ditemukan.'); window.location.href='data_penjualan.php';</script>";
        exit();
    }

    // Cek apakah stok cukup
    if ($Stok > $StokTersedia) {
        echo "<script>alert('Stok tidak mencukupi. Stok tersedia: $StokTersedia'); window.location.href='data_penjualan.php';</script>";
        exit();
    }

    // Ambil Nama Toko
    $sql_get_toko = "SELECT NamaToko FROM toko WHERE TokoID = $TokoID";
    $result_get_toko = $koneksi->query($sql_get_toko);
    $NamaToko = ($result_get_toko && $result_get_toko->num_rows > 0) 
                ? $result_get_toko->fetch_assoc()['NamaToko'] 
                : '';

    // Masukkan ke tabel penjualan
    $sql_insert_penjualan = "INSERT INTO penjualan (ProdukID, NamaProduk, Harga, Stok, Subtotal, TanggalPenjualan, TokoID, NamaToko)
                             VALUES ('$ProdukID', '$NamaProduk', '$Harga', '$Stok', '$Subtotal', '$TanggalPenjualan', '$TokoID', '$NamaToko')";

    // Jalankan transaksi: simpan penjualan dan update stok
    $koneksi->begin_transaction();

    try {
        $koneksi->query($sql_insert_penjualan);

        $sql_update_stok = "UPDATE produk SET Stok = Stok - $Stok WHERE ProdukID = $ProdukID";
        $koneksi->query($sql_update_stok);

        $koneksi->commit();

        echo "<script>alert('Data penjualan berhasil ditambahkan.'); window.location.href='detail_penjualan.php';</script>";
    } catch (Exception $e) {
        $koneksi->rollback();
        echo "<script>alert('Terjadi kesalahan saat menyimpan data.'); window.location.href='data_penjualan.php';</script>";
    }

    $koneksi->close();
} else {
    header("Location: data_penjualan.php");
    exit();
}
?>
