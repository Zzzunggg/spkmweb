<?php
include '../koneksi/koneksi.php'; // koneksi database
include 'header.php';

// Ambil keyword pencarian
$keyword = $_GET['keyword'] ?? '';

// Query data anggota dengan pencarian
if ($keyword) {
    $search = "%$keyword%";
    $stmt = $conn->prepare("SELECT * FROM anggota WHERE nama LIKE ? OR alamat LIKE ? OR email LIKE ? ORDER BY id DESC");
    $stmt->bind_param("sss", $search, $search, $search);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = $conn->query("SELECT * FROM anggota ORDER BY id DESC");
}

// Ambil data anggota untuk edit jika ada
$editData = null;
if (isset($_GET['edit'])) {
    $id = (int)$_GET['edit'];
    $stmt2 = $conn->prepare("SELECT * FROM anggota WHERE id = ?");
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
    <title>CRUD Data Anggota</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-green-50 p-6">

<h1 class="text-3xl font-extrabold mb-6 text-green-900">Data Anggota</h1>

<div class="flex gap-8">
  <!-- Form tambah/edit anggota -->
  <div class="w-1/3 p-6 bg-white rounded-lg shadow-lg border border-green-300">
    <h2 class="text-2xl mb-6 font-semibold text-green-800"><?= $editData ? "Edit Anggota" : "Tambah Anggota" ?></h2>

    <form action="proses/proses_anggota.php" method="post" class="space-y-6">
      <input type="hidden" name="id" value="<?= $editData['id'] ?? '' ?>">

      <label class="block text-green-700 font-medium">
        Nama
        <input type="text" name="nama" required 
          class="mt-2 w-full border border-green-400 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500" 
          value="<?= htmlspecialchars($editData['nama'] ?? '') ?>" />
      </label>

      <label class="block text-green-700 font-medium">
        Umur
        <input type="number" name="umur" required 
          class="mt-2 w-full border border-green-400 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500" 
          value="<?= htmlspecialchars($editData['umur'] ?? '') ?>" />
      </label>

      <label class="block text-green-700 font-medium">
        Alamat
        <textarea name="alamat" 
          class="mt-2 w-full border border-green-400 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500" 
          rows="3"><?= htmlspecialchars($editData['alamat'] ?? '') ?></textarea>
      </label>

      <label class="block text-green-700 font-medium">
        Email
        <input type="email" name="email" 
          class="mt-2 w-full border border-green-400 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500" 
          value="<?= htmlspecialchars($editData['email'] ?? '') ?>" />
      </label>

      <button type="submit" name="<?= $editData ? 'update' : 'add' ?>" 
        class="bg-green-700 text-white px-6 py-2 rounded-md hover:bg-green-800 transition duration-200">
        <?= $editData ? 'Update' : 'Tambah' ?>
      </button>

      <?php if ($editData): ?>
        <a href="anggota.php" class="ml-6 text-green-600 hover:underline font-semibold">Batal</a>
      <?php endif; ?>
    </form>
  </div>

  <!-- Tabel data anggota -->
  <div class="flex-1 overflow-auto bg-white rounded-lg shadow-lg border border-green-300 p-6">
    
    <!-- Form pencarian -->
    <form method="GET" class="mb-6 flex items-center gap-3">
      <input type="text" name="keyword" placeholder="Cari anggota..." value="<?= htmlspecialchars($keyword) ?>" 
        class="border border-green-400 px-4 py-2 rounded-md w-72 focus:outline-none focus:ring-2 focus:ring-green-500" />
      <button type="submit" class="bg-green-700 text-white px-5 py-2 rounded-md hover:bg-green-800 transition duration-200">Cari</button>
      <?php if($keyword): ?>
        <a href="anggota.php" class="ml-6 text-green-600 hover:underline font-semibold">Reset</a>
      <?php endif; ?>
    </form>

    <table class="min-w-full border border-green-300 rounded-md overflow-hidden">
      <thead class="bg-green-100 text-green-900 font-semibold text-left">
        <tr>
          <th class="px-5 py-3 border-b border-green-300">ID</th>
          <th class="px-5 py-3 border-b border-green-300">Nama</th>
          <th class="px-5 py-3 border-b border-green-300">Umur</th>
          <th class="px-5 py-3 border-b border-green-300">Alamat</th>
          <th class="px-5 py-3 border-b border-green-300">Email</th>
          <th class="px-5 py-3 border-b border-green-300">Aksi</th>
        </tr>
      </thead>
      <tbody class="text-green-800">
        <?php if($result->num_rows > 0): ?>
          <?php while ($row = $result->fetch_assoc()): ?>
          <tr class="border-t border-green-300 hover:bg-green-50 transition">
            <td class="px-5 py-3"><?= $row['id'] ?></td>
            <td class="px-5 py-3"><?= htmlspecialchars($row['nama']) ?></td>
            <td class="px-5 py-3"><?= $row['umur'] ?></td>
            <td class="px-5 py-3 whitespace-pre-wrap"><?= htmlspecialchars($row['alamat']) ?></td>
            <td class="px-5 py-3"><?= htmlspecialchars($row['email']) ?></td>
            <td class="px-5 py-3 space-x-4">
              <a href="?edit=<?= $row['id'] ?>" class="text-green-700 hover:underline font-semibold">Edit</a>
              <a href="proses/proses_anggota.php?delete=<?= $row['id'] ?>" 
                 onclick="return confirm('Yakin ingin hapus data?');" 
                 class="text-red-600 hover:underline font-semibold">Hapus</a>
            </td>
          </tr>
          <?php endwhile; ?>
        <?php else: ?>
          <tr><td colspan="6" class="text-center p-6 text-green-600 font-semibold">Data tidak ditemukan.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

</body>
</html>
