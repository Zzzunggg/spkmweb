-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 22, 2025 at 02:24 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `profil-organisasi`
--

-- --------------------------------------------------------

--
-- Table structure for table `anggota`
--

CREATE TABLE `anggota` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `umur` int(11) NOT NULL,
  `alamat` text DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `anggota`
--

INSERT INTO `anggota` (`id`, `nama`, `umur`, `alamat`, `email`, `created_at`) VALUES
(1, 'purba', 700, 'lamongan', 'muaffaaditya88@gmail.com', '2025-05-20 20:58:57'),
(2, 'purba', 70, 'lamongan', 'muaffaaditya88@gmail.com', '2025-05-20 21:00:05'),
(3, 'purba', 70, 'purbalingga', 'muaffaaditya88@gmail.com', '2025-05-20 21:00:29'),
(4, 'purba', 70, 'sidoarjo', 'muaffaaditya88@gmail.com', '2025-05-20 21:00:57'),
(5, 'purba', 70, 'gresik', 'muaffaaditya88@gmail.com', '2025-05-20 21:01:19'),
(6, 'purba', 90, 'gresik', 'muaffaaditya88@gmail.com', '2025-05-21 11:48:42'),
(7, 'purbaaaa', 90, 'gresik', 'muaffaaditya88@gmail.com', '2025-05-21 11:48:56');

-- --------------------------------------------------------

--
-- Table structure for table `galeri`
--

CREATE TABLE `galeri` (
  `id` int(11) NOT NULL,
  `gambar` varchar(255) NOT NULL,
  `caption` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `galeri`
--

INSERT INTO `galeri` (`id`, `gambar`, `caption`, `created_at`) VALUES
(1, 'galeri_682d1ff9cb4b1.png', '', '2025-05-21 07:36:09'),
(3, 'galeri_682d22a31e630.png', '', '2025-05-21 07:47:31'),
(4, 'galeri_682d22adb960b.png', '', '2025-05-21 07:47:41'),
(5, 'galeri_682d22b6e1248.png', '', '2025-05-21 07:47:50'),
(6, 'galeri_682d22c5266a6.png', '', '2025-05-21 07:48:05'),
(7, 'galeri_682d231ad2612.png', '', '2025-05-21 07:49:30'),
(9, 'galeri_682d2415b61b5.png', '', '2025-05-21 07:53:41'),
(14, 'galeri_682f12a59c9cc.jpg', '', '2025-05-22 19:03:49');

-- --------------------------------------------------------

--
-- Table structure for table `jadwal_latihan`
--

CREATE TABLE `jadwal_latihan` (
  `id` int(11) NOT NULL,
  `tingkat` enum('Dasar','Menengah','Mahir') NOT NULL,
  `tempat` varchar(100) NOT NULL,
  `waktu` varchar(100) NOT NULL,
  `hari` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jadwal_latihan`
--

INSERT INTO `jadwal_latihan` (`id`, `tingkat`, `tempat`, `waktu`, `hari`, `created_at`) VALUES
(2, 'Menengah', 'pp', '07.00-09.00', 'rabu', '2025-05-20 17:12:42'),
(4, 'Mahir', 'pp', '07.00-09.00', 'rabu', '2025-05-20 17:14:29'),
(7, 'Dasar', 'pp10', '07.00-09.00', 'rabu', '2025-05-20 17:26:05');

-- --------------------------------------------------------

--
-- Table structure for table `kegiatan`
--

CREATE TABLE `kegiatan` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `tanggal` date NOT NULL,
  `deskripsi` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `materi`
--

CREATE TABLE `materi` (
  `id` int(11) NOT NULL,
  `judul` varchar(255) DEFAULT NULL,
  `nama_file` varchar(255) DEFAULT NULL,
  `tanggal_upload` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `materi_dasar`
--

CREATE TABLE `materi_dasar` (
  `id` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `deskripsi_singkat` text NOT NULL,
  `deskripsi_lengkap` longtext NOT NULL,
  `gambar` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `materi_dasar`
--

INSERT INTO `materi_dasar` (`id`, `judul`, `deskripsi_singkat`, `deskripsi_lengkap`, `gambar`, `created_at`) VALUES
(1, 'halo', 'pp', 'pp', 'Forum-silahturahmi-Kapolres-Madiun.jpg', '2025-05-20 14:49:25'),
(2, 'halo', 'ppp', 'pp', 'Forum-silahturahmi-Kapolres-Madiun.jpg', '2025-05-20 15:05:59'),
(3, 'halo', 'ppp', 'ppp', 'Forum-silahturahmi-Kapolres-Madiun.jpg', '2025-05-20 15:06:12');

-- --------------------------------------------------------

--
-- Table structure for table `materi_mahir`
--

CREATE TABLE `materi_mahir` (
  `id` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `deskripsi_singkat` text NOT NULL,
  `deskripsi_lengkap` longtext NOT NULL,
  `gambar` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `materi_menengah`
--

CREATE TABLE `materi_menengah` (
  `id` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `deskripsi_singkat` text NOT NULL,
  `deskripsi_lengkap` longtext NOT NULL,
  `gambar` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pelatih`
--

CREATE TABLE `pelatih` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `umur` int(11) NOT NULL,
  `spesialisasi` varchar(100) NOT NULL,
  `pengalaman` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pelatih`
--

INSERT INTO `pelatih` (`id`, `nama`, `umur`, `spesialisasi`, `pengalaman`, `created_at`) VALUES
(2, 'purba', 900, 'orang dalam', 'mencintaimu', '2025-05-20 20:51:31'),
(3, 'purba', 60, 'orang dalam', 'mencintaimu', '2025-05-20 20:55:18');

-- --------------------------------------------------------

--
-- Table structure for table `pesan`
--

CREATE TABLE `pesan` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telp` varchar(20) DEFAULT NULL,
  `subjek` varchar(150) DEFAULT NULL,
  `pesan` text NOT NULL,
  `tanggal_kirim` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pesan`
--

INSERT INTO `pesan` (`id`, `nama`, `email`, `telp`, `subjek`, `pesan`, `tanggal_kirim`) VALUES
(1, 'loris agustin', 'Info@example.com', '081249771960', 'dscdsc', 'vsfd', '2025-05-21 09:43:00'),
(2, 'loris agustin', 'Info@example.com', '081249771960', 'dscdsc', 'vsfd', '2025-05-21 09:45:25'),
(3, 'muaffa aditya', 'Info@example.com', '081249771960', 'pp', 'pp', '2025-05-21 17:41:46');

-- --------------------------------------------------------

--
-- Table structure for table `prestasi`
--

CREATE TABLE `prestasi` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `tanggal_upload` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `prestasi`
--

INSERT INTO `prestasi` (`id`, `nama`, `deskripsi`, `foto`, `tanggal_upload`) VALUES
(5, 'pp', 'pp', '1747913307_01a11561c1.jpg', '2025-05-21 09:28:34'),
(6, 'pp', 'ppp', '1747913300_cb5a66ab4f.jpg', '2025-05-22 18:26:39'),
(7, 'pp', 'pp', '1747913293_a326d12ac0.jpg', '2025-05-22 18:26:48');

-- --------------------------------------------------------

--
-- Table structure for table `sambutan`
--

CREATE TABLE `sambutan` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `jabatan` varchar(255) NOT NULL,
  `foto` varchar(255) NOT NULL,
  `sambutan` text NOT NULL,
  `gambar` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sambutan`
--

INSERT INTO `sambutan` (`id`, `nama`, `jabatan`, `foto`, `sambutan`, `gambar`, `created_at`) VALUES
(1, 'purba', 'ketua umum', 'foto_682d118c7a297.png', 'pp', 'gambar_682d118c7a29c.png', '2025-05-20 16:34:36'),
(2, 'purba', 'ketua umum', 'foto_682d127fc4699.png', 'pp', '', '2025-05-20 16:38:39'),
(3, 'purba', 'ketua umum', 'foto_682d1e3902aca.png', 'pp', '', '2025-05-20 17:28:41'),
(4, 'purba', 'ketua umum', 'foto_682d1e6a8260e.png', 'pp', '', '2025-05-20 17:29:30'),
(5, 'purba', 'ketua umum', 'foto_682d1e7027955.png', 'pp', '', '2025-05-20 17:29:36'),
(6, 'purba', 'ketua umum', 'foto_682d1e96119f2.png', 'pp', '', '2025-05-20 17:30:14'),
(7, 'purba', 'ketua umum', 'foto_682d20b554ab6.png', 'pp', '', '2025-05-20 17:39:17'),
(8, 'purba', 'ketua umum', 'foto_682d9b7abaab1.png', 'Assalamu’alaikum Warahmatullahi Wabarakatuh,\r\nSalam sejahtera bagi kita semua,\r\n\r\nYang saya hormati, para anggota, tamu undangan, serta seluruh hadirin yang berbahagia,\r\n\r\nPuji syukur kita panjatkan ke hadirat Allah SWT, karena atas limpahan rahmat dan karunia-Nya kita dapat berkumpul dalam acara yang sangat penting ini. Pada kesempatan yang berbahagia ini, izinkan saya menyampaikan beberapa kata sambutan sebagai Ketua Umum.\r\n\r\nPertama-tama, saya ingin mengucapkan terima kasih yang sebesar-besarnya kepada semua pihak yang telah bekerja keras dan berkontribusi demi kelancaran kegiatan kita. Kerja sama dan semangat yang tinggi dari seluruh anggota merupakan kekuatan utama organisasi ini.\r\n\r\nSebagai Ketua Umum, saya sangat mengapresiasi dedikasi dan komitmen yang telah ditunjukkan selama ini. Namun demikian, tantangan ke depan semakin kompleks dan menuntut kita untuk terus berinovasi, beradaptasi, dan menjaga semangat kebersamaan.\r\n\r\nMari kita jadikan momentum ini sebagai langkah awal untuk memperkuat solidaritas, meningkatkan profesionalisme, dan mewujudkan visi-misi organisasi kita secara bersama-sama.\r\n\r\nSaya percaya dengan kebersamaan dan kerja keras, kita dapat mencapai tujuan yang telah kita tetapkan dan memberikan manfaat nyata bagi seluruh anggota serta masyarakat luas.\r\n\r\nAkhir kata, saya berharap acara ini berjalan lancar dan memberikan hasil yang positif. Terima kasih atas perhatian dan partisipasi semua pihak.\r\n\r\nWassalamu’alaikum Warahmatullahi Wabarakatuh.', '', '2025-05-21 09:23:06'),
(9, 'David Tufikurrahman', 'ketua umum', 'foto_682d9ba994311.png', 'Assalamu’alaikum Warahmatullahi Wabarakatuh,\r\nSalam sejahtera bagi kita semua,\r\n\r\nYang saya hormati, para anggota, tamu undangan, serta seluruh hadirin yang berbahagia,\r\n\r\nPuji syukur kita panjatkan ke hadirat Allah SWT, karena atas limpahan rahmat dan karunia-Nya kita dapat berkumpul dalam acara yang sangat penting ini. Pada kesempatan yang berbahagia ini, izinkan saya menyampaikan beberapa kata sambutan sebagai Ketua Umum.\r\n\r\nPertama-tama, saya ingin mengucapkan terima kasih yang sebesar-besarnya kepada semua pihak yang telah bekerja keras dan berkontribusi demi kelancaran kegiatan kita. Kerja sama dan semangat yang tinggi dari seluruh anggota merupakan kekuatan utama organisasi ini.\r\n\r\nSebagai Ketua Umum, saya sangat mengapresiasi dedikasi dan komitmen yang telah ditunjukkan selama ini. Namun demikian, tantangan ke depan semakin kompleks dan menuntut kita untuk terus berinovasi, beradaptasi, dan menjaga semangat kebersamaan.\r\n\r\nMari kita jadikan momentum ini sebagai langkah awal untuk memperkuat solidaritas, meningkatkan profesionalisme, dan mewujudkan visi-misi organisasi kita secara bersama-sama.\r\n\r\nSaya percaya dengan kebersamaan dan kerja keras, kita dapat mencapai tujuan yang telah kita tetapkan dan memberikan manfaat nyata bagi seluruh anggota serta masyarakat luas.\r\n\r\nAkhir kata, saya berharap acara ini berjalan lancar dan memberikan hasil yang positif. Terima kasih atas perhatian dan partisipasi semua pihak.\r\n\r\nWassalamu’alaikum Warahmatullahi Wabarakatuh.', '', '2025-05-21 09:23:53'),
(10, 'David Tufikurrahman', 'ketua umum', 'foto_682dcaff08013.jpg', 'Assalamu’alaikum Warahmatullahi Wabarakatuh,\r\nSalam sejahtera bagi kita semua,\r\n\r\nYang saya hormati, para anggota, tamu undangan, serta seluruh hadirin yang berbahagia,\r\n\r\nPuji syukur kita panjatkan ke hadirat Allah SWT, karena atas limpahan rahmat dan karunia-Nya kita dapat berkumpul dalam acara yang sangat penting ini. Pada kesempatan yang berbahagia ini, izinkan saya menyampaikan beberapa kata sambutan sebagai Ketua Umum.\r\n\r\nPertama-tama, saya ingin mengucapkan terima kasih yang sebesar-besarnya kepada semua pihak yang telah bekerja keras dan berkontribusi demi kelancaran kegiatan kita. Kerja sama dan semangat yang tinggi dari seluruh anggota merupakan kekuatan utama organisasi ini.\r\n\r\nSebagai Ketua Umum, saya sangat mengapresiasi dedikasi dan komitmen yang telah ditunjukkan selama ini. Namun demikian, tantangan ke depan semakin kompleks dan menuntut kita untuk terus berinovasi, beradaptasi, dan menjaga semangat kebersamaan.\r\n\r\nMari kita jadikan momentum ini sebagai langkah awal untuk memperkuat solidaritas, meningkatkan profesionalisme, dan mewujudkan visi-misi organisasi kita secara bersama-sama.\r\n\r\nSaya percaya dengan kebersamaan dan kerja keras, kita dapat mencapai tujuan yang telah kita tetapkan dan memberikan manfaat nyata bagi seluruh anggota serta masyarakat luas.\r\n\r\nAkhir kata, saya berharap acara ini berjalan lancar dan memberikan hasil yang positif. Terima kasih atas perhatian dan partisipasi semua pihak.\r\n\r\nWassalamu’alaikum Warahmatullahi Wabarakatuh.', '', '2025-05-21 12:45:51'),
(11, 'David Tufikurrahman', 'ketua umum', 'foto_682dcb4c71416.png', 'Assalamu’alaikum Warahmatullahi Wabarakatuh,\r\nSalam sejahtera bagi kita semua,\r\n\r\nYang saya hormati, para anggota, tamu undangan, serta seluruh hadirin yang berbahagia,\r\n\r\nPuji syukur kita panjatkan ke hadirat Allah SWT, karena atas limpahan rahmat dan karunia-Nya kita dapat berkumpul dalam acara yang sangat penting ini. Pada kesempatan yang berbahagia ini, izinkan saya menyampaikan beberapa kata sambutan sebagai Ketua Umum.\r\n\r\nPertama-tama, saya ingin mengucapkan terima kasih yang sebesar-besarnya kepada semua pihak yang telah bekerja keras dan berkontribusi demi kelancaran kegiatan kita. Kerja sama dan semangat yang tinggi dari seluruh anggota merupakan kekuatan utama organisasi ini.\r\n\r\nSebagai Ketua Umum, saya sangat mengapresiasi dedikasi dan komitmen yang telah ditunjukkan selama ini. Namun demikian, tantangan ke depan semakin kompleks dan menuntut kita untuk terus berinovasi, beradaptasi, dan menjaga semangat kebersamaan.\r\n\r\nMari kita jadikan momentum ini sebagai langkah awal untuk memperkuat solidaritas, meningkatkan profesionalisme, dan mewujudkan visi-misi organisasi kita secara bersama-sama.\r\n\r\nSaya percaya dengan kebersamaan dan kerja keras, kita dapat mencapai tujuan yang telah kita tetapkan dan memberikan manfaat nyata bagi seluruh anggota serta masyarakat luas.\r\n\r\nAkhir kata, saya berharap acara ini berjalan lancar dan memberikan hasil yang positif. Terima kasih atas perhatian dan partisipasi semua pihak.\r\n\r\nWassalamu’alaikum Warahmatullahi Wabarakatuh.', '', '2025-05-21 12:47:08'),
(12, 'David Tufikurrahman', 'ketua umum', 'foto_682dcc1eb0053.jpg', 'Assalamu’alaikum Warahmatullahi Wabarakatuh,\r\nSalam sejahtera bagi kita semua,\r\n\r\nYang saya hormati, para anggota, tamu undangan, serta seluruh hadirin yang berbahagia,\r\n\r\nPuji syukur kita panjatkan ke hadirat Allah SWT, karena atas limpahan rahmat dan karunia-Nya kita dapat berkumpul dalam acara yang sangat penting ini. Pada kesempatan yang berbahagia ini, izinkan saya menyampaikan beberapa kata sambutan sebagai Ketua Umum.\r\n\r\nPertama-tama, saya ingin mengucapkan terima kasih yang sebesar-besarnya kepada semua pihak yang telah bekerja keras dan berkontribusi demi kelancaran kegiatan kita. Kerja sama dan semangat yang tinggi dari seluruh anggota merupakan kekuatan utama organisasi ini.\r\n\r\nSebagai Ketua Umum, saya sangat mengapresiasi dedikasi dan komitmen yang telah ditunjukkan selama ini. Namun demikian, tantangan ke depan semakin kompleks dan menuntut kita untuk terus berinovasi, beradaptasi, dan menjaga semangat kebersamaan.\r\n\r\nMari kita jadikan momentum ini sebagai langkah awal untuk memperkuat solidaritas, meningkatkan profesionalisme, dan mewujudkan visi-misi organisasi kita secara bersama-sama.\r\n\r\nSaya percaya dengan kebersamaan dan kerja keras, kita dapat mencapai tujuan yang telah kita tetapkan dan memberikan manfaat nyata bagi seluruh anggota serta masyarakat luas.\r\n\r\nAkhir kata, saya berharap acara ini berjalan lancar dan memberikan hasil yang positif. Terima kasih atas perhatian dan partisipasi semua pihak.\r\n\r\nWassalamu’alaikum Warahmatullahi Wabarakatuh.', '', '2025-05-21 12:50:38');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `banner_image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `banner_image`) VALUES
(1, '682f0a243ad49-WhatsApp Image 2025-05-22 at 18.26.45_141a63bf.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `struktur_organisasi`
--

CREATE TABLE `struktur_organisasi` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `jabatan` varchar(255) NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `struktur_organisasi`
--

INSERT INTO `struktur_organisasi` (`id`, `nama`, `jabatan`, `foto`, `deskripsi`, `created_at`) VALUES
(3, 'loris', 'ketua umum 1', '1747791946_Cuplikan layar 2025-02-13 122708.png', '', '2025-05-20 18:45:46'),
(4, 'Purba', 'Sekretaris', '1747819308_Cuplikan layar 2025-02-13 121423.png', '', '2025-05-21 09:21:48');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `fullname` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `fullname`, `email`, `created_at`) VALUES
(1, 'sidoarjo', '$2y$10$NIci/YNe3o/3YnGGxieVGOd6iI.43mMzWJJgC8l3QiFst5V7OGQXm', NULL, 'muaffaaditya88@gmail.com', '2025-05-20 20:40:19'),
(2, 'david', '$2y$10$tQRzdufzOM9n2KT16DxuiOvznoTFekNmteVNn3Js06DWga6fFSq6y', NULL, '3130023016@student.unusa.ac.id', '2025-05-21 12:37:59');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `anggota`
--
ALTER TABLE `anggota`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `galeri`
--
ALTER TABLE `galeri`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jadwal_latihan`
--
ALTER TABLE `jadwal_latihan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kegiatan`
--
ALTER TABLE `kegiatan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `materi`
--
ALTER TABLE `materi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `materi_dasar`
--
ALTER TABLE `materi_dasar`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `materi_mahir`
--
ALTER TABLE `materi_mahir`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `materi_menengah`
--
ALTER TABLE `materi_menengah`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pelatih`
--
ALTER TABLE `pelatih`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pesan`
--
ALTER TABLE `pesan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prestasi`
--
ALTER TABLE `prestasi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sambutan`
--
ALTER TABLE `sambutan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `struktur_organisasi`
--
ALTER TABLE `struktur_organisasi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `anggota`
--
ALTER TABLE `anggota`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `galeri`
--
ALTER TABLE `galeri`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `jadwal_latihan`
--
ALTER TABLE `jadwal_latihan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `kegiatan`
--
ALTER TABLE `kegiatan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `materi`
--
ALTER TABLE `materi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `materi_dasar`
--
ALTER TABLE `materi_dasar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `materi_mahir`
--
ALTER TABLE `materi_mahir`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `materi_menengah`
--
ALTER TABLE `materi_menengah`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pelatih`
--
ALTER TABLE `pelatih`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `pesan`
--
ALTER TABLE `pesan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `prestasi`
--
ALTER TABLE `prestasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `sambutan`
--
ALTER TABLE `sambutan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `struktur_organisasi`
--
ALTER TABLE `struktur_organisasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
