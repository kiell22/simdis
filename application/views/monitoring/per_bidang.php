<?php
$sifat_class = ['rahasia'=>'danger','segera'=>'warning','penting'=>'info','biasa'=>'secondary'];
?>

<!-- Ringkasan per Bidang -->
<div class="row mb-3">
  <?php foreach ($data_bidang as $item): ?>
  <div class="col-md-4 col-lg-3 mb-2">
    <div class="info-box shadow-none border mb-0" style="border-radius:10px">
      <span class="info-box-icon <?= $item['total'] > 0 ? 'bg-primary' : 'bg-secondary' ?>" style="border-radius:10px 0 0 10px;font-size:0.8rem">
        <i class="fas fa-building"></i>
      </span>
      <div class="info-box-content">
        <span class="info-box-text" style="font-size:0.7rem"><?= $item['bidang']->nama_bidang ?></span>
        <span class="info-box-number"><?= $item['total'] ?> surat</span>
        <span style="font-size:0.7rem">
          <span class="text-warning"><?= $item['dikirim'] ?> menunggu</span> &bull;
          <span class="text-success"><?= $item['diterima'] ?> diterima</span>
        </span>
      </div>
    </div>
  </div>
  <?php endforeach; ?>
</div>

<!-- Detail Per Bidang -->
<?php foreach ($data_bidang as $item): ?>
<div class="card mb-4" id="bidang-<?= $item['bidang']->id_bidang ?>">
  <div class="card-header d-flex justify-content-between align-items-center"
       style="background:#f8f9fa;border-left:4px solid <?= $item['total'] > 0 ? '#007bff' : '#dee2e6' ?>">
    <h6 class="mb-0 font-weight-bold">
      <i class="fas fa-building mr-2 text-primary"></i><?= $item['bidang']->nama_bidang ?>
      <span class="badge badge-primary ml-1"><?= $item['total'] ?></span>
    </h6>
    <div>
      <span class="badge badge-warning mr-1"><i class="fas fa-clock mr-1"></i><?= $item['dikirim'] ?> Menunggu</span>
      <span class="badge badge-success"><i class="fas fa-check mr-1"></i><?= $item['diterima'] ?> Diterima</span>
    </div>
  </div>
  <div class="card-body p-0">
    <?php if (empty($item['surat'])): ?>
    <div class="text-center text-muted py-4">
      <i class="fas fa-inbox fa-2x mb-2 d-block text-light"></i>
      Belum ada surat masuk ke bidang ini
    </div>
    <?php else: ?>
    <div class="table-responsive">
      <table class="table table-hover table-sm mb-0">
        <thead class="thead-light">
          <tr>
            <th width="5%">#</th>
            <th width="12%">No. Agenda</th>
            <th>Perihal</th>
            <th width="8%">Sifat</th>
            <th width="12%">Tgl Kirim</th>
            <th width="10%">Status Dist.</th>
            <th width="10%">Status Surat</th>
            <th width="8%">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($item['surat'] as $i => $s): ?>
          <tr>
            <td class="text-muted small"><?= $i+1 ?></td>
            <td><span class="badge badge-secondary small"><?= $s->no_agenda ?></span></td>
            <td>
              <div class="font-weight-bold small"><?= character_limiter($s->perihal, 50) ?></div>
              <div class="text-muted" style="font-size:0.72rem">Dikirim oleh: <?= $s->kirim_oleh ?></div>
            </td>
            <td><span class="badge badge-<?= $sifat_class[$s->sifat] ?? 'secondary' ?>"><?= ucfirst($s->sifat) ?></span></td>
            <td class="small text-muted"><?= date('d M Y H:i', strtotime($s->tgl_kirim)) ?></td>
            <td>
              <?php if ($s->status_dist == 'diterima'): ?>
                <span class="badge badge-success"><i class="fas fa-check mr-1"></i>Diterima</span>
                <div class="text-muted" style="font-size:0.7rem"><?= date('d M Y', strtotime($s->tgl_terima_dist)) ?></div>
              <?php else: ?>
                <span class="badge badge-warning"><i class="fas fa-clock mr-1"></i>Menunggu</span>
              <?php endif; ?>
            </td>
            <td><span class="badge badge-status badge-status-<?= $s->status ?>"><?= ucfirst($s->status) ?></span></td>
            <td>
              <a href="<?= base_url('Surat/detail/'.$s->id_surat) ?>" class="btn btn-info btn-sm" title="Detail">
                <i class="fas fa-eye"></i>
              </a>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
    <?php endif; ?>
  </div>
</div>
<?php endforeach; ?>
