<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>404 - Halaman Tidak Ditemukan | SIMDIS</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
  <style>
    body { background: #f4f6f9; }
    .error-page { display: flex; align-items: center; justify-content: center; min-height: 100vh; }
    .error-box { text-align: center; padding: 40px 20px; }
    .error-number {
      font-size: 120px; font-weight: 700; line-height: 1;
      color: #1565c0; text-shadow: 2px 4px 0 rgba(21,101,192,0.15);
    }
    .error-icon {
      width: 80px; height: 80px; background: #e3f2fd;
      border-radius: 50%; display: flex; align-items: center;
      justify-content: center; margin: 0 auto 20px;
    }
  </style>
</head>
<body class="hold-transition">
<div class="error-page">
  <div class="error-box">
    <div class="error-icon">
      <i class="fas fa-search fa-2x text-primary"></i>
    </div>
    <div class="error-number">404</div>
    <h3 class="font-weight-bold text-dark mt-2 mb-1">Halaman Tidak Ditemukan</h3>
    <p class="text-muted mb-4">Halaman yang Anda cari tidak tersedia atau telah dipindahkan.</p>
    <a href="<?= base_url('Dashboard') ?>" class="btn btn-primary px-4">
      <i class="fas fa-home mr-2"></i>Kembali ke Dashboard
    </a>
  </div>
</div>
</body>
</html>
