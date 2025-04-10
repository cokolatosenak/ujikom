<?php
include("koneksi.php");

    $ProdukID = $_POST["ProdukID"];
    $NamaProduk = $_POST["NamaProduk"];
    $Harga = $_POST["Harga"];
    $Stok = $_POST["Stok"];
    $TanggalMasuk = $_POST["TanggalMasuk"];


    try {
        $koneksi->query
        ("UPDATE produk SET ProdukID = '$ProdukID', Harga = '$Harga', Stok = '$Stok', TanggalMasuk = '$TanggalMasuk'WHERE ProdukID = '$ProdukID'");
        echo "<script>window.location.href='tampil_produk.php';</script>";
    
    }catch (exception $e) {
        echo "Tambah data gagal :" . $e->getMessage();
    }
    
    
    ?>

