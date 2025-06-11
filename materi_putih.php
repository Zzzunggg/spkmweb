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
    <title>Materi Sabuk Putih - Pencak Silat</title>
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
        <b>MATERI SABUK PUTIH</b>
        <p>Fondasi dasar pencak silat, meliputi kuda-kuda, tangkisan, dan pola langkah sebagai dasar gerakan selanjutnya.</p>
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
        <h1>Daftar Materi Sabuk Putih</h1>
        <p>Pada tingkat ini, pesilat akan mempelajari dasar-dasar yang paling fundamental untuk membangun postur, keseimbangan, dan koordinasi yang kuat.</p>

        <section id="kuda-kuda-dasar">
            <h2>1. Kuda-Kuda Dasar</h2>
            <p>Penjelasan mendalam tentang berbagai jenis kuda-kuda dasar (depan, belakang, tengah, samping) dan fungsinya untuk menjaga keseimbangan dan kekuatan.</p>
            <ul>
                <li><strong>Kuda-Kuda Depan:</strong> Fokus pada kekuatan tumpuan kaki depan.</li>
                <li><strong>Kuda-Kuda Belakang:</strong> Digunakan untuk pertahanan dan persiapan serangan balik.</li>
                <li><strong>Kuda-Kuda Tengah:</strong> Memberikan stabilitas maksimal.</li>
            </ul>
            <div class="video-responsive-container">
                <iframe src="URL_VIDEO_KUDA_KUDA" title="Video Pembelajaran Kuda-Kuda" allowfullscreen></iframe>
            </div>
        </section>

        <section id="tangkisan-dasar">
            <h2>2. Tangkisan Dasar</h2>
            <p>Teknik menangkis serangan lawan menggunakan tangan. Meliputi tangkisan luar, dalam, atas, dan bawah untuk melindungi bagian vital tubuh.</p>
            <ol>
                <li>Posisikan tubuh dengan kuda-kuda yang kokoh.</li>
                <li>Gunakan lengan bawah untuk memblokir atau mengalihkan serangan.</li>
                <li>Jaga agar pandangan tetap fokus pada lawan.</li>
            </ol>
            <div class="video-responsive-container">
                <iframe src="URL_VIDEO_TANGKISAN" title="Video Pembelajaran Tangkisan" allowfullscreen></iframe>
            </div>
        </section>
        
        <section id="langkah-segitiga">
            <h2>3. Jurus Dasar Langkah Segitiga</h2>
            <p>Pola gerakan kaki membentuk segitiga yang penting untuk mobilitas, mengubah posisi terhadap lawan, dan membuka peluang serangan atau pertahanan.</p>
            <p>Teknik ini melatih pesilat untuk bergerak secara efisien tanpa kehilangan keseimbangan.</p>
            <div class="video-responsive-container">
                <iframe src="URL_VIDEO_LANGKAH_SEGITIGA" title="Video Pembelajaran Langkah Segitiga" allowfullscreen></iframe>
            </div>
        </section>

    </article>
</div>

<?php include 'footer.php'; ?>
<script src="script_materi.js"></script>
</body>
</html>