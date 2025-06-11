<?php
include 'koneksi/koneksi.php';
include 'header.php';

$sql = "SELECT banner_image FROM settings WHERE id = 1 LIMIT 1";
$resultBanner = $conn->query($sql);
$bannerImage = 'default-banner.jpg';
if ($resultBanner && $resultBanner->num_rows > 0) {
    $rowBanner = $resultBanner->fetch_assoc();
    if (!empty($rowBanner['banner_image'])) {
        $bannerImage = $rowBanner['banner_image'];
    }
}

$data = $conn->query("SELECT * FROM prestasi ORDER BY tanggal_upload DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Prestasi</title>
  <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet" />
  <style>
    .banner {
      position: relative;
      height: 50vh;
      display: flex;
      flex-direction: column;
      justify-content: center;
      text-align: center;
      color: white;
      padding: 0 1.5rem;
      overflow: hidden;
      background-image:
        linear-gradient(rgba(0,0,0,0.45), rgba(0,0,0,0.45)),
        url('admin/uploads/<?php echo htmlspecialchars($bannerImage); ?>');
      background-size: cover;
      background-position: center;
      box-shadow: inset 0 0 50px rgba(0,0,0,0.5);
      user-select: none;
    }
    .banner b {
      font-size: 2.5rem;
      font-weight: 700;
      max-width: 900px;
      margin: 0 auto;
      text-shadow: 1px 1px 4px rgba(0,0,0,0.7);
    }
    .banner p {
      margin-top: 1rem;
      max-width: 700px;
      font-size: 1.1rem;
      font-weight: 400;
      line-height: 1.4;
      margin-left: auto;
      margin-right: auto;
      text-shadow: 0 0 5px rgba(0,0,0,0.5);
    }

    .prestasi-container {
      display: flex;
      flex-direction: column;
      gap: 1.5rem;
      padding: 2rem 1rem 3rem;
      max-width: 1000px;
      margin: 0 auto;
    }

    .prestasi-box {
      background-color: #f9fafb;
      border-radius: 12px;
      display: flex;
      align-items: center;
      padding: 1.2rem;
      gap: 1.5rem;
      box-shadow: 0 2px 6px rgba(0,0,0,0.05);
      transition: transform 0.3s ease;
    }

    .prestasi-box:hover {
      transform: scale(1.02);
    }

    .prestasi-img {
      width: 90px;
      height: 90px;
      border-radius: 8px;
      object-fit: cover;
      background-color: #d1d5db;
      flex-shrink: 0;
    }

    .prestasi-content {
      display: flex;
      flex-direction: column;
    }

    .prestasi-title {
      font-size: 1rem;
      font-weight: 600;
      color: #111827;
      margin-bottom: 0.3rem;
    }

    .prestasi-desc {
      font-size: 0.9rem;
      color: #6b7280;
      margin: 0;
    }

    .no-data {
      text-align: center;
      width: 100%;
      color: #777;
      font-style: italic;
      margin: 3rem 0;
    }

    @media (max-width: 640px) {
      .prestasi-box {
        flex-direction: column;
        align-items: flex-start;
      }

      .prestasi-img {
        width: 100%;
        height: auto;
        border-radius: 10px;
      }

      .prestasi-content {
        width: 100%;
      }

      .prestasi-title {
        margin-top: 0.5rem;
      }
    }
  </style>
</head>
<body>

<section class="banner" role="banner" aria-label="Banner prestasi" data-aos="fade-down">
  <b>PRESTASI KAMI</b>
  <p>Berbagai pencapaian dan penghargaan yang telah kami raih sebagai bentuk dedikasi dan kualitas.</p>
</section>

<div class="prestasi-container" aria-live="polite" aria-relevant="additions" data-aos="fade-up">
  <?php if ($data && $data->num_rows > 0): ?>
    <?php
      $delay = 0;
      while ($row = $data->fetch_assoc()):
        $delay += 100;
    ?>
      <article class="prestasi-box" tabindex="0" data-aos="zoom-in" data-aos-delay="<?= $delay ?>" aria-label="Prestasi: <?= htmlspecialchars($row['nama']) ?>">
        <?php if ($row['foto'] && file_exists('admin/uploads/' . $row['foto'])): ?>
          <img src="admin/uploads/<?= htmlspecialchars($row['foto']) ?>" alt="<?= htmlspecialchars($row['nama']) ?>" class="prestasi-img" />
        <?php else: ?>
          <div class="prestasi-img" style="display:flex;align-items:center;justify-content:center;color:#6b7280;font-size:0.8rem;text-align:center;">
            Tidak ada gambar
          </div>
        <?php endif; ?>
        <div class="prestasi-content">
          <h2 class="prestasi-title"><?= htmlspecialchars($row['nama']) ?></h2>
          <p class="prestasi-desc"><?= nl2br(htmlspecialchars($row['deskripsi'])) ?></p>
        </div>
      </article>
    <?php endwhile; ?>
  <?php else: ?>
    <p class="no-data" data-aos="fade-up">Belum ada data prestasi saat ini.</p>
  <?php endif; ?>
</div>

<?php include 'footer.php'; ?>

<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
<script>
  AOS.init({
    duration: 800,
    once: true,
    offset: 50,
  });
</script>
</body>
</html>
