<?php
$status_labels = ['menunggu'=>'Menunggu Review','diterima_bu'=>'Diterima Bidang Umum','diteruskan_kadis'=>'Diteruskan ke Kepala Dinas','ditolak'=>'Ditolak'];
$status_colors = ['menunggu'=>'warning','diterima_bu'=>'primary','diteruskan_kadis'=>'success','ditolak'=>'danger'];
$sc = $status_colors[$sml->status] ?? 'secondary';
$sl = $status_labels[$sml->status] ?? $sml->status;

$steps = ['menunggu'=>1,'diterima_bu'=>2,'diteruskan_kadis'=>3];
$current = $steps[$sml->status] ?? ($sml->status === 'ditolak' ? 0 : 1);
$step_list = [
    'menunggu'        => ['Menunggu','clock'],
    'diterima_bu'     => ['Diterima BU','check'],
    'diteruskan_kadis'=> ['Ke Kadis','user-tie'],
];
?>

<div class="row">
  <div class="col-lg-8">

    <!-- Progress -->
    <div class="card mb-3">
      <div class="card-body py-3">
        <?php if ($sml->status === 'ditolak'): ?>
        <div class="alert alert-danger mb-0 py-2">
          <i class="fas fa-times-circle mr-2"></i><strong>Surat Ditolak</strong>
          <?php if ($sml->catatan_bu): ?> &mdash; <?= $sml->catatan_bu ?><?php endif; ?>
          <?php if ($sml->catatan_sepri): ?> &mdash; <?= $sml->catatan_sepri ?><?php endif; ?>
        </div>
        <?php else: ?>
        <div class="d-flex justify-content-between align-items-center">
          <?php
          $si = 1;
          foreach ($step_list as $key => [$label, $icon]):
            $done   = $si < $current;
            $active = $si == $current;
          ?>
          <div class="text-center" style="flex:1">
            <div class="mx-auto mb-1 d-flex align-items-center justify-content-center"
                 style="width:36px;height:36px;border-radius:50%;
                        background:<?= $done ? '#e8f5e9' : ($active ? '#1565c0' : '#f1f3f5') ?>;
                        border:2px solid <?= $done ? '#2e7d32' : ($active ? '#1565c0' : '#dee2e6') ?>">
              <i class="fas fa-<?= $done ? 'check' : $icon ?> fa-sm"
                 style="color:<?= $done ? '#2e7d32' : ($active ? '#fff' : '#adb5bd') ?>"></i>
            </div>
            <div style="font-size:0.68rem;font-weight:<?= $active?'700':'400' ?>;color:<?= $active?'#1565c0':($done?'#2e7d32':'#adb5bd') ?>"><?= $label ?></div>
          </div>
          <?php if ($si < count($step_list)): ?>
          <div style="flex:1;height:2px;background:<?= $si < $current ? '#2e7d32' : '#dee2e6' ?>;max-width:40px;margin-bottom:20px"></div>
          <?php endif; ?>
          <?php $si++; endforeach; ?>
        </div>
        <?php endif; ?>
      </div>
    </div>

    <!-- Info Surat -->
    <div class="card mb-3">
      <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h6 class="font-weight-bold text-dark mb-0"><i class="fas fa-file-alt mr-2 text-primary"></i>Detail Surat Masuk</h6>
        <div>
          <span class="badge badge-<?= $sc ?> mr-2"><?= $sl ?></span>
          <?php if ($sml->file_surat): ?>
          <a href="<?= base_url('SuratMasukAdmin/lihat_file/'.$sml->id_sml) ?>" target="_blank" class="btn btn-sm btn-outline-danger">
            <i class="fas fa-file-pdf mr-1"></i>Lihat PDF
          </a>
          <?php endif; ?>
        </div>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-6">
            <table class="table table-sm table-borderless mb-0">
              <tr><td class="text-muted small font-weight-bold" width="40%">Kode Tiket</td><td><span class="badge badge-secondary"><?= $sml->kode_tiket ?></span></td></tr>
              <tr><td class="text-muted small font-weight-bold">No. Surat</td><td class="small font-weight-bold"><?= $sml->no_surat ?></td></tr>
              <tr><td class="text-muted small font-weight-bold">Tgl. Surat</td><td class="small"><?= date('d F Y', strtotime($sml->tgl_surat)) ?></td></tr>
              <tr><td class="text-muted small font-weight-bold">Tgl. Masuk</td><td class="small"><?= date('d F Y H:i', strtotime($sml->created_at)) ?></td></tr>
            </table>
          </div>
          <div class="col-md-6">
            <table class="table table-sm table-borderless mb-0">
              <tr><td class="text-muted small font-weight-bold" width="40%">Pengirim</td><td class="small"><?= $sml->nama_pengirim ?></td></tr>
              <tr><td class="text-muted small font-weight-bold">Instansi</td><td class="small"><?= $sml->instansi_pengirim ?></td></tr>
              <tr><td class="text-muted small font-weight-bold">NIP</td><td class="small"><?= $sml->nip_pengirim ?: '-' ?></td></tr>
              <tr><td class="text-muted small font-weight-bold">No. HP</td><td class="small"><?= $sml->no_hp ?: '-' ?></td></tr>
            </table>
          </div>
        </div>
        <div class="mt-3 p-3 bg-light rounded">
          <div class="text-muted small font-weight-bold mb-1">PERIHAL</div>
          <div><?= $sml->perihal ?></div>
        </div>
        <?php if ($sml->keterangan): ?>
        <div class="mt-2 p-3 bg-light rounded">
          <div class="text-muted small font-weight-bold mb-1">KETERANGAN</div>
          <div class="small"><?= $sml->keterangan ?></div>
        </div>
        <?php endif; ?>
      </div>
    </div>

    <!-- Panel Aksi: Bidang Umum terima/tolak -->
    <?php if ((int)$user->id_bidang === 9 || $user->role === 'admin'): ?>
    <?php if ($sml->status === 'menunggu'): ?>
    <div class="row">
      <div class="col-md-6">
        <div class="card mb-3 border-left border-success" style="border-left-width:4px!important">
          <div class="card-header bg-white"><h6 class="font-weight-bold text-success mb-0"><i class="fas fa-check-circle mr-2"></i>Terima Surat</h6></div>
          <div class="card-body">
            <form action="<?= base_url('SuratMasukAdmin/terima/'.$sml->id_sml) ?>" method="post">
              <div class="form-group">
                <label class="small font-weight-bold">Catatan (opsional)</label>
                <textarea name="catatan_bu" class="form-control form-control-sm" rows="2" placeholder="Catatan penerimaan..."></textarea>
              </div>
              <button type="submit" class="btn btn-success btn-sm btn-block">
                <i class="fas fa-check mr-1"></i>Terima & Teruskan ke Sepri
              </button>
            </form>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="card mb-3 border-left border-danger" style="border-left-width:4px!important">
          <div class="card-header bg-white"><h6 class="font-weight-bold text-danger mb-0"><i class="fas fa-times-circle mr-2"></i>Tolak Surat</h6></div>
          <div class="card-body">
            <form action="<?= base_url('SuratMasukAdmin/tolak/'.$sml->id_sml) ?>" method="post">
              <div class="form-group">
                <label class="small font-weight-bold">Alasan Penolakan <span class="text-danger">*</span></label>
                <textarea name="catatan_bu" class="form-control form-control-sm" rows="2" placeholder="Jelaskan alasan penolakan..." required></textarea>
              </div>
              <button type="submit" class="btn btn-danger btn-sm btn-block">
                <i class="fas fa-times mr-1"></i>Tolak Surat
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
    <?php endif; ?>
    <?php endif; ?>

    <!-- Panel Aksi: Sepri validasi/tolak -->
    <?php if (in_array($user->role, ['sepri','admin']) && $sml->status === 'diterima_bu'): ?>
    <div class="row">
      <div class="col-md-6">
        <div class="card mb-3 border-left border-primary" style="border-left-width:4px!important">
          <div class="card-header bg-white"><h6 class="font-weight-bold text-primary mb-0"><i class="fas fa-user-check mr-2"></i>Validasi & Teruskan ke Kadis</h6></div>
          <div class="card-body">
            <div class="alert alert-info py-2 small mb-3">
              <i class="fas fa-info-circle mr-1"></i>Surat akan otomatis dicatat sebagai surat internal dan diteruskan ke Kepala Dinas.
            </div>
            <form action="<?= base_url('SuratMasukAdmin/validasi/'.$sml->id_sml) ?>" method="post">
              <div class="form-group">
                <label class="small font-weight-bold">Catatan Validasi (opsional)</label>
                <textarea name="catatan_sepri" class="form-control form-control-sm" rows="2" placeholder="Catatan validasi..."></textarea>
              </div>
              <button type="submit" class="btn btn-primary btn-sm btn-block">
                <i class="fas fa-paper-plane mr-1"></i>Validasi & Teruskan ke Kadis
              </button>
            </form>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="card mb-3 border-left border-danger" style="border-left-width:4px!important">
          <div class="card-header bg-white"><h6 class="font-weight-bold text-danger mb-0"><i class="fas fa-times-circle mr-2"></i>Tolak Surat</h6></div>
          <div class="card-body">
            <form action="<?= base_url('SuratMasukAdmin/tolak_sepri/'.$sml->id_sml) ?>" method="post">
              <div class="form-group">
                <label class="small font-weight-bold">Alasan Penolakan <span class="text-danger">*</span></label>
                <textarea name="catatan_sepri" class="form-control form-control-sm" rows="2" placeholder="Jelaskan alasan penolakan..." required></textarea>
              </div>
              <button type="submit" class="btn btn-danger btn-sm btn-block">
                <i class="fas fa-times mr-1"></i>Tolak Surat
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
    <?php endif; ?>

    <!-- Info jika sudah diteruskan ke kadis -->
    <?php if ($sml->status === 'diteruskan_kadis' && $sml->id_surat_internal): ?>
    <div class="alert alert-success">
      <i class="fas fa-check-double mr-2"></i>
      Surat telah divalidasi dan dicatat sebagai surat internal.
      <a href="<?= base_url('Surat/detail/'.$sml->id_surat_internal) ?>" class="btn btn-success btn-sm ml-2">
        <i class="fas fa-eye mr-1"></i>Lihat Surat Internal
      </a>
    </div>
    <?php endif; ?>

  </div>

  <!-- Kolom Kanan: Timeline -->
  <div class="col-lg-4">
    <div class="card">
      <div class="card-header bg-white"><h6 class="font-weight-bold text-dark mb-0"><i class="fas fa-history mr-2 text-primary"></i>Riwayat Proses</h6></div>
      <div class="card-body p-3">
        <ul class="timeline">
          <li>
            <div class="timeline-icon bg-primary text-white"><i class="fas fa-inbox fa-sm"></i></div>
            <div style="font-size:0.8rem">
              <div class="font-weight-bold">Surat Dikirim</div>
              <div class="text-muted"><?= $sml->nama_pengirim ?> &mdash; <?= $sml->instansi_pengirim ?></div>
              <div class="text-muted" style="font-size:0.72rem"><i class="fas fa-clock mr-1"></i><?= date('d M Y H:i', strtotime($sml->created_at)) ?></div>
            </div>
          </li>
          <?php if ($sml->tgl_terima_bu): ?>
          <li>
            <div class="timeline-icon bg-<?= $sml->status==='ditolak' && !$sml->tgl_validasi_sepri ? 'danger' : 'success' ?> text-white">
              <i class="fas fa-<?= $sml->status==='ditolak' && !$sml->tgl_validasi_sepri ? 'times' : 'check' ?> fa-sm"></i>
            </div>
            <div style="font-size:0.8rem">
              <div class="font-weight-bold"><?= $sml->status==='ditolak' && !$sml->tgl_validasi_sepri ? 'Ditolak Bidang Umum' : 'Diterima Bidang Umum' ?></div>
              <?php if ($sml->catatan_bu): ?><div class="text-muted font-italic">"<?= $sml->catatan_bu ?>"</div><?php endif; ?>
              <div class="text-muted" style="font-size:0.72rem"><i class="fas fa-clock mr-1"></i><?= date('d M Y H:i', strtotime($sml->tgl_terima_bu)) ?></div>
            </div>
          </li>
          <?php endif; ?>
          <?php if ($sml->tgl_validasi_sepri): ?>
          <li>
            <div class="timeline-icon bg-<?= $sml->status==='ditolak' ? 'danger' : 'success' ?> text-white">
              <i class="fas fa-<?= $sml->status==='ditolak' ? 'times' : 'user-check' ?> fa-sm"></i>
            </div>
            <div style="font-size:0.8rem">
              <div class="font-weight-bold"><?= $sml->status==='ditolak' ? 'Ditolak Sepri' : 'Divalidasi Sepri' ?></div>
              <?php if ($sml->catatan_sepri): ?><div class="text-muted font-italic">"<?= $sml->catatan_sepri ?>"</div><?php endif; ?>
              <div class="text-muted" style="font-size:0.72rem"><i class="fas fa-clock mr-1"></i><?= date('d M Y H:i', strtotime($sml->tgl_validasi_sepri)) ?></div>
            </div>
          </li>
          <?php endif; ?>
          <?php if ($sml->status === 'diteruskan_kadis'): ?>
          <li>
            <div class="timeline-icon bg-success text-white"><i class="fas fa-user-tie fa-sm"></i></div>
            <div style="font-size:0.8rem">
              <div class="font-weight-bold">Diteruskan ke Kepala Dinas</div>
              <div class="text-muted small">Surat internal dibuat otomatis</div>
            </div>
          </li>
          <?php endif; ?>
        </ul>
      </div>
    </div>
  </div>
</div>
