<?php
include("koneksi.php");

if (isset($_GET["id"]) && is_numeric($_GET["id"])) {
    $id_barang = $_GET["id"];

    try {
        $query = mysqli_prepare($koneksi, "DELETE FROM produk WHERE ProdukID = ?");
        mysqli_stmt_bind_param($query, "i", $id_barang);
        mysqli_stmt_execute($query);

        if (mysqli_stmt_affected_rows($query) > 0) {
            header("location: tampil_produk.php?pesan=sukses"); // Tambahkan pesan sukses
        } else {
            header("location: tampil_produk.php?pesan=gagal"); // Tambahkan pesan gagal
        }
    } catch (mysqli_sql_exception $e) {
        if ($e->getCode() == 1451 || $e->getCode() == 1452) { // Kode error untuk foreign key constraint
            header("location: tampil_produk.php?pesan=gagal_fk");
        } else {
            echo "Hapus data gagal: " . $e->getMessage(); // Tampilkan error lain jika bukan foreign key
        }
    }
} else {
    echo "ID barang tidak valid.";
}
?>