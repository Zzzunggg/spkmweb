<?php include 'proses/auth_admin.php';?>
<?php
include '../koneksi/koneksi.php'; // koneksi database, variabel $conn
include 'header.php';

// Tangkap keyword pencarian dari GET
$keyword = $_GET['keyword'] ?? '';

// Query ambil data pelatih dengan filter pencarian
if ($keyword) {
    // pakai prepared statement agar aman dari SQL Injection
    $search = "%$keyword%";
    $stmt = $conn->prepare("SELECT * FROM pelatih WHERE nama LIKE ? OR spesialisasi LIKE ? OR pengalaman LIKE ? ORDER BY id DESC");
    $stmt->bind_param("sss", $search, $search, $search);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    // tanpa filter keyword
    $result = $conn->query("SELECT * FROM pelatih ORDER BY id DESC");
}

// Ambil data pelatih untuk edit jika ada ?edit=id
$editData = null;
if (isset($_GET['edit'])) {
    $id = (int)$_GET['edit'];
    $stmt2 = $conn->prepare("SELECT * FROM pelatih WHERE id = ?");
    $stmt2->bind_param("i", $id);
    $stmt2->execute();
    $editData = $stmt2->get_result()->fetch_assoc();
    $stmt2->close();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <title>CRUD Data Pelatih</title>
  <style>
  h1, h2 {
    text-align: center;
  }
  form {
    background: white; /* tetap putih */
    max-width: 600px;
    margin: 0 auto 30px;
    padding: 20px 25px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    border-radius: 8px;
  }
  form label {
    display: block;
    margin-bottom: 8px;
    font-weight: 600;
    color: #333;
  }
  form input[type="text"],
  form input[type="number"],
  form textarea {
    width: 100%;
    padding: 10px 12px;
    margin-bottom: 18px;
    border: 1px solid #ccc;
    border-radius: 6px;
    font-size: 1rem;
    resize: vertical;
    transition: border-color 0.3s;
    background: white; /* putih */
    color: #333;
  }
  form input[type="text"]:focus,
  form input[type="number"]:focus,
  form textarea:focus {
    border-color: #29802f; /* hijau tua fokus */
    outline: none;
    background: #f9fff9; /* sangat terang hijau */
  }
  form button {
    background-color: #2c6b2f; /* hijau gelap */
    color: white;
    border: none;
    padding: 12px 22px;
    border-radius: 6px;
    font-size: 1.1rem;
    cursor: pointer;
    transition: background-color 0.3s ease;
  }
  form button:hover {
    background-color: #1f4d1f; /* hijau lebih gelap */
  }
  form a.cancel-link {
    margin-left: 15px;
    color: #555;
    font-weight: 600;
    text-decoration: none;
  }
  form a.cancel-link:hover {
    text-decoration: underline;
  }
  .search-form {
    max-width: 600px;
    margin: 0 auto 20px;
    display: flex;
    justify-content: center;
    gap: 10px;
  }
  .search-form input[type="text"] {
    flex-grow: 1;
    max-width: 400px;
    border-radius: 6px;
    padding: 10px 12px;
    background: white;
    color: #333;
    border: 1px solid #ccc;
    transition: border-color 0.3s;
  }
  .search-form input[type="text"]:focus {
    border-color: #29802f;
    outline: none;
  }
  .search-form button {
    background-color: #2c6b2f;
    color: white;
    border: none;
    padding: 12px 22px;
    border-radius: 6px;
    cursor: pointer;
    transition: background-color 0.3s ease;
  }
  .search-form button:hover {
    background-color: #1f4d1f;
  }
  .search-form a.cancel-link {
    color: #555;
    font-weight: 600;
    text-decoration: none;
    align-self: center;
  }
  .search-form a.cancel-link:hover {
    text-decoration: underline;
  }
  table {
    width: 90%;
    margin: 0 auto;
    border-collapse: collapse;
    background: white; /* putih */
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    border-radius: 8px;
    overflow: hidden;
    color: #333;
  }
  th, td {
    padding: 12px 15px;
    border-bottom: 1px solid #ddd;
    text-align: left;
    vertical-align: top;
  }
  th {
    background: #2c6b2f; /* hijau header tabel */
    color: white;
    font-weight: 700;
  }

  td.actions a {
    margin-right: 12px;
    font-weight: 600;
    color: #2c6b2f; /* hijau link aksi */
    text-decoration: none;
  }
  td.actions a.delete {
    color: #a83a3a; /* merah gelap untuk delete */
  }
  td.actions a:hover {
    text-decoration: underline;
  }
  @media (max-width: 700px) {
    body {
      padding: 10px;
    }
    form, .search-form, table {
      width: 100%;
    }
    table, thead, tbody, th, td, tr {
      display: block;
    }
    thead tr {
      display: none;
    }

    td {
      border: none;
      padding: 8px 12px;
      position: relative;
      padding-left: 50%;
      color: #333;
    }

    td.actions {
      padding-left: 12px;
    }
  }
</style>

</head>
<body>

<form method="GET" class="search-form" autocomplete="off">
  <input type="text" name="keyword" placeholder="Cari pelatih..." value="<?= htmlspecialchars($keyword) ?>" />
  <button type="submit">Cari</button>
  <?php if ($keyword): ?>
    <a href="pelatih.php" class="cancel-link">Reset</a>
  <?php endif; ?>
</form>

<form action="proses/proses_pelatih.php" method="post" autocomplete="off">
  <input type="hidden" name="id" value="<?= $editData['id'] ?? '' ?>" />
  <h2><?= $editData ? 'Edit Pelatih' : 'Tambah Pelatih' ?></h2>
  
  <label for="nama">Nama</label>
  <input type="text" id="nama" name="nama" required value="<?= htmlspecialchars($editData['nama'] ?? '') ?>" />
  
  <label for="umur">Umur</label>
  <input type="number" id="umur" name="umur" required value="<?= htmlspecialchars($editData['umur'] ?? '') ?>" />
  
  <label for="spesialisasi">Spesialisasi</label>
  <input type="text" id="spesialisasi" name="spesialisasi" required value="<?= htmlspecialchars($editData['spesialisasi'] ?? '') ?>" />
  
  <label for="pengalaman">Pengalaman</label>
  <textarea id="pengalaman" name="pengalaman" rows="4"><?= htmlspecialchars($editData['pengalaman'] ?? '') ?></textarea>
  
  <button type="submit" name="<?= $editData ? 'update' : 'add' ?>">
    <?= $editData ? 'Update' : 'Tambah' ?>
  </button>
  <?php if ($editData): ?>
    <a href="pelatih.php" class="cancel-link">Batal</a>
  <?php endif; ?>
</form>

<table>
  <thead>
    <tr>
      <th>ID</th>
      <th>Nama</th>
      <th>Umur</th>
      <th>Spesialisasi</th>
      <th>Pengalaman</th>
      <th>Aksi</th>
    </tr>
  </thead>
  <tbody>
    <?php if ($result && $result->num_rows > 0): ?>
      <?php while ($row = $result->fetch_assoc()): ?>
      <tr>
        <td data-label="ID"><?= $row['id'] ?></td>
        <td data-label="Nama"><?= htmlspecialchars($row['nama']) ?></td>
        <td data-label="Umur"><?= $row['umur'] ?></td>
        <td data-label="Spesialisasi"><?= htmlspecialchars($row['spesialisasi']) ?></td>
        <td data-label="Pengalaman"><?= nl2br(htmlspecialchars($row['pengalaman'])) ?></td>
        <td data-label="Aksi" class="actions">
          <a href="?edit=<?= $row['id'] ?>">Edit</a>
          <a href="proses/proses_pelatih.php?delete=<?= $row['id'] ?>" onclick="return confirm('Yakin ingin hapus data?');" class="delete">Hapus</a>
        </td>
      </tr>
      <?php endwhile; ?>
    <?php else: ?>
      <tr><td colspan="6" style="text-align:center; padding: 15px;">Data tidak ditemukan.</td></tr>
    <?php endif; ?>
  </tbody>
</table>

</body>
</html>
