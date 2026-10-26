<?php
$stat_labels = ['baru'=>'Baru','disposisi'=>'Disposisi','distribusi'=>'Distribusi','diterima'=>'Diterima','diproses'=>'Diproses','selesai'=>'Selesai'];
$stat_icons  = ['baru'=>'fa-inbox','disposisi'=>'fa-pen-nib','distribusi'=>'fa-paper-plane','diterima'=>'fa-check','diproses'=>'fa-cog','selesai'=>'fa-check-double'];
$stat_colors = ['baru'=>'#1565c0','disposisi'=>'#e65100','distribusi'=>'#6a1b9a','diterima'=>'#2e7d32','diproses'=>'#f57f17','selesai'=>'#1b5e20'];
$stat_bg     = ['baru'=>'#e3f2fd','disposisi'=>'#fff3e0','distribusi'=>'#f3e5f5','diterima'=>'#e8f5e9','diproses'=>'#fff8e1','selesai'=>'#e8f5e9'];

$aksi_info = [
    'kadis'       => ['label'=>'Perlu Disposisi',    'icon'=>'fa-pen-nib',     'color'=>'#e65100', 'bg'=>'#fff3e0', 'btn'=>'warning',  'btn_label'=>'Beri Disposisi'],
    'bidang_umum' => ['label'=>'Perlu Distribusi',   'icon'=>'fa-paper-plane', 'color'=>'#6a1b9a', 'bg'=>'#f3e5f5', 'btn'=>'purple',   'btn_label'=>'Distribusikan'],
    'kepala_bidang'=>['label'=>'Perlu Diterima',      'icon'=>'fa-check-circle','color'=>'#2e7d32', 'bg'=>'#e8f5e9', 'btn'=>'success',  'btn_label'=>'Konfirmasi Terima'],
    'sepri'       => ['label'=>'Surat Baru Masuk',   'icon'=>'fa-inbox',       'color'=>'#1565c0', 'bg'=>'#e3f2fd', 'btn'=>'primary',  'btn_label'=>'Lihat Detail'],
    'admin'       => ['label'=>'Surat Baru Masuk',   'icon'=>'fa-inbox',       'color'=>'#1565c0', 'bg'=>'#e3f2fd', 'btn'=>'primary',  'btn_label'=>'Lihat Detail'],
];
$ai = $aksi_info[$user->role] ?? null;
?>

<?php if ($ai && !empty($surat_aksi)): ?>
<div class="card mb-3" style="border-left:4px solid <?= $ai['color'] ?>">
  <div class="card-header bg-white d-flex justify-content-between align-items-center">
    <h6 class="font-weight-bold mb-0" style="color:<?= $ai['color'] ?>">
      <i class="fas <?= $ai['icon'] ?> mr-2"></i><?= $ai['label'] ?>
      <span class="badge badge-pill text-white ml-1" style="background:<?= $ai['color'] ?>"><?= count($surat_aksi) ?></span>
    </h6>
  </div>
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-hover mb-0">
        <thead class="thead-light">
          <tr>
            <th>No. Agenda</th>
            <th>Perihal</th>
            <th>Asal Surat</th>
            <th>Tgl Terima</th>
            <th>Sifat</th>
            <?php if ($user->role == 'kepala_bidang'): ?>
            <th>Tgl Kirim</th>
            <?php endif; ?>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($surat_aksi as $s): ?>
          <tr>
            <td><span class="badge badge-secondary small"><?= $s->no_agenda ?></span></td>
            <td>
              <div class="font-weight-bold text-dark" style="font-size:0.875rem"><?= character_limiter($s->perihal, 45) ?></div>
              <div class="text-muted small"><?= $s->asal_surat ?></div>
            </td>
            <td class="small"><?= $s->asal_surat ?></td>
            <td class="small text-muted"><?= date('d M Y', strtotime($s->tgl_terima)) ?></td>
            <td>
              <?php $sc = ['rahasia'=>'danger','segera'=>'warning','penting'=>'info','biasa'=>'secondary']; ?>
              <span class="badge badge-<?= $sc[$s->sifat] ?? 'secondary' ?>"><?= ucfirst($s->sifat) ?></span>
            </td>
            <?php if ($user->role == 'kepala_bidang'): ?>
            <td class="small text-muted"><?= date('d M Y H:i', strtotime($s->tgl_kirim)) ?></td>
            <?php endif; ?>
            <td>
              <?php if ($user->role == 'kepala_bidang'): ?>
              <a href="<?= base_url('Surat/detail/'.$s->id_surat) ?>" class="btn btn-success btn-sm">
                <i class="fas fa-check mr-1"></i><?= $ai['btn_label'] ?>
              </a>
              <?php else: ?>
              <a href="<?= base_url('Surat/detail/'.$s->id_surat) ?>" class="btn btn-sm text-white" style="background:<?= $ai['color'] ?>">
                <i class="fas fa-arrow-right mr-1"></i><?= $ai['btn_label'] ?>
              </a>
              <?php endif; ?>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<?php endif; ?>

<!-- Stat Cards -->
<div class="row">
  <?php foreach ($stat_labels as $key => $label): ?>
  <div class="col-6 col-md-4 col-lg-2 mb-3">
    <div class="card stat-card h-100" style="border-left: 4px solid <?= $stat_colors[$key] ?>">
      <div class="card-body p-3">
        <div class="d-flex justify-content-between align-items-start">
          <div>
            <div class="text-muted small font-weight-bold text-uppercase" style="font-size:0.7rem;letter-spacing:0.5px"><?= $label ?></div>
            <div class="font-weight-bold mt-1" style="font-size:1.8rem;color:<?= $stat_colors[$key] ?>;line-height:1">
              <?= $stat[$key] ?? 0 ?>
            </div>
            <div class="small text-muted mt-1">surat</div>
          </div>
          <div class="icon-box" style="background:<?= $stat_bg[$key] ?>">
            <i class="fas <?= $stat_icons[$key] ?>" style="color:<?= $stat_colors[$key] ?>"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php endforeach; ?>
</div>

<div class="row">
  <!-- Chart -->
  <div class="col-lg-5 mb-3">
    <div class="card h-100">
      <div class="card-header bg-white border-bottom-0 pt-3 pb-0">
        <h6 class="font-weight-bold text-dark mb-0"><i class="fas fa-chart-pie mr-2 text-primary"></i>Distribusi Status Surat</h6>
      </div>
      <div class="card-body d-flex align-items-center justify-content-center">
        <canvas id="chartStatus" style="max-height:240px"></canvas>
      </div>
    </div>
  </div>

  <!-- Surat Terbaru -->
  <div class="col-lg-7 mb-3">
    <div class="card h-100">
      <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h6 class="font-weight-bold text-dark mb-0"><i class="fas fa-clock mr-2 text-primary"></i>Surat Terbaru</h6>
        <a href="<?= base_url('Surat') ?>" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
      </div>
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-hover mb-0">
            <thead class="thead-light">
              <tr>
                <th>No. Agenda</th>
                <th>Perihal</th>
                <th>Tgl Terima</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              <?php if (!empty($surat_baru)): ?>
                <?php foreach ($surat_baru as $s): ?>
                <tr style="cursor:pointer" onclick="window.location='<?= base_url('Surat/detail/'.$s->id_surat) ?>'">
                  <td><span class="badge badge-secondary"><?= $s->no_agenda ?></span></td>
                  <td>
                    <div class="font-weight-bold text-dark" style="font-size:0.85rem"><?= character_limiter($s->perihal, 40) ?></div>
                    <div class="text-muted" style="font-size:0.75rem"><?= $s->asal_surat ?></div>
                  </td>
                  <td class="small text-muted"><?= date('d M Y', strtotime($s->tgl_terima)) ?></td>
                  <td><?php
                    $sc = ['baru'=>'primary','disposisi'=>'warning','distribusi'=>'purple','diterima'=>'success','diproses'=>'info','selesai'=>'success'];
                    $si = ['baru'=>'inbox','disposisi'=>'pen','distribusi'=>'paper-plane','diterima'=>'check','diproses'=>'cog','selesai'=>'check-double'];
                    $c = $sc[$s->status] ?? 'secondary';
                    $i = $si[$s->status] ?? 'circle';
                  ?>
                  <span class="badge badge-status badge-status-<?= $s->status ?>">
                    <i class="fas fa-<?= $i ?> mr-1"></i><?= ucfirst($s->status) ?>
                  </span>
                  </td>
                </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr><td colspan="4" class="text-center text-muted py-4">Belum ada surat</td></tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <!-- Monitoring Distribusi -->
  <div class="col-lg-8 mb-3">
    <div class="card">
      <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h6 class="font-weight-bold text-dark mb-0"><i class="fas fa-map-marker-alt mr-2 text-primary"></i>Monitoring Distribusi</h6>
        <a href="<?= base_url('Monitoring') ?>" class="btn btn-sm btn-outline-primary">Detail</a>
      </div>
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-hover mb-0">
            <thead class="thead-light">
              <tr>
                <th>No. Surat</th>
                <th>Perihal</th>
                <th>Bidang Tujuan</th>
                <th>Progress</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              <?php if (!empty($monitoring)): ?>
                <?php foreach ($monitoring as $m): ?>
                <tr>
                  <td><span class="badge badge-secondary small"><?= $m->no_surat ?></span></td>
                  <td class="small"><?= character_limiter($m->perihal, 35) ?></td>
                  <td class="small text-muted"><?= $m->bidang_tujuan ?: '-' ?></td>
                  <td style="min-width:120px">
                    <?php
                      $total = $m->total_distribusi ?: 1;
                      $done  = $m->sudah_diterima ?: 0;
                      $pct   = round(($done / $total) * 100);
                      $pcolor = $pct == 100 ? 'success' : ($pct > 0 ? 'warning' : 'danger');
                    ?>
                    <div class="d-flex align-items-center">
                      <div class="progress flex-grow-1 mr-2" style="height:6px;border-radius:3px">
                        <div class="progress-bar bg-<?= $pcolor ?>" style="width:<?= $pct ?>%"></div>
                      </div>
                      <small class="text-muted"><?= $done ?>/<?= $total ?></small>
                    </div>
                  </td>
                  <td>
                    <span class="badge badge-status badge-status-<?= $m->status ?>">
                      <?= ucfirst($m->status) ?>
                    </span>
                  </td>
                </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr><td colspan="5" class="text-center text-muted py-4">Tidak ada data distribusi aktif</td></tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <!-- Aktivitas Terbaru -->
  <div class="col-lg-4 mb-3">
    <div class="card h-100">
      <div class="card-header bg-white">
        <h6 class="font-weight-bold text-dark mb-0"><i class="fas fa-history mr-2 text-primary"></i>Aktivitas Terbaru</h6>
      </div>
      <div class="card-body p-3" style="overflow-y:auto;max-height:320px">
        <?php if (!empty($aktivitas)): ?>
        <ul class="timeline">
          <?php
          $role_colors = ['admin'=>'danger','sepri'=>'primary','kadis'=>'warning','bidang_umum'=>'purple','kepala_bidang'=>'success'];
          $role_icons  = ['admin'=>'user-shield','sepri'=>'user-edit','kadis'=>'user-tie','bidang_umum'=>'truck','kepala_bidang'=>'user-check'];
          foreach ($aktivitas as $a):
            $rc = $role_colors[$a->role] ?? 'secondary';
            $ri = $role_icons[$a->role] ?? 'user';
          ?>
          <li>
            <div class="timeline-icon bg-<?= $rc ?> text-white">
              <i class="fas fa-<?= $ri ?> fa-sm"></i>
            </div>
            <div class="bg-light rounded p-2" style="font-size:0.8rem">
              <div class="font-weight-bold text-dark"><?= $a->aksi ?></div>
              <div class="text-muted"><?= $a->nama_lengkap ?></div>
              <?php if ($a->no_surat): ?>
              <div class="text-primary small"><?= $a->no_surat ?></div>
              <?php endif; ?>
              <div class="text-muted" style="font-size:0.72rem">
                <i class="fas fa-clock mr-1"></i><?= date('d M H:i', strtotime($a->tgl_aksi)) ?>
              </div>
            </div>
          </li>
          <?php endforeach; ?>
        </ul>
        <?php else: ?>
          <div class="text-center text-muted py-4">
            <i class="fas fa-history fa-2x mb-2 d-block text-light"></i>
            Belum ada aktivitas
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>

<?php
$chart_data   = array_values($stat);
$chart_labels = array_values($stat_labels);
$chart_colors = array_values($stat_colors);
?>
<script>
var ctx = document.getElementById('chartStatus').getContext('2d');
new Chart(ctx, {
  type: 'doughnut',
  data: {
    labels: <?= json_encode($chart_labels) ?>,
    datasets: [{
      data: <?= json_encode($chart_data) ?>,
      backgroundColor: <?= json_encode($chart_colors) ?>,
      borderWidth: 3, borderColor: '#fff',
      hoverOffset: 8
    }]
  },
  options: {
    responsive: true, maintainAspectRatio: true,
    plugins: {
      legend: { position: 'bottom', labels: { padding: 12, font: { size: 11 } } }
    },
    cutout: '65%'
  }
});
</script>
