<?php
include '../koneksi/koneksi.php';

// Proses tambah, edit, hapus harus di atas agar bisa header redirect tanpa error

$pesan = '';
$mode = 'tambah';
$id_edit = 0;
$nama = '';
$tanggal = '';
$deskripsi = '';

// Edit data
if(isset($_GET['edit'])) {
    $id_edit = intval($_GET['edit']);
    $result = $conn->query("SELECT * FROM kegiatan WHERE id = $id_edit");
    if($result && $result->num_rows == 1) {
        $data = $result->fetch_assoc();
        $nama = $data['nama'];
        $tanggal = $data['tanggal'];
        $deskripsi = $data['deskripsi'];
        $mode = 'edit';
    } else {
        $pesan = "Data kegiatan tidak ditemukan.";
    }
}

// Tambah data
if(isset($_POST['submit'])) {
    $nama = $conn->real_escape_string($_POST['nama']);
    $tanggal = $conn->real_escape_string($_POST['tanggal']);
    $deskripsi = $conn->real_escape_string($_POST['deskripsi']);

    $query = "INSERT INTO kegiatan (nama, tanggal, deskripsi) VALUES ('$nama', '$tanggal', '$deskripsi')";
    if($conn->query($query)) {
        header("Location: upload_data_kegiatan.php");
        exit;
    } else {
        $pesan = "Gagal menambahkan data: " . $conn->error;
    }
}

// Update data
if(isset($_POST['update'])) {
    $id = intval($_POST['id']);
    $nama = $conn->real_escape_string($_POST['nama']);
    $tanggal = $conn->real_escape_string($_POST['tanggal']);
    $deskripsi = $conn->real_escape_string($_POST['deskripsi']);

    $update = $conn->query("UPDATE kegiatan SET nama='$nama', tanggal='$tanggal', deskripsi='$deskripsi' WHERE id=$id");
    if($update) {
        header("Location: upload_data_kegiatan.php");
        exit;
    } else {
        $pesan = "Gagal update data: " . $conn->error;
    }
}

// Hapus data
if(isset($_GET['hapus'])) {
    $id = intval($_GET['hapus']);
    $hapusQuery = "DELETE FROM kegiatan WHERE id=$id";
    if($conn->query($hapusQuery)) {
        header("Location: upload_data_kegiatan.php");
        exit;
    } else {
        $pesan = "Gagal menghapus data.";
    }
}

include 'header.php'; // Setelah proses PHP, baru include header.php yang mungkin output HTML

$result = $conn->query("SELECT * FROM kegiatan ORDER BY tanggal ASC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Manajemen Kegiatan</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
h1, h2 {
  text-align: center;
}
.container {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  gap: 2rem;
  padding: 2rem;
}
.form-box, .table-box {
  background-color: #ffffff;
  border-radius: 10px;
  box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
  padding: 2rem;
  width: 100%;
  max-width: 600px;
  box-sizing: border-box;
}
label {
  display: block;
  margin-bottom: 0.5rem;
  font-weight: 600;
}
input[type="text"],
input[type="date"],
textarea {
  width: 100%;
  padding: 0.6rem;
  margin-bottom: 1rem;
  border: 1px solid #d1d5db;
  border-radius: 6px;
  background-color: #f9fafb;
  font-size: 1rem;
}
textarea {
  resize: vertical;
}
button {
  background-color: #10b981;
  color: white;
  border: none;
  padding: 0.75rem 1.5rem;
  font-size: 1rem;
  border-radius: 6px;
  cursor: pointer;
  transition: background-color 0.3s ease;
  width: 100%;
}
button:hover {
  background-color: #059669;
}
table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 1rem;
}
table th, table td {
  border: 1px solid #e5e7eb;
  padding: 0.75rem;
  text-align: center;
}
table th {
  background-color: #f9fafb;
  font-weight: bold;
}
a:hover {
  text-decoration: underline;
}
.pesan {
  margin-bottom: 1rem;
  padding: 0.75rem 1rem;
  border-radius: 6px;
  background-color: #d1fae5;
  color: #065f46;
  text-align: center;
}
/* Tambahan untuk ikon aksi */
.icon-edit {
  color: #3b82f6; /* biru */
  margin-right: 0.3rem;
}
.icon-delete {
  color: #ef4444; /* merah */
  margin-left: 0.3rem;
}
.icon-edit:hover {
  color: #1d4ed8;
}
.icon-delete:hover {
  color: #b91c1c;
}
</style>
</head>
<body>

<div class="container">
  <div class="form-box">
    <h1><?= ($mode == 'edit') ? 'Edit Kegiatan' : 'Tambah Kegiatan' ?></h1>

    <?php if(!empty($pesan)): ?>
      <div class="pesan"><?= htmlspecialchars($pesan) ?></div>
    <?php endif; ?>

    <form action="" method="post" autocomplete="off">
      <?php if($mode == 'edit'): ?>
        <input type="hidden" name="id" value="<?= $id_edit ?>">
      <?php endif; ?>

      <label for="nama">Nama Kegiatan</label>
      <input type="text" name="nama" id="nama" value="<?= htmlspecialchars($nama) ?>" required>

      <label for="tanggal">Tanggal</label>
      <input type="date" name="tanggal" id="tanggal" value="<?= htmlspecialchars($tanggal) ?>" required>

      <label for="deskripsi">Deskripsi</label>
      <textarea name="deskripsi" id="deskripsi" rows="4" required><?= htmlspecialchars($deskripsi) ?></textarea>

      <button type="submit" name="<?= ($mode == 'edit') ? 'update' : 'submit' ?>">
        <?= ($mode == 'edit') ? 'Update Kegiatan' : 'Tambah Kegiatan' ?>
      </button>

      <?php if($mode == 'edit'): ?>
        <p style="margin-top: 0.75rem;"><a href="upload_data_kegiatan.php">Batal Edit</a></p>
      <?php endif; ?>
    </form>
  </div>

  <div class="table-box">
    <h2>Daftar Kegiatan</h2>

    <?php if($result && $result->num_rows > 0): ?>
    <table>
      <thead>
        <tr>
          <th>Nama</th>
          <th>Tanggal</th>
          <th>Deskripsi</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php while($row = $result->fetch_assoc()): ?>
        <tr>
          <td><?= htmlspecialchars($row['nama']) ?></td>
          <td><?= htmlspecialchars($row['tanggal']) ?></td>
          <td><?= htmlspecialchars($row['deskripsi']) ?></td>
          <td>
            <a href="?edit=<?= $row['id'] ?>" title="Edit"><i class="fas fa-edit icon-edit"></i></a>
            <a href="?hapus=<?= $row['id'] ?>" onclick="return confirm('Yakin ingin menghapus kegiatan ini?')" title="Hapus"><i class="fas fa-trash-alt icon-delete"></i></a>
          </td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
    <?php else: ?>
      <p style="text-align: center; color: #6b7280;">Belum ada data kegiatan.</p>
    <?php endif; ?>
  </div>
</div>

</body>
</html>
