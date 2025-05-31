<?php 
include 'koneksi/koneksi.php'; 

$id = $_GET['id'];

// Ambil data materi berdasarkan ID
$stmt = $conn->prepare("SELECT * FROM materi_mahir WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$materi = $result->fetch_assoc();

// Ambil materi lain
$materi_lain = $conn->prepare("SELECT * FROM materi_mahir WHERE id != ? ORDER BY id DESC LIMIT 5");
$materi_lain->bind_param("i", $id);
$materi_lain->execute();
$materi_lain_result = $materi_lain->get_result();
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title><?= htmlspecialchars($materi['judul']) ?> - Detail Materi</title>
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f0f4f3;
      color: #333;
      line-height: 1.6;
    }

    .container {
      max-width: 1000px;
      margin: 50px auto;
      padding: 0 20px;
      animation: fadeIn 0.5s ease-in-out;
    }

    h2 {
      font-size: 30px;
      color: #1b5e20;
      margin-bottom: 20px;
      border-bottom: 3px solid #1b5e20;
      padding-bottom: 8px;
    }

    .materi-image {
      width: 100%;
      max-height: 400px;
      object-fit: cover;
      border-radius: 12px;
      margin-bottom: 25px;
      box-shadow: 0 6px 16px rgba(0,0,0,0.1);
    }

    .deskripsi {
      font-size: 16px;
      margin-bottom: 30px;
    }

    a.kembali {
      display: inline-block;
      margin-top: 10px;
      background-color: #1b5e20;
      color: #fff;
      padding: 10px 16px;
      border-radius: 8px;
      text-decoration: none;
      transition: background 0.3s ease;
    }

    a.kembali:hover {
      background-color: #2e7d32;
    }

    .materi-lainnya {
      margin-top: 60px;
    }

    .materi-lainnya h3 {
      font-size: 22px;
      color: #1b5e20;
      margin-bottom: 20px;
      border-bottom: 2px solid #1b5e20;
      padding-bottom: 6px;
    }

    .materi-lain-list {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
      gap: 20px;
    }

    .materi-item {
      background: white;
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 4px 12px rgba(0,0,0,0.08);
      transition: transform 0.2s ease;
    }

    .materi-item:hover {
      transform: translateY(-4px);
    }

    .materi-item img {
      width: 100%;
      height: 130px;
      object-fit: cover;
    }

    .materi-item a {
      display: block;
      padding: 12px;
      font-weight: 600;
      font-size: 15px;
      color: #2e7d32;
      text-decoration: none;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    @media (max-width: 600px) {
      h2 { font-size: 24px; }
    }
  </style>
</head>
<body>

<div class="container">
  <!-- Materi Utama -->
  <h2><?= htmlspecialchars($materi['judul']) ?></h2>
  <img src="admin/uploads/<?= htmlspecialchars($materi['gambar']) ?>" class="materi-image" alt="Gambar Materi">
  <div class="deskripsi">
    <p><strong>Deskripsi:</strong></p>
    <p><?= nl2br(htmlspecialchars($materi['deskripsi_lengkap'])) ?></p>
  </div>
  <a class="kembali" href="materi_mahir.php">← Kembali ke Materi</a>

  <!-- Materi Lainnya -->
  <div class="materi-lainnya">
    <h3>Materi Lainnya</h3>
    <div class="materi-lain-list">
      <?php while($m = $materi_lain_result->fetch_assoc()): ?>
        <div class="materi-item">
          <img src="admin/uploads/<?= htmlspecialchars($m['gambar']) ?>" alt="<?= htmlspecialchars($m['judul']) ?>">
          <a href="detail_materi_mahir.php?id=<?= $m['id'] ?>">
            <?= htmlspecialchars($m['judul']) ?>
          </a>
        </div>
      <?php endwhile; ?>
    </div>
  </div>
</div>

<?php include 'footer.php'; ?>
</body>
</html>
