-- ============================================================
-- Tabel: tbl_surat_masuk_luar
-- Untuk menampung surat masuk dari kantor lain (tanpa login)
-- Alur: Kantor Lain → Bidang Umum → Sepri → Kepala Dinas
-- ============================================================

CREATE TABLE IF NOT EXISTS `tbl_surat_masuk_luar` (
  `id_sml`              int(11) NOT NULL AUTO_INCREMENT,
  `kode_tiket`          varchar(20) NOT NULL,

  -- Data pengirim
  `nama_pengirim`       varchar(100) NOT NULL,
  `instansi_pengirim`   varchar(150) NOT NULL,
  `nip_pengirim`        varchar(30) DEFAULT NULL,
  `no_hp`               varchar(20) DEFAULT NULL,
  `email_pengirim`      varchar(100) DEFAULT NULL,

  -- Data surat
  `no_surat`            varchar(100) NOT NULL,
  `tgl_surat`           date NOT NULL,
  `perihal`             text NOT NULL,
  `sifat`               enum('biasa','penting','segera','rahasia') DEFAULT 'biasa',
  `file_surat`          varchar(200) DEFAULT NULL,
  `keterangan`          text DEFAULT NULL,

  -- Alur status
  -- menunggu       → baru masuk, belum diproses Bidang Umum
  -- diterima_bu    → diterima Bidang Umum, menunggu validasi Sepri
  -- diteruskan_kadis → divalidasi Sepri, surat internal dibuat, siap disposisi Kadis
  -- ditolak        → ditolak (bisa oleh BU atau Sepri)
  `status`              enum('menunggu','diterima_bu','diteruskan_kadis','ditolak') DEFAULT 'menunggu',

  -- Proses Bidang Umum
  `id_pengguna_bu`      int(11) DEFAULT NULL,
  `tgl_terima_bu`       datetime DEFAULT NULL,
  `catatan_bu`          text DEFAULT NULL,

  -- Proses Sepri
  `id_pengguna_sepri`   int(11) DEFAULT NULL,
  `tgl_validasi_sepri`  datetime DEFAULT NULL,
  `catatan_sepri`       text DEFAULT NULL,

  -- Link ke surat internal (dibuat saat Sepri validasi)
  `id_surat_internal`   int(11) DEFAULT NULL,

  `created_at`          datetime DEFAULT CURRENT_TIMESTAMP,

  PRIMARY KEY (`id_sml`),
  UNIQUE KEY `kode_tiket` (`kode_tiket`),
  KEY `status` (`status`),
  KEY `id_pengguna_bu` (`id_pengguna_bu`),
  KEY `id_pengguna_sepri` (`id_pengguna_sepri`),
  KEY `id_surat_internal` (`id_surat_internal`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
