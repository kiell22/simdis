<?php
$conn = new mysqli('localhost', 'root', '', 'disdik_papua');
if ($conn->connect_error) die('Gagal: '.$conn->connect_error);

// Reset semua password ke MD5
$users = [
    'admin'       => 'admin123',
    'sepri'       => 'sepri123',
    'kadis'       => 'kadis123',
    'bidang_umum' => 'umum123',
    'kabid_sd'    => 'kabid123',
    'kabid_smp'   => 'kabid123',
    'kabid_gtk'   => 'kabid123',
];

foreach ($users as $username => $password) {
    $hash = md5($password);
    $conn->query("UPDATE tbl_pengguna SET password='$hash' WHERE username='$username'");
    $affected = $conn->affected_rows;
    echo ($affected > 0 ? '✅' : '⚠️ (tidak ada perubahan)')." Reset password <b>$username</b> → MD5<br>";
}

echo '<br><strong>Selesai! Semua password sudah direset.</strong><br><br>';
echo '<a href="/arsip-desa" style="background:#1a3a5c;color:white;padding:10px 20px;text-decoration:none;border-radius:5px">Login Sekarang</a>';

$conn->close();
?>
