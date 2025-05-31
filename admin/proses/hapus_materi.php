<?php
include '../../koneksi/koneksi.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Ambil nama file untuk menghapus file fisik
    $query = mysqli_query($conn, "SELECT nama_file FROM materi WHERE id=$id");
    $data = mysqli_fetch_assoc($query);
    
    if ($data) {
        $file_path = "../../uploads/" . $data['nama_file'];
        if (file_exists($file_path)) {
            unlink($file_path); // Hapus file PDF
        }

        // Hapus data dari database
        $delete = mysqli_query($conn, "DELETE FROM materi WHERE id=$id");

        if ($delete) {
            echo "<script>alert('Materi berhasil dihapus.'); window.location.href='../admin_upload_materi.php';</script>";
        } else {
            echo "<script>alert('Gagal menghapus data.'); window.location.href='../admin_upload_materi.php';</script>";
        }
    } else {
        echo "<script>alert('Data tidak ditemukan.'); window.location.href='../admin_upload_materi.php';</script>";
    }
} else {
    echo "<script>alert('ID tidak ditemukan.'); window.location.href='../admin_upload_materi.php';</script>";
}
?>
