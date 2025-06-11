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
    <title>Materi Sabuk Hijau - Pencak Silat</title>
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
        <b>MATERI SABUK HIJAU</b>
        <p>Tingkat lanjutan yang fokus pada kombinasi gerak, tendangan variatif, dan penguasaan jurus dasar tangan kosong.</p>
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
        <h1>Daftar Materi Sabuk Hijau</h1>
        <p>Pada level ini, pesilat dilatih untuk merangkai gerakan dasar menjadi sebuah kombinasi yang efektif dalam pertarungan.</p>

        <section id="kombinasi-gerak">
            <h2>1. Kombinasi Pukulan dan Tangkisan</h2>
            <p>Melatih refleks untuk menangkis serangan lawan dan secara langsung menyambungnya dengan serangan balasan berupa pukulan. Ini adalah dasar dari serangan balik (counter-attack).</p>
            <div class="video-responsive-container">
                <iframe src="URL_VIDEO_KOMBINASI_PUKUL_TANGKIS" title="Video Pembelajaran Kombinasi Pukul & Tangkis" allowfullscreen></iframe>
            </div>
        </section>

        <section id="tendangan-samping">
            <h2>2. Tendangan Samping dan Belakang</h2>
            <p>Pengembangan dari teknik tendangan. Tendangan samping (T) menggunakan pisau kaki untuk menyerang, sedangkan tendangan belakang membutuhkan rotasi tubuh yang baik untuk menghasilkan kekuatan tak terduga.</p>
            <div class="video-responsive-container">
                <iframe src="URL_VIDEO_TENDANGAN_SAMPING_BELAKANG" title="Video Pembelajaran Tendangan Samping & Belakang" allowfullscreen></iframe>
            </div>
        </section>
        
        <section id="jurus-tangan-kosong">
            <h2>3. Jurus Tangan Kosong 1-3</h2>
            <p>Rangkaian gerak terstruktur yang menggabungkan kuda-kuda, langkah, tangkisan, elakan, pukulan, dan tendangan. Jurus melatih memori gerak, stamina, dan keindahan gerak (seni).</p>
            <div class="video-responsive-container">
                <iframe src="URL_VIDEO_JURUS_1_3" title="Video Pembelajaran Jurus 1-3" allowfullscreen></iframe>
            </div>
        </section>

    </article>
</div>

<?php include 'footer.php'; ?>
<script src="script_materi.js"></script>
</body>
</html>