<?php
ob_start(); // <- tambahkan ini di baris paling atas untuk menahan output

include '../koneksi/koneksi.php';
include 'header.php';

// --- PROSES TAMBAH ---
if (isset($_POST['aksi']) && $_POST['aksi'] === 'tambah') {
    $tingkat = $_POST['tingkat'];
    $tempat = $_POST['tempat'];
    $waktu = $_POST['waktu'];
    $hari = $_POST['hari'];

    $stmt = $conn->prepare("INSERT INTO jadwal_latihan (tingkat, tempat, waktu, hari) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $tingkat, $tempat, $waktu, $hari);
    $stmt->execute();

    header("Location: ".$_SERVER['PHP_SELF']);
    exit;
}

// --- PROSES EDIT ---
if (isset($_POST['aksi']) && $_POST['aksi'] === 'edit') {
    $id = intval($_POST['id']);
    $tingkat = $_POST['tingkat'];
    $tempat = $_POST['tempat'];
    $waktu = $_POST['waktu'];
    $hari = $_POST['hari'];

    $stmt = $conn->prepare("UPDATE jadwal_latihan SET tingkat=?, tempat=?, waktu=?, hari=? WHERE id=?");
    $stmt->bind_param("ssssi", $tingkat, $tempat, $waktu, $hari, $id);
    $stmt->execute();

    header("Location: ".$_SERVER['PHP_SELF']);
    exit;
}

// --- PROSES HAPUS ---
if (isset($_GET['hapus'])) {
    $id = intval($_GET['hapus']);
    $result = $conn->query("DELETE FROM jadwal_latihan WHERE id = $id");
    if (!$result) {
        die("Gagal hapus data: " . $conn->error);
    }
    header("Location: ".$_SERVER['PHP_SELF']);
    exit;
}

// --- AMBIL DATA JADWAL ---
$jadwal = $conn->query("SELECT * FROM jadwal_latihan ORDER BY tingkat ASC, id DESC");

$dasar = $menengah = $mahir = [];
while ($row = $jadwal->fetch_assoc()) {
    if ($row['tingkat'] == 'Dasar') $dasar[] = $row;
    elseif ($row['tingkat'] == 'Menengah') $menengah[] = $row;
    elseif ($row['tingkat'] == 'Mahir') $mahir[] = $row;
}

// --- MODE EDIT ---
$mode_edit = false;
$edit_data = null;
if (isset($_GET['edit'])) {
    $id_edit = intval($_GET['edit']);
    $res = $conn->query("SELECT * FROM jadwal_latihan WHERE id = $id_edit");
    if ($res->num_rows > 0) {
        $edit_data = $res->fetch_assoc();
        $mode_edit = true;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <title>Kelola Jadwal Latihan</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-green-50 min-h-screen p-6">

  <!-- FORM TAMBAH / EDIT -->
  <form method="post" action="" class="max-w-xl mx-auto bg-white rounded-lg shadow-md p-6 mb-10">
    <h2 class="text-2xl font-semibold text-green-800 mb-6"><?= $mode_edit ? 'Edit Jadwal' : 'Tambah Jadwal Baru' ?></h2>

    <input type="hidden" name="aksi" value="<?= $mode_edit ? 'edit' : 'tambah' ?>">
    <?php if ($mode_edit): ?>
      <input type="hidden" name="id" value="<?= $edit_data['id'] ?>">
    <?php endif; ?>

    <label class="block mb-2 font-medium text-green-700">Tingkat:</label>
    <select name="tingkat" required class="w-full mb-4 p-2 border rounded-md">
      <option value="Dasar" <?= ($mode_edit && $edit_data['tingkat'] == 'Dasar') ? 'selected' : '' ?>>Dasar</option>
      <option value="Menengah" <?= ($mode_edit && $edit_data['tingkat'] == 'Menengah') ? 'selected' : '' ?>>Menengah</option>
      <option value="Mahir" <?= ($mode_edit && $edit_data['tingkat'] == 'Mahir') ? 'selected' : '' ?>>Mahir</option>
    </select>

    <label class="block mb-2 font-medium text-green-700">Tempat:</label>
    <input type="text" name="tempat" required value="<?= $mode_edit ? htmlspecialchars($edit_data['tempat']) : '' ?>" class="w-full mb-4 p-2 border rounded-md">

    <label class="block mb-2 font-medium text-green-700">Waktu:</label>
    <input type="text" name="waktu" required placeholder="Contoh: 07.00 - 09.00 WIB" value="<?= $mode_edit ? htmlspecialchars($edit_data['waktu']) : '' ?>" class="w-full mb-4 p-2 border rounded-md">

    <label class="block mb-2 font-medium text-green-700">Hari:</label>
    <input type="text" name="hari" required placeholder="Contoh: Senin, Rabu, Jumat" value="<?= $mode_edit ? htmlspecialchars($edit_data['hari']) : '' ?>" class="w-full mb-6 p-2 border rounded-md">

    <button type="submit" class="w-full bg-green-700 text-white py-3 rounded hover:bg-green-800 transition">
      <?= $mode_edit ? 'Update Jadwal' : 'Tambah Jadwal' ?>
    </button>

    <?php if ($mode_edit): ?>
      <a href="<?= $_SERVER['PHP_SELF'] ?>" class="block text-center mt-4 text-green-600 hover:underline">Batal edit</a>
    <?php endif; ?>
  </form>

  <!-- TABEL DATA -->
  <div class="max-w-6xl mx-auto grid md:grid-cols-3 gap-8">

    <!-- Dasar -->
    <div class="bg-white rounded-lg shadow p-6 border-l-4 border-green-600">
      <h2 class="text-xl font-bold mb-4 text-green-700">Dasar</h2>
      <?php if ($dasar): foreach ($dasar as $j): ?>
        <div class="mb-4 pb-4 border-b">
          <p><strong>Tempat:</strong> <?= htmlspecialchars($j['tempat']) ?></p>
          <p><strong>Waktu:</strong> <?= htmlspecialchars($j['waktu']) ?></p>
          <p><strong>Hari:</strong> <?= htmlspecialchars($j['hari']) ?></p>
          <div class="mt-2">
            <a href="?edit=<?= $j['id'] ?>" class="text-blue-600 hover:underline">Edit</a> |
            <a href="?hapus=<?= $j['id'] ?>" onclick="return confirm('Yakin hapus?')" class="text-red-600 hover:underline">Hapus</a>
          </div>
        </div>
      <?php endforeach; else: ?>
        <p class="text-green-600">Belum ada jadwal.</p>
      <?php endif; ?>
    </div>

    <!-- Menengah -->
    <div class="bg-white rounded-lg shadow p-6 border-l-4 border-yellow-600">
      <h2 class="text-xl font-bold mb-4 text-yellow-700">Menengah</h2>
      <?php if ($menengah): foreach ($menengah as $j): ?>
        <div class="mb-4 pb-4 border-b">
          <p><strong>Tempat:</strong> <?= htmlspecialchars($j['tempat']) ?></p>
          <p><strong>Waktu:</strong> <?= htmlspecialchars($j['waktu']) ?></p>
          <p><strong>Hari:</strong> <?= htmlspecialchars($j['hari']) ?></p>
          <div class="mt-2">
            <a href="?edit=<?= $j['id'] ?>" class="text-blue-600 hover:underline">Edit</a> |
            <a href="?hapus=<?= $j['id'] ?>" onclick="return confirm('Yakin hapus?')" class="text-red-600 hover:underline">Hapus</a>
          </div>
        </div>
      <?php endforeach; else: ?>
        <p class="text-yellow-600">Belum ada jadwal.</p>
      <?php endif; ?>
    </div>

    <!-- Mahir -->
    <div class="bg-white rounded-lg shadow p-6 border-l-4 border-purple-600">
      <h2 class="text-xl font-bold mb-4 text-purple-700">Mahir</h2>
      <?php if ($mahir): foreach ($mahir as $j): ?>
        <div class="mb-4 pb-4 border-b">
          <p><strong>Tempat:</strong> <?= htmlspecialchars($j['tempat']) ?></p>
          <p><strong>Waktu:</strong> <?= htmlspecialchars($j['waktu']) ?></p>
          <p><strong>Hari:</strong> <?= htmlspecialchars($j['hari']) ?></p>
          <div class="mt-2">
            <a href="?edit=<?= $j['id'] ?>" class="text-blue-600 hover:underline">Edit</a> |
            <a href="?hapus=<?= $j['id'] ?>" onclick="return confirm('Yakin hapus?')" class="text-red-600 hover:underline">Hapus</a>
          </div>
        </div>
      <?php endforeach; else: ?>
        <p class="text-purple-600">Belum ada jadwal.</p>
      <?php endif; ?>
    </div>

  </div>

</body>
</html>

<?php ob_end_flush(); // Flush output buffer ?>
