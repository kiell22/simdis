<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= isset($judul) ? $judul.' | SIMDIS' : 'SIMDIS - Dinas Pendidikan Papua' ?></title>
  <link rel="icon" type="image/png" href="<?= base_url('assets/images/logo-pemda.png') ?>">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap4-theme@1.0.0/dist/select2-bootstrap4.min.css">
  <style>
    /* Sidebar */
    .main-sidebar { background: #1a1f2e !important; }
    .main-sidebar .brand-link {
      background: #1565c0;
      border-bottom: 1px solid rgba(255,255,255,0.08) !important;
      padding: 14px 16px;
    }
    .brand-text { font-size: 0.95rem !important; font-weight: 700 !important; line-height: 1.2; }
    .brand-text small { font-size: 0.65rem; font-weight: 400; opacity: 0.75; display: block; }
    .sidebar-dark-primary .nav-sidebar > .nav-item > .nav-link.active {
      background: #1565c0 !important;
      border-radius: 6px;
      margin: 0 8px;
    }
    .nav-sidebar .nav-link { border-radius: 6px; margin: 1px 8px; transition: background 0.15s; }
    .nav-sidebar .nav-link:hover { background: rgba(255,255,255,0.07) !important; }
    .nav-header { font-size: 0.65rem !important; letter-spacing: 1.2px; padding: 14px 16px 4px !important; color: rgba(255,255,255,0.3) !important; }

    /* Sidebar user panel */
    .sidebar-user-panel { padding: 12px 16px; border-bottom: 1px solid rgba(255,255,255,0.07); }
    .sidebar-user-panel img { width: 38px; height: 38px; border-radius: 50%; border: 2px solid rgba(255,255,255,0.2); object-fit: cover; }

    /* Navbar */
    .main-header { background: #fff !important; border-bottom: 1px solid #e9ecef; box-shadow: 0 1px 6px rgba(0,0,0,0.06); }
    .main-header .navbar-nav .nav-link { color: #495057 !important; }

    /* Content */
    .content-wrapper { background: #f4f6f9; }
    .content-header h1 { font-size: 1.3rem; font-weight: 700; color: #2d3748; }
    .breadcrumb { background: transparent; padding: 0; }

    /* Cards */
    .card { border: none; border-radius: 10px; box-shadow: 0 1px 8px rgba(0,0,0,0.07); }
    .card-header { border-radius: 10px 10px 0 0 !important; border-bottom: 1px solid rgba(0,0,0,0.05); background: #fff; }
    .card-title { font-weight: 700; font-size: 0.95rem; color: #2d3748; }

    /* Tables */
    .table th { font-size: 0.78rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.4px; color: #6c757d; border-top: none; }
    .table td { vertical-align: middle; font-size: 0.875rem; }

    /* Buttons & Forms */
    .btn { border-radius: 6px; font-size: 0.875rem; }
    .btn-sm { border-radius: 5px; }
    .form-control, .custom-select { border-radius: 6px; }
    .select2-container--bootstrap4 .select2-selection { border-radius: 6px !important; }

    /* Status badges */
    .badge-status { padding: 4px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; }
    .badge-status-baru       { background: #e3f2fd; color: #1565c0; }
    .badge-status-disposisi  { background: #fff3e0; color: #e65100; }
    .badge-status-distribusi { background: #f3e5f5; color: #6a1b9a; }
    .badge-status-diterima   { background: #e8f5e9; color: #2e7d32; }
    .badge-status-diproses   { background: #fff8e1; color: #f57f17; }
    .badge-status-selesai    { background: #e8f5e9; color: #1b5e20; }

    /* Stat cards */
    .stat-card { border-radius: 10px; overflow: hidden; transition: transform 0.15s; }
    .stat-card:hover { transform: translateY(-2px); }
    .stat-card .icon-box { width: 52px; height: 52px; border-radius: 10px; display: flex; align-items: center; justify-content: center; }

    /* Timeline */
    .timeline { position: relative; padding: 0; list-style: none; }
    .timeline::before { content: ''; position: absolute; top: 0; bottom: 0; left: 18px; width: 2px; background: #e9ecef; }
    .timeline > li { position: relative; margin-bottom: 14px; padding-left: 44px; }
    .timeline > li .timeline-icon { position: absolute; left: 0; width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.8rem; }

    /* Notif badge */
    .notif-badge { position: absolute; top: 4px; right: 4px; }

    /* Sifat surat */
    .sifat-rahasia { color: #c62828; font-weight: 700; }
    .sifat-segera  { color: #e65100; font-weight: 700; }
    .sifat-penting { color: #f57f17; font-weight: 600; }
  </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button">
        <i class="fas fa-bars text-secondary"></i>
      </a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
      <span class="nav-link text-muted small">
        <i class="fas fa-calendar-alt mr-1"></i><?= date('l, d F Y') ?>
      </span>
    </li>
  </ul>
  <ul class="navbar-nav ml-auto">

    <!-- Notifikasi -->
    <li class="nav-item dropdown">
      <a class="nav-link position-relative" data-toggle="dropdown" href="#">
        <i class="fas fa-bell text-secondary"></i>
        <?php if (!empty($notif_count) && $notif_count > 0): ?>
        <span class="badge badge-danger badge-pill notif-badge" style="font-size:0.6rem">
          <?= $notif_count > 9 ? '9+' : $notif_count ?>
        </span>
        <?php endif; ?>
      </a>
      <div class="dropdown-menu dropdown-menu-right" style="width:310px;border-radius:8px;box-shadow:0 8px 30px rgba(0,0,0,0.12);border:none">
        <div class="px-3 py-2 border-bottom d-flex justify-content-between align-items-center">
          <span class="font-weight-bold small text-dark">Notifikasi</span>
          <?php if (!empty($notif_count) && $notif_count > 0): ?>
          <a href="<?= base_url('Notifikasi/baca') ?>" class="small text-primary">Tandai dibaca</a>
          <?php endif; ?>
        </div>
        <div style="max-height:260px;overflow-y:auto">
          <?php if (!empty($notifikasi)): ?>
            <?php foreach ($notifikasi as $n): ?>
            <a href="<?= $n->id_surat ? base_url('Surat/detail/'.$n->id_surat) : '#' ?>"
               class="dropdown-item py-2 border-bottom <?= !$n->dibaca ? 'bg-light' : '' ?>">
              <div class="d-flex">
                <span class="badge badge-primary p-2 mr-2 align-self-start mt-1">
                  <i class="fas fa-envelope fa-sm"></i>
                </span>
                <div>
                  <div class="small text-dark"><?= $n->pesan ?></div>
                  <div class="text-muted" style="font-size:0.72rem">
                    <i class="fas fa-clock mr-1"></i><?= date('d M Y H:i', strtotime($n->created_at)) ?>
                  </div>
                </div>
              </div>
            </a>
            <?php endforeach; ?>
          <?php else: ?>
            <div class="text-center text-muted py-4 small">
              <i class="fas fa-bell-slash fa-2x mb-2 d-block text-light"></i>
              Tidak ada notifikasi
            </div>
          <?php endif; ?>
        </div>
      </div>
    </li>

    <!-- User Menu -->
    <li class="nav-item dropdown ml-1">
      <a class="nav-link dropdown-toggle d-flex align-items-center" data-toggle="dropdown" href="#">
        <img src="<?= base_url('uploads/foto/'.($user->foto ?? 'default.png')) ?>"
             class="rounded-circle mr-2" width="30" height="30" style="object-fit:cover;border:2px solid #dee2e6"
             onerror="this.src='https://ui-avatars.com/api/?name=<?= urlencode($user->nama_lengkap) ?>&background=1565c0&color=fff&size=30'">
        <span class="d-none d-md-block small font-weight-bold text-dark"><?= $user->nama_lengkap ?></span>
      </a>
      <div class="dropdown-menu dropdown-menu-right" style="border-radius:8px;border:none;box-shadow:0 6px 24px rgba(0,0,0,0.1);min-width:180px">
        <div class="px-3 py-2 border-bottom">
          <div class="font-weight-bold small text-dark"><?= $user->nama_lengkap ?></div>
          <div class="text-muted" style="font-size:0.72rem"><?= $user->jabatan ?? ucfirst(str_replace('_',' ',$user->role)) ?></div>
        </div>
        <a href="<?= base_url('Pengguna/profil') ?>" class="dropdown-item small">
          <i class="fas fa-user-circle mr-2 text-primary"></i> Profil Saya
        </a>
        <div class="dropdown-divider my-1"></div>
        <a href="<?= base_url('Auth/logout') ?>" class="dropdown-item small text-danger">
          <i class="fas fa-sign-out-alt mr-2"></i> Keluar
        </a>
      </div>
    </li>
  </ul>
</nav>

<!-- Sidebar -->
<aside class="main-sidebar sidebar-dark-primary elevation-2">
  <a href="<?= base_url('Dashboard') ?>" class="brand-link">
    <div class="d-flex align-items-center">
      <img src="<?= base_url('assets/images/logo-pemda.png') ?>"
           alt="Logo" width="34" height="34"
           style="object-fit:contain;margin-right:10px;flex-shrink:0"
           onerror="this.style.display='none'">
      <span class="brand-text text-white">
        SIMDIS
        <small>Dinas Pendidikan Papua</small>
      </span>
    </div>
  </a>

  <div class="sidebar">
    <div class="sidebar-user-panel">
      <div class="d-flex align-items-center">
        <img src="<?= base_url('uploads/foto/'.($user->foto ?? 'default.png')) ?>"
             onerror="this.src='https://ui-avatars.com/api/?name=<?= urlencode($user->nama_lengkap) ?>&background=1565c0&color=fff&size=38'"
             alt="User">
        <div class="ml-2">
          <div class="text-white small font-weight-bold" style="line-height:1.3"><?= $user->nama_lengkap ?></div>
          <div style="font-size:0.68rem;color:rgba(255,255,255,0.45)">
            <i class="fas fa-circle text-success" style="font-size:0.45rem"></i>
            <?= ucfirst(str_replace('_',' ',$user->role)) ?>
          </div>
        </div>
      </div>
    </div>

    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column nav-compact" data-widget="treeview" role="menu">

        <li class="nav-item">
          <a href="<?= base_url('Dashboard') ?>" class="nav-link <?= (uri_string() == 'Dashboard' || uri_string() == '') ? 'active' : '' ?>">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>Dashboard</p>
          </a>
        </li>

        <li class="nav-header">Manajemen Surat</li>

        <li class="nav-item">
          <a href="<?= base_url('Surat') ?>" class="nav-link <?= strpos(uri_string(),'Surat') !== false && strpos(uri_string(),'SuratMasukAdmin') === false ? 'active' : '' ?>">
            <i class="nav-icon fas fa-envelope"></i>
            <p>Daftar Surat</p>
          </a>
        </li>

        <?php if ($user->role === 'admin' || (int)$user->id_bidang === 9 || $user->role === 'sepri'): ?>
        <?php
          $sml_pending = $this->db->where('status','menunggu')->count_all_results('tbl_surat_masuk_luar');
          if ($user->role === 'sepri') {
              $sml_pending = $this->db->where('status','diterima_bu')->count_all_results('tbl_surat_masuk_luar');
          }
        ?>
        <li class="nav-item">
          <a href="<?= base_url('SuratMasukAdmin') ?>" class="nav-link <?= strpos(uri_string(),'SuratMasukAdmin') !== false ? 'active' : '' ?>">
            <i class="nav-icon fas fa-inbox"></i>
            <p>Surat Masuk Luar
              <?php if ($sml_pending > 0): ?>
              <span class="badge badge-warning badge-pill right" style="font-size:0.65rem"><?= $sml_pending ?></span>
              <?php endif; ?>
            </p>
          </a>
        </li>
        <?php endif; ?>

        <?php if (in_array($user->role, ['admin','sepri'])): ?>
        <li class="nav-item">
          <a href="<?= base_url('Surat/tambah') ?>" class="nav-link <?= uri_string() == 'Surat/tambah' ? 'active' : '' ?>">
            <i class="nav-icon fas fa-plus-circle"></i>
            <p>Catat Surat Baru</p>
          </a>
        </li>
        <?php endif; ?>

        <?php if (in_array($user->role, ['admin','bidang_umum'])): ?>
        <li class="nav-item">
          <a href="<?= base_url('Distribusi') ?>" class="nav-link <?= strpos(uri_string(),'Distribusi') !== false ? 'active' : '' ?>">
            <i class="nav-icon fas fa-paper-plane"></i>
            <p>Distribusi Surat</p>
          </a>
        </li>
        <?php endif; ?>

        <li class="nav-header">Monitoring</li>

        <li class="nav-item">
          <a href="<?= base_url('Monitoring') ?>" class="nav-link <?= strpos(uri_string(),'Monitoring') !== false ? 'active' : '' ?>">
            <i class="nav-icon fas fa-chart-line"></i>
            <p>Monitoring Distribusi</p>
          </a>
        </li>

        <li class="nav-item">
          <a href="<?= base_url('Laporan') ?>" class="nav-link <?= strpos(uri_string(),'Laporan') !== false ? 'active' : '' ?>">
            <i class="nav-icon fas fa-file-alt"></i>
            <p>Laporan</p>
          </a>
        </li>

        <?php if ($user->role == 'admin'): ?>
        <li class="nav-header">Pengaturan</li>

        <li class="nav-item">
          <a href="<?= base_url('Pengguna') ?>" class="nav-link <?= strpos(uri_string(),'Pengguna') !== false ? 'active' : '' ?>">
            <i class="nav-icon fas fa-users"></i>
            <p>Pengguna</p>
          </a>
        </li>

        <li class="nav-item">
          <a href="<?= base_url('Bidang') ?>" class="nav-link <?= strpos(uri_string(),'Bidang') !== false ? 'active' : '' ?>">
            <i class="nav-icon fas fa-sitemap"></i>
            <p>Bidang</p>
          </a>
        </li>
        <?php endif; ?>

      </ul>
    </nav>
  </div>
</aside>

<!-- Content Wrapper -->
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0"><?= isset($judul) ? $judul : 'Dashboard' ?></h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?= base_url('Dashboard') ?>"><i class="fas fa-home"></i></a></li>
            <?php if (isset($breadcrumb)): ?>
              <?php foreach ($breadcrumb as $bc): ?>
              <li class="breadcrumb-item <?= isset($bc['active']) ? 'active' : '' ?>">
                <?= isset($bc['url']) ? '<a href="'.$bc['url'].'">'.$bc['label'].'</a>' : $bc['label'] ?>
              </li>
              <?php endforeach; ?>
            <?php else: ?>
              <li class="breadcrumb-item active"><?= isset($judul) ? $judul : 'Dashboard' ?></li>
            <?php endif; ?>
          </ol>
        </div>
      </div>
    </div>
  </div>
  <div class="content">
    <div class="container-fluid">

      <?php if ($this->session->flashdata('success')): ?>
      <div class="alert alert-success alert-dismissible fade show" style="border-radius:8px;border:none">
        <i class="fas fa-check-circle mr-2"></i><?= $this->session->flashdata('success') ?>
        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
      </div>
      <?php endif; ?>
      <?php if ($this->session->flashdata('error')): ?>
      <div class="alert alert-danger alert-dismissible fade show" style="border-radius:8px;border:none">
        <i class="fas fa-exclamation-circle mr-2"></i><?= $this->session->flashdata('error') ?>
        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
      </div>
      <?php endif; ?>
      <?php if ($this->session->flashdata('warning')): ?>
      <div class="alert alert-warning alert-dismissible fade show" style="border-radius:8px;border:none">
        <i class="fas fa-exclamation-triangle mr-2"></i><?= $this->session->flashdata('warning') ?>
        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
      </div>
      <?php endif; ?>
