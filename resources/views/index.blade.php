@extends('layouts.app')

@section('title', 'Nanap Shop - Platform Manajemen Produk Terbaik')

@section('content')

{{-- ========================================================
     INLINE STYLES KHUSUS HALAMAN LANDING
     ======================================================== --}}
<style>
    /* ---- Reset & Base ---- */
    .landing-wrap {
        margin: -2rem 0;   /* batalkan padding dari main di layout */
        overflow-x: hidden;
    }

    /* ---- Animasi Global ---- */
    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(28px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    @keyframes floatBlob {
        0%, 100% { transform: translateY(0)   scale(1);    }
        50%       { transform: translateY(-22px) scale(1.04); }
    }
    @keyframes pulse-ring {
        0%   { box-shadow: 0 0 0 0   rgba(102,126,234,.35); }
        70%  { box-shadow: 0 0 0 14px rgba(102,126,234,0);  }
        100% { box-shadow: 0 0 0 0   rgba(102,126,234,0);   }
    }

    .anim-up { animation: fadeUp .7s ease both; }
    .delay-1 { animation-delay: .1s; }
    .delay-2 { animation-delay: .2s; }
    .delay-3 { animation-delay: .3s; }
    .delay-4 { animation-delay: .4s; }

    /* ---- HERO ---- */
    .hero-section {
        min-height: 92vh;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        text-align: center;
        padding: 5rem 1.5rem 4rem;
        position: relative;
        overflow: hidden;
        background: linear-gradient(160deg, #f0f4ff 0%, #faf5ff 50%, #f0fff4 100%);
    }
    .hero-section::before {
        content: '';
        position: absolute;
        inset: 0;
        background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Ccircle cx='30' cy='30' r='3' fill='%23667eea' fill-opacity='.045'/%3E%3C/svg%3E") ;
        pointer-events: none;
    }

    /* Floating blobs */
    .blob {
        position: absolute;
        border-radius: 50%;
        opacity: .13;
        pointer-events: none;
        animation: floatBlob 7s ease-in-out infinite;
    }
    .blob-1 { width: 380px; height: 380px; background: var(--primary-color);   top: -100px; right: -80px;  animation-delay: 0s;  }
    .blob-2 { width: 240px; height: 240px; background: var(--secondary-color); bottom: 20px; left: -60px; animation-delay: 2.5s;}
    .blob-3 { width: 160px; height: 160px; background: var(--success-color);   bottom: 110px; right: 60px; animation-delay: 5s;  }

    .hero-badge {
        display: inline-flex;
        align-items: center;
        gap: .45rem;
        background: rgba(102,126,234,.1);
        border: 1px solid rgba(102,126,234,.25);
        color: var(--primary-color);
        border-radius: 2rem;
        padding: .4rem 1.1rem;
        font-size: .8rem;
        font-weight: 700;
        letter-spacing: .03em;
        margin-bottom: 1.6rem;
    }

    .hero-title {
        font-size: clamp(2.2rem, 6vw, 4.2rem);
        font-weight: 800;
        line-height: 1.15;
        color: #1a1a2e;
        margin-bottom: 1.3rem;
    }
    .hero-title .gradient-text {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .hero-desc {
        max-width: 580px;
        font-size: 1.05rem;
        color: #718096;
        line-height: 1.85;
        margin: 0 auto 2.5rem;
    }

    .hero-actions {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
        justify-content: center;
    }

    .btn-hero-primary {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        color: #fff;
        border: none;
        border-radius: .6rem;
        padding: .8rem 2.2rem;
        font-size: 1rem;
        font-weight: 700;
        cursor: pointer;
        transition: all .3s;
        box-shadow: 0 6px 22px rgba(102,126,234,.38);
        animation: pulse-ring 2.5s ease-in-out infinite;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: .5rem;
    }
    .btn-hero-primary:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 30px rgba(102,126,234,.48);
        color: #fff;
    }

    .btn-hero-outline {
        background: #fff;
        color: var(--primary-color);
        border: 2px solid rgba(102,126,234,.25);
        border-radius: .6rem;
        padding: .8rem 2.2rem;
        font-size: 1rem;
        font-weight: 700;
        text-decoration: none;
        transition: all .3s;
        display: inline-flex;
        align-items: center;
        gap: .5rem;
    }
    .btn-hero-outline:hover {
        border-color: var(--primary-color);
        transform: translateY(-2px);
        color: var(--primary-color);
    }

    /* ---- STATS ---- */
    .stats-section {
        padding: 3.5rem 0;
        background: #fff;
        border-top: 1px solid #f0f0f0;
        border-bottom: 1px solid #f0f0f0;
    }
    .stat-card {
        text-align: center;
        padding: 2rem 1rem;
        border-radius: 1rem;
        transition: all .3s;
    }
    .stat-card:hover { transform: translateY(-5px); }
    .stat-icon-wrap {
        width: 56px; height: 56px;
        border-radius: .875rem;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.35rem;
        color: #fff;
        margin: 0 auto 1rem;
    }
    .ic-purple  { background: linear-gradient(135deg,#667eea,#764ba2); }
    .ic-green   { background: linear-gradient(135deg,#43e97b,#38f9d7); }
    .ic-orange  { background: linear-gradient(135deg,#f6d365,#fda085); }
    .ic-pink    { background: linear-gradient(135deg,#f093fb,#f5576c); }

    .stat-number {
        font-size: 2.2rem;
        font-weight: 800;
        color: #1a1a2e;
        line-height: 1;
    }
    .stat-label {
        font-size: .82rem;
        color: #718096;
        font-weight: 600;
        margin-top: .3rem;
    }

    /* ---- FITUR ---- */
    .features-section { padding: 5rem 0; background: #f8f9fa; }

    .section-pill {
        display: inline-block;
        background: rgba(102,126,234,.1);
        color: var(--primary-color);
        border-radius: 2rem;
        padding: .3rem 1rem;
        font-size: .78rem;
        font-weight: 700;
        margin-bottom: .75rem;
        letter-spacing: .04em;
    }
    .section-heading {
        font-size: clamp(1.6rem, 4vw, 2.5rem);
        font-weight: 800;
        color: #1a1a2e;
    }
    .section-sub {
        color: #718096;
        font-size: 1rem;
        margin-top: .5rem;
    }

    .feature-card {
        background: #fff;
        border-radius: 1rem;
        padding: 2rem;
        height: 100%;
        border: 1px solid rgba(0,0,0,.06);
        box-shadow: 0 2px 16px rgba(0,0,0,.04);
        transition: all .35s;
    }
    .feature-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 14px 40px rgba(0,0,0,.1);
    }
    .feature-icon {
        width: 50px; height: 50px;
        border-radius: .75rem;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.15rem;
        color: #fff;
        margin-bottom: 1.25rem;
    }
    .feature-card h5 { font-weight: 700; color: #1a1a2e; margin-bottom: .6rem; }
    .feature-card p  { font-size: .9rem; color: #718096; line-height: 1.75; margin: 0; }

    /* ---- PRODUK ---- */
    .products-section {
        padding: 5rem 0;
        background: linear-gradient(160deg,#f8f9ff,#fff8ff);
    }

    .product-card {
        background: #fff;
        border-radius: 1rem;
        overflow: hidden;
        border: 1px solid rgba(0,0,0,.06);
        box-shadow: 0 2px 16px rgba(0,0,0,.05);
        transition: all .35s;
        height: 100%;
    }
    .product-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 18px 44px rgba(0,0,0,.12);
    }
    .product-thumb {
        height: 160px;
        display: flex; align-items: center; justify-content: center;
        font-size: 3.5rem;
    }
    .product-body { padding: 1.3rem; }
    .product-cat {
        font-size: .72rem; font-weight: 700;
        color: var(--primary-color);
        text-transform: uppercase;
        letter-spacing: .07em;
        margin-bottom: .35rem;
    }
    .product-name { font-size: 1rem; font-weight: 700; color: #1a1a2e; margin-bottom: .4rem; }
    .product-price {
        font-size: 1.1rem; font-weight: 800;
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    .product-footer {
        display: flex; align-items: center; justify-content: space-between;
        margin-top: 1rem;
    }
    .badge-in  { background: rgba(104,211,145,.15); color: #2d5a3d; font-size:.72rem; padding:.3rem .75rem; border-radius:2rem; font-weight:600; }
    .badge-out { background: rgba(245,101,101,.12); color: #c53030; font-size:.72rem; padding:.3rem .75rem; border-radius:2rem; font-weight:600; }

    .btn-add {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        color: #fff; border: none; border-radius: .5rem;
        padding: .4rem 1rem; font-size: .82rem; font-weight: 700;
        cursor: pointer; transition: all .25s;
        text-decoration: none; display: inline-block;
    }
    .btn-add:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(102,126,234,.4);
        color: #fff;
    }

    /* ---- CTA BANNER ---- */
    .cta-section {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        padding: 5.5rem 1.5rem;
        text-align: center;
        color: #fff;
        position: relative;
        overflow: hidden;
    }
    .cta-section::before {
        content: '';
        position: absolute;
        width: 500px; height: 500px;
        background: rgba(255,255,255,.06);
        border-radius: 50%;
        top: -200px; right: -100px;
        pointer-events: none;
    }
    .cta-section::after {
        content: '';
        position: absolute;
        width: 300px; height: 300px;
        background: rgba(255,255,255,.06);
        border-radius: 50%;
        bottom: -100px; left: -80px;
        pointer-events: none;
    }
    .cta-section h2 {
        font-size: clamp(1.8rem, 5vw, 3rem);
        font-weight: 800;
        margin-bottom: 1rem;
    }
    .cta-section p {
        opacity: .85; font-size: 1.05rem;
        max-width: 520px; margin: 0 auto 2.2rem; line-height: 1.8;
    }
    .btn-cta-white {
        background: #fff; color: var(--primary-color);
        border: none; border-radius: .6rem;
        padding: .85rem 2.5rem; font-size: 1rem; font-weight: 800;
        text-decoration: none; display: inline-block;
        transition: all .3s;
    }
    .btn-cta-white:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 30px rgba(0,0,0,.22);
        color: var(--primary-color);
    }

    /* ---- RESPONSIVE ---- */
    @media (max-width: 576px) {
        .hero-actions { flex-direction: column; align-items: center; }
        .btn-hero-primary, .btn-hero-outline { width: 100%; justify-content: center; }
    }
</style>

<div class="landing-wrap">

    {{-- ============================================================
         SECTION 1 — HERO
         ============================================================ --}}
    <section class="hero-section">
        {{-- Blobs --}}
        <div class="blob blob-1"></div>
        <div class="blob blob-2"></div>
        <div class="blob blob-3"></div>

        <div class="hero-badge anim-up">
            <i class="fas fa-star fa-xs"></i> Platform Manajemen Produk Terpercaya
        </div>

        <h1 class="hero-title anim-up delay-1">
            Kelola Produk Anda<br>
            dengan <span class="gradient-text">Lebih Mudah</span>
        </h1>

        <p class="hero-desc anim-up delay-2">
            Nanap Shop hadir sebagai solusi lengkap untuk manajemen produk dan kategori
            bisnis Anda. Fitur CRUD yang intuitif, cepat, dan efisien — semua dalam
            satu platform yang elegan.
        </p>

        <div class="hero-actions anim-up delay-3">
            <a href="{{ route('products.index') }}" class="btn-hero-primary">
                <i class="fas fa-rocket"></i> Jelajahi Produk
            </a>
            <a href="{{ route('login') }}" class="btn-hero-outline">
                <i class="fas fa-sign-in-alt"></i> Masuk Sekarang
            </a>
        </div>
    </section>

    {{-- ============================================================
         SECTION 2 — STATISTIK
         ============================================================ --}}
    <section class="stats-section">
        <div class="container">
            <div class="row g-3 justify-content-center">
                <div class="col-6 col-md-3">
                    <div class="stat-card anim-up delay-1">
                        <div class="stat-icon-wrap ic-purple">
                            <i class="fas fa-box"></i>
                        </div>
                        <div class="stat-number">1.240+</div>
                        <div class="stat-label">Total Produk</div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-card anim-up delay-2">
                        <div class="stat-icon-wrap ic-green">
                            <i class="fas fa-folder-open"></i>
                        </div>
                        <div class="stat-number">48</div>
                        <div class="stat-label">Kategori Aktif</div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-card anim-up delay-3">
                        <div class="stat-icon-wrap ic-orange">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="stat-number">320+</div>
                        <div class="stat-label">Pengguna Aktif</div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-card anim-up delay-4">
                        <div class="stat-icon-wrap ic-pink">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <div class="stat-number">99.9%</div>
                        <div class="stat-label">Uptime System</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ============================================================
         SECTION 3 — FITUR UNGGULAN
         ============================================================ --}}
    <section class="features-section">
        <div class="container">
            <div class="text-center mb-5 anim-up">
                <span class="section-pill">FITUR UNGGULAN</span>
                <h2 class="section-heading">Semua yang Anda Butuhkan</h2>
                <p class="section-sub">Dirancang untuk kemudahan pengelolaan inventaris dan produk bisnis Anda</p>
            </div>

            <div class="row g-4">
                <div class="col-md-6 col-lg-4 anim-up delay-1">
                    <div class="feature-card">
                        <div class="feature-icon ic-purple">
                            <i class="fas fa-plus"></i>
                        </div>
                        <h5>Tambah Produk Mudah</h5>
                        <p>Form intuitif untuk menambahkan produk baru dengan nama, harga, stok, dan kategori dalam hitungan detik.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 anim-up delay-2">
                    <div class="feature-card">
                        <div class="feature-icon ic-green">
                            <i class="fas fa-edit"></i>
                        </div>
                        <h5>Edit & Perbarui Data</h5>
                        <p>Perbarui informasi produk kapan saja dengan editor yang responsif dan menyimpan perubahan secara real-time.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 anim-up delay-3">
                    <div class="feature-card">
                        <div class="feature-icon ic-orange">
                            <i class="fas fa-folder-plus"></i>
                        </div>
                        <h5>Manajemen Kategori</h5>
                        <p>Organisir produk dalam kategori yang terstruktur untuk memudahkan pencarian dan pengelompokan inventaris.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 anim-up delay-1">
                    <div class="feature-card">
                        <div class="feature-icon ic-pink">
                            <i class="fas fa-search"></i>
                        </div>
                        <h5>Pencarian Cepat</h5>
                        <p>Temukan produk atau kategori apapun dengan fitur pencarian canggih yang menampilkan hasil secara instan.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 anim-up delay-2">
                    <div class="feature-card">
                        <div class="feature-icon" style="background: linear-gradient(135deg,#4facfe,#00f2fe);">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <h5>Keamanan Terproteksi</h5>
                        <p>Autentikasi pengguna dan sistem otorisasi berlapis untuk memastikan data bisnis Anda tetap aman.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 anim-up delay-3">
                    <div class="feature-card">
                        <div class="feature-icon" style="background: linear-gradient(135deg,#43e97b,#38f9d7);">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <h5>Responsif di Semua Layar</h5>
                        <p>Tampilan yang menyesuaikan sempurna di desktop, tablet, maupun smartphone untuk kenyamanan maksimal.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ============================================================
         SECTION 4 — PRODUK UNGGULAN (statis / bisa diganti dynamic)
         ============================================================ --}}
    <section class="products-section">
        <div class="container">
            <div class="text-center mb-5 anim-up">
                <span class="section-pill">PRODUK PILIHAN</span>
                <h2 class="section-heading">Produk Terlaris Kami</h2>
                <p class="section-sub">Temukan berbagai produk pilihan yang telah dipercaya ribuan pelanggan</p>
            </div>

            <div class="row g-4">
                {{-- CARD 1 --}}
                <div class="col-sm-6 col-lg-3 anim-up delay-1">
                    <div class="product-card">
                        <div class="product-thumb" style="background:linear-gradient(135deg,#e0e7ff,#ddd6fe);">💻</div>
                        <div class="product-body">
                            <div class="product-cat">Elektronik</div>
                            <div class="product-name">Laptop Gaming Pro X</div>
                            <div class="product-price">Rp 15.999.000</div>
                            <div class="product-footer">
                                <span class="badge-in">✓ Tersedia</span>
                                <a href="{{ route('login') }}" class="btn-add">+ Lihat</a>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- CARD 2 --}}
                <div class="col-sm-6 col-lg-3 anim-up delay-2">
                    <div class="product-card">
                        <div class="product-thumb" style="background:linear-gradient(135deg,#fce7f3,#fbcfe8);">👟</div>
                        <div class="product-body">
                            <div class="product-cat">Fashion</div>
                            <div class="product-name">Sneakers Urban Classic</div>
                            <div class="product-price">Rp 899.000</div>
                            <div class="product-footer">
                                <span class="badge-in">✓ Tersedia</span>
                                <a href="{{ route('login') }}" class="btn-add">+ Lihat</a>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- CARD 3 --}}
                <div class="col-sm-6 col-lg-3 anim-up delay-3">
                    <div class="product-card">
                        <div class="product-thumb" style="background:linear-gradient(135deg,#d1fae5,#a7f3d0);">📱</div>
                        <div class="product-body">
                            <div class="product-cat">Elektronik</div>
                            <div class="product-name">Smartphone Nano 5G</div>
                            <div class="product-price">Rp 7.499.000</div>
                            <div class="product-footer">
                                <span class="badge-out">✗ Habis</span>
                                <span class="btn-add" style="opacity:.45;cursor:not-allowed;">+ Lihat</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- CARD 4 --}}
                <div class="col-sm-6 col-lg-3 anim-up delay-4">
                    <div class="product-card">
                        <div class="product-thumb" style="background:linear-gradient(135deg,#fef3c7,#fde68a);">⌚</div>
                        <div class="product-body">
                            <div class="product-cat">Aksesoris</div>
                            <div class="product-name">Smart Watch Elite</div>
                            <div class="product-price">Rp 2.299.000</div>
                            <div class="product-footer">
                                <span class="badge-in">✓ Tersedia</span>
                                <a href="{{ route('login') }}" class="btn-add">+ Lihat</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tombol lihat semua --}}
            <div class="text-center mt-5 anim-up">
                <a href="{{ route('products.index') }}" class="btn btn-primary px-5">
                    <i class="fas fa-th-large me-2"></i>Lihat Semua Produk
                </a>
            </div>
        </div>
    </section>

    {{-- ============================================================
         SECTION 5 — CTA
         ============================================================ --}}
    <section class="cta-section">
        <div class="position-relative" style="z-index:1;">
            <h2 class="anim-up">Siap Kelola Toko Anda?</h2>
            <p class="anim-up delay-1">
                Daftarkan diri sekarang dan nikmati kemudahan manajemen
                produk tanpa batas bersama ribuan pengguna aktif kami.
            </p>
            <a href="{{ route('login') }}" class="btn-cta-white anim-up delay-2">
                Mulai Sekarang &rarr;
            </a>
        </div>
    </section>

</div>{{-- /landing-wrap --}}

@endsection

@section('scripts')
{{-- Scroll-triggered animation --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const targets = document.querySelectorAll('.anim-up');

    // Set awal: semua tersembunyi kecuali yg langsung di viewport
    targets.forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(28px)';
        el.style.transition = 'opacity .65s ease, transform .65s ease';
    });

    const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const el = entry.target;
                const delay = parseFloat(getComputedStyle(el).animationDelay) || 0;
                setTimeout(() => {
                    el.style.opacity = '1';
                    el.style.transform = 'translateY(0)';
                }, delay * 1000);
                observer.unobserve(el);
            }
        });
    }, { threshold: 0.12 });

    targets.forEach(el => observer.observe(el));
});
</script>
@endsection