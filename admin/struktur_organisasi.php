
<?php
include '../koneksi/koneksi.php';

// --- Proses Tambah ---
if (isset($_POST['tambah'])) {
    $nama = $_POST['nama'];
    $jabatan = $_POST['jabatan'];
    $deskripsi = $_POST['deskripsi'];

    $foto = null;
    if (!empty($_FILES['foto']['name'])) {
        $uploadDir = 'uploads/';
        $fotoName = time() . '_' . basename($_FILES['foto']['name']);
        $targetFile = $uploadDir . $fotoName;
        if (move_uploaded_file($_FILES['foto']['tmp_name'], $targetFile)) {
            $foto = $fotoName;
        }
    }

    $stmt = $conn->prepare("INSERT INTO struktur_organisasi (nama, jabatan, foto, deskripsi) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $nama, $jabatan, $foto, $deskripsi);
    $stmt->execute();

    header('Location: struktur_organisasi.php');
    exit();
}

// --- Proses Hapus ---
if (isset($_GET['hapus'])) {
    $id = (int)$_GET['hapus'];

    // Hapus file foto jika ada
    $res = $conn->query("SELECT foto FROM struktur_organisasi WHERE id=$id");
    if ($res && $res->num_rows > 0) {
        $row = $res->fetch_assoc();
        if ($row['foto'] && file_exists('uploads/' . $row['foto'])) {
            unlink('uploads/' . $row['foto']);
        }
    }
    $conn->query("DELETE FROM struktur_organisasi WHERE id=$id");

    header('Location: struktur_organisasi.php');
    exit();
}

// --- Proses Update ---
if (isset($_POST['update'])) {
    $id = (int)$_POST['id'];
    $nama = $_POST['nama'];
    $jabatan = $_POST['jabatan'];
    $deskripsi = $_POST['deskripsi'];

    if (!empty($_FILES['foto']['name'])) {
        // Hapus foto lama
        $res = $conn->query("SELECT foto FROM struktur_organisasi WHERE id=$id");
        if ($res && $res->num_rows > 0) {
            $row = $res->fetch_assoc();
            if ($row['foto'] && file_exists('uploads/' . $row['foto'])) {
                unlink('uploads/' . $row['foto']);
            }
        }
        $uploadDir = 'uploads/';
        $fotoName = time() . '_' . basename($_FILES['foto']['name']);
        $targetFile = $uploadDir . $fotoName;
        move_uploaded_file($_FILES['foto']['tmp_name'], $targetFile);

        $stmt = $conn->prepare("UPDATE struktur_organisasi SET nama=?, jabatan=?, foto=?, deskripsi=? WHERE id=?");
        $stmt->bind_param("ssssi", $nama, $jabatan, $fotoName, $deskripsi, $id);
    } else {
        $stmt = $conn->prepare("UPDATE struktur_organisasi SET nama=?, jabatan=?, deskripsi=? WHERE id=?");
        $stmt->bind_param("sssi", $nama, $jabatan, $deskripsi, $id);
    }
    $stmt->execute();

    header('Location: struktur_organisasi.php');
    exit();
}

// Setelah proses di atas, baru include header dan mulai output HTML
include 'header.php';

// --- Ambil data untuk edit jika ada ?edit=id ---
$editData = null;
if (isset($_GET['edit'])) {
    $id = (int)$_GET['edit'];
    $res = $conn->query("SELECT * FROM struktur_organisasi WHERE id=$id");
    if ($res && $res->num_rows > 0) {
        $editData = $res->fetch_assoc();
    }
}

// --- Ambil semua data ---
$data = $conn->query("SELECT * FROM struktur_organisasi ORDER BY id ASC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Admin Struktur Organisasi</title>
<style>
  /* CSS tetap sama */
  .container {
    max-width: 900px;
    margin: 0 auto;
  }
 
  form {
    background: white;
    padding: 1.5rem;
    border-radius: 8px;
    box-shadow: 0 3px 8px rgba(46,125,50,0.1);
    margin-bottom: 2rem;
    max-width: 500px;
    margin-left: auto;
    margin-right: auto;
  }
  label {
    display: block;
    margin-top: 0.8rem;
    font-weight: 600;
    color: #356b33;
  }
  input[type=text], textarea, input[type=file] {
    width: 100%;
    padding: 0.5rem;
    border: 1px solid #a5d6a7;
    border-radius: 4px;
    margin-top: 0.3rem;
    box-sizing: border-box;
    font-size: 1rem;
  }
  textarea {
    resize: vertical;
  }
  button {
    margin-top: 1.2rem;
    background-color: #2e7d32;
    color: white;
    border: none;
    padding: 0.8rem 1.3rem;
    border-radius: 5px;
    cursor: pointer;
    font-size: 1rem;
    display: inline-block;
  }
  button:hover {
    background-color: #4caf50;
  }
  form a {
    display: inline-block;
    margin-left: 10px;
    color: #2e7d32;
    font-weight: 600;
    text-decoration: none;
  }
  form a:hover {
    text-decoration: underline;
  }
  h2 {
    color: #2e7d32;
    margin-bottom: 1rem;
    text-align: center;
  }
  table {
    width: 100%;
    border-collapse: collapse;
    background: white;
    box-shadow: 0 2px 6px rgba(0,0,0,0.07);
  }
  th, td {
    border: 1px solid #c8e6c9;
    padding: 10px 12px;
    text-align: left;
    vertical-align: middle;
  }
  th {
    background-color: #2e7d32;
    color: white;
  }
  td img {
    max-width: 80px;
    border-radius: 4px;
    display: block;
    margin: 0 auto;
  }
  a.button-link {
    display: inline-block;
    padding: 5px 10px;
    background: #4caf50;
    color: white;
    border-radius: 4px;
    text-decoration: none;
    font-size: 0.9rem;
    margin-right: 5px;
  }
  a.button-link:hover {
    background: #388e3c;
  }
  a.delete-link {
    background: #d32f2f;
  }
  a.delete-link:hover {
    background: #b71c1c;
  }
</style>
</head>
<body>
<div class="container">
<br><br>
  <form method="post" enctype="multipart/form-data" autocomplete="off">
    <input type="hidden" name="id" value="<?= $editData ? $editData['id'] : '' ?>" />
    <label for="nama">Nama:</label>
    <input type="text" id="nama" name="nama" required value="<?= $editData ? htmlspecialchars($editData['nama']) : '' ?>" />

    <label for="jabatan">Jabatan:</label>
    <input type="text" id="jabatan" name="jabatan" required value="<?= $editData ? htmlspecialchars($editData['jabatan']) : '' ?>" />

    <label for="foto">Foto: <?= $editData && $editData['foto'] ? "(kosongkan jika tidak ingin ganti)" : "" ?></label>
    <input type="file" id="foto" name="foto" accept="image/*" />

    <label for="deskripsi">Deskripsi:</label>
    <textarea id="deskripsi" name="deskripsi" rows="4"><?= $editData ? htmlspecialchars($editData['deskripsi']) : '' ?></textarea>

    <?php if ($editData): ?>
      <button type="submit" name="update">Update</button>
      <a href="struktur_organisasi.php">Batal</a>
    <?php else: ?>
      <button type="submit" name="tambah">Tambah</button>
    <?php endif; ?>
  </form>

  <h2>Daftar Struktur Organisasi</h2>
  <?php if ($data && $data->num_rows > 0): ?>
  <table>
    <thead>
      <tr>
        <th>Foto</th>
        <th>Nama</th>
        <th>Jabatan</th>
        <th>Deskripsi</th>
        <th style="width: 140px;">Aksi</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($row = $data->fetch_assoc()): ?>
        <tr>
          <td>
            <?php if ($row['foto'] && file_exists('uploads/' . $row['foto'])): ?>
              <img src="uploads/<?= htmlspecialchars($row['foto']) ?>" alt="<?= htmlspecialchars($row['nama']) ?>" />
            <?php else: ?>
              No Image
            <?php endif; ?>
          </td>
          <td><?= htmlspecialchars($row['nama']) ?></td>
          <td><?= htmlspecialchars($row['jabatan']) ?></td>
          <td style="max-width: 300px;"><?= nl2br(htmlspecialchars($row['deskripsi'])) ?></td>
          <td>
            <a class="button-link" href="?edit=<?= $row['id'] ?>">Edit</a>
            <a class="button-link delete-link" href="?hapus=<?= $row['id'] ?>" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
          </td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
  <?php else: ?>
    <p style="text-align:center; color:#555;">Belum ada data struktur organisasi.</p>
  <?php endif; ?>

</div>
</body>
</html>
