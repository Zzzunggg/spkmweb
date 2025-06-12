<?php
include 'koneksi/koneksi.php';
// header.php akan di-include di dalam <body>
// footer.php akan di-include sebelum </body>

// Data untuk bagian Sejarah (menggunakan data sambutan yang sudah ada)
$sejarah = $conn->query("SELECT * FROM sambutan ORDER BY created_at DESC LIMIT 1")->fetch_assoc();

// Data untuk Banner
$bannerImage = 'default-banner.jpg'; // Default banner
$result = $conn->query("SELECT banner_image FROM settings WHERE id = 1 LIMIT 1");
if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if (!empty($row['banner_image'])) {
        $bannerImage = $row['banner_image'];
    }
}

// Data untuk Galeri (tetap digunakan)
$galeri = $conn->query("SELECT * FROM galeri ORDER BY created_at DESC LIMIT 8");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <link rel="icon" type="image/png" href="uploads/Logo SPKM.png">
    <meta charset="UTF-8">
    <title>Surabaya Pencak Kordo Manyuro - SPKM 1938</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <style>
        /* === DESAIN BARU SESUAI GAMBAR === */
        :root {
            --primary-color: #007BFF; /* Warna biru bisa disesuaikan */
            --background-color: #ffffff;
            --card-background: #f8f9fa;
            --text-color: #555;
            --heading-color: #222;
            --border-color: #e9ecef;
            --border-radius: 12px;
            --shadow: 0 4px 15px rgba(0,0,0,0.06);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: var(--background-color);
            color: var(--text-color);
            line-height: 1.7;
            -webkit-font-smoothing: antialiased;
        }
        
        a { text-decoration: none; color: var(--primary-color); }
        h1, h2, h3, h4 { color: var(--heading-color); font-weight: 600; }

        /* Asumsi CSS untuk header.php dan footer.php sudah ada di file masing-masing */

        .hero {
            background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.6)),
                        url('admin/uploads/<?= htmlspecialchars($bannerImage) ?>') center/cover no-repeat;
            min-height: 90vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            padding: 3rem 1.5rem;
            text-align: center;
        }
        
        .hero-text { max-width: 800px; }
        .hero h1 {
            font-size: clamp(2.5rem, 5vw, 3.8rem);
            font-weight: 700;
            margin-bottom: 1rem;
            text-shadow: 0 2px 4px rgba(0,0,0,0.5);
            color: #ffffff;
        }
        .hero p {
            font-size: clamp(1rem, 2.5vw, 1.3rem);
            max-width: 600px;
            margin: 0.5rem auto 2rem;
            color: #f0f0f0;
        }
        
        .cta-button {
            display: inline-block;
            background-color: var(--primary-color);
            color: white;
            padding: 0.8rem 2rem;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .cta-button:hover {
            background-color: #0056b3;
            transform: translateY(-3px);
        }

        .container {
            width: 90%;
            max-width: 1100px;
            margin: auto;
            padding: 5rem 0;
        }

        .section-title {
            font-size: clamp(2rem, 4vw, 2.8rem);
            font-weight: 700;
            margin-bottom: 4rem;
            text-align: center;
        }
        
        /* === BAGIAN SEJARAH (BARU) === */
        .sejarah-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            align-items: center;
        }
        
        .sejarah-images {
            position: relative;
            height: 400px;
        }
        
        .image-stack-item {
            position: absolute;
            background-color: #e0e0e0;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            color: #888;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            font-weight: 500;
            object-fit: cover;
        }
        
        .img-1 {
            width: 75%;
            height: 75%;
            top: 0;
            left: 0;
            z-index: 1;
        }
        
        .img-2 {
            width: 65%;
            height: 65%;
            bottom: 0;
            right: 0;
            background-color: #f0f0f0;
            border: 5px solid white;
            z-index: 2;
        }

        .sejarah-content h2 {
            font-size: 2.2rem;
            margin-bottom: 1.5rem;
            line-height: 1.3;
        }

        /* CSS untuk Prestasi & Aktivitas bisa dihapus jika tidak ada elemen lain yang menggunakannya */
        /* Namun untuk sementara dibiarkan agar tidak merusak style lain */
        .prestasi-grid {
            display: grid;
            grid-template-columns: 1.5fr 1fr;
            gap: 2.5rem;
            align-items: start;
        }

        .prestasi-card {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            background-color: var(--card-background);
            padding: 1.25rem;
            border-radius: var(--border-radius);
            margin-bottom: 1.5rem;
        }

        .prestasi-card-img {
            flex-shrink: 0;
            width: 100px;
            height: 100px;
            background-color: #e0e0e0;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #888;
            font-weight: 500;
        }

        .prestasi-card-info h4 {
            font-size: 1.2rem;
            margin-bottom: 0.25rem;
        }
        
        .jadwal-card-horizontal {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background-color: var(--card-background);
            padding: 1rem 1.5rem;
            border-radius: var(--border-radius);
            margin-bottom: 1rem;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            cursor: pointer;
        }
        .jadwal-card-horizontal:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow);
        }

        .jadwal-info {
            display: flex;
            align-items: center;
            gap: 1rem;
            font-weight: 500;
            color: var(--heading-color);
        }
        
        .jadwal-info i {
            font-size: 1.3rem;
            color: var(--primary-color);
            width: 25px; /* Memberi lebar tetap agar text lurus */
            text-align: center;
        }
        
        .jadwal-card-horizontal .arrow {
            color: var(--primary-color);
            font-weight: bold;
        }


        /* === [PERBAIKAN FINAL] GALERI DENGAN UKURAN TETAP === */
        .galeri-grid {
            display: flex;
            flex-wrap: wrap;
            justify-content: center; /* Agar gambar di tengah */
            gap: 1rem;
        }
        
        .galeri-item {
            /* KUNCI UTAMA: Memberi ukuran lebar yang pasti */
            width: 200px; 
            
            /* Mencegah gambar membesar atau mengecil otomatis */
            flex-grow: 0;
            flex-shrink: 0;

            /* Menjaga bentuk agar tidak gepeng */
            aspect-ratio: 4 / 3;
            
            position: relative;
            overflow: hidden;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            transition: transform 0.3s ease;
            background-color: #e0e0e0;
        }
        
        .galeri-item:hover {
            transform: scale(1.05);
        }
        
        .galeri-item img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover; /* Ini yang mencegah gambar gepeng */
        }


        /* Media Queries untuk Responsif */
        @media (max-width: 992px) {
            .sejarah-grid, .prestasi-grid {
                grid-template-columns: 1fr;
            }
            .sejarah-images {
                height: 350px;
                margin-bottom: 2rem;
            }
        }
        
        @media (max-width: 768px) {
            .container { padding: 3rem 0; }
            .section-title { font-size: 2rem; margin-bottom: 2.5rem; }
            .sejarah-images { height: 300px; }
            .sejarah-content h2 { font-size: 1.8rem; }
        }

    </style>
</head>
<body>

<?php
// Include header.php Anda di sini.
include 'header.php';
?>

<section class="hero" id="beranda">
    <div class="hero-text">
        <h1 data-aos="fade-down">Surabaya Pencak Kordo Manyuro - 1938</h1>
        <p data-aos="fade-up" data-aos-delay="100">SPKM (Surabaya Pencak Kordo Manyuro) adalah salah satu perguruan pencak silat di Indonesia asal kota Surabaya yang berdiri sejak tahun 1938.</p>
        
    </div>
</section>

<main>
    <section id="sejarah" class="container">
        <div class="sejarah-grid">
            <div class="sejarah-images" data-aos="fade-right">
                <div class="sejarah-images" data-aos="fade-right">
                    <img src="admin/uploads/galeri/juara budokai.png" class="image-stack-item img-1" alt="Kegiatan 1">
                    <img src="admin/uploads/galeri/image.png" class="image-stack-item img-2" alt="Kegiatan 2">
                </div>
            </div>
            <div class="sejarah-content" data-aos="fade-left">
                <h2>Sejarah Perguruan Silat SPKM Kordo Manyuro</h2>
                <?php if ($sejarah && !empty($sejarah['sambutan'])): ?>
                    <p><?= nl2br(htmlspecialchars($sejarah['sambutan'])) ?></p>
                <?php else: ?>
                    <p>SPKM (Surabaya Pencak Kordo Manyuro) adalah perguruan silat historis yang berpengaruh di Indonesia. Sejak didirikan pada tahun 1938 di Surabaya oleh Almarhum Bapak Soedirman, SPKM telah melahirkan banyak pendekar dan atlet yang berprestasi.</p>
                    <p>Tekad yang kuat serta semangat yang tak pernah padam dari para anggota senior maupun yunior, SPKM Kordo Manyuro berkembang dan berhasil membuka cabang-cabang baru di berbagai daerah, menunjukkan dedikasi dalam melestarikan budaya pencak silat.</p>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <section id="galeri" class="container">
        <h2 class="section-title" data-aos="fade-up">Galeri Kegiatan</h2>
        <?php if ($galeri && $galeri->num_rows > 0): ?>
        <div class="galeri-grid" data-aos="fade-up" data-aos-delay="200">
            <?php while ($img = $galeri->fetch_assoc()): ?>
            <div class="galeri-item">
                <img src="admin/uploads/galeri/<?= htmlspecialchars($img['gambar']) ?>" alt="Galeri <?= htmlspecialchars($img['caption'] ?? 'Kegiatan') ?>">
            </div>
            <?php endwhile; ?>
        </div>
        <?php else: ?>
        <p style="text-align:center;">Belum ada galeri tersedia.</p>
        <?php endif; ?>
    </section>

</main>

<?php
// Include footer.php Anda di sini.
include 'footer.php';
?>

<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
<script>
    // Inisialisasi AOS (Animasi saat scroll)
    AOS.init({
        duration: 800,
        once: true,
        offset: 50,
    });
</script>


</body>
</html>