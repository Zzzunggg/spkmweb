<?php
session_start();
include '../koneksi/koneksi.php'; // koneksi dengan variabel $conn

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = trim($_POST['username'] ?? '');
  $password = $_POST['password'] ?? '';
  $password2 = $_POST['password2'] ?? '';
  $email = trim($_POST['email'] ?? '');

  if (!$username || !$password || !$password2 || !$email) {
    $message = 'Semua field harus diisi.';
  } elseif ($password !== $password2) {
    $message = 'Password dan konfirmasi password tidak cocok.';
  } else {
    // cek username/email sudah dipakai?
    $stmt = $conn->prepare("SELECT COUNT(*) AS cnt FROM users WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row['cnt'] > 0) {
      $message = 'Username atau email sudah dipakai.';
    } else {
      // simpan user baru
      $hash = password_hash($password, PASSWORD_DEFAULT);
      $stmt = $conn->prepare("INSERT INTO users (username, password, email) VALUES (?, ?, ?)");
      $stmt->bind_param("sss", $username, $hash, $email);

      if ($stmt->execute()) {
        header('Location: login.php');
        exit;
      } else {
        $message = 'Gagal menyimpan data.';
      }
    }
    $stmt->close();
  }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8"/>
  <title>Daftar Akun</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            greenlight: '#d7f8d7',
            greenprimary: '#2e7d32',
            greenhover: '#256029'
          }
        }
      }
    }
  </script>
</head>
<body class="bg-gradient-to-br from-green-100 via-green-50 to-greenlight min-h-screen flex items-center justify-center px-4">

  <div class="w-full max-w-sm bg-white rounded-2xl shadow-2xl p-8 border-t-4 border-greenprimary">
    <div class="text-center mb-6">
      <h1 class="text-greenprimary text-3xl font-extrabold tracking-wide mb-1">Daftar Akun</h1>
      <p class="text-sm text-gray-500">Buat akun admin baru di sini</p>
    </div>

    <?php if ($message): ?>
      <div class="mb-4 bg-red-100 text-red-700 p-3 rounded-md text-sm font-medium text-center">
        <?= htmlspecialchars($message) ?>
      </div>
    <?php endif; ?>

    <form method="post" class="space-y-4">
      <div>
        <label class="block text-sm font-semibold text-greenprimary mb-1">Username</label>
        <input type="text" name="username" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-greenprimary" required>
      </div>
      <div>
        <label class="block text-sm font-semibold text-greenprimary mb-1">Email</label>
        <input type="email" name="email" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-greenprimary" required>
      </div>
      <div>
        <label class="block text-sm font-semibold text-greenprimary mb-1">Password</label>
        <input type="password" name="password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-greenprimary" required>
      </div>
      <div>
        <label class="block text-sm font-semibold text-greenprimary mb-1">Konfirmasi Password</label>
        <input type="password" name="password2" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-greenprimary" required>
      </div>

      <button type="submit" class="w-full bg-greenprimary hover:bg-greenhover text-white font-bold py-2 rounded-lg transition duration-200">
        Daftar
      </button>
    </form>

    <p class="text-center text-sm text-gray-600 mt-6">
      Sudah punya akun? 
      <a href="login.php" class="text-greenprimary font-semibold hover:underline">Login di sini</a>
    </p>
  </div>

</body>
</html>

