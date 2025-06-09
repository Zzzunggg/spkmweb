<?php
include 'koneksi/koneksi.php';
// header.php akan di-include di dalam <body>
// footer.php akan di-include sebelum </body>

$sambutan = $conn->query("SELECT * FROM sambutan ORDER BY created_at DESC LIMIT 1")->fetch_assoc();
$bannerImage = 'default-banner.jpg'; // Default banner
$result = $conn->query("SELECT banner_image FROM settings WHERE id = 1 LIMIT 1");
if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if (!empty($row['banner_image'])) {
        $bannerImage = $row['banner_image'];
    }
}
$jadwal = $conn->query("SELECT * FROM jadwal_latihan ORDER BY tingkat ASC, id DESC");
$dasar = $menengah = $mahir = [];
while ($row = $jadwal->fetch_assoc()) {
    if ($row['tingkat'] == 'Dasar') $dasar[] = $row;
    elseif ($row['tingkat'] == 'Menengah') $menengah[] = $row;
    elseif ($row['tingkat'] == 'Mahir') $mahir[] = $row;
}
$galeri = $conn->query("SELECT * FROM galeri ORDER BY created_at DESC LIMIT 8");
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Surabaya Pencak Kordo Manyuro - SPKM 1938</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
  <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">
  <style>
    :root {
      --primary-color: #007BFF;
      --secondary-color: #6c757d;
      --background-color: #f0f2f5;
      --card-background:rgb(255, 255, 255);
      --text-color: #343a40;
      --heading-color: #1a1a1a;
      --border-radius: 8px;
      --shadow: 0 4px 15px rgba(0,0,0,0.08);
      --shadow-hover: 0 6px 20px rgba(0,0,0,0.12);
    }

    * { margin: 0; padding: 0; box-sizing: border-box; }

    html {
        scroll-behavior: smooth;
    }

    body {
      font-family: 'Poppins', 'Inter', sans-serif;
      background: var(--background-color);
      color: var(--text-color);
      line-height: 1.7;
      -webkit-font-smoothing: antialiased;
      -moz-osx-font-smoothing: grayscale;
    }
    a { text-decoration: none; color: var(--primary-color); transition: color 0.3s ease; }
    a:hover { color: #0056b3; }

    /* CSS untuk header.php dan footer.php tidak diubah/dihapus dari sini, diasumsikan ada di file masing-masing atau CSS terpisah */

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
      position: relative;
    }
    .hero-text {
      max-width: 800px;
    }
    .hero h1 {
      font-size: clamp(2.5rem, 5vw, 3.8rem);
      font-weight: 700;
      margin-bottom: 1rem;
      animation: fadeInDown 1s ease-in-out;
      text-shadow: 0 2px 4px rgba(0,0,0,0.5);
    }
    .hero p {
      font-size: clamp(1rem, 2.5vw, 1.3rem);
      margin-top: 0.5rem;
      animation: fadeInUp 1.2s ease-in-out;
      max-width: 600px;
      margin-left: auto;
      margin-right: auto;
      color: #f0f0f0;
      margin-bottom: 2rem;
    }

    .cta-button {
      display: inline-block;
      background-color: var(--primary-color);
      color: white;
      padding: 0.8rem 2rem;
      border-radius: 50px;
      margin-top: 1.5rem;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      transition: background-color 0.3s ease, transform 0.3s ease, box-shadow 0.3s ease;
      box-shadow: 0 4px 10px rgba(0, 123, 255, 0.3);
    }
    .cta-button:hover {
      background-color: #0056b3;
      color: white;
      transform: translateY(-3px);
      box-shadow: 0 6px 15px rgba(0, 123, 255, 0.4);
    }

    .container {
      width: 90%;
      max-width: 1100px;
      margin: auto;
      padding: 4rem 0;
    }

    .section-title {
      font-size: clamp(1.8rem, 4vw, 2.5rem);
      font-weight: 700;
      margin-bottom: 3rem;
      color: var(--heading-color);
      text-align: center;
      position: relative;
      padding-bottom: 1rem;
    }

    .section-title::after {
      content: '';
      position: absolute;
      bottom: 0;
      left: 50%;
      transform: translateX(-50%);
      width: 80px;
      height: 4px;
      background-color: var(--primary-color);
      border-radius: 2px;
    }

    .card {
      background: var(--card-background);
      border-radius: var(--border-radius);
      padding: 2rem;
      box-shadow: var(--shadow);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      margin-bottom: 2rem;
    }
    .card:hover:not(.jadwal-tab) {
      transform: translateY(-5px);
      box-shadow: var(--shadow-hover);
    }

    /* SAMBUTAN */
    .sambutan-content {
      display: grid;
      grid-template-columns: 1fr;
      gap: 2.5rem;
      align-items: center;
    }
    .sambutan-content img {
      width: 100%;
      max-width: 280px;
      border-radius: 50%;
      object-fit: cover;
      aspect-ratio: 1/1;
      margin: 0 auto 1.5rem auto;
      box-shadow: 0 4px 15px rgba(0,0,0,0.15);
    }
    .sambutan-content div h3 {
      color: var(--heading-color);
      font-size: 1.6rem;
      margin-bottom: 0.5rem;
      font-weight: 600;
    }
    .sambutan-content div h3 small {
      font-size: 1rem;
      color: var(--secondary-color);
      font-weight: 400;
      display: block;
      margin-top: 0.25rem;
    }
    .sambutan-content div p {
      color: var(--text-color);
      line-height: 1.8;
      margin-top: 1rem;
    }

    /* JADWAL */
    .jadwal-tabs {
      display: flex;
      gap: 1rem;
      margin-bottom: 2.5rem;
      justify-content: center;
      flex-wrap: wrap;
    }
    .tab-btn {
      padding: 0.7rem 1.5rem;
      border: 1px solid #ddd;
      border-radius: 50px;
      background: var(--card-background);
      color: var(--text-color);
      cursor: pointer;
      transition: all 0.3s ease;
      font-weight: 500;
    }
    .tab-btn:hover {
      background: #e9e9e9;
      border-color: #ccc;
    }
    .tab-btn.active {
      background: var(--primary-color);
      color: white;
      border-color: var(--primary-color);
      box-shadow: 0 2px 8px rgba(0, 123, 255, 0.3);
    }

    .jadwal-tab {
      margin-bottom: 0;
      opacity: 0;
      display: none;
      transition: opacity 0.4s ease;
      min-height: 150px;
    }
    .jadwal-tab.active {
      opacity: 1;
      display: block;
    }
    .jadwal-card {
      padding: 1rem 1.5rem;
      background-color: #f8f9fa;
      border-radius: var(--border-radius);
      margin-bottom: 1rem;
      border: 1px solid #eee;
      transition: transform 0.2s ease, box-shadow 0.2s ease;
      display: flex;
      align-items: center;
      gap: 0.75rem;
    }
    .jadwal-card:hover {
        transform: translateX(5px);
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    }
    .jadwal-card:last-child {
      margin-bottom: 0;
    }
    .jadwal-card strong {
      color: var(--primary-color);
      font-weight: 600;
    }
    .jadwal-card::before {
        content: '📅';
        font-size: 1.2rem;
        color: var(--primary-color);
    }

    /* GALERI */
    .galeri-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
      gap: 1.5rem;
    }
    .galeri-item {
      position: relative;
      overflow: hidden;
      border-radius: var(--border-radius);
      box-shadow: var(--shadow);
      aspect-ratio: 4/3;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      background-color: #e0e0e0;
    }
    .galeri-item:hover {
      transform: translateY(-5px) scale(1.03);
      box-shadow: var(--shadow-hover);
    }
    .galeri-item img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: transform 0.5s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    }
    .galeri-item .caption {
      position: absolute;
      bottom: 0;
      left: 0;
      background: linear-gradient(to top, rgba(0,0,0,0.85) 20%, rgba(0,0,0,0));
      color: #fff;
      width: 100%;
      text-align: left;
      padding: 1.5rem 1rem 1rem;
      font-size: 0.9rem;
      opacity: 0;
      transform: translateY(20px);
      transition: opacity 0.4s ease, transform 0.4s ease;
    }
    .galeri-item:hover .caption {
      opacity: 1;
      transform: translateY(0);
    }

    /* Media Queries */
    @media (min-width: 768px) {
      .sambutan-content {
        grid-template-columns: 280px 1fr;
        text-align: left;
      }
      .sambutan-content img {
        margin: 0;
      }
    }

    @media (max-width: 768px) {
      .hero h1 { font-size: 2.2rem; }
      .hero p { font-size: 1rem; }
      .section-title { font-size: 1.8rem; }
    }
    @media (max-width: 480px) {
      .jadwal-tabs {
        flex-direction: column;
        align-items: stretch;
      }
      .tab-btn { margin-bottom: 0.5rem; }
      .cta-button { padding: 0.7rem 1.5rem; font-size: 0.9rem;}
      .hero h1 { font-size: 2rem; }
      .hero p { font-size: 0.9rem; }
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
    <h1>Surabaya Pencak Kordo Manyuro - 1938</h1>
    <p>SPKM (Surabaya Pencak Kordo Manyuro) adalah salah satu perguruan pencak silat di Indonesia asal kota Surabaya yang berdiri sejak tahun 1938.</p>
    <a href="#jadwal" class="cta-button" data-aos="fade-up" data-aos-delay="200">Lihat Jadwal Latihan</a>
  </div>
</section>

<main>
  <div class="container">

    <section id="sambutan">
      <h2 class="section-title" data-aos="fade-right">Sambutan Ketua Organisasi</h2>
      <?php if ($sambutan): ?>
      <div class="card sambutan" data-aos="fade-up">
        <div class="sambutan-content">
          <img src="admin/uploads/sambutan/<?= htmlspecialchars($sambutan['foto']) ?>" alt="Foto <?= htmlspecialchars($sambutan['nama']) ?>">
          <div>
            <h3><?= htmlspecialchars($sambutan['nama']) ?></h3>
            <small><?= htmlspecialchars($sambutan['jabatan']) ?></small>
            <p><?= nl2br(htmlspecialchars($sambutan['sambutan'])) ?></p>
          </div>
        </div>
      </div>
      <?php else: ?>
      <div class="card" data-aos="fade-up"><p>Informasi sambutan belum tersedia.</p></div>
      <?php endif; ?>
    </section>

    <section id="jadwal" style="margin-top:4rem;">
      <h2 class="section-title" data-aos="fade-right">Jadwal Latihan</h2>
      <div class="jadwal-tabs" data-aos="fade-up">
        <button class="tab-btn active" onclick="showTab('dasar', event)" data-aos="fade-up" data-aos-delay="100">Dasar</button>
        <button class="tab-btn" onclick="showTab('menengah', event)" data-aos="fade-up" data-aos-delay="200">Menengah</button>
        <button class="tab-btn" onclick="showTab('mahir', event)" data-aos="fade-up" data-aos-delay="300">Mahir</button>
      </div>

      <div id="dasar" class="card jadwal-tab active" data-aos="fade-up" data-aos-delay="200">
        <?php if (!empty($dasar)): ?>
          <?php foreach ($dasar as $j): ?>
          <div class="jadwal-card">
            <strong><?= htmlspecialchars($j['hari']) ?></strong> - <?= htmlspecialchars($j['waktu']) ?> @ <?= htmlspecialchars($j['tempat']) ?>
          </div>
          <?php endforeach; ?>
        <?php else: ?>
          <p>Belum ada jadwal untuk tingkat Dasar.</p>
        <?php endif; ?>
      </div>

      <div id="menengah" class="card jadwal-tab" data-aos="fade-up">
        <?php if (!empty($menengah)): ?>
          <?php foreach ($menengah as $j): ?>
          <div class="jadwal-card">
            <strong><?= htmlspecialchars($j['hari']) ?></strong> - <?= htmlspecialchars($j['waktu']) ?> @ <?= htmlspecialchars($j['tempat']) ?>
          </div>
          <?php endforeach; ?>
        <?php else: ?>
          <p>Belum ada jadwal untuk tingkat Menengah.</p>
        <?php endif; ?>
      </div>

      <div id="mahir" class="card jadwal-tab" data-aos="fade-up">
        <?php if (!empty($mahir)): ?>
          <?php foreach ($mahir as $j): ?>
          <div class="jadwal-card">
            <strong><?= htmlspecialchars($j['hari']) ?></strong> - <?= htmlspecialchars($j['waktu']) ?> @ <?= htmlspecialchars($j['tempat']) ?>
          </div>
          <?php endforeach; ?>
        <?php else: ?>
          <p>Belum ada jadwal untuk tingkat Mahir.</p>
        <?php endif; ?>
      </div>
    </section>

    <section id="galeri" style="margin-top:4rem;">
      <h2 class="section-title" data-aos="fade-right">Galeri Kegiatan</h2>
      <?php if ($galeri && $galeri->num_rows > 0): ?>
      <div class="galeri-grid" data-aos="fade-up">
        <?php $delay = 0; while ($img = $galeri->fetch_assoc()): $delay += 100; ?>
        <div class="galeri-item" data-aos="fade-up" data-aos-delay="<?= $delay ?>">
          <img src="admin/uploads/galeri/<?= htmlspecialchars($img['gambar']) ?>" alt="Galeri <?= htmlspecialchars($img['caption'] ?? 'Kegiatan') ?>">
          <?php if (!empty($img['caption'])): ?>
          <div class="caption"><?= htmlspecialchars($img['caption']) ?></div>
          <?php endif; ?>
        </div>
        <?php endwhile; ?>
      </div>
      <?php else: ?>
      <div class="card" data-aos="fade-up"><p>Belum ada galeri tersedia.</p></div>
      <?php endif; ?>
    </section>

  </div> </main>

<?php
// Include footer.php Anda di sini.
include 'footer.php';
?>

<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
<script>
  AOS.init({
    duration: 700,
    once: true,
    offset: 120,
    easing: 'ease-in-out-cubic'
  });

  function showTab(tabId, event) {
    document.querySelectorAll('.jadwal-tab').forEach(tab => {
      tab.classList.remove('active');
    });

    const activeTab = document.getElementById(tabId);
    requestAnimationFrame(() => {
        activeTab.classList.add('active');
    });

    document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
    if (event && event.currentTarget) {
        event.currentTarget.classList.add('active');
    } else if (event) {
        event.target.classList.add('active');
    }
  }

  document.addEventListener('DOMContentLoaded', () => {
    const firstActiveButton = document.querySelector('.tab-btn.active');
    if (firstActiveButton) {
        // Ekstrak tabId dari atribut onclick
        const onclickAttribute = firstActiveButton.getAttribute('onclick');
        if (onclickAttribute) {
            const match = onclickAttribute.match(/'([^']+)'/);
            if (match && match[1]) {
                const activeTabId = match[1];
                showTab(activeTabId, { currentTarget: firstActiveButton });
            }
        }
    }
  });
</script>

</body>
</html>