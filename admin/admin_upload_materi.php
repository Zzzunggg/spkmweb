<?php include 'proses/auth_admin.php';?>
<?php
include '../koneksi/koneksi.php';
include 'header.php';

// Handle Upload
if (isset($_POST['upload'])) {
    $judul = mysqli_real_escape_string($conn, $_POST['judul']);
    $file = $_FILES['file']['name'];
    $tmp = $_FILES['file']['tmp_name'];
    $folder = "../uploads/";

    $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
    $allowed = ['pdf'];

    if (in_array($ext, $allowed)) {
        if (!is_dir($folder)) {
            mkdir($folder, 0777, true);
        }

        $newname = uniqid('materi_', true) . '.' . $ext;
        if (move_uploaded_file($tmp, $folder . $newname)) {
            $query = "INSERT INTO materi (judul, nama_file) VALUES ('$judul', '$newname')";
            if (mysqli_query($conn, $query)) {
                echo "<script>alert('Upload berhasil.'); window.location.href='admin_upload_materi.php';</script>";
            } else {
                echo "Gagal menyimpan ke database: " . mysqli_error($conn);
            }
        } else {
            echo "Gagal memindahkan file.";
        }
    } else {
        echo "Hanya file PDF yang diperbolehkan.";
    }
}

// Ambil data materi
$result = mysqli_query($conn, "SELECT * FROM materi ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Upload Materi PDF</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-green-50 text-gray-800 min-h-screen">

<div class="max-w-3xl mx-auto py-10 px-4">
    <h1 class="text-3xl font-bold text-green-700 text-center mb-8">Upload Materi PDF</h1>

    <!-- Upload Form -->
    <div class="bg-white p-6 rounded-xl shadow-lg border border-green-200 mb-10">
        <form action="" method="POST" enctype="multipart/form-data" class="space-y-5">
            <div>
                <label for="judul" class="block font-semibold text-green-700 mb-1">Judul Materi</label>
                <input type="text" name="judul" id="judul" required
                       class="w-full border border-green-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-green-500 bg-green-50"/>
            </div>

            <div>
                <label for="file" class="block font-semibold text-green-700 mb-1">Pilih File PDF</label>
                <input type="file" name="file" id="file" accept=".pdf" required
                       class="w-full text-sm text-gray-700 border border-green-300 rounded-lg cursor-pointer bg-green-50 focus:outline-none focus:ring-2 focus:ring-green-500 p-2"/>
                <p class="text-xs text-gray-500 mt-1">Hanya file PDF. Maksimal 2MB.</p>
            </div>

            <button type="submit" name="upload"
                    class="w-full bg-green-600 text-white py-2 rounded-lg font-semibold hover:bg-green-700 transition duration-200 shadow">
                Upload PDF Materi
            </button>
        </form>
    </div>

    <!-- Tabel Materi -->
    <div class="bg-white p-4 rounded-xl shadow-lg border border-green-200">
        <h2 class="text-xl font-bold mb-4 text-green-700">Daftar Materi</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm border border-green-200">
                <thead class="bg-green-100 text-green-900 font-semibold">
                    <tr>
                        <th class="py-2 px-4 border-b border-green-200">No</th>
                        <th class="py-2 px-4 border-b border-green-200">Judul</th>
                        <th class="py-2 px-4 border-b border-green-200">Lihat</th>
                        <th class="py-2 px-4 border-b border-green-200">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    <?php
                    $no = 1;
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr class='hover:bg-green-50 transition'>
                            <td class='py-2 px-4 border-b'>{$no}</td>
                            <td class='py-2 px-4 border-b'>{$row['judul']}</td>
                            <td class='py-2 px-4 border-b'>
                                <a class='bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 transition' 
                                   href='../uploads/{$row['nama_file']}' target='_blank'>Lihat</a>
                            </td>
                            <td class='py-2 px-4 border-b'>
                                <a class='bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 transition' 
                                   href='proses/hapus_materi.php?id={$row['id']}'
                                   onclick=\"return confirm('Yakin ingin menghapus materi ini?')\">Hapus</a>
                            </td>
                        </tr>";
                        $no++;
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>
