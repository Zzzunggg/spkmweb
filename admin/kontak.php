<?php
include 'header.php';
include '../koneksi/koneksi.php';

$result = $conn->query("SELECT * FROM pesan ORDER BY tanggal_kirim DESC");
?>
<br>
<h1 style="text-align:center; margin-bottom: 20px;">Daftar Pesan Masuk</h1>
<table border="1" cellpadding="8" cellspacing="0" style="border-collapse: collapse; width: 100%; max-width: 1200px; margin: 0 auto;">
  <thead style="background-color: #064e3b; color: white;">
    <tr>
      <th>ID</th>
      <th>Nama</th>
      <th>Email</th>
      <th>Telp</th>
      <th>Subjek</th>
      <th>Pesan</th>
      <th>Tanggal Kirim</th>
    </tr>
  </thead>
  <tbody>
    <?php if ($result->num_rows > 0): ?>
      <?php while ($row = $result->fetch_assoc()): ?>
      <tr>
        <td><?= $row['id'] ?></td>
        <td><?= htmlspecialchars($row['nama']) ?></td>
        <td><?= htmlspecialchars($row['email']) ?></td>
        <td><?= htmlspecialchars($row['telp']) ?></td>
        <td><?= htmlspecialchars($row['subjek']) ?></td>
        <td><?= nl2br(htmlspecialchars($row['pesan'])) ?></td>
        <td><?= $row['tanggal_kirim'] ?></td>
      </tr>
      <?php endwhile; ?>
    <?php else: ?>
      <tr><td colspan="7" style="text-align:center;">Belum ada pesan masuk.</td></tr>
    <?php endif; ?>
  </tbody>
</table>
