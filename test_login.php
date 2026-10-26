<?php
session_start();

$conn = new mysqli('localhost', 'root', '', 'disdik_papua');

echo '<h3>Test 1: Koneksi DB</h3>';
echo $conn->connect_error ? '❌ GAGAL: '.$conn->connect_error : '✅ OK';

echo '<h3>Test 2: Data Admin</h3>';
$r = $conn->query("SELECT * FROM tbl_pengguna WHERE username='admin'");
$u = $r->fetch_object();
echo 'Password di DB: <code>'.$u->password.'</code><br>';
echo 'MD5(admin123): <code>'.md5('admin123').'</code><br>';
echo ($u->password === md5('admin123')) ? '✅ Password COCOK' : '❌ Password TIDAK COCOK';
echo '<br>Aktif: '.$u->aktif;

echo '<h3>Test 3: PHP Session</h3>';
$_SESSION['test'] = 'berhasil';
echo isset($_SESSION['test']) ? '✅ Session OK' : '❌ Session GAGAL';

echo '<h3>Test 4: Simulasi Login Manual</h3>';
if (isset($_POST['login'])) {
    $user = $conn->query("SELECT * FROM tbl_pengguna WHERE username='".$_POST['u']."' AND password='".md5($_POST['p'])."' AND aktif=1")->fetch_object();
    if ($user) {
        $_SESSION['id_pengguna'] = $user->id_pengguna;
        $_SESSION['role'] = $user->role;
        echo '✅ LOGIN BERHASIL! Role: '.$user->role.'<br>';
        echo 'Session id_pengguna: '.$_SESSION['id_pengguna'];
    } else {
        echo '❌ LOGIN GAGAL';
    }
}

echo '<form method="post">
    <input name="u" value="admin" placeholder="username"><br>
    <input name="p" value="admin123" placeholder="password"><br>
    <button name="login">Test Login</button>
</form>';

echo '<h3>Test 5: Cek CI Session Table</h3>';
$t = $conn->query("SHOW TABLES LIKE 'ci_sessions'");
echo $t->num_rows > 0 ? '✅ Tabel ci_sessions ADA' : '❌ Tabel ci_sessions TIDAK ADA';

if ($t->num_rows > 0) {
    $cols = $conn->query("DESCRIBE ci_sessions");
    echo '<br>Kolom: ';
    while ($c = $cols->fetch_assoc()) echo $c['Field'].' | ';
}

$conn->close();
?>
