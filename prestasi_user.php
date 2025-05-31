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
<style>
  /* Reset margin & padding agar konsisten */

  /* Banner style */
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

  /* Container grid untuk box prestasi */
  .prestasi-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 1.5rem;
    padding: 2rem 1rem 3rem;
    max-width: 1200px;
    margin: 0 auto;
  }

  /* Box prestasi */
  .prestasi-box {
    background-color: #fff;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 6px 10px rgba(0,0,0,0.08);
    cursor: pointer;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    display: flex;
    flex-direction: column;
    height: 100%;
    outline: none;
  }

  .prestasi-box:focus {
    box-shadow: 0 0 0 3px #005fcc;
    transform: scale(1.05);
  }

  /* Hover efek: scale & shadow */
  .prestasi-box:hover {
    transform: scale(1.05);
    box-shadow: 0 12px 20px rgba(0,0,0,0.15);
  }

  /* Gambar prestasi */
  .prestasi-img {
    width: 100%;
    height: 160px;
    object-fit: cover;
    border-bottom: 1px solid #eee;
    flex-shrink: 0;
  }

  /* Konten prestasi */
  .prestasi-content {
    padding: 1rem 1.2rem;
    flex-grow: 1;
    display: flex;
    flex-direction: column;
  }

  /* Judul */
  .prestasi-title {
    font-weight: 700;
    font-size: 1.2rem;
    margin-bottom: 0.6rem;
    color: #222;
  }

  /* Deskripsi */
  .prestasi-desc {
    flex-grow: 1;
    font-size: 0.95rem;
    color: #555;
    line-height: 1.4;
    margin-bottom: 1rem;
    white-space: pre-line;
  }

  /* Tanggal upload */
  .prestasi-date {
    font-size: 0.85rem;
    color: #999;
    text-align: right;
    font-style: italic;
  }

  /* Pesan kosong */
  .no-data {
    text-align: center;
    width: 100%;
    color: #777;
    font-style: italic;
    margin: 3rem 0;
  }

  /* Responsive tweaks */
  @media (max-width: 480px) {
    .banner b {
      font-size: 1.8rem;
    }
    .banner p {
      font-size: 1rem;
    }
  }
</style>
</head>
<body>

<section class="banner" role="banner" aria-label="Banner prestasi">
  <b>PRESTASI KAMI</b>
  <p>Berbagai pencapaian dan penghargaan yang telah kami raih sebagai bentuk dedikasi dan kualitas.</p>
</section>

<div class="prestasi-container" aria-live="polite" aria-relevant="additions">
  <?php if ($data && $data->num_rows > 0): ?>
    <?php while ($row = $data->fetch_assoc()): ?>
      <article class="prestasi-box" tabindex="0" aria-label="Prestasi: <?= htmlspecialchars($row['nama']) ?>">
        <?php if ($row['foto'] && file_exists('admin/uploads/' . $row['foto'])): ?>
          <img src="admin/uploads/<?= htmlspecialchars($row['foto']) ?>" alt="<?= htmlspecialchars($row['nama']) ?>" class="prestasi-img" />
        <?php else: ?>
          <img src="https://via.placeholder.com/400x160?text=No+Image" alt="Gambar tidak tersedia" class="prestasi-img" />
        <?php endif; ?>
        <div class="prestasi-content">
          <h2 class="prestasi-title"><?= htmlspecialchars($row['nama']) ?></h2>
          <p class="prestasi-desc"><?= nl2br(htmlspecialchars($row['deskripsi'])) ?></p>
          <time datetime="<?= date('Y-m-d', strtotime($row['tanggal_upload'])) ?>" class="prestasi-date"><?= date('d M Y', strtotime($row['tanggal_upload'])) ?></time>
        </div>
      </article>
    <?php endwhile; ?>
  <?php else: ?>
    <p class="no-data">Belum ada data prestasi saat ini.</p>
  <?php endif; ?>
</div>

<?php include 'footer.php'; ?>

</body>
</html>
