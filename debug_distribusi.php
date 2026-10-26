<?php
$conn = new mysqli('localhost', 'root', '', 'disdik_papua');
if ($conn->connect_error) die("Koneksi gagal: " . $conn->connect_error);

// Cek data pengguna dan bidang dulu
echo "<h3>Data Pengguna</h3>";
$r = $conn->query("SELECT id_pengguna, username, nama_lengkap, role, id_bidang FROM tbl_pengguna WHERE aktif=1 ORDER BY role");
echo "<table border='1' cellpadding='5'><tr><th>id_pengguna</th><th>username</th><th>nama_lengkap</th><th>role</th><th>id_bidang</th></tr>";
$pengguna = [];
while($row = $r->fetch_assoc()) {
    $pengguna[$row['role']][] = $row;
    echo "<tr><td>{$row['id_pengguna']}</td><td>{$row['username']}</td><td>{$row['nama_lengkap']}</td><td>{$row['role']}</td><td>{$row['id_bidang']}</td></tr>";
}
echo "</table>";

echo "<h3>Data Bidang</h3>";
$r2 = $conn->query("SELECT id_bidang, kode_bidang, nama_bidang FROM tbl_bidang WHERE aktif=1 ORDER BY id_bidang");
echo "<table border='1' cellpadding='5'><tr><th>id_bidang</th><th>kode_bidang</th><th>nama_bidang</th></tr>";
$bidang_list = [];
while($row = $r2->fetch_assoc()) {
    $bidang_list[] = $row;
    echo "<tr><td>{$row['id_bidang']}</td><td>{$row['kode_bidang']}</td><td>{$row['nama_bidang']}</td></tr>";
}
echo "</table>";

echo "<h3>Data Surat Existing</h3>";
$r3 = $conn->query("SELECT id_surat, no_agenda, perihal, status FROM tbl_surat ORDER BY id_surat DESC LIMIT 10");
echo "<table border='1' cellpadding='5'><tr><th>id_surat</th><th>no_agenda</th><th>perihal</th><th>status</th></tr>";
while($row = $r3->fetch_assoc()) {
    echo "<tr><td>{$row['id_surat']}</td><td>{$row['no_agenda']}</td><td>{$row['perihal']}</td><td>{$row['status']}</td></tr>";
}
echo "</table>";

// Jika ada tombol insert
if (isset($_POST['insert'])) {
    // Ambil id pengguna yang dibutuhkan
    $id_sepri  = $conn->query("SELECT id_pengguna FROM tbl_pengguna WHERE role IN ('sepri','admin') LIMIT 1")->fetch_assoc()['id_pengguna'];
    $id_kadis  = $conn->query("SELECT id_pengguna FROM tbl_pengguna WHERE role='kadis' LIMIT 1")->fetch_assoc()['id_pengguna'];
    $id_bumum  = $conn->query("SELECT id_pengguna FROM tbl_pengguna WHERE role='bidang_umum' LIMIT 1")->fetch_assoc()['id_pengguna'];

    // Ambil semua kepala bidang
    $kabid_list = [];
    $rk = $conn->query("SELECT id_pengguna, id_bidang, nama_lengkap FROM tbl_pengguna WHERE role='kepala_bidang' AND aktif=1");
    while($row = $rk->fetch_assoc()) $kabid_list[] = $row;

    if (empty($kabid_list)) {
        echo "<p style='color:red'>Tidak ada kepala_bidang di database!</p>";
    } else {
        $now = date('Y-m-d H:i:s');
        $tgl = date('Y-m-d');

        // Insert 3 surat test
        $surat_data = [
            ['no_surat'=>'001/TEST/VIII/2025', 'perihal'=>'Surat Test Distribusi 1 - Undangan Rapat Koordinasi', 'asal'=>'Kementerian Pendidikan'],
            ['no_surat'=>'002/TEST/VIII/2025', 'perihal'=>'Surat Test Distribusi 2 - Pemberitahuan Dana BOS', 'asal'=>'Dinas Keuangan Provinsi'],
            ['no_surat'=>'003/TEST/VIII/2025', 'perihal'=>'Surat Test Distribusi 3 - Laporan Kegiatan Semester', 'asal'=>'Badan Pengawas Daerah'],
        ];

        foreach ($surat_data as $i => $sd) {
            $no_agenda = 'AGD/2025/TEST'.($i+1);

            // 1. Insert surat
            $conn->query("INSERT INTO tbl_surat (no_agenda, no_surat, tgl_surat, tgl_terima, asal_surat, perihal, sifat, status, id_pengguna_input, created_at, updated_at)
                VALUES ('$no_agenda', '{$sd['no_surat']}', '$tgl', '$tgl', '{$sd['asal']}', '{$sd['perihal']}', 'biasa', 'distribusi', $id_sepri, '$now', '$now')");
            $id_surat = $conn->insert_id;

            // 2. Insert disposisi
            $conn->query("INSERT INTO tbl_disposisi (id_surat, id_pengguna_disposisi, isi_disposisi, instruksi, tgl_disposisi)
                VALUES ($id_surat, $id_kadis, 'Untuk ditindaklanjuti sesuai bidang masing-masing', 'Segera diproses', '$now')");
            $id_disposisi = $conn->insert_id;

            // 3. Insert disposisi_bidang ke semua kabid
            foreach ($kabid_list as $kb) {
                $conn->query("INSERT INTO tbl_disposisi_bidang (id_disposisi, id_bidang) VALUES ($id_disposisi, {$kb['id_bidang']})");
            }

            // 4. Insert distribusi ke semua kabid
            foreach ($kabid_list as $kb) {
                $conn->query("INSERT INTO tbl_distribusi (id_surat, id_bidang, id_pengguna_kirim, tgl_kirim, catatan_kirim, status)
                    VALUES ($id_surat, {$kb['id_bidang']}, $id_bumum, '$now', 'Dikirim untuk ditindaklanjuti', 'dikirim')");
            }

            // 5. Insert riwayat
            $conn->query("INSERT INTO tbl_riwayat (id_surat, id_pengguna, aksi, keterangan, tgl_aksi) VALUES ($id_surat, $id_sepri, 'Surat dicatat', 'No. Agenda: $no_agenda', '$now')");
            $conn->query("INSERT INTO tbl_riwayat (id_surat, id_pengguna, aksi, keterangan, tgl_aksi) VALUES ($id_surat, $id_kadis, 'Surat didisposisi', 'Didisposisi ke semua bidang', '$now')");
            $conn->query("INSERT INTO tbl_riwayat (id_surat, id_pengguna, aksi, keterangan, tgl_aksi) VALUES ($id_surat, $id_bumum, 'Surat dikirim/distribusi', 'Dikirim ke semua bidang', '$now')");

            echo "<p style='color:green'>✓ Surat <b>{$sd['no_surat']}</b> (id_surat=$id_surat) berhasil dibuat dan didistribusikan ke " . count($kabid_list) . " bidang.</p>";
        }

        echo "<hr><h3>Cek tbl_distribusi setelah insert</h3>";
        $rc = $conn->query("SELECT d.id_distribusi, d.id_surat, d.id_bidang, d.status, b.nama_bidang FROM tbl_distribusi d LEFT JOIN tbl_bidang b ON b.id_bidang=d.id_bidang ORDER BY d.id_distribusi DESC LIMIT 20");
        echo "<table border='1' cellpadding='5'><tr><th>id_distribusi</th><th>id_surat</th><th>id_bidang</th><th>nama_bidang</th><th>status</th></tr>";
        while($row = $rc->fetch_assoc()) {
            echo "<tr><td>{$row['id_distribusi']}</td><td>{$row['id_surat']}</td><td>{$row['id_bidang']}</td><td>{$row['nama_bidang']}</td><td>{$row['status']}</td></tr>";
        }
        echo "</table>";
        echo "<p><a href='http://localhost/simdis/Surat' target='_blank'>→ Buka Daftar Surat</a></p>";
    }
}

$conn->close();
?>

<?php if (!isset($_POST['insert'])): ?>
<hr>
<form method="post">
    <button name="insert" value="1" style="padding:10px 20px;background:green;color:white;border:none;cursor:pointer;font-size:16px">
        INSERT DATA TEST (3 Surat ke Semua Kabid)
    </button>
</form>
<?php endif; ?>
