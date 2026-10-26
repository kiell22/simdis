<?php
// Debug script - akses: http://localhost/arsip-desa/debug_surat.php
// HAPUS setelah selesai debug!

// Simulasi environment CI
define('FCPATH', __DIR__ . DIRECTORY_SEPARATOR);

echo '<h3>1. Cek Koneksi Database</h3>';
$conn = new mysqli('localhost', 'root', '', 'disdik_papua');
if ($conn->connect_error) {
    die('❌ Koneksi gagal: ' . $conn->connect_error);
}
echo '✅ Koneksi OK<br>';

echo '<h3>2. Cek Kolom tbl_pengguna (password)</h3>';
$res = $conn->query("SHOW COLUMNS FROM tbl_pengguna LIKE 'password'");
$col = $res->fetch_assoc();
echo 'Tipe kolom password: <b>' . $col['Type'] . '</b><br>';
if (strpos($col['Type'], '255') !== false || strpos($col['Type'], '100') !== false) {
    $len = (int) filter_var($col['Type'], FILTER_SANITIZE_NUMBER_INT);
    if ($len < 255) {
        echo '⚠️ Panjang kolom password hanya ' . $len . ' — perlu diperbesar ke 255<br>';
    } else {
        echo '✅ Panjang kolom password cukup<br>';
    }
}

echo '<h3>3. Cek Sample Password di Database</h3>';
$res = $conn->query("SELECT username, LEFT(password,10) as pw_awal, LENGTH(password) as pw_len FROM tbl_pengguna LIMIT 5");
echo '<table border="1" cellpadding="4"><tr><th>Username</th><th>Awal Password</th><th>Panjang</th><th>Tipe Hash</th></tr>';
while ($row = $res->fetch_assoc()) {
    $tipe = strlen($row['pw_awal']) && $row['pw_len'] == 32 ? '⚠️ MD5' : ($row['pw_len'] >= 60 ? '✅ bcrypt' : '❓ Unknown');
    echo "<tr><td>{$row['username']}</td><td>{$row['pw_awal']}...</td><td>{$row['pw_len']}</td><td>$tipe</td></tr>";
}
echo '</table>';

echo '<h3>4. Cek Struktur tbl_surat</h3>';
$res = $conn->query("SHOW COLUMNS FROM tbl_surat");
echo '<table border="1" cellpadding="4"><tr><th>Field</th><th>Type</th><th>Null</th><th>Default</th></tr>';
while ($row = $res->fetch_assoc()) {
    echo "<tr><td>{$row['Field']}</td><td>{$row['Type']}</td><td>{$row['Null']}</td><td>{$row['Default']}</td></tr>";
}
echo '</table>';

echo '<h3>5. Cek PHP Version & Session</h3>';
echo 'PHP Version: <b>' . PHP_VERSION . '</b><br>';
session_start();
echo 'Session save path: <b>' . session_save_path() . '</b><br>';
echo 'Session writable: <b>' . (is_writable(session_save_path()) ? '✅ Ya' : '❌ Tidak') . '</b><br>';

echo '<h3>6. Cek Upload Directory</h3>';
$upload_dir = FCPATH . 'uploads' . DIRECTORY_SEPARATOR . 'surat' . DIRECTORY_SEPARATOR;
echo 'Path: <b>' . $upload_dir . '</b><br>';
echo 'Exists: <b>' . (is_dir($upload_dir) ? '✅ Ya' : '❌ Tidak') . '</b><br>';
echo 'Writable: <b>' . (is_writable($upload_dir) ? '✅ Ya' : '❌ Tidak') . '</b><br>';

$conn->close();
echo '<br><span style="color:red"><b>HAPUS file debug_surat.php setelah selesai!</b></span>';
