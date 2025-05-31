<?php
include '../../koneksi/koneksi.php';

if (isset($_POST['add'])) {
    $nama = $_POST['nama'];
    $umur = $_POST['umur'];
    $alamat = $_POST['alamat'];
    $email = $_POST['email'];

    $stmt = $conn->prepare("INSERT INTO anggota (nama, umur, alamat, email) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("siss", $nama, $umur, $alamat, $email);

    if ($stmt->execute()) {
        header('Location: ../anggota.php?success=added');
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }
} 
elseif (isset($_POST['update'])) {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $umur = $_POST['umur'];
    $alamat = $_POST['alamat'];
    $email = $_POST['email'];

    $stmt = $conn->prepare("UPDATE anggota SET nama=?, umur=?, alamat=?, email=? WHERE id=?");
    $stmt->bind_param("sissi", $nama, $umur, $alamat, $email, $id);

    if ($stmt->execute()) {
        header('Location: ../anggota.php?success=updated');
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }
}
elseif (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM anggota WHERE id=?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header('Location: ../anggota.php?success=deleted');
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }
} else {
    header('Location: ../anggota.php');
    exit;
}
