<?php
include '../koneksi/koneksi.php';
include 'header.php';

// Ambil pesan dari URL jika ada (hasil upload)
$message = '';
if (isset($_GET['msg'])) {
    $message = $_GET['msg'];
}

// Ambil gambar banner saat ini dari database
$sql = "SELECT banner_image FROM settings WHERE id = 1";
$result = $conn->query($sql);
$currentImage = 'default-banner.jpg';
if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if (!empty($row['banner_image'])) {
        $currentImage = $row['banner_image'];
    }
}

$conn->close();
?>

<div class="flex items-center justify-center min-h-screen bg-green-50 py-10 px-4">
  <div class="max-w-xl w-full bg-white p-8 rounded-2xl shadow-xl border border-green-200">
    <h2 class="text-3xl font-bold text-center text-green-700 mb-6">Ganti Gambar Banner</h2>

    <?php if ($message): ?>
      <div class="mb-4 p-4 bg-green-100 text-green-800 border border-green-300 rounded-lg text-center font-medium">
        <?php echo htmlspecialchars($message); ?>
      </div>
    <?php endif; ?>

    <div class="mb-6 text-center">
      <p class="text-gray-600">Gambar banner saat ini:</p>
      <div class="mt-3 rounded overflow-hidden shadow-lg border border-green-200">
        <img src="uploads/<?php echo htmlspecialchars($currentImage); ?>" alt="Banner Saat Ini" class="w-full max-h-64 object-cover" />
      </div>
    </div>

    <form action="proses/proses_upload.php" method="POST" enctype="multipart/form-data" class="space-y-4">
      <div>
        <label class="block text-sm font-medium text-green-700 mb-1">Pilih Gambar Baru</label>
        <input type="file" name="banner_image" accept=".jpg,.jpeg,.png,.webp" required 
               class="block w-full text-sm text-gray-700 border border-green-300 rounded-lg cursor-pointer bg-green-50 focus:outline-none focus:ring-2 focus:ring-green-500 p-2" />
        <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG, atau WEBP. Maksimal 2MB.</p>
      </div>

      <button type="submit" 
              class="w-full bg-green-600 text-white font-semibold px-4 py-2 rounded-lg hover:bg-green-700 transition duration-200 shadow-md">
        Upload dan Simpan
      </button>
    </form>
  </div>
</div>
