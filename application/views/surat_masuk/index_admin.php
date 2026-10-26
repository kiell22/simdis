<?php
$status_labels = ['menunggu'=>'Menunggu','diterima_bu'=>'Diterima BU','diteruskan_kadis'=>'Diteruskan Kadis','ditolak'=>'Ditolak'];
$status_colors = ['menunggu'=>'warning','diterima_bu'=>'primary','diteruskan_kadis'=>'success','ditolak'=>'danger'];
?>
<div class="card">
  <div class="card-header bg-white d-flex justify-content-between align-items-center">
    <h6 class="font-weight-bold text-dark mb-0">
      <i class="fas fa-inbox mr-2 text-primary"></i>Surat Masuk dari Luar
      <span class="badge badge-primary ml-1"><?= count($list) ?></span>
    </h6>
    <div class="d-flex" style="gap:8px">
      <?php foreach ($status_labels as $k => $v):
        $active = $status_filter === $k;
        $c = $status_colors[$k];
      ?>
      <a href="<?= base_url('SuratMasukAdmin?status='.$k) ?>"
         class="btn btn-sm <?= $active ? 'btn-'.$c : 'btn-outline-'.$c ?>">
        <?= $v ?>
      </a>
      <?php endforeach; ?>
      <?php if ($status_filter): ?>
      <a href="<?= base_url('SuratMasukAdmin') ?>" class="btn btn-sm btn-outline-secondary">Semua</a>
      <?php endif; ?>
    </div>
  </div>
  <div class="card-body p-0">
    <?php if (empty($list)): ?>
    <div class="text-center py-5 text-muted">
      <i class="fas fa-inbox fa-3x mb-3 d-block text-light"></i>Tidak ada surat masuk
    </div>
    <?php else: ?>
    <div class="table-responsive">
      <table class="table table-hover mb-0">
        <thead class="thead-light">
          <tr>
            <th>#</th>
            <th>Kode Tiket</th>
            <th>Pengirim / Instansi</th>
            <th>No. Surat</th>
            <th>Perihal</th>
            <th>Sifat</th>
            <th>Tgl. Masuk</th>
            <th>Status</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($list as $i => $s):
            $sc = $status_colors[$s->status] ?? 'secondary';
            $sl = $status_labels[$s->status] ?? $s->status;
          ?>
          <tr>
            <td class="text-muted small"><?= $i+1 ?></td>
            <td><span class="badge badge-secondary"><?= $s->kode_tiket ?></span></td>
            <td>
              <div class="font-weight-bold text-dark" style="font-size:0.875rem"><?= $s->nama_pengirim ?></div>
              <div class="text-muted small"><?= $s->instansi_pengirim ?></div>
            </td>
            <td class="small text-muted"><?= $s->no_surat ?></td>
            <td class="small"><?= character_limiter($s->perihal, 45) ?></td>
            <td>
              <?php $sf = ['rahasia'=>'danger','segera'=>'warning','penting'=>'info','biasa'=>'secondary']; ?>
              <span class="badge badge-<?= $sf[$s->sifat] ?? 'secondary' ?>"><?= ucfirst($s->sifat) ?></span>
            </td>
            <td class="small text-muted"><?= date('d M Y', strtotime($s->created_at)) ?></td>
            <td><span class="badge badge-<?= $sc ?>"><?= $sl ?></span></td>
            <td>
              <a href="<?= base_url('SuratMasukAdmin/detail/'.$s->id_sml) ?>" class="btn btn-info btn-sm" title="Detail">
                <i class="fas fa-eye"></i>
              </a>
              <?php if ($s->file_surat): ?>
              <a href="<?= base_url('SuratMasukAdmin/lihat_file/'.$s->id_sml) ?>" target="_blank" class="btn btn-danger btn-sm" title="Lihat PDF">
                <i class="fas fa-file-pdf"></i>
              </a>
              <?php endif; ?>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
    <?php endif; ?>
  </div>
</div>
