<?php
session_start();
include '../koneksi/koneksi.php';
// include 'header_admin.php';
include 'header.php';
// --- Konfigurasi dan Diagnosis Otomatis ---
$pdf_upload_dir_name = 'materi_pdf';
$gambar_upload_dir_name = 'gambar_materi';
$pdf_upload_dir = __DIR__ . '/' . $pdf_upload_dir_name . '/';
$gambar_upload_dir = __DIR__ . '/' . $gambar_upload_dir_name . '/';
$pesan_error_awal = '';

// Cek dan buat folder jika belum ada
if (!is_dir($pdf_upload_dir)) { if (!mkdir($pdf_upload_dir, 0755, true)) { $pesan_error_awal .= " Gagal membuat folder {$pdf_upload_dir_name}."; }}
if (!is_dir($gambar_upload_dir)) { if (!mkdir($gambar_upload_dir, 0755, true)) { $pesan_error_awal .= " Gagal membuat folder {$gambar_upload_dir_name}."; }}

// Cek izin tulis folder
if (is_dir($pdf_upload_dir) && !is_writable($pdf_upload_dir)) { $pesan_error_awal .= " Folder {$pdf_upload_dir_name} tidak bisa ditulisi (permission denied)."; }
if (is_dir($gambar_upload_dir) && !is_writable($gambar_upload_dir)) { $pesan_error_awal .= " Folder {$gambar_upload_dir_name} tidak bisa ditulisi (permission denied)."; }

if (!empty($pesan_error_awal)) { $_SESSION['pesan_error'] = "FATAL:".$pesan_error_awal; header("Location: admin_materi.php"); exit(); }

// --- Logika CRUD ---
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
    // Ambil semua data dari form
    $id = isset($_POST['id']) && !empty($_POST['id']) ? $_POST['id'] : null;
    $sabuk = $_POST['sabuk'];
    $judul = $_POST['judul'];
    $anchor_id = $_POST['anchor_id'];
    $deskripsi = $_POST['deskripsi'];
    $video_url = $_POST['video_url'];
    $urutan = $_POST['urutan'];
    
    // Siapkan nama file lama
    $pdf_lama = $_POST['pdf_lama'];
    $gambar_lama = $_POST['gambar_lama'];
    $nama_file_pdf_baru = $pdf_lama;
    $nama_file_gambar_baru = $gambar_lama;

    // Proses upload PDF jika ada file baru
    if (isset($_FILES['file_pdf']) && $_FILES['file_pdf']['error'] == UPLOAD_ERR_OK) {
        // ... (logika upload PDF tidak berubah)
        $file_tmp = $_FILES['file_pdf']['tmp_name']; $file_name = basename($_FILES['file_pdf']['name']); $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        if ($file_ext == 'pdf') {
            $nama_file_pdf_baru = time() . '-pdf-' . preg_replace("/[^a-zA-Z0-9-.]/", "", $file_name);
            if (move_uploaded_file($file_tmp, $pdf_upload_dir . $nama_file_pdf_baru)) {
                if (!empty($pdf_lama) && file_exists($pdf_upload_dir . $pdf_lama)) { unlink($pdf_upload_dir . $pdf_lama); }
            }
        } else { $_SESSION['pesan_error'] = "Hanya file PDF yang diizinkan."; header("Location: admin_materi.php"); exit(); }
    }

    // Proses upload GAMBAR jika ada file baru
    if (isset($_FILES['gambar_materi']) && $_FILES['gambar_materi']['error'] == UPLOAD_ERR_OK) {
        $img_tmp = $_FILES['gambar_materi']['tmp_name']; $img_name = basename($_FILES['gambar_materi']['name']);
        $img_ext = strtolower(pathinfo($img_name, PATHINFO_EXTENSION));
        $allowed_img_ext = ['jpg', 'jpeg', 'png', 'gif'];
        if (in_array($img_ext, $allowed_img_ext)) {
            $nama_file_gambar_baru = time() . '-img-' . preg_replace("/[^a-zA-Z0-9-.]/", "", $img_name);
            if (move_uploaded_file($img_tmp, $gambar_upload_dir . $nama_file_gambar_baru)) {
                if (!empty($gambar_lama) && file_exists($gambar_upload_dir . $gambar_lama)) { unlink($gambar_upload_dir . $gambar_lama); }
            }
        } else { $_SESSION['pesan_error'] = "Hanya file gambar (JPG, PNG, GIF) yang diizinkan."; header("Location: admin_materi.php"); exit(); }
    }

    // Eksekusi ke database
    if ($id) { // Update
        $sql = "UPDATE materi_detail SET sabuk=?, judul=?, anchor_id=?, deskripsi=?, video_url=?, nama_file_pdf=?, gambar_materi=?, urutan=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssssii", $sabuk, $judul, $anchor_id, $deskripsi, $video_url, $nama_file_pdf_baru, $nama_file_gambar_baru, $urutan, $id);
        $pesan = "Materi berhasil diperbarui.";
    } else { // Create
        $sql = "INSERT INTO materi_detail (sabuk, judul, anchor_id, deskripsi, video_url, nama_file_pdf, gambar_materi, urutan) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssssi", $sabuk, $judul, $anchor_id, $deskripsi, $video_url, $nama_file_pdf_baru, $nama_file_gambar_baru, $urutan);
        $pesan = "Materi baru berhasil ditambahkan.";
    }
    if ($stmt->execute()) { $_SESSION['pesan_sukses'] = $pesan; } else { $_SESSION['pesan_error'] = "Database Error: " . $stmt->error; }
    $stmt->close(); header("Location: admin_materi.php"); exit();
}

// Proses Hapus (Delete)
if (isset($_GET['act']) && $_GET['act'] == 'hapus' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt_select = $conn->prepare("SELECT nama_file_pdf, gambar_materi FROM materi_detail WHERE id = ?");
    $stmt_select->bind_param("i", $id); $stmt_select->execute(); $result_select = $stmt_select->get_result();
    if ($row = $result_select->fetch_assoc()) {
        if (!empty($row['nama_file_pdf']) && file_exists($pdf_upload_dir . $row['nama_file_pdf'])) { unlink($pdf_upload_dir . $row['nama_file_pdf']); }
        if (!empty($row['gambar_materi']) && file_exists($gambar_upload_dir . $row['gambar_materi'])) { unlink($gambar_upload_dir . $row['gambar_materi']); }
    }
    $stmt_select->close();
    $stmt_delete = $conn->prepare("DELETE FROM materi_detail WHERE id = ?");
    $stmt_delete->bind_param("i", $id);
    if ($stmt_delete->execute()) { $_SESSION['pesan_sukses'] = "Materi berhasil dihapus."; } else { $_SESSION['pesan_error'] = "Gagal menghapus materi."; }
    $stmt_delete->close(); header("Location: admin_materi.php"); exit();
}

// Ambil pesan notifikasi
if(isset($_SESSION['pesan_sukses'])){ $pesan_sukses = $_SESSION['pesan_sukses']; unset($_SESSION['pesan_sukses']); }
if(isset($_SESSION['pesan_error'])){ $pesan_error = $_SESSION['pesan_error']; unset($_SESSION['pesan_error']); }
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Manajemen Materi Detail</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-green-50 text-gray-800 min-h-screen">
<div class="max-w-6xl mx-auto py-10 px-4">
    <h1 class="text-3xl font-bold text-green-700 text-center mb-8">Manajemen Materi Detail</h1>
    <?php if(!empty($pesan_sukses)): ?><div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert"><?= $pesan_sukses; ?></div><?php endif; ?>
    <?php if(!empty($pesan_error)): ?><div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert"><?= $pesan_error; ?></div><?php endif; ?>

    <?php
    $act = isset($_GET['act']) ? $_GET['act'] : 'list';
    switch ($act) {
        case 'tambah':
        case 'edit':
            $data = ['id' => '', 'sabuk' => '', 'judul' => '', 'anchor_id' => '', 'deskripsi' => '', 'video_url' => '', 'nama_file_pdf' => '', 'gambar_materi' => '', 'urutan' => 0];
            $form_title = "Tambah Materi Baru";
            if ($act == 'edit' && isset($_GET['id'])) {
                $form_title = "Edit Materi";
                $id = $_GET['id'];
                $stmt = $conn->prepare("SELECT * FROM materi_detail WHERE id = ?"); $stmt->bind_param("i", $id); $stmt->execute();
                $data = $stmt->get_result()->fetch_assoc(); $stmt->close();
            }
    ?>
            <div class="bg-white p-6 rounded-xl shadow-lg border border-green-200 mb-10">
                <h2 class="text-xl font-bold mb-4 text-green-700"><?= $form_title ?></h2>
                <form method="POST" action="admin_materi.php" enctype="multipart/form-data" class="space-y-5">
                    <input type="hidden" name="id" value="<?= htmlspecialchars($data['id']) ?>">
                    <input type="hidden" name="pdf_lama" value="<?= htmlspecialchars($data['nama_file_pdf']) ?>">
                    <input type="hidden" name="gambar_lama" value="<?= htmlspecialchars($data['gambar_materi']) ?>">
                    
                    <div><label for="judul" class="block font-semibold text-green-700 mb-1">Judul Materi</label><input type="text" id="judul" name="judul" value="<?= htmlspecialchars($data['judul']) ?>" required class="w-full border border-green-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-green-500 bg-green-50"/></div>
                    <div><label for="anchor_id" class="block font-semibold text-green-700 mb-1">Anchor ID</label><input type="text" id="anchor_id" name="anchor_id" value="<?= htmlspecialchars($data['anchor_id']) ?>" required class="w-full border border-green-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-green-500 bg-green-50"/><p class="text-xs text-gray-500 mt-1">Untuk link (cth: kuda-kuda-dasar). Harus unik, tanpa spasi.</p></div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div><label for="sabuk" class="block font-semibold text-green-700 mb-1">Tingkat Sabuk</label><select id="sabuk" name="sabuk" required class="w-full border border-green-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-green-500 bg-green-50"><?php $sabuk_options = ['putih', 'kuning', 'hijau', 'hitam', 'emas', 'merah']; foreach ($sabuk_options as $option) { $selected = ($data['sabuk'] == $option) ? 'selected' : ''; echo "<option value='$option' $selected>" . ucfirst($option) . "</option>"; } ?></select></div>
                        <div><label for="urutan" class="block font-semibold text-green-700 mb-1">Urutan Tampil</label><input type="number" id="urutan" name="urutan" value="<?= htmlspecialchars($data['urutan']) ?>" required class="w-full border border-green-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-green-500 bg-green-50"/></div>
                    </div>
                    <div><label for="video_url" class="block font-semibold text-green-700 mb-1">URL Embed Video (Opsional)</label><input type="text" id="video_url" name="video_url" value="<?= htmlspecialchars($data['video_url']) ?>" class="w-full border border-green-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-green-500 bg-green-50"/></div>

                    <div>
                        <label for="gambar_materi" class="block font-semibold text-green-700 mb-1">Upload Gambar Materi (Opsional)</label>
                        <input type="file" id="gambar_materi" name="gambar_materi" accept="image/jpeg, image/png, image/gif" class="w-full text-sm text-gray-700 border border-green-300 rounded-lg cursor-pointer bg-green-50 focus:outline-none focus:ring-2 focus:ring-green-500 p-2"/>
                        <?php if ($act == 'edit' && !empty($data['gambar_materi'])): ?>
                            <div class="mt-2">
                                <p class="text-xs text-green-600">Gambar saat ini:</p>
                                <img src="gambar_materi/<?= htmlspecialchars($data['gambar_materi']) ?>" alt="Gambar saat ini" class="mt-1 h-24 w-auto rounded">
                                <p class="text-xs text-gray-500 mt-1">Biarkan kosong jika tidak ingin mengganti gambar.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <div><label for="file_pdf" class="block font-semibold text-green-700 mb-1">Upload File PDF (Opsional)</label><input type="file" id="file_pdf" name="file_pdf" accept=".pdf" class="w-full text-sm text-gray-700 border border-green-300 rounded-lg cursor-pointer bg-green-50 focus:outline-none focus:ring-2 focus:ring-green-500 p-2"/><?php if ($act == 'edit' && !empty($data['nama_file_pdf'])): ?><p class="text-xs text-green-600 mt-1">File saat ini: <a href="materi_pdf/<?= htmlspecialchars($data['nama_file_pdf']) ?>" target="_blank" class="underline"><?= htmlspecialchars($data['nama_file_pdf']) ?></a>. Biarkan kosong jika tidak ingin ganti.</p><?php endif; ?></div>
                    
                    <div><label for="deskripsi" class="block font-semibold text-green-700 mb-1">Deskripsi Materi</label><textarea id="deskripsi" name="deskripsi" rows="10" class="w-full border border-green-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-green-500 bg-green-50"><?= htmlspecialchars($data['deskripsi']) ?></textarea></div>
                    <div class="flex gap-4"><button type="submit" name="submit" class="w-full bg-green-600 text-white py-2 rounded-lg font-semibold hover:bg-green-700 transition duration-200 shadow">Simpan Materi</button><a href="admin_materi.php" class="w-full text-center bg-gray-200 text-gray-800 py-2 rounded-lg font-semibold hover:bg-gray-300 transition duration-200 shadow">Batal</a></div>
                </form>
            </div>
    <?php
            break;
        default: // list
    ?>
            <div class="bg-white p-4 sm:p-6 rounded-xl shadow-lg border border-green-200">
                <div class="flex justify-between items-center mb-4"><h2 class="text-xl font-bold text-green-700">Daftar Materi Detail</h2><a href="?act=tambah" class="bg-green-600 text-white py-2 px-4 rounded-lg font-semibold hover:bg-green-700 transition duration-200 shadow">+ Tambah Materi</a></div>
                <div class="overflow-x-auto"><table class="min-w-full text-sm border border-green-200"><thead class="bg-green-100 text-green-900 font-semibold"><tr><th class="py-2 px-4 border-b border-green-200">Judul</th><th class="py-2 px-4 border-b border-green-200">Sabuk</th><th class="py-2 px-4 border-b border-green-200">Gambar</th><th class="py-2 px-4 border-b border-green-200">PDF</th><th class="py-2 px-4 border-b border-green-200">Aksi</th></tr></thead>
                <tbody class="text-center"><?php $sql = "SELECT id, judul, sabuk, urutan, nama_file_pdf, gambar_materi FROM materi_detail ORDER BY sabuk, urutan ASC"; $result = $conn->query($sql); if ($result->num_rows > 0) { while ($row = $result->fetch_assoc()) { ?>
                <tr class='hover:bg-green-50 transition'><td class='py-2 px-4 border-b text-left'><?= htmlspecialchars($row['judul']); ?></td><td class='py-2 px-4 border-b'><span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-200 text-green-800"><?= ucfirst(htmlspecialchars($row['sabuk'])); ?></span></td><td class='py-2 px-4 border-b'><?= !empty($row['gambar_materi']) ? '✔️' : '❌'; ?></td><td class='py-2 px-4 border-b'><?= !empty($row['nama_file_pdf']) ? '✔️' : '❌'; ?></td><td class='py-2 px-4 border-b space-x-2'><a href="?act=edit&id=<?= $row['id']; ?>" class='bg-yellow-500 text-white px-3 py-1 rounded-md hover:bg-yellow-600 transition text-xs font-semibold'>Edit</a><a href="?act=hapus&id=<?= $row['id']; ?>" class='bg-red-500 text-white px-3 py-1 rounded-md hover:bg-red-600 transition text-xs font-semibold' onclick="return confirm('Anda yakin ingin menghapus materi ini beserta semua filenya?')">Hapus</a></td></tr>
                <?php } } else { echo "<tr><td colspan='5' class='text-center py-4'>Belum ada materi. Silakan tambahkan materi baru.</td></tr>"; } ?>
                </tbody></table></div></div>
    <?php break; } ?>
</div>
<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>tinymce.init({ selector: '#deskripsi', plugins: 'lists link autolink', toolbar: 'undo redo | bold italic | bullist numlist | link', menubar: false });</script>
</body>
</html>