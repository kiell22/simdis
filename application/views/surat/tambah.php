<div class="row justify-content-center">
  <div class="col-lg-9">
    <div class="card">
      <div class="card-header bg-white">
        <h6 class="font-weight-bold text-dark mb-0">
          <i class="fas fa-plus-circle mr-2 text-primary"></i>Form Pencatatan Surat Baru
        </h6>
      </div>
      <div class="card-body">
        <form action="<?= base_url('Surat/tambah') ?>" method="post" enctype="multipart/form-data">

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="font-weight-bold small">No. Surat <span class="text-danger">*</span></label>
                <input type="text" name="no_surat" class="form-control" placeholder="Contoh: 421/001/2024" required value="<?= set_value('no_surat') ?>">
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label class="font-weight-bold small">Tanggal Surat <span class="text-danger">*</span></label>
                <input type="date" name="tgl_surat" class="form-control" required value="<?= set_value('tgl_surat') ?>">
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label class="font-weight-bold small">Tanggal Terima <span class="text-danger">*</span></label>
                <input type="date" name="tgl_terima" class="form-control" required value="<?= date('Y-m-d') ?>">
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="font-weight-bold small">Asal Surat <span class="text-danger">*</span></label>
                <input type="text" name="asal_surat" class="form-control" placeholder="Instansi/nama pengirim" required value="<?= set_value('asal_surat') ?>">
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label class="font-weight-bold small">Sifat Surat <span class="text-danger">*</span></label>
                <select name="sifat" class="form-control" required>
                  <?php foreach (['biasa'=>'Biasa','penting'=>'Penting','segera'=>'Segera','rahasia'=>'Rahasia'] as $v => $l): ?>
                  <option value="<?= $v ?>" <?= set_select('sifat', $v, $v=='biasa') ?>><?= $l ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label class="font-weight-bold small">Jenis Surat <span class="text-danger">*</span></label>
                <select name="jenis_surat" class="form-control" required>
                  <option value="masuk" <?= set_select('jenis_surat','masuk',true) ?>>Surat Masuk</option>
                  <option value="keluar" <?= set_select('jenis_surat','keluar') ?>>Surat Keluar</option>
                </select>
              </div>
            </div>
          </div>

          <div class="form-group">
            <label class="font-weight-bold small">Perihal <span class="text-danger">*</span></label>
            <textarea name="perihal" class="form-control" rows="3" placeholder="Isi perihal surat..." required><?= set_value('perihal') ?></textarea>
          </div>

          <div class="row">
            <div class="col-md-8">
              <div class="form-group">
                <label class="font-weight-bold small">File Surat (PDF, maks. 10MB)</label>
                <input type="file" name="file_surat" id="fileSurat" accept=".pdf" class="form-control-file mt-1">
                <small class="text-muted">Format: PDF. Maksimal 10MB</small>
                <div class="mt-1"><small id="namaFileSurat" class="text-primary font-weight-bold"></small></div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label class="font-weight-bold small">Keterangan</label>
                <input type="text" name="keterangan" class="form-control" placeholder="Opsional" value="<?= set_value('keterangan') ?>">
              </div>
            </div>
          </div>

          <hr>
          <div class="d-flex justify-content-between">
            <a href="<?= base_url('Surat') ?>" class="btn btn-secondary">
              <i class="fas fa-arrow-left mr-1"></i> Kembali
            </a>
            <button type="submit" name="btnsimpan" class="btn btn-primary">
              <i class="fas fa-save mr-1"></i> Simpan Surat
            </button>
          </div>

        </form>
      </div>
    </div>
  </div>
</div>

<?php $extra_js = '<script>
$("#fileSurat").on("change", function() {
  var name = $(this).val().split("\\\\").pop() || $(this).val().split("/").pop();
  $("#namaFileSurat").text(name || "Belum ada file dipilih");
});
</script>'; ?>
