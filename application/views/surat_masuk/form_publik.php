<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Form Surat Masuk | Dinas Pendidikan Provinsi Papua</title>
  <link rel="icon" type="image/png" href="<?= base_url('assets/images/logo-pemda.png') ?>">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <style>
    body {
      background: url('<?= base_url('assets/images/bg1.webp') ?>') center center / cover no-repeat fixed;
      min-height: 100vh;
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
    .page-wrap {
      position: relative;
      z-index: 1;
      padding: 30px 15px 50px;
    }
    .header-bar {
      background: rgba(21,101,192,0.92);
      backdrop-filter: blur(8px);
      border-radius: 12px;
      padding: 20px 28px;
      margin-bottom: 24px;
      display: flex;
      align-items: center;
      gap: 16px;
      box-shadow: 0 4px 20px rgba(0,0,0,0.3);
    }
    .header-bar img { width: 56px; height: 56px; object-fit: contain; }
    .header-bar h4 { color: #fff; font-weight: 700; margin: 0; font-size: 1.1rem; }
    .header-bar p  { color: rgba(255,255,255,0.8); margin: 0; font-size: 0.82rem; }
    .card-form {
      background: #fff;
      border-radius: 12px;
      box-shadow: 0 8px 32px rgba(0,0,0,0.25);
      border: none;
    }
    .card-form .card-header {
      background: #1565c0;
      color: #fff;
      border-radius: 12px 12px 0 0;
      padding: 14px 24px;
      font-weight: 700;
    }
    .section-title {
      font-size: 0.72rem;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 1px;
      color: #1565c0;
      border-bottom: 2px solid #e3f2fd;
      padding-bottom: 6px;
      margin-bottom: 16px;
      margin-top: 8px;
    }
    .form-label { font-size: 0.82rem; font-weight: 600; color: #495057; }
    .required { color: #dc3545; }
    .btn-submit {
      background: #1565c0;
      border: none;
      padding: 12px 32px;
      font-weight: 700;
      font-size: 0.95rem;
      border-radius: 8px;
      transition: background 0.2s;
    }
    .btn-submit:hover { background: #0d47a1; }
    .cek-status-link {
      background: rgba(255,255,255,0.12);
      border: 1px solid rgba(255,255,255,0.3);
      border-radius: 8px;
      padding: 12px 20px;
      color: #fff;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 8px;
      font-size: 0.85rem;
      transition: background 0.2s;
    }
    .cek-status-link:hover { background: rgba(255,255,255,0.2); color: #fff; text-decoration: none; }
  </style>
</head>
<body>
<div class="page-wrap">
  <div class="container" style="max-width:780px">

    <!-- Header -->
    <div class="header-bar">
      <img src="<?= base_url('assets/images/logo-pemda.png') ?>" alt="Logo"
           onerror="this.style.display='none'">
      <div class="flex-grow-1">
        <h4>Form Pengiriman Surat Masuk</h4>
        <p>Dinas Pendidikan Provinsi Papua &mdash; Silakan isi form di bawah untuk mengirimkan surat Anda</p>
      </div>
      <a href="<?= base_url('surat-masuk/cek-status') ?>" class="cek-status-link d-none d-md-flex">
        <i class="fas fa-search"></i> Cek Status Surat
      </a>
    </div>

    <?php if ($this->session->flashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show">
      <i class="fas fa-exclamation-circle mr-2"></i><?= $this->session->flashdata('error') ?>
      <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
    </div>
    <?php endif; ?>

    <div class="card card-form">
      <div class="card-header">
        <i class="fas fa-envelope-open-text mr-2"></i>Data Surat Masuk
      </div>
      <div class="card-body p-4">
        <form action="<?= base_url('surat-masuk/kirim') ?>" method="post" enctype="multipart/form-data">

          <!-- Data Pengirim -->
          <div class="section-title"><i class="fas fa-user mr-1"></i>Data Pengirim</div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="form-label">Nama Lengkap <span class="required">*</span></label>
                <input type="text" name="nama_pengirim" class="form-control" placeholder="Nama lengkap pengirim" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="form-label">Instansi / Kantor <span class="required">*</span></label>
                <input type="text" name="instansi_pengirim" class="form-control" placeholder="Nama instansi/kantor" required>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label class="form-label">NIP</label>
                <input type="text" name="nip_pengirim" class="form-control" placeholder="NIP pengirim (opsional)">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label class="form-label">No. HP / Telepon</label>
                <input type="text" name="no_hp" class="form-control" placeholder="08xxxxxxxxxx">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label class="form-label">Email</label>
                <input type="email" name="email_pengirim" class="form-control" placeholder="email@instansi.go.id">
              </div>
            </div>
          </div>

          <!-- Data Surat -->
          <div class="section-title mt-3"><i class="fas fa-file-alt mr-1"></i>Data Surat</div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="form-label">Nomor Surat <span class="required">*</span></label>
                <input type="text" name="no_surat" class="form-control" placeholder="Contoh: 001/DINAS/VIII/2026" required>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label class="form-label">Tanggal Surat <span class="required">*</span></label>
                <input type="date" name="tgl_surat" class="form-control" required>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label class="form-label">Sifat Surat</label>
                <select name="sifat" class="form-control">
                  <option value="biasa">Biasa</option>
                  <option value="penting">Penting</option>
                  <option value="segera">Segera</option>
                  <option value="rahasia">Rahasia</option>
                </select>
              </div>
            </div>
            <div class="col-12">
              <div class="form-group">
                <label class="form-label">Perihal / Isi Surat <span class="required">*</span></label>
                <textarea name="perihal" class="form-control" rows="3" placeholder="Jelaskan perihal surat secara singkat dan jelas..." required></textarea>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="form-label">Upload File Surat (PDF, maks 10MB)</label>
                <div class="custom-file">
                  <input type="file" class="custom-file-input" name="file_surat" id="fileSurat" accept=".pdf">
                  <label class="custom-file-label" for="fileSurat">Pilih file PDF...</label>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="form-label">Keterangan Tambahan</label>
                <input type="text" name="keterangan" class="form-control" placeholder="Opsional">
              </div>
            </div>
          </div>

          <hr>
          <div class="d-flex justify-content-between align-items-center">
            <small class="text-muted"><span class="required">*</span> Wajib diisi</small>
            <button type="submit" class="btn btn-submit text-white">
              <i class="fas fa-paper-plane mr-2"></i>Kirim Surat
            </button>
          </div>
        </form>
      </div>
    </div>

    <div class="text-center mt-3">
      <a href="<?= base_url('surat-masuk/cek-status') ?>" class="cek-status-link d-inline-flex d-md-none">
        <i class="fas fa-search"></i> Cek Status Surat
      </a>
    </div>

  </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
$('.custom-file-input').on('change', function() {
  var name = $(this).val().split('\\').pop();
  $(this).next('.custom-file-label').html(name || 'Pilih file PDF...');
});
</script>
</body>
</html>
