<?php
include("koneksi.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $NamaProduk = $_POST["NamaProduk"];
    $Harga = $_POST["Harga"];
    $Stok = $_POST["Stok"];
    $TanggalMasuk = $_POST["TanggalMasuk"];

    try {
        $koneksi->query("INSERT INTO produk (NamaProduk, Harga, Stok, TanggalMasuk) VALUES ('$NamaProduk', '$Harga', '$Stok', '$TanggalMasuk')");
        echo "<script>window.location.href='tampil_produk.php';</script>";
    } catch (Exception $e) {
        echo "Tambah data gagal: " . $e->getMessage();
    }
}
?>