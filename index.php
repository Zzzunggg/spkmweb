<?php
include 'koneksi/koneksi.php';
include 'header.php';

$sambutan = $conn->query("SELECT * FROM sambutan ORDER BY created_at DESC LIMIT 1")->fetch_assoc();
$bannerImage = 'default-banner.jpg';
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
  <title>Elite Training Center</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    a { text-decoration: none; color: inherit; }

    .hero {
      background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.7)),
                  url('admin/uploads/<?= htmlspecialchars($bannerImage) ?>') center/cover no-repeat;
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      text-align: center;
      color: white;
      padding: 2rem;
    }
    .hero h1 {
      font-size: 3rem;
      animation: fadeInDown 1s ease-in-out;
    }
    .hero p {
      font-size: 1.3rem;
      margin-top: 0.5rem;
      animation: fadeInUp 1.2s ease-in-out;
    }

    @keyframes fadeInDown {
      from { opacity: 0; transform: translateY(-30px); }
      to { opacity: 1; transform: translateY(0); }
    }
    @keyframes fadeInUp {
      from { opacity: 0; transform: translateY(30px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .container {
      width: 90%;
      max-width: 1200px;
      margin: auto;
      padding: 3rem 0;
    }

    .section-title {
      font-size: 2rem;
      font-weight: 700;
      margin-bottom: 2rem;
      color: #333;
      border-left: 5px solid #4caf50;
      padding-left: 1rem;
    }

    .card {
      background: white;
      border-radius: 16px;
      padding: 2rem;
      box-shadow: 0 8px 20px rgba(0,0,0,0.07);
      transition: 0.3s;
    }
    .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 12px 24px rgba(0,0,0,0.1);
    }

    .sambutan img {
      width: 100%;
      border-radius: 12px;
    }
    .sambutan-content {
      display: grid;
      grid-template-columns: 280px 1fr;
      gap: 2rem;
    }

    .jadwal-tabs {
      display: flex;
      gap: 1rem;
      margin-bottom: 2rem;
    }
    .tab-btn {
      padding: 0.6rem 1.2rem;
      border: none;
      border-radius: 20px;
      background: #e0e0e0;
      cursor: pointer;
      transition: 0.2s;
    }
    .tab-btn.active {
      background: #4caf50;
      color: white;
    }

    .jadwal-card {
      margin-bottom: 1.2rem;
    }

    .galeri-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 1rem;
    }
    .galeri-grid div {
      position: relative;
      overflow: hidden;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }
    .galeri-grid img {
      width: 100%;
      height: 200px;
      object-fit: cover;
      transition: 0.3s;
    }
    .galeri-grid div:hover img {
      transform: scale(1.05);
    }
    .caption {
      position: absolute;
      bottom: 0;
      background: rgba(0,0,0,0.6);
      color: #fff;
      width: 100%;
      text-align: center;
      padding: 0.5rem;
    }

    @media (max-width: 768px) {
      .sambutan-content {
        grid-template-columns: 1fr;
        text-align: center;
      }
      .jadwal-tabs {
        flex-direction: column;
      }
    }
  </style>
</head>
<body>

<!-- HERO -->
<section class="hero">
  <div>
    <h1>SELAMAT DATANG DI WEBSITE NAFA</h1>
    <p>Pusat latihan kebugaran dan keterampilan terbaik untuk semua kalangan</p>
  </div>
</section>

<!-- CONTENT -->
<div class="container">

  <!-- SAMBUTAN -->
  <h2 class="section-title">Sambutan Ketua Umum</h2>
  <?php if ($sambutan): ?>
    <div class="card sambutan">
      <div class="sambutan-content">
        <img src="uploads/sambutan/<?= htmlspecialchars($sambutan['foto']) ?>" alt="Ketua">
        <div>
          <h3><?= htmlspecialchars($sambutan['nama']) ?> <br><small><?= htmlspecialchars($sambutan['jabatan']) ?></small></h3>
          <p><?= nl2br(htmlspecialchars($sambutan['sambutan'])) ?></p>
        </div>
      </div>
    </div>
  <?php endif; ?>

  <!-- JADWAL -->
  <h2 class="section-title" style="margin-top:3rem;">Jadwal Latihan</h2>
  <div class="jadwal-tabs">
    <button class="tab-btn active" onclick="showTab('dasar')">Dasar</button>
    <button class="tab-btn" onclick="showTab('menengah')">Menengah</button>
    <button class="tab-btn" onclick="showTab('mahir')">Mahir</button>
  </div>
  <div id="dasar" class="card jadwal-tab">
    <?php foreach ($dasar as $j): ?>
      <div class="jadwal-card">
        <strong><?= $j['hari'] ?></strong> - <?= $j['waktu'] ?> @ <?= $j['tempat'] ?>
      </div>
    <?php endforeach; ?>
  </div>
  <div id="menengah" class="card jadwal-tab" style="display:none">
    <?php foreach ($menengah as $j): ?>
      <div class="jadwal-card">
        <strong><?= $j['hari'] ?></strong> - <?= $j['waktu'] ?> @ <?= $j['tempat'] ?>
      </div>
    <?php endforeach; ?>
  </div>
  <div id="mahir" class="card jadwal-tab" style="display:none">
    <?php foreach ($mahir as $j): ?>
      <div class="jadwal-card">
        <strong><?= $j['hari'] ?></strong> - <?= $j['waktu'] ?> @ <?= $j['tempat'] ?>
      </div>
    <?php endforeach; ?>
  </div>

  <!-- GALERI -->
  <h2 class="section-title" style="margin-top:3rem;">Galeri Kegiatan</h2>
  <?php if ($galeri && $galeri->num_rows > 0): ?>
    <div class="galeri-grid">
      <?php while ($img = $galeri->fetch_assoc()): ?>
        <div>
          <img src="admin/uploads/galeri/<?= htmlspecialchars($img['gambar']) ?>" alt="Galeri">
          <?php if (!empty($img['caption'])): ?>
            <div class="caption"><?= htmlspecialchars($img['caption']) ?></div>
          <?php endif; ?>
        </div>
      <?php endwhile; ?>
    </div>
  <?php else: ?>
    <p>Belum ada galeri tersedia.</p>
  <?php endif; ?>
</div>

<script>
function showTab(tabId) {
  document.querySelectorAll('.jadwal-tab').forEach(tab => tab.style.display = 'none');
  document.getElementById(tabId).style.display = 'block';
  document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
  event.target.classList.add('active');
}
</script>

<?php include 'footer.php'; ?>
</body>
</html>
