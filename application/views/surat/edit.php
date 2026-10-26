<div class="row justify-content-center">
  <div class="col-lg-9">
    <div class="card">
      <div class="card-header bg-white">
        <h6 class="font-weight-bold text-dark mb-0">
          <i class="fas fa-edit mr-2 text-warning"></i>Edit Surat - <?= $surat->no_agenda ?>
        </h6>
      </div>
      <div class="card-body">
        <form action="<?= base_url('Surat/edit/'.$surat->id_surat) ?>" method="post" enctype="multipart/form-data">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="font-weight-bold small">No. Surat <span class="text-danger">*</span></label>
                <input type="text" name="no_surat" class="form-control" required value="<?= $surat->no_surat ?>">
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label class="font-weight-bold small">Tanggal Surat</label>
                <input type="date" name="tgl_surat" class="form-control" required value="<?= $surat->tgl_surat ?>">
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label class="font-weight-bold small">Tanggal Terima</label>
                <input type="date" name="tgl_terima" class="form-control" required value="<?= $surat->tgl_terima ?>">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="font-weight-bold small">Asal Surat</label>
                <input type="text" name="asal_surat" class="form-control" required value="<?= $surat->asal_surat ?>">
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label class="font-weight-bold small">Sifat Surat</label>
                <select name="sifat" class="form-control">
                  <?php foreach (['biasa'=>'Biasa','penting'=>'Penting','segera'=>'Segera','rahasia'=>'Rahasia'] as $v => $l): ?>
                  <option value="<?= $v ?>" <?= $surat->sifat==$v?'selected':'' ?>><?= $l ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label class="font-weight-bold small">Keterangan</label>
                <input type="text" name="keterangan" class="form-control" value="<?= $surat->keterangan ?>">
              </div>
            </div>
          </div>
          <div class="form-group">
            <label class="font-weight-bold small">Perihal</label>
            <textarea name="perihal" class="form-control" rows="3" required><?= $surat->perihal ?></textarea>
          </div>
          <div class="form-group">
            <label class="font-weight-bold small">Ganti File PDF (kosongkan jika tidak diganti)</label>
            <?php if ($surat->file_surat): ?>
            <div class="mb-2">
              <a href="<?= base_url('Surat/lihat_pdf/'.$surat->id_surat) ?>" target="_blank" class="btn btn-sm btn-outline-danger">
                <i class="fas fa-file-pdf mr-1"></i>File saat ini: <?= $surat->file_surat ?>
              </a>
            </div>
            <?php endif; ?>
            <input type="file" name="file_surat" id="fileSurat" accept=".pdf" class="form-control-file">
            <small class="text-muted">Format: PDF. Maksimal 10MB</small>
            <div class="mt-1"><small id="namaFileSurat" class="text-primary font-weight-bold"></small></div>
          </div>
          <hr>
          <div class="d-flex justify-content-between">
            <a href="<?= base_url('Surat/detail/'.$surat->id_surat) ?>" class="btn btn-secondary">
              <i class="fas fa-arrow-left mr-1"></i>Kembali
            </a>
            <button type="submit" name="btnupdate" class="btn btn-warning">
              <i class="fas fa-save mr-1"></i>Simpan Perubahan
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
  $("#namaFileSurat").text(name || "");
});
</script>'; ?>
