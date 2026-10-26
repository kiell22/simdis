<?php
// Test session CI - akses: http://localhost/arsip-desa/test_session.php
define('FCPATH', __DIR__ . DIRECTORY_SEPARATOR);

// Boot CI manual
define('STDIN', fopen('php://stdin', 'r'));
$_SERVER['SERVER_NAME'] = 'localhost';
$_SERVER['HTTP_HOST']   = 'localhost';
$_SERVER['REQUEST_URI'] = '/arsip-desa/test_session.php';

echo '<h3>Test Session & POST</h3>';

// Cek session native PHP
session_save_path(__DIR__ . '/application/cache/');
session_start();

echo 'Session ID: <b>' . session_id() . '</b><br>';
echo 'Session save path: <b>' . session_save_path() . '</b><br>';
echo 'Writable: <b>' . (is_writable(session_save_path()) ? '✅ Ya' : '❌ Tidak') . '</b><br><br>';

// Simulasi set & baca session
if (isset($_GET['set'])) {
    $_SESSION['test_val'] = 'berhasil_' . time();
    echo '✅ Session di-set: ' . $_SESSION['test_val'] . '<br>';
    echo '<a href="test_session.php?read=1">Klik untuk baca session</a>';
} elseif (isset($_GET['read'])) {
    echo 'Session value: <b>' . ($_SESSION['test_val'] ?? '❌ KOSONG - session tidak persist!') . '</b><br>';
} else {
    echo '<a href="test_session.php?set=1">Set session</a>';
}

echo '<br><br>';

// Cek POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo '<h3>POST Data Diterima:</h3>';
    echo '<pre>' . print_r($_POST, true) . '</pre>';
} else {
    echo '<h3>Test Form POST:</h3>';
    echo '<form method="post">
        <input type="text" name="test_field" value="test123">
        <button type="submit" name="btnsimpan">Submit</button>
    </form>';
}

echo '<br><span style="color:red">HAPUS file ini setelah selesai!</span>';
