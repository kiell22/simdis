<div class="card">
  <div class="card-header">
    <h3 class="card-title"><i class="fas fa-sitemap mr-2"></i>Daftar Bidang</h3>
    <div class="card-tools">
      <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalTambah">
        <i class="fas fa-plus mr-1"></i> Tambah Bidang
      </button>
    </div>
  </div>
  <div class="card-body p-0">
    <?php if (empty($bidang)): ?>
    <div class="text-center text-muted py-4">
      <i class="fas fa-sitemap fa-2x mb-2 d-block text-light"></i>
      Belum ada bidang
    </div>
    <?php else: ?>
    <div class="table-responsive">
      <table class="table table-hover mb-0" id="tbl-bidang">
        <thead class="thead-light">
          <tr>
            <th width="5%">#</th>
            <th width="15%">Kode Bidang</th>
            <th>Nama Bidang</th>
            <th>Keterangan</th>
            <th width="10%">Status</th>
            <th width="10%">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($bidang as $i => $b): ?>
          <tr>
            <td class="text-muted"><?= $i + 1 ?></td>
            <td><code><?= $b->kode_bidang ?></code></td>
            <td class="font-weight-bold"><?= $b->nama_bidang ?></td>
            <td class="small text-muted"><?= $b->keterangan ?: '-' ?></td>
            <td>
              <span class="badge badge-<?= $b->aktif ? 'success' : 'danger' ?>">
                <?= $b->aktif ? 'Aktif' : 'Nonaktif' ?>
              </span>
            </td>
            <td>
              <div class="btn-group btn-group-sm">
                <button class="btn btn-warning btn-edit-bidang"
                  data-id="<?= $b->id_bidang ?>"
                  data-kode="<?= htmlspecialchars($b->kode_bidang) ?>"
                  data-nama="<?= htmlspecialchars($b->nama_bidang) ?>"
                  data-ket="<?= htmlspecialchars($b->keterangan) ?>"
                  title="Edit">
                  <i class="fas fa-edit"></i>
                </button>
                <button onclick="konfirmasiHapus('<?= base_url('Bidang/hapus/'.$b->id_bidang) ?>','<?= addslashes($b->nama_bidang) ?>')"
                        class="btn btn-danger" title="Nonaktifkan">
                  <i class="fas fa-trash"></i>
                </button>
              </div>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
    <?php endif; ?>
  </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="modalTambah" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title text-white"><i class="fas fa-sitemap mr-2"></i>Tambah Bidang</h5>
        <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
      </div>
      <form method="post" action="<?= base_url('Bidang/simpan') ?>">
        <div class="modal-body">
          <div class="form-group">
            <label class="font-weight-bold small">Kode Bidang <span class="text-danger">*</span></label>
            <input type="text" name="kode_bidang" class="form-control" placeholder="Contoh: BIDANG-SD" required>
          </div>
          <div class="form-group">
            <label class="font-weight-bold small">Nama Bidang <span class="text-danger">*</span></label>
            <input type="text" name="nama_bidang" class="form-control" placeholder="Nama lengkap bidang" required>
          </div>
          <div class="form-group">
            <label class="font-weight-bold small">Keterangan</label>
            <textarea name="keterangan" class="form-control" rows="2" placeholder="Opsional"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-1"></i>Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="modalEdit" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-warning">
        <h5 class="modal-title"><i class="fas fa-edit mr-2"></i>Edit Bidang</h5>
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
      </div>
      <form method="post" action="<?= base_url('Bidang/update') ?>">
        <input type="hidden" name="id_bidang" id="editId">
        <div class="modal-body">
          <div class="form-group">
            <label class="font-weight-bold small">Kode Bidang</label>
            <input type="text" name="kode_bidang" id="editKode" class="form-control" required>
          </div>
          <div class="form-group">
            <label class="font-weight-bold small">Nama Bidang</label>
            <input type="text" name="nama_bidang" id="editNama" class="form-control" required>
          </div>
          <div class="form-group">
            <label class="font-weight-bold small">Keterangan</label>
            <textarea name="keterangan" id="editKet" class="form-control" rows="2"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-warning"><i class="fas fa-save mr-1"></i>Update</button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php $extra_js = '<script>
document.addEventListener("DOMContentLoaded", function() {
  if (typeof $ === "undefined") return;
  if ($.fn.DataTable && !$.fn.DataTable.isDataTable("#tbl-bidang")) {
    $("#tbl-bidang").DataTable({
      language: { url: "https://cdn.datatables.net/plug-ins/1.13.6/i18n/id.json" },
      pageLength: 10,
      columnDefs: [{ orderable: false, targets: 5 }],
      dom: "<\"row align-items-center mb-2\"<\"col-sm-6\"l><\"col-sm-6\"f>><\"t\"><\"row mt-2\"<\"col-sm-5\"i><\"col-sm-7\"p>>"
    });
  }
  $(document).on("click", ".btn-edit-bidang", function() {
    var btn = $(this);
    $("#editId").val(btn.attr("data-id"));
    $("#editKode").val(btn.attr("data-kode"));
    $("#editNama").val(btn.attr("data-nama"));
    $("#editKet").val(btn.attr("data-ket"));
    $("#modalEdit").modal("show");
  });
});
</script>'; ?>
