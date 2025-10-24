<!DOCTYPE html>
<html lang="en">
@php
    use Illuminate\Support\Facades\Auth;

/**
 * @see \App\Http\Controllers\SiteController::index()
 */
@endphp
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Layanan Publik Kabupaten Subang</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

  <!-- Favicons -->
  <link href="{{ asset('images/logo.png') }}" rel="icon">
  <link href="{{ asset('images/logo.png') }}" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{ asset('home/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('home/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('home/vendor/aos/aos.css') }}" rel="stylesheet">
  <link href="{{ asset('home/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
  <link href="{{ asset('home/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="{{ asset('home/css/main.css') }}" rel="stylesheet">

  <!-- FullCalendar CSS -->
  <link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.7/index.global.min.css' rel='stylesheet' />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.5.0/css/all.min.css">

  


  <!-- =======================================================
  * Template Name: eNno
  * Template URL: https://bootstrapmade.com/enno-free-simple-bootstrap-template/
  * Updated: Aug 07 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body class="index-page">

  <header id="header" class="header d-flex align-items-center sticky-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center">

      <a href="index.html" class="logo d-flex align-items-center me-auto">
        <!-- Uncomment the line below if you also wish to use an image logo -->
        <img src="{{ asset('images/logo.png') }}" alt="">
        <h1 class="sitename">Layanan Publik Kabupaten Subang</h1>
         {{-- <h1 class="sitename"> Agenda Pimpinan</h1> --}}
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="#hero" class="active">Beranda</a></li>
          <li><a href="#evaluasi">Evaluasi</a></li>
          <li><a href="#contact">Kontak</a></li>
          {{-- <li><a href="#services">Services</a></li>
          <li><a href="#portfolio">Portfolio</a></li>
          <li><a href="#team">Team</a></li>
          <li class="dropdown"><a href="#"><span>Dropdown</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
            <ul>
              <li><a href="#">Dropdown 1</a></li>
              <li class="dropdown"><a href="#"><span>Deep Dropdown</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
                <ul>
                  <li><a href="#">Deep Dropdown 1</a></li>
                  <li><a href="#">Deep Dropdown 2</a></li>
                  <li><a href="#">Deep Dropdown 3</a></li>
                  <li><a href="#">Deep Dropdown 4</a></li>
                  <li><a href="#">Deep Dropdown 5</a></li>
                </ul>
              </li>
              <li><a href="#">Dropdown 2</a></li>
              <li><a href="#">Dropdown 3</a></li>
              <li><a href="#">Dropdown 4</a></li>
            </ul>
          </li> --}}
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

      <a class="btn-getstarted" href="{{ Auth::check() ? url('/dashboard') : route('login') }}">
          {{ Auth::check() ? 'Dashboard' : 'Login' }}
      </a>

    </div>
  </header>

  <main class="main">

    <!-- Hero Section -->
    <style>
      #hero {
        position: relative;
        color: white;
        height: 541px;
        background-image: url('{{ asset('images/landing/background-hero.png') }}');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        background-color: #000;
      }

      /* Overlay: nuansa hangat oranye -> kuning, tetap jaga keterbacaan */
      #hero::before {
        content: "";
        position: absolute;
        top: 0; left: 0;
        width: 100%;
        height: 100%;
        z-index: 1;
        background: linear-gradient(to left, rgba(0, 0, 0, 0.55), rgba(255, 213, 79, 0.10));
      }

      /* Ornamen top-right: background-section ter-crop sebagai aksen */
      #hero::after {
        content: "";
        position: absolute;
        top: 0; right: 0;
        width: min(40vw, 520px);
        height: min(40vw, 520px);
        background: url('{{ asset('images/landing/background-section.png') }}') no-repeat top right / contain;
        z-index: 2;
        pointer-events: none;
      }

      #hero .content {
        position: relative;
        z-index: 3;
        text-shadow: 2px 2px 6px rgba(0, 0, 0, 0.6); /* Supaya teks tetap terbaca tanpa gelapin gambar */
      }
      #hero .content-inner {
        max-width: 760px;
      }
      #hero .hero-heading {
        font-size: 16px;
        letter-spacing: .08em;
        font-weight: 700;
        opacity: .95;
        margin-bottom: .35rem;
      }
      #hero .hero-title {
        line-height: 1.2;
        letter-spacing: .2px;
        margin-bottom: 0;
      }

      /* Badge layananpublik.go.id di bawah judul */
      #hero .hero-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-top: 12px;
        padding: 4px 14px;
        border-radius: 999px;
        background: var(--brand-gradient);
        color: #fff;
        font-weight: 700;
        letter-spacing: .4px;
        box-shadow: 0 6px 18px rgba(255, 122, 0, .25);
        border: 1px solid rgba(255,255,255,.35);
        width: fit-content;
      }
      #hero .hero-badge .dot {
        width: 8px; height: 8px; border-radius: 50%; background: rgba(255,255,255,.85);
      }

      /* Gaya foto Bupati di kiri teks */
      #hero .bupati {
        position: relative;
        z-index: 3;
        display: flex;
        align-items: center;
        justify-content: center;
      }
      #hero .bupati img {
        max-height: 460px;
        width: auto;
        object-fit: contain;
        filter: drop-shadow(0 12px 28px rgba(0,0,0,.25));
      }

      /* Deretan logo di pojok kanan atas: latar putih + stroke */
      #hero .hero-logos {
        position: absolute;
        top: 0;
        right: 0;
        z-index: 4;
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 12px 16px;
        background-color: #ffffff;
        border-radius: 0 0 0 14px;
        min-height: 64px;
        border: 1.5px solid rgba(255, 138, 0, 0.6); /* stroke line */
        box-shadow: 0 10px 24px rgba(0,0,0,0.08);
      }
      #hero .hero-logos img { height: 36px; width: auto; filter: drop-shadow(0 2px 6px rgba(0,0,0,.25)); }

      @media (max-width: 768px) {
        #hero {
          background-size: cover;
          background-position: center;
          height: auto;
          padding: 60px 0;
          text-align: center;
        }

        #hero .row {
          justify-content: center !important;
        }

        #hero .bupati img { max-height: 300px; }
        #hero .content { text-align: center; }
        #hero .content-inner { margin: 0 auto; }
        #hero .hero-logos { top: 0; right: 0; gap: 10px; padding: 10px 12px; border-radius: 0 0 0 12px; }
        #hero .hero-logos img { height: 30px; }
        #hero::after { width: 55vw; height: 55vw; }
      }
    </style>
    <section id="hero" class="hero section d-flex align-items-center">
      <div class="container">
        <!-- Logo di pojok kanan atas -->
        <div class="hero-logos">
          <img src="{{ asset('images/logo.png') }}" alt="Logo Layanan Publik" />
          <img src="{{ asset('images/landing/logo-ngabret.png') }}" alt="Logo Ngabret" />
          <img src="{{ asset('images/landing/logo-berahlak.png') }}" alt="Logo BerAKHLAK" />
        </div>
        <div class="row align-items-center">
          <!-- Kolom Foto Bupati -->
          <div class="col-lg-5 mb-4 mb-lg-0 bupati" data-aos="fade-right">
            <img src="{{ asset('images/landing/foto-bupati-subang-v2.png') }}" alt="Bupati Subang" class="img-fluid">
          </div>

          <!-- Kolom Teks + Logo -->
          <div class="col-lg-7 content" data-aos="fade-left">
            <div class="content-inner">
              <h2 class="text-uppercase text-white hero-heading">Selamat Datang di Aplikasi</h2>
              <h1 class="display-4 text-white fw-bold hero-title">
                Evaluasi Kinerja Penyelenggaraan<br class="d-none d-lg-block" />Pelayanan Publik<br class="d-none d-lg-block" />
                Kabupaten Subang
              </h1>
              <div class="hero-badge" aria-label="Alamat laman Layanan Publik">
                <span style="color: black;">layananpublik.subang.go.id</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- End Hero Section -->

    <!-- THEME: warna utama (nuansa oranye ke kuning) -->
    <style>
      :root {
        --brand: #ffd54f; /* oranye utama */
        --brand-strong: #ff8c00; /* oranye lebih pekat */
        --brand-yellow: #ffd54f; /* kuning cerah */
        --brand-gradient: linear-gradient(135deg, #ffea00 0%, #ffb300 50%, #ffd54f 100%);
      }

      /* Utilitas warna brand */
      .brand-text { color: var(--brand) !important; }
      .brand-icon { color: var(--brand) !important; }
      .brand-border { border-color: var(--brand) !important; }
      .brand-bg { background: var(--brand) !important; color:#fff !important; }

      /* Heading teks dengan gradiasi */
      .gradient-text {
        background: var(--brand-gradient);
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
      }

      /* Section title default gunakan brand */
      .section-title h2,
      .section-title p {  }

      /* Kartu pada unsur & valuasi: border halus + hover aksen */
      #unsur-evaluasi .card,
      #valuasi .card {
        border:1px solid rgba(255, 138, 0, .18);
        box-shadow: 0 4px 16px rgba(255, 122, 0, 0.07);
      }
      #valuasi .card:hover,
      #unsur-evaluasi .card:hover { border-color: var(--brand); }

      /* Tombol header: override jadi gradiasi oranye-kuning */
      .header .btn-getstarted,
      .header .btn-getstarted:focus {
        background: var(--brand-gradient);
        border: none;
      }
      .header .btn-getstarted:hover,
      .header .btn-getstarted:focus:hover {
        background: linear-gradient(135deg, #ff8c00 0%, #ffc107 60%, #ffe082 100%);
      }
    </style>

    <!-- Evaluasi Kinerja Section -->
    <section id="evaluasi" class="section py-5">
      <div class="container section-title" data-aos="fade-up">
        <h2 class="brand-text">Evaluasi Kinerja Penyelenggaraan Pelayanan Publik</h2>
        <p class="mb-0">
          Evaluasi kinerja penyelenggaraan pelayanan publik di Kabupaten Subang merupakan upaya sistematis
          untuk menilai sejauh mana pelayanan yang diberikan oleh perangkat daerah mampu menjawab kebutuhan
          masyarakat. Proses evaluasi ini tidak hanya mengukur tingkat kepuasan publik, tetapi juga mendorong
          peningkatan kualitas tata kelola pemerintahan yang transparan, akuntabel, dan berorientasi hasil.
        </p>
      </div>

      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row align-items-center">
          <div class="col-lg-6">
            <ul style="list-style:none; padding-left:0;">
              <li style="display:flex; align-items:center; margin-bottom:1rem; color:#4a4a4a; font-weight:500;">
                <span class="brand-icon" style="font-size:1.5rem; margin-right:.75rem;">
                  <i class="bi bi-check-circle-fill"></i>
                </span>
                Menilai efektivitas pelayanan publik dalam memenuhi kebutuhan dan harapan masyarakat Subang.
              </li>
              <li style="display:flex; align-items:center; margin-bottom:1rem; color:#4a4a4a; font-weight:500;">
                <span class="brand-icon" style="font-size:1.5rem; margin-right:.75rem;">
                  <i class="bi bi-check-circle-fill"></i>
                </span>
                Mendorong akuntabilitas dan transparansi kinerja perangkat daerah.
              </li>
              <li style="display:flex; align-items:center; margin-bottom:1rem; color:#4a4a4a; font-weight:500;">
                <span class="brand-icon" style="font-size:1.5rem; margin-right:.75rem;">
                  <i class="bi bi-check-circle-fill"></i>
                </span>
                Memberikan dasar perbaikan berkelanjutan dalam sistem pelayanan publik.
              </li>
            </ul>
          </div>

          <div class="col-lg-6 text-center">
            <img src="{{ asset('home/img/eval.avif') }}"
                alt="Infografis Evaluasi Kinerja"
                class="img-fluid rounded brand-border"
                style="max-height:300px; object-fit:contain;">
          </div>
        </div>
      </div>
    </section>
    <!-- End Evaluasi Kinerja Section -->

    <!-- Unsur Evaluasi Section -->
    <section id="unsur-evaluasi" class="how-we-work section">
      <style>
        #unsur-evaluasi .container > .row {
          display:flex; align-items:stretch; justify-content:center; gap:30px;
        }
        .process-container, .col-lg-5.d-flex { display:flex; flex-direction:column; height:100%; }
        .col-lg-5.d-flex .card {
          flex:1; display:flex; justify-content:center; align-items:center;
          box-shadow:0 0 10px rgb(0 0 0 / 0.08); border-radius:8px;
        }
        .col-lg-5.d-flex img { max-height:100%; width:auto; object-fit:contain; border-radius:8px; }
        .step-number { font-weight:700; font-size:1.5rem; color:var(--brand); margin-right:10px; }
        .process-item { margin-bottom:20px; }
        .step-icon { color:var(--brand); }
      </style>

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2 class="brand-text">Unsur Evaluasi</h2>
        <p>
          Evaluasi kinerja pelayanan publik di Kabupaten Subang didasarkan pada sejumlah unsur penting
          yang menjadi tolok ukur perbaikan dan inovasi. Unsur-unsur ini dirancang untuk memastikan
          pelayanan publik berlangsung efektif, efisien, serta mampu menjawab tuntutan masyarakat.
        </p>
      </div>

      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row justify-content-center align-items-stretch">

          <!-- Daftar Unsur Evaluasi -->
          <div class="process-container col-lg-5 col-md-6 mb-4">
            
            <div class="process-item" data-aos="fade-up" data-aos-delay="200">
              <div class="content d-flex align-items-center">
                <span class="step-number">1</span>
                <div class="card-body d-flex align-items-center gap-3 p-0">
                  <div class="step-icon fs-3"><i class="bi bi-gear"></i></div>
                  <div class="step-content">
                    <h3 class="fw-bold">Kebijakan Pelayanan</h3>
                    <p>Kebijakan yang menjadi dasar penyelenggaraan pelayanan publik.</p>
                  </div>
                </div>
              </div>
            </div>

            <div class="process-item" data-aos="fade-up" data-aos-delay="300">
              <div class="content d-flex align-items-center">
                <span class="step-number">2</span>
                <div class="card-body d-flex align-items-center gap-3 p-0">
                  <div class="step-icon fs-3"><i class="bi bi-person-badge"></i></div>
                  <div class="step-content">
                    <h3 class="fw-bold">Profesionalisme SDM</h3>
                    <p>Kapasitas, kompetensi, dan integritas aparatur penyelenggara layanan.</p>
                  </div>
                </div>
              </div>
            </div>

            <div class="process-item" data-aos="fade-up" data-aos-delay="400">
              <div class="content d-flex align-items-center">
                <span class="step-number">3</span>
                <div class="card-body d-flex align-items-center gap-3 p-0">
                  <div class="step-icon fs-3"><i class="bi bi-building"></i></div>
                  <div class="step-content">
                    <h3 class="fw-bold">Sarana dan Prasarana</h3>
                    <p>Ketersediaan fasilitas pendukung yang memadai untuk pelayanan publik.</p>
                  </div>
                </div>
              </div>
            </div>

            <div class="process-item" data-aos="fade-up" data-aos-delay="500">
              <div class="content d-flex align-items-center">
                <span class="step-number">4</span>
                <div class="card-body d-flex align-items-center gap-3 p-0">
                  <div class="step-icon fs-3"><i class="bi bi-laptop"></i></div>
                  <div class="step-content">
                    <h3 class="fw-bold">Sistem Informasi Pelayanan Publik</h3>
                    <p>Pemanfaatan teknologi informasi dalam mendukung transparansi dan efisiensi.</p>
                  </div>
                </div>
              </div>
            </div>

            <div class="process-item" data-aos="fade-up" data-aos-delay="600">
              <div class="content d-flex align-items-center">
                <span class="step-number">5</span>
                <div class="card-body d-flex align-items-center gap-3 p-0">
                  <div class="step-icon fs-3"><i class="bi bi-chat-dots"></i></div>
                  <div class="step-content">
                    <h3 class="fw-bold">Konsultasi Pengaduan</h3>
                    <p>Mekanisme penerimaan, penanganan, dan tindak lanjut pengaduan masyarakat.</p>
                  </div>
                </div>
              </div>
            </div>

            <div class="process-item" data-aos="fade-up" data-aos-delay="700">
              <div class="content d-flex align-items-center">
                <span class="step-number">6</span>
                <div class="card-body d-flex align-items-center gap-3 p-0">
                  <div class="step-icon fs-3"><i class="bi bi-lightbulb"></i></div>
                  <div class="step-content">
                    <h3 class="fw-bold">Inovasi</h3>
                    <p>Upaya pembaruan dan kreativitas dalam meningkatkan kualitas pelayanan.</p>
                  </div>
                </div>
              </div>
            </div>

          </div>

          <!-- Infografis Unsur -->
          <div class="col-lg-5 col-md-6 d-flex">
            <img src="{{ asset('home/img/unsur evaluasi.png') }}"
                alt="Infografis Unsur Evaluasi"
                class="img-fluid rounded brand-border"
                style="object-fit:contain; height:auto; max-height:550px; margin-top:30px;">
          </div>

        </div>
      </div>
    </section>
    <!-- End Unsur Evaluasi Section -->

    <!-- Valuasi Kinerja (Pengganti Sambutan Resmi) -->
    <section id="valuasi" class="section py-5 bg-light">
      <div class="container">
        <div class="row align-items-start g-4">

          <div class="col-12">
            <h3 class="fw-bold mb-2 brand-text">Evaluasi Kinerja Penyelenggaraan Pelayanan Publik Kabupaten Subang</h3>
            <p class="mb-4" style="text-align:justify;">
              Evaluasi kinerja berfokus pada nilai yang dihasilkan layanan publik terhadap manfaat bagi masyarakat.
              Pendekatan ini menggabungkan efektivitas, efisiensi biaya, dampak sosial, serta keberlanjutan inovasi layanan.
              Hasil evaluasi memberikan dasar pengambilan keputusan anggaran dan perbaikan layanan yang terukur.
            </p>
          </div>

          <!-- Kartu Ringkas -->
          <div class="col-md-6 col-lg-3">
            <div class="card h-100">
              <div class="card-body">
                <div class="d-flex align-items-center mb-2">
                  <i class="bi bi-bullseye fs-3 brand-text me-2"></i>
                  <h5 class="mb-0 fw-bold">Tujuan</h5>
                </div>
                <p class="mb-0">Mengukur nilai manfaat layanan terhadap kebutuhan warga dan prioritas daerah.</p>
              </div>
            </div>
          </div>

          <div class="col-md-6 col-lg-3">
            <div class="card h-100">
              <div class="card-body">
                <div class="d-flex align-items-center mb-2">
                  <i class="bi bi-graph-up fs-3 brand-text me-2"></i>
                  <h5 class="mb-0 fw-bold">Pendekatan</h5>
                </div>
                <p class="mb-0">Kombinasi KPI kinerja, analisis biaya-manfaat, dan umpan balik pengguna.</p>
              </div>
            </div>
          </div>

          <div class="col-md-6 col-lg-3">
            <div class="card h-100">
              <div class="card-body">
                <div class="d-flex align-items-center mb-2">
                  <i class="bi bi-speedometer2 fs-3 brand-text me-2"></i>
                  <h5 class="mb-0 fw-bold">Indikator</h5>
                </div>
                <ul class="mb-0 ps-3">
                  <li>Waktu layanan & SLA</li>
                  <li>Kepuasan & aksesibilitas</li>
                  <li>Biaya per layanan</li>
                </ul>
              </div>
            </div>
          </div>

          <div class="col-md-6 col-lg-3">
            <div class="card h-100">
              <div class="card-body">
                <div class="d-flex align-items-center mb-2">
                  <i class="bi bi-shield-check fs-3 brand-text me-2"></i>
                  <h5 class="mb-0 fw-bold">Output</h5>
                </div>
                <p class="mb-0">Rekomendasi perbaikan terukur, prioritas inovasi, dan penguatan tata kelola.</p>
              </div>
            </div>
          </div>

          <!-- Alur Singkat -->
          <div class="col-12 mt-4">
            <div class="p-4 rounded brand-border" style="border:2px solid;">
              <h5 class="fw-bold mb-3">Alur Evaluasi Singkat</h5>
              <div class="row g-3">
                <div class="col-md-3">
                  <div class="p-3 h-100 border rounded">
                    <div class="fw-semibold mb-1">1. Penetapan KPI</div>
                    <small>Menurunkan tujuan daerah menjadi indikator terukur per layanan.</small>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="p-3 h-100 border rounded">
                    <div class="fw-semibold mb-1">2. Pengumpulan Data</div>
                    <small>Operasional, biaya, dan persepsi masyarakat (survei/aduan).</small>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="p-3 h-100 border rounded">
                    <div class="fw-semibold mb-1">3. Analisis Nilai</div>
                    <small>Perbandingan capaian vs target, biaya vs manfaat, dampak sosial.</small>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="p-3 h-100 border rounded">
                    <div class="fw-semibold mb-1">4. Rekomendasi</div>
                    <small>Action plan perbaikan & inovasi dengan time-bound milestone.</small>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- End Valuasi Kinerja -->

    <!-- Contact Section -->
    <style>
        .chatbot-box {
          background-color: #f9f9f9; /* very light grey/cream */
          border: 1.5px solid #ddd; /* soft grey border */
          border-radius: 10px;
        }

        .chatbot-messages::-webkit-scrollbar-thumb {
          background-color: #ccc; /* scrollbar soft grey */
        }

        .chatbot-header {
          color: #555; /* abu-abu gelap untuk header */
          font-weight: 600;
        }

        .badge.bg-warning {
          background-color: #bbb; /* badge abu-abu soft */
          color: #444;
        }

        .chat-bubble.bot > div {
          background-color: #e9ecef; /* very light grey bubble */
          color: #333; /* teks gelap */
        }

        .chat-bubble.user > div {
          background-color: #6c757d; /* abu-abu gelap */
          color: #fff;
        }

        .btn.btn-warning {
          background-color: #6c757d; /* tombol kirim abu-abu gelap */
          border-color: #5a6268;
        }

        .btn.btn-warning:hover {
          background-color: #5a6268;
          border-color: #545b62;
        }
    </style>

    <section id="contact" class="contact section py-5">
      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        {{-- <span>Kontak</span> --}}
        <h2 class="brand-text">Kontak</h2>
        <p class="mb-0">Butuh Bantuan? Hubungi Kami</p>

      </div>

      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row gy-4 align-items-stretch">

          <!-- Info Kontak -->
          <div class="col-lg-12">
            <div class="info-wrap h-100 d-flex flex-column justify-content-between">
              <div class="row text-center">
                <div class="col-md-4 d-flex flex-column align-items-center" data-aos="fade-up" data-aos-delay="200">
                  <i class="bi bi-geo-alt fs-3 mb-2 brand-icon"></i>
                  <h5>Alamat</h5>
                  <p class="mb-0">Jl. Otto Iskandardinata No. 2, Subang, Jawa Barat</p>
                </div>
                <div class="col-md-4 d-flex flex-column align-items-center" data-aos="fade-up" data-aos-delay="300">
                  <i class="bi bi-telephone fs-3 mb-2 brand-icon"></i>
                  <h5>Telepon</h5>
                  <p class="mb-0">(0260) 411500</p>
                </div>
                <div class="col-md-4 d-flex flex-column align-items-center" data-aos="fade-up" data-aos-delay="400">
                  <i class="bi bi-envelope fs-3 mb-2 brand-icon"></i>
                  <h5>Email</h5>
                  <p class="mb-0">diskominfo@subang.go.id</p>
                </div>
              </div>

              <!-- Google Maps -->
              <div class="mt-4">
                <iframe
                  src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3963.123456789!2d107.75645!3d-6.57589!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e690f9b1234567%3A0xabcdef1234567890!2sPemkab%20Subang!5e0!3m2!1sen!2sid!4v0000000000000"
                  frameborder="0" style="border:0; width:100%; height:270px;" allowfullscreen="" loading="lazy"
                  referrerpolicy="no-referrer-when-downgrade"></iframe>
              </div>
            </div>
          </div>

        </div>
      </div>
    </section>
    <!-- End Contact Section -->

  </main>

  <footer id="footer" class="footer">
    <div class="container footer-top">
      <div class="row gy-4">
        <div class="col-lg-4 col-md-6 footer-about">
          <a href="index.html" class="d-flex align-items-center">
            <span class="sitename" style="margin-top: -15px;">Layanan Publik Kabupaten Subang</span>
          </a>
          <div class="footer-contact pt-3">
            <p>Jl. Otto Iskandardinata No. 2, Subang, Jawa Barat</p>
            <p class="mt-3"><strong>Telepon:</strong> <span>(0260) 411500</span></p>
            <p><strong>Email:</strong> <span>diskominfo@subang.go.id</span></p>
          </div>
        </div>

        <div class="col-lg-2 col-md-3 footer-links">
          <h4>Link Penting</h4>
          <ul>
            <li><i class="bi bi-chevron-right"></i> <a href="#">Beranda</a></li>
            <li><i class="bi bi-chevron-right"></i> <a href="#">Layanan</a></li>
            <li><i class="bi bi-chevron-right"></i> <a href="https://subang.go.id/">Portal Kabupaten Subang</a></li>
            <li><i class="bi bi-chevron-right"></i> <a href="https://ppid.subang.go.id">PPID Kabupaten Subang</a></li>
          </ul>
        </div>

        <div class="col-lg-2 col-md-3 footer-links">
          <h4>Statistik Pengunjung</h4>
          <ul>
            <li><i class="bi bi-people-fill me-1"></i> <a href="#">Total Pengunjung : {{ number_format($totalVisitors ?? 0) }}</a></li>
            <li><i class="bi bi-calendar-day me-1"></i> <a href="#">Hari ini : {{ number_format($todayVisitors ?? 0) }} </a></li>
            <li><i class="bi bi-calendar3 me-1"></i> <a href="#">Bulan ini : {{ number_format($monthlyVisitors ?? 0) }}</a></li>
            <li><i class="bi bi-calendar-check me-1"></i> <a href="#">Tahun ini : {{ number_format($yearlyVisitors ?? 0) }}</a></li>
          </ul>
        </div>

        <div class="col-lg-4 col-md-12">
          <h4>Ikuti Kami</h4>
          <p>Ikuti update resmi Pemerintah Kabupaten Subang melalui media sosial berikut:</p>
          <div class="social-links d-flex">
            <a href="https://www.tiktok.com/@pemkabsubang" target="_blank" rel="noopener"><i class="bi bi-tiktok"></i></a>
            <a href="https://www.facebook.com/pemkabsubang" target="_blank" rel="noopener"><i class="bi bi-facebook"></i></a>
            <a href="https://instagram.com/pemkabsubang" target="_blank" rel="noopener"><i class="bi bi-instagram"></i></a>
            <a href="https://twitter.com/pemkabsubang" target="_blank" rel="noopener"><i class="bi bi-twitter"></i></a>
          </div>
        </div>
      </div>
    </div>

    <div class="container copyright text-center mt-4">
      <p>© <span>Copyright</span> <strong class="px-1 sitename">Layanan Publik Kabupaten Subang</strong> <span>All Rights Reserved</span></p>
      <div class="credits">
        {{-- Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a> Distributed by <a href="https://themewagon.com">ThemeWagon</a> --}}
      </div>
    </div>
  </footer>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="{{ asset('home/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('home/vendor/php-email-form/validate.js') }}"></script>
  <script src="{{ asset('home/vendor/aos/aos.js') }}"></script>
  <script src="{{ asset('home/vendor/glightbox/js/glightbox.min.js') }}"></script>
  <script src="{{ asset('home/vendor/purecounter/purecounter_vanilla.js') }}"></script>
  <script src="{{ asset('home/vendor/imagesloaded/imagesloaded.pkgd.min.js') }}"></script>
  <script src="{{ asset('home/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
  <script src="{{ asset('home/vendor/swiper/swiper-bundle.min.js') }}"></script>

  <!-- Main JS File -->
  <script src="{{ asset('home/js/main.js') }}"></script>

  <!-- FullCalendar JS -->
  <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.7/index.global.min.js'></script>

  <script>
    function showDetailPimpinan(data) {
      const fotoUrl = data.foto 
        ? `{{ url('storage/unsur-pimpinan') }}/${data.foto}` 
        : `{{ asset('images/image-not-found.png') }}`;

      document.getElementById('modalFoto').src = fotoUrl;
      document.getElementById('modalNama').innerText = data.nama ?? '-';
      document.getElementById('modalJabatan').innerHTML = data.jabatan ?? '-';
      document.getElementById('modalPendidikan').innerHTML = data.riwayat_pendidikan ?? '-';
      document.getElementById('modalJabatanRiwayat').innerHTML = data.riwayat_jabatan ?? '-';

      const sosmed = [];
      if (data.tautan_fb)
        sosmed.push(`<a href="${data.tautan_fb}" target="_blank" class="btn btn-sm btn-primary me-2"><i class="fab fa-facebook-f"></i></a>`);
      if (data.tautan_ig)
        sosmed.push(`<a href="${data.tautan_ig}" target="_blank" class="btn btn-sm btn-danger me-2"><i class="fab fa-instagram"></i></a>`);
      if (data.tautan_tiktok)
      sosmed.push(`<a href="${data.tautan_tiktok}" target="_blank" class="btn btn-sm btn-dark me-2"><i class="fab fa-tiktok"></i></a>`);
    
    document.getElementById('modalSosmed').innerHTML = sosmed.join('');
    }
  </script>

</body>

</html>
