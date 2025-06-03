<?php
$siteTitle = "Admin";
$siteTagline = "admin";

$menus = [
  'admin_banner.php' => 'Upload Banner',
  'upload_materi.php' => 'Upload Materi',
  'admin_upload_materi.php' => 'Upload materi PDF',
  'upload_data_kegiatan.php' => 'Data Kegiatan',
  'pelatih.php' => 'Data Pelatih',
  'anggota.php' => 'Data Anggota',
  'jadwal_latihan.php' => 'Jadwal Latihan',
  'prestasi.php' => 'Prestasi',
  'upload_sambutan.php' => 'Sambutan Ketua',
  'upload_galeri.php' => 'Galeri',
  'struktur_organisasi.php' => 'Struktur Organisasi',
  'kontak.php' => 'Contact',
  'login.php' => 'Login',
  'register.php' => 'Daftar Akun',
  'logout.php' => 'Log Out'
];

$currentPage = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <title><?php echo $siteTitle; ?></title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/js/all.min.js"></script>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap');
    body { font-family: 'Inter', sans-serif; }
  </style>
</head>
<body class="bg-gray-100">

<div class="flex min-h-screen">
  <!-- Sidebar -->
  <aside class="w-64 bg-gradient-to-b from-lime-500 to-emerald-700 text-white hidden sm:block">
    <div class="p-6 border-b border-lime-400">
      <div class="flex items-center">
        <div class="ml-3">
          <h1 class="font-semibold text-lg"><?php echo $siteTitle; ?></h1>
          <p class="text-sm text-lime-200"><?php echo $siteTagline; ?></p>
        </div>
      </div>
    </div>
    <nav class="p-4 space-y-2 text-sm">
      <?php foreach ($menus as $url => $label): ?>
        <a href="<?php echo $url; ?>" class="block px-4 py-2 rounded <?php echo ($url == $currentPage) ? 'bg-lime-400 font-bold text-gray-900' : 'hover:bg-emerald-600'; ?>">
          <?php echo $label; ?>
        </a>
      <?php endforeach; ?>
    </nav>
  </aside>

  <!-- Mobile Header -->
  <div class="sm:hidden fixed top-0 left-0 w-full bg-emerald-800 text-white border-b shadow z-50 flex justify-between items-center px-4 py-3">
    <div class="flex items-center">
      <div class="ml-2">
        <h1 class="font-semibold text-lg"><?php echo $siteTitle; ?></h1>
        <p class="text-xs text-lime-200"><?php echo $siteTagline; ?></p>
      </div>
    </div>
    <button id="mobileToggle" class="text-white text-2xl"><i class="fas fa-bars"></i></button>
  </div>

  <!-- Mobile Sidebar -->
  <div id="mobileSidebar" class="sm:hidden fixed top-16 left-0 w-64 h-full bg-gradient-to-b from-lime-500 to-emerald-700 text-white shadow-lg transform -translate-x-full transition-transform duration-300 z-40">
    <nav class="p-4 space-y-2 text-sm">
      <?php foreach ($menus as $url => $label): ?>
        <a href="<?php echo $url; ?>" class="block px-4 py-2 rounded <?php echo ($url == $currentPage) ? 'bg-lime-400 font-bold text-gray-900' : 'hover:bg-emerald-600'; ?>">
          <?php echo $label; ?>
        </a>
      <?php endforeach; ?>
    </nav>
  </div>

  <!-- Main Content -->
  <main class="flex-1 p-6 mt-16 sm:mt-0">
    <!-- === ISI HALAMAN DI SINI === -->
