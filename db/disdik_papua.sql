-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 17 Agu 2026 pada 05.18
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
-- Database: `disdik_papua`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `ci_sessions`
--

CREATE TABLE `ci_sessions` (
  `id` varchar(128) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `data` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `ci_sessions`
--

INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES
('b0qh27f9nfrolftmojmnqaee11nmo115', '::1', 1786694895, 0x5f5f63695f6c6173745f726567656e65726174657c693a313738363639343839353b69645f70656e6767756e617c733a313a2231223b6e616d615f6c656e676b61707c733a31333a2241646d696e6973747261746f72223b757365726e616d657c733a353a2261646d696e223b726f6c657c733a353a2261646d696e223b69645f626964616e677c4e3b6a61626174616e7c733a32303a2241646d696e6973747261746f722053697374656d223b666f746f7c733a31313a2264656661756c742e706e67223b),
('peo9o5bhhckar6jpktpsrtc08ts700eq', '::1', 1786696238, 0x5f5f63695f6c6173745f726567656e65726174657c693a313738363639363233383b69645f70656e6767756e617c733a313a2231223b6e616d615f6c656e676b61707c733a31333a2241646d696e6973747261746f72223b757365726e616d657c733a353a2261646d696e223b726f6c657c733a353a2261646d696e223b69645f626964616e677c4e3b6a61626174616e7c733a32303a2241646d696e6973747261746f722053697374656d223b666f746f7c733a31313a2264656661756c742e706e67223b),
('kh83pb7u1i4prqr4s3gi1ovot5dek2fr', '::1', 1786696570, 0x5f5f63695f6c6173745f726567656e65726174657c693a313738363639363438353b69645f70656e6767756e617c733a313a2233223b6e616d615f6c656e676b61707c733a31323a224b6570616c612044696e6173223b757365726e616d657c733a353a226b61646973223b726f6c657c733a353a226b61646973223b69645f626964616e677c4e3b6a61626174616e7c733a32333a224b6570616c612044696e61732050656e646964696b616e223b666f746f7c733a31313a2264656661756c742e706e67223b),
('or5oih6d86j975s9cu4vgtvi94s5q1fh', '::1', 1786778335, 0x5f5f63695f6c6173745f726567656e65726174657c693a313738363737383333353b69645f70656e6767756e617c733a313a2232223b6e616d615f6c656e676b61707c733a31393a22537461662050656e6572696d61205375726174223b757365726e616d657c733a353a227365707269223b726f6c657c733a353a227365707269223b69645f626964616e677c733a313a2231223b6a61626174616e7c733a31393a22537461662050656e6572696d61205375726174223b666f746f7c733a31313a2264656661756c742e706e67223b),
('29iae962qaqa1uodt2b16f2aqfn5eqbs', '::1', 1786778653, 0x5f5f63695f6c6173745f726567656e65726174657c693a313738363737383635333b6572726f727c733a32393a22557365726e616d6520617461752070617373776f72642073616c616821223b5f5f63695f766172737c613a313a7b733a353a226572726f72223b733a333a226f6c64223b7d),
('l7ve1ll47lucarsm8ips91l713d9q69l', '::1', 1786778653, 0x5f5f63695f6c6173745f726567656e65726174657c693a313738363737383635333b6572726f727c733a32393a22557365726e616d6520617461752070617373776f72642073616c616821223b5f5f63695f766172737c613a313a7b733a353a226572726f72223b733a333a226f6c64223b7d);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_bidang`
--

CREATE TABLE `tbl_bidang` (
  `id_bidang` int(11) NOT NULL,
  `kode_bidang` varchar(20) NOT NULL,
  `nama_bidang` varchar(100) NOT NULL,
  `keterangan` text DEFAULT NULL,
  `aktif` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `tbl_bidang`
--

INSERT INTO `tbl_bidang` (`id_bidang`, `kode_bidang`, `nama_bidang`, `keterangan`, `aktif`) VALUES
(1, 'SEKRETARIAT', 'Sekretariat', NULL, 1),
(2, 'BIDANG-SD', 'Bidang Pembinaan SD', NULL, 1),
(3, 'BIDANG-SMP', 'Bidang Pembinaan SMP', NULL, 1),
(4, 'BIDANG-SMA', 'Bidang Pembinaan SMA', NULL, 1),
(5, 'BIDANG-SMK', 'Bidang Pembinaan SMK', NULL, 1),
(6, 'BIDANG-GTK', 'Bidang GTK', NULL, 1),
(7, 'BIDANG-PAUD', 'Bidang PAUD & PNF', NULL, 1),
(8, 'BIDANG-SARPRAS', 'Bidang Sarana Prasarana', NULL, 1),
(9, 'BIDANG-UMUM', 'Bidang Umum', NULL, 1),
(10, 'Bidang_kom', 'Bidang Komunikasi', '', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_disposisi`
--

CREATE TABLE `tbl_disposisi` (
  `id_disposisi` int(11) NOT NULL,
  `id_surat` int(11) NOT NULL,
  `id_pengguna_disposisi` int(11) NOT NULL,
  `isi_disposisi` text NOT NULL,
  `instruksi` text DEFAULT NULL,
  `tgl_disposisi` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `tbl_disposisi`
--

INSERT INTO `tbl_disposisi` (`id_disposisi`, `id_surat`, `id_pengguna_disposisi`, `isi_disposisi`, `instruksi`, `tgl_disposisi`) VALUES
(1, 3, 3, 'Untuk ditindaklanjuti sesuai bidang masing-masing', 'Segera diproses', '2026-08-14 10:30:32'),
(2, 4, 3, 'Untuk ditindaklanjuti sesuai bidang masing-masing', 'Segera diproses', '2026-08-14 10:30:32'),
(3, 5, 3, 'Untuk ditindaklanjuti sesuai bidang masing-masing', 'Segera diproses', '2026-08-14 10:30:32'),
(4, 1, 3, 'aw', '', '2026-08-15 10:02:50'),
(5, 2, 3, 'oke kerjakan', '', '2026-08-15 10:05:14'),
(6, 6, 3, 'kerjakan', '', '2026-08-16 02:39:00'),
(7, 8, 3, 'tolong diserahkan ke bidang smk', '', '2026-08-16 07:08:46');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_disposisi_bidang`
--

CREATE TABLE `tbl_disposisi_bidang` (
  `id` int(11) NOT NULL,
  `id_disposisi` int(11) NOT NULL,
  `id_bidang` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `tbl_disposisi_bidang`
--

INSERT INTO `tbl_disposisi_bidang` (`id`, `id_disposisi`, `id_bidang`) VALUES
(1, 1, 2),
(2, 1, 3),
(3, 1, 6),
(4, 1, 4),
(5, 1, 5),
(6, 1, 7),
(7, 1, 8),
(8, 1, 1),
(9, 2, 2),
(10, 2, 3),
(11, 2, 6),
(12, 2, 4),
(13, 2, 5),
(14, 2, 7),
(15, 2, 8),
(16, 2, 1),
(17, 3, 2),
(18, 3, 3),
(19, 3, 6),
(20, 3, 4),
(21, 3, 5),
(22, 3, 7),
(23, 3, 8),
(24, 3, 1),
(25, 4, 1),
(26, 4, 2),
(27, 5, 4),
(28, 5, 10),
(29, 6, 2),
(30, 7, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_distribusi`
--

CREATE TABLE `tbl_distribusi` (
  `id_distribusi` int(11) NOT NULL,
  `id_surat` int(11) NOT NULL,
  `id_bidang` int(11) NOT NULL,
  `id_pengguna_kirim` int(11) NOT NULL,
  `tgl_kirim` datetime DEFAULT current_timestamp(),
  `tgl_terima` datetime DEFAULT NULL,
  `id_pengguna_terima` int(11) DEFAULT NULL,
  `catatan_kirim` text DEFAULT NULL,
  `catatan_terima` text DEFAULT NULL,
  `status` enum('dikirim','diterima') DEFAULT 'dikirim'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `tbl_distribusi`
--

INSERT INTO `tbl_distribusi` (`id_distribusi`, `id_surat`, `id_bidang`, `id_pengguna_kirim`, `tgl_kirim`, `tgl_terima`, `id_pengguna_terima`, `catatan_kirim`, `catatan_terima`, `status`) VALUES
(1, 3, 2, 4, '2026-08-14 10:30:32', '2026-08-15 09:45:57', 5, 'Dikirim untuk ditindaklanjuti', '', 'diterima'),
(2, 3, 3, 4, '2026-08-14 10:30:32', '2026-08-15 09:50:05', 6, 'Dikirim untuk ditindaklanjuti', '', 'diterima'),
(3, 3, 6, 4, '2026-08-14 10:30:32', '2026-08-15 09:52:14', 1, 'Dikirim untuk ditindaklanjuti', '', 'diterima'),
(4, 3, 4, 4, '2026-08-14 10:30:32', '2026-08-15 09:52:18', 1, 'Dikirim untuk ditindaklanjuti', '', 'diterima'),
(5, 3, 5, 4, '2026-08-14 10:30:32', '2026-08-15 09:52:20', 1, 'Dikirim untuk ditindaklanjuti', '', 'diterima'),
(6, 3, 7, 4, '2026-08-14 10:30:32', '2026-08-15 09:52:27', 1, 'Dikirim untuk ditindaklanjuti', '', 'diterima'),
(7, 3, 8, 4, '2026-08-14 10:30:32', '2026-08-15 09:52:24', 1, 'Dikirim untuk ditindaklanjuti', '', 'diterima'),
(8, 3, 1, 4, '2026-08-14 10:30:32', '2026-08-15 09:52:29', 1, 'Dikirim untuk ditindaklanjuti', '', 'diterima'),
(9, 4, 2, 4, '2026-08-14 10:30:32', '2026-08-15 10:03:09', 5, 'Dikirim untuk ditindaklanjuti', '', 'diterima'),
(10, 4, 3, 4, '2026-08-14 10:30:32', '2026-08-15 09:54:49', 6, 'Dikirim untuk ditindaklanjuti', '', 'diterima'),
(11, 4, 6, 4, '2026-08-14 10:30:32', NULL, NULL, 'Dikirim untuk ditindaklanjuti', NULL, 'dikirim'),
(12, 4, 4, 4, '2026-08-14 10:30:32', '2026-08-15 10:05:56', 9, 'Dikirim untuk ditindaklanjuti', '', 'diterima'),
(13, 4, 5, 4, '2026-08-14 10:30:32', NULL, NULL, 'Dikirim untuk ditindaklanjuti', NULL, 'dikirim'),
(14, 4, 7, 4, '2026-08-14 10:30:32', NULL, NULL, 'Dikirim untuk ditindaklanjuti', NULL, 'dikirim'),
(15, 4, 8, 4, '2026-08-14 10:30:32', NULL, NULL, 'Dikirim untuk ditindaklanjuti', NULL, 'dikirim'),
(16, 4, 1, 4, '2026-08-14 10:30:32', NULL, NULL, 'Dikirim untuk ditindaklanjuti', NULL, 'dikirim'),
(17, 5, 2, 4, '2026-08-14 10:30:32', '2026-08-15 12:09:19', 5, 'Dikirim untuk ditindaklanjuti', '', 'diterima'),
(18, 5, 3, 4, '2026-08-14 10:30:32', NULL, NULL, 'Dikirim untuk ditindaklanjuti', NULL, 'dikirim'),
(19, 5, 6, 4, '2026-08-14 10:30:32', NULL, NULL, 'Dikirim untuk ditindaklanjuti', NULL, 'dikirim'),
(20, 5, 4, 4, '2026-08-14 10:30:32', '2026-08-15 10:06:52', 9, 'Dikirim untuk ditindaklanjuti', 'oke bos', 'diterima'),
(21, 5, 5, 4, '2026-08-14 10:30:32', NULL, NULL, 'Dikirim untuk ditindaklanjuti', NULL, 'dikirim'),
(22, 5, 7, 4, '2026-08-14 10:30:32', NULL, NULL, 'Dikirim untuk ditindaklanjuti', NULL, 'dikirim'),
(23, 5, 8, 4, '2026-08-14 10:30:32', NULL, NULL, 'Dikirim untuk ditindaklanjuti', NULL, 'dikirim'),
(24, 5, 1, 4, '2026-08-14 10:30:32', NULL, NULL, 'Dikirim untuk ditindaklanjuti', NULL, 'dikirim'),
(25, 2, 1, 16, '2026-08-15 11:28:19', NULL, NULL, '', NULL, 'dikirim'),
(26, 6, 2, 14, '2026-08-16 02:41:00', '2026-08-16 02:41:57', 5, '', '', 'diterima'),
(27, 1, 1, 14, '2026-08-16 02:41:31', NULL, NULL, '', NULL, 'dikirim'),
(28, 1, 2, 14, '2026-08-16 02:41:31', NULL, NULL, '', NULL, 'dikirim');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_notifikasi`
--

CREATE TABLE `tbl_notifikasi` (
  `id_notif` int(11) NOT NULL,
  `id_pengguna` int(11) NOT NULL,
  `id_surat` int(11) DEFAULT NULL,
  `pesan` text NOT NULL,
  `dibaca` tinyint(1) DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `tbl_notifikasi`
--

INSERT INTO `tbl_notifikasi` (`id_notif`, `id_pengguna`, `id_surat`, `pesan`, `dibaca`, `created_at`) VALUES
(1, 3, 1, 'Surat baru masuk: asdawda', 1, '2026-08-14 16:36:04'),
(2, 8, 1, 'Surat baru masuk: asdawda', 0, '2026-08-14 16:36:04'),
(3, 3, 2, 'Surat baru masuk: DAU', 1, '2026-08-14 16:59:07'),
(4, 8, 2, 'Surat baru masuk: DAU', 0, '2026-08-14 16:59:07'),
(5, 4, 1, 'Surat \"asdawda\" telah didisposisi, siap didistribusikan.', 0, '2026-08-15 17:02:50'),
(6, 14, 1, 'Surat \"asdawda\" telah didisposisi, siap didistribusikan.', 0, '2026-08-15 17:02:50'),
(7, 15, 1, 'Surat \"asdawda\" telah didisposisi, siap didistribusikan.', 0, '2026-08-15 17:02:50'),
(8, 16, 1, 'Surat \"asdawda\" telah didisposisi, siap didistribusikan.', 0, '2026-08-15 17:02:50'),
(9, 17, 1, 'Surat \"asdawda\" telah didisposisi, siap didistribusikan.', 0, '2026-08-15 17:02:50'),
(10, 1, 1, 'Surat \"asdawda\" telah didisposisi oleh Kepala Dinas.', 0, '2026-08-15 17:02:50'),
(11, 2, 1, 'Surat \"asdawda\" telah didisposisi oleh Kepala Dinas.', 1, '2026-08-15 17:02:50'),
(12, 1, 4, 'Surat \"Surat Test Distribusi 2 - Pemberitahuan Dana BOS\" telah diterima oleh Kepala Bidang SD (Bidang Pembinaan SD)', 0, '2026-08-15 17:03:09'),
(13, 4, 4, 'Surat \"Surat Test Distribusi 2 - Pemberitahuan Dana BOS\" telah diterima oleh Kepala Bidang SD (Bidang Pembinaan SD)', 0, '2026-08-15 17:03:09'),
(14, 14, 4, 'Surat \"Surat Test Distribusi 2 - Pemberitahuan Dana BOS\" telah diterima oleh Kepala Bidang SD (Bidang Pembinaan SD)', 0, '2026-08-15 17:03:09'),
(15, 15, 4, 'Surat \"Surat Test Distribusi 2 - Pemberitahuan Dana BOS\" telah diterima oleh Kepala Bidang SD (Bidang Pembinaan SD)', 0, '2026-08-15 17:03:09'),
(16, 16, 4, 'Surat \"Surat Test Distribusi 2 - Pemberitahuan Dana BOS\" telah diterima oleh Kepala Bidang SD (Bidang Pembinaan SD)', 0, '2026-08-15 17:03:09'),
(17, 17, 4, 'Surat \"Surat Test Distribusi 2 - Pemberitahuan Dana BOS\" telah diterima oleh Kepala Bidang SD (Bidang Pembinaan SD)', 0, '2026-08-15 17:03:09'),
(18, 4, 2, 'Surat \"DAU\" telah didisposisi, siap didistribusikan.', 0, '2026-08-15 17:05:14'),
(19, 14, 2, 'Surat \"DAU\" telah didisposisi, siap didistribusikan.', 0, '2026-08-15 17:05:14'),
(20, 15, 2, 'Surat \"DAU\" telah didisposisi, siap didistribusikan.', 0, '2026-08-15 17:05:14'),
(21, 16, 2, 'Surat \"DAU\" telah didisposisi, siap didistribusikan.', 0, '2026-08-15 17:05:14'),
(22, 17, 2, 'Surat \"DAU\" telah didisposisi, siap didistribusikan.', 0, '2026-08-15 17:05:14'),
(23, 1, 2, 'Surat \"DAU\" telah didisposisi oleh Kepala Dinas.', 0, '2026-08-15 17:05:14'),
(24, 2, 2, 'Surat \"DAU\" telah didisposisi oleh Kepala Dinas.', 1, '2026-08-15 17:05:14'),
(25, 1, 4, 'Surat \"Surat Test Distribusi 2 - Pemberitahuan Dana BOS\" telah diterima oleh Kepala Bidang SMA (Bidang Pembinaan SMA)', 0, '2026-08-15 17:05:56'),
(26, 4, 4, 'Surat \"Surat Test Distribusi 2 - Pemberitahuan Dana BOS\" telah diterima oleh Kepala Bidang SMA (Bidang Pembinaan SMA)', 0, '2026-08-15 17:05:56'),
(27, 14, 4, 'Surat \"Surat Test Distribusi 2 - Pemberitahuan Dana BOS\" telah diterima oleh Kepala Bidang SMA (Bidang Pembinaan SMA)', 0, '2026-08-15 17:05:56'),
(28, 15, 4, 'Surat \"Surat Test Distribusi 2 - Pemberitahuan Dana BOS\" telah diterima oleh Kepala Bidang SMA (Bidang Pembinaan SMA)', 0, '2026-08-15 17:05:56'),
(29, 16, 4, 'Surat \"Surat Test Distribusi 2 - Pemberitahuan Dana BOS\" telah diterima oleh Kepala Bidang SMA (Bidang Pembinaan SMA)', 0, '2026-08-15 17:05:56'),
(30, 17, 4, 'Surat \"Surat Test Distribusi 2 - Pemberitahuan Dana BOS\" telah diterima oleh Kepala Bidang SMA (Bidang Pembinaan SMA)', 0, '2026-08-15 17:05:56'),
(31, 1, 5, 'Surat \"Surat Test Distribusi 3 - Laporan Kegiatan Semester\" telah diterima oleh Kepala Bidang SMA (Bidang Pembinaan SMA)', 0, '2026-08-15 17:06:52'),
(32, 4, 5, 'Surat \"Surat Test Distribusi 3 - Laporan Kegiatan Semester\" telah diterima oleh Kepala Bidang SMA (Bidang Pembinaan SMA)', 0, '2026-08-15 17:06:52'),
(33, 14, 5, 'Surat \"Surat Test Distribusi 3 - Laporan Kegiatan Semester\" telah diterima oleh Kepala Bidang SMA (Bidang Pembinaan SMA)', 0, '2026-08-15 17:06:52'),
(34, 15, 5, 'Surat \"Surat Test Distribusi 3 - Laporan Kegiatan Semester\" telah diterima oleh Kepala Bidang SMA (Bidang Pembinaan SMA)', 0, '2026-08-15 17:06:52'),
(35, 16, 5, 'Surat \"Surat Test Distribusi 3 - Laporan Kegiatan Semester\" telah diterima oleh Kepala Bidang SMA (Bidang Pembinaan SMA)', 0, '2026-08-15 17:06:52'),
(36, 17, 5, 'Surat \"Surat Test Distribusi 3 - Laporan Kegiatan Semester\" telah diterima oleh Kepala Bidang SMA (Bidang Pembinaan SMA)', 0, '2026-08-15 17:06:52'),
(37, 13, 2, 'Surat \"DAU\" sedang dikirim ke bidang Anda.', 0, '2026-08-15 18:28:19'),
(38, 1, 5, 'Surat \"Surat Test Distribusi 3 - Laporan Kegiatan Semester\" telah diterima oleh Kepala Bidang SD (Bidang Pembinaan SD)', 0, '2026-08-15 19:09:19'),
(39, 4, 5, 'Surat \"Surat Test Distribusi 3 - Laporan Kegiatan Semester\" telah diterima oleh Kepala Bidang SD (Bidang Pembinaan SD)', 0, '2026-08-15 19:09:19'),
(40, 14, 5, 'Surat \"Surat Test Distribusi 3 - Laporan Kegiatan Semester\" telah diterima oleh Kepala Bidang SD (Bidang Pembinaan SD)', 0, '2026-08-15 19:09:19'),
(41, 15, 5, 'Surat \"Surat Test Distribusi 3 - Laporan Kegiatan Semester\" telah diterima oleh Kepala Bidang SD (Bidang Pembinaan SD)', 0, '2026-08-15 19:09:19'),
(42, 16, 5, 'Surat \"Surat Test Distribusi 3 - Laporan Kegiatan Semester\" telah diterima oleh Kepala Bidang SD (Bidang Pembinaan SD)', 0, '2026-08-15 19:09:19'),
(43, 17, 5, 'Surat \"Surat Test Distribusi 3 - Laporan Kegiatan Semester\" telah diterima oleh Kepala Bidang SD (Bidang Pembinaan SD)', 0, '2026-08-15 19:09:19'),
(44, 4, NULL, 'Surat masuk baru dari Kantor Gubernur - \"ada sesuatu harus dikerjakan\" menunggu penerimaan.', 0, '2026-08-16 09:36:37'),
(45, 14, NULL, 'Surat masuk baru dari Kantor Gubernur - \"ada sesuatu harus dikerjakan\" menunggu penerimaan.', 0, '2026-08-16 09:36:37'),
(46, 15, NULL, 'Surat masuk baru dari Kantor Gubernur - \"ada sesuatu harus dikerjakan\" menunggu penerimaan.', 0, '2026-08-16 09:36:37'),
(47, 16, NULL, 'Surat masuk baru dari Kantor Gubernur - \"ada sesuatu harus dikerjakan\" menunggu penerimaan.', 0, '2026-08-16 09:36:37'),
(48, 17, NULL, 'Surat masuk baru dari Kantor Gubernur - \"ada sesuatu harus dikerjakan\" menunggu penerimaan.', 0, '2026-08-16 09:36:37'),
(49, 2, NULL, 'Surat dari Kantor Gubernur telah diterima Bidang Umum, menunggu validasi Anda.', 0, '2026-08-16 09:37:19'),
(50, 1, 6, 'Surat baru dari Kantor Gubernur telah divalidasi Sepri dan siap untuk disposisi.', 0, '2026-08-16 09:37:58'),
(51, 3, 6, 'Surat baru dari Kantor Gubernur telah divalidasi Sepri dan siap untuk disposisi.', 0, '2026-08-16 09:37:58'),
(52, 8, 6, 'Surat baru dari Kantor Gubernur telah divalidasi Sepri dan siap untuk disposisi.', 0, '2026-08-16 09:37:58'),
(53, 4, 6, 'Surat \"ada sesuatu harus dikerjakan\" telah didisposisi, siap didistribusikan.', 0, '2026-08-16 09:39:00'),
(54, 14, 6, 'Surat \"ada sesuatu harus dikerjakan\" telah didisposisi, siap didistribusikan.', 0, '2026-08-16 09:39:00'),
(55, 15, 6, 'Surat \"ada sesuatu harus dikerjakan\" telah didisposisi, siap didistribusikan.', 0, '2026-08-16 09:39:00'),
(56, 16, 6, 'Surat \"ada sesuatu harus dikerjakan\" telah didisposisi, siap didistribusikan.', 0, '2026-08-16 09:39:00'),
(57, 17, 6, 'Surat \"ada sesuatu harus dikerjakan\" telah didisposisi, siap didistribusikan.', 0, '2026-08-16 09:39:00'),
(58, 1, 6, 'Surat \"ada sesuatu harus dikerjakan\" telah didisposisi oleh Kepala Dinas.', 0, '2026-08-16 09:39:00'),
(59, 2, 6, 'Surat \"ada sesuatu harus dikerjakan\" telah didisposisi oleh Kepala Dinas.', 0, '2026-08-16 09:39:00'),
(60, 5, 6, 'Surat \"ada sesuatu harus dikerjakan\" sedang dikirim ke bidang Anda.', 0, '2026-08-16 09:41:00'),
(61, 13, 1, 'Surat \"asdawda\" sedang dikirim ke bidang Anda.', 0, '2026-08-16 09:41:31'),
(62, 5, 1, 'Surat \"asdawda\" sedang dikirim ke bidang Anda.', 0, '2026-08-16 09:41:31'),
(63, 1, 6, 'Surat \"ada sesuatu harus dikerjakan\" telah diterima oleh Kepala Bidang SD (Bidang Pembinaan SD)', 0, '2026-08-16 09:41:57'),
(64, 4, 6, 'Surat \"ada sesuatu harus dikerjakan\" telah diterima oleh Kepala Bidang SD (Bidang Pembinaan SD)', 0, '2026-08-16 09:41:57'),
(65, 14, 6, 'Surat \"ada sesuatu harus dikerjakan\" telah diterima oleh Kepala Bidang SD (Bidang Pembinaan SD)', 0, '2026-08-16 09:41:57'),
(66, 15, 6, 'Surat \"ada sesuatu harus dikerjakan\" telah diterima oleh Kepala Bidang SD (Bidang Pembinaan SD)', 0, '2026-08-16 09:41:57'),
(67, 16, 6, 'Surat \"ada sesuatu harus dikerjakan\" telah diterima oleh Kepala Bidang SD (Bidang Pembinaan SD)', 0, '2026-08-16 09:41:57'),
(68, 17, 6, 'Surat \"ada sesuatu harus dikerjakan\" telah diterima oleh Kepala Bidang SD (Bidang Pembinaan SD)', 0, '2026-08-16 09:41:57'),
(69, 4, NULL, 'Surat masuk baru dari kantor bapperida - \"ada penting\" menunggu penerimaan.', 0, '2026-08-16 13:13:07'),
(70, 14, NULL, 'Surat masuk baru dari kantor bapperida - \"ada penting\" menunggu penerimaan.', 0, '2026-08-16 13:13:07'),
(71, 15, NULL, 'Surat masuk baru dari kantor bapperida - \"ada penting\" menunggu penerimaan.', 0, '2026-08-16 13:13:07'),
(72, 16, NULL, 'Surat masuk baru dari kantor bapperida - \"ada penting\" menunggu penerimaan.', 0, '2026-08-16 13:13:07'),
(73, 17, NULL, 'Surat masuk baru dari kantor bapperida - \"ada penting\" menunggu penerimaan.', 0, '2026-08-16 13:13:07'),
(74, 1, 7, 'Surat baru dari kantor bapperida telah diterima Bidang Umum dan siap untuk disposisi.', 0, '2026-08-16 13:58:43'),
(75, 3, 7, 'Surat baru dari kantor bapperida telah diterima Bidang Umum dan siap untuk disposisi.', 0, '2026-08-16 13:58:43'),
(76, 8, 7, 'Surat baru dari kantor bapperida telah diterima Bidang Umum dan siap untuk disposisi.', 0, '2026-08-16 13:58:43'),
(77, 4, NULL, 'Surat masuk baru dari Kantor Pendidikan - \"aad penting\" menunggu penerimaan.', 0, '2026-08-16 14:03:55'),
(78, 14, NULL, 'Surat masuk baru dari Kantor Pendidikan - \"aad penting\" menunggu penerimaan.', 0, '2026-08-16 14:03:55'),
(79, 15, NULL, 'Surat masuk baru dari Kantor Pendidikan - \"aad penting\" menunggu penerimaan.', 0, '2026-08-16 14:03:55'),
(80, 16, NULL, 'Surat masuk baru dari Kantor Pendidikan - \"aad penting\" menunggu penerimaan.', 0, '2026-08-16 14:03:55'),
(81, 17, NULL, 'Surat masuk baru dari Kantor Pendidikan - \"aad penting\" menunggu penerimaan.', 0, '2026-08-16 14:03:55'),
(82, 18, NULL, 'Surat masuk baru dari Kantor Pendidikan - \"aad penting\" menunggu penerimaan.', 0, '2026-08-16 14:03:56'),
(83, 19, NULL, 'Surat masuk baru dari Kantor Pendidikan - \"aad penting\" menunggu penerimaan.', 0, '2026-08-16 14:03:58'),
(84, 20, NULL, 'Surat masuk baru dari Kantor Pendidikan - \"aad penting\" menunggu penerimaan.', 0, '2026-08-16 14:03:59'),
(85, 21, NULL, 'Surat masuk baru dari Kantor Pendidikan - \"aad penting\" menunggu penerimaan.', 0, '2026-08-16 14:03:59'),
(86, 2, NULL, 'Surat dari Kantor Pendidikan telah diterima Bidang Umum, menunggu validasi Anda.', 0, '2026-08-16 14:04:19'),
(87, 1, 8, 'Surat baru dari Kantor Pendidikan telah divalidasi Sepri dan siap untuk disposisi.', 0, '2026-08-16 14:04:44'),
(88, 3, 8, 'Surat baru dari Kantor Pendidikan telah divalidasi Sepri dan siap untuk disposisi.', 0, '2026-08-16 14:04:44'),
(89, 8, 8, 'Surat baru dari Kantor Pendidikan telah divalidasi Sepri dan siap untuk disposisi.', 0, '2026-08-16 14:04:44'),
(90, 4, 8, 'Surat \"aad penting\" telah didisposisi, siap didistribusikan.', 0, '2026-08-16 14:08:46'),
(91, 14, 8, 'Surat \"aad penting\" telah didisposisi, siap didistribusikan.', 0, '2026-08-16 14:08:46'),
(92, 15, 8, 'Surat \"aad penting\" telah didisposisi, siap didistribusikan.', 0, '2026-08-16 14:08:46'),
(93, 16, 8, 'Surat \"aad penting\" telah didisposisi, siap didistribusikan.', 0, '2026-08-16 14:08:46'),
(94, 17, 8, 'Surat \"aad penting\" telah didisposisi, siap didistribusikan.', 0, '2026-08-16 14:08:46'),
(95, 18, 8, 'Surat \"aad penting\" telah didisposisi, siap didistribusikan.', 0, '2026-08-16 14:08:46'),
(96, 19, 8, 'Surat \"aad penting\" telah didisposisi, siap didistribusikan.', 0, '2026-08-16 14:08:46'),
(97, 20, 8, 'Surat \"aad penting\" telah didisposisi, siap didistribusikan.', 0, '2026-08-16 14:08:46'),
(98, 21, 8, 'Surat \"aad penting\" telah didisposisi, siap didistribusikan.', 0, '2026-08-16 14:08:46'),
(99, 1, 8, 'Surat \"aad penting\" telah didisposisi oleh Kepala Dinas.', 0, '2026-08-16 14:08:46'),
(100, 2, 8, 'Surat \"aad penting\" telah didisposisi oleh Kepala Dinas.', 0, '2026-08-16 14:08:46');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_pengguna`
--

CREATE TABLE `tbl_pengguna` (
  `id_pengguna` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `jabatan` varchar(100) DEFAULT NULL,
  `role` enum('admin','sepri','kadis','bidang_umum','kepala_bidang') NOT NULL DEFAULT 'kepala_bidang',
  `id_bidang` int(11) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `telp` varchar(20) DEFAULT NULL,
  `foto` varchar(100) DEFAULT 'default.png',
  `aktif` tinyint(1) DEFAULT 1,
  `terakhir_login` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `tbl_pengguna`
--

INSERT INTO `tbl_pengguna` (`id_pengguna`, `username`, `password`, `nama_lengkap`, `jabatan`, `role`, `id_bidang`, `email`, `telp`, `foto`, `aktif`, `terakhir_login`, `created_at`) VALUES
(1, 'admin', '$2y$10$VuU.S97JxlQKwt/RVhZG6OmFnqy78hcLK46zmZPZ5ftxdohNSEdlC', 'Administrator', 'Administrator Sistem', 'admin', NULL, NULL, NULL, 'default.png', 1, '2026-08-16 07:14:22', '2026-08-14 12:12:31'),
(2, 'sepri', '$2y$10$UjOa.OjahysnQo1jkRgtz.bXg06Nrz.rtaR01hYoTrgnCXjcz3l6e', 'Staf Penerima Surat', 'Staf Penerima Surat', 'sepri', 1, NULL, NULL, 'default.png', 1, '2026-08-16 07:14:39', '2026-08-14 12:12:31'),
(3, 'kadis', '$2y$10$V9wf4O5e3kChbot8T7vjtuv9VJt8DOdIz2M16CvFgGrTuOHQHQBZS', 'Kepala Dinas', 'Kepala Dinas Pendidikan', 'kadis', NULL, NULL, NULL, 'foto_3_1786776998.png', 1, '2026-08-16 07:08:02', '2026-08-14 12:12:31'),
(4, 'bidang_umum', '$2y$10$Vj1o9PWIerHA2qYKEpM8Lu/8NK7uRkX0G0XzbMmgW0btH.Nkq894q', 'Staf Bidang Umum', 'Staf Distribusi Surat', 'bidang_umum', 9, NULL, NULL, 'default.png', 1, NULL, '2026-08-14 12:12:31'),
(5, 'kabid_sd', '$2y$10$sBUXv07BRXbqwXmLHo2Rg.6IM2gPpaQyWRIo3fpVPD3mgZ8cIdgLO', 'Kepala Bidang SD', 'Kepala Bidang Pembinaan SD', 'kepala_bidang', 2, NULL, NULL, 'default.png', 1, '2026-08-16 06:47:57', '2026-08-14 12:12:31'),
(6, 'kabid_smp', '$2y$10$bb6EBnFz4S5niJP48ak.xOH.cPVfgTIIgbGhZF6ce7oGTsKbDcy8q', 'Kepala Bidang SMP', 'Kepala Bidang Pembinaan SMP', 'kepala_bidang', 3, NULL, NULL, 'default.png', 1, '2026-08-16 06:05:10', '2026-08-14 12:12:31'),
(7, 'kabid_gtk', '$2y$10$IdsIR11jfPvEup8TpIkaJO8aE9isHGiscW47vuUAowoneOJrbKXYu', 'Kepala Bidang GTK', 'Kepala Bidang GTK', 'kepala_bidang', 6, NULL, NULL, 'default.png', 1, NULL, '2026-08-14 12:12:31'),
(8, 'kiel', 'b00467603971b5f807ab4e1e9f5c661e', 'jeskiel', 'Kepala Dinas', 'kadis', NULL, 'kiell22@gmail.com', '081231213123', 'default.png', 1, '2026-08-16 06:50:32', '2026-08-14 15:19:43'),
(9, 'kabid_sma', '$2y$10$FhMBCTyaMoo.vXNbdVIy8uqx5zAozGHnCzqUw.ikpOKsjFPCysGyG', 'Kepala Bidang SMA', 'Kepala Bidang Pembinaan SMA', 'kepala_bidang', 4, NULL, NULL, 'default.png', 1, '2026-08-15 10:05:39', '2026-08-14 16:20:11'),
(10, 'kabid_smk', '$2y$10$KmKrS1.cY.j/Qaj6zItAhuwFBSA/71fIMk/4rCe6nMp2yHP5ea3Ta', 'Kepala Bidang SMK', 'Kepala Bidang Pembinaan SMK', 'kepala_bidang', 5, NULL, NULL, 'default.png', 1, NULL, '2026-08-14 16:20:11'),
(11, 'kabid_paud', '$2y$10$zb0XogxRUE.XL7WKUhDtluceL0BE2o6oDD/GWyoEUz3FRVuU0UrHS', 'Kepala Bidang PAUD', 'Kepala Bidang PAUD & PNF', 'kepala_bidang', 7, NULL, NULL, 'default.png', 1, NULL, '2026-08-14 16:20:11'),
(12, 'kabid_sarpras', '$2y$10$.g/lYAN6FGNcZn6O2vB.Y.fgh4tSVgcHYTzFtdNxEmCp41QCnztaO', 'Kepala Bidang Sarpras', 'Kepala Bidang Sarana Prasarana', 'kepala_bidang', 8, NULL, NULL, 'default.png', 1, NULL, '2026-08-14 16:20:11'),
(13, 'kabid_sekret', '$2y$10$b1lJAZlVIUTS0dKz4eCfYOWJqPBNaRfvvtDRwGvkwKfVFU2XCgwTm', 'Kepala Sekretariat', 'Kepala Sekretariat', 'kepala_bidang', 1, NULL, NULL, 'default.png', 1, NULL, '2026-08-14 16:20:11'),
(14, 'kiel22', '$2y$10$gs5gve37IzZ2rLEqXfYV8uNbBOzJ3oNfPTktUfdlJoymPb2CZ6K5a', 'kiel', 'Tim IT', 'bidang_umum', 9, 'jeskielsiahaan@gmail.com', '081247052935', 'foto_14_1786694550.png', 1, '2026-08-16 06:50:43', '2026-08-14 17:02:10'),
(15, 'anton123', '$2y$10$TDrSskItHqNRbX9J9ay7UedEjVsxU9.KlnU/StKm2T6OCb9qDLlIW', 'Antonius', 'PNS', 'bidang_umum', 9, 'anton12@gmail.com', '081231231231', 'default.png', 1, '2026-08-16 06:38:33', '2026-08-15 15:59:59'),
(16, 'valen123', '$2y$10$PPOBy6.dEFJRTNd/A7AcX.ksV0klmbIUKZONbb7AVWJQy3p6sS44W', 'valen', 'Bidang Biasa', 'bidang_umum', 9, 'valen@gmail.com', '081231231232', 'foto_16_1786781750.jpeg', 1, '2026-08-16 07:04:51', '2026-08-15 16:05:50'),
(17, 'adws', '$2y$10$QoN/rBj99dmY0GOTSy4QLukrqHMVzGo9PHv0SFha17O8WuxwaMmIu', 'asdaw', 'awdwa', 'bidang_umum', 9, 'adada@gmaul.com', '1231231231', 'default.png', 1, NULL, '2026-08-15 16:07:27'),
(18, 'kiellw', '$2y$10$wI6nqLKkcVU.MVS3omqxAugTe692XDosLqQlzSkyaelOop56edwha', 'jeskiel siahaan', 'biasa', 'bidang_umum', 9, 'jeskielsiahaan@gmail.com', '081247052935', 'default.png', 1, '2026-08-16 06:43:54', '2026-08-16 13:43:47'),
(19, 'kielq', '$2y$10$7eapKhUOPY7VYkDiwn3ka.rmWgJhFPffYaeVxllukEQkQkesVtJ7S', 'sasadaw', 'kepala', 'bidang_umum', 9, 'jeskielsiahaan@gmail.com', '081247052935', 'default.png', 1, '2026-08-16 06:52:41', '2026-08-16 13:52:35'),
(20, 'kielas', '$2y$10$JB297fQl/OaZx28isfEH/.3xbIIii75TKuy36/zAXvIBI0lRJy8fO', 'jeskiel siahaan', 'biasa', 'bidang_umum', 9, 'jeskielsiahaan@gmail.com', '081247052935', 'default.png', 1, NULL, '2026-08-16 13:53:38'),
(21, 'akwe', '$2y$10$FBXdfiT6p1a7SvEYBz1DJOBUIH/nZ91zk6pY9I546Nq/hFUvJ0isS', 'asaw', 'biasa', 'bidang_umum', 3, 'jeskielsiahaan@gmail.com', '081247052935', 'default.png', 1, '2026-08-16 06:55:28', '2026-08-16 13:55:19');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_proses_surat`
--

CREATE TABLE `tbl_proses_surat` (
  `id_proses` int(11) NOT NULL,
  `id_surat` int(11) NOT NULL,
  `id_bidang` int(11) NOT NULL,
  `id_pengguna` int(11) NOT NULL,
  `keterangan` text NOT NULL,
  `tgl_proses` datetime DEFAULT current_timestamp(),
  `status` enum('diproses','selesai') DEFAULT 'diproses'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `tbl_proses_surat`
--

INSERT INTO `tbl_proses_surat` (`id_proses`, `id_surat`, `id_bidang`, `id_pengguna`, `keterangan`, `tgl_proses`, `status`) VALUES
(1, 4, 2, 5, 'oke proses', '2026-08-15 10:03:20', 'diproses'),
(2, 4, 2, 5, 'selesai', '2026-08-15 10:03:34', 'diproses'),
(3, 4, 4, 9, 'oke kami proses', '2026-08-15 10:06:07', 'diproses'),
(4, 5, 4, 9, 'selesai ya bos', '2026-08-15 10:07:02', 'selesai'),
(5, 3, 4, 9, 'oke selesai', '2026-08-15 10:07:33', 'selesai'),
(6, 6, 2, 5, 'oke selesai\r\n', '2026-08-16 02:42:08', 'selesai');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_riwayat`
--

CREATE TABLE `tbl_riwayat` (
  `id_riwayat` int(11) NOT NULL,
  `id_surat` int(11) NOT NULL,
  `id_pengguna` int(11) NOT NULL,
  `aksi` varchar(100) NOT NULL,
  `keterangan` text DEFAULT NULL,
  `tgl_aksi` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `tbl_riwayat`
--

INSERT INTO `tbl_riwayat` (`id_riwayat`, `id_surat`, `id_pengguna`, `aksi`, `keterangan`, `tgl_aksi`) VALUES
(1, 1, 1, 'Surat dicatat', 'No. Agenda: AGD/2026/0001', '2026-08-14 09:36:04'),
(2, 1, 1, 'Surat diperbarui', '', '2026-08-14 09:36:34'),
(3, 1, 1, 'Surat diperbarui', '', '2026-08-14 09:49:21'),
(4, 2, 1, 'Surat dicatat', 'No. Agenda: AGD/2026/0002', '2026-08-14 09:59:07'),
(5, 3, 1, 'Surat dicatat', 'No. Agenda: AGD/2025/TEST1', '2026-08-14 10:30:32'),
(6, 3, 3, 'Surat didisposisi', 'Didisposisi ke semua bidang', '2026-08-14 10:30:32'),
(7, 3, 4, 'Surat dikirim/distribusi', 'Dikirim ke semua bidang', '2026-08-14 10:30:32'),
(8, 4, 1, 'Surat dicatat', 'No. Agenda: AGD/2025/TEST2', '2026-08-14 10:30:32'),
(9, 4, 3, 'Surat didisposisi', 'Didisposisi ke semua bidang', '2026-08-14 10:30:32'),
(10, 4, 4, 'Surat dikirim/distribusi', 'Dikirim ke semua bidang', '2026-08-14 10:30:32'),
(11, 5, 1, 'Surat dicatat', 'No. Agenda: AGD/2025/TEST3', '2026-08-14 10:30:32'),
(12, 5, 3, 'Surat didisposisi', 'Didisposisi ke semua bidang', '2026-08-14 10:30:32'),
(13, 5, 4, 'Surat dikirim/distribusi', 'Dikirim ke semua bidang', '2026-08-14 10:30:32'),
(14, 3, 1, 'Surat diperbarui', '', '2026-08-14 10:33:20'),
(15, 3, 5, 'Surat diterima bidang', 'Diterima oleh: Kepala Bidang SD (Bidang Pembinaan SD)', '2026-08-15 09:45:57'),
(16, 3, 6, 'Surat diterima bidang', 'Diterima oleh: Kepala Bidang SMP (Bidang Pembinaan SMP)', '2026-08-15 09:50:05'),
(17, 3, 1, 'Surat diterima bidang', 'Diterima oleh: Administrator (Bidang GTK)', '2026-08-15 09:52:14'),
(18, 3, 1, 'Surat diterima bidang', 'Diterima oleh: Administrator (Bidang Pembinaan SMA)', '2026-08-15 09:52:18'),
(19, 3, 1, 'Surat diterima bidang', 'Diterima oleh: Administrator (Bidang Pembinaan SMK)', '2026-08-15 09:52:20'),
(20, 3, 1, 'Surat diterima bidang', 'Diterima oleh: Administrator (Bidang Sarana Prasarana)', '2026-08-15 09:52:24'),
(21, 3, 1, 'Surat diterima bidang', 'Diterima oleh: Administrator (Bidang PAUD & PNF)', '2026-08-15 09:52:27'),
(22, 3, 1, 'Surat diterima bidang', 'Diterima oleh: Administrator (Sekretariat)', '2026-08-15 09:52:29'),
(23, 4, 6, 'Surat diterima bidang', 'Diterima oleh: Kepala Bidang SMP (Bidang Pembinaan SMP)', '2026-08-15 09:54:49'),
(24, 1, 3, 'Surat didisposisi', 'Didisposisi ke: Sekretariat, Bidang Pembinaan SD', '2026-08-15 10:02:50'),
(25, 4, 5, 'Surat diterima bidang', 'Diterima oleh: Kepala Bidang SD (Bidang Pembinaan SD)', '2026-08-15 10:03:09'),
(26, 4, 5, 'Surat sedang diproses', 'oke proses', '2026-08-15 10:03:20'),
(27, 4, 5, 'Surat sedang diproses', 'selesai', '2026-08-15 10:03:34'),
(28, 2, 3, 'Surat didisposisi', 'Didisposisi ke: Bidang Pembinaan SMA, Bidang Komunikasi', '2026-08-15 10:05:14'),
(29, 4, 9, 'Surat diterima bidang', 'Diterima oleh: Kepala Bidang SMA (Bidang Pembinaan SMA)', '2026-08-15 10:05:56'),
(30, 4, 9, 'Surat sedang diproses', 'oke kami proses', '2026-08-15 10:06:07'),
(31, 5, 9, 'Surat diterima bidang', 'Diterima oleh: Kepala Bidang SMA (Bidang Pembinaan SMA)', '2026-08-15 10:06:52'),
(32, 5, 9, 'Surat selesai diproses', 'selesai ya bos', '2026-08-15 10:07:02'),
(33, 3, 9, 'Surat selesai diproses', 'oke selesai', '2026-08-15 10:07:33'),
(34, 2, 16, 'Surat dikirim/distribusi', 'Dikirim ke: Sekretariat', '2026-08-15 11:28:19'),
(35, 5, 5, 'Surat diterima bidang', 'Diterima oleh: Kepala Bidang SD (Bidang Pembinaan SD)', '2026-08-15 12:09:19'),
(36, 6, 2, 'Surat dicatat', 'Dari surat masuk luar: SML-1E63E63C', '2026-08-16 02:37:58'),
(37, 6, 3, 'Surat didisposisi', 'Didisposisi ke: Bidang Pembinaan SD', '2026-08-16 02:39:00'),
(38, 6, 14, 'Surat dikirim/distribusi', 'Dikirim ke: Bidang Pembinaan SD', '2026-08-16 02:41:00'),
(39, 1, 14, 'Surat dikirim/distribusi', 'Dikirim ke: Sekretariat, Bidang Pembinaan SD', '2026-08-16 02:41:31'),
(40, 6, 5, 'Surat diterima bidang', 'Diterima oleh: Kepala Bidang SD (Bidang Pembinaan SD)', '2026-08-16 02:41:57'),
(41, 6, 5, 'Surat selesai diproses', 'oke selesai\r\n', '2026-08-16 02:42:08'),
(42, 7, 16, 'Surat dicatat', 'Dari surat masuk luar: SML-A9BD2D35', '2026-08-16 06:58:43'),
(43, 8, 2, 'Surat dicatat', 'Dari surat masuk luar: SML-62D01A11', '2026-08-16 07:04:44'),
(44, 8, 3, 'Surat didisposisi', 'Didisposisi ke: Sekretariat', '2026-08-16 07:08:46'),
(45, 7, 1, 'Surat diperbarui', '', '2026-08-16 07:11:44');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_surat`
--

CREATE TABLE `tbl_surat` (
  `id_surat` int(11) NOT NULL,
  `no_agenda` varchar(30) NOT NULL,
  `no_surat` varchar(100) NOT NULL,
  `tgl_surat` date NOT NULL,
  `tgl_terima` date NOT NULL,
  `asal_surat` varchar(150) NOT NULL,
  `perihal` text NOT NULL,
  `sifat` enum('biasa','penting','rahasia','segera') DEFAULT 'biasa',
  `jenis_surat` enum('masuk','keluar') DEFAULT 'masuk',
  `file_surat` varchar(200) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `status` enum('baru','disposisi','distribusi','diterima','diproses','selesai') DEFAULT 'baru',
  `id_pengguna_input` int(11) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `tbl_surat`
--

INSERT INTO `tbl_surat` (`id_surat`, `no_agenda`, `no_surat`, `tgl_surat`, `tgl_terima`, `asal_surat`, `perihal`, `sifat`, `jenis_surat`, `file_surat`, `keterangan`, `status`, `id_pengguna_input`, `created_at`, `updated_at`) VALUES
(1, 'AGD/2026/0001', '121/312', '2026-08-14', '2026-08-14', 'Walikota', 'asdawda', 'biasa', 'masuk', 'surat_1786692964.pdf', 'as', 'distribusi', 1, '2026-08-14 16:36:04', '2026-08-16 02:41:31'),
(2, 'AGD/2026/0002', '222/121/121', '2026-08-14', '2026-08-14', 'Walikota', 'DAU', 'penting', 'masuk', 'surat_1786694347.pdf', 'as', 'distribusi', 1, '2026-08-14 16:59:07', '2026-08-15 11:28:19'),
(3, 'AGD/2025/TEST1', '001/TEST/VIII/2025', '2026-08-14', '2026-08-14', 'Kementerian Pendidikan', 'Surat Test Distribusi 1 - Undangan Rapat Koordinasi', 'biasa', 'masuk', NULL, '', 'selesai', 1, '2026-08-14 10:30:32', '2026-08-15 10:07:33'),
(4, 'AGD/2025/TEST2', '002/TEST/VIII/2025', '2026-08-14', '2026-08-14', 'Dinas Keuangan Provinsi', 'Surat Test Distribusi 2 - Pemberitahuan Dana BOS', 'biasa', 'masuk', NULL, NULL, 'diproses', 1, '2026-08-14 10:30:32', '2026-08-15 10:06:07'),
(5, 'AGD/2025/TEST3', '003/TEST/VIII/2025', '2026-08-14', '2026-08-14', 'Badan Pengawas Daerah', 'Surat Test Distribusi 3 - Laporan Kegiatan Semester', 'biasa', 'masuk', NULL, NULL, 'selesai', 1, '2026-08-14 10:30:32', '2026-08-15 10:07:02'),
(6, 'AGD/2026/0003', '121/312', '2026-08-16', '2026-08-16', 'Kantor Gubernur', 'ada sesuatu harus dikerjakan', 'segera', 'masuk', NULL, 'Surat masuk dari luar. Pengirim: jeskiel siahaan (Kantor Gubernur). ', 'selesai', 2, '2026-08-16 09:37:58', '2026-08-16 02:42:08'),
(8, 'AGD/2026/0005', '213/121', '2026-08-16', '2026-08-16', 'Kantor Pendidikan', 'aad penting', 'segera', 'masuk', NULL, 'Surat masuk dari luar. Pengirim: Valen (Kantor Pendidikan). ', 'disposisi', 2, '2026-08-16 14:04:44', '2026-08-16 07:08:46');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_surat_masuk_luar`
--

CREATE TABLE `tbl_surat_masuk_luar` (
  `id_sml` int(11) NOT NULL,
  `kode_tiket` varchar(20) NOT NULL,
  `nama_pengirim` varchar(150) NOT NULL,
  `instansi_pengirim` varchar(200) NOT NULL,
  `nip_pengirim` varchar(30) DEFAULT NULL,
  `no_hp` varchar(20) DEFAULT NULL,
  `email_pengirim` varchar(100) DEFAULT NULL,
  `no_surat` varchar(100) NOT NULL,
  `tgl_surat` date NOT NULL,
  `perihal` text NOT NULL,
  `sifat` enum('biasa','penting','rahasia','segera') DEFAULT 'biasa',
  `file_surat` varchar(200) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `status` enum('menunggu','diterima_bu','validasi_sepri','diteruskan_kadis','ditolak') DEFAULT 'menunggu',
  `catatan_bu` text DEFAULT NULL,
  `catatan_sepri` text DEFAULT NULL,
  `id_pengguna_bu` int(11) DEFAULT NULL,
  `id_pengguna_sepri` int(11) DEFAULT NULL,
  `tgl_terima_bu` datetime DEFAULT NULL,
  `tgl_validasi_sepri` datetime DEFAULT NULL,
  `id_surat_internal` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `tbl_surat_masuk_luar`
--

INSERT INTO `tbl_surat_masuk_luar` (`id_sml`, `kode_tiket`, `nama_pengirim`, `instansi_pengirim`, `nip_pengirim`, `no_hp`, `email_pengirim`, `no_surat`, `tgl_surat`, `perihal`, `sifat`, `file_surat`, `keterangan`, `status`, `catatan_bu`, `catatan_sepri`, `id_pengguna_bu`, `id_pengguna_sepri`, `tgl_terima_bu`, `tgl_validasi_sepri`, `id_surat_internal`, `created_at`, `updated_at`) VALUES
(1, 'SML-1E63E63C', 'jeskiel siahaan', 'Kantor Gubernur', '3 C', '081247052935', 'jeskielsiahaan@gmail.com', '121/312', '2026-08-16', 'ada sesuatu harus dikerjakan', 'segera', 'sml_1786840597.pdf', '', 'diteruskan_kadis', '', '', 16, 2, '2026-08-16 02:37:19', '2026-08-16 02:37:58', 6, '2026-08-16 09:36:37', '2026-08-16 09:37:58'),
(2, 'SML-A9BD2D35', 'Kiel', 'kantor bapperida', '12311231231', '081247052935', 'bapperida@gmail.com', '123/123', '2026-08-16', 'ada penting', 'biasa', 'sml_1786853587.pdf', '', 'diteruskan_kadis', '', NULL, 16, NULL, '2026-08-16 06:58:43', NULL, 7, '2026-08-16 13:13:07', '2026-08-16 13:58:43'),
(3, 'SML-62D01A11', 'Valen', 'Kantor Pendidikan', '912312312', '08123123123', 'valen@gmail.com', '213/121', '2026-08-16', 'aad penting', 'segera', 'sml_1786856634.pdf', '', 'diteruskan_kadis', '', 'mohon diliat pak', 16, 2, '2026-08-16 07:04:19', '2026-08-16 07:04:44', 8, '2026-08-16 14:03:54', '2026-08-16 14:04:44');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `ci_sessions`
--
ALTER TABLE `ci_sessions`
  ADD KEY `ci_sessions_timestamp` (`timestamp`);

--
-- Indeks untuk tabel `tbl_bidang`
--
ALTER TABLE `tbl_bidang`
  ADD PRIMARY KEY (`id_bidang`);

--
-- Indeks untuk tabel `tbl_disposisi`
--
ALTER TABLE `tbl_disposisi`
  ADD PRIMARY KEY (`id_disposisi`),
  ADD KEY `id_surat` (`id_surat`);

--
-- Indeks untuk tabel `tbl_disposisi_bidang`
--
ALTER TABLE `tbl_disposisi_bidang`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_distribusi`
--
ALTER TABLE `tbl_distribusi`
  ADD PRIMARY KEY (`id_distribusi`);

--
-- Indeks untuk tabel `tbl_notifikasi`
--
ALTER TABLE `tbl_notifikasi`
  ADD PRIMARY KEY (`id_notif`);

--
-- Indeks untuk tabel `tbl_pengguna`
--
ALTER TABLE `tbl_pengguna`
  ADD PRIMARY KEY (`id_pengguna`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indeks untuk tabel `tbl_proses_surat`
--
ALTER TABLE `tbl_proses_surat`
  ADD PRIMARY KEY (`id_proses`);

--
-- Indeks untuk tabel `tbl_riwayat`
--
ALTER TABLE `tbl_riwayat`
  ADD PRIMARY KEY (`id_riwayat`);

--
-- Indeks untuk tabel `tbl_surat`
--
ALTER TABLE `tbl_surat`
  ADD PRIMARY KEY (`id_surat`);

--
-- Indeks untuk tabel `tbl_surat_masuk_luar`
--
ALTER TABLE `tbl_surat_masuk_luar`
  ADD PRIMARY KEY (`id_sml`),
  ADD UNIQUE KEY `kode_tiket` (`kode_tiket`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tbl_bidang`
--
ALTER TABLE `tbl_bidang`
  MODIFY `id_bidang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `tbl_disposisi`
--
ALTER TABLE `tbl_disposisi`
  MODIFY `id_disposisi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `tbl_disposisi_bidang`
--
ALTER TABLE `tbl_disposisi_bidang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT untuk tabel `tbl_distribusi`
--
ALTER TABLE `tbl_distribusi`
  MODIFY `id_distribusi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT untuk tabel `tbl_notifikasi`
--
ALTER TABLE `tbl_notifikasi`
  MODIFY `id_notif` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT untuk tabel `tbl_pengguna`
--
ALTER TABLE `tbl_pengguna`
  MODIFY `id_pengguna` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT untuk tabel `tbl_proses_surat`
--
ALTER TABLE `tbl_proses_surat`
  MODIFY `id_proses` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `tbl_riwayat`
--
ALTER TABLE `tbl_riwayat`
  MODIFY `id_riwayat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT untuk tabel `tbl_surat`
--
ALTER TABLE `tbl_surat`
  MODIFY `id_surat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `tbl_surat_masuk_luar`
--
ALTER TABLE `tbl_surat_masuk_luar`
  MODIFY `id_sml` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
