<?php
include '../../koneksi/koneksi.php';

if(isset($_POST['submit'])) {
    $nama = $conn->real_escape_string($_POST['nama']);
    $tanggal = $conn->real_escape_string($_POST['tanggal']);
    $deskripsi = $conn->real_escape_string($_POST['deskripsi']);

    $query = "INSERT INTO kegiatan (nama, tanggal, deskripsi) VALUES ('$nama', '$tanggal', '$deskripsi')";
    if($conn->query($query)) {
        header("Location: about.php");
        exit;
    } else {
        echo "Gagal menambahkan data: " . $conn->error;
    }
} else {
    header("Location: about.php");
    exit;
}
