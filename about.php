<?php
include 'koneksi/koneksi.php';
include 'header.php';

// Ambil gambar banner
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
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Profil Organisasi</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet" />
  <style>
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body { font-family: 'Inter', sans-serif; line-height: 1.6; color: #333; background: #f9f9f9; }
    a { text-decoration: none; color: inherit; }

    .banner {
      position: relative;
      height: 50vh;
      background: linear-gradient(rgba(0,0,0,0.45), rgba(0,0,0,0.45)),
                  url('admin/uploads/<?= htmlspecialchars($bannerImage) ?>') center/cover no-repeat;
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      text-align: center;
      padding: 2rem;
    }
    .banner h1 {
      font-size: 3rem;
      font-weight: 700;
    }

    .content-center {
      max-width: 960px;
      margin: 0 auto;
      padding: 3rem 1rem;
    }

    .section-title {
      font-size: 2rem;
      font-weight: 700;
      margin-bottom: 2rem;
      color: #333;
      text-align: center;
    }

    .card {
      background: white;
      border-radius: 16px;
      padding: 2rem;
      box-shadow: 0 8px 20px rgba(0,0,0,0.07);
      transition: 0.3s;
      margin-bottom: 3rem;
    }
    .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 12px 24px rgba(0,0,0,0.1);
    }

    .card p {
      margin-bottom: 1.2rem;
      font-size: 1.1rem;
      text-align: justify;
    }

    .struktur-ketua-container {
      display: flex;
      justify-content: center;
      margin-bottom: 2rem;
    }

    .struktur-wrapper {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 1.5rem;
    }

    .struktur-card {
      background: white;
      text-align: center;
      padding: 1rem 1rem 1.5rem;
      border-radius: 12px;
      box-shadow: 0 6px 16px rgba(0,0,0,0.05);
      transition: 0.2s ease;
    }

    .struktur-card:hover {
      transform: translateY(-4px);
    }

    .struktur-foto {
      width: 110px;
      height: 110px;
      border-radius: 50%;
      object-fit: cover;
      border: 3px solid #4caf50;
      margin-bottom: 0.8rem;
    }

    .struktur-card h3 {
      font-size: 1.1rem;
      font-weight: 600;
    }

    .struktur-card p {
      font-size: 0.95rem;
      color: #555;
      font-style: italic;
    }

    @media (max-width: 768px) {
      .banner h1 {
        font-size: 2rem;
      }
    }
  </style>
</head>
<body>

<!-- BANNER -->
<section class="banner">
  <div>
    <h1>PROFIL KAMI</h1>
    <p>Kami siap membantu dan menjawab pertanyaan Anda kapan pun dibutuhkan.</p>
  </div>
</section>

<!-- ISI KONTEN -->
<div class="content-center">

  <!-- TENTANG KAMI -->
  <h2 class="section-title">Tentang Kami</h2>
  <div class="card">
    <p>
      Perguruan Silat SPKM (Surabaya Pencak Kordo Manyuro) merupakan salah satu perguruan pencak silat tertua dan berpengaruh di Indonesia. Didirikan pada tahun 1938 di Salatiga, Jawa Tengah, SPKM lahir dari semangat para pendekar tempo dulu untuk melestarikan warisan seni bela diri asli Nusantara yang kaya nilai budaya, spiritualitas, dan kearifan lokal. Seiring berjalannya waktu, SPKM berkembang pesat dan kini dikenal luas di berbagai daerah, khususnya di kota Surabaya. Perguruan ini menjadi rumah bagi para pesilat dari berbagai generasi, yang tidak hanya belajar teknik bela diri, tetapi juga dibina dalam hal kedisiplinan, etika, dan penguatan karakter. Nama Kordo Manyuro dalam SPKM mengandung filosofi mendalam. "Kordo" dimaknai sebagai jalan atau laku, sementara "Manyuro" berasal dari bahasa Jawa yang merujuk pada kekuatan batin dan pengendalian diri. Maka dari itu, SPKM tidak hanya mengajarkan kekuatan fisik, tetapi juga menanamkan nilai-nilai spiritual, rasa hormat kepada guru, serta kepedulian terhadap sesama dan lingkungan.
    </p>
  </div>

  <!-- STRUKTUR ORGANISASI -->
  <h2 class="section-title">Struktur Organisasi</h2>

  <?php
    $query = $conn->query("SELECT * FROM struktur_organisasi ORDER BY id ASC");
    $ketua = null;
    $anggota = [];

    while ($row = $query->fetch_assoc()) {
      if (stripos($row['jabatan'], 'ketua umum') !== false) {
        $ketua = $row;
      } else {
        $anggota[] = $row;
      }
    }
  ?>

  <!-- Ketua -->
  <?php if ($ketua): ?>
    <div class="struktur-ketua-container">
      <div class="struktur-card">
        <img src="admin/uploads/<?= htmlspecialchars($ketua['foto']) ?>" alt="<?= htmlspecialchars($ketua['nama']) ?>" class="struktur-foto" />
        <h3><?= htmlspecialchars($ketua['nama']) ?></h3>
        <p><?= htmlspecialchars($ketua['jabatan']) ?></p>
      </div>
    </div>
  <?php endif; ?>

  <!-- Anggota -->
  <div class="struktur-wrapper">
    <?php foreach ($anggota as $row): ?>
      <div class="struktur-card">
        <img src="admin/uploads/<?= htmlspecialchars($row['foto']) ?>" alt="<?= htmlspecialchars($row['nama']) ?>" class="struktur-foto" />
        <h3><?= htmlspecialchars($row['nama']) ?></h3>
        <p><?= htmlspecialchars($row['jabatan']) ?></p>
      </div>
    <?php endforeach; ?>
  </div>

</div>

<?php include 'footer.php'; ?>
</body>
</html>
