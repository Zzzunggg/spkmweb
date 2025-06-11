<?php
session_start();
include '../koneksi/koneksi.php'; // koneksi database dengan variabel $conn
if (isset($_SESSION['username'])) {
    header('Location: admin_banner.php'); 
    exit;
}
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = $_POST['username'] ?? '';
  $password = $_POST['password'] ?? '';

  if ($username && $password) {
    // prepare statement dengan mysqli
    $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
      // Login sukses
      $_SESSION['user_id'] = $user['id'];
      $_SESSION['username'] = $user['username'];
      header('Location: admin_banner.php'); // arahkan ke halaman utama setelah login
      exit;
    } else {
      $message = 'Username atau password salah.';
    }

    $stmt->close();
  } else {
    $message = 'Isi username dan password.';
  }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8"/>
  <title>Login Admin</title>
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
      <div class="text-greenprimary text-4xl font-extrabold tracking-wide mb-2">Login Admin</div>
      <p class="text-sm text-gray-500">Silakan masuk ke panel admin</p>
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
        <label class="block text-sm font-semibold text-greenprimary mb-1">Password</label>
        <input type="password" name="password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-greenprimary" required>
      </div>

      <button type="submit" class="w-full bg-greenprimary hover:bg-greenhover text-white font-bold py-2 rounded-lg transition duration-200">
        Masuk
      </button>
    </form>

  
  </div>

</body>
</html>
