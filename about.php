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

    .container {
      max-width: 960px;
      margin: auto;
      padding: 3rem 1rem;
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
      margin-bottom: 3rem;
    }
    .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 12px 24px rgba(0,0,0,0.1);
    }

    .card p {
      margin-bottom: 1.2rem;
      font-size: 1.1rem;
    }

    .card ul {
      padding-left: 1.5rem;
    }

    .struktur-wrapper {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
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

<!-- ABOUT -->
<div class="container">
  <h2 class="section-title">Tentang Kami</h2>
  <div class="card">
    <p>Elite Training Center adalah pusat latihan bela diri dan kebugaran yang berdedikasi untuk membina generasi yang sehat, tangguh, dan berkarakter. Kami menyediakan program latihan dari tingkat dasar hingga mahir, yang dirancang oleh pelatih profesional dan berpengalaman.</p>
    <p>Dengan fasilitas yang lengkap dan lingkungan yang mendukung, kami percaya bahwa setiap individu dapat mencapai potensi terbaiknya. Elite Training Center tidak hanya mengedepankan kekuatan fisik, tetapi juga kedisiplinan, mental baja, dan semangat kebersamaan.</p>
    <p>Visi kami adalah menjadi pusat pelatihan terdepan di Indonesia yang mampu mencetak atlet-atlet berprestasi serta membentuk pribadi yang tangguh dan bertanggung jawab.</p>
    <p>Misi kami mencakup:</p>
    <ul>
      <li>Menyediakan pelatihan berkualitas untuk semua tingkatan usia dan kemampuan.</li>
      <li>Membangun komunitas yang solid dan suportif.</li>
      <li>Melahirkan generasi pemimpin yang sehat secara fisik dan mental.</li>
    </ul>
  </div>

  <!-- STRUKTUR ORGANISASI -->
  <h2 class="section-title">Struktur Organisasi</h2>
  <div class="struktur-wrapper">
    <?php
    $result = $conn->query("SELECT * FROM struktur_organisasi ORDER BY id ASC");
    if ($result && $result->num_rows > 0):
      while ($row = $result->fetch_assoc()):
    ?>
    <div class="struktur-card">
      <img src="admin/uploads/<?= htmlspecialchars($row['foto']) ?>" alt="<?= htmlspecialchars($row['nama']) ?>" class="struktur-foto" />
      <h3><?= htmlspecialchars($row['nama']) ?></h3>
      <p><?= htmlspecialchars($row['jabatan']) ?></p>
    </div>
    <?php endwhile; else: ?>
      <p>Tidak ada data struktur organisasi.</p>
    <?php endif; ?>
  </div>
</div>

<?php include 'footer.php'; ?>
</body>
</html>
