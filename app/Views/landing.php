<!DOCTYPE HTML>
<html lang="id">

<head>
    <title>Wisata Bus - Jelajahi Destinasi Impian Anda</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <link rel="stylesheet" href="<?= base_url('assets/icons/font-awesome/css/font-awesome.min.css') ?>" />
    <link rel="stylesheet" href="<?= base_url('assets/css/landing-modern.css') ?>" />
</head>

<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="nav-container">
            <div class="nav-logo">
                <i class="fas fa-bus"></i>
                <span>Wisata Bus</span>
            </div>
            <ul class="nav-menu">
                <li><a href="#home" class="nav-link active">Beranda</a></li>
                <li><a href="#paket" class="nav-link">Paket</a></li>
                <li><a href="#tentang" class="nav-link">Tentang</a></li>
                <li><a href="#testimoni" class="nav-link">Testimoni</a></li>
                <li><a href="#kontak" class="nav-link">Kontak</a></li>
                <li><a href="<?= base_url('/pemesanan') ?>" class="nav-link btn-cta">Pesan Sekarang</a></li>
            </ul>
            <div class="hamburger">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero" id="home">
        <div class="hero-content">
            <div class="hero-text">
                <h1 class="hero-title">Jelajahi Destinasi Impian Anda</h1>
                <p class="hero-subtitle">Nikmati pengalaman perjalanan yang tak terlupakan dengan kenyamanan dan keamanan terjamin</p>
                <div class="hero-buttons">
                    <a href="<?= base_url('/pemesanan') ?>" class="btn btn-primary">
                        <i class="fas fa-arrow-right"></i> Mulai Petualangan
                    </a>
                    <a href="#paket" class="btn btn-secondary">
                        <i class="fas fa-play"></i> Lihat Paket
                    </a>
                </div>
            </div>
            <div class="hero-image">
                <div class="floating-card card-1">
                    <i class="fas fa-map-location-dot"></i>
                    <span>50+ Destinasi</span>
                </div>
                <div class="floating-card card-2">
                    <i class="fas fa-users"></i>
                    <span>10K+ Pelanggan</span>
                </div>
                <div class="floating-card card-3">
                    <i class="fas fa-star"></i>
                    <span>4.9 Rating</span>
                </div>
            </div>
        </div>
        <div class="hero-background">
            <div class="gradient-blob blob-1"></div>
            <div class="gradient-blob blob-2"></div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features">
        <div class="container">
            <div class="section-header">
                <h2>Mengapa Memilih Kami?</h2>
                <p>Layanan terbaik untuk perjalanan impian Anda</p>
            </div>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-bus"></i>
                    </div>
                    <h3>Armada Modern</h3>
                    <p>Bus terbaru dengan fasilitas lengkap dan AC yang nyaman untuk perjalanan Anda</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-user-tie"></i>
                    </div>
                    <h3>Sopir Profesional</h3>
                    <p>Tim sopir berpengalaman dan terlatih untuk keselamatan perjalanan Anda</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h3>Asuransi Lengkap</h3>
                    <p>Perlindungan penuh untuk setiap perjalanan dengan asuransi komprehensif</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-headset"></i>
                    </div>
                    <h3>Layanan 24/7</h3>
                    <p>Tim customer service siap membantu Anda kapan saja, siang atau malam</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-tag"></i>
                    </div>
                    <h3>Harga Kompetitif</h3>
                    <p>Paket wisata dengan harga terjangkau tanpa mengorbankan kualitas</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-map"></i>
                    </div>
                    <h3>Destinasi Pilihan</h3>
                    <p>Ratusan destinasi menarik di seluruh Indonesia siap untuk dijelajahi</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Packages Section -->
    <section class="packages" id="paket">
        <div class="container">
            <div class="section-header">
                <h2>Paket Wisata Unggulan</h2>
                <p>Pilih paket wisata yang sesuai dengan impian Anda</p>
            </div>
            <div class="packages-grid">
                <?php if (!empty($paketWisata)) : ?>
                    <?php $count = 0;
                    foreach ($paketWisata as $paket) : ?>
                        <?php if ($count < 6) : ?>
                            <div class="package-card">
                                <div class="package-image">
                                    <img src="<?= base_url('html5up-zerofour/images/pic0' . (($count % 8) + 1) . '.jpg') ?>" alt="<?= esc($paket['nama_paket']) ?>" />
                                    <div class="package-overlay">
                                        <a href="<?= base_url('/pemesanan') ?>" class="btn btn-small">Pesan Sekarang</a>
                                    </div>
                                </div>
                                <div class="package-content">
                                    <h3><?= esc($paket['nama_paket']) ?></h3>
                                    <p class="package-destination">
                                        <i class="fas fa-map-marker-alt"></i> <?= esc($paket['tujuan']) ?>
                                    </p>
                                    <div class="package-rating">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star-half-alt"></i>
                                        <span>(4.8)</span>
                                    </div>
                                </div>
                            </div>
                            <?php $count++; ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php else : ?>
                    <div style="grid-column: 1/-1; text-align: center; padding: 40px;">
                        <p>Paket wisata sedang dipersiapkan. Silakan kembali lagi nanti.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="about" id="tentang">
        <div class="container">
            <div class="about-content">
                <div class="about-text">
                    <h2>Tentang Wisata Bus</h2>
                    <p>Kami adalah perusahaan pariwisata terpercaya dengan pengalaman lebih dari 10 tahun melayani jutaan wisatawan di seluruh Indonesia.</p>
                    <div class="about-stats">
                        <div class="stat">
                            <h4>10+</h4>
                            <p>Tahun Pengalaman</p>
                        </div>
                        <div class="stat">
                            <h4>50+</h4>
                            <p>Destinasi</p>
                        </div>
                        <div class="stat">
                            <h4>10K+</h4>
                            <p>Pelanggan Puas</p>
                        </div>
                        <div class="stat">
                            <h4>100+</h4>
                            <p>Bus Modern</p>
                        </div>
                    </div>
                </div>
                <div class="about-image">
                    <div class="image-wrapper">
                        <img src="<?= base_url('html5up-zerofour/images/pic08.jpg') ?>" alt="Tentang Kami" />
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="testimonials" id="testimoni">
        <div class="container">
            <div class="section-header">
                <h2>Apa Kata Pelanggan Kami?</h2>
                <p>Ribuan pelanggan puas telah merasakan pengalaman luar biasa bersama kami</p>
            </div>
            <div class="testimonials-grid">
                <div class="testimonial-card">
                    <div class="testimonial-header">
                        <div class="testimonial-avatar">
                            <i class="fas fa-user-circle"></i>
                        </div>
                        <div class="testimonial-info">
                            <h4>Budi Santoso</h4>
                            <p>Jakarta</p>
                        </div>
                    </div>
                    <div class="testimonial-rating">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <p class="testimonial-text">Perjalanan ke Bali bersama keluarga sangat menyenangkan. Bus yang nyaman, sopir yang ramah, dan itinerary yang teratur membuat liburan kami tak terlupakan!</p>
                </div>
                <div class="testimonial-card">
                    <div class="testimonial-header">
                        <div class="testimonial-avatar">
                            <i class="fas fa-user-circle"></i>
                        </div>
                        <div class="testimonial-info">
                            <h4>Siti Nurhaliza</h4>
                            <p>Surabaya</p>
                        </div>
                    </div>
                    <div class="testimonial-rating">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <p class="testimonial-text">Harga yang ditawarkan sangat kompetitif. Fasilitas bus lengkap dengan AC, WiFi, dan kursi yang empuk. Saya puas dan akan merekomendasikan ke teman-teman!</p>
                </div>
                <div class="testimonial-card">
                    <div class="testimonial-header">
                        <div class="testimonial-avatar">
                            <i class="fas fa-user-circle"></i>
                        </div>
                        <div class="testimonial-info">
                            <h4>Ahmad Wijaya</h4>
                            <p>Bandung</p>
                        </div>
                    </div>
                    <div class="testimonial-rating">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <p class="testimonial-text">Perjalanan bisnis ke beberapa kota berjalan lancar. Profesionalisme tim mereka luar biasa. Jadwal tepat waktu dan sopir berpengalaman membuat perjalanan produktif!</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <div class="cta-content">
                <h2>Siap untuk Petualangan Berikutnya?</h2>
                <p>Jangan lewatkan kesempatan untuk menjelajahi destinasi impian Anda bersama kami</p>
                <a href="<?= base_url('/pemesanan') ?>" class="btn btn-primary btn-large">
                    <i class="fas fa-calendar-check"></i> Pesan Paket Wisata Sekarang
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer" id="kontak">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>Wisata Bus</h3>
                    <p>Perusahaan pariwisata terpercaya dengan komitmen memberikan pengalaman perjalanan terbaik untuk Anda.</p>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-facebook"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-whatsapp"></i></a>
                    </div>
                </div>
                <div class="footer-section">
                    <h4>Destinasi Populer</h4>
                    <ul>
                        <li><a href="#">Bali</a></li>
                        <li><a href="#">Yogyakarta</a></li>
                        <li><a href="#">Lombok</a></li>
                        <li><a href="#">Bandung</a></li>
                        <li><a href="#">Malang</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h4>Layanan</h4>
                    <ul>
                        <li><a href="#">Paket Wisata</a></li>
                        <li><a href="#">Sewa Bus</a></li>
                        <li><a href="#">Tour Guide</a></li>
                        <li><a href="#">Akomodasi</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h4>Hubungi Kami</h4>
                    <ul>
                        <li><i class="fas fa-phone"></i> (021) 1234-5678</li>
                        <li><i class="fas fa-whatsapp"></i> +62 812-3456-7890</li>
                        <li><i class="fas fa-envelope"></i> info@wisatabus.com</li>
                        <li><i class="fas fa-map-marker-alt"></i> Jl. Merdeka No. 123, Jakarta</li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2024 Wisata Bus. Semua hak dilindungi.</p>
            </div>
        </div>
    </footer>

    <script src="<?= base_url('assets/js/landing-modern.js') ?>"></script>
</body>

</html>