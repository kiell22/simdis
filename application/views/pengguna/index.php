<div class="card">
  <div class="card-header">
    <h3 class="card-title"><i class="fas fa-users mr-2"></i>Daftar Pengguna</h3>
    <div class="card-tools">
      <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalTambah">
        <i class="fas fa-plus mr-1"></i> Tambah Pengguna
      </button>
    </div>
  </div>
  <div class="card-body p-0">
    <?php if (empty($pengguna)): ?>
    <div class="text-center text-muted py-4">
      <i class="fas fa-users fa-2x mb-2 d-block text-light"></i>
      Belum ada pengguna
    </div>
    <?php else: ?>
    <div class="table-responsive">
      <table class="table table-hover mb-0" id="tbl-pengguna">
        <thead class="thead-light">
          <tr>
            <th width="4%">#</th>
            <th>Nama</th>
            <th>Username</th>
            <th>Jabatan</th>
            <th>Role</th>
            <th>Bidang</th>
            <th>Status</th>
            <th>Terakhir Login</th>
            <th width="10%">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($pengguna as $i => $p): ?>
          <tr>
            <td class="text-muted"><?= $i + 1 ?></td>
            <td>
              <div class="d-flex align-items-center">
                <img src="<?= base_url('uploads/foto/'.($p->foto ?? 'default.png')) ?>"
                     class="rounded-circle mr-2" width="32" height="32" style="object-fit:cover"
                     onerror="this.src='https://ui-avatars.com/api/?name=<?= urlencode($p->nama_lengkap) ?>&background=1565c0&color=fff&size=32'">
                <span class="font-weight-bold"><?= $p->nama_lengkap ?></span>
              </div>
            </td>
            <td><code><?= $p->username ?></code></td>
            <td class="small text-muted"><?= $p->jabatan ?: '-' ?></td>
            <td>
              <?php $role_badge = ['admin'=>'danger','sepri'=>'info','kadis'=>'primary','bidang_umum'=>'warning','kepala_bidang'=>'success']; ?>
              <span class="badge badge-<?= $role_badge[$p->role] ?? 'secondary' ?>"><?= ucfirst(str_replace('_', ' ', $p->role)) ?></span>
            </td>
            <td class="small"><?= $p->nama_bidang ?: '-' ?></td>
            <td>
              <span class="badge badge-<?= $p->aktif ? 'success' : 'danger' ?>">
                <?= $p->aktif ? 'Aktif' : 'Nonaktif' ?>
              </span>
            </td>
            <td class="small text-muted"><?= $p->terakhir_login ? date('d/m/Y H:i', strtotime($p->terakhir_login)) : '-' ?></td>
            <td>
              <div class="btn-group btn-group-sm">
                <button class="btn btn-warning btn-edit-pengguna"
                  data-id="<?= $p->id_pengguna ?>"
                  data-nama="<?= htmlspecialchars($p->nama_lengkap) ?>"
                  data-username="<?= $p->username ?>"
                  data-jabatan="<?= htmlspecialchars($p->jabatan) ?>"
                  data-role="<?= $p->role ?>"
                  data-bidang="<?= $p->id_bidang ?>"
                  data-email="<?= htmlspecialchars($p->email) ?>"
                  data-telp="<?= htmlspecialchars($p->telp) ?>"
                  title="Edit">
                  <i class="fas fa-edit"></i>
                </button>
                <?php if ($p->id_pengguna != $user->id_pengguna): ?>
                <button onclick="konfirmasiHapus('<?= base_url('Pengguna/hapus/'.$p->id_pengguna) ?>','<?= addslashes($p->nama_lengkap) ?>')"
                        class="btn btn-danger btn-sm" title="Nonaktifkan">
                  <i class="fas fa-user-slash"></i>
                </button>
                <?php endif; ?>
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
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title text-white"><i class="fas fa-user-plus mr-2"></i>Tambah Pengguna</h5>
        <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
      </div>
      <form method="post" action="<?= base_url('Pengguna/simpan') ?>">
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="font-weight-bold small">Nama Lengkap <span class="text-danger">*</span></label>
                <input type="text" name="nama_lengkap" class="form-control" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="font-weight-bold small">Username <span class="text-danger">*</span></label>
                <input type="text" name="username" class="form-control" required>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="font-weight-bold small">Password <span class="text-danger">*</span></label>
                <input type="password" name="password" class="form-control" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="font-weight-bold small">Jabatan</label>
                <input type="text" name="jabatan" class="form-control">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="font-weight-bold small">Role <span class="text-danger">*</span></label>
                <select name="role" class="form-control" required>
                  <option value="sepri">Sepri</option>
                  <option value="kadis">Kepala Dinas</option>
                  <option value="bidang_umum">Bidang Umum</option>
                  <option value="kepala_bidang">Kepala Bidang</option>
                  <option value="admin">Admin</option>
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="font-weight-bold small">Bidang</label>
                <select name="id_bidang" class="form-control">
                  <option value="">-- Pilih Bidang --</option>
                  <?php foreach ($bidang as $b): ?>
                  <option value="<?= $b->id_bidang ?>"><?= $b->nama_bidang ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="font-weight-bold small">Email</label>
                <input type="email" name="email" class="form-control">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="font-weight-bold small">No. Telepon</label>
                <input type="text" name="telp" class="form-control">
              </div>
            </div>
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
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-warning">
        <h5 class="modal-title"><i class="fas fa-user-edit mr-2"></i>Edit Pengguna</h5>
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
      </div>
      <form method="post" action="<?= base_url('Pengguna/update') ?>">
        <input type="hidden" name="id_pengguna" id="editId">
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="font-weight-bold small">Nama Lengkap</label>
                <input type="text" name="nama_lengkap" id="editNama" class="form-control" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="font-weight-bold small">Username</label>
                <input type="text" name="username" id="editUsername" class="form-control" required>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="font-weight-bold small">Password Baru <small class="text-muted">(kosongkan jika tidak diubah)</small></label>
                <input type="password" name="password" class="form-control">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="font-weight-bold small">Jabatan</label>
                <input type="text" name="jabatan" id="editJabatan" class="form-control">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="font-weight-bold small">Role</label>
                <select name="role" id="editRole" class="form-control">
                  <option value="sepri">Sepri</option>
                  <option value="kadis">Kepala Dinas</option>
                  <option value="bidang_umum">Bidang Umum</option>
                  <option value="kepala_bidang">Kepala Bidang</option>
                  <option value="admin">Admin</option>
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="font-weight-bold small">Bidang</label>
                <select name="id_bidang" id="editBidang" class="form-control">
                  <option value="">-- Pilih Bidang --</option>
                  <?php foreach ($bidang as $b): ?>
                  <option value="<?= $b->id_bidang ?>"><?= $b->nama_bidang ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="font-weight-bold small">Email</label>
                <input type="email" name="email" id="editEmail" class="form-control">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="font-weight-bold small">No. Telepon</label>
                <input type="text" name="telp" id="editTelp" class="form-control">
              </div>
            </div>
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
  if ($.fn.DataTable && !$.fn.DataTable.isDataTable("#tbl-pengguna")) {
    $("#tbl-pengguna").DataTable({
      language: { url: "https://cdn.datatables.net/plug-ins/1.13.6/i18n/id.json" },
      pageLength: 10,
      columnDefs: [{ orderable: false, targets: 8 }],
      dom: "<\"row align-items-center mb-2\"<\"col-sm-6\"l><\"col-sm-6\"f>><\"t\"><\"row mt-2\"<\"col-sm-5\"i><\"col-sm-7\"p>>"
    });
  }
  $(document).on("click", ".btn-edit-pengguna", function() {
    var btn = $(this);
    $("#editId").val(btn.attr("data-id"));
    $("#editNama").val(btn.attr("data-nama"));
    $("#editUsername").val(btn.attr("data-username"));
    $("#editJabatan").val(btn.attr("data-jabatan"));
    $("#editRole").val(btn.attr("data-role"));
    $("#editBidang").val(btn.attr("data-bidang"));
    $("#editEmail").val(btn.attr("data-email"));
    $("#editTelp").val(btn.attr("data-telp"));
    $("#modalEdit").modal("show");
  });
});
</script>'; ?>
