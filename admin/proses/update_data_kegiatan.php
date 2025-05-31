<?php
include '../../koneksi/koneksi.php';

if(isset($_POST['submit']) && isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $nama = $conn->real_escape_string($_POST['nama']);
    $tanggal = $conn->real_escape_string($_POST['tanggal']);
    $deskripsi = $conn->real_escape_string($_POST['deskripsi']);

    $updateQuery = "UPDATE kegiatan SET nama='$nama', tanggal='$tanggal', deskripsi='$deskripsi' WHERE id=$id";
    if($conn->query($updateQuery)) {
        header("Location: about.php");
        exit;
    } else {
        echo "Gagal memperbarui data: " . $conn->error;
    }
} else {
    header("Location: about.php");
    exit;
}
