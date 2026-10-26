<!-- Filter -->
<div class="card mb-3">
  <div class="card-body py-3">
    <form method="get" action="<?= base_url('Surat') ?>">
      <div class="row align-items-end">
        <div class="col-md-3 mb-2 mb-md-0">
          <label class="small font-weight-bold text-muted">KATA KUNCI</label>
          <div class="input-group input-group-sm">
            <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-search"></i></span></div>
            <input type="text" name="keyword" class="form-control" placeholder="No. surat / perihal / asal..." value="<?= $filter['keyword'] ?>">
          </div>
        </div>
        <div class="col-md-2 mb-2 mb-md-0">
          <label class="small font-weight-bold text-muted">STATUS</label>
          <select name="status" class="form-control form-control-sm">
            <option value="">Semua Status</option>
            <?php foreach (['baru','disposisi','distribusi','diterima','diproses','selesai'] as $s): ?>
            <option value="<?= $s ?>" <?= $filter['status'] == $s ? 'selected' : '' ?>><?= ucfirst($s) ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="col-md-2 mb-2 mb-md-0">
          <label class="small font-weight-bold text-muted">BIDANG</label>
          <select name="id_bidang" class="form-control form-control-sm">
            <option value="">Semua Bidang</option>
            <?php foreach ($bidang as $b): ?>
            <option value="<?= $b->id_bidang ?>" <?= $filter['id_bidang'] == $b->id_bidang ? 'selected' : '' ?>><?= $b->nama_bidang ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="col-md-2 mb-2 mb-md-0">
          <label class="small font-weight-bold text-muted">TGL DARI</label>
          <input type="date" name="tgl_dari" class="form-control form-control-sm" value="<?= $filter['tgl_dari'] ?>">
        </div>
        <div class="col-md-2 mb-2 mb-md-0">
          <label class="small font-weight-bold text-muted">TGL SAMPAI</label>
          <input type="date" name="tgl_sampai" class="form-control form-control-sm" value="<?= $filter['tgl_sampai'] ?>">
        </div>
        <div class="col-md-1">
          <button type="submit" class="btn btn-primary btn-sm btn-block">
            <i class="fas fa-filter"></i>
          </button>
        </div>
      </div>
      <?php if (array_filter($filter)): ?>
      <div class="mt-2">
        <a href="<?= base_url('Surat') ?>" class="btn btn-sm btn-outline-secondary">
          <i class="fas fa-times mr-1"></i>Reset Filter
        </a>
        <span class="small text-muted ml-2">Menampilkan <?= count($surat) ?> surat</span>
      </div>
      <?php endif; ?>
    </form>
  </div>
</div>

<!-- Tabel Surat -->
<div class="card">
  <div class="card-header bg-white d-flex justify-content-between align-items-center">
    <h6 class="font-weight-bold text-dark mb-0">
      <i class="fas fa-envelope mr-2 text-primary"></i>Daftar Surat
      <span class="badge badge-primary ml-1"><?= count($surat) ?></span>
    </h6>
    <?php if (in_array($user->role, ['admin','sepri'])): ?>
    <a href="<?= base_url('Surat/tambah') ?>" class="btn btn-primary btn-sm">
      <i class="fas fa-plus mr-1"></i> Catat Surat Baru
    </a>
    <?php endif; ?>
  </div>
  <div class="card-body p-0">
    <?php if (empty($surat)): ?>
    <div class="text-center py-5 text-muted">
      <i class="fas fa-inbox fa-3x mb-3 d-block text-light"></i>
      Tidak ada surat ditemukan
    </div>
    <?php else: ?>
    <div class="table-responsive">
      <table class="table table-hover mb-0" id="tbl-surat">
        <thead class="thead-light">
          <tr>
            <th width="5%">#</th>
            <th width="12%">No. Agenda</th>
            <th width="12%">No. Surat</th>
            <th>Perihal</th>
            <th width="12%">Asal Surat</th>
            <th width="10%">Tgl Terima</th>
            <th width="8%">Sifat</th>
            <th width="10%">Status</th>
            <th width="10%">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($surat as $i => $s): ?>
          <tr>
            <td class="text-muted small"><?= $i+1 ?></td>
            <td><span class="badge badge-secondary small"><?= $s->no_agenda ?></span></td>
            <td class="small text-muted"><?= $s->no_surat ?></td>
            <td>
              <div class="font-weight-bold text-dark" style="font-size:0.875rem"><?= character_limiter($s->perihal, 50) ?></div>
              <div class="text-muted small"><i class="fas fa-user mr-1"></i><?= $s->input_oleh ?></div>
            </td>
            <td class="small"><?= $s->asal_surat ?></td>
            <td class="small text-muted"><?= date('d M Y', strtotime($s->tgl_terima)) ?></td>
            <td>
              <?php $sifat_class = ['rahasia'=>'danger','segera'=>'warning','penting'=>'info','biasa'=>'secondary']; ?>
              <span class="badge badge-<?= $sifat_class[$s->sifat] ?? 'secondary' ?>"><?= ucfirst($s->sifat) ?></span>
            </td>
            <td>
              <span class="badge badge-status badge-status-<?= $s->status ?>"><?= ucfirst($s->status) ?></span>
            </td>
            <td class="text-nowrap">
              <a href="<?= base_url('Surat/detail/'.$s->id_surat) ?>" class="btn btn-info btn-sm" title="Detail">
                <i class="fas fa-eye"></i>
              </a>
              <?php if ($s->file_surat): ?>
              <a href="<?= base_url('Surat/lihat_pdf/'.$s->id_surat) ?>" target="_blank" class="btn btn-secondary btn-sm" title="Lihat PDF">
                <i class="fas fa-file-pdf"></i>
              </a>
              <?php endif; ?>
              <?php if (in_array($user->role, ['admin','sepri'])): ?>
              <a href="<?= base_url('Surat/edit/'.$s->id_surat) ?>" class="btn btn-warning btn-sm" title="Edit">
                <i class="fas fa-edit"></i>
              </a>
              <?php endif; ?>
              <button onclick="konfirmasiHapus('<?= base_url('Surat/hapus/'.$s->id_surat) ?>','<?= addslashes($s->perihal) ?>')"
                      class="btn btn-danger btn-sm" title="Hapus">
                <i class="fas fa-trash"></i>
              </button>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
    <?php endif; ?>
  </div>
</div>

<?php $extra_js = '
<script>
$(document).ready(function() {
  if ($("#tbl-surat").length) {
    $("#tbl-surat").DataTable({
      language: { url: "https://cdn.datatables.net/plug-ins/1.13.6/i18n/id.json" },
      pageLength: 10,
      order: [[5, "desc"]],
      columnDefs: [{ orderable: false, targets: 8 }],
      dom: "<\"row align-items-center mb-2\"<\"col-sm-6\"l><\"col-sm-6\"f>><\"t\"><\"row mt-2\"<\"col-sm-5\"i><\"col-sm-7\"p>>"
    });
  }
});
</script>'; ?>
