<?php
// Cek dan perbaiki tabel ci_sessions
$conn = new mysqli('localhost', 'root', '', 'disdik_papua');
if ($conn->connect_error) die('Koneksi gagal: ' . $conn->connect_error);

// Cek apakah tabel ci_sessions ada dan strukturnya benar
$r = $conn->query("SHOW TABLES LIKE 'ci_sessions'");
if ($r->num_rows == 0) {
    // Buat tabel ci_sessions
    $conn->query("CREATE TABLE IF NOT EXISTS `ci_sessions` (
        `id`         varchar(128) NOT NULL,
        `ip_address` varchar(45)  NOT NULL,
        `timestamp`  int(10) unsigned DEFAULT 0 NOT NULL,
        `data`       blob NOT NULL,
        KEY `ci_sessions_timestamp` (`timestamp`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8");
    echo '<p style="color:green">✅ Tabel ci_sessions berhasil dibuat</p>';
} else {
    echo '<p style="color:green">✅ Tabel ci_sessions sudah ada</p>';
    // Tampilkan struktur
    $cols = $conn->query("DESCRIBE ci_sessions");
    echo '<table border="1" cellpadding="5"><tr><th>Field</th><th>Type</th><th>Key</th></tr>';
    while ($c = $cols->fetch_assoc()) {
        echo "<tr><td>{$c['Field']}</td><td>{$c['Type']}</td><td>{$c['Key']}</td></tr>";
    }
    echo '</table>';
}

// Cek data pengguna
$r2 = $conn->query("SELECT username, password, aktif FROM tbl_pengguna WHERE username='admin'");
if ($r2 && $r2->num_rows > 0) {
    $u = $r2->fetch_object();
    $match = ($u->password === md5('admin123')) ? '✅ COCOK' : '❌ TIDAK COCOK';
    echo "<p>Admin password check: $match | aktif: {$u->aktif}</p>";
} else {
    echo '<p style="color:red">❌ User admin tidak ditemukan!</p>';
}

$conn->close();
echo '<br><a href="/arsip-desa" style="background:#1a3a5c;color:white;padding:10px 20px;text-decoration:none;border-radius:5px">Coba Login Sekarang</a>';
?>
