<?php
$logoSrc = "https://storage.googleapis.com/a1aa/image/ddfdca28-b56a-49c2-577d-f7ea42df6653.jpg";
$siteTitle = "Website";
$siteTagline = "Tahun 0000";

$menus = [
  'index.php' => 'Home',
  'materi.php' => 'Materi',
  'prestasi_user.php' => 'Prestasi',
  'kontak.php' => 'Contact',
  'about.php' => 'About'
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
    /* Tambahkan transisi untuk kehalusan */
    #mainHeader, #mainHeader div, #mainHeader img, #mainHeader h1, #mainHeader p, #mainHeader nav a {
        transition: all 0.3s ease-in-out;
    }
  </style>
</head>
<body class="bg-white">

<header id="mainHeader" class="sticky top-0 z-50 bg-green-600 shadow-md">
  <div id="headerContainer" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4"> {/* ID ditambahkan */}
    <div class="flex items-center justify-between">
      <div class="flex items-center space-x-4">
        <img id="headerLogo" src="<?php echo $logoSrc; ?>" alt="Logo" class="h-14 w-14 rounded-full object-cover"/> {/* ID ditambahkan */}
        <div>
          <h1 id="headerTitle" class="text-lg sm:text-xl font-bold text-white leading-tight"><?php echo $siteTitle; ?></h1> {/* ID ditambahkan */}
          <p id="headerTagline" class="text-xs text-white"><?php echo $siteTagline; ?></p> {/* ID ditambahkan */}
        </div>
      </div>

      <nav class="hidden sm:flex ml-auto space-x-6 text-sm font-medium">
        <?php foreach ($menus as $url => $label): ?>
          <a href="<?php echo $url; ?>" class="<?php echo ($url == $currentPage) ? 'text-white font-bold' : 'text-white/80 hover:text-white'; ?>">
            <?php echo $label; ?>
          </a>
        <?php endforeach; ?>
      </nav>

      <button id="menuToggle" class="sm:hidden text-white text-2xl ml-auto">
        <i class="fas fa-bars"></i>
      </button>
    </div>

    <nav id="mobileMenu" class="sm:hidden hidden mt-4 space-y-2 text-sm font-medium bg-green-500 p-4 rounded">
      <?php foreach ($menus as $url => $label): ?>
        <a href="<?php echo $url; ?>" class="block <?php echo ($url == $currentPage) ? 'text-white font-bold' : 'text-white/80 hover:text-white'; ?>">
          <?php echo $label; ?>
        </a>
      <?php endforeach; ?>
    </nav>
  </div>
</header>

<script>
  document.getElementById('menuToggle').addEventListener('click', function () {
    document.getElementById('mobileMenu').classList.toggle('hidden');
  });

  // Script untuk header mengecil saat scroll
  const header = document.getElementById('mainHeader');
  const headerContainer = document.getElementById('headerContainer');
  const logo = document.getElementById('headerLogo');
  const title = document.getElementById('headerTitle');
  const tagline = document.getElementById('headerTagline');
  const scrollThreshold = 50; // Jarak scroll sebelum header mengecil (dalam pixel)

  // Simpan kelas asli untuk di-restore
  const originalContainerPadding = ['py-4'];
  const originalLogoSize = ['h-14', 'w-14'];
  const originalTitleSize = ['text-lg', 'sm:text-xl'];
  const originalTaglineClasses = ['text-xs', 'text-white']; // Simpan kelas asli tagline

  // Kelas untuk state mengecil
  const shrunkContainerPadding = ['py-2'];
  const shrunkLogoSize = ['h-10', 'w-10'];
  const shrunkTitleSize = ['text-base', 'sm:text-lg']; // Ukuran font lebih kecil
  const shrunkTaglineClasses = ['text-xs', 'text-white', 'sm:hidden']; // Sembunyikan di layar sm ke atas saat mengecil, atau sesuaikan

  function toggleHeaderSize() {
    if (window.scrollY > scrollThreshold) {
      // Mengecilkan Header
      headerContainer.classList.remove(...originalContainerPadding);
      headerContainer.classList.add(...shrunkContainerPadding);

      logo.classList.remove(...originalLogoSize);
      logo.classList.add(...shrunkLogoSize);

      title.classList.remove(...originalTitleSize);
      title.classList.add(...shrunkTitleSize);
      
      // Opsi 1: Sembunyikan tagline di layar kecil saat di-scroll
      tagline.classList.remove('text-xs', 'text-white'); // Hapus kelas lama dulu
      tagline.classList.add('text-[0.6rem]', 'sm:hidden', 'text-white'); // Ukuran sangat kecil atau sembunyikan di mobile
      
      // Opsi 2: Atau sembunyikan tagline sepenuhnya saat scroll
      // tagline.classList.add('hidden');


    } else {
      // Mengembalikan ukuran Header ke normal
      headerContainer.classList.remove(...shrunkContainerPadding);
      headerContainer.classList.add(...originalContainerPadding);

      logo.classList.remove(...shrunkLogoSize);
      logo.classList.add(...originalLogoSize);

      title.classList.remove(...shrunkTitleSize);
      title.classList.add(...originalTitleSize);
      
      // Mengembalikan tagline
      tagline.classList.remove('text-[0.6rem]', 'sm:hidden', 'hidden', 'text-white');
      tagline.classList.add(...originalTaglineClasses);
    }
  }

  window.addEventListener('scroll', toggleHeaderSize);
  // Panggil sekali saat load untuk kondisi awal jika halaman sudah di-scroll (misalnya setelah refresh)
  toggleHeaderSize(); 

</script>

</body>
</html>