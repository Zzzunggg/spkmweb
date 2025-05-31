<?php 
include 'koneksi/koneksi.php'; 
include 'header.php'; 

// Ambil data materi dasar
$materi = $conn->query("SELECT * FROM materi_dasar ORDER BY id DESC");

// Ambil gambar banner
$bannerImage = 'default-banner.jpg';
$sql = "SELECT banner_image FROM settings WHERE id = 1 LIMIT 1";
$result = $conn->query($sql);
if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if (!empty($row['banner_image'])) {
        $bannerImage = $row['banner_image'];
    }
}
?>

<style>
  .banner {
    position: relative;
    height: 50vh;
    background: linear-gradient(rgba(0,0,0,0.45), rgba(0,0,0,0.45)),
                url('admin/uploads/<?= htmlspecialchars($bannerImage) ?>') center/cover no-repeat;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    color: white;
    text-align: center;
    padding: 2rem;
  }

  .banner b {
    font-size: 2.8rem;
    font-weight: 700;
  }

  .banner p {
    font-size: 1.2rem;
    margin-top: 1rem;
    max-width: 700px;
  }

  .container {
    display: flex;
    gap: 2rem;
    max-width: 1200px;
    margin: 3rem auto;
    padding: 0 1rem;
    flex-wrap: wrap;
  }

  aside.sidebar {
    flex: 1 1 250px;
    background-color: #f4f8f4;
    border-radius: 10px;
    padding: 1.5rem;
    box-shadow: 0 6px 16px rgba(0,0,0,0.05);
  }

  aside.sidebar h4 {
    font-size: 1.4rem;
    margin-bottom: 1.2rem;
    border-bottom: 2px solid #337a33;
    padding-bottom: 0.5rem;
  }

  aside.sidebar ul {
    list-style: none;
    padding: 0;
  }

  aside.sidebar li {
    margin-bottom: 0.8rem;
  }

  aside.sidebar a {
    display: block;
    padding: 10px 14px;
    background: #e6f2e6;
    color: #145214;
    border-radius: 8px;
    font-weight: 500;
    transition: background 0.3s;
  }

  aside.sidebar a:hover {
    background: #cdeccd;
    text-decoration: none;
  }

  article.content {
    flex: 3 1 700px;
    background: white;
    padding: 2rem;
    border-radius: 10px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.08);
  }

  article.content h1 {
    font-size: 2.2rem;
    margin-bottom: 1rem;
    color: #145214;
  }

  article.content p.intro {
    font-size: 1.1rem;
    margin-bottom: 2rem;
    color: #444;
  }

  .materi-list {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
    gap: 1.5rem;
  }

  .materi-card {
    background: #f0f8f0;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 6px 18px rgba(0, 100, 0, 0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    display: flex;
    flex-direction: column;
  }

  .materi-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 10px 24px rgba(0, 128, 0, 0.2);
  }

  .materi-card img {
    width: 100%;
    height: 180px;
    object-fit: cover;
  }

  .materi-card-content {
    padding: 1.2rem;
    display: flex;
    flex-direction: column;
    height: 100%;
  }

  .materi-card-content h3 {
    font-size: 1.3rem;
    color: #145214;
    margin-bottom: 0.6rem;
  }

  .materi-card-content p {
    font-size: 0.95rem;
    color: #333;
    flex-grow: 1;
  }

  .materi-card-content a {
    margin-top: 1rem;
    display: inline-block;
    background: #145214;
    color: #fff;
    padding: 8px 16px;
    border-radius: 20px;
    font-weight: 600;
    font-size: 0.95rem;
    text-decoration: none;
    transition: background 0.3s ease;
  }

  .materi-card-content a:hover {
    background: #0e3d0e;
  }

  @media (max-width: 768px) {
    .container {
      flex-direction: column;
    }
    aside.sidebar, article.content {
      width: 100%;
    }
    .banner b {
      font-size: 2rem;
    }
    .banner p {
      font-size: 1rem;
    }
  }
</style>

<section class="banner">
  <b>MATERI TINGKAT DASAR</b>
  <p>Pelajari dasar-dasar pencak silat untuk membangun teknik dan kepercayaan diri yang kuat.</p>
</section>

<div class="container">
  <aside class="sidebar">
    <h4>Materi Lainnya</h4>
    <ul>
      <li><a href="#">Materi Dasar</a></li>
      <li><a href="materi_menengah.php">Materi Menengah</a></li>
      <li><a href="materi_mahir.php">Materi Mahir</a></li>
    </ul>
  </aside>

  <article class="content">
    <h1>Materi Tingkat Dasar</h1>
    <p class="intro">Berikut adalah daftar materi tingkat dasar yang dapat Anda pelajari secara bertahap.</p>

    <section class="materi-list">
      <?php while ($m = $materi->fetch_assoc()): ?>
        <div class="materi-card">
          <img src="admin/uploads/<?= htmlspecialchars($m['gambar']) ?>" alt="Gambar <?= htmlspecialchars($m['judul']) ?>" loading="lazy" />
          <div class="materi-card-content">
            <h3><?= htmlspecialchars($m['judul']) ?></h3>
            <p><?= htmlspecialchars($m['deskripsi_singkat']) ?></p>
            <a href="detail_materi_dasar.php?id=<?= $m['id'] ?>">Pelajari Materi →</a>
          </div>
        </div>
      <?php endwhile; ?>
    </section>
  </article>
</div>

<?php include 'footer.php'; ?>
