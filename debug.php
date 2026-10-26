<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$db   = 'disdik_papua';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die('<p style="color:red">❌ Koneksi DB gagal: ' . $conn->connect_error . '</p>');
}
echo '<p style="color:green">✅ Koneksi database OK</p>';

// Cek tabel
$tables = ['tbl_bidang','tbl_pengguna','tbl_surat','tbl_disposisi','tbl_distribusi','tbl_riwayat','tbl_notifikasi'];
foreach ($tables as $t) {
    $r = $conn->query("SHOW TABLES LIKE '$t'");
    $status = $r->num_rows > 0 ? '✅' : '❌ TIDAK ADA';
    echo "<p>Tabel <code>$t</code>: $status</p>";
}

// Cek data pengguna
echo '<hr><h3>Data Pengguna:</h3>';
$res = $conn->query("SELECT id_pengguna, username, password, role, aktif FROM tbl_pengguna");
if ($res && $res->num_rows > 0) {
    echo '<table border="1" cellpadding="5">';
    echo '<tr><th>ID</th><th>Username</th><th>Password (MD5)</th><th>Role</th><th>Aktif</th><th>Test MD5</th></tr>';
    while ($row = $res->fetch_object()) {
        $test_pass = [
            'admin'       => md5('admin123'),
            'sepri'       => md5('sepri123'),
            'kadis'       => md5('kadis123'),
            'bidang_umum' => md5('umum123'),
            'kabid_sd'    => md5('kabid123'),
            'kabid_smp'   => md5('kabid123'),
            'kabid_gtk'   => md5('kabid123'),
        ];
        $expected = $test_pass[$row->username] ?? '-';
        $match = ($row->password === $expected) ? '✅ Cocok' : '❌ TIDAK COCOK (expected: '.$expected.')';
        echo "<tr>
            <td>{$row->id_pengguna}</td>
            <td>{$row->username}</td>
            <td style='font-size:11px'>{$row->password}</td>
            <td>{$row->role}</td>
            <td>{$row->aktif}</td>
            <td>$match</td>
        </tr>";
    }
    echo '</table>';
} else {
    echo '<p style="color:red">❌ Tabel tbl_pengguna KOSONG - data belum ada!</p>';
    echo '<p><a href="?fix=1" style="background:red;color:white;padding:8px 15px;text-decoration:none">Klik untuk Insert Data Pengguna</a></p>';
}

// Fix: insert data jika kosong
if (isset($_GET['fix'])) {
    $inserts = [
        "INSERT IGNORE INTO tbl_pengguna (username, password, nama_lengkap, jabatan, role, id_bidang) VALUES ('admin', '".md5('admin123')."', 'Administrator', 'Administrator Sistem', 'admin', NULL)",
        "INSERT IGNORE INTO tbl_pengguna (username, password, nama_lengkap, jabatan, role, id_bidang) VALUES ('sepri', '".md5('sepri123')."', 'Sepri', 'Staf Penerima Surat', 'sepri', 1)",
        "INSERT IGNORE INTO tbl_pengguna (username, password, nama_lengkap, jabatan, role, id_bidang) VALUES ('kadis', '".md5('kadis123')."', 'Kepala Dinas', 'Kepala Dinas Pendidikan', 'kadis', NULL)",
        "INSERT IGNORE INTO tbl_pengguna (username, password, nama_lengkap, jabatan, role, id_bidang) VALUES ('bidang_umum', '".md5('umum123')."', 'Staf Bidang Umum', 'Staf Distribusi Surat', 'bidang_umum', 9)",
        "INSERT IGNORE INTO tbl_pengguna (username, password, nama_lengkap, jabatan, role, id_bidang) VALUES ('kabid_sd', '".md5('kabid123')."', 'Kepala Bidang SD', 'Kepala Bidang Pembinaan SD', 'kepala_bidang', 2)",
    ];
    foreach ($inserts as $sql) {
        if ($conn->query($sql)) echo '<p style="color:green">✅ Insert OK</p>';
        else echo '<p style="color:red">❌ '.$conn->error.'</p>';
    }
    echo '<p><a href="debug.php">Refresh halaman ini</a></p>';
}

// Simulasi proses login
echo '<hr><h3>Simulasi Login (admin / admin123):</h3>';
$username = 'admin';
$password = md5('admin123');
$res2 = $conn->query("SELECT * FROM tbl_pengguna WHERE username='$username' AND password='$password' AND aktif=1");
if ($res2 && $res2->num_rows > 0) {
    echo '<p style="color:green">✅ Login BERHASIL - data user ditemukan</p>';
} else {
    echo '<p style="color:red">❌ Login GAGAL - user tidak ditemukan dengan kondisi tersebut</p>';
    // Cek tanpa filter aktif
    $res3 = $conn->query("SELECT * FROM tbl_pengguna WHERE username='$username'");
    if ($res3 && $res3->num_rows > 0) {
        $u = $res3->fetch_object();
        echo '<p>User ditemukan tapi: password match='.($u->password === $password ? 'YA' : 'TIDAK').', aktif='.$u->aktif.'</p>';
    } else {
        echo '<p>User <b>admin</b> tidak ada di database sama sekali</p>';
    }
}

// Cek session
echo '<hr><h3>Cek Session PHP:</h3>';
session_start();
$_SESSION['test'] = 'ok';
echo isset($_SESSION['test']) ? '<p style="color:green">✅ Session PHP berjalan normal</p>' : '<p style="color:red">❌ Session bermasalah</p>';

$conn->close();
?>

<?php
// Test tambahan: cek apakah redirect berfungsi
if (isset($_GET['logintest'])) {
    echo '<hr><h3>Test POST simulation:</h3>';
    $conn2 = new mysqli('localhost','root','','disdik_papua');
    $u = 'admin';
    $p = md5('admin123');
    $r = $conn2->query("SELECT * FROM tbl_pengguna WHERE username='$u' AND password='$p' AND aktif=1");
    echo $r->num_rows > 0
        ? '<p style="color:green">✅ Query login manual BERHASIL</p>'
        : '<p style="color:red">❌ Query login manual GAGAL</p>';

    echo '<p>MD5 admin123 = <code>'.md5('admin123').'</code></p>';
    echo '<p>Cek base_url CI: <code>http://localhost/arsip-desa/</code></p>';
    echo '<p><a href="/arsip-desa" style="background:blue;color:white;padding:8px 15px;text-decoration:none">Coba Login Sekarang</a></p>';
}
?>
