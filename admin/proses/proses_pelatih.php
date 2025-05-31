<?php
include '../../koneksi/koneksi.php';

if (isset($_POST['add'])) {
    $nama = $_POST['nama'];
    $umur = $_POST['umur'];
    $spesialisasi = $_POST['spesialisasi'];
    $pengalaman = $_POST['pengalaman'];

    $stmt = $conn->prepare("INSERT INTO pelatih (nama, umur, spesialisasi, pengalaman) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("siss", $nama, $umur, $spesialisasi, $pengalaman);
    if ($stmt->execute()) {
        header('Location: ../pelatih.php?success=added');
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }
}

elseif (isset($_POST['update'])) {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $umur = $_POST['umur'];
    $spesialisasi = $_POST['spesialisasi'];
    $pengalaman = $_POST['pengalaman'];

    $stmt = $conn->prepare("UPDATE pelatih SET nama=?, umur=?, spesialisasi=?, pengalaman=? WHERE id=?");
    $stmt->bind_param("sissi", $nama, $umur, $spesialisasi, $pengalaman, $id);
    if ($stmt->execute()) {
        header('Location: ../pelatih.php?success=updated');
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }
}

elseif (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM pelatih WHERE id=?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        header('Location: ../pelatih.php?success=deleted');
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }
}

else {
    header('Location: ../pelatih.php');
    exit;
}
