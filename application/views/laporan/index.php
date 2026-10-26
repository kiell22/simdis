<!-- Filter -->
<div class="card mb-3">
  <div class="card-body py-3">
    <form method="get" action="<?= base_url('Laporan') ?>">
      <div class="row align-items-end">
        <div class="col-md-3 mb-2 mb-md-0">
          <label class="small font-weight-bold text-muted">KATA KUNCI</label>
          <div class="input-group input-group-sm">
            <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-search"></i></span></div>
            <input type="text" name="keyword" class="form-control" placeholder="No. surat / perihal..." value="<?= $filter['keyword'] ?>">
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
          <label class="small font-weight-bold text-muted">TGL DARI</label>
          <input type="date" name="tgl_dari" class="form-control form-control-sm" value="<?= $filter['tgl_dari'] ?>">
        </div>
        <div class="col-md-2 mb-2 mb-md-0">
          <label class="small font-weight-bold text-muted">TGL SAMPAI</label>
          <input type="date" name="tgl_sampai" class="form-control form-control-sm" value="<?= $filter['tgl_sampai'] ?>">
        </div>
        <div class="col-md-3">
          <div class="d-flex">
            <button type="submit" class="btn btn-primary btn-sm mr-2">
              <i class="fas fa-filter mr-1"></i>Filter
            </button>
            <?php if (array_filter($filter)): ?>
            <a href="<?= base_url('Laporan') ?>" class="btn btn-secondary btn-sm mr-2">
              <i class="fas fa-times mr-1"></i>Reset
            </a>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Ringkasan stat -->
<div class="row mb-3">
  <?php
  $stat_labels = ['baru'=>'Baru','disposisi'=>'Disposisi','distribusi'=>'Distribusi','diterima'=>'Diterima','diproses'=>'Diproses','selesai'=>'Selesai'];
  $stat_colors = ['baru'=>'primary','disposisi'=>'warning','distribusi'=>'purple','diterima'=>'success','diproses'=>'info','selesai'=>'success'];
  foreach ($stat_labels as $key => $label):
  ?>
  <div class="col-6 col-md-2 mb-2">
    <div class="small-box bg-<?= $stat_colors[$key] ?> mb-0" style="border-radius:8px">
      <div class="inner py-2 px-3">
        <h4 class="mb-0"><?= $stat[$key] ?? 0 ?></h4>
        <p class="mb-0" style="font-size:0.78rem"><?= $label ?></p>
      </div>
    </div>
  </div>
  <?php endforeach; ?>
</div>

<!-- Tabel Laporan -->
<div class="card">
  <div class="card-header">
    <h3 class="card-title">
      <i class="fas fa-file-alt mr-2"></i>Laporan Surat
      <span class="badge badge-primary ml-1"><?= count($surat) ?></span>
    </h3>
  </div>
  <div class="card-body p-0">
    <?php if (empty($surat)): ?>
    <div class="text-center text-muted py-5">
      <i class="fas fa-file-alt fa-2x mb-2 d-block text-light"></i>
      Tidak ada data laporan
    </div>
    <?php else: ?>
    <div class="table-responsive">
      <table class="table table-hover mb-0" id="tbl-laporan">
        <thead class="thead-light">
          <tr>
            <th width="4%">#</th>
            <th width="11%">No. Agenda</th>
            <th width="12%">No. Surat</th>
            <th>Perihal</th>
            <th width="13%">Asal Surat</th>
            <th width="10%">Tgl Terima</th>
            <th width="8%">Sifat</th>
            <th width="10%">Status</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($surat as $i => $s): ?>
          <tr style="cursor:pointer" onclick="window.location='<?= base_url('Surat/detail/'.$s->id_surat) ?>'">
            <td class="text-muted"><?= $i + 1 ?></td>
            <td><span class="badge badge-secondary small"><?= $s->no_agenda ?></span></td>
            <td class="small text-muted"><?= $s->no_surat ?></td>
            <td>
              <div class="font-weight-bold" style="font-size:0.875rem"><?= character_limiter($s->perihal, 50) ?></div>
              <div class="text-muted small"><?= $s->input_oleh ?></div>
            </td>
            <td class="small"><?= $s->asal_surat ?></td>
            <td class="small text-muted"><?= date('d M Y', strtotime($s->tgl_terima)) ?></td>
            <td>
              <?php $sc = ['rahasia'=>'danger','segera'=>'warning','penting'=>'info','biasa'=>'secondary']; ?>
              <span class="badge badge-<?= $sc[$s->sifat] ?? 'secondary' ?>"><?= ucfirst($s->sifat) ?></span>
            </td>
            <td>
              <span class="badge badge-status badge-status-<?= $s->status ?>"><?= ucfirst($s->status) ?></span>
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
  if ($("#tbl-laporan").length) {
    $("#tbl-laporan").DataTable({
      language: { url: "https://cdn.datatables.net/plug-ins/1.13.6/i18n/id.json" },
      pageLength: 10,
      order: [[5, "desc"]],
      dom: "<\"row align-items-center mb-2\"<\"col-sm-6\"l><\"col-sm-6\"f>><\"t\"><\"row mt-2\"<\"col-sm-5\"i><\"col-sm-7\"p>>"
    });
  }
});
</script>'; ?>
