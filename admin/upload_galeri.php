<?php include 'proses/auth_admin.php';?>

<?php
include '../koneksi/koneksi.php';
include 'header.php';

$errors = [];
$success = "";

// ======================
// Proses hapus gambar
// ======================
if (isset($_GET['hapus_id'])) {
    $hapus_id = intval($_GET['hapus_id']);

    $stmt = $conn->prepare("SELECT gambar FROM galeri WHERE id = ?");
    $stmt->bind_param("i", $hapus_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $file_to_delete = 'uploads/galeri/' . $row['gambar'];

        if (file_exists($file_to_delete)) {
            unlink($file_to_delete);
        }

        $stmt_del = $conn->prepare("DELETE FROM galeri WHERE id = ?");
        $stmt_del->bind_param("i", $hapus_id);
        $stmt_del->execute();
        $stmt_del->close();

        header("Location: " . strtok($_SERVER["REQUEST_URI"], '?'));
        exit();
    }
    $stmt->close();
}

// ======================
// Proses upload gambar
// ======================
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_FILES['gambar']) || $_FILES['gambar']['error'] !== UPLOAD_ERR_OK) {
        $errors[] = "Gambar wajib diupload.";
    } else {
        $file_tmp = $_FILES['gambar']['tmp_name'];
        $file_name = basename($_FILES['gambar']['name']);
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];

        if (!in_array($file_ext, $allowed_ext)) {
            $errors[] = "Format gambar harus jpg, jpeg, png, atau gif.";
        }
    }

    $caption = isset($_POST['caption']) ? trim($_POST['caption']) : '';

    if (empty($errors)) {
        $upload_dir = 'uploads/galeri/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }

        $new_file_name = uniqid('galeri_') . '.' . $file_ext;

        if (move_uploaded_file($file_tmp, $upload_dir . $new_file_name)) {
            $stmt = $conn->prepare("INSERT INTO galeri (gambar, caption, created_at) VALUES (?, ?, NOW())");
            if (!$stmt) {
                die("Prepare failed: " . $conn->error);
            }

            $stmt->bind_param("ss", $new_file_name, $caption);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                $success = "Gambar berhasil diupload.";
            } else {
                $errors[] = "Gagal menyimpan data ke database.";
                unlink($upload_dir . $new_file_name);
            }
            $stmt->close();
        } else {
            $errors[] = "Gagal mengupload file gambar.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title>Upload Galeri Gambar</title>
    <style>
        .container {
            max-width: 700px;
            margin: auto;
            background: white;
            padding: 25px 30px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            color: #2e7d32;
            margin-bottom: 25px;
        }
        label {
            display: block;
            margin-top: 15px;
            font-weight: 600;
            color: #333;
        }
        input[type="file"], input[type="text"] {
            width: 100%;
            padding: 10px 12px;
            margin-top: 6px;
            border-radius: 6px;
            border: 1px solid #ccc;
            font-size: 1rem;
            transition: border-color 0.3s;
        }
        input[type="file"]:focus, input[type="text"]:focus {
            border-color: #2e7d32;
            outline: none;
        }
        button {
            background: #2e7d32;
            color: white;
            border: none;
            padding: 14px;
            border-radius: 8px;
            margin-top: 25px;
            width: 100%;
            cursor: pointer;
            font-size: 1.1rem;
            font-weight: 600;
            transition: background-color 0.3s;
        }
        button:hover {
            background: #1b5e20;
        }
        .error, .success {
            border-radius: 8px;
            padding: 15px 18px;
            margin-top: 20px;
            font-weight: 600;
            box-sizing: border-box;
        }
        .error {
            background: #fdecea;
            border: 1px solid #f5c6cb;
            color: #a94442;
        }
        .success {
            background: #e6f4ea;
            border: 1px solid #c3e6cb;
            color: #2e7d32;
        }
        /* Tabel */
        h3 {
            margin-top: 40px;
            color: #2e7d32;
            border-bottom: 2px solid #2e7d32;
            padding-bottom: 6px;
            font-weight: 700;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        table thead {
            background: #d0f0d0;
        }
        table thead th {
            padding: 12px 15px;
            font-weight: 700;
            color: #2e7d32;
            border-bottom: 2px solid #2e7d32;
            text-align: left;
        }
        table tbody td {
            padding: 12px 15px;
            border-bottom: 1px solid #ddd;
            vertical-align: middle;
            color: #444;
        }
        table tbody tr:hover {
            background: #f3f9f3;
        }
        img.thumb {
            max-width: 120px;
            max-height: 90px;
            border-radius: 8px;
            box-shadow: 0 0 8px rgba(0,0,0,0.1);
            object-fit: cover;
        }
        a.hapus-btn {
            background: #d9534f;
            color: white;
            padding: 6px 14px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 600;
            transition: background-color 0.3s;
            display: inline-block;
        }
        a.hapus-btn:hover {
            background: #b52b27;
        }
    </style>
</head>
<body>
<br>
<br>
<div class="container">

    <?php if ($errors): ?>
        <div class="error">
            <ul style="margin: 0; padding-left: 20px;">
                <?php foreach ($errors as $err): ?>
                    <li><?= htmlspecialchars($err) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php elseif ($success): ?>
        <div class="success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <form action="" method="post" enctype="multipart/form-data" novalidate>
        <label for="gambar">Pilih Gambar:</label>
        <input type="file" name="gambar" id="gambar" accept="image/*" required>

        <label for="caption">Caption (opsional):</label>
        <input type="text" name="caption" id="caption" placeholder="Deskripsi singkat gambar">

        <button type="submit">Upload Gambar</button>
    </form>

    <?php
    // Ambil data galeri dari DB
    $result = $conn->query("SELECT * FROM galeri ORDER BY created_at DESC");
    ?>

    <h3>Daftar Gambar Galeri</h3>
    <table>
        <thead>
            <tr>
                <th style="width:5%;">No</th>
                <th style="width:25%;">Gambar</th>
                <th style="width:35%;">Caption</th>
                <th style="width:20%;">Tanggal Upload</th>
                <th style="width:15%;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result && $result->num_rows > 0): ?>
                <?php $no = 1; ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><img class="thumb" src="uploads/galeri/<?= htmlspecialchars($row['gambar']) ?>" alt="gambar"></td>
                        <td><?= htmlspecialchars($row['caption']) ?: '-' ?></td>
                        <td><?= htmlspecialchars($row['created_at']) ?></td>
                        <td>
                            <a href="?hapus_id=<?= $row['id'] ?>" 
                               onclick="return confirm('Yakin ingin menghapus gambar ini?');" 
                               class="hapus-btn">Hapus</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" style="text-align:center; padding: 25px 0; color:#777;">Belum ada gambar yang diupload.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>
