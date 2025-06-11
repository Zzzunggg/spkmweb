<?php include 'proses/auth_admin.php';?>
<?php
include '../koneksi/koneksi.php';

$errors = [];
$success = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = trim($_POST['nama']);
    $jabatan = trim($_POST['jabatan']);
    $sambutan_text = trim($_POST['sambutan']);

    if (empty($nama)) $errors[] = "Nama harus diisi.";
    if (empty($jabatan)) $errors[] = "Jabatan harus diisi.";
    if (empty($sambutan_text)) $errors[] = "Sambutan harus diisi.";

    if (!isset($_FILES['foto']) || $_FILES['foto']['error'] !== UPLOAD_ERR_OK) {
        $errors[] = "Foto ketua umum wajib diupload.";
    } else {
        $foto_tmp = $_FILES['foto']['tmp_name'];
        $foto_name = basename($_FILES['foto']['name']);
        $foto_ext = strtolower(pathinfo($foto_name, PATHINFO_EXTENSION));
        $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];

        if (!in_array($foto_ext, $allowed_ext)) {
            $errors[] = "Format foto harus jpg, jpeg, png, atau gif.";
        }
    }

    if (empty($errors)) {
        $upload_dir = '../uploads/sambutan/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }

        $new_foto_name = uniqid('foto_') . '.' . $foto_ext;

        if (move_uploaded_file($foto_tmp, $upload_dir . $new_foto_name)) {
            $stmt = $conn->prepare("INSERT INTO sambutan (nama, jabatan, foto, sambutan) VALUES (?, ?, ?, ?)");
            if (!$stmt) {
                die("Prepare failed: " . $conn->error);
            }

            $stmt->bind_param("ssss", $nama, $jabatan, $new_foto_name, $sambutan_text);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                header("Location: upload_sambutan.php");
                exit;
            } else {
                $errors[] = "Gagal menyimpan data ke database.";
            }

            $stmt->close();
        } else {
            $errors[] = "Gagal mengupload file foto.";
        }
    }
}

include 'header.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Upload Sambutan Ketua Umum</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-green-50 min-h-screen p-6">

    <div class="max-w-2xl mx-auto bg-white rounded-xl shadow-md p-8 mt-8">
        <h2 class="text-2xl font-bold text-green-800 mb-6 text-center">Upload Sambutan Ketua Umum</h2>

        <?php if ($errors): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul class="list-disc pl-5">
                    <?php foreach ($errors as $err): ?>
                        <li><?= htmlspecialchars($err) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="" method="post" enctype="multipart/form-data" class="space-y-5">
            <div>
                <label for="nama" class="block text-green-700 font-medium">Nama Ketua Umum</label>
                <input type="text" id="nama" name="nama" required class="w-full mt-1 p-3 border rounded-lg focus:ring focus:ring-green-300" value="<?= isset($nama) ? htmlspecialchars($nama) : '' ?>">
            </div>

            <div>
                <label for="jabatan" class="block text-green-700 font-medium">Jabatan</label>
                <input type="text" id="jabatan" name="jabatan" required class="w-full mt-1 p-3 border rounded-lg focus:ring focus:ring-green-300" value="<?= isset($jabatan) ? htmlspecialchars($jabatan) : '' ?>">
            </div>

            <div>
                <label for="foto" class="block text-green-700 font-medium">Foto Ketua Umum</label>
                <input type="file" id="foto" name="foto" accept="image/*" required class="w-full mt-1 p-2 bg-white border rounded-lg file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-green-100 file:text-green-700 hover:file:bg-green-200">
            </div>

            <div>
                <label for="sambutan" class="block text-green-700 font-medium">Isi Sambutan</label>
                <textarea id="sambutan" name="sambutan" rows="6" required class="w-full mt-1 p-3 border rounded-lg focus:ring focus:ring-green-300"><?= isset($sambutan_text) ? htmlspecialchars($sambutan_text) : '' ?></textarea>
            </div>

            <button type="submit" class="w-full bg-green-700 text-white py-3 rounded-lg hover:bg-green-800 transition duration-200">
                Upload Sambutan
            </button>
        </form>
    </div>

</body>
</html>
