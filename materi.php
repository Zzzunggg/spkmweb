<?php
// Sertakan file koneksi dan header (tidak diubah)
include 'koneksi/koneksi.php';
include 'header.php';

// Ambil gambar banner dari database (tidak diubah)
$sql = "SELECT banner_image FROM settings WHERE id = 1 LIMIT 1";
$result = $conn->query($sql);
$bannerImage = 'default-banner.jpg'; // Gambar default

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
    <title>Jurus Dasar Langkah Segitiga - Materi Pencak Silat</title>

    <link rel="stylesheet" href="style-materi.css">

    <style>
        .banner {
            --banner-bg-url: url('admin/uploads/<?= htmlspecialchars($bannerImage) ?>');
        }
    </style>
</head>
<body>

<section class="banner" role="banner" aria-label="Banner Materi">
    <div>
        <b>MATERI KAMI</b>
        <p>Materi tingkat dasar mengenai gerakan kaki dalam membentuk pola segitiga untuk pertahanan dan serangan dasar pencak silat.</p>
    </div>
</section>

<div class="container">
    <aside class="sidebar" role="navigation" aria-label="Navigasi Materi">
        
        <div class="accordion-item active">
            <button class="accordion-toggle" aria-expanded="true">
                Sabuk Putih
                <span class="icon" aria-hidden="true">▾</span>
            </button>
            <div class="accordion-content">
                <ul>
                    <li><a href="materi_putih.php">Kuda-Kuda Dasar</a></li>
                    <li><a href="materi_putih.php#tangkisan-dasar">Tangkisan Dasar</a></li>
                    <li><a href="materi_putih.php#langkah-segitiga" aria-current="page">Jurus Dasar Langkah Segitiga</a></li>
                </ul>
            </div>
        </div>

        <div class="accordion-item">
            <button class="accordion-toggle" aria-expanded="false">
                Sabuk Kuning
                <span class="icon" aria-hidden="true">▸</span>
            </button>
            <div class="accordion-content">
                <ul>
                    <li><a href="materi_kuning.php#pukulan-dasar">Pukulan Dasar (Lurus & Bandul)</a></li>
                    <li><a href="materi_kuning.php#tendangan-dasar">Tendangan Dasar (Depan)</a></li>
                    <li><a href="materi_kuning.php#elakan-dasar">Elakan Dasar</a></li>
                </ul>
            </div>
        </div>

        <div class="accordion-item">
            <button class="accordion-toggle" aria-expanded="false">
                Sabuk Hijau
                <span class="icon" aria-hidden="true">▸</span>
            </button>
            <div class="accordion-content">
                <ul>
                    <li><a href="materi_hijau.php#kombinasi-gerak">Kombinasi Pukulan dan Tangkisan</a></li>
                    <li><a href="materi_hijau.php#tendangan-samping">Tendangan Samping dan Belakang</a></li>
                    <li><a href="materi_hijau.php#jurus-tangan-kosong">Jurus Tangan Kosong 1-3</a></li>
                </ul>
            </div>
        </div>

        <div class="accordion-item">
            <button class="accordion-toggle" aria-expanded="false">
                Sabuk Hitam
                <span class="icon" aria-hidden="true">▸</span>
            </button>
            <div class="accordion-content">
                <ul>
                    <li><a href="materi_hitam.php#teknik-kuncian">Teknik Kuncian Dasar</a></li>
                    <li><a href="materi_hitam.php#teknik-jatuhan">Teknik Jatuhan dan Bantingan</a></li>
                    <li><a href="materi_hitam.php#jurus-senjata">Dasar Jurus Senjata (Golok/Toya)</a></li>
                </ul>
            </div>
        </div>

        <div class="accordion-item">
            <button class="accordion-toggle" aria-expanded="false">
                Sabuk Kuning Emas
                <span class="icon" aria-hidden="true">▸</span>
            </button>
            <div class="accordion-content">
                <ul>
                     <li><a href="materi_emas.php#kuncian-lanjutan">Kuncian Lanjutan</a></li>
                    <li><a href="materi_emas.php#pemecahan-kuncian">Teknik Pemecahan Kuncian</a></li>
                    <li><a href="materi_emas.php#jurus-master">Jurus Master Tangan Kosong</a></li>
                </ul>
            </div>
        </div>
        
        <div class="accordion-item">
            <button class="accordion-toggle" aria-expanded="false">
                Sabuk Merah
                <span class="icon" aria-hidden="true">▸</span>
            </button>
            <div class="accordion-content">
                <ul>
                    <li><a href="materi_merah.php#filosofi-gerak">Filosofi Gerakan Pencak Silat</a></li>
                    <li><a href="materi_merah.php#tenaga-dalam">Dasar Pernapasan dan Tenaga Dalam</a></li>
                    <li><a href="materi_merah.php#aplikasi-beladiri">Aplikasi Praktis Bela Diri</a></li>
                </ul>
            </div>
        </div>

        <section class="box-download" aria-label="Download Materi Terbaru">
            <h4>Unduh Materi Terbaru</h4>
            <?php
            // Query untuk download tidak diubah
            $materi = mysqli_query($conn, "SELECT * FROM materi ORDER BY id DESC LIMIT 1");
            if (mysqli_num_rows($materi) > 0) {
                $m = mysqli_fetch_assoc($materi);
                echo '<p>' . htmlspecialchars($m['judul']) . '</p>';
                echo '<a href="../uploads/' . htmlspecialchars($m['nama_file']) . '" class="btn-download" download target="_blank" rel="noopener">📄 Unduh PDF Materi</a>';
            } else {
                echo "<p>Belum ada file tersedia.</p>";
            }
            ?>
        </section>
    </aside>

    <article class="content" role="main">
        <h1>Jurus Dasar Langkah Segitiga</h1>
        <p>Dalam pencak silat, langkah segitiga adalah teknik dasar yang mengajarkan gerakan kaki membentuk pola segitiga. Teknik ini penting untuk menjaga keseimbangan, memudahkan perpindahan posisi, dan mempersiapkan serangan atau pertahanan.</p>

        <h2>Langkah-langkah Dasar</h2>
        <ol>
            <li>Berdiri dengan kaki sejajar dan tubuh rileks.</li>
            <li>Langkahkan kaki kanan ke depan membentuk sudut segitiga.</li>
            <li>Langkahkan kaki kiri menyilang ke belakang kaki kanan.</li>
            <li>Kembali ke posisi awal dan ulangi pola secara bergantian.</li>
        </ol>

        <h2>Manfaat Latihan</h2>
        <ul>
            <li>Meningkatkan keseimbangan tubuh.</li>
            <li>Memperkuat otot kaki dan postur tubuh.</li>
            <li>Menambah kelincahan dalam menghadapi lawan.</li>
            <li>Menjadi dasar untuk jurus lanjutan.</li>
        </ul>

        <h2>Video Pembelajaran</h2>
        <div class="video-responsive-container">
            <iframe src="https://www.youtube.com/embed/your_video_id" title="Video Pembelajaran Langkah Segitiga" allowfullscreen></iframe>
        </div>

        <h2>Tips Latihan Mandiri</h2>
        <ul>
            <li>Lakukan di ruang terbuka agar lebih leluasa.</li>
            <li>Gunakan cermin untuk memperbaiki postur.</li>
            <li>Latihan secara rutin minimal 3 kali seminggu.</li>
        </ul>
    </article>
</div>

<?php
// Sertakan footer (tidak diubah)
include 'footer.php';
?>

<script>
// Tidak ada perubahan pada JavaScript, fungsionalitas akordeon tetap sama.
document.addEventListener('DOMContentLoaded', function () {
    const accordionItems = document.querySelectorAll('.accordion-item');

    accordionItems.forEach(item => {
        const toggle = item.querySelector('.accordion-toggle');
        const icon = toggle.querySelector('.icon');
        
        // Inisialisasi ikon berdasarkan status aktif
        if (item.classList.contains('active')) {
            icon.textContent = '▾'; // Panah ke bawah (terbuka)
        } else {
            icon.textContent = '▸'; // Panah ke samping (tertutup)
        }

        toggle.addEventListener('click', () => {
            const isActive = item.classList.contains('active');
            
            // Opsi: Tutup semua accordion lain saat satu dibuka
            // accordionItems.forEach(otherItem => {
            //     otherItem.classList.remove('active');
            //     otherItem.querySelector('.accordion-toggle').setAttribute('aria-expanded', 'false');
            //     otherItem.querySelector('.icon').textContent = '▸';
            // });

            if (!isActive) {
                item.classList.add('active');
                toggle.setAttribute('aria-expanded', 'true');
                icon.textContent = '▾';
            } else {
                item.classList.remove('active');
                toggle.setAttribute('aria-expanded', 'false');
                icon.textContent = '▸';
            }
        });
    });
});
</script>

</body>
</html>