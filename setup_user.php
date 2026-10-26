<?php
/**
 * Setup lengkap - akses: http://localhost/arsip-desa/setup_user.php
 * HAPUS setelah dijalankan!
 */
$conn = new mysqli('localhost', 'root', '', 'disdik_papua');
if ($conn->connect_error) die('❌ Koneksi gagal: ' . $conn->connect_error);

echo '<style>body{font-family:monospace;padding:20px}table{border-collapse:collapse}td,th{border:1px solid #ccc;padding:6px 10px}h3{margin-top:20px}</style>';
echo '<h2>Setup Sistem</h2>';

// 1. Buat tabel ci_sessions untuk session database
$conn->query("CREATE TABLE IF NOT EXISTS `ci_sessions` (
    `id`         varchar(128) NOT NULL,
    `ip_address` varchar(45)  NOT NULL,
    `timestamp`  int(10) unsigned DEFAULT 0 NOT NULL,
    `data`       blob NOT NULL,
    KEY `ci_sessions_timestamp` (`timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
echo '✅ Tabel ci_sessions siap<br>';

// 2. Perbesar kolom password
$conn->query("ALTER TABLE tbl_pengguna MODIFY COLUMN password varchar(255) NOT NULL");
echo '✅ Kolom password diperbesar ke varchar(255)<br>';

// 3. Pastikan data bidang ada
$cek = $conn->query("SELECT COUNT(*) as total FROM tbl_bidang")->fetch_object();
if ($cek->total == 0) {
    $conn->query("INSERT INTO tbl_bidang (kode_bidang, nama_bidang, aktif) VALUES
        ('SEKRETARIAT','Sekretariat',1),
        ('BIDANG-SD','Bidang Pembinaan SD',1),
        ('BIDANG-SMP','Bidang Pembinaan SMP',1),
        ('BIDANG-SMA','Bidang Pembinaan SMA',1),
        ('BIDANG-SMK','Bidang Pembinaan SMK',1),
        ('BIDANG-GTK','Bidang GTK',1),
        ('BIDANG-PAUD','Bidang PAUD & PNF',1),
        ('BIDANG-SARPRAS','Bidang Sarana Prasarana',1),
        ('BIDANG-UMUM','Bidang Umum',1)");
    echo '✅ Data bidang diinsert<br>';
} else {
    echo '✅ Data bidang sudah ada (' . $cek->total . ' bidang)<br>';
}

// 4. Ambil id_bidang
$bidang = [];
$res = $conn->query("SELECT id_bidang, kode_bidang FROM tbl_bidang ORDER BY id_bidang ASC");
while ($row = $res->fetch_object()) $bidang[$row->kode_bidang] = $row->id_bidang;

// 5. Insert/update user
$users = [
    ['admin',        'admin123', 'Administrator',         'Administrator Sistem',           'admin',         null],
    ['sepri',        'sepri123', 'Staf Penerima Surat',   'Staf Penerima Surat',            'sepri',         'SEKRETARIAT'],
    ['kadis',        'kadis123', 'Kepala Dinas',          'Kepala Dinas Pendidikan',        'kadis',         null],
    ['bidang_umum',  'umum123',  'Staf Bidang Umum',      'Staf Distribusi Surat',          'bidang_umum',   'BIDANG-UMUM'],
    ['kabid_sd',     'kabid123', 'Kepala Bidang SD',      'Kepala Bidang Pembinaan SD',     'kepala_bidang', 'BIDANG-SD'],
    ['kabid_smp',    'kabid123', 'Kepala Bidang SMP',     'Kepala Bidang Pembinaan SMP',    'kepala_bidang', 'BIDANG-SMP'],
    ['kabid_sma',    'kabid123', 'Kepala Bidang SMA',     'Kepala Bidang Pembinaan SMA',    'kepala_bidang', 'BIDANG-SMA'],
    ['kabid_smk',    'kabid123', 'Kepala Bidang SMK',     'Kepala Bidang Pembinaan SMK',    'kepala_bidang', 'BIDANG-SMK'],
    ['kabid_gtk',    'kabid123', 'Kepala Bidang GTK',     'Kepala Bidang GTK',              'kepala_bidang', 'BIDANG-GTK'],
    ['kabid_paud',   'kabid123', 'Kepala Bidang PAUD',    'Kepala Bidang PAUD & PNF',       'kepala_bidang', 'BIDANG-PAUD'],
    ['kabid_sarpras','kabid123', 'Kepala Bidang Sarpras', 'Kepala Bidang Sarana Prasarana', 'kepala_bidang', 'BIDANG-SARPRAS'],
    ['kabid_sekret', 'kabid123', 'Kepala Sekretariat',    'Kepala Sekretariat',             'kepala_bidang', 'SEKRETARIAT'],
];

echo '<h3>Daftar User</h3>';
echo '<table><tr style="background:#ddd"><th>Username</th><th>Password</th><th>Role</th><th>Bidang</th><th>Status</th></tr>';

$inserted = $updated = 0;
foreach ($users as $u) {
    list($username, $plain, $nama, $jabatan, $role, $kode_bidang) = $u;
    $hash      = password_hash($plain, PASSWORD_DEFAULT);
    $id_bidang = $kode_bidang ? ($bidang[$kode_bidang] ?? null) : null;

    $cek = $conn->prepare("SELECT id_pengguna FROM tbl_pengguna WHERE username = ?");
    $cek->bind_param('s', $username);
    $cek->execute();
    $cek->store_result();
    $exists = $cek->num_rows > 0;
    $cek->close();

    if ($exists) {
        $stmt = $conn->prepare("UPDATE tbl_pengguna SET password=?,nama_lengkap=?,jabatan=?,role=?,id_bidang=?,aktif=1 WHERE username=?");
        $stmt->bind_param('ssssis', $hash, $nama, $jabatan, $role, $id_bidang, $username);
        $status = '🔄 Updated';
        $updated++;
    } else {
        $stmt = $conn->prepare("INSERT INTO tbl_pengguna (username,password,nama_lengkap,jabatan,role,id_bidang,aktif) VALUES (?,?,?,?,?,?,1)");
        $stmt->bind_param('sssssi', $username, $hash, $nama, $jabatan, $role, $id_bidang);
        $status = '✅ Baru';
        $inserted++;
    }
    $stmt->execute();
    $stmt->close();

    echo "<tr><td><b>$username</b></td><td>$plain</td><td>$role</td><td>" . ($kode_bidang ?? '-') . "</td><td>$status</td></tr>";
}
echo '</table>';
echo "<br><b>$inserted user baru, $updated user diperbarui.</b>";
echo '<h3>Langkah Selanjutnya</h3>';
echo '<ol>
<li>Hapus file <b>setup_user.php</b> ini</li>
<li>Hapus file <b>test_session.php</b>, <b>debug_surat.php</b>, <b>migrate_password.php</b> jika ada</li>
<li>Buka browser baru / clear cookies</li>
<li>Login dengan username <b>admin</b> password <b>admin123</b></li>
</ol>';
echo "<span style='color:red;font-size:1.1em'><b>⚠️ HAPUS file setup_user.php sekarang!</b></span>";
$conn->close();
