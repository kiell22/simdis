-- ============================================================
-- DATABASE: Sistem Monitoring Distribusi Surat Internal
-- Dinas Pendidikan Provinsi Papua
-- ============================================================

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+07:00";

-- --------------------------------------------------------
-- Tabel: tbl_bidang
-- --------------------------------------------------------
CREATE TABLE `tbl_bidang` (
  `id_bidang` int(11) NOT NULL AUTO_INCREMENT,
  `kode_bidang` varchar(20) NOT NULL,
  `nama_bidang` varchar(100) NOT NULL,
  `keterangan` text,
  `aktif` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`id_bidang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `tbl_bidang` (`kode_bidang`, `nama_bidang`) VALUES
('SEKRETARIAT', 'Sekretariat'),
('BIDANG-SD', 'Bidang Pembinaan SD'),
('BIDANG-SMP', 'Bidang Pembinaan SMP'),
('BIDANG-SMA', 'Bidang Pembinaan SMA'),
('BIDANG-SMK', 'Bidang Pembinaan SMK'),
('BIDANG-GTK', 'Bidang GTK'),
('BIDANG-PAUD', 'Bidang PAUD & PNF'),
('BIDANG-SARPRAS', 'Bidang Sarana Prasarana'),
('BIDANG-UMUM', 'Bidang Umum');

-- --------------------------------------------------------
-- Tabel: tbl_pengguna
-- --------------------------------------------------------
CREATE TABLE `tbl_pengguna` (
  `id_pengguna` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `jabatan` varchar(100) DEFAULT NULL,
  `role` enum('admin','sepri','kadis','bidang_umum','kepala_bidang') NOT NULL DEFAULT 'kepala_bidang',
  `id_bidang` int(11) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `telp` varchar(20) DEFAULT NULL,
  `foto` varchar(100) DEFAULT 'default.png',
  `aktif` tinyint(1) DEFAULT 1,
  `terakhir_login` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_pengguna`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `tbl_pengguna` (`username`, `password`, `nama_lengkap`, `jabatan`, `role`, `id_bidang`) VALUES
('admin', MD5('admin123'), 'Administrator', 'Administrator Sistem', 'admin', NULL),
('sepri', MD5('sepri123'), 'Sepri', 'Staf Penerima Surat', 'sepri', 1),
('kadis', MD5('kadis123'), 'Kepala Dinas', 'Kepala Dinas Pendidikan', 'kadis', NULL),
('bidang_umum', MD5('umum123'), 'Staf Bidang Umum', 'Staf Distribusi Surat', 'bidang_umum', 9),
('kabid_sd', MD5('kabid123'), 'Kepala Bidang SD', 'Kepala Bidang Pembinaan SD', 'kepala_bidang', 2),
('kabid_smp', MD5('kabid123'), 'Kepala Bidang SMP', 'Kepala Bidang Pembinaan SMP', 'kepala_bidang', 3),
('kabid_gtk', MD5('kabid123'), 'Kepala Bidang GTK', 'Kepala Bidang GTK', 'kepala_bidang', 6);

-- --------------------------------------------------------
-- Tabel: tbl_surat
-- --------------------------------------------------------
CREATE TABLE `tbl_surat` (
  `id_surat` int(11) NOT NULL AUTO_INCREMENT,
  `no_agenda` varchar(30) NOT NULL,
  `no_surat` varchar(100) NOT NULL,
  `tgl_surat` date NOT NULL,
  `tgl_terima` date NOT NULL,
  `asal_surat` varchar(150) NOT NULL,
  `perihal` text NOT NULL,
  `sifat` enum('biasa','penting','rahasia','segera') DEFAULT 'biasa',
  `jenis_surat` enum('masuk','keluar') DEFAULT 'masuk',
  `file_surat` varchar(200) DEFAULT NULL,
  `keterangan` text,
  `status` enum('baru','disposisi','distribusi','diterima','diproses','selesai') DEFAULT 'baru',
  `id_pengguna_input` int(11) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_surat`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------
-- Tabel: tbl_disposisi
-- --------------------------------------------------------
CREATE TABLE `tbl_disposisi` (
  `id_disposisi` int(11) NOT NULL AUTO_INCREMENT,
  `id_surat` int(11) NOT NULL,
  `id_pengguna_disposisi` int(11) NOT NULL,
  `isi_disposisi` text NOT NULL,
  `instruksi` text,
  `tgl_disposisi` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_disposisi`),
  KEY `id_surat` (`id_surat`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------
-- Tabel: tbl_disposisi_bidang (surat bisa ke banyak bidang)
-- --------------------------------------------------------
CREATE TABLE `tbl_disposisi_bidang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_disposisi` int(11) NOT NULL,
  `id_bidang` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_disposisi` (`id_disposisi`),
  KEY `id_bidang` (`id_bidang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------
-- Tabel: tbl_distribusi
-- --------------------------------------------------------
CREATE TABLE `tbl_distribusi` (
  `id_distribusi` int(11) NOT NULL AUTO_INCREMENT,
  `id_surat` int(11) NOT NULL,
  `id_bidang` int(11) NOT NULL,
  `id_pengguna_kirim` int(11) NOT NULL,
  `tgl_kirim` datetime DEFAULT CURRENT_TIMESTAMP,
  `tgl_terima` datetime DEFAULT NULL,
  `id_pengguna_terima` int(11) DEFAULT NULL,
  `catatan_kirim` text,
  `catatan_terima` text,
  `status` enum('dikirim','diterima') DEFAULT 'dikirim',
  PRIMARY KEY (`id_distribusi`),
  KEY `id_surat` (`id_surat`),
  KEY `id_bidang` (`id_bidang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------
-- Tabel: tbl_proses_surat
-- --------------------------------------------------------
CREATE TABLE `tbl_proses_surat` (
  `id_proses` int(11) NOT NULL AUTO_INCREMENT,
  `id_surat` int(11) NOT NULL,
  `id_bidang` int(11) NOT NULL,
  `id_pengguna` int(11) NOT NULL,
  `keterangan` text NOT NULL,
  `tgl_proses` datetime DEFAULT CURRENT_TIMESTAMP,
  `status` enum('diproses','selesai') DEFAULT 'diproses',
  PRIMARY KEY (`id_proses`),
  KEY `id_surat` (`id_surat`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------
-- Tabel: tbl_riwayat (log semua aktivitas surat)
-- --------------------------------------------------------
CREATE TABLE `tbl_riwayat` (
  `id_riwayat` int(11) NOT NULL AUTO_INCREMENT,
  `id_surat` int(11) NOT NULL,
  `id_pengguna` int(11) NOT NULL,
  `aksi` varchar(100) NOT NULL,
  `keterangan` text,
  `tgl_aksi` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_riwayat`),
  KEY `id_surat` (`id_surat`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------
-- Tabel: tbl_notifikasi
-- --------------------------------------------------------
CREATE TABLE `tbl_notifikasi` (
  `id_notif` int(11) NOT NULL AUTO_INCREMENT,
  `id_pengguna` int(11) NOT NULL,
  `id_surat` int(11) DEFAULT NULL,
  `pesan` text NOT NULL,
  `dibaca` tinyint(1) DEFAULT 0,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_notif`),
  KEY `id_pengguna` (`id_pengguna`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

COMMIT;
