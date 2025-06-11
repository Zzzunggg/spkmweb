<?php
// Mendeteksi halaman mana yang sedang aktif dari URL
$active_page = basename($_SERVER['PHP_SELF']);

// Fungsi untuk memeriksa dan memberikan kelas 'active' pada menu
function get_active_class($page_name, $menu_level) {
    $map = [
        'materi_putih.php' => 'putih',
        'materi_kuning.php' => 'kuning',
        'materi_hijau.php' => 'hijau',
        'materi_hitam.php' => 'hitam',
        'materi_emas.php' => 'emas',
        'materi_merah.php' => 'merah'
    ];
    if (isset($map[$page_name]) && $map[$page_name] == $menu_level) {
        return 'active';
    }
    return '';
}

// Fungsi untuk memeriksa apakah menu harus terbuka (expanded)
function is_expanded($page_name, $menu_level) {
    return get_active_class($page_name, $menu_level) === 'active' ? 'true' : 'false';
}
?>

<div class="accordion-item <?= get_active_class($active_page, 'putih') ?>">
    <button class="accordion-toggle" aria-expanded="<?= is_expanded($active_page, 'putih') ?>">
        Sabuk Putih <span class="icon" aria-hidden="true"></span>
    </button>
    <div class="accordion-content">
        <ul>
            <li><a href="materi_putih.php#kuda-kuda-dasar">Kuda-Kuda Dasar</a></li>
            <li><a href="materi_putih.php#tangkisan-dasar">Tangkisan Dasar</a></li>
            <li><a href="materi_putih.php#langkah-segitiga">Jurus Dasar Langkah Segitiga</a></li>
        </ul>
    </div>
</div>

<div class="accordion-item <?= get_active_class($active_page, 'kuning') ?>">
    <button class="accordion-toggle" aria-expanded="<?= is_expanded($active_page, 'kuning') ?>">
        Sabuk Kuning <span class="icon" aria-hidden="true"></span>
    </button>
    <div class="accordion-content">
        <ul>
            <li><a href="materi_kuning.php#pukulan-dasar">Pukulan Dasar (Lurus & Bandul)</a></li>
            <li><a href="materi_kuning.php#tendangan-dasar">Tendangan Dasar (Depan)</a></li>
            <li><a href="materi_kuning.php#elakan-dasar">Elakan Dasar</a></li>
        </ul>
    </div>
</div>

<div class="accordion-item <?= get_active_class($active_page, 'hijau') ?>">
    <button class="accordion-toggle" aria-expanded="<?= is_expanded($active_page, 'hijau') ?>">
        Sabuk Hijau <span class="icon" aria-hidden="true"></span>
    </button>
    <div class="accordion-content">
        <ul>
            <li><a href="materi_hijau.php#kombinasi-gerak">Kombinasi Gerak</a></li>
            <li><a href="materi_hijau.php#tendangan-samping">Tendangan Samping</a></li>
            <li><a href="materi_hijau.php#jurus-tangan-kosong">Jurus Tangan Kosong</a></li>
        </ul>
    </div>
</div>

<div class="accordion-item <?= get_active_class($active_page, 'hitam') ?>">
    <button class="accordion-toggle" aria-expanded="<?= is_expanded($active_page, 'hitam') ?>">
        Sabuk Hitam <span class="icon" aria-hidden="true"></span>
    </button>
    <div class="accordion-content">
        <ul>
            <li><a href="materi_hitam.php#teknik-kuncian">Teknik Kuncian</a></li>
            <li><a href="materi_hitam.php#teknik-jatuhan">Teknik Jatuhan</a></li>
            <li><a href="materi_hitam.php#jurus-senjata">Jurus Senjata</a></li>
        </ul>
    </div>
</div>

<div class="accordion-item <?= get_active_class($active_page, 'emas') ?>">
    <button class="accordion-toggle" aria-expanded="<?= is_expanded($active_page, 'emas') ?>">
        Sabuk Kuning Emas <span class="icon" aria-hidden="true"></span>
    </button>
    <div class="accordion-content">
        <ul>
            <li><a href="materi_emas.php#kuncian-lanjutan">Kuncian Lanjutan</a></li>
            <li><a href="materi_emas.php#pemecahan-kuncian">Pemecahan Kuncian</a></li>
            <li><a href="materi_emas.php#jurus-master">Jurus Master</a></li>
        </ul>
    </div>
</div>

<div class="accordion-item <?= get_active_class($active_page, 'merah') ?>">
    <button class="accordion-toggle" aria-expanded="<?= is_expanded($active_page, 'merah') ?>">
        Sabuk Merah <span class="icon" aria-hidden="true"></span>
    </button>
    <div class="accordion-content">
        <ul>
            <li><a href="materi_merah.php#filosofi-gerak">Filosofi Gerakan</a></li>
            <li><a href="materi_merah.php#tenaga-dalam">Tenaga Dalam</a></li>
            <li><a href="materi_merah.php#aplikasi-beladiri">Aplikasi Bela Diri</a></li>
        </ul>
    </div>
</div>