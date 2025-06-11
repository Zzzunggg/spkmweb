<?php
include 'koneksi/koneksi.php';
include 'header.php';

$sql = "SELECT banner_image FROM settings WHERE id = 1 LIMIT 1";
$result = $conn->query($sql);
$bannerImage = 'default-banner.jpg';
if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if (!empty($row['banner_image'])) {
        $bannerImage = $row['banner_image'];
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Materi Sabuk Kuning Emas - Pencak Silat</title>
    <link rel="stylesheet" href="style-materi.css">
    <style>
        .banner {
            --banner-bg-url: url('admin/uploads/<?= htmlspecialchars($bannerImage) ?>');
        }
    </style>
</head>
<body>

<section class="banner" role="banner">
    <div>
        <b>MATERI SABUK KUNING EMAS</b>
        <p>Tingkat master yang mendalami aplikasi kuncian, cara melepaskan diri, dan penguasaan jurus tingkat tinggi.</p>
    </div>
</section>

<div class="container">
    <aside class="sidebar" role="navigation" aria-label="Navigasi Materi">
        <?php include 'menu_materi.php'; ?>
        
        <section class="box-download" aria-label="Download Materi Terbaru">
            <h4>Unduh Materi Terbaru</h4>
            <?php
            $materi = mysqli_query($conn, "SELECT * FROM materi ORDER BY id DESC LIMIT 1");
            if (mysqli_num_rows($materi) > 0) {
                $m = mysqli_fetch_assoc($materi);
                echo '<p>' . htmlspecialchars($m['judul']) . '</p>';
                echo '<a href="../uploads/' . htmlspecialchars($m['nama_file']) . '" class="btn-download" download>📄 Unduh PDF</a>';
            } else {
                echo "<p>Belum ada file tersedia.</p>";
            }
            ?>
        </section>
    </aside>

    <article class="content" role="main">
        <h1>Daftar Materi Sabuk Kuning Emas</h1>
        <p>Di level ini, pemahaman tentang anatomi dan titik lemah menjadi kunci dalam mengaplikasikan dan melawan teknik kuncian.</p>

        <section id="kuncian-lanjutan">
            <h2>1. Kuncian Lanjutan</h2>
            <p>Pengembangan dari kuncian dasar, meliputi kuncian sambil bergerak, kuncian pada leher, dan kuncian yang mengarah pada pitingan (submission) yang lebih kompleks.</p>
            <div class="video-responsive-container">
                <iframe src="URL_VIDEO_KUNCIAN_LANJUTAN" title="Video Pembelajaran Kuncian Lanjutan" allowfullscreen></iframe>
            </div>
        </section>

        <section id="pemecahan-kuncian">
            <h2>2. Teknik Pemecahan Kuncian</h2>
            <p>Ilmu untuk melepaskan diri dari kuncian lawan (counter-locking). Mempelajari cara memutar sendi dan menggunakan berat badan untuk keluar dari posisi terkunci.</p>
            <div class="video-responsive-container">
                <iframe src="URL_VIDEO_PECAH_KUNCIAN" title="Video Pembelajaran Pemecahan Kuncian" allowfullscreen></iframe>
            </div>
        </section>
        
        <section id="jurus-master">
            <h2>3. Jurus Master Tangan Kosong</h2>
            <p>Jurus tingkat tinggi yang gerakannya lebih kompleks, cepat, dan membutuhkan pemahaman mendalam tentang setiap detail aplikasi pertarungannya.</p>
            <div class="video-responsive-container">
                <iframe src="URL_VIDEO_JURUS_MASTER" title="Video Pembelajaran Jurus Master" allowfullscreen></iframe>
            </div>
        </section>

    </article>
</div>

<?php include 'footer.php'; ?>
<script src="script_materi.js"></script>
</body>
</html>