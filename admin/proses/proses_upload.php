<?php
include '../../koneksi/koneksi.php';  // Pastikan path koneksi sesuai

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['banner_image']) && $_FILES['banner_image']['error'] === 0) {
        $allowed_types = ['image/jpeg', 'image/png', 'image/webp'];
        $file_type = $_FILES['banner_image']['type'];

        if (in_array($file_type, $allowed_types)) {
            $upload_dir = __DIR__ . '/../uploads/';  // path fisik ke folder uploads
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0755, true);
            }
            $file_name = uniqid() . '-' . basename($_FILES['banner_image']['name']);
            $target_file = $upload_dir . $file_name;

            if (move_uploaded_file($_FILES['banner_image']['tmp_name'], $target_file)) {
                // Update nama file banner di database
                $sql = "UPDATE settings SET banner_image = ? WHERE id = 1";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('s', $file_name);

                if ($stmt->execute()) {
                    $message = "Gambar banner berhasil diupload dan disimpan.";
                } else {
                    $message = "Gagal menyimpan data ke database.";
                }
                $stmt->close();
            } else {
                $message = "Gagal mengupload file ke server.";
            }
        } else {
            $message = "Tipe file tidak diperbolehkan. Hanya JPG, PNG, dan WEBP.";
        }
    } else {
        $message = "Tidak ada file yang diupload atau terjadi error.";
    }
} else {
    $message = "Metode request harus POST.";
}

$conn->close();

// Redirect kembali ke index.php (atau admin_banner.php) dengan pesan
header("Location: ../admin_banner.php?msg=" . urlencode($message));
exit;
?>
