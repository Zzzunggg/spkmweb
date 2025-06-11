<?php include 'proses/auth_admin.php';?>
<?php
ob_start();           // Mulai output buffering supaya header() bisa dipanggil kapan saja
session_start();

include '../koneksi/koneksi.php';  // koneksi database

$uploadDir = 'uploads/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

$errorMsg = '';

// Proses tambah / update
if (isset($_POST['submit'])) {
    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
    $nama = trim($_POST['nama']);
    $deskripsi = trim($_POST['deskripsi']);

    if ($nama === '') {
        $errorMsg = 'Nama prestasi wajib diisi.';
    }

    $foto = null;
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $tmpName = $_FILES['foto']['tmp_name'];
        $ext = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg','jpeg','png','gif','webp'];
        if (!in_array($ext, $allowed)) {
            $errorMsg = "Format foto tidak didukung. Gunakan jpg, jpeg, png, gif, atau webp.";
        } else {
            $fotoName = time() . '_' . bin2hex(random_bytes(5)) . '.' . $ext;
            $targetFile = $uploadDir . $fotoName;
            if (move_uploaded_file($tmpName, $targetFile)) {
                $foto = $fotoName;
            } else {
                $errorMsg = "Gagal upload file foto.";
            }
        }
    }

    if (!$errorMsg) {
        if ($id > 0) {
            if ($foto) {
                $stmtOld = $conn->prepare("SELECT foto FROM prestasi WHERE id=?");
                $stmtOld->bind_param("i", $id);
                $stmtOld->execute();
                $resOld = $stmtOld->get_result();
                if ($resOld && $resOld->num_rows > 0) {
                    $rowOld = $resOld->fetch_assoc();
                    if ($rowOld['foto'] && file_exists($uploadDir . $rowOld['foto'])) {
                        unlink($uploadDir . $rowOld['foto']);
                    }
                }
                $stmtOld->close();

                $stmt = $conn->prepare("UPDATE prestasi SET nama=?, deskripsi=?, foto=? WHERE id=?");
                $stmt->bind_param("sssi", $nama, $deskripsi, $foto, $id);
            } else {
                $stmt = $conn->prepare("UPDATE prestasi SET nama=?, deskripsi=? WHERE id=?");
                $stmt->bind_param("ssi", $nama, $deskripsi, $id);
            }
            $stmt->execute();
            $stmt->close();
        } else {
            $stmt = $conn->prepare("INSERT INTO prestasi (nama, deskripsi, foto, tanggal_upload) VALUES (?, ?, ?, NOW())");
            $stmt->bind_param("sss", $nama, $deskripsi, $foto);
            $stmt->execute();
            $stmt->close();
        }
        header("Location: prestasi.php");
        exit();
    }
}

// proses hapus
if (isset($_GET['hapus'])) {
    $id = (int)$_GET['hapus'];

    $stmt = $conn->prepare("SELECT foto FROM prestasi WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($res && $res->num_rows > 0) {
        $row = $res->fetch_assoc();
        if ($row['foto'] && file_exists($uploadDir . $row['foto'])) {
            unlink($uploadDir . $row['foto']);
        }
    }
    $stmt->close();

    $stmtDel = $conn->prepare("DELETE FROM prestasi WHERE id=?");
    $stmtDel->bind_param("i", $id);
    $stmtDel->execute();
    $stmtDel->close();

    header("Location: prestasi.php");
    exit();
}

// ambil data untuk edit
$editData = null;
if (isset($_GET['edit'])) {
    $id = (int)$_GET['edit'];
    $stmt = $conn->prepare("SELECT * FROM prestasi WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($res && $res->num_rows > 0) {
        $editData = $res->fetch_assoc();
    }
    $stmt->close();
}

// ambil semua data prestasi
$data = $conn->query("SELECT * FROM prestasi ORDER BY tanggal_upload DESC");

// Panggil header setelah semua proses logic selesai, agar tidak ada output sebelum header()
include 'header.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title>Kelola Prestasi</title>
    <style>
        /* Reset & basic */
        * {
            box-sizing: border-box;
        }
        h1, h2 {
            text-align: center;
        
        }
        form {
            background: #fff;
            padding: 20px;
            max-width: 500px;
            margin: 15px auto 30px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            border-radius: 6px;
        }
        label {
            display: block;
            margin-bottom: 6px;
            font-weight: 600;
        }
        input[type="text"], textarea, input[type="file"] {
            width: 100%;
            padding: 8px 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 1rem;
            transition: border-color 0.3s;
        }
        input[type="text"]:focus, textarea:focus, input[type="file"]:focus {
            border-color: #2c6b2f;
            outline: none;
        }
        textarea {
            resize: vertical;
            min-height: 80px;
            font-family: inherit;
        }
        button[type="submit"] {
            background-color: #2c6b2f;
            color: white;
            padding: 10px 18px;
            border: none;
            border-radius: 5px;
            font-size: 1.1rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        button[type="submit"]:hover {
            background-color: #2c6b2f;
        }

        a:hover {
            text-decoration: underline;
        }
        .error-message {
            color: #e74c3c;
            font-weight: bold;
            margin-bottom: 20px;
            text-align: center;
        }
        .prestasi-list {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }
        .prestasi-item {
            background: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            width: 220px;
            padding: 12px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.05);
            display: flex;
            flex-direction: column;
            align-items: center;
            transition: box-shadow 0.3s;
        }
        .prestasi-item:hover {
            box-shadow: 0 4px 14px rgba(0,0,0,0.1);
        }
        .prestasi-item img {
            max-width: 100%;
            height: auto;
            border-radius: 6px;
            margin-bottom: 12px;
            object-fit: cover;
        }
        .prestasi-item h3 {
            margin: 0 0 8px;
            font-size: 1.1rem;
            text-align: center;
            color: #2c3e50;
            min-height: 48px;
        }
        .prestasi-item p {
            font-size: 0.9rem;
            color: #555;
            white-space: pre-line;
            flex-grow: 1;
            text-align: center;
            margin-bottom: 10px;
        }
        .prestasi-item small {
            color: #888;
            font-size: 0.8rem;
            margin-bottom: 10px;
            display: block;
        }
        .prestasi-item .actions {
            margin-top: auto;
        }
        .prestasi-item .actions a {
            margin: 0 5px;
            font-size: 0.9rem;
            color: #2c6b2f;
            cursor: pointer;
        }
        .prestasi-item .actions a.delete {
            color: #e74c3c;
        }
        .prestasi-item .actions a:hover {
            text-decoration: underline;
        }
        /* Responsive */
        @media (max-width: 600px) {
            .prestasi-item {
                width: 100%;
                max-width: 320px;
            }
            form {
                width: 90%;
            }
        }
    </style>
</head>
<body>

<?php if ($errorMsg): ?>
    <div class="error-message"><?= htmlspecialchars($errorMsg) ?></div>
<?php endif; ?>

<form method="post" enctype="multipart/form-data" autocomplete="off">
    <input type="hidden" name="id" value="<?= $editData ? (int)$editData['id'] : '' ?>" />

    <label for="nama">Nama Prestasi</label>
    <input type="text" id="nama" name="nama" required value="<?= $editData ? htmlspecialchars($editData['nama']) : '' ?>" />

    <label for="deskripsi">Deskripsi</label>
    <textarea id="deskripsi" name="deskripsi" rows="4"><?= $editData ? htmlspecialchars($editData['deskripsi']) : '' ?></textarea>

    <label for="foto">Foto Prestasi <?= $editData ? '(kosongkan jika tidak ingin ganti)' : '' ?></label>
    <input type="file" id="foto" name="foto" accept="image/*" />

    <button type="submit" name="submit"><?= $editData ? 'Update Prestasi' : 'Tambah Prestasi' ?></button>
    <?php if ($editData): ?>
        <a href="prestasi.php" style="margin-left:10px;">Batal</a>
    <?php endif; ?>
</form>

<h2>Daftar Prestasi</h2>
<br>
<div class="prestasi-list">
<?php if ($data && $data->num_rows > 0): ?>
    <?php while ($row = $data->fetch_assoc()): ?>
        <div class="prestasi-item">
            <?php if ($row['foto'] && file_exists($uploadDir . $row['foto'])): ?>
                <img src="<?= htmlspecialchars($uploadDir . $row['foto']) ?>" alt="<?= htmlspecialchars($row['nama']) ?>" />
            <?php else: ?>
                <img src="https://via.placeholder.com/220x150?text=No+Image" alt="No Image" />
            <?php endif; ?>
            <h3><?= htmlspecialchars($row['nama']) ?></h3>
            <p><?= nl2br(htmlspecialchars($row['deskripsi'])) ?></p>
            <small>Upload: <?= date('d M Y, H:i', strtotime($row['tanggal_upload'])) ?></small>
            <div class="actions">
                <a href="prestasi.php?edit=<?= $row['id'] ?>">Edit</a>
                <a href="prestasi.php?hapus=<?= $row['id'] ?>" class="delete" onclick="return confirm('Yakin ingin menghapus prestasi ini?')">Hapus</a>
            </div>
        </div>
    <?php endwhile; ?>
<?php else: ?>
    <p style="text-align:center; color:#666;">Tidak ada data prestasi.</p>
<?php endif; ?>
</div>
<br>
</body>
</html>

<?php
ob_end_flush();  // Kirim output buffer ke browser
