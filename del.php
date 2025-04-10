<?php
include "koneksi.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Query untuk menghapus data
    $sql = "DELETE FROM penjualan WHERE id = ?";
    
    // Persiapkan statement
    $stmt = $koneksi->prepare($sql);
    $stmt->bind_param("i", $id);

    // Eksekusi statement
    if ($stmt->execute()) {
        echo "<script>alert('Data berhasil dihapus!'); window.location.href='penjualan.php';</script>";
    } else {
        echo "<script>alert('Gagal menghapus data: " . $stmt->error . "'); window.location.href='penjualan.php';</script>";
    }

    // Tutup statement
    $stmt->close();
} else {
    echo "<script>alert('ID tidak ditemukan!'); window.location.href='penjualan.php';</script>";
}

// Tutup koneksi
$koneksi->close();
?>