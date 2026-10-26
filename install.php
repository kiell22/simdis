<?php
// Proteksi: hanya bisa diakses dari localhost
if (!in_array($_SERVER['REMOTE_ADDR'] ?? '', ['127.0.0.1', '::1'])) {
    die('Akses ditolak.');
}

$host = 'localhost';
$user = 'root';
$pass = '';
$db   = 'disdik_papua';

$steps = [];

// 1. Koneksi MySQL
$conn = mysqli_connect($host, $user, $pass);
if (!$conn) {
    die('<div style="font-family:sans-serif;padding:30px;color:red"><h3>Koneksi MySQL gagal!</h3><p>'.mysqli_connect_error().'</p><p>Pastikan XAMPP MySQL sudah berjalan.</p></div>');
}
$steps[] = ['ok', 'Koneksi MySQL berhasil'];

// 2. Buat database
mysqli_query($conn, "CREATE DATABASE IF NOT EXISTS `$db` CHARACTER SET utf8 COLLATE utf8_general_ci");
mysqli_select_db($conn, $db);
$steps[] = ['ok', "Database <code>$db</code> siap"];

// 3. Buat semua tabel
$tables = [
'tbl_bidang' => "CREATE TABLE IF NOT EXISTS `tbl_bidang` (
  `id_bidang` int(11) NOT NULL AUTO_INCREMENT,
  `kode_bidang` varchar(20) NOT NULL,
  `nama_bidang` varchar(100) NOT NULL,
  `keterangan` text,
  `aktif` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`id_bidang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8",

'tbl_pengguna' => "CREATE TABLE IF NOT EXISTS `tbl_pengguna` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8",

'tbl_surat' => "CREATE TABLE IF NOT EXISTS `tbl_surat` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8",

'tbl_disposisi' => "CREATE TABLE IF NOT EXISTS `tbl_disposisi` (
  `id_disposisi` int(11) NOT NULL AUTO_INCREMENT,
  `id_surat` int(11) NOT NULL,
  `id_pengguna_disposisi` int(11) NOT NULL,
  `isi_disposisi` text NOT NULL,
  `instruksi` text,
  `tgl_disposisi` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_disposisi`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8",

'tbl_disposisi_bidang' => "CREATE TABLE IF NOT EXISTS `tbl_disposisi_bidang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_disposisi` int(11) NOT NULL,
  `id_bidang` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8",

'tbl_distribusi' => "CREATE TABLE IF NOT EXISTS `tbl_distribusi` (
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
  PRIMARY KEY (`id_distribusi`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8",

'tbl_proses_surat' => "CREATE TABLE IF NOT EXISTS `tbl_proses_surat` (
  `id_proses` int(11) NOT NULL AUTO_INCREMENT,
  `id_surat` int(11) NOT NULL,
  `id_bidang` int(11) NOT NULL,
  `id_pengguna` int(11) NOT NULL,
  `keterangan` text NOT NULL,
  `tgl_proses` datetime DEFAULT CURRENT_TIMESTAMP,
  `status` enum('diproses','selesai') DEFAULT 'diproses',
  PRIMARY KEY (`id_proses`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8",

'tbl_riwayat' => "CREATE TABLE IF NOT EXISTS `tbl_riwayat` (
  `id_riwayat` int(11) NOT NULL AUTO_INCREMENT,
  `id_surat` int(11) NOT NULL,
  `id_pengguna` int(11) NOT NULL,
  `aksi` varchar(100) NOT NULL,
  `keterangan` text,
  `tgl_aksi` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_riwayat`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8",

'tbl_notifikasi' => "CREATE TABLE IF NOT EXISTS `tbl_notifikasi` (
  `id_notif` int(11) NOT NULL AUTO_INCREMENT,
  `id_pengguna` int(11) NOT NULL,
  `id_surat` int(11) DEFAULT NULL,
  `pesan` text NOT NULL,
  `dibaca` tinyint(1) DEFAULT 0,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_notif`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8",
];

foreach ($tables as $name => $sql) {
    if (mysqli_query($conn, $sql)) {
        $steps[] = ['ok', "Tabel <code>$name</code> siap"];
    } else {
        $steps[] = ['err', "Tabel <code>$name</code> gagal: " . mysqli_error($conn)];
    }
}

// 4. Data awal bidang
$cek_bidang = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM tbl_bidang"));
if ($cek_bidang[0] == 0) {
    $sql_bidang = "INSERT INTO `tbl_bidang` (`kode_bidang`, `nama_bidang`) VALUES
    ('SEKRETARIAT','Sekretariat'),('BIDANG-SD','Bidang Pembinaan SD'),
    ('BIDANG-SMP','Bidang Pembinaan SMP'),('BIDANG-SMA','Bidang Pembinaan SMA'),
    ('BIDANG-SMK','Bidang Pembinaan SMK'),('BIDANG-GTK','Bidang GTK'),
    ('BIDANG-PAUD','Bidang PAUD & PNF'),('BIDANG-SARPRAS','Bidang Sarana Prasarana'),
    ('BIDANG-UMUM','Bidang Umum')";
    mysqli_query($conn, $sql_bidang);
    $steps[] = ['ok', 'Data bidang berhasil diisi'];
} else {
    $steps[] = ['info', 'Data bidang sudah ada, dilewati'];
}

// 5. Data awal pengguna
$cek_user = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM tbl_pengguna"));
if ($cek_user[0] == 0) {
    $sql_user = "INSERT INTO `tbl_pengguna` (`username`,`password`,`nama_lengkap`,`jabatan`,`role`,`id_bidang`) VALUES
    ('admin',MD5('admin123'),'Administrator','Administrator Sistem','admin',NULL),
    ('sepri',MD5('sepri123'),'Sepri','Staf Penerima Surat','sepri',1),
    ('kadis',MD5('kadis123'),'Kepala Dinas','Kepala Dinas Pendidikan','kadis',NULL),
    ('bidang_umum',MD5('umum123'),'Staf Bidang Umum','Staf Distribusi Surat','bidang_umum',9),
    ('kabid_sd',MD5('kabid123'),'Kepala Bidang SD','Kepala Bidang Pembinaan SD','kepala_bidang',2),
    ('kabid_smp',MD5('kabid123'),'Kepala Bidang SMP','Kepala Bidang Pembinaan SMP','kepala_bidang',3),
    ('kabid_gtk',MD5('kabid123'),'Kepala Bidang GTK','Kepala Bidang GTK','kepala_bidang',6)";
    mysqli_query($conn, $sql_user);
    $steps[] = ['ok', 'Data pengguna default berhasil diisi'];
} else {
    $steps[] = ['info', 'Data pengguna sudah ada, dilewati'];
}

// 6. Buat folder uploads
$base = __DIR__ . '/';
$folders = ['uploads/', 'uploads/foto/', 'uploads/surat/'];
foreach ($folders as $f) {
    if (!is_dir($base.$f)) {
        mkdir($base.$f, 0755, true);
        $steps[] = ['ok', "Folder <code>$f</code> dibuat"];
    } else {
        $steps[] = ['info', "Folder <code>$f</code> sudah ada"];
    }
}

// 7. Copy default.png
$src  = $base . 'foto/default.png';
$dest = $base . 'uploads/foto/default.png';
if (!file_exists($dest)) {
    if (file_exists($src)) {
        copy($src, $dest);
        $steps[] = ['ok', 'File <code>default.png</code> disalin ke uploads/foto/'];
    } else {
        $steps[] = ['warn', 'File <code>foto/default.png</code> tidak ditemukan, foto default tidak tersedia'];
    }
} else {
    $steps[] = ['info', 'File <code>default.png</code> sudah ada'];
}

$base_url = 'http://' . ($_SERVER['HTTP_HOST'] ?? 'localhost') . '/arsip-desa/';
$has_error = count(array_filter($steps, fn($s) => $s[0] === 'err')) > 0;
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Instalasi SIMDIS</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>body{background:#f4f6f9;display:flex;align-items:center;justify-content:center;min-height:100vh;padding:20px}</style>
</head>
<body>
<div style="width:580px">
  <div class="card" style="border-radius:12px;box-shadow:0 4px 24px rgba(0,0,0,0.1)">
    <div class="card-header bg-primary text-white" style="border-radius:12px 12px 0 0;padding:20px 24px">
      <h5 class="mb-0"><i class="fas fa-database mr-2"></i>Instalasi Database SIMDIS</h5>
    </div>
    <div class="card-body px-4 py-3">

      <!-- Log steps -->
      <div class="mb-3" style="max-height:280px;overflow-y:auto">
        <?php foreach ($steps as $s): ?>
        <?php
          $icon  = $s[0] === 'ok' ? 'check-circle text-success' : ($s[0] === 'err' ? 'times-circle text-danger' : ($s[0] === 'warn' ? 'exclamation-triangle text-warning' : 'info-circle text-info'));
        ?>
        <div class="d-flex align-items-start mb-1" style="font-size:0.85rem">
          <i class="fas fa-<?= $icon ?> mr-2 mt-1" style="flex-shrink:0"></i>
          <span><?= $s[1] ?></span>
        </div>
        <?php endforeach; ?>
      </div>

      <?php if (!$has_error): ?>
      <div class="alert alert-success py-2 mb-3">
        <i class="fas fa-check-circle mr-1"></i>
        Instalasi selesai! Semua komponen siap digunakan.
      </div>

      <h6 class="font-weight-bold">Akun Login Default:</h6>
      <table class="table table-sm table-bordered mb-3">
        <thead class="thead-light"><tr><th>Username</th><th>Password</th><th>Role</th></tr></thead>
        <tbody>
          <tr><td><code>admin</code></td><td><code>admin123</code></td><td><span class="badge badge-danger">Admin</span></td></tr>
          <tr><td><code>sepri</code></td><td><code>sepri123</code></td><td><span class="badge badge-info">Sepri</span></td></tr>
          <tr><td><code>kadis</code></td><td><code>kadis123</code></td><td><span class="badge badge-primary">Kadis</span></td></tr>
          <tr><td><code>bidang_umum</code></td><td><code>umum123</code></td><td><span class="badge badge-warning">Bidang Umum</span></td></tr>
          <tr><td><code>kabid_sd</code></td><td><code>kabid123</code></td><td><span class="badge badge-success">Kepala Bidang</span></td></tr>
        </tbody>
      </table>

      <a href="<?= $base_url ?>" class="btn btn-primary btn-block">
        <i class="fas fa-sign-in-alt mr-1"></i> Buka Aplikasi
      </a>
      <?php else: ?>
      <div class="alert alert-danger py-2">
        <i class="fas fa-exclamation-circle mr-1"></i>
        Ada error saat instalasi. Periksa log di atas.
      </div>
      <?php endif; ?>
    </div>
  </div>
</div>
</body>
</html>
