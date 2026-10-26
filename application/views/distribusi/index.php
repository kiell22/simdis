<div class="row">
  <!-- Surat Siap Distribusi -->
  <div class="col-lg-6 mb-3">
    <div class="card h-100">
      <div class="card-header">
        <h3 class="card-title"><i class="fas fa-inbox mr-2 text-warning"></i>Surat Siap Distribusi</h3>
        <div class="card-tools">
          <span class="badge badge-warning"><?= count($surat_disposisi) ?></span>
        </div>
      </div>
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-hover mb-0">
            <thead class="thead-light">
              <tr>
                <th>No. Agenda</th>
                <th>Perihal</th>
                <th>Tgl Terima</th>
                <th data-orderable="false">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php if (!empty($surat_disposisi)): ?>
              <?php foreach ($surat_disposisi as $s): ?>
              <tr>
                <td><span class="badge badge-secondary small"><?= $s->no_agenda ?></span></td>
                <td>
                  <div class="font-weight-bold small"><?= character_limiter($s->perihal, 40) ?></div>
                  <div class="text-muted" style="font-size:0.75rem"><?= $s->asal_surat ?></div>
                </td>
                <td class="small text-muted"><?= date('d M Y', strtotime($s->tgl_terima)) ?></td>
                <td>
                  <a href="<?= base_url('Surat/detail/'.$s->id_surat) ?>" class="btn btn-warning btn-sm">
                    <i class="fas fa-paper-plane mr-1"></i>Distribusi
                  </a>
                </td>
              </tr>
              <?php endforeach; ?>
              <?php else: ?>
              <tr>
                <td colspan="4" class="text-center text-muted py-4">
                  <i class="fas fa-check-circle fa-2x mb-2 d-block text-success"></i>
                  Tidak ada surat menunggu distribusi
                </td>
              </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <!-- Status Distribusi Berjalan -->
  <div class="col-lg-6 mb-3">
    <div class="card h-100">
      <div class="card-header">
        <h3 class="card-title"><i class="fas fa-chart-line mr-2 text-primary"></i>Status Distribusi Berjalan</h3>
      </div>
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-hover mb-0">
            <thead class="thead-light">
              <tr>
                <th>No. Surat</th>
                <th>Perihal</th>
                <th>Progress</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              <?php if (!empty($surat_distribusi)): ?>
              <?php foreach ($surat_distribusi as $m): ?>
              <?php
                $total  = $m->total_distribusi ?: 1;
                $done   = $m->sudah_diterima  ?: 0;
                $pct    = round(($done / $total) * 100);
                $pcolor = $pct == 100 ? 'success' : ($pct > 0 ? 'warning' : 'danger');
              ?>
              <tr style="cursor:pointer" onclick="window.location='<?= base_url('Surat/detail/'.$m->id_surat) ?>'">
                <td><span class="badge badge-secondary small"><?= $m->no_surat ?></span></td>
                <td class="small"><?= character_limiter($m->perihal, 35) ?></td>
                <td style="min-width:100px">
                  <div class="d-flex align-items-center">
                    <div class="progress flex-grow-1 mr-1" style="height:6px;border-radius:3px">
                      <div class="progress-bar bg-<?= $pcolor ?>" style="width:<?= $pct ?>%"></div>
                    </div>
                    <small class="text-muted"><?= $done ?>/<?= $total ?></small>
                  </div>
                </td>
                <td>
                  <span class="badge badge-status badge-status-<?= $m->status ?>"><?= ucfirst($m->status) ?></span>
                </td>
              </tr>
              <?php endforeach; ?>
              <?php else: ?>
              <tr>
                <td colspan="4" class="text-center text-muted py-4">
                  <i class="fas fa-paper-plane fa-2x mb-2 d-block text-light"></i>
                  Belum ada distribusi berjalan
                </td>
              </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
