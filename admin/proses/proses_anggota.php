<?php
// Pastikan file koneksi disertakan
include '../../koneksi/koneksi.php';

// --- PROSES TAMBAH DATA ---
if (isset($_POST['add'])) {
    // Ambil data dari form
    $nama = $_POST['nama'];
    $no_induk = $_POST['no_induk']; // Ganti umur dengan no_induk
    $alamat = $_POST['alamat'];
    $email = $_POST['email'];
    $tempat_lahir = $_POST['tempat_lahir']; // Tambah tempat_lahir
    $tanggal_lahir = $_POST['tanggal_lahir']; // Tambah tanggal_lahir

    // Query INSERT disesuaikan dengan struktur tabel baru
    $query = "INSERT INTO anggota (nama, no_induk, alamat, email, tempat_lahir, tanggal_lahir) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);

    // Sesuaikan tipe data dan variabel di bind_param
    // s = string, s = string, s = string, s = string, s = string, s = string (untuk DATE)
    $stmt->bind_param("ssssss", $nama, $no_induk, $alamat, $email, $tempat_lahir, $tanggal_lahir);

    // Eksekusi query
    if ($stmt->execute()) {
        header('Location: ../anggota.php?success=added');
        exit;
    } else {
        echo "Error saat menambah data: " . $stmt->error;
    }
} 
// --- PROSES UPDATE DATA ---
elseif (isset($_POST['update'])) {
    // Ambil data dari form
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $no_induk = $_POST['no_induk']; // Ganti umur dengan no_induk
    $alamat = $_POST['alamat'];
    $email = $_POST['email'];
    $tempat_lahir = $_POST['tempat_lahir']; // Tambah tempat_lahir
    $tanggal_lahir = $_POST['tanggal_lahir']; // Tambah tanggal_lahir

    // Query UPDATE disesuaikan dengan struktur tabel baru
    $query = "UPDATE anggota SET nama=?, no_induk=?, alamat=?, email=?, tempat_lahir=?, tanggal_lahir=? WHERE id=?";
    $stmt = $conn->prepare($query);

    // Sesuaikan tipe data dan variabel di bind_param
    // s = string, s = string, s = string, s = string, s = string, s = string, i = integer
    $stmt->bind_param("ssssssi", $nama, $no_induk, $alamat, $email, $tempat_lahir, $tanggal_lahir, $id);

    // Eksekusi query
    if ($stmt->execute()) {
        header('Location: ../anggota.php?success=updated');
        exit;
    } else {
        echo "Error saat memperbarui data: " . $stmt->error;
    }
}
// --- PROSES HAPUS DATA (Tidak ada perubahan) ---
elseif (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM anggota WHERE id=?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header('Location: ../anggota.php?success=deleted');
        exit;
    } else {
        echo "Error saat menghapus data: " . $stmt->error;
    }
} 
// Jika tidak ada aksi, kembali ke halaman utama
else {
    header('Location: ../anggota.php');
    exit;
}
?>