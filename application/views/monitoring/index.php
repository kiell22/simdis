<?php
$stat_labels = ['baru'=>'Baru','disposisi'=>'Disposisi','distribusi'=>'Distribusi','diterima'=>'Diterima','diproses'=>'Diproses','selesai'=>'Selesai'];
$stat_colors = ['baru'=>'primary','disposisi'=>'warning','distribusi'=>'purple','diterima'=>'success','diproses'=>'info','selesai'=>'success'];
$stat_icons  = ['baru'=>'inbox','disposisi'=>'pen-nib','distribusi'=>'paper-plane','diterima'=>'check','diproses'=>'cog','selesai'=>'check-double'];
?>

<div class="row mb-3">
  <?php foreach ($stat_labels as $key => $label): ?>
  <div class="col-6 col-md-4 col-lg-2 mb-2">
    <div class="info-box shadow-none border mb-0" style="border-radius:10px">
      <span class="info-box-icon bg-<?= $stat_colors[$key] ?>" style="border-radius:10px 0 0 10px">
        <i class="fas fa-<?= $stat_icons[$key] ?>"></i>
      </span>
      <div class="info-box-content">
        <span class="info-box-text" style="font-size:0.75rem"><?= $label ?></span>
        <span class="info-box-number"><?= $stat[$key] ?? 0 ?></span>
      </div>
    </div>
  </div>
  <?php endforeach; ?>
</div>

<div class="card">
  <div class="card-header">
    <h3 class="card-title"><i class="fas fa-chart-line mr-2"></i>Monitoring Distribusi Surat</h3>
  </div>
  <div class="card-body p-0">
    <?php if (empty($monitoring)): ?>
    <div class="text-center text-muted py-5">
      <i class="fas fa-chart-line fa-2x mb-2 d-block text-light"></i>
      Belum ada data distribusi
    </div>
    <?php else: ?>
    <div class="table-responsive">
      <table class="table table-hover mb-0" id="tbl-monitoring">
        <thead class="thead-light">
          <tr>
            <th width="4%">#</th>
            <th width="13%">No. Surat</th>
            <th>Perihal</th>
            <th width="20%">Bidang Tujuan</th>
            <th width="10%">Tgl Terima</th>
            <th width="14%">Progress</th>
            <th width="10%">Status</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($monitoring as $i => $m): ?>
          <?php
            $total  = $m->total_distribusi ?: 1;
            $done   = $m->sudah_diterima  ?: 0;
            $pct    = $total > 0 ? round(($done / $total) * 100) : 0;
            $pcolor = $pct == 100 ? 'success' : ($pct > 0 ? 'warning' : 'danger');
          ?>
          <tr style="cursor:pointer" onclick="window.location='<?= base_url('Surat/detail/'.$m->id_surat) ?>'">
            <td class="text-muted"><?= $i + 1 ?></td>
            <td><span class="badge badge-secondary small"><?= $m->no_surat ?></span></td>
            <td><div class="font-weight-bold" style="font-size:0.875rem"><?= character_limiter($m->perihal, 55) ?></div></td>
            <td class="small text-muted"><?= $m->bidang_tujuan ?: '-' ?></td>
            <td class="small text-muted"><?= date('d M Y', strtotime($m->tgl_terima)) ?></td>
            <td>
              <div class="d-flex align-items-center">
                <div class="progress flex-grow-1 mr-2" style="height:6px;border-radius:3px">
                  <div class="progress-bar bg-<?= $pcolor ?>" style="width:<?= $pct ?>%"></div>
                </div>
                <small class="text-muted"><?= $done ?>/<?= $total ?></small>
              </div>
            </td>
            <td><span class="badge badge-status badge-status-<?= $m->status ?>"><?= ucfirst($m->status) ?></span></td>
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
  if ($("#tbl-monitoring").length) {
    $("#tbl-monitoring").DataTable({
      language: { url: "https://cdn.datatables.net/plug-ins/1.13.6/i18n/id.json" },
      pageLength: 10,
      order: [[4, "desc"]],
      dom: "<\"row align-items-center mb-2\"<\"col-sm-6\"l><\"col-sm-6\"f>><\"t\"><\"row mt-2\"<\"col-sm-5\"i><\"col-sm-7\"p>>"
    });
  }
});
</script>'; ?>
