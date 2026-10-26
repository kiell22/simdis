<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login | SIMDIS</title>
  <link rel="icon" type="image/png" href="<?= base_url('assets/images/logo-pemda.png') ?>">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
  <style>
    * { box-sizing: border-box; margin: 0; padding: 0; }

    body {
      min-height: 100vh;
      font-family: 'Source Sans Pro', sans-serif;
      background: url('<?= base_url('assets/images/bg1.webp') ?>') center center / cover no-repeat fixed;
      display: flex;
      align-items: center;
      justify-content: center;
      position: relative;
    }
    body::before {
      content: '';
      position: fixed;
      inset: 0;
      background: rgba(10, 15, 30, 0.55);
      backdrop-filter: blur(3px);
      -webkit-backdrop-filter: blur(3px);
      z-index: 0;
    }

    .login-wrapper {
      position: relative;
      z-index: 1;
      display: flex;
      width: 900px;
      min-height: 520px;
      border-radius: 16px;
      overflow: hidden;
      box-shadow: 0 32px 80px rgba(0,0,0,0.6);
    }

    /* Panel kiri - background + branding */
    .login-left {
      flex: 1;
      position: relative;
      background: url('<?= base_url('assets/images/bg.webp') ?>') center center / cover no-repeat;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      padding: 40px 32px;
    }
    .login-left::before {
      content: '';
      position: absolute;
      inset: 0;
      background: linear-gradient(160deg, rgba(13,71,161,0.82) 0%, rgba(21,101,192,0.72) 100%);
    }
    .login-left-content {
      position: relative;
      z-index: 1;
      text-align: center;
      color: #fff;
    }
    .login-left-content img {
      width: 90px;
      height: 90px;
      object-fit: contain;
      margin-bottom: 18px;
      filter: drop-shadow(0 4px 12px rgba(0,0,0,0.3));
    }
    .login-left-content h2 {
      font-size: 1.5rem;
      font-weight: 700;
      margin-bottom: 6px;
      letter-spacing: 0.5px;
    }
    .login-left-content p {
      font-size: 0.82rem;
      opacity: 0.85;
      line-height: 1.6;
    }
    .login-left-content .divider {
      width: 40px;
      height: 3px;
      background: rgba(255,255,255,0.5);
      border-radius: 2px;
      margin: 14px auto;
    }

    /* Panel kanan - form */
    .login-right {
      width: 360px;
      background: #fff;
      display: flex;
      flex-direction: column;
      justify-content: center;
      padding: 40px 36px;
    }
    .login-right h4 {
      font-size: 1.15rem;
      font-weight: 700;
      color: #1a1f2e;
      margin-bottom: 4px;
    }
    .login-right .subtitle {
      font-size: 0.82rem;
      color: #6c757d;
      margin-bottom: 28px;
    }
    .form-label {
      font-size: 0.75rem;
      font-weight: 700;
      color: #6c757d;
      letter-spacing: 0.5px;
      text-transform: uppercase;
      margin-bottom: 5px;
      display: block;
    }
    .input-group-text {
      background: #f8f9fa;
      border-right: none;
      color: #adb5bd;
    }
    .form-control {
      border-left: none;
      font-size: 0.9rem;
    }
    .form-control:focus {
      box-shadow: none;
      border-color: #ced4da;
    }
    .input-group-append .input-group-text {
      border-left: none;
      cursor: pointer;
    }
    .btn-login {
      background: #1565c0;
      border: none;
      font-weight: 600;
      font-size: 0.9rem;
      padding: 10px;
      border-radius: 6px;
      transition: background 0.2s;
    }
    .btn-login:hover { background: #0d47a1; }
    .login-footer-text {
      text-align: center;
      font-size: 0.75rem;
      color: #adb5bd;
      margin-top: 24px;
    }
    .alert {
      border-radius: 6px;
      font-size: 0.85rem;
      padding: 10px 14px;
    }

    @media (max-width: 680px) {
      .login-wrapper { flex-direction: column; width: 94%; min-height: auto; }
      .login-left { padding: 32px 24px; min-height: 200px; }
      .login-right { width: 100%; padding: 32px 28px; }
    }
  </style>
</head>
<body>

<div class="login-wrapper">

  <!-- Kiri: Background + Branding -->
  <div class="login-left">
    <div class="login-left-content">
      <img src="<?= base_url('assets/images/logo-pemda.png') ?>" alt="Logo Pemda">
      <h2>SIMDIS</h2>
      <div class="divider"></div>
      <p>Sistem Monitoring Distribusi<br>Surat Internal<br>Dinas Pendidikan Provinsi Papua</p>
    </div>
  </div>

  <!-- Kanan: Form Login -->
  <div class="login-right">
    <h4>Selamat Datang</h4>
    <p class="subtitle">Masuk untuk melanjutkan ke sistem</p>

    <?php if ($this->session->flashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show mb-3">
      <i class="fas fa-exclamation-circle mr-1"></i>
      <?= $this->session->flashdata('error') ?>
      <button type="button" class="close py-2" data-dismiss="alert"><span>&times;</span></button>
    </div>
    <?php endif; ?>

    <form action="<?= base_url('Auth/login') ?>" method="post">
      <div class="form-group mb-3">
        <label class="form-label">Username</label>
        <div class="input-group">
          <div class="input-group-prepend">
            <span class="input-group-text"><i class="fas fa-user fa-sm"></i></span>
          </div>
          <input type="text" name="username" class="form-control" placeholder="Masukkan username" required autofocus>
        </div>
      </div>

      <div class="form-group mb-4">
        <label class="form-label">Password</label>
        <div class="input-group">
          <div class="input-group-prepend">
            <span class="input-group-text"><i class="fas fa-lock fa-sm"></i></span>
          </div>
          <input type="password" name="password" id="password" class="form-control" placeholder="Masukkan password" required>
          <div class="input-group-append">
            <span class="input-group-text" onclick="togglePass()">
              <i class="fas fa-eye fa-sm text-muted" id="eyeIcon"></i>
            </span>
          </div>
        </div>
      </div>

      <button type="submit" name="btnlogin" class="btn btn-login btn-block text-white">
        <i class="fas fa-sign-in-alt mr-1"></i> Masuk
      </button>
    </form>

    <div class="text-center mt-3">
      <a href="<?= base_url('/') ?>" class="btn btn-outline-secondary btn-block" style="font-size:0.85rem;border-radius:6px">
        <i class="fas fa-arrow-left mr-1"></i> Kembali ke Website
      </a>
    </div>

    <div class="login-footer-text">
      &copy; <?= date('Y') ?> Dinas Pendidikan Provinsi Papua
    </div>
  </div>

</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
function togglePass() {
  var p = document.getElementById('password');
  var i = document.getElementById('eyeIcon');
  if (p.type === 'password') {
    p.type = 'text';
    i.classList.replace('fa-eye', 'fa-eye-slash');
  } else {
    p.type = 'password';
    i.classList.replace('fa-eye-slash', 'fa-eye');
  }
}
</script>
</body>
</html>
