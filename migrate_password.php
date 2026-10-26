<?php
/**
 * Script migrasi password MD5 -> password_hash (bcrypt)
 * Akses: http://localhost/arsip-desa/migrate_password.php
 * HAPUS file ini setelah dijalankan!
 */

$conn = new mysqli('localhost', 'root', '', 'disdik_papua');
if ($conn->connect_error) die('Koneksi gagal: ' . $conn->connect_error);

// Password asli sesuai disdik.sql
$passwords = [
    'admin'       => 'admin123',
    'sepri'       => 'sepri123',
    'kadis'       => 'kadis123',
    'bidang_umum' => 'umum123',
    'kabid_sd'    => 'kabid123',
    'kabid_smp'   => 'kabid123',
    'kabid_gtk'   => 'kabid123',
    // Tambahkan user lain jika ada
];

echo '<h3>Migrasi Password MD5 → bcrypt</h3>';
$updated = 0;
foreach ($passwords as $username => $plain) {
    $hash = password_hash($plain, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("UPDATE tbl_pengguna SET password = ? WHERE username = ?");
    $stmt->bind_param('ss', $hash, $username);
    $stmt->execute();
    if ($stmt->affected_rows > 0) {
        echo "✅ <b>$username</b> berhasil dimigrasi.<br>";
        $updated++;
    } else {
        echo "⚠️ <b>$username</b> tidak ditemukan atau sudah dimigrasi.<br>";
    }
    $stmt->close();
}

echo "<br><b>Total: $updated akun diperbarui.</b><br>";
echo "<br><span style='color:red'><b>⚠️ HAPUS file migrate_password.php sekarang!</b></span>";
$conn->close();
