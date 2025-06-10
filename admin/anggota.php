<?php
// Sertakan file koneksi dan header
include '../koneksi/koneksi.php'; 
include 'header.php';

// Ambil keyword pencarian dari URL, jika ada
$keyword = $_GET['keyword'] ?? '';

// --- Kueri Data Anggota dengan Fitur Pencarian ---
if ($keyword) {
    $search = "%$keyword%";
    // (UPDATED) Tambahkan kolom baru (no_induk, tempat_lahir) ke dalam pencarian
    $stmt = $conn->prepare("SELECT * FROM anggota WHERE nama LIKE ? OR no_induk LIKE ? OR alamat LIKE ? OR email LIKE ? OR tempat_lahir LIKE ? ORDER BY id DESC");
    // (UPDATED) Sesuaikan bind_param menjadi "sssss" untuk 5 parameter
    $stmt->bind_param("sssss", $search, $search, $search, $search, $search);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    // Kueri standar jika tidak ada pencarian
    $result = $conn->query("SELECT * FROM anggota ORDER BY id DESC");
}

// Ambil data anggota untuk form edit jika parameter 'edit' ada di URL
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

<div class="flex flex-col lg:flex-row gap-8">
    <div class="w-full lg:w-1/3 p-6 bg-white rounded-lg shadow-lg border border-green-300">
        <h2 class="text-2xl mb-6 font-semibold text-green-800"><?= $editData ? "Edit Anggota" : "Tambah Anggota" ?></h2>

        <form action="proses/proses_anggota.php" method="post" class="space-y-4">
            <input type="hidden" name="id" value="<?= $editData['id'] ?? '' ?>">

            <label class="block text-green-700 font-medium">
                Nama Lengkap
                <input type="text" name="nama" required 
                       class="mt-2 w-full border border-green-400 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500" 
                       value="<?= htmlspecialchars($editData['nama'] ?? '') ?>" />
            </label>

            <label class="block text-green-700 font-medium">
                No. Induk
                <input type="text" name="no_induk" required 
                       class="mt-2 w-full border border-green-400 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500" 
                       value="<?= htmlspecialchars($editData['no_induk'] ?? '') ?>" />
            </label>
            
            <label class="block text-green-700 font-medium">
                Tempat Lahir
                <input type="text" name="tempat_lahir"
                       class="mt-2 w-full border border-green-400 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500" 
                       value="<?= htmlspecialchars($editData['tempat_lahir'] ?? '') ?>" />
            </label>
            
            <label class="block text-green-700 font-medium">
                Tanggal Lahir
                <input type="date" name="tanggal_lahir" 
                       class="mt-2 w-full border border-green-400 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500" 
                       value="<?= htmlspecialchars($editData['tanggal_lahir'] ?? '') ?>" />
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
                <?= $editData ? 'Update Data' : 'Tambah Data' ?>
            </button>

            <?php if ($editData): ?>
                <a href="anggota.php" class="ml-4 text-green-600 hover:underline font-semibold">Batal Edit</a>
            <?php endif; ?>
        </form>
    </div>

    <div class="flex-1 overflow-x-auto bg-white rounded-lg shadow-lg border border-green-300 p-6">
        
        <form method="GET" class="mb-6 flex items-center gap-3">
            <input type="text" name="keyword" placeholder="Cari nama, no induk, alamat..." value="<?= htmlspecialchars($keyword) ?>" 
                   class="border border-green-400 px-4 py-2 rounded-md w-full md:w-72 focus:outline-none focus:ring-2 focus:ring-green-500" />
            <button type="submit" class="bg-green-700 text-white px-5 py-2 rounded-md hover:bg-green-800 transition duration-200">Cari</button>
            <?php if($keyword): ?>
                <a href="anggota.php" class="text-green-600 hover:underline font-semibold whitespace-nowrap">Reset Cari</a>
            <?php endif; ?>
        </form>

        <table class="min-w-full border border-green-300 rounded-md overflow-hidden">
            <thead class="bg-green-100 text-green-900 font-semibold text-left">
                <tr>
                    <th class="px-5 py-3 border-b border-green-300">ID</th>
                    <th class="px-5 py-3 border-b border-green-300">Nama</th>
                    <th class="px-5 py-3 border-b border-green-300">No. Induk</th>
                    <th class="px-5 py-3 border-b border-green-300">Lahir</th>
                    <th class="px-5 py-3 border-b border-green-300">Alamat</th>
                    <th class="px-5 py-3 border-b border-green-300">Email</th>
                    <th class="px-5 py-3 border-b border-green-300">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-green-800">
                <?php if($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                    <tr class="border-t border-green-200 hover:bg-green-50 transition">
                        <td class="px-5 py-3"><?= $row['id'] ?></td>
                        <td class="px-5 py-3 font-medium"><?= htmlspecialchars($row['nama']) ?></td>
                        <td class="px-5 py-3"><?= htmlspecialchars($row['no_induk']) ?></td>
                        <td class="px-5 py-3 whitespace-nowrap"><?= htmlspecialchars($row['tempat_lahir'] . ', ' . date('d M Y', strtotime($row['tanggal_lahir']))) ?></td>
                        <td class="px-5 py-3"><?= htmlspecialchars($row['alamat']) ?></td>
                        <td class="px-5 py-3"><?= htmlspecialchars($row['email']) ?></td>
                        <td class="px-5 py-3 space-x-4 whitespace-nowrap">
                            <a href="?edit=<?= $row['id'] ?>" class="text-green-700 hover:underline font-semibold">Edit</a>
                            <a href="proses/proses_anggota.php?delete=<?= $row['id'] ?>" 
                               onclick="return confirm('Yakin ingin hapus data ini?');" 
                               class="text-red-600 hover:underline font-semibold">Hapus</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="7" class="text-center p-6 text-green-600 font-semibold">Data tidak ditemukan.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>