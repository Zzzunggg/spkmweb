<?php
$logoSrc = "uploads/Logo SPKM.png";
$siteTitle = "Surabaya Pencak Kordo Manyuro";
$siteTagline = "1938";

$menus = [
  'index.php' => 'Home',
  'materi.php' => 'Materi',
  'prestasi_user.php' => 'Prestasi',
  'kontak.php' => 'Contact',
  'about.php' => 'About',
  'admin/login.php' => 'SPKM',

];

$currentPage = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <!-- Di dalam <head> -->


  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <title><?php echo $siteTitle; ?></title>
  <link rel="icon" type="image/png" href="uploads/Logo SPKM.png">
  <script src="https://cdn.tailwindcss.com"></script>
  <script defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/js/all.min.js"></script>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap');
    body { font-family: 'Inter', sans-serif; }
    #mainHeader, #mainHeader div, #mainHeader img, #mainHeader h1, #mainHeader p, #mainHeader nav a {
        transition: all 0.3s ease-in-out;
    }
  </style>
</head>
<body class="bg-white">

<header id="mainHeader" class="sticky top-0 z-50 bg-green-700 shadow-md">
  <div id="headerContainer" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
    <div class="flex items-center justify-between">
      <div class="flex items-center space-x-4">
        <img id="headerLogo" src="<?php echo $logoSrc; ?>" alt="Logo" class="h-14 w-14 rounded-full object-cover"/>
        <div>
          <h1 id="headerTitle" class="text-lg sm:text-xl font-bold text-white leading-tight"><?php echo $siteTitle; ?></h1>
          <p id="headerTagline" class="text-xs text-white"><?php echo $siteTagline; ?></p>
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

  const header = document.getElementById('mainHeader');
  const headerContainer = document.getElementById('headerContainer');
  const logo = document.getElementById('headerLogo');
  const title = document.getElementById('headerTitle');
  const tagline = document.getElementById('headerTagline');
  const scrollThreshold = 50;

  const originalContainerPadding = ['py-4'];
  const originalLogoSize = ['h-14', 'w-14'];
  const originalTitleSize = ['text-lg', 'sm:text-xl'];
  const originalTaglineClasses = ['text-xs', 'text-white'];

  const shrunkContainerPadding = ['py-2'];
  const shrunkLogoSize = ['h-10', 'w-10'];
  const shrunkTitleSize = ['text-base', 'sm:text-lg'];
  const shrunkTaglineClasses = ['text-[0.6rem]', 'sm:hidden', 'text-white'];

  function toggleHeaderSize() {
    if (window.scrollY > scrollThreshold) {
      headerContainer.classList.remove(...originalContainerPadding);
      headerContainer.classList.add(...shrunkContainerPadding);

      logo.classList.remove(...originalLogoSize);
      logo.classList.add(...shrunkLogoSize);

      title.classList.remove(...originalTitleSize);
      title.classList.add(...shrunkTitleSize);

      tagline.classList.remove(...originalTaglineClasses);
      tagline.classList.add(...shrunkTaglineClasses);
    } else {
      headerContainer.classList.remove(...shrunkContainerPadding);
      headerContainer.classList.add(...originalContainerPadding);

      logo.classList.remove(...shrunkLogoSize);
      logo.classList.add(...originalLogoSize);

      title.classList.remove(...shrunkTitleSize);
      title.classList.add(...originalTitleSize);

      tagline.classList.remove(...shrunkTaglineClasses);
      tagline.classList.add(...originalTaglineClasses);
    }
  }

  window.addEventListener('scroll', toggleHeaderSize);
  toggleHeaderSize();
</script>

</body>
</html>
