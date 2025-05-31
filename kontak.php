<?php
session_start();
include 'header.php';
include 'koneksi/koneksi.php';

// --- Ambil gambar banner ---
$sql = "SELECT banner_image FROM settings WHERE id = 1 LIMIT 1";
$result = $conn->query($sql);
$bannerImage = 'default-banner.jpg';
if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if (!empty($row['banner_image'])) {
        $bannerImage = $row['banner_image'];
    }
}

// --- Logika form ---
$errorMsg = $successMsg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = trim($_POST['nama'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $telp = trim($_POST['telp'] ?? '');
    $subjek = trim($_POST['subjek'] ?? '');
    $pesan = trim($_POST['pesan'] ?? '');

    if ($nama === '' || $email === '' || $pesan === '') {
        $errorMsg = "Nama, Email, dan Pesan wajib diisi.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errorMsg = "Email tidak valid.";
    } else {
        $stmt = $conn->prepare("INSERT INTO pesan (nama, email, telp, subjek, pesan, tanggal_kirim) VALUES (?, ?, ?, ?, ?, NOW())");
        $stmt->bind_param("sssss", $nama, $email, $telp, $subjek, $pesan);
        if ($stmt->execute()) {
            $successMsg = "Pesan berhasil dikirim!";
            $nama = $email = $telp = $subjek = $pesan = '';
        } else {
            $errorMsg = "Gagal mengirim pesan, coba lagi.";
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Hubungi Kami</title>

<style>
  /* Banner style */
  .banner {
    position: relative;
    height: 50vh;
    display: flex;
    justify-content: center;
    align-items: center;
    color: white;
    text-align: center;
    background:
      linear-gradient(rgba(0,0,0,0.45), rgba(0,0,0,0.45)),
      url('admin/uploads/<?= htmlspecialchars($bannerImage); ?>');
    background-size: cover;
    background-position: center;
    box-shadow: inset 0 0 60px rgba(0,0,0,0.5);
  }
  .banner h1 {
    font-size: 2.5rem;
    font-weight: bold;
    text-shadow: 2px 2px 6px rgba(0,0,0,0.7);
  }
  .banner p {
    margin-top: 0.75rem;
    font-size: 1.1rem;
    color: #eee;
    text-shadow: 1px 1px 4px rgba(0,0,0,0.6);
  }

  @media (max-width: 768px) {
    .banner {
      height: 220px;
      padding: 1rem;
    }
    .banner h1 {
      font-size: 1.7rem;
    }
    .banner p {
      font-size: 0.95rem;
    }
  }

  /* Kontainer utama */
  .container {
    max-width: 600px;
    margin: 2rem auto 4rem;
    padding: 0 1rem;
  }

  /* Form style */
  form {
    background-color: #fff;
    border-radius: 12px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    padding: 2rem 2.5rem;
    display: flex;
    flex-direction: column;
    gap: 1.2rem;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;

    align-items: center; /* Center children horizontally */
  }
  form h2 {
    color: #2f855a;
    margin-bottom: 1rem;
  }
  form input[type="text"],
  form input[type="email"] {
    width: 100%;
    border: 1.5px solid #cbd5e0;
    border-radius: 8px;
    padding: 0.6rem 1rem;
    font-size: 1rem;
    transition: border-color 0.3s ease;
  }
  form input[type="text"]:focus,
  form input[type="email"]:focus,
  form textarea:focus {
    outline: none;
    border-color: #38a169;
    box-shadow: 0 0 6px #38a169aa;
  }
  form textarea {
    min-height: 120px;
    width: 80%;
    max-width: 600px;
    border: 1.5px solid #cbd5e0;
    border-radius: 8px;
    padding: 0.6rem 1rem;
    font-size: 1rem;
    resize: vertical;
  }
  form button {
    background-color: #2f855a;
    color: white;
    font-weight: 700;
    font-size: 1.1rem;
    padding: 0.7rem 1.8rem;
    border: none;
    border-radius: 8px;
    cursor: pointer;

    display: flex;
    align-items: center;
    gap: 0.6rem;
    transition: background-color 0.3s ease;

    align-self: center;
  }
  form button:hover {
    background-color: #276749;
  }
  .error-msg {
    color: #e53e3e;
    font-weight: 600;
    background-color: #fed7d7;
    padding: 0.6rem 1rem;
    border-radius: 6px;
    width: 100%;
    text-align: center;
  }
  .success-msg {
    color: #2f855a;
    font-weight: 600;
    background-color: #c6f6d5;
    padding: 0.6rem 1rem;
    border-radius: 6px;
    width: 100%;
    text-align: center;
  }
</style>

<!-- Banner -->
<div class="banner" role="banner" aria-label="Banner Hubungi Kami">
    <div>
        <h1>HUBUNGI KAMI</h1>
        <p>Kami siap membantu dan menjawab pertanyaan Anda kapan pun dibutuhkan.</p>
    </div>
</div>

<!-- Konten -->
<div class="container">
  <!-- Form -->
  <form method="post" autocomplete="off" novalidate>
    <h2>Kirim Pesan</h2>

    <?php if ($errorMsg): ?>
      <div class="error-msg" role="alert"><?= htmlspecialchars($errorMsg) ?></div>
    <?php elseif ($successMsg): ?>
      <div class="success-msg" role="status"><?= htmlspecialchars($successMsg) ?></div>
    <?php endif; ?>

    <input name="nama" type="text" required placeholder="Nama Lengkap" value="<?= htmlspecialchars($nama ?? '') ?>" aria-label="Nama Lengkap" />
    <input name="email" type="email" required placeholder="Email" value="<?= htmlspecialchars($email ?? '') ?>" aria-label="Email" />
    <input name="telp" type="text" placeholder="Nomor Telepon" value="<?= htmlspecialchars($telp ?? '') ?>" aria-label="Nomor Telepon" />
    <input name="subjek" type="text" placeholder="Subjek" value="<?= htmlspecialchars($subjek ?? '') ?>" aria-label="Subjek" />
    
    <textarea name="pesan" rows="5" required placeholder="Pesan Anda..." aria-label="Pesan Anda"><?= htmlspecialchars($pesan ?? '') ?></textarea>

    <button type="submit" aria-label="Kirim Pesan"><i class="fas fa-paper-plane"></i> Kirim</button>
  </form>
</div>

<!-- Load Font Awesome for icons -->
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

</body>
</html>
<?php include 'footer.php'; ?>
