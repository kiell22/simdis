<?php
// === DEBUG SEMENTARA - HAPUS SETELAH SELESAI ===
if (isset($_GET['debug'])):
?>
<div style="background:#fff3cd;border:1px solid #ffc107;padding:10px;margin:10px;font-size:12px">
  <b>DEBUG INFO:</b><br>
  Role: <?= $user->role ?> | id_bidang user: <?= $user->id_bidang ?> (type: <?= gettype($user->id_bidang) ?>)<br>
  Status surat: <?= $surat->status ?><br>
  Jumlah distribusi: <?= count($distribusi) ?><br>
  <?php foreach($distribusi as $dx): ?>
    &nbsp;&nbsp;- id_distribusi: <?= $dx->id_distribusi ?>, id_bidang: <?= $dx->id_bidang ?> (type: <?= gettype($dx->id_bidang) ?>), status: <?= $dx->status ?>, nama_bidang: <?= $dx->nama_bidang ?><br>
    &nbsp;&nbsp;&nbsp;&nbsp;Match? <?= ((int)$dx->id_bidang === (int)$user->id_bidang) ? '<b style="color:green">YA</b>' : '<b style="color:red">TIDAK</b>' ?><br>
  <?php endforeach; ?>
</div>
<?php endif; ?>
<?php
$status_step = ['baru'=>1,'disposisi'=>2,'distribusi'=>3,'diterima'=>4,'diproses'=>5,'selesai'=>6];
$current_step = $status_step[$surat->status] ?? 1;
?>

<div class="row">
  <!-- Kolom Kiri: Info Surat + Aksi -->
  <div class="col-lg-8">

    <!-- Progress Status -->
    <div class="card mb-3">
      <div class="card-body py-3">
        <div class="d-flex justify-content-between align-items-center flex-wrap">
          <?php
          $steps = ['baru'=>['Baru','inbox'],'disposisi'=>['Disposisi','pen-nib'],'distribusi'=>['Distribusi','paper-plane'],'diterima'=>['Diterima','check'],'diproses'=>['Diproses','cog'],'selesai'=>['Selesai','check-double']];
          $colors = ['baru'=>'#1565c0','disposisi'=>'#e65100','distribusi'=>'#6a1b9a','diterima'=>'#2e7d32','diproses'=>'#f57f17','selesai'=>'#1b5e20'];
          $i = 1;
          foreach ($steps as $key => [$label, $icon]):
            $done    = $i < $current_step;
            $active  = $i == $current_step;
            $pending = $i > $current_step;
          ?>
          <div class="text-center" style="flex:1;min-width:60px">
            <div class="mx-auto mb-1 d-flex align-items-center justify-content-center"
                 style="width:38px;height:38px;border-radius:50%;
                        background:<?= $done ? '#e8f5e9' : ($active ? $colors[$key] : '#f1f3f5') ?>;
                        border:2px solid <?= $done ? '#2e7d32' : ($active ? $colors[$key] : '#dee2e6') ?>">
              <i class="fas fa-<?= $done ? 'check' : $icon ?> fa-sm"
                 style="color:<?= $done ? '#2e7d32' : ($active ? '#fff' : '#adb5bd') ?>"></i>
            </div>
            <div style="font-size:0.68rem;font-weight:<?= $active ? '700' : '400' ?>;
                        color:<?= $active ? $colors[$key] : ($done ? '#2e7d32' : '#adb5bd') ?>">
              <?= $label ?>
            </div>
          </div>
          <?php if ($i < 6): ?>
          <div style="flex:1;height:2px;background:<?= $i < $current_step ? '#2e7d32' : '#dee2e6' ?>;max-width:40px;margin-bottom:20px"></div>
          <?php endif; ?>
          <?php $i++; endforeach; ?>
        </div>
      </div>
    </div>

    <!-- Info Surat -->
    <div class="card mb-3">
      <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h6 class="font-weight-bold text-dark mb-0">
          <i class="fas fa-file-alt mr-2 text-primary"></i>Informasi Surat
        </h6>
        <div>
          <?php if ($surat->file_surat): ?>
          <a href="<?= base_url('Surat/lihat_pdf/'.$surat->id_surat) ?>" target="_blank" class="btn btn-sm btn-outline-danger mr-1">
            <i class="fas fa-file-pdf mr-1"></i>Lihat PDF
          </a>
          <?php endif; ?>
          <?php if (!empty($sml) && $sml->file_surat): ?>
          <a href="<?= base_url('SuratMasukAdmin/lihat_file/'.$sml->id_sml) ?>" target="_blank" class="btn btn-sm btn-outline-secondary mr-1">
            <i class="fas fa-file-pdf mr-1"></i>File Asli
          </a>
          <?php endif; ?>
          <?php if (in_array($user->role, ['admin','sepri'])): ?>
          <a href="<?= base_url('Surat/edit/'.$surat->id_surat) ?>" class="btn btn-sm btn-outline-warning">
            <i class="fas fa-edit mr-1"></i>Edit
          </a>
          <?php endif; ?>
        </div>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-6">
            <table class="table table-sm table-borderless mb-0">
              <tr>
                <td class="text-muted small font-weight-bold" width="40%">No. Agenda</td>
                <td><span class="badge badge-primary"><?= $surat->no_agenda ?></span></td>
              </tr>
              <tr>
                <td class="text-muted small font-weight-bold">No. Surat</td>
                <td class="small font-weight-bold"><?= $surat->no_surat ?></td>
              </tr>
              <tr>
                <td class="text-muted small font-weight-bold">Tgl. Surat</td>
                <td class="small"><?= date('d F Y', strtotime($surat->tgl_surat)) ?></td>
              </tr>
              <tr>
                <td class="text-muted small font-weight-bold">Tgl. Terima</td>
                <td class="small"><?= date('d F Y', strtotime($surat->tgl_terima)) ?></td>
              </tr>
            </table>
          </div>
          <div class="col-md-6">
            <table class="table table-sm table-borderless mb-0">
              <tr>
                <td class="text-muted small font-weight-bold" width="40%">Asal Surat</td>
                <td class="small"><?= $surat->asal_surat ?></td>
              </tr>
              <tr>
                <td class="text-muted small font-weight-bold">Sifat</td>
                <td><?php
                  $sc = ['rahasia'=>'danger','segera'=>'warning','penting'=>'info','biasa'=>'secondary'];
                  echo '<span class="badge badge-'.($sc[$surat->sifat]??'secondary').'">'.ucfirst($surat->sifat).'</span>';
                ?></td>
              </tr>
              <tr>
                <td class="text-muted small font-weight-bold">Status</td>
                <td><span class="badge badge-status badge-status-<?= $surat->status ?>"><?= ucfirst($surat->status) ?></span></td>
              </tr>
              <tr>
                <td class="text-muted small font-weight-bold">Dicatat oleh</td>
                <td class="small"><?= $surat->input_oleh ?></td>
              </tr>
            </table>
          </div>
        </div>
        <div class="mt-3 p-3 bg-light rounded">
          <div class="text-muted small font-weight-bold mb-1">PERIHAL</div>
          <div><?= $surat->perihal ?></div>
        </div>
        <?php if ($surat->keterangan): ?>
        <div class="mt-2 p-3 bg-light rounded">
          <div class="text-muted small font-weight-bold mb-1">KETERANGAN</div>
          <div class="small"><?= $surat->keterangan ?></div>
        </div>
        <?php endif; ?>
      </div>
    </div>

    <!-- Panel Aksi: Disposisi (Kadis) -->
    <?php if (in_array($user->role, ['kadis','admin']) && $surat->status == 'baru'): ?>
    <div class="card mb-3 border-left border-warning" style="border-left-width:4px!important">
      <div class="card-header bg-white">
        <h6 class="font-weight-bold text-warning mb-0"><i class="fas fa-pen-nib mr-2"></i>Beri Disposisi</h6>
      </div>
      <div class="card-body">
        <form action="<?= base_url('Disposisi/proses/'.$surat->id_surat) ?>" method="post">
          <div class="form-group">
            <label class="font-weight-bold small">Bidang Tujuan <span class="text-danger">*</span></label>
            <select name="bidang_tujuan[]" class="form-control select2" multiple required>
              <?php foreach ($bidang as $b): ?>
              <option value="<?= $b->id_bidang ?>"><?= $b->nama_bidang ?></option>
              <?php endforeach; ?>
            </select>
            <small class="text-muted">Bisa pilih lebih dari satu bidang</small>
          </div>
          <div class="form-group">
            <label class="font-weight-bold small">Isi Disposisi <span class="text-danger">*</span></label>
            <textarea name="isi_disposisi" class="form-control" rows="2" placeholder="Contoh: Untuk ditindaklanjuti..." required></textarea>
          </div>
          <div class="form-group">
            <label class="font-weight-bold small">Instruksi Tambahan</label>
            <input type="text" name="instruksi" class="form-control" placeholder="Opsional">
          </div>
          <button type="submit" name="btndisposisi" class="btn btn-warning">
            <i class="fas fa-paper-plane mr-1"></i>Kirim Disposisi
          </button>
        </form>
      </div>
    </div>
    <?php endif; ?>

    <!-- Panel Aksi: Distribusi (Bidang Umum) -->
    <?php if (in_array($user->role, ['bidang_umum','admin']) && $surat->status == 'disposisi'): ?>
    <div class="card mb-3 border-left border-purple" style="border-left-width:4px!important;border-color:#6a1b9a!important">
      <div class="card-header bg-white">
        <h6 class="font-weight-bold mb-0" style="color:#6a1b9a"><i class="fas fa-paper-plane mr-2"></i>Distribusi Surat ke Bidang</h6>
      </div>
      <div class="card-body">
        <form action="<?= base_url('Distribusi/kirim/'.$surat->id_surat) ?>" method="post">
          <?php
          // Tampilkan bidang dari disposisi sebagai default
          $bidang_disp = [];
          foreach ($disposisi as $d) {
            foreach ($bidang_disposisi[$d->id_disposisi] ?? [] as $bd) {
              $bidang_disp[$bd->id_bidang] = $bd->nama_bidang;
            }
          }
          ?>
          <div class="form-group">
            <label class="font-weight-bold small">Kirim ke Bidang <span class="text-danger">*</span></label>
            <select name="bidang_kirim[]" class="form-control select2" multiple required>
              <?php foreach ($bidang as $b): ?>
              <option value="<?= $b->id_bidang ?>" <?= isset($bidang_disp[$b->id_bidang]) ? 'selected' : '' ?>>
                <?= $b->nama_bidang ?>
              </option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="form-group">
            <label class="font-weight-bold small">Catatan Pengiriman</label>
            <input type="text" name="catatan_kirim" class="form-control" placeholder="Opsional">
          </div>
          <button type="submit" name="btnkirim" class="btn btn-block text-white" style="background:#6a1b9a">
            <i class="fas fa-paper-plane mr-1"></i>Kirim Surat
          </button>
        </form>
      </div>
    </div>
    <?php endif; ?>

    <!-- Panel Aksi: Terima & Proses (Kepala Bidang) -->
    <?php if ($user->role == 'kepala_bidang' || $user->role == 'admin'): ?>
      <?php foreach ($distribusi as $dist):
        if ((int)$dist->id_bidang !== (int)$user->id_bidang && $user->role !== 'admin') continue;
        if ($dist->status == 'dikirim'):
      ?>
      <div class="card mb-3 border-left border-success" style="border-left-width:4px!important">
        <div class="card-header bg-white">
          <h6 class="font-weight-bold text-success mb-0"><i class="fas fa-check-circle mr-2"></i>Konfirmasi Penerimaan Surat</h6>
        </div>
        <div class="card-body">
          <div class="alert alert-info py-2 small">
            <i class="fas fa-info-circle mr-1"></i>
            Surat dikirim oleh <strong><?= $dist->kirim_oleh ?></strong> pada <?= date('d M Y H:i', strtotime($dist->tgl_kirim)) ?>
          </div>
          <form action="<?= base_url('Distribusi/terima/'.$dist->id_distribusi) ?>" method="post">
            <div class="form-group">
              <label class="font-weight-bold small">Catatan Penerimaan</label>
              <input type="text" name="catatan_terima" class="form-control" placeholder="Opsional">
            </div>
            <button type="submit" name="btnterima" class="btn btn-success">
              <i class="fas fa-check mr-1"></i>Konfirmasi Diterima
            </button>
          </form>
        </div>
      </div>
      <?php endif; endforeach; ?>

      <?php
      $bidang_sudah_terima = false;
      foreach ($distribusi as $dist) {
          if ((int)$dist->id_bidang === (int)$user->id_bidang && $dist->status === 'diterima') {
              $bidang_sudah_terima = true;
              break;
          }
      }
      if (($bidang_sudah_terima || $user->role === 'admin') && in_array($surat->status, ['distribusi','diterima','diproses'])): ?>
      <div class="card mb-3 border-left border-info" style="border-left-width:4px!important">
        <div class="card-header bg-white">
          <h6 class="font-weight-bold text-info mb-0"><i class="fas fa-cog mr-2"></i>Update Proses Surat</h6>
        </div>
        <div class="card-body">
          <form action="<?= base_url('Distribusi/proses/'.$surat->id_surat) ?>" method="post">
            <div class="form-group">
              <label class="font-weight-bold small">Keterangan Proses <span class="text-danger">*</span></label>
              <textarea name="keterangan" class="form-control" rows="2" placeholder="Jelaskan tindakan yang dilakukan..." required></textarea>
            </div>
            <div class="form-group">
              <label class="font-weight-bold small">Status</label>
              <select name="status_proses" class="form-control">
                <option value="diproses">Sedang Diproses</option>
                <option value="selesai">Selesai</option>
              </select>
            </div>
            <button type="submit" name="btnproses" class="btn btn-info text-white">
              <i class="fas fa-save mr-1"></i>Simpan Update
            </button>
          </form>
        </div>
      </div>
      <?php endif; ?>
    <?php endif; ?>

  </div>

  <!-- Kolom Kanan: Riwayat & Info Distribusi -->
  <div class="col-lg-4">

    <!-- Riwayat / Timeline -->
    <div class="card mb-3">
      <div class="card-header bg-white">
        <h6 class="font-weight-bold text-dark mb-0"><i class="fas fa-history mr-2 text-primary"></i>Riwayat Surat</h6>
      </div>
      <div class="card-body p-3" style="max-height:350px;overflow-y:auto">
        <?php if (!empty($riwayat)): ?>
        <ul class="timeline">
          <?php
          $aksi_colors = ['Surat dicatat'=>'primary','Surat didisposisi'=>'warning','Surat dikirim/distribusi'=>'purple','Surat diterima bidang'=>'success','Surat sedang diproses'=>'info','Surat selesai diproses'=>'success','Surat diperbarui'=>'secondary'];
          foreach ($riwayat as $r):
            $rc = 'secondary';
            foreach ($aksi_colors as $k => $v) { if (strpos($r->aksi, substr($k,6)) !== false) { $rc = $v; break; } }
          ?>
          <li>
            <div class="timeline-icon bg-<?= $rc ?> text-white" style="font-size:0.7rem">
              <i class="fas fa-circle fa-xs"></i>
            </div>
            <div style="font-size:0.8rem">
              <div class="font-weight-bold text-dark"><?= $r->aksi ?></div>
              <div class="text-muted"><?= $r->nama_lengkap ?></div>
              <?php if ($r->keterangan): ?>
              <div class="text-muted small font-italic"><?= $r->keterangan ?></div>
              <?php endif; ?>
              <div class="text-muted" style="font-size:0.72rem">
                <i class="fas fa-clock mr-1"></i><?= date('d M Y H:i', strtotime($r->tgl_aksi)) ?>
              </div>
            </div>
          </li>
          <?php endforeach; ?>
        </ul>
        <?php else: ?>
          <div class="text-center text-muted py-3 small">Belum ada riwayat</div>
        <?php endif; ?>
      </div>
    </div>

    <!-- Info Disposisi -->
    <?php if (!empty($disposisi)): ?>
    <div class="card mb-3">
      <div class="card-header bg-white">
        <h6 class="font-weight-bold text-dark mb-0"><i class="fas fa-pen-nib mr-2 text-warning"></i>Disposisi</h6>
      </div>
      <div class="card-body p-3">
        <?php foreach ($disposisi as $d): ?>
        <div class="mb-3 p-3 bg-light rounded">
          <div class="small font-weight-bold text-dark"><?= $d->isi_disposisi ?></div>
          <?php if ($d->instruksi): ?>
          <div class="small text-muted mt-1"><i class="fas fa-info-circle mr-1"></i><?= $d->instruksi ?></div>
          <?php endif; ?>
          <div class="mt-2">
            <?php foreach ($bidang_disposisi[$d->id_disposisi] ?? [] as $bd): ?>
            <span class="badge badge-warning mr-1 mb-1"><?= $bd->nama_bidang ?></span>
            <?php endforeach; ?>
          </div>
          <div class="text-muted mt-1" style="font-size:0.72rem">
            <i class="fas fa-user mr-1"></i><?= $d->disposisi_oleh ?> &bull;
            <?= date('d M Y H:i', strtotime($d->tgl_disposisi)) ?>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
    <?php endif; ?>

    <!-- Info Distribusi -->
    <?php if (!empty($distribusi)): ?>
    <div class="card mb-3">
      <div class="card-header bg-white">
        <h6 class="font-weight-bold text-dark mb-0"><i class="fas fa-paper-plane mr-2" style="color:#6a1b9a"></i>Status Distribusi</h6>
      </div>
      <div class="card-body p-3">
        <?php foreach ($distribusi as $dist): ?>
        <div class="d-flex align-items-start mb-3 pb-3 border-bottom">
          <div class="mr-3">
            <span class="badge badge-pill <?= $dist->status=='diterima' ? 'badge-success' : 'badge-warning' ?> p-2">
              <i class="fas fa-<?= $dist->status=='diterima' ? 'check' : 'clock' ?>"></i>
            </span>
          </div>
          <div style="font-size:0.8rem">
            <div class="font-weight-bold text-dark"><?= $dist->nama_bidang ?></div>
            <div class="text-muted">Dikirim: <?= date('d M Y H:i', strtotime($dist->tgl_kirim)) ?></div>
            <?php if ($dist->tgl_terima): ?>
            <div class="text-success">Diterima: <?= date('d M Y H:i', strtotime($dist->tgl_terima)) ?></div>
            <?php endif; ?>
            <?php if ($dist->catatan_terima): ?>
            <div class="text-muted font-italic">"<?= $dist->catatan_terima ?>"</div>
            <?php endif; ?>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
    <?php endif; ?>

    <!-- Proses -->
    <?php if (!empty($proses)): ?>
    <div class="card">
      <div class="card-header bg-white">
        <h6 class="font-weight-bold text-dark mb-0"><i class="fas fa-cog mr-2 text-info"></i>Log Proses</h6>
      </div>
      <div class="card-body p-3">
        <?php foreach ($proses as $p): ?>
        <div class="mb-2 p-2 bg-light rounded" style="font-size:0.8rem">
          <div class="d-flex justify-content-between">
            <span class="font-weight-bold text-dark"><?= $p->nama_bidang ?></span>
            <span class="badge badge-<?= $p->status=='selesai' ? 'success' : 'info' ?>"><?= ucfirst($p->status) ?></span>
          </div>
          <div class="text-muted mt-1"><?= $p->keterangan ?></div>
          <div class="text-muted" style="font-size:0.72rem">
            <i class="fas fa-user mr-1"></i><?= $p->nama_lengkap ?> &bull;
            <?= date('d M Y H:i', strtotime($p->tgl_proses)) ?>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
    <?php endif; ?>

  </div>
</div>
