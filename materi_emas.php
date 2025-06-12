<?php
include 'koneksi/koneksi.php';
include 'header.php';

// Mengambil gambar banner dari database
$sql_banner = "SELECT banner_image FROM settings WHERE id = 1 LIMIT 1";
$result_banner = $conn->query($sql_banner);
$bannerImage = 'default-banner.jpg'; 
if ($result_banner && $result_banner->num_rows > 0) {
    $row_banner = $result_banner->fetch_assoc();
    if (!empty($row_banner['banner_image'])) {
        $bannerImage = $row_banner['banner_image'];
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
        .content .image-container img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            margin-top: 15px;
        }
        .content section {
            margin-bottom: 40px;
            padding-bottom: 20px;
            border-bottom: 1px solid #eee;
        }
        .content section:last-child {
            border-bottom: none;
        }
        .materi-download-link {
            margin-top: 20px;
        }
        .btn-download-item {
            display: inline-block;
            background: linear-gradient(145deg, #ffd700, #f0c000); /* Warna Emas Gradien */
            color: #493800; /* Warna teks gelap untuk kontras */
            padding: 8px 15px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            font-size: 14px;
            transition: all 0.3s;
            border: 1px solid #d4af37;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .btn-download-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.15);
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
            // Sidebar ini akan selalu menampilkan PDF terbaru dari semua materi
            $query_unduh = "SELECT judul, nama_file_pdf FROM materi_detail WHERE nama_file_pdf IS NOT NULL AND nama_file_pdf != '' ORDER BY id DESC LIMIT 1";
            $materi_unduh = mysqli_query($conn, $query_unduh);

            if (mysqli_num_rows($materi_unduh) > 0) {
                $m = mysqli_fetch_assoc($materi_unduh);
                echo '<p>' . htmlspecialchars($m['judul']) . '</p>';
                $pdf_path = 'admin/materi_pdf/' . htmlspecialchars($m['nama_file_pdf']);
                echo '<a href="' . $pdf_path . '" class="btn-download" download>📄 Unduh PDF</a>';
            } else {
                echo "<p>Belum ada file PDF tersedia.</p>";
            }
            ?>
        </section>
    </aside>

    <article class="content" role="main">
        <h1>Daftar Materi Sabuk Kuning Emas</h1>
        <p>Di level ini, pemahaman tentang anatomi dan titik lemah menjadi kunci dalam mengaplikasikan dan melawan teknik kuncian.</p>

        <?php
        // =================================================================
        // PERUBAHAN UTAMA HANYA DI BARIS INI
        // Filter diubah menjadi 'emas'
        $sql_materi = "SELECT * FROM materi_detail WHERE sabuk = 'emas' ORDER BY urutan ASC";
        // =================================================================
        
        $result_materi = mysqli_query($conn, $sql_materi);

        if ($result_materi && mysqli_num_rows($result_materi) > 0) {
            $nomor = 1;
            while ($item = mysqli_fetch_assoc($result_materi)) {
        ?>
                
                <section id="<?php echo htmlspecialchars($item['anchor_id']); ?>">
                    
                    <h2><?php echo $nomor . ". " . htmlspecialchars($item['judul']); ?></h2>
                    
                    <div><?php echo nl2br(htmlspecialchars($item['deskripsi'])); ?></div>

                    <?php
                    // Menampilkan Tombol Unduh PDF jika tersedia
                    if (!empty($item['nama_file_pdf'])) {
                        $pdf_path_item = 'admin/materi_pdf/' . htmlspecialchars($item['nama_file_pdf']);
                    ?>
                        <div class="materi-download-link">
                            <a href="<?= $pdf_path_item ?>" class="btn-download-item" download>
                                📄 Unduh Materi (PDF)
                            </a>
                        </div>
                    <?php
                    }
                    ?>

                    <?php
                    // Menampilkan gambar jika tersedia
                    if (!empty($item['gambar_materi'])) {
                        $image_path = 'admin/gambar_materi/' . htmlspecialchars($item['gambar_materi']);
                    ?>
                        <div class="image-container" style="margin-top:15px;">
                            <img src="<?php echo $image_path; ?>" alt="Gambar untuk <?php echo htmlspecialchars($item['judul']); ?>">
                        </div>
                    <?php
                    }
                    ?>

                    <?php
                    // Menampilkan video jika tersedia
                    if (!empty($item['video_url'])) {
                    ?>
                        <div class="video-responsive-container" style="margin-top:15px;">
                           <iframe src="<?php echo htmlspecialchars($item['video_url']); ?>" title="Video Pembelajaran <?php echo htmlspecialchars($item['judul']); ?>" allowfullscreen></iframe>
                        </div>
                    <?php
                    }
                    ?>
                </section>

        <?php
                $nomor++;
            } // Akhir while
        } else {
            // Pesan jika materi untuk sabuk kuning emas belum ada
            echo "<p style='margin-top: 20px; font-style: italic;'>Materi untuk Sabuk Kuning Emas saat ini belum tersedia.</p>";
        }
        ?>

    </article>
</div>

<?php include 'footer.php'; ?>
<script src="script_materi.js"></script>
</body>
</html>