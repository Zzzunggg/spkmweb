<?php 
include '../koneksi/koneksi.php'; 
include 'header.php'; ?>

<?php
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    $conn->query("DELETE FROM materi_dasar WHERE id = $id");
    echo "<script>alert('Materi dihapus!'); window.location='list_materi.php';</script>";
}
$materi = $conn->query("SELECT * FROM materi_dasar ORDER BY id DESC");
?>

<h2>Daftar Materi</h2>
<a href="upload_materi.php">Upload Baru</a>
<table border="1" cellpadding="10">
  <tr>
    <th>No</th>
    <th>Judul</th>
    <th>Gambar</th>
    <th>Aksi</th>
  </tr>
  <?php $no = 1; while ($m = $materi->fetch_assoc()): ?>
  <tr>
    <td><?= $no++ ?></td>
    <td><?= htmlspecialchars($m['judul']) ?></td>
    <td><img src="uploads/<?= $m['gambar'] ?>" width="100"></td>
    <td><a href="?hapus=<?= $m['id'] ?>" onclick="return confirm('Hapus materi ini?')">Hapus</a></td>
  </tr>
  <?php endwhile; ?>
</table>

<?php include 'footer.php'; ?>
