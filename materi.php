<?php
include 'koneksi/koneksi.php';
include 'header.php'; // sudah ada css header/footer tersendiri

// Ambil gambar banner dari database
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
  <title>Jurus Dasar Langkah Segitiga</title>
  <style>
    /* CSS khusus tampilan materi */

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

    .banner b {
      font-size: 2.5rem;
      font-weight: 700;
    }

    .banner p {
      font-size: 1.1rem;
      margin-top: 1rem;
      max-width: 600px;
      margin-left: auto;
      margin-right: auto;
    }

    .container {
      display: flex;
      gap: 2rem;
      max-width: 1200px;
      margin: 3rem auto;
      padding: 0 1rem;
    }

    aside.sidebar {
      flex: 1;
    }

    article.content {
      flex: 2.5;
      background: white;
      padding: 2rem;
      border-radius: 16px;
      box-shadow: 0 8px 20px rgba(0,0,0,0.05);
    }

    nav.box, section.box-download {
      background: white;
      border-radius: 12px;
      padding: 1.5rem;
      box-shadow: 0 4px 12px rgba(0,0,0,0.04);
      margin-bottom: 2rem;
      cursor: pointer;
      transition: transform 0.2s ease, box-shadow 0.2s ease;
      user-select: none;
    }

    /* Box yang bisa diklik */
    nav.box:hover, nav.box:focus {
      transform: translateY(-4px);
      box-shadow: 0 8px 20px rgba(0,0,0,0.12);
      outline: none;
    }

    nav.box:active {
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(0,0,0,0.15);
    }

    /* Box download tidak clickable secara keseluruhan */
    section.box-download {
      cursor: default;
      user-select: text;
    }

    nav.box h4, section.box-download h4 {
      font-size: 1.1rem;
      font-weight: 600;
      margin-bottom: 1rem;
      border-left: 4px solid #4caf50;
      padding-left: 0.6rem;
    }

    nav.box ul {
      list-style: none;
      padding-left: 0;
      margin: 0;
    }

    nav.box ul li {
      margin-bottom: 0.5rem;
    }

    nav.box ul li a {
      color: #333;
      font-size: 0.95rem;
      text-decoration: none;
      pointer-events: none; /* agar klik tidak double */
      cursor: default;
    }

    .btn-download {
      display: inline-block;
      margin-top: 0.5rem;
      padding: 0.6rem 1.2rem;
      background: #4caf50;
      color: white;
      border-radius: 8px;
      font-weight: 600;
      font-size: 0.95rem;
      transition: 0.3s;
      text-decoration: none;
    }

    .btn-download:hover,
    .btn-download:focus {
      background: #43a047;
      outline: none;
    }

    h1 {
      font-size: 2rem;
      font-weight: 700;
    }

    h2 {
      font-size: 1.3rem;
      margin-top: 2rem;
      margin-bottom: 1rem;
      font-weight: 600;
    }

    .img-container {
      margin: 1.5rem 0;
      text-align: center;
    }

    .img-container img {
      max-width: 100%;
      border-radius: 12px;
      box-shadow: 0 6px 12px rgba(0,0,0,0.05);
    }

    iframe {
      border: none;
      border-radius: 12px;
    }

    /* Responsive */
    @media (max-width: 768px) {
      .container {
        flex-direction: column;
      }
      .banner b {
        font-size: 2rem;
      }
    }
  </style>
</head>
<body>

<section class="banner" role="banner" aria-label="Banner Materi Jurus Dasar Langkah Segitiga">
  <div>
    <b>MATERI KAMI</b>
    <p>Materi tingkat dasar mengenai gerakan kaki dalam membentuk pola segitiga untuk pertahanan dan serangan dasar pencak silat.</p>
  </div>
</section>

<div class="container">
  <aside class="sidebar" role="navigation" aria-label="Navigasi Materi">
    <nav class="box" tabindex="0" aria-labelledby="judul-dasar" role="link" onclick="window.location.href='materi_dasar.php'" onkeypress="if(event.key==='Enter'){window.location.href='materi_dasar.php'}">
      <h4 id="judul-dasar">Daftar Materi Tingkat Dasar</h4>
      <ul>
        <li><a href="materi_dasar.php" tabindex="-1" aria-hidden="true">Kuda-Kuda Dasar</a></li>
        <li><a href="materi_dasar.php#tangkisan-dasar" tabindex="-1" aria-hidden="true">Tangkisan Dasar</a></li>
        <li><a href="materi_dasar.php#langkah-segitiga" tabindex="-1" aria-hidden="true" aria-current="page">Jurus Dasar Langkah Segitiga</a></li>
      </ul>
    </nav>

    <nav class="box" tabindex="0" aria-labelledby="judul-menengah" role="link" onclick="window.location.href='materi_menengah.php'" onkeypress="if(event.key==='Enter'){window.location.href='materi_menengah.php'}">
      <h4 id="judul-menengah">Daftar Materi Tingkat Menengah</h4>
      <ul>
        <li><a href="materi_menengah.php#pukulan-tangkisan" tabindex="-1" aria-hidden="true">Kombinasi Pukulan dan Tangkisan</a></li>
        <li><a href="materi_menengah.php#tendangan" tabindex="-1" aria-hidden="true">Tendangan Dasar dan Samping</a></li>
      </ul>
    </nav>

    <nav class="box" tabindex="0" aria-labelledby="judul-mahir" role="link" onclick="window.location.href='materi_mahir.php'" onkeypress="if(event.key==='Enter'){window.location.href='materi_mahir.php'}">
      <h4 id="judul-mahir">Daftar Materi Tingkat Mahir</h4>
      <ul>
        <li><a href="materi_mahir.php#sapuan-kuncian" tabindex="-1" aria-hidden="true">Teknik Sapuan dan Kuncian</a></li>
        <li><a href="materi_mahir.php#seni-gerakan" tabindex="-1" aria-hidden="true">Seni Gerakan Jurus</a></li>
      </ul>
    </nav>

    <section class="box box-download" tabindex="0" aria-label="Download Materi Terbaru">
      <h4>Unduh Materi Terbaru</h4>
      <?php
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
    <ol class="list-decimal">
      <li>Berdiri dengan kaki sejajar dan tubuh rileks.</li>
      <li>Langkahkan kaki kanan ke depan membentuk sudut segitiga.</li>
      <li>Langkahkan kaki kiri menyilang ke belakang kaki kanan.</li>
      <li>Kembali ke posisi awal dan ulangi pola secara bergantian.</li>
    </ol>

    <h2>Manfaat Latihan</h2>
    <ul class="list-disc">
      <li>Meningkatkan keseimbangan tubuh.</li>
      <li>Memperkuat otot kaki dan postur tubuh.</li>
      <li>Menambah kelincahan dalam menghadapi lawan.</li>
      <li>Menjadi dasar untuk jurus lanjutan.</li>
    </ul>

    <h2>Video Pembelajaran</h2>
    <div style="position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden;">
      <iframe src="https://www.youtube.com/embed/YOUR_VIDEO_ID" title="Video Langkah Segitiga" allowfullscreen style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;"></iframe>
    </div>

    <h2>Tips Latihan Mandiri</h2>
    <ul class="list-disc">
      <li>Lakukan di ruang terbuka agar lebih leluasa.</li>
      <li>Gunakan cermin untuk memperbaiki postur.</li>
      <li>Latihan secara rutin minimal 3 kali seminggu.</li>
    </ul>
  </article>
</div>

<?php include 'footer.php'; ?>
</body>
</html>
