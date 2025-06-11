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
    <title>Materi Sabuk Merah - Pencak Silat</title>
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
        <b>MATERI SABUK MERAH</b>
        <p>Pengenalan teknik serangan dasar menggunakan tangan dan kaki, serta teknik menghindar dari serangan lawan.</p>
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
        <h1>Daftar Materi Sabuk Kuning</h1>
        <p>Setelah menguasai fondasi, pesilat mulai diperkenalkan dengan cara menyerang dan menghindar secara efektif.</p>

        <section id="pukulan-dasar">
            <h2>1. Pukulan Dasar (Lurus & Bandul)</h2>
            <p>Penjelasan detail mengenai teknik pukulan lurus yang cepat dan terarah, serta pukulan bandul (swing) yang memiliki kekuatan lebih besar dari arah samping.</p>
            <div class="video-responsive-container">
                <iframe src="URL_VIDEO_PUKULAN" title="Video Pembelajaran Pukulan" allowfullscreen></iframe>
            </div>
        </section>

        <section id="tendangan-dasar">
            <h2>2. Tendangan Dasar (Depan)</h2>
            <p>Teknik tendangan lurus ke arah depan (tendangan A), menargetkan area perut atau dada lawan. Latihan ini berfokus pada kecepatan, kekuatan, dan keseimbangan saat menendang.</p>
            <div class="video-responsive-container">
                <iframe src="URL_VIDEO_TENDANGAN_DEPAN" title="Video Pembelajaran Tendangan Depan" allowfullscreen></iframe>
            </div>
        </section>
        
        <section id="elakan-dasar">
            <h2>3. Elakan Dasar</h2>
            <p>Teknik memindahkan tubuh untuk menghindari serangan lawan tanpa harus memblokir. Meliputi elakan bawah dan elakan samping untuk melatih refleks dan kelincahan.</p>
            <div class="video-responsive-container">
                <iframe src="URL_VIDEO_ELAKAN" title="Video Pembelajaran Elakan" allowfullscreen></iframe>
            </div>
        </section>

    </article>
</div>

<?php include 'footer.php'; ?>
<script src="script_materi.js"></script>
</body>
</html>