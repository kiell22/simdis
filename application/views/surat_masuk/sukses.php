<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Surat Terkirim | Dinas Pendidikan Provinsi Papua</title>
  <link rel="icon" type="image/png" href="<?= base_url('assets/images/logo-pemda.png') ?>">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <style>
    body {
      background: url('<?= base_url('assets/images/bg1.webp') ?>') center center / cover no-repeat fixed;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      font-family: 'Source Sans Pro', sans-serif;
    }
    body::before {
      content: '';
      position: fixed;
      inset: 0;
      background: rgba(10,15,35,0.6);
      backdrop-filter: blur(2px);
      z-index: 0;
    }
    .card-sukses {
      position: relative;
      z-index: 1;
      background: #fff;
      border-radius: 16px;
      box-shadow: 0 16px 48px rgba(0,0,0,0.35);
      padding: 48px 40px;
      text-align: center;
      max-width: 480px;
      width: 100%;
    }
    .icon-sukses {
      width: 80px; height: 80px;
      background: #e8f5e9;
      border-radius: 50%;
      display: flex; align-items: center; justify-content: center;
      margin: 0 auto 20px;
    }
    .tiket-box {
      background: #e3f2fd;
      border: 2px dashed #1565c0;
      border-radius: 10px;
      padding: 16px 24px;
      margin: 20px 0;
    }
    .tiket-box .label { font-size: 0.75rem; color: #6c757d; font-weight: 700; text-transform: uppercase; }
    .tiket-box .kode  { font-size: 1.6rem; font-weight: 700; color: #1565c0; letter-spacing: 2px; }
  </style>
</head>
<body>
<div class="card-sukses">
  <div class="icon-sukses">
    <i class="fas fa-check-circle fa-2x text-success"></i>
  </div>
  <h4 class="font-weight-bold text-dark mb-1">Surat Berhasil Dikirim!</h4>
  <p class="text-muted small mb-0">Surat Anda telah diterima dan sedang dalam proses review oleh Bidang Umum.</p>

  <div class="tiket-box">
    <div class="label">Kode Tiket Anda</div>
    <div class="kode"><?= $tiket ?></div>
    <div class="small text-muted mt-1">Simpan kode ini untuk memantau status surat Anda</div>
  </div>

  <div class="bg-light rounded p-3 text-left mb-4" style="font-size:0.85rem">
    <div class="text-muted small font-weight-bold mb-1">PERIHAL</div>
    <div class="text-dark"><?= $perihal ?></div>
  </div>

  <div class="d-flex gap-2 justify-content-center" style="gap:10px">
    <a href="<?= base_url('surat-masuk/cek-status?kode='.$tiket) ?>"
       class="btn btn-primary btn-sm px-4">
      <i class="fas fa-search mr-1"></i> Cek Status
    </a>
    <a href="<?= base_url('surat-masuk') ?>" class="btn btn-outline-secondary btn-sm px-4">
      <i class="fas fa-plus mr-1"></i> Kirim Surat Lain
    </a>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
