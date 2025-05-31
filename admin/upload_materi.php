<?php
include '../koneksi/koneksi.php';
include 'header.php';

// Fungsi upload gambar dengan validasi tipe file
function uploadGambar($file) {
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    if ($file['error'] === 4) return null; // Tidak ada file diupload
    if (!in_array($file['type'], $allowedTypes)) {
        echo "<script>alert('File harus berupa JPG, PNG, atau GIF');</script>";
        return null;
    }
    $filename = uniqid() . '_' . basename($file['name']);
    $target = "uploads/" . $filename;
    if (move_uploaded_file($file['tmp_name'], $target)) {
        return $filename;
    } else {
        echo "<script>alert('Gagal upload gambar');</script>";
        return null;
    }
}

$mode = 'tambah';
$id = '';
$judul = '';
$singkat = '';
$lengkap = '';
$kategori = 'dasar';
$gambar = null;

// Amankan kategori hanya tiga pilihan ini
function sanitizeKategori($kat) {
    $list = ['dasar', 'menengah', 'mahir'];
    return in_array($kat, $list) ? $kat : 'dasar';
}

// Handle upload materi baru
if (isset($_POST['upload'])) {
    $judul = $_POST['judul'];
    $singkat = $_POST['deskripsi_singkat'];
    $lengkap = $_POST['deskripsi_lengkap'];
    $kategori = sanitizeKategori($_POST['kategori']);

    $gambar = uploadGambar($_FILES['gambar']);
    if ($gambar) {
        $stmt = $conn->prepare("INSERT INTO materi_$kategori (judul, deskripsi_singkat, deskripsi_lengkap, gambar) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $judul, $singkat, $lengkap, $gambar);
        if ($stmt->execute()) {
            echo "<script>alert('Materi berhasil ditambahkan'); window.location='upload_materi.php';</script>";
            exit;
        } else {
            echo "<script>alert('Gagal menambah materi');</script>";
        }
    }
}

// Handle form edit: load data materi yang diedit
if (isset($_GET['edit']) && isset($_GET['kategori'])) {
    $mode = 'edit';
    $id = intval($_GET['edit']);
    $kategori = sanitizeKategori($_GET['kategori']);

    $result = $conn->query("SELECT * FROM materi_$kategori WHERE id = $id");
    if ($result && $result->num_rows > 0) {
        $data = $result->fetch_assoc();
        $judul = $data['judul'];
        $singkat = $data['deskripsi_singkat'];
        $lengkap = $data['deskripsi_lengkap'];
        $gambar = $data['gambar'];
    } else {
        echo "<script>alert('Data tidak ditemukan'); window.location='upload_materi.php';</script>";
        exit;
    }
}

// Handle update materi
if (isset($_POST['update'])) {
    $id = intval($_GET['edit']);
    $kategori = sanitizeKategori($_POST['kategori']);
    $judul = $_POST['judul'];
    $singkat = $_POST['deskripsi_singkat'];
    $lengkap = $_POST['deskripsi_lengkap'];

    $gambarLama = $_POST['gambar_lama'];
    $gambarBaru = uploadGambar($_FILES['gambar']);

    if ($gambarBaru) {
        if ($gambarLama && file_exists("uploads/$gambarLama")) {
            unlink("uploads/$gambarLama");
        }
        $gambar = $gambarBaru;
    } else {
        $gambar = $gambarLama;
    }

    $stmt = $conn->prepare("UPDATE materi_$kategori SET judul=?, deskripsi_singkat=?, deskripsi_lengkap=?, gambar=? WHERE id=?");
    $stmt->bind_param("ssssi", $judul, $singkat, $lengkap, $gambar, $id);
    if ($stmt->execute()) {
        echo "<script>alert('Materi berhasil diperbarui'); window.location='upload_materi.php';</script>";
        exit;
    } else {
        echo "<script>alert('Gagal memperbarui materi');</script>";
    }
}

// Handle hapus materi
if (isset($_GET['hapus']) && isset($_GET['kategori'])) {
    $id = intval($_GET['hapus']);
    $kategori = sanitizeKategori($_GET['kategori']);

    $result = $conn->query("SELECT gambar FROM materi_$kategori WHERE id=$id");
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($row['gambar'] && file_exists("uploads/" . $row['gambar'])) {
            unlink("uploads/" . $row['gambar']);
        }
        $conn->query("DELETE FROM materi_$kategori WHERE id=$id");
        echo "<script>alert('Materi berhasil dihapus'); window.location='upload_materi.php';</script>";
        exit;
    }
}

// Ambil data semua materi per kategori
$materi_dasar = $conn->query("SELECT * FROM materi_dasar ORDER BY id DESC");
$materi_menengah = $conn->query("SELECT * FROM materi_menengah ORDER BY id DESC");
$materi_mahir = $conn->query("SELECT * FROM materi_mahir ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Upload Materi</title>
  <style>
    h2, h3 {
      text-align: center;
      color: #222;
    }

    .container {
      display: flex;
      justify-content: center;
      align-items: flex-start;
      flex-wrap: wrap;
      gap: 20px;
      padding: 30px;
    }

    .form-container, .tables-container {
      background: #fff;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
      flex: 1;
      min-width: 420px;
      max-width: 550px;
    }

    form {
      display: flex;
      flex-direction: column;
    }

    label {
      margin: 10px 0 5px;
      font-weight: 600;
    }

    input[type="text"],
    textarea,
    select,
    input[type="file"] {
      padding: 10px;
      border-radius: 6px;
      border: 1px solid #ccc;
      font-size: 14px;
      width: 100%;
    }

    button {
      margin-top: 20px;
      padding: 10px;
      background-color: #2e7d32;
      border: none;
      color: white;
      font-weight: bold;
      border-radius: 6px;
      cursor: pointer;
      transition: background 0.3s ease;
    }

    button:hover {
      background-color: #2e7d32;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }

    th, td {
      padding: 10px;
      border: 1px solid #ddd;
      text-align: center;
    }

    th {
      background-color: #2e7d32;
      color: white;
    }

    tr:nth-child(even) {
      background-color: #f9f9f9;
    }

    img {
      max-width: 100px;
      max-height: 60px;
      border-radius: 6px;
    }

    .action-links a {
      margin: 0 5px;
      color: #2e7d32;
      text-decoration: none;
      font-weight: bold;
    }

    .action-links a:hover {
      text-decoration: underline;
    }

    .current-image {
      margin: 10px 0;
    }

    .table-box {
      margin-bottom: 30px;
    }
  </style>
</head>
<body>

<div class="container">
  <!-- Form Upload / Edit -->
  <div class="form-container">
    <h3><?= $mode == 'tambah' ? 'Tambah Materi' : 'Edit Materi' ?></h3>
    <form action="<?= $mode == 'edit' ? '?edit=' . $id . '&kategori=' . $kategori : '' ?>" method="post" enctype="multipart/form-data">
      <label>Judul Materi</label>
      <input type="text" name="judul" value="<?= htmlspecialchars($judul) ?>" required>

      <label>Deskripsi Singkat</label>
      <textarea name="deskripsi_singkat" rows="3" required><?= htmlspecialchars($singkat) ?></textarea>

      <label>Deskripsi Lengkap</label>
      <textarea name="deskripsi_lengkap" rows="6" required><?= htmlspecialchars($lengkap) ?></textarea>

      <label>Kategori Materi</label>
      <select name="kategori" required>
        <option value="dasar" <?= $kategori == 'dasar' ? 'selected' : '' ?>>Dasar</option>
        <option value="menengah" <?= $kategori == 'menengah' ? 'selected' : '' ?>>Menengah</option>
        <option value="mahir" <?= $kategori == 'mahir' ? 'selected' : '' ?>>Mahir</option>
      </select>

      <?php if ($mode == 'tambah'): ?>
        <label>Gambar</label>
        <input type="file" name="gambar" accept="image/*" required>
        <button type="submit" name="upload">Upload</button>
      <?php else: ?>
        <div class="current-image">
          <p>Gambar saat ini:</p>
          <?php if ($gambar): ?>
            <img src="uploads/<?= htmlspecialchars($gambar) ?>" alt="gambar materi">
          <?php else: ?>
            <p>Tidak ada gambar</p>
          <?php endif; ?>
        </div>
        <input type="hidden" name="gambar_lama" value="<?= htmlspecialchars($gambar) ?>">
        <label>Ganti Gambar (opsional)</label>
        <input type="file" name="gambar" accept="image/*">
        <button type="submit" name="update">Update</button>
      <?php endif; ?>
    </form>
  </div>

  <!-- Daftar Materi -->
  <div class="tables-container">
    <?php
    $kategoriList = [
      'dasar' => $materi_dasar,
      'menengah' => $materi_menengah,
      'mahir' => $materi_mahir
    ];
    foreach ($kategoriList as $label => $data):
    ?>
    <div class="table-box">
      <h3>Materi <?= ucfirst($label) ?></h3>
      <table>
        <thead>
          <tr><th>No</th><th>Judul</th><th>Gambar</th><th>Aksi</th></tr>
        </thead>
        <tbody>
          <?php $no = 1; while ($row = $data->fetch_assoc()): ?>
          <tr>
            <td><?= $no++ ?></td>
            <td><?= htmlspecialchars($row['judul']) ?></td>
            <td>
              <?= $row['gambar'] ? '<img src="uploads/' . htmlspecialchars($row['gambar']) . '">' : '-' ?>
            </td>
            <td class="action-links">
              <a href="?edit=<?= $row['id'] ?>&kategori=<?= $label ?>">Edit</a> |
              <a href="?hapus=<?= $row['id'] ?>&kategori=<?= $label ?>" onclick="return confirm('Hapus materi ini?')">Hapus</a>
            </td>
          </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
    <?php endforeach; ?>
  </div>
</div>

</body>
</html>
