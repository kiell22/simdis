<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Cek Status Surat | Dinas Pendidikan Provinsi Papua</title>
  <link rel="icon" type="image/png" href="<?= base_url('assets/images/logo-pemda.png') ?>">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <style>
    body {
      background: url('<?= base_url('assets/images/bg1.webp') ?>') center center / cover no-repeat fixed;
      min-height: 100vh; display: flex; align-items: center; justify-content: center;
      font-family: 'Source Sans Pro', sans-serif;
    }
    body::before { content:''; position:fixed; inset:0; background:rgba(10,15,35,0.6); backdrop-filter:blur(2px); z-index:0; }
    .card-cek { position:relative; z-index:1; background:#fff; border-radius:16px; box-shadow:0 16px 48px rgba(0,0,0,0.35); padding:36px 32px; max-width:500px; width:100%; }
    <?php
    $status_colors = ['menunggu'=>'#f57f17','diterima_bu'=>'#1565c0','validasi_sepri'=>'#6a1b9a','diteruskan_kadis'=>'#2e7d32','ditolak'=>'#c62828'];
    $status_labels = ['menunggu'=>'Menunggu Review','diterima_bu'=>'Diterima Bidang Umum','validasi_sepri'=>'Validasi Sepri','diteruskan_kadis'=>'Diteruskan ke Kepala Dinas','ditolak'=>'Ditolak'];
    $status_icons  = ['menunggu'=>'clock','diterima_bu'=>'check','validasi_sepri'=>'user-check','diteruskan_kadis'=>'check-double','ditolak'=>'times-circle'];
    ?>
  </style>
</head>
<body>
<div class="card-cek">
  <div class="text-center mb-4">
    <img src="<?= base_url('assets/images/logo-pemda.png') ?>" width="50" class="mb-2" onerror="this.style.display='none'">
    <h5 class="font-weight-bold text-dark mb-0">Cek Status Surat</h5>
    <p class="text-muted small">Masukkan kode tiket yang Anda terima</p>
  </div>

  <form method="get" action="<?= base_url('surat-masuk/cek-status') ?>">
    <div class="input-group mb-3">
      <input type="text" name="kode" class="form-control" placeholder="Contoh: SML-A1B2C3D4"
             value="<?= htmlspecialchars($kode ?? '') ?>" style="text-transform:uppercase">
      <div class="input-group-append">
        <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
      </div>
    </div>
  </form>

  <?php if ($kode && !$result): ?>
  <div class="alert alert-warning text-center">
    <i class="fas fa-exclamation-triangle mr-1"></i>
    Kode tiket <strong><?= htmlspecialchars($kode) ?></strong> tidak ditemukan.
  </div>
  <?php endif; ?>

  <?php if ($result): ?>
  <?php
    $sc = $status_colors[$result->status] ?? '#6c757d';
    $sl = $status_labels[$result->status] ?? $result->status;
    $si = $status_icons[$result->status] ?? 'circle';
  ?>
  <div class="border rounded p-3 mt-2">
    <div class="d-flex align-items-center mb-3">
      <div style="width:42px;height:42px;border-radius:50%;background:<?= $sc ?>;display:flex;align-items:center;justify-content:center;margin-right:12px;flex-shrink:0">
        <i class="fas fa-<?= $si ?> text-white"></i>
      </div>
      <div>
        <div class="font-weight-bold text-dark"><?= $sl ?></div>
        <div class="small text-muted">Tiket: <strong><?= $result->kode_tiket ?></strong></div>
      </div>
    </div>
    <table class="table table-sm table-borderless mb-0" style="font-size:0.85rem">
      <tr><td class="text-muted" width="40%">Pengirim</td><td><?= $result->nama_pengirim ?></td></tr>
      <tr><td class="text-muted">Instansi</td><td><?= $result->instansi_pengirim ?></td></tr>
      <tr><td class="text-muted">No. Surat</td><td><?= $result->no_surat ?></td></tr>
      <tr><td class="text-muted">Perihal</td><td><?= $result->perihal ?></td></tr>
      <tr><td class="text-muted">Tgl. Kirim</td><td><?= date('d M Y H:i', strtotime($result->created_at)) ?></td></tr>
      <?php if ($result->catatan_bu): ?>
      <tr><td class="text-muted">Catatan</td><td><?= $result->catatan_bu ?></td></tr>
      <?php endif; ?>
    </table>
  </div>
  <?php endif; ?>

  <div class="text-center mt-3">
    <a href="<?= base_url('surat-masuk') ?>" class="text-primary small">
      <i class="fas fa-arrow-left mr-1"></i>Kembali ke Form
    </a>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.querySelector('input[name=kode]').addEventListener('input', function(){ this.value = this.value.toUpperCase(); });
</script>
</body>
</html>
