<div class="row">
  <!-- Kolom Foto & Info Singkat -->
  <div class="col-md-4">
    <div class="card card-primary card-outline">
      <div class="card-body text-center pt-4">
        <img src="<?= base_url('uploads/foto/'.($pengguna->foto ?? 'default.png')) ?>"
             class="rounded-circle mb-3" width="100" height="100" style="object-fit:cover;border:3px solid #dee2e6"
             onerror="this.src='https://ui-avatars.com/api/?name=<?= urlencode($pengguna->nama_lengkap) ?>&background=1565c0&color=fff&size=100'">
        <h5 class="font-weight-bold mb-0"><?= $pengguna->nama_lengkap ?></h5>
        <p class="text-muted small mb-2"><?= $pengguna->jabatan ?: '-' ?></p>
        <?php
        $role_badge = ['admin'=>'danger','sepri'=>'info','kadis'=>'primary','bidang_umum'=>'warning','kepala_bidang'=>'success'];
        $rc = $role_badge[$pengguna->role] ?? 'secondary';
        ?>
        <span class="badge badge-<?= $rc ?> mb-3"><?= ucfirst(str_replace('_', ' ', $pengguna->role)) ?></span>
        <hr>
        <form method="post" action="<?= base_url('Pengguna/upload_foto') ?>" enctype="multipart/form-data">
          <div class="form-group">
            <div class="custom-file text-left">
              <input type="file" class="custom-file-input" name="foto" id="inputFoto" accept="image/*">
              <label class="custom-file-label" for="inputFoto">Pilih foto...</label>
            </div>
            <small class="text-muted">JPG/PNG, maks 2MB</small>
          </div>
          <button type="submit" class="btn btn-primary btn-sm btn-block">
            <i class="fas fa-upload mr-1"></i> Ganti Foto
          </button>
        </form>
      </div>
    </div>
  </div>

  <!-- Kolom Form -->
  <div class="col-md-8">
    <!-- Informasi Akun -->
    <div class="card">
      <div class="card-header">
        <h3 class="card-title"><i class="fas fa-user-circle mr-2"></i>Informasi Akun</h3>
      </div>
      <div class="card-body">
        <form method="post" action="<?= base_url('Pengguna/update_profil') ?>">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="font-weight-bold small">Nama Lengkap</label>
                <input type="text" name="nama_lengkap" class="form-control" value="<?= $pengguna->nama_lengkap ?>" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="font-weight-bold small">Jabatan</label>
                <input type="text" name="jabatan" class="form-control" value="<?= $pengguna->jabatan ?>">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="font-weight-bold small">Email</label>
                <input type="email" name="email" class="form-control" value="<?= $pengguna->email ?>">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="font-weight-bold small">No. Telepon</label>
                <input type="text" name="telp" class="form-control" value="<?= $pengguna->telp ?>">
              </div>
            </div>
          </div>
          <button type="submit" class="btn btn-primary">
            <i class="fas fa-save mr-1"></i> Simpan Perubahan
          </button>
        </form>
      </div>
    </div>

    <!-- Ganti Password -->
    <div class="card">
      <div class="card-header">
        <h3 class="card-title"><i class="fas fa-lock mr-2"></i>Ganti Password</h3>
      </div>
      <div class="card-body">
        <form method="post" action="<?= base_url('Pengguna/ganti_password') ?>">
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label class="font-weight-bold small">Password Lama</label>
                <input type="password" name="password_lama" class="form-control" required>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label class="font-weight-bold small">Password Baru</label>
                <input type="password" name="password_baru" class="form-control" required>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label class="font-weight-bold small">Konfirmasi Password</label>
                <input type="password" name="konfirmasi" class="form-control" required>
              </div>
            </div>
          </div>
          <button type="submit" class="btn btn-warning">
            <i class="fas fa-key mr-1"></i> Ganti Password
          </button>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
$('.custom-file-input').on('change', function() {
  var name = $(this).val().split('\\').pop();
  $(this).next('.custom-file-label').html(name || 'Pilih foto...');
});
</script>
