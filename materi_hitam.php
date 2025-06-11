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
    <title>Materi Sabuk Hitam - Pencak Silat</title>
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
        <b>MATERI SABUK HITAM</b>
        <p>Penguasaan teknik tingkat tinggi yang berfokus pada melumpuhkan lawan, meliputi kuncian, jatuhan, dan pengenalan senjata tradisional.</p>
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
        <h1>Daftar Materi Sabuk Hitam</h1>
        <p>Pada tingkat ini, pesilat dianggap matang dalam teknik dasar dan siap mempelajari aplikasi pertarungan jarak dekat yang lebih kompleks.</p>

        <section id="teknik-kuncian">
            <h2>1. Teknik Kuncian Dasar</h2>
            <p>Cara mengontrol dan melumpuhkan lawan tanpa harus mencederai secara fatal. Materi ini mencakup kuncian pada sendi pergelangan tangan, siku, dan bahu.</p>
            <div class="video-responsive-container">
                <iframe src="URL_VIDEO_KUNCIAN" title="Video Pembelajaran Teknik Kuncian" allowfullscreen></iframe>
            </div>
        </section>

        <section id="teknik-jatuhan">
            <h2>2. Teknik Jatuhan dan Bantingan</h2>
            <p>Cara merusak keseimbangan lawan dan menjatuhkannya ke tanah. Termasuk teknik sapuan (bawah) dan bantingan (atas) yang memerlukan timing dan teknik yang tepat.</p>
            <div class="video-responsive-container">
                <iframe src="URL_VIDEO_JATUHAN" title="Video Pembelajaran Teknik Jatuhan" allowfullscreen></iframe>
            </div>
        </section>
        
        <section id="jurus-senjata">
            <h2>3. Dasar Jurus Senjata (Golok/Toya)</h2>
            <p>Pengenalan senjata tradisional pencak silat. Materi ini mengajarkan cara memegang, kuda-kuda dengan senjata, serta gerakan dasar serangan dan pertahanan menggunakan golok atau toya.</p>
            <div class="video-responsive-container">
                <iframe src="URL_VIDEO_SENJATA" title="Video Pembelajaran Jurus Senjata" allowfullscreen></iframe>
            </div>
        </section>

    </article>
</div>

<?php include 'footer.php'; ?>
<script src="script_materi.js"></script>
</body>
</html>