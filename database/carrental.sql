-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 16 Jun 2025 pada 03.20
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `carrental`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `UserName` varchar(100) NOT NULL,
  `Password` varchar(100) NOT NULL,
  `updationDate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`id`, `UserName`, `Password`, `updationDate`) VALUES
(3, 'admin', '12345678', '2025-06-15 00:48:24');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tblbooking`
--

CREATE TABLE `tblbooking` (
  `id` int(11) NOT NULL,
  `BookingNumber` bigint(12) DEFAULT NULL,
  `userEmail` varchar(100) DEFAULT NULL,
  `VehicleId` int(11) DEFAULT NULL,
  `FromDate` varchar(20) DEFAULT NULL,
  `ToDate` varchar(20) DEFAULT NULL,
  `message` varchar(255) DEFAULT NULL,
  `Status` int(11) DEFAULT NULL,
  `PostingDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `LastUpdationDate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `metode` varchar(20) NOT NULL,
  `payments` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tblbrands`
--

CREATE TABLE `tblbrands` (
  `id` int(11) NOT NULL,
  `BrandName` varchar(120) NOT NULL,
  `CreationDate` timestamp NULL DEFAULT current_timestamp(),
  `UpdationDate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `tblbrands`
--

INSERT INTO `tblbrands` (`id`, `BrandName`, `CreationDate`, `UpdationDate`) VALUES
(2, 'BMW', '2024-05-01 16:24:34', '2024-06-05 05:26:34'),
(4, 'Nissan', '2024-05-01 16:24:34', '2024-06-05 05:26:34'),
(5, 'Toyota', '2024-05-01 16:24:34', '2024-06-05 05:26:34'),
(9, 'Daihatsu', '2025-06-15 17:00:03', NULL),
(10, 'Mitsubishi', '2025-06-15 17:00:19', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tblcontactusinfo`
--

CREATE TABLE `tblcontactusinfo` (
  `id` int(11) NOT NULL,
  `Address` tinytext DEFAULT NULL,
  `EmailId` varchar(255) DEFAULT NULL,
  `ContactNo` char(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `tblcontactusinfo`
--

INSERT INTO `tblcontactusinfo` (`id`, `Address`, `EmailId`, `ContactNo`) VALUES
(1, 'Jalan Pantai Indah NO.72', 'RENTCAR@gmail.com', '083185510148');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tblcontactusquery`
--

CREATE TABLE `tblcontactusquery` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `EmailId` varchar(120) DEFAULT NULL,
  `ContactNumber` char(11) DEFAULT NULL,
  `Message` longtext DEFAULT NULL,
  `PostingDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `tblcontactusquery`
--

INSERT INTO `tblcontactusquery` (`id`, `name`, `EmailId`, `ContactNumber`, `Message`, `PostingDate`, `status`) VALUES
(5, 'Rodiyan', 'Rodiyan123@gamil.com', '0831855101', 'aaaa', '2025-06-16 00:22:32', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tblpages`
--

CREATE TABLE `tblpages` (
  `id` int(11) NOT NULL,
  `PageName` varchar(255) DEFAULT NULL,
  `type` varchar(255) NOT NULL DEFAULT '',
  `detail` longtext NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `tblpages`
--

INSERT INTO `tblpages` (`id`, `PageName`, `type`, `detail`) VALUES
(1, 'Syarat dan Ketentuan Penggunaan', 'terms', '<p data-start=\"163\" data-end=\"304\" style=\"text-align: justify;\"><span style=\"font-size: medium;\">Selamat datang di layanan rental mobil kami. Dengan menggunakan layanan ini, Anda menyetujui untuk terikat oleh syarat dan ketentuan berikut:</span></p><p data-start=\"306\" data-end=\"466\"><div style=\"text-align: justify;\"><strong data-start=\"306\" data-end=\"329\" style=\"font-size: medium;\">1. Persyaratan Umum</strong></div><span style=\"font-size: medium;\"><div style=\"text-align: justify;\">Pengguna harus berusia minimal 21 tahun dan memiliki SIM (Surat Izin Mengemudi) yang masih berlaku sesuai jenis kendaraan yang disewa.</div></span></p><p data-start=\"468\" data-end=\"713\"><div style=\"text-align: justify;\"><strong data-start=\"468\" data-end=\"509\" style=\"font-size: medium;\">2. Ketentuan Pemesanan dan Pembayaran</strong></div><span style=\"font-size: medium;\"><div style=\"text-align: justify;\">Pemesanan dapat dilakukan secara online melalui situs ini. Pembayaran harus diselesaikan sebelum kendaraan diserahkan. Harga sewa dapat berubah sewaktu-waktu tergantung pada durasi dan jenis kendaraan.</div></span></p><p data-start=\"715\" data-end=\"913\"><div style=\"text-align: justify;\"><strong data-start=\"715\" data-end=\"742\" style=\"font-size: medium;\">3. Penggunaan Kendaraan</strong></div><span style=\"font-size: medium;\"><div style=\"text-align: justify;\">Kendaraan hanya boleh digunakan untuk keperluan pribadi dan tidak boleh dipindahtangankan, digunakan untuk kegiatan ilegal, balapan, atau tindakan yang melanggar hukum.</div></span></p><p data-start=\"915\" data-end=\"1127\"><div style=\"text-align: justify;\"><strong data-start=\"915\" data-end=\"945\" style=\"font-size: medium;\">4. Tanggung Jawab Pengguna</strong></div><span style=\"font-size: medium;\"><div style=\"text-align: justify;\">Penyewa bertanggung jawab atas kerusakan, kehilangan, atau denda lalu lintas selama masa sewa. Biaya perbaikan akibat kelalaian pengguna akan dibebankan sepenuhnya kepada penyewa.</div></span></p><p data-start=\"1129\" data-end=\"1297\"><div style=\"text-align: justify;\"><strong data-start=\"1129\" data-end=\"1168\" style=\"font-size: medium;\">5. Pembatalan dan Pengembalian Dana</strong></div><span style=\"font-size: medium;\"><div style=\"text-align: justify;\">Pembatalan maksimal dilakukan 24 jam sebelum waktu sewa. Pengembalian dana akan diproses sesuai kebijakan refund yang berlaku.</div></span></p><p data-start=\"1299\" data-end=\"1468\"><div style=\"text-align: justify;\"><strong data-start=\"1299\" data-end=\"1328\" style=\"font-size: medium;\">6. Pengembalian Kendaraan</strong></div><span style=\"font-size: medium;\"><div style=\"text-align: justify;\">Kendaraan harus dikembalikan sesuai waktu yang disepakati. Keterlambatan akan dikenakan denda per jam atau per hari tergantung kebijakan.</div></span></p><p align=\"justify\">\r\n\r\n\r\n\r\n\r\n\r\n\r\n</p><p data-start=\"1470\" data-end=\"1670\"><div style=\"text-align: justify;\"><strong data-start=\"1470\" data-end=\"1507\" style=\"font-size: medium;\">7. Perubahan Syarat dan Ketentuan</strong></div><span style=\"font-size: medium;\"><div style=\"text-align: justify;\">Kami berhak mengubah syarat dan ketentuan ini sewaktu-waktu tanpa pemberitahuan sebelumnya. Harap selalu membaca versi terbaru sebelum menggunakan layanan kami.</div></span></p>'),
(2, 'Kebijakan Privasi', 'privacy', '<p data-start=\"122\" data-end=\"309\" style=\"text-align: justify;\"><span style=\"font-size: large;\">Kami menghargai dan melindungi privasi pengguna kami. Kebijakan ini menjelaskan bagaimana kami mengumpulkan, menggunakan, dan melindungi data pribadi Anda selama menggunakan layanan kami.</span></p>\r\n<p data-start=\"311\" data-end=\"510\"><div style=\"text-align: justify;\"><strong data-start=\"311\" data-end=\"339\" style=\"font-size: large;\">1. Pengumpulan Informasi</strong></div><span style=\"font-size: large;\"><div style=\"text-align: justify;\">Kami mengumpulkan informasi pribadi seperti nama, alamat, nomor telepon, alamat email, data KTP, dan informasi lain yang diperlukan untuk keperluan penyewaan kendaraan.</div></span></p>\r\n<p data-start=\"512\" data-end=\"580\"><div style=\"text-align: justify;\"><strong data-start=\"512\" data-end=\"539\" style=\"font-size: large;\">2. Penggunaan Informasi</strong></div><span style=\"font-size: large;\"><div style=\"text-align: justify;\">Data yang dikumpulkan digunakan untuk:</div></span></p><ol><li style=\"text-align: justify;\"><span style=\"font-size: large;\">Memproses transaksi dan penyewaan kendaraan</span></li><li style=\"text-align: justify;\"><span style=\"font-size: large;\">Memberikan layanan pelanggan</span></li><li style=\"text-align: justify;\"><span style=\"font-size: large;\">Mengirimkan notifikasi dan konfirmasi pesanan</span></li><li style=\"text-align: justify;\"><span style=\"font-size: large;\">Kepentingan verifikasi dan keamanan</span></li></ol><p></p>\r\n<p data-start=\"745\" data-end=\"976\"><div style=\"text-align: justify;\"><strong data-start=\"745\" data-end=\"781\" style=\"font-size: large;\">3. Penyimpanan dan Keamanan Data</strong></div><span style=\"font-size: large;\"><div style=\"text-align: justify;\">Semua informasi pribadi disimpan dengan aman dan hanya diakses oleh staf yang berwenang. Kami menggunakan langkah-langkah teknis dan organisasi untuk melindungi data dari akses yang tidak sah.</div></span></p>\r\n<p data-start=\"978\" data-end=\"1182\"><div style=\"text-align: justify;\"><strong data-start=\"978\" data-end=\"1019\" style=\"font-size: large;\">4. Pembagian Data kepada Pihak Ketiga</strong></div><span style=\"font-size: large;\"><div style=\"text-align: justify;\">Kami <strong data-start=\"1027\" data-end=\"1060\">tidak menjual atau membagikan</strong> data pribadi pengguna kepada pihak ketiga, kecuali jika diwajibkan oleh hukum atau untuk keperluan penyelidikan penipuan.</div></span></p>\r\n<p data-start=\"1184\" data-end=\"1341\"><div style=\"text-align: justify;\"><strong data-start=\"1184\" data-end=\"1203\" style=\"font-size: large;\">5. Hak Pengguna</strong></div><span style=\"font-size: large;\"><div style=\"text-align: justify;\">Pengguna berhak untuk mengakses, memperbarui, atau menghapus informasi pribadinya kapan saja dengan menghubungi layanan pelanggan kami.</div></span></p>\r\n<p data-start=\"1343\" data-end=\"1478\"><div style=\"text-align: justify;\"><strong data-start=\"1343\" data-end=\"1361\" style=\"font-size: large;\">6. Persetujuan</strong></div><span style=\"font-size: large;\"><div style=\"text-align: justify;\">Dengan menggunakan layanan kami, Anda menyetujui pengumpulan dan penggunaan informasi sesuai dengan kebijakan ini.</div></span></p>'),
(3, 'Tentang Kami', 'aboutus', '<p data-start=\"138\" data-end=\"402\" style=\"text-align: justify;\"><span style=\"font-size: large; font-family: arial;\">Selamat datang di RENTCAR, solusi terbaik untuk kebutuhan sewa mobil Anda. Kami adalah perusahaan rental mobil terpercaya yang berkomitmen untuk memberikan pelayanan terbaik, armada berkualitas, dan harga yang kompetitif kepada setiap pelanggan.</span></p>\r\n<p data-start=\"404\" data-end=\"739\" style=\"text-align: justify;\"><span style=\"font-size: large; font-family: arial;\">Dengan pengalaman bertahun-tahun di industri transportasi, kami memahami pentingnya kenyamanan, keamanan, dan ketepatan waktu dalam setiap perjalanan. Oleh karena itu, kami menyediakan berbagai jenis kendaraan – mulai dari city car, SUV, hingga mobil mewah – yang selalu dalam kondisi prima dan siap digunakan kapan saja Anda butuhkan.</span></p>\r\n<p data-start=\"741\" data-end=\"782\"></p><div style=\"text-align: justify;\"><span style=\"font-size: large; font-family: arial;\">Kami melayani berbagai keperluan seperti:</span></div><div style=\"text-align: justify;\"><ul><li><span style=\"font-family: arial; font-size: large;\">Perjalanan wisata keluarga</span></li><li><span style=\"font-family: arial; font-size: large;\">Keperluan bisnis</span></li><li><span style=\"font-family: arial; font-size: large;\">Event pernikahan</span></li><li><span style=\"font-family: arial; font-size: large;\">Dan kebutuhan transportasi lainnya</span></li></ul></div><div style=\"text-align: justify;\"><span style=\"font-size: large; font-family: arial;\"><span style=\"font-weight: 700;\"><br></span></span></div><div style=\"text-align: justify;\"><span style=\"font-size: large; font-family: arial;\">RENTCAR&nbsp;siap menjadi mitra perjalanan Anda yang andal dan nyaman.</span></div>'),
(11, 'Persyaratan Umum', 'faqs', '<p data-start=\"117\" data-end=\"217\" style=\"text-align: justify;\"><span style=\"font-size: large;\">Untuk dapat menggunakan layanan rental mobil kami, pengguna diwajibkan memenuhi persyaratan berikut:</span></p>\r\n<p data-start=\"219\" data-end=\"350\"><div style=\"text-align: justify;\"><strong data-start=\"219\" data-end=\"238\" style=\"font-size: large;\">1. Usia Minimum</strong></div><div style=\"text-align: justify;\"><span style=\"font-size: large;\">Penyewa harus berusia minimal <strong data-start=\"271\" data-end=\"283\" style=\"\">21 tahun</strong> dan maksimal <strong data-start=\"297\" data-end=\"309\" style=\"\">65 tahun</strong> pada saat penyewaan kendaraan dilakukan.</span></div></p>\r\n<p data-start=\"352\" data-end=\"559\"><div style=\"text-align: justify;\"><strong data-start=\"352\" data-end=\"380\" style=\"font-size: large;\">2. Memiliki SIM yang Sah</strong></div><div style=\"text-align: justify;\"><span style=\"font-size: large;\">Penyewa wajib memiliki <strong data-start=\"406\" data-end=\"438\" style=\"\">Surat Izin Mengemudi (SIM) A</strong> yang masih berlaku dan sesuai dengan jenis kendaraan yang akan disewa. SIM harus ditunjukkan saat pengambilan kendaraan.</span></div></p>\r\n<p data-start=\"561\" data-end=\"712\"><div style=\"text-align: justify;\"><strong data-start=\"561\" data-end=\"583\" style=\"font-size: large;\">3. Kartu Identitas</strong></div><div style=\"text-align: justify;\"><span style=\"font-size: large;\">Penyewa diwajibkan menyerahkan <strong data-start=\"617\" data-end=\"645\" style=\"\">fotokopi KTP atau paspor</strong> yang masih berlaku sebagai dokumen pendukung verifikasi identitas.</span></div></p>\r\n<p data-start=\"714\" data-end=\"854\"><div style=\"text-align: justify;\"><strong data-start=\"714\" data-end=\"728\" style=\"font-size: large;\">4. Jaminan</strong></div><div style=\"text-align: justify;\"><span style=\"font-size: large;\">Beberapa jenis kendaraan mungkin memerlukan <strong data-start=\"775\" data-end=\"801\" style=\"\">jaminan berupa deposit</strong> atau dokumen tambahan sesuai ketentuan yang berlaku.</span></div></p>\r\n<p data-start=\"856\" data-end=\"1040\"><div style=\"text-align: justify;\"><strong data-start=\"856\" data-end=\"878\" style=\"font-size: large;\">5. Data yang Valid</strong></div><div style=\"text-align: justify;\"><span style=\"font-size: large;\">Seluruh informasi yang diberikan oleh penyewa, baik saat pendaftaran akun maupun saat melakukan pemesanan, harus benar, valid, dan dapat dipertanggungjawabkan.</span></div></p>\r\n<p data-start=\"1042\" data-end=\"1223\"><div style=\"text-align: justify;\"><strong data-start=\"1042\" data-end=\"1066\" style=\"font-size: large;\">6. Penolakan Layanan</strong></div><div style=\"text-align: justify;\"><span style=\"font-size: large;\">Kami berhak menolak penyewaan apabila terdapat indikasi penggunaan yang mencurigakan, data yang tidak sesuai, atau pelanggaran terhadap ketentuan layanan.</span></div></p>');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tblsubscribers`
--

CREATE TABLE `tblsubscribers` (
  `id` int(11) NOT NULL,
  `SubscriberEmail` varchar(120) DEFAULT NULL,
  `PostingDate` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `tblsubscribers`
--

INSERT INTO `tblsubscribers` (`id`, `SubscriberEmail`, `PostingDate`) VALUES
(7, 'Fadhillah@gmail.com', '2025-06-16 01:19:28');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbltestimonial`
--

CREATE TABLE `tbltestimonial` (
  `id` int(11) NOT NULL,
  `UserEmail` varchar(100) NOT NULL,
  `Testimonial` mediumtext NOT NULL,
  `PostingDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `tbltestimonial`
--

INSERT INTO `tbltestimonial` (`id`, `UserEmail`, `Testimonial`, `PostingDate`, `status`) VALUES
(5, 'Rodiyan@gmail.com', 'Trusteddddd bangettttt', '2025-06-16 00:26:07', 1),
(6, 'Rodiyan@gmail.com', 'Mantapppppp\r\n', '2025-06-16 00:30:04', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tblusers`
--

CREATE TABLE `tblusers` (
  `id` int(11) NOT NULL,
  `FullName` varchar(120) DEFAULT NULL,
  `EmailId` varchar(100) DEFAULT NULL,
  `Password` varchar(100) DEFAULT NULL,
  `ContactNo` char(15) DEFAULT NULL,
  `dob` varchar(100) DEFAULT NULL,
  `Address` varchar(255) DEFAULT NULL,
  `City` varchar(100) DEFAULT NULL,
  `Country` varchar(100) DEFAULT NULL,
  `RegDate` timestamp NULL DEFAULT current_timestamp(),
  `UpdationDate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `KtpImage` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `tblusers`
--

INSERT INTO `tblusers` (`id`, `FullName`, `EmailId`, `Password`, `ContactNo`, `dob`, `Address`, `City`, `Country`, `RegDate`, `UpdationDate`, `KtpImage`) VALUES
(6, 'Fadhil', 'gila123@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', '8318551014', NULL, NULL, NULL, NULL, '2025-06-02 00:38:49', '2025-06-02 00:40:56', NULL),
(10, 'Fadhillah', 'AYAM123@gmail.com', '698d51a19d8a121ce581499d7b701668', '0831855101', NULL, NULL, NULL, NULL, '2025-06-02 23:37:47', NULL, '1748907467_Screenshot (14).png'),
(11, 'Rodiyan', 'AYAM12@gmail.com', '698d51a19d8a121ce581499d7b701668', '0831855101', NULL, 'JAJA', 'JUJU', 'JAJAJA', '2025-06-02 23:51:52', NULL, '1748908312_Screenshot (14).png'),
(14, 'Rodiyan', 'gila1@gmail.com', '12', '8318551014', NULL, 'JAJA', 'fdsfdsf', 'JAJAJA', '2025-06-03 12:09:24', NULL, '1748952564_HAHAHA.png'),
(16, 'Rodiyan', 'gila@gmail.com', '2', '08318551018', '', 'JAJAA', 'fdsfdsf', 'fdsfdsf', '2025-06-03 12:21:46', '2025-06-14 11:22:39', '1748953306_HAHAHA.png'),
(17, 'hahaha', 'gila2@gmail.com', '1', '0831855101', NULL, 'JAJA', 'fdsfdsf', 'JAJAJA', '2025-06-03 12:52:29', NULL, '1748955149_HAHAHA.png'),
(18, 'a', 'gila1234@gmail.com', '111', '0831855101', NULL, 'aa', 'a', 'a', '2025-06-12 05:58:38', NULL, '1749707918_WhatsApp Image 2025-06-11 at 21.10.32.jpeg'),
(28, 'ULARRRR', 'hahaha123@gmail.com', '12345678', '083185510148', NULL, 'JAJA', 'fdsfdsf', 'a', '2025-06-14 11:12:15', NULL, '1749899535_WhatsApp Image 2025-06-11 at 20.15.05.jpeg'),
(29, 'Rodiyan', 'Rodiyan@gmail.com', '12345678', '083185510148', '', 'Pantai Indah no 72', 'Tanjungpinang', 'Tanjungpinang', '2025-06-15 00:46:06', '2025-06-15 01:54:11', '1749948366_circle.png'),
(30, 'Jamal', 'hahaha12@gmail.com', '12345678', '083185510148', '', 'Pantai Indah no 721', 'Tanjungpinang', 'Indonesia', '2025-06-15 02:07:34', '2025-06-15 02:28:04', '1749953254_user.png'),
(31, 'Rodiyan', 'gila12@gmail.com', '12345678', '083185510148', '10/12/2005', 'Pantai Indah no 72', 'Tanjungpinang', 'Indonesia', '2025-06-15 02:32:38', NULL, '1749954758_user.png');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tblvehicles`
--

CREATE TABLE `tblvehicles` (
  `id` int(11) NOT NULL,
  `VehiclesTitle` varchar(150) DEFAULT NULL,
  `VehiclesBrand` int(11) DEFAULT NULL,
  `VehiclesOverview` longtext DEFAULT NULL,
  `PricePerDay` int(11) DEFAULT NULL,
  `FuelType` varchar(100) DEFAULT NULL,
  `ModelYear` int(6) DEFAULT NULL,
  `SeatingCapacity` int(11) DEFAULT NULL,
  `Vimage1` varchar(120) DEFAULT NULL,
  `Vimage2` varchar(120) DEFAULT NULL,
  `Vimage3` varchar(120) DEFAULT NULL,
  `Vimage4` varchar(120) DEFAULT NULL,
  `Vimage5` varchar(120) DEFAULT NULL,
  `AirConditioner` int(11) DEFAULT NULL,
  `PowerDoorLocks` int(11) DEFAULT NULL,
  `AntiLockBrakingSystem` int(11) DEFAULT NULL,
  `BrakeAssist` int(11) DEFAULT NULL,
  `PowerSteering` int(11) DEFAULT NULL,
  `DriverAirbag` int(11) DEFAULT NULL,
  `PassengerAirbag` int(11) DEFAULT NULL,
  `PowerWindows` int(11) DEFAULT NULL,
  `CDPlayer` int(11) DEFAULT NULL,
  `CentralLocking` int(11) DEFAULT NULL,
  `CrashSensor` int(11) DEFAULT NULL,
  `LeatherSeats` int(11) DEFAULT NULL,
  `RegDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `UpdationDate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `tblvehicles`
--

INSERT INTO `tblvehicles` (`id`, `VehiclesTitle`, `VehiclesBrand`, `VehiclesOverview`, `PricePerDay`, `FuelType`, `ModelYear`, `SeatingCapacity`, `Vimage1`, `Vimage2`, `Vimage3`, `Vimage4`, `Vimage5`, `AirConditioner`, `PowerDoorLocks`, `AntiLockBrakingSystem`, `BrakeAssist`, `PowerSteering`, `DriverAirbag`, `PassengerAirbag`, `PowerWindows`, `CDPlayer`, `CentralLocking`, `CrashSensor`, `LeatherSeats`, `RegDate`, `UpdationDate`) VALUES
(10, 'X1', 2, 'BMW X1 merupakan SUV kompak dari BMW yang dirancang untuk menawarkan keseimbangan antara gaya, kenyamanan, dan performa. Secara tampilan, kendaraan ini memiliki desain eksterior yang modern dan sporty, dengan ciri khas gril kidney BMW yang lebih besar serta lampu LED yang ramping. Proporsinya tetap kompak, cocok digunakan di perkotaan, namun tetap memberikan kesan gagah seperti SUV pada umumnya.\r\n\r\nMasuk ke bagian dalam, interior BMW X1 mengusung nuansa premium. Material yang digunakan terasa mewah, mulai dari jok kulit hingga trim aluminium atau kayu tergantung varian. Di bagian dashboard, terdapat layar infotainment besar yang sudah menggunakan sistem iDrive terbaru dan terintegrasi dengan Apple CarPlay serta Android Auto. Panel instrumen juga sudah full digital, memberikan kesan modern sekaligus memudahkan pengemudi dalam memantau berbagai informasi kendaraan.\r\n\r\nDari sisi performa, BMW X1 memiliki beberapa pilihan mesin. Varian entry-level biasanya menggunakan mesin bensin 1.5 liter tiga silinder, sedangkan varian yang lebih bertenaga dibekali mesin 2.0 liter turbo empat silinder. Tersedia juga pilihan plug-in hybrid untuk efisiensi bahan bakar yang lebih baik, serta varian listrik penuh yang dikenal sebagai BMW iX1. Perpindahan giginya terasa halus berkat penggunaan transmisi otomatis 7-percepatan dual-clutch. Untuk penggeraknya, BMW X1 tersedia dalam pilihan penggerak roda depan maupun sistem xDrive (penggerak semua roda), tergantung tipe yang dipilih.\r\n\r\nSecara keseluruhan, BMW X1 cocok bagi pengguna yang menginginkan SUV kompak dengan kenyamanan tinggi, fitur modern, dan performa khas BMW, tanpa harus memilih SUV berukuran besar.', 250000, 'Petrol', 2023, 6, 'BMW X5 xDrive45e iPerformance gets 394 PS and 50….jpg', 'BMW X1 - Car and Driver.jpg', '26346909-7c75-4853-90cd-ef16afd98893.jpg', '1c6c4f7a-a9e1-4c40-9d6c-e8915e9a3014.jpg', '2473c892-8b4e-4031-9ccb-78a67f130245.jpg', 1, 1, 1, 1, 1, 1, 1, 1, 0, 0, 1, 1, '2025-06-15 17:12:31', '2025-06-15 17:16:59'),
(12, 'Alphard AH40', 5, 'Toyota Alphard AH40 merupakan generasi keempat dari lini MPV mewah Toyota yang diluncurkan mulai tahun 2023. Kendaraan ini hadir dengan pembaruan total, baik dari sisi desain, teknologi, maupun kenyamanan, menjadikannya salah satu MPV paling premium di kelasnya. Desain eksterior Alphard AH40 menampilkan gril depan besar dengan aksen dark chrome dan lampu depan LED modern yang memberikan kesan elegan dan gagah. Proporsi bodi dibuat lebih tinggi dan lebar, dengan panjang mencapai sekitar lima meter, yang memberi ruang kabin sangat luas untuk seluruh penumpang.\r\n\r\nInterior Alphard AH40 dirancang layaknya kabin first class di pesawat. Jok baris kedua menggunakan model captain seat dengan fitur elektrik penuh, termasuk fungsi pijat, pengaturan posisi otomatis, serta sandaran kaki. Material yang digunakan berkualitas tinggi, seperti kulit nappa, aksen kayu mewah, serta pencahayaan ambien dengan 64 pilihan warna yang menciptakan suasana eksklusif di dalam kabin. Fitur tambahan seperti sunroof ganda, panel kontrol individual, port USB-C di setiap baris, dan soket daya AC menambah kesan modern dan fungsional.\r\n\r\nDari sisi performa, Alphard AH40 ditawarkan dalam beberapa pilihan mesin, termasuk mesin bensin 2.5 liter dan varian hybrid yang memadukan efisiensi dengan tenaga yang halus. Di beberapa pasar seperti Jepang dan Malaysia, juga tersedia mesin 2.4 liter turbo yang menawarkan performa lebih bertenaga. Sistem transmisi otomatis 8-percepatan dan penggerak roda depan menjadi konfigurasi standar, sementara suspensi depan MacPherson dan belakang double wishbone memberikan kenyamanan dan stabilitas maksimal saat berkendara.\r\n\r\nTeknologi keselamatan juga ditingkatkan secara signifikan dengan kehadiran Toyota Safety Sense generasi terbaru, mencakup fitur-fitur seperti pre-collision system, lane keeping assist, adaptive cruise control, blind spot monitor, serta kamera 360 derajat dengan resolusi tinggi. Sistem infotainment menampilkan layar besar berukuran 14 inci dengan konektivitas Apple CarPlay dan Android Auto, ditambah sistem audio premium JBL untuk pengalaman mendengarkan yang imersif.\r\n\r\nDengan segala peningkatan ini, Toyota Alphard AH40 menjadi simbol kemewahan dan kenyamanan dalam kendaraan keluarga premium maupun kendaraan eksekutif, memadukan desain elegan, fitur canggih, serta ruang kabin yang luas dan mewah.', 300000, 'Petrol', 2023, 7, 'Toy1.jpg', 'Toy2.jpg', 'Toy3.jpg', 'Toy4.jpg', 'Toy5.jpg', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, '2025-06-15 23:28:36', '2025-06-16 00:06:56'),
(13, 'Granmax MB', 9, 'Daihatsu Gran Max MB adalah kendaraan niaga ringan jenis minibus yang dirancang untuk memenuhi kebutuhan usaha maupun transportasi penumpang. Sejak pertama kali diluncurkan pada tahun 2007, mobil ini dikenal luas di Indonesia berkat daya angkut yang besar, desain kompak, dan biaya operasional yang terjangkau. Desain eksteriornya menggunakan model semi-bonnet yang memberikan kesan fungsional dan memudahkan perawatan mesin. Dimensinya tergolong ramping, dengan panjang sekitar 4 meter, menjadikannya lincah di jalan sempit namun tetap mampu membawa banyak muatan.\r\n\r\nDi bagian interior, Gran Max MB menawarkan kabin luas yang dapat menampung hingga delapan atau sembilan penumpang, tergantung konfigurasi kursinya. Kursi-kursi tersebut bisa dilipat untuk menambah ruang kargo jika dibutuhkan, menjadikan mobil ini fleksibel untuk berbagai keperluan. Meskipun desain interiornya sederhana, beberapa varian telah dilengkapi dengan AC, port USB, dan sistem audio dasar untuk menunjang kenyamanan dalam perjalanan.\r\n\r\nUntuk performa, Gran Max MB dibekali dua pilihan mesin bensin, yaitu 1.3 liter dan 1.5 liter. Mesin 1.3 liter menggunakan tipe K3-DE DOHC, sedangkan mesin 1.5 liter menggunakan tipe 3SZ-VE atau 2NR-VE pada varian terbaru. Mesin ini dikenal irit bahan bakar dan cukup tangguh untuk digunakan dalam berbagai kondisi, terutama karena menggunakan sistem penggerak roda belakang yang lebih cocok untuk membawa beban berat. Semua varian Gran Max MB dilengkapi transmisi manual 5 percepatan.\r\n\r\nFitur keselamatan pada Gran Max MB termasuk rangka monocoque yang kokoh, sabuk pengaman tiga titik, serta sistem pengereman dengan cakram di depan dan tromol di belakang. Suspensinya menggunakan MacPherson strut di bagian depan dan rigid-axle dengan lima link di bagian belakang, memberikan kestabilan yang cukup baik meski kendaraan membawa banyak muatan. Ground clearance yang tinggi serta posisi air intake yang cukup tinggi juga membuat kendaraan ini tetap andal digunakan di jalanan dengan genangan air.\r\n\r\nSecara keseluruhan, Daihatsu Gran Max MB merupakan pilihan kendaraan yang ekonomis, andal, dan fungsional untuk keperluan niaga atau transportasi massal skala kecil. Kelebihannya terletak pada ruang kabin yang luas, konsumsi bahan bakar yang efisien, serta biaya perawatan yang rendah. Namun dari sisi kenyamanan dan fitur keselamatan, mobil ini masih tergolong standar sesuai dengan segmentasinya sebagai kendaraan komersial.', 180000, 'Diesel', 2020, 9, '1.jpg', '2.jpg', 'Dai3.jpg', 'Dai5.jpg', 'Dai4.jpg', 1, 0, 1, 1, 1, 1, 0, 1, 1, 0, 1, 0, '2025-06-15 23:38:33', '2025-06-15 23:58:02'),
(14, 'Pajero Sport', 10, 'Mitsubishi Pajero Sport 2022 adalah SUV tangguh dengan rangka ladder-frame yang dirancang untuk menghadapi berbagai kondisi jalan, termasuk medan berat. Mobil ini memiliki desain gagah dan modern, dengan tampilan depan yang tajam serta lampu utama sipit yang memberi kesan futuristik. Dimensinya besar dengan panjang sekitar 4,8 meter dan jarak sumbu roda 2,8 meter, menjadikan kabinnya luas untuk penumpang dan barang.\r\n\r\nDitenagai oleh mesin diesel 2.4 liter MIVEC turbo, Pajero Sport 2022 mampu menghasilkan tenaga sekitar 181 PS dan torsi 430 Nm. Mesin ini dipadukan dengan transmisi otomatis 8 percepatan yang halus dan responsif. Beberapa varian menggunakan sistem penggerak 4x2, sementara varian tertinggi sudah menggunakan 4x4 dengan fitur Super Select 4WD II untuk meningkatkan kemampuan off-road.\r\n\r\nDi bagian interior, Pajero Sport menawarkan kenyamanan dan kemewahan dengan penggunaan jok kulit, head unit layar sentuh, panel instrumen digital, AC dual zone, serta fitur-fitur modern seperti power tailgate, kamera 360 derajat, dan sunroof. Kabin dapat menampung hingga tujuh penumpang dengan konfigurasi tiga baris kursi, di mana kursi baris ketiga bisa dilipat untuk memperluas bagasi.\r\n\r\nFitur keselamatan yang tersedia cukup lengkap, antara lain sistem pengereman ABS dan EBD, kontrol traksi, hill start assist, hill descent control, tujuh airbag, cruise control adaptif, serta fitur bantuan berkendara seperti lane change assist dan rear cross traffic alert pada varian tertinggi.\r\n\r\nDari sisi kenyamanan berkendara, Pajero Sport dikenal stabil di jalan tol dan kuat di medan berat. Suspensinya memang sedikit kaku di jalanan kota, tetapi hal ini diimbangi dengan ketangguhan saat digunakan di medan menantang. Konsumsi bahan bakarnya berkisar 8 hingga 9 liter per 100 km, tergantung kondisi penggunaan.\r\n\r\nSecara keseluruhan, Mitsubishi Pajero Sport 2022 adalah pilihan yang solid bagi pengguna yang membutuhkan kendaraan diesel tangguh, nyaman untuk keluarga, dan siap diajak berpetualang di berbagai medan. Kelebihan utamanya terletak pada performa mesin, kelengkapan fitur, dan kemampuan off-road, meski beberapa pengguna mungkin merasa kabin agak sempit di baris ketiga dan suspensi terasa keras saat melintasi jalan berlubang.', 400000, 'CNG', 2022, 7, 'Mit1.jpg', 'Mit2.jpg', 'Mit3.jpg', 'Mit4.jpg', 'Mit5.jpg', 1, 1, 1, 1, 1, 1, 0, 1, 1, 0, 1, 1, '2025-06-15 23:43:15', '2025-06-16 00:01:19'),
(15, 'Serena C26', 4, 'Nissan Serena C26 adalah generasi kelima dari lini MPV keluarga Nissan yang pertama kali diluncurkan pada tahun 2010 dan dikenal luas di pasar Jepang serta beberapa negara Asia, termasuk Indonesia. Kendaraan ini hadir dengan desain yang lebih modern dan fitur yang disesuaikan untuk kebutuhan keluarga maupun penggunaan sehari-hari. Desain eksteriornya menampilkan bentuk kotak yang khas MPV, namun tetap dinamis dengan sentuhan garis-garis tegas dan lampu depan besar yang memberikan kesan elegan dan fungsional. Pada bagian interior, Nissan Serena C26 menawarkan kabin yang luas dan fleksibel, dengan konfigurasi tempat duduk tiga baris yang dapat menampung hingga tujuh penumpang. Salah satu keunggulan utama dari mobil ini adalah sistem kursi \"Smart Multi Center Seat\" yang memungkinkan pengaturan bangku baris kedua menjadi lebih fleksibel untuk memudahkan akses ke baris ketiga. Material interior yang digunakan memberikan kesan nyaman dan cocok untuk perjalanan jarak jauh, sementara bagasi yang luas mendukung kebutuhan membawa barang dalam jumlah besar. Nissan Serena C26 ditenagai oleh mesin bensin 2.0 liter MR20DD yang dipadukan dengan sistem transmisi Xtronic CVT, menghasilkan perpindahan gigi yang halus dan efisiensi bahan bakar yang baik. Untuk varian di Jepang, tersedia juga pilihan dengan teknologi S-Hybrid, yang membantu menurunkan konsumsi bahan bakar melalui sistem motor elektrik ringan. Meskipun bukan mobil dengan performa tinggi, Serena C26 sangat mengutamakan kenyamanan dan efisiensi, sehingga cocok sebagai kendaraan keluarga atau travel. Dari sisi keselamatan dan teknologi, Nissan Serena C26 dilengkapi dengan fitur standar seperti airbag, ABS, EBD, kamera mundur, serta sensor parkir. Pada beberapa varian, tersedia juga fitur hiburan layar ganda, kontrol iklim otomatis, serta pintu geser elektrik yang memudahkan akses keluar-masuk penumpang. Kombinasi antara desain praktis, efisiensi bahan bakar, dan fitur lengkap menjadikan Nissan Serena C26 sebagai pilihan populer di kelas MPV keluarga.', 180000, 'Petrol', 2010, 7, 'Nis1.jpg', 'Nis2.jpg', 'Nis3.jpg', 'Nis4.jpg', 'Nis5.jpg', 1, 1, 1, 1, 0, 1, 0, 1, 1, 1, 1, 1, '2025-06-15 23:52:29', '2025-06-16 00:04:15'),
(16, 'Xforce Exceed CVT', 10, 'Mitsubishi Xforce adalah SUV kompak terbaru dari Mitsubishi yang mulai dipasarkan di Indonesia pada tahun 2023. Mobil ini dirancang untuk memenuhi kebutuhan konsumen urban yang menginginkan kendaraan bergaya, nyaman, dan tangguh untuk aktivitas harian maupun perjalanan luar kota. Desain eksteriornya menampilkan bahasa desain Dynamic Shield khas Mitsubishi, dengan garis tegas, lampu LED tajam, dan bentuk bodi yang menggabungkan kesan futuristik dan sporty. Dimensinya yang kompak membuat Xforce mudah bermanuver di jalan perkotaan, namun tetap memiliki ground clearance tinggi yang mendukung karakter SUV.\r\n\r\nMasuk ke bagian interior, Mitsubishi Xforce menawarkan kabin yang lapang dengan tata letak ergonomis dan kualitas material yang cukup baik di kelasnya. Pada varian tertinggi, tersedia sistem audio premium dari Yamaha, layar infotainment besar dengan konektivitas Android Auto dan Apple CarPlay, serta ambient lighting yang memperkuat nuansa modern. Posisi duduk yang tinggi memberikan visibilitas lebih baik bagi pengemudi, sementara ruang kaki dan kepala di baris belakang cukup lega untuk penumpang dewasa. Jok menggunakan material kombinasi kulit dan kain pada varian Ultimate, sementara varian Exceed lebih sederhana namun tetap nyaman.\r\n\r\nMitsubishi Xforce ditenagai oleh mesin bensin 1.5 liter MIVEC yang disandingkan dengan transmisi otomatis CVT. Mesin ini memberikan performa yang cukup untuk penggunaan harian, dengan akselerasi halus dan konsumsi bahan bakar yang efisien. Sistem penggerak roda depan menjadikan mobil ini ringan dikendalikan dan cocok untuk jalanan kota. Suspensinya disesuaikan untuk memberikan kenyamanan maksimal, terutama saat melewati jalan berlubang atau bergelombang.\r\n\r\nDari sisi keselamatan, Mitsubishi Xforce sudah dilengkapi dengan berbagai fitur penting seperti kamera belakang, airbag ganda, kontrol traksi, hill start assist, dan rem ABS dengan EBD. Untuk varian Ultimate, ditambahkan fitur-fitur canggih seperti kamera 360 derajat, active yaw control, serta berbagai sensor bantuan berkendara yang meningkatkan keselamatan dan kemudahan manuver.\r\n\r\nSecara keseluruhan, Mitsubishi Xforce merupakan pilihan menarik di segmen SUV kompak dengan desain yang atraktif, fitur modern, kabin nyaman, dan efisiensi bahan bakar yang baik. Mobil ini sangat cocok untuk pengguna muda atau keluarga kecil yang menginginkan kendaraan stylish, praktis, dan siap diajak berkendara di berbagai kondisi jalan.', 320000, 'Petrol', 2023, 7, 'Mit6.jpg', 'Mit9.jpg', 'Mit7.jpg', 'Mit10.jpg', 'Mit8.jpg', 1, 1, 1, 1, 1, 1, 0, 1, 0, 0, 1, 1, '2025-06-16 00:15:10', NULL);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tblbooking`
--
ALTER TABLE `tblbooking`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tblbrands`
--
ALTER TABLE `tblbrands`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tblcontactusinfo`
--
ALTER TABLE `tblcontactusinfo`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tblcontactusquery`
--
ALTER TABLE `tblcontactusquery`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tblpages`
--
ALTER TABLE `tblpages`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tblsubscribers`
--
ALTER TABLE `tblsubscribers`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbltestimonial`
--
ALTER TABLE `tbltestimonial`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tblusers`
--
ALTER TABLE `tblusers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `EmailId` (`EmailId`);

--
-- Indeks untuk tabel `tblvehicles`
--
ALTER TABLE `tblvehicles`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `tblbooking`
--
ALTER TABLE `tblbooking`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT untuk tabel `tblbrands`
--
ALTER TABLE `tblbrands`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `tblcontactusinfo`
--
ALTER TABLE `tblcontactusinfo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `tblcontactusquery`
--
ALTER TABLE `tblcontactusquery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `tblpages`
--
ALTER TABLE `tblpages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT untuk tabel `tblsubscribers`
--
ALTER TABLE `tblsubscribers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `tbltestimonial`
--
ALTER TABLE `tbltestimonial`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `tblusers`
--
ALTER TABLE `tblusers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT untuk tabel `tblvehicles`
--
ALTER TABLE `tblvehicles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
