<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SIMDIS - Sistem Monitoring Distribusi Surat</title>
  <link rel="icon" type="image/png" href="<?= base_url('assets/images/logo-pemda.png') ?>">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    :root {
      --blue: #1565c0;
      --blue-dark: #0d47a1;
      --blue-light: #e3f2fd;
      --accent: #f57c00;
      --text: #1a1f2e;
      --muted: #6c757d;
      --border: #e9ecef;
      --white: #ffffff;
    }

    html { scroll-behavior: smooth; }

    body {
      font-family: 'Inter', sans-serif;
      color: var(--text);
      background: var(--white);
      line-height: 1.6;
    }

    /* ===== NAVBAR ===== */
    nav {
      position: fixed;
      top: 0; left: 0; right: 0;
      z-index: 100;
      background: rgba(255,255,255,0.95);
      backdrop-filter: blur(10px);
      border-bottom: 1px solid var(--border);
      padding: 0 5%;
      display: flex;
      align-items: center;
      justify-content: space-between;
      height: 64px;
    }
    .nav-brand {
      display: flex;
      align-items: center;
      gap: 10px;
      text-decoration: none;
    }
    .nav-brand img {
      height: 38px;
      width: 38px;
      object-fit: contain;
    }
    .nav-brand span {
      font-size: 1.1rem;
      font-weight: 700;
      color: var(--blue);
    }
    .nav-links {
      display: flex;
      align-items: center;
      gap: 8px;
    }
    .nav-links a {
      text-decoration: none;
      color: var(--muted);
      font-size: 0.88rem;
      font-weight: 500;
      padding: 6px 14px;
      border-radius: 6px;
      transition: all 0.2s;
    }
    .nav-links a:hover { color: var(--blue); background: var(--blue-light); }
    .btn-nav-login {
      background: var(--blue) !important;
      color: var(--white) !important;
      padding: 7px 18px !important;
    }
    .btn-nav-login:hover { background: var(--blue-dark) !important; }

    /* ===== HERO ===== */
    .hero {
      min-height: 100vh;
      background: linear-gradient(135deg, rgba(13,71,161,0.88) 0%, rgba(21,101,192,0.82) 50%, rgba(25,118,210,0.80) 100%),
                  url('<?= base_url('assets/images/bg.webp') ?>') center/cover no-repeat;
      display: flex;
      align-items: center;
      padding: 100px 5% 60px;
      position: relative;
      overflow: hidden;
    }
    .hero::before {
      content: '';
      position: absolute;
      top: -100px; right: -100px;
      width: 500px; height: 500px;
      background: rgba(255,255,255,0.04);
      border-radius: 50%;
    }
    .hero::after {
      content: '';
      position: absolute;
      bottom: -150px; left: -80px;
      width: 400px; height: 400px;
      background: rgba(255,255,255,0.03);
      border-radius: 50%;
    }
    .hero-content {
      max-width: 1100px;
      margin: 0 auto;
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 60px;
      align-items: center;
      position: relative;
      z-index: 1;
      width: 100%;
    }
    .hero-text .badge {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      background: rgba(255,255,255,0.15);
      color: #fff;
      font-size: 0.78rem;
      font-weight: 600;
      padding: 5px 14px;
      border-radius: 20px;
      margin-bottom: 20px;
      border: 1px solid rgba(255,255,255,0.2);
    }
    .hero-text h1 {
      font-size: 2.8rem;
      font-weight: 800;
      color: #fff;
      line-height: 1.2;
      margin-bottom: 16px;
    }
    .hero-text h1 span { color: #ffcc02; }
    .hero-text p {
      font-size: 1rem;
      color: rgba(255,255,255,0.85);
      margin-bottom: 32px;
      line-height: 1.7;
    }
    .hero-actions {
      display: flex;
      gap: 12px;
      flex-wrap: wrap;
    }
    .btn-primary {
      background: #fff;
      color: var(--blue);
      padding: 13px 28px;
      border-radius: 8px;
      font-weight: 700;
      font-size: 0.92rem;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 8px;
      transition: all 0.2s;
      box-shadow: 0 4px 16px rgba(0,0,0,0.15);
    }
    .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(0,0,0,0.2); }
    .btn-outline {
      background: transparent;
      color: #fff;
      padding: 13px 28px;
      border-radius: 8px;
      font-weight: 600;
      font-size: 0.92rem;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 8px;
      border: 2px solid rgba(255,255,255,0.5);
      transition: all 0.2s;
    }
    .btn-outline:hover { background: rgba(255,255,255,0.1); border-color: #fff; }

    /* Hero card */
    .hero-card {
      background: rgba(255,255,255,0.1);
      backdrop-filter: blur(12px);
      border: 1px solid rgba(255,255,255,0.2);
      border-radius: 16px;
      padding: 28px;
      color: #fff;
    }
    .hero-card h3 {
      font-size: 0.85rem;
      font-weight: 600;
      opacity: 0.7;
      text-transform: uppercase;
      letter-spacing: 1px;
      margin-bottom: 20px;
    }
    .stat-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 16px;
      margin-bottom: 20px;
    }
    .stat-item {
      background: rgba(255,255,255,0.1);
      border-radius: 10px;
      padding: 16px;
      text-align: center;
    }
    .stat-item .num {
      font-size: 1.8rem;
      font-weight: 800;
      display: block;
    }
    .stat-item .label {
      font-size: 0.75rem;
      opacity: 0.75;
    }
    .hero-card .step-list {
      list-style: none;
      display: flex;
      flex-direction: column;
      gap: 10px;
    }
    .hero-card .step-list li {
      display: flex;
      align-items: center;
      gap: 10px;
      font-size: 0.88rem;
      opacity: 0.9;
    }
    .hero-card .step-list li .dot {
      width: 8px; height: 8px;
      background: #ffcc02;
      border-radius: 50%;
      flex-shrink: 0;
    }

    /* ===== SECTION COMMON ===== */
    section { padding: 80px 5%; }
    .section-inner { max-width: 1100px; margin: 0 auto; }
    .section-label {
      font-size: 0.78rem;
      font-weight: 700;
      color: var(--blue);
      text-transform: uppercase;
      letter-spacing: 1.5px;
      margin-bottom: 10px;
    }
    .section-title {
      font-size: 2rem;
      font-weight: 800;
      color: var(--text);
      margin-bottom: 12px;
    }
    .section-desc {
      font-size: 0.95rem;
      color: var(--muted);
      max-width: 560px;
      line-height: 1.7;
    }
    .section-header { margin-bottom: 48px; }

    /* ===== FITUR ===== */
    #fitur { background: #f8faff; }
    .fitur-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 24px;
    }
    .fitur-card {
      background: var(--white);
      border: 1px solid var(--border);
      border-radius: 12px;
      padding: 28px 24px;
      transition: all 0.2s;
    }
    .fitur-card:hover {
      border-color: var(--blue);
      box-shadow: 0 8px 32px rgba(21,101,192,0.1);
      transform: translateY(-3px);
    }
    .fitur-icon {
      width: 48px; height: 48px;
      background: var(--blue-light);
      border-radius: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 16px;
      font-size: 1.2rem;
      color: var(--blue);
    }
    .fitur-card h4 {
      font-size: 1rem;
      font-weight: 700;
      margin-bottom: 8px;
    }
    .fitur-card p {
      font-size: 0.85rem;
      color: var(--muted);
      line-height: 1.6;
    }

    /* ===== ALUR ===== */
    #alur { background: var(--white); }
    .alur-steps {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 0;
      position: relative;
    }
    .alur-steps::before {
      content: '';
      position: absolute;
      top: 32px;
      left: 12.5%;
      right: 12.5%;
      height: 2px;
      background: linear-gradient(to right, var(--blue), var(--blue-light));
      z-index: 0;
    }
    .alur-step {
      text-align: center;
      padding: 0 16px;
      position: relative;
      z-index: 1;
    }
    .alur-num {
      width: 64px; height: 64px;
      background: var(--blue);
      color: #fff;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.3rem;
      font-weight: 800;
      margin: 0 auto 16px;
      border: 4px solid #fff;
      box-shadow: 0 4px 16px rgba(21,101,192,0.3);
    }
    .alur-step h4 {
      font-size: 0.95rem;
      font-weight: 700;
      margin-bottom: 8px;
    }
    .alur-step p {
      font-size: 0.82rem;
      color: var(--muted);
      line-height: 1.5;
    }

    /* ===== CTA ===== */
    #cta {
      background: linear-gradient(135deg, #0d47a1, #1565c0);
      padding: 80px 5%;
    }
    .cta-inner {
      max-width: 700px;
      margin: 0 auto;
      text-align: center;
    }
    .cta-inner h2 {
      font-size: 2rem;
      font-weight: 800;
      color: #fff;
      margin-bottom: 14px;
    }
    .cta-inner p {
      color: rgba(255,255,255,0.8);
      font-size: 0.95rem;
      margin-bottom: 32px;
      line-height: 1.7;
    }
    .cta-buttons {
      display: flex;
      gap: 12px;
      justify-content: center;
      flex-wrap: wrap;
    }
    .btn-cta-white {
      background: #fff;
      color: var(--blue);
      padding: 13px 28px;
      border-radius: 8px;
      font-weight: 700;
      font-size: 0.92rem;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 8px;
      transition: all 0.2s;
    }
    .btn-cta-white:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(0,0,0,0.2); }
    .btn-cta-outline {
      background: transparent;
      color: #fff;
      padding: 13px 28px;
      border-radius: 8px;
      font-weight: 600;
      font-size: 0.92rem;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 8px;
      border: 2px solid rgba(255,255,255,0.5);
      transition: all 0.2s;
    }
    .btn-cta-outline:hover { background: rgba(255,255,255,0.1); border-color: #fff; }

    /* ===== FOOTER ===== */
    footer {
      background: #0d1b2a;
      color: rgba(255,255,255,0.6);
      padding: 60px 5% 0;
    }
    .footer-top {
      max-width: 1100px;
      margin: 0 auto;
      display: grid;
      grid-template-columns: 2fr 1fr 1fr 1.4fr;
      gap: 48px;
      padding-bottom: 48px;
    }
    .footer-brand {
      display: flex;
      align-items: center;
      gap: 10px;
      margin-bottom: 16px;
    }
    .footer-brand img {
      height: 48px;
      width: 48px;
      object-fit: contain;
    }
    .footer-brand span {
      font-size: 1rem;
      font-weight: 700;
      color: #fff;
    }
    .footer-col-desc {
      font-size: 0.83rem;
      line-height: 1.7;
      color: rgba(255,255,255,0.5);
      margin-bottom: 20px;
    }
    .footer-social {
      display: flex;
      gap: 10px;
    }
    .footer-social a {
      width: 34px; height: 34px;
      background: rgba(255,255,255,0.08);
      border: 1px solid rgba(255,255,255,0.12);
      border-radius: 8px;
      display: flex;
      align-items: center;
      justify-content: center;
      color: rgba(255,255,255,0.5);
      font-size: 0.85rem;
      text-decoration: none;
      transition: all 0.2s;
    }
    .footer-social a:hover {
      background: var(--blue);
      border-color: var(--blue);
      color: #fff;
    }
    .footer-col h5 {
      font-size: 0.82rem;
      font-weight: 700;
      color: #fff;
      text-transform: uppercase;
      letter-spacing: 1.2px;
      margin-bottom: 18px;
      padding-bottom: 10px;
      border-bottom: 1px solid rgba(255,255,255,0.08);
    }
    .footer-col ul {
      list-style: none;
      display: flex;
      flex-direction: column;
      gap: 10px;
    }
    .footer-col ul li a {
      color: rgba(255,255,255,0.5);
      text-decoration: none;
      font-size: 0.83rem;
      transition: color 0.2s;
      display: flex;
      align-items: center;
      gap: 7px;
    }
    .footer-col ul li a i {
      font-size: 0.7rem;
      color: var(--blue);
      opacity: 0.8;
    }
    .footer-col ul li a:hover { color: #fff; }
    .footer-contact-list {
      list-style: none;
      display: flex;
      flex-direction: column;
      gap: 14px;
    }
    .footer-contact-list li {
      display: flex;
      gap: 12px;
      align-items: flex-start;
    }
    .footer-contact-list li .icon {
      width: 30px; height: 30px;
      background: rgba(21,101,192,0.25);
      border-radius: 7px;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
      font-size: 0.78rem;
      color: #64b5f6;
      margin-top: 1px;
    }
    .footer-contact-list li .info {
      display: flex;
      flex-direction: column;
      gap: 2px;
    }
    .footer-contact-list li .info span:first-child {
      font-size: 0.72rem;
      color: rgba(255,255,255,0.35);
      text-transform: uppercase;
      letter-spacing: 0.8px;
      font-weight: 600;
    }
    .footer-contact-list li .info span:last-child {
      font-size: 0.83rem;
      color: rgba(255,255,255,0.7);
      line-height: 1.5;
    }
    .footer-divider {
      max-width: 1100px;
      margin: 0 auto;
      border: none;
      border-top: 1px solid rgba(255,255,255,0.08);
    }
    .footer-bottom {
      max-width: 1100px;
      margin: 0 auto;
      display: flex;
      align-items: center;
      justify-content: space-between;
      flex-wrap: wrap;
      gap: 12px;
      padding: 20px 0 24px;
    }
    .footer-bottom p {
      font-size: 0.8rem;
      color: rgba(255,255,255,0.35);
    }
    .footer-bottom p a {
      color: rgba(255,255,255,0.5);
      text-decoration: none;
    }
    .footer-bottom p a:hover { color: #fff; }
    .footer-bottom-links {
      display: flex;
      gap: 20px;
    }
    .footer-bottom-links a {
      color: rgba(255,255,255,0.35);
      text-decoration: none;
      font-size: 0.8rem;
      transition: color 0.2s;
    }
    .footer-bottom-links a:hover { color: #fff; }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 900px) {
      .hero-content { grid-template-columns: 1fr; gap: 40px; }
      .hero-text h1 { font-size: 2rem; }
      .fitur-grid { grid-template-columns: repeat(2, 1fr); }
      .alur-steps { grid-template-columns: repeat(2, 1fr); gap: 32px; }
      .alur-steps::before { display: none; }
      .footer-top { grid-template-columns: 1fr 1fr; gap: 32px; }
    }
    @media (max-width: 600px) {
      .hero-text h1 { font-size: 1.7rem; }
      .fitur-grid { grid-template-columns: 1fr; }
      .alur-steps { grid-template-columns: 1fr; }
      .nav-links a:not(.btn-nav-login) { display: none; }
      .section-title { font-size: 1.6rem; }
      .footer-top { grid-template-columns: 1fr; gap: 28px; }
      .footer-bottom { flex-direction: column; align-items: flex-start; gap: 8px; }
    }
  </style>
</head>
<body>

<!-- NAVBAR -->
<nav>
  <a href="<?= base_url('landing') ?>" class="nav-brand">
    <img src="<?= base_url('assets/images/logo-pemda.png') ?>" alt="Logo">
    <span>Sistem Monitoring Distribusi Surat</span>
  </a>
  <div class="nav-links">
    <a href="#fitur">Fitur</a>
    <a href="#alur">Cara Kirim</a>
    <a href="<?= base_url('surat-masuk/cek-status') ?>">Cek Status</a>
    <a href="<?= base_url('Auth') ?>" class="btn-nav-login">
      <i class="fas fa-sign-in-alt"></i> Login Petugas
    </a>
  </div>
</nav>

<!-- HERO -->
<section class="hero">
  <div class="hero-content">
    <div class="hero-text">
      <div class="badge">
        <i class="fas fa-circle" style="font-size:6px; color:#4caf50;"></i>
        Sistem Resmi Dinas Pendidikan Provinsi Papua
      </div>
      <h1>Kirim Surat ke <span>Dinas Pendidikan</span> Lebih Mudah</h1>
      <p>
        SIMDIS memudahkan instansi dan kantor Anda mengirimkan surat resmi secara digital.
        Pantau status surat Anda secara real-time tanpa perlu datang langsung ke kantor.
      </p>
      <div class="hero-actions">
        <a href="<?= base_url('surat-masuk') ?>" class="btn-primary">
          <i class="fas fa-paper-plane"></i> Kirim Surat Sekarang
        </a>
        <a href="<?= base_url('surat-masuk/cek-status') ?>" class="btn-outline">
          <i class="fas fa-search"></i> Cek Status Surat
        </a>
      </div>
    </div>

    <div class="hero-card">
      <h3><i class="fas fa-chart-bar" style="margin-right:6px;"></i> Keunggulan Sistem</h3>
      <div class="stat-grid">
        <div class="stat-item">
          <span class="num">24/7</span>
          <span class="label">Layanan Online</span>
        </div>
        <div class="stat-item">
          <span class="num">Real-time</span>
          <span class="label">Pantau Status</span>
        </div>
        <div class="stat-item">
          <span class="num">Gratis</span>
          <span class="label">Tanpa Biaya</span>
        </div>
        <div class="stat-item">
          <span class="num">Aman</span>
          <span class="label">Terenkripsi</span>
        </div>
      </div>
      <ul class="step-list">
        <li><span class="dot"></span> Isi form pengiriman surat online</li>
        <li><span class="dot"></span> Upload file surat (PDF)</li>
        <li><span class="dot"></span> Dapatkan kode tiket pelacakan</li>
        <li><span class="dot"></span> Pantau status surat kapan saja</li>
      </ul>
    </div>
  </div>
</section>

<!-- FITUR -->
<section id="fitur">
  <div class="section-inner">
    <div class="section-header">
      <div class="section-label">Fitur Unggulan</div>
      <h2 class="section-title">Semua yang Anda Butuhkan</h2>
      <p class="section-desc">Platform digital untuk pengelolaan surat masuk yang efisien, transparan, dan mudah digunakan.</p>
    </div>
    <div class="fitur-grid">
      <div class="fitur-card">
        <div class="fitur-icon"><i class="fas fa-paper-plane"></i></div>
        <h4>Pengiriman Surat Online</h4>
        <p>Kirim surat resmi dari instansi Anda kapan saja dan di mana saja tanpa perlu hadir langsung ke kantor.</p>
      </div>
      <div class="fitur-card">
        <div class="fitur-icon"><i class="fas fa-ticket-alt"></i></div>
        <h4>Kode Tiket Pelacakan</h4>
        <p>Setiap surat yang dikirim mendapatkan kode tiket unik untuk memudahkan pelacakan status secara mandiri.</p>
      </div>
      <div class="fitur-card">
        <div class="fitur-icon"><i class="fas fa-search"></i></div>
        <h4>Cek Status Real-time</h4>
        <p>Pantau perkembangan surat Anda secara langsung — mulai dari menunggu, diterima, hingga diproses.</p>
      </div>
      <div class="fitur-card">
        <div class="fitur-icon"><i class="fas fa-file-pdf"></i></div>
        <h4>Upload Lampiran PDF</h4>
        <p>Sertakan file surat dalam format PDF hingga 10MB sebagai lampiran digital yang aman dan terarsip.</p>
      </div>
      <div class="fitur-card">
        <div class="fitur-icon"><i class="fas fa-bell"></i></div>
        <h4>Notifikasi Otomatis</h4>
        <p>Petugas dinas mendapatkan notifikasi langsung setiap ada surat masuk baru dari instansi Anda.</p>
      </div>
      <div class="fitur-card">
        <div class="fitur-icon"><i class="fas fa-shield-alt"></i></div>
        <h4>Keamanan Data</h4>
        <p>Data surat dan informasi instansi Anda tersimpan dengan aman dan hanya dapat diakses oleh petugas berwenang.</p>
      </div>
    </div>
  </div>
</section>

<!-- ALUR -->
<section id="alur">
  <div class="section-inner">
    <div class="section-header">
      <div class="section-label">Cara Penggunaan</div>
      <h2 class="section-title">Kirim Surat dalam 4 Langkah</h2>
      <p class="section-desc">Proses pengiriman surat yang sederhana dan cepat, dirancang untuk kemudahan instansi Anda.</p>
    </div>
    <div class="alur-steps">
      <div class="alur-step">
        <div class="alur-num">1</div>
        <h4>Isi Formulir</h4>
        <p>Lengkapi data pengirim, nomor surat, tanggal, dan perihal surat dengan benar.</p>
      </div>
      <div class="alur-step">
        <div class="alur-num">2</div>
        <h4>Upload File</h4>
        <p>Lampirkan file surat dalam format PDF (opsional, maks. 10MB).</p>
      </div>
      <div class="alur-step">
        <div class="alur-num">3</div>
        <h4>Kirim & Catat Tiket</h4>
        <p>Submit formulir dan simpan kode tiket yang diberikan sistem untuk pelacakan.</p>
      </div>
      <div class="alur-step">
        <div class="alur-num">4</div>
        <h4>Pantau Status</h4>
        <p>Gunakan kode tiket untuk memantau status surat Anda kapan saja secara online.</p>
      </div>
    </div>
  </div>
</section>

<!-- CTA -->
<section id="cta">
  <div class="cta-inner">
    <h2>Siap Mengirim Surat?</h2>
    <p>
      Gunakan layanan digital SIMDIS untuk mengirimkan surat resmi ke Dinas Pendidikan Provinsi Papua
      dengan mudah, cepat, dan dapat dipantau secara real-time.
    </p>
    <div class="cta-buttons">
      <a href="<?= base_url('surat-masuk') ?>" class="btn-cta-white">
        <i class="fas fa-paper-plane"></i> Kirim Surat Sekarang
      </a>
      <a href="<?= base_url('surat-masuk/cek-status') ?>" class="btn-cta-outline">
        <i class="fas fa-search"></i> Cek Status Surat
      </a>
    </div>
  </div>
</section>

<!-- FOOTER -->
<footer>
  <div class="footer-top">

    <!-- Kolom 1: Brand & Deskripsi -->
    <div>
      <div class="footer-brand">
        <img src="<?= base_url('assets/images/logo-pemda.png') ?>" alt="Logo">
        <span>SIMDIS</span>
      </div>
      <p class="footer-col-desc">
        Sistem Monitoring Distribusi Surat resmi milik Dinas Pendidikan Provinsi Papua.
        Layanan digital untuk pengiriman dan pelacakan surat secara transparan.
      </p>
      <div class="footer-social">
        <a href="#" title="Facebook"><i class="fab fa-facebook-f"></i></a>
        <a href="#" title="Instagram"><i class="fab fa-instagram"></i></a>
        <a href="#" title="YouTube"><i class="fab fa-youtube"></i></a>
        <a href="#" title="Email"><i class="fas fa-envelope"></i></a>
      </div>
    </div>

    <!-- Kolom 2: Layanan -->
    <div class="footer-col">
      <h5>Layanan</h5>
      <ul>
        <li><a href="<?= base_url('surat-masuk') ?>"><i class="fas fa-chevron-right"></i> Kirim Surat</a></li>
        <li><a href="<?= base_url('surat-masuk/cek-status') ?>"><i class="fas fa-chevron-right"></i> Cek Status Surat</a></li>
        <li><a href="<?= base_url('Auth') ?>"><i class="fas fa-chevron-right"></i> Login Petugas</a></li>
      </ul>
    </div>

    <!-- Kolom 3: Navigasi -->
    <div class="footer-col">
      <h5>Informasi</h5>
      <ul>
        <li><a href="#fitur"><i class="fas fa-chevron-right"></i> Fitur Sistem</a></li>
        <li><a href="#alur"><i class="fas fa-chevron-right"></i> Cara Penggunaan</a></li>
        <li><a href="#cta"><i class="fas fa-chevron-right"></i> Mulai Sekarang</a></li>
      </ul>
    </div>

    <!-- Kolom 4: Kontak -->
    <div class="footer-col">
      <h5>Kontak Kami</h5>
      <ul class="footer-contact-list">
        <li>
          <div class="icon"><i class="fas fa-map-marker-alt"></i></div>
          <div class="info">
            <span>Alamat</span>
            <span>Jl. Tanjung Ria Base G Jayapura Papua 99771</span>
          </div>
        </li>
        <li>
          <div class="icon"><i class="fas fa-phone-alt"></i></div>
          <div class="info">
            <span>Telepon</span>
            <span>(0967) 531-XXX</span>
          </div>
        </li>
        <li>
          <div class="icon"><i class="fas fa-envelope"></i></div>
          <div class="info">
            <span>Email</span>
            <span>disdik@gmail.com</span>
          </div>
        </li>
        <li>
          <div class="icon"><i class="fas fa-clock"></i></div>
          <div class="info">
            <span>Jam Operasional</span>
            <span>Senin &ndash; Jumat, 08.00 &ndash; 16.00 WIT</span>
          </div>
        </li>
      </ul>
    </div>

  </div>

  <hr class="footer-divider">

  <div class="footer-bottom">
    <p>&copy; <?= date('Y') ?> <a href="<?= base_url('landing') ?>">SIMDIS</a> &mdash; Dinas Pendidikan Provinsi Papua. Hak Cipta Dilindungi.</p>
    <div class="footer-bottom-links">
      <a href="#">Kebijakan Privasi</a>
      <a href="#">Syarat Penggunaan</a>
      <a href="<?= base_url('Auth') ?>">Login Petugas</a>
    </div>
  </div>
</footer>

</body>
</html>
