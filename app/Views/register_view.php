<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Register | G-Tour Reservasi Wisata</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="<?= base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 25%, #f093fb 50%, #4facfe 75%, #00f2fe 100%);
            background-size: 400% 400%;
            animation: gradientShift 15s ease infinite;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow-x: hidden;
            padding: 20px;
        }

        @keyframes gradientShift {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        .register-container {
            display: flex;
            width: 100%;
            max-width: 1300px;
            border-radius: 30px;
            overflow: hidden;
            box-shadow: 0 20px 80px rgba(0, 0, 0, 0.4);
            animation: slideUp 0.8s ease-out;
            background: white;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(50px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .register-left {
            flex: 1;
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: white;
            padding: 60px 40px;
            position: relative;
            overflow: hidden;
            min-height: 800px;
        }

        .register-left::before {
            content: '';
            position: absolute;
            width: 400px;
            height: 400px;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 50%;
            top: -150px;
            right: -150px;
            animation: float 8s ease-in-out infinite;
        }

        .register-left::after {
            content: '';
            position: absolute;
            width: 250px;
            height: 250px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            bottom: -80px;
            left: -80px;
            animation: float 10s ease-in-out infinite reverse;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(40px);
            }
        }

        .register-left-content {
            position: relative;
            z-index: 2;
            text-align: center;
        }

        .register-left-content h1 {
            font-size: 3.8rem;
            font-weight: 800;
            margin-bottom: 20px;
            text-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            animation: fadeInDown 0.8s ease-out;
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .register-left-content p {
            font-size: 1.15rem;
            margin-bottom: 40px;
            opacity: 0.95;
            line-height: 1.6;
            animation: fadeInUp 0.8s ease-out 0.2s both;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .benefits {
            display: flex;
            flex-direction: column;
            gap: 18px;
            margin-top: 40px;
        }

        .benefit-item {
            display: flex;
            align-items: center;
            gap: 15px;
            font-size: 0.98rem;
            opacity: 0.9;
            animation: fadeInUp 0.8s ease-out both;
            transition: all 0.3s ease;
        }

        .benefit-item:nth-child(1) {
            animation-delay: 0.3s;
        }

        .benefit-item:nth-child(2) {
            animation-delay: 0.4s;
        }

        .benefit-item:nth-child(3) {
            animation-delay: 0.5s;
        }

        .benefit-item:nth-child(4) {
            animation-delay: 0.6s;
        }

        .benefit-item:hover {
            transform: translateX(10px);
            opacity: 1;
        }

        .benefit-item i {
            font-size: 1.5rem;
            background: rgba(255, 255, 255, 0.25);
            width: 45px;
            height: 45px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            transition: all 0.3s ease;
        }

        .benefit-item:hover i {
            background: rgba(255, 255, 255, 0.4);
            transform: scale(1.1);
        }

        .register-right {
            flex: 1;
            background: rgba(255, 255, 255, 0.98);
            padding: 60px 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
            overflow-y: auto;
            max-height: 800px;
        }

        .register-right::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, #f093fb, #f5576c);
        }

        .register-form h2 {
            font-size: 2.2rem;
            color: #333;
            margin-bottom: 8px;
            font-weight: 800;
            animation: fadeInDown 0.8s ease-out;
        }

        .register-form .subtitle {
            color: #999;
            margin-bottom: 35px;
            font-size: 0.98rem;
            animation: fadeInUp 0.8s ease-out 0.1s both;
        }

        .form-group {
            margin-bottom: 20px;
            animation: fadeInUp 0.8s ease-out both;
        }

        .form-group:nth-child(n+3) {
            animation-delay: 0.2s;
        }

        .form-group:nth-child(n+4) {
            animation-delay: 0.3s;
        }

        .form-group:nth-child(n+5) {
            animation-delay: 0.4s;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #555;
            font-weight: 700;
            font-size: 0.88rem;
            text-transform: uppercase;
            letter-spacing: 0.6px;
        }

        .form-group label i {
            margin-right: 6px;
            color: #f093fb;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 13px 16px;
            border: 2px solid #e8e8e8;
            border-radius: 12px;
            font-size: 0.96rem;
            transition: all 0.3s ease;
            background: #f9fafb;
            font-family: inherit;
        }

        .form-group input:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #f093fb;
            background: white;
            box-shadow: 0 0 0 5px rgba(240, 147, 251, 0.12);
            transform: translateY(-2px);
        }

        .form-group input::placeholder,
        .form-group textarea::placeholder {
            color: #ccc;
        }

        .form-group small {
            display: block;
            margin-top: 7px;
            color: #aaa;
            font-size: 0.82rem;
        }

        .photo-upload {
            position: relative;
            margin-bottom: 20px;
            animation: fadeInUp 0.8s ease-out 0.5s both;
        }

        .photo-upload input[type="file"] {
            display: none;
        }

        .photo-upload-label {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            padding: 25px;
            border: 2px dashed #e0e0e0;
            border-radius: 12px;
            background: linear-gradient(135deg, #f9fafb 0%, #f5f5f5 100%);
            cursor: pointer;
            transition: all 0.3s ease;
            color: #666;
            font-weight: 600;
            font-size: 0.95rem;
        }

        .photo-upload-label:hover {
            border-color: #f093fb;
            background: linear-gradient(135deg, rgba(240, 147, 251, 0.08) 0%, rgba(245, 87, 108, 0.05) 100%);
            color: #f093fb;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(240, 147, 251, 0.15);
        }

        .photo-upload-label i {
            font-size: 1.4rem;
        }

        .photo-preview {
            margin-top: 15px;
            text-align: center;
            animation: fadeIn 0.4s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        .photo-preview img {
            max-width: 120px;
            max-height: 120px;
            border-radius: 12px;
            border: 3px solid #f093fb;
            box-shadow: 0 4px 12px rgba(240, 147, 251, 0.3);
        }

        .btn-register {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 1.02rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            margin-top: 20px;
            box-shadow: 0 6px 20px rgba(240, 147, 251, 0.4);
            animation: fadeInUp 0.8s ease-out 0.6s both;
        }

        .btn-register:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(240, 147, 251, 0.6);
        }

        .btn-register:active {
            transform: translateY(-1px);
        }

        .register-footer {
            text-align: center;
            margin-top: 25px;
            color: #999;
            font-size: 0.92rem;
            animation: fadeInUp 0.8s ease-out 0.7s both;
        }

        .register-footer a {
            color: #f093fb;
            text-decoration: none;
            font-weight: 700;
            transition: all 0.3s ease;
            position: relative;
        }

        .register-footer a::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 2px;
            background: #f093fb;
            transition: width 0.3s ease;
        }

        .register-footer a:hover::after {
            width: 100%;
        }

        .alert-custom {
            border-radius: 12px;
            border: 2px solid #ff6b6b;
            background: rgba(255, 107, 107, 0.1);
            color: #d63031;
            padding: 14px 16px;
            margin-bottom: 25px;
            font-size: 0.92rem;
            animation: slideDown 0.4s ease-out;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-15px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .alert-custom i {
            font-size: 1.2rem;
            flex-shrink: 0;
        }

        .alert-custom .close {
            color: #d63031;
            opacity: 0.7;
            margin-left: auto;
        }

        .alert-custom .close:hover {
            opacity: 1;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 18px;
        }

        @media (max-width: 768px) {
            .register-container {
                flex-direction: column;
                border-radius: 20px;
            }

            .register-left {
                padding: 40px 30px;
                min-height: 350px;
            }

            .register-left-content h1 {
                font-size: 2.8rem;
            }

            .register-right {
                padding: 40px 30px;
                max-height: none;
            }

            .register-form h2 {
                font-size: 1.8rem;
            }

            .form-row {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <div class="register-container">
        <!-- Left Section -->
        <div class="register-left">
            <div class="register-left-content">
                <h1>🎉 Bergabunglah</h1>
                <p>Mulai Petualangan Wisata Impian Anda Hari Ini</p>
                <div class="benefits">
                    <div class="benefit-item">
                        <i class="fas fa-star"></i>
                        <span>Akses Eksklusif ke Paket Wisata Premium</span>
                    </div>
                    <div class="benefit-item">
                        <i class="fas fa-ticket"></i>
                        <span>Booking Mudah, Cepat & Aman</span>
                    </div>
                    <div class="benefit-item">
                        <i class="fas fa-wallet"></i>
                        <span>Harga Terbaik & Promo Menarik Setiap Hari</span>
                    </div>
                    <div class="benefit-item">
                        <i class="fas fa-headset"></i>
                        <span>Dukungan Pelanggan 24/7</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Section -->
        <div class="register-right">
            <div class="register-form">
                <h2>Daftar Akun</h2>
                <p class="subtitle">Buat akun baru untuk memulai perjalanan Anda</p>

                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-custom alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle"></i>
                        <span><?= session()->getFlashdata('error') ?></span>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php endif; ?>

                <form method="post" action="<?= site_url('register/store') ?>" enctype="multipart/form-data">
                    <?= csrf_field() ?>

                    <div class="form-group">
                        <label><i class="fas fa-user-circle"></i> Nama Lengkap</label>
                        <input type="text" name="nama" placeholder="Masukkan nama lengkap Anda" value="<?= set_value('nama') ?>" required>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label><i class="fas fa-envelope"></i> Email</label>
                            <input type="email" name="email" placeholder="nama@example.com" value="<?= set_value('email') ?>" required>
                        </div>
                        <div class="form-group">
                            <label><i class="fas fa-phone-alt"></i> No. HP</label>
                            <input type="text" name="nohp" placeholder="08123456789" value="<?= set_value('nohp') ?>" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label><i class="fas fa-map-marker-alt"></i> Alamat Lengkap</label>
                        <textarea name="alamat" placeholder="Masukkan alamat lengkap Anda (Jalan, Kota, Provinsi)" rows="2" required><?= set_value('alamat') ?></textarea>
                    </div>

                    <div class="form-group">
                        <label><i class="fas fa-lock"></i> Password</label>
                        <input type="password" name="password" placeholder="••••••••" required>
                        <small>💡 Minimal 8 karakter, gunakan kombinasi huruf dan angka untuk keamanan maksimal</small>
                    </div>

                    <div class="photo-upload">
                        <label for="foto" class="photo-upload-label">
                            <i class="fas fa-cloud-upload-alt"></i>
                            <span>Pilih Foto Profil (Opsional)</span>
                        </label>
                        <input type="file" id="foto" name="foto" accept="image/*" onchange="previewPhoto(this)">
                        <div class="photo-preview" id="photoPreview"></div>
                        <small style="display: block; margin-top: 10px; color: #aaa;">📸 Format: JPG, PNG, GIF (Max 2MB) - Foto akan ditampilkan di profil Anda</small>
                    </div>

                    <!-- Role hidden, hanya penyewa yang bisa register -->
                    <input type="hidden" name="role" value="penyewa">

                    <button type="submit" class="btn-register">
                        <i class="fas fa-user-plus"></i> Daftar Sekarang
                    </button>
                </form>

                <div class="register-footer">
                    Sudah punya akun? <a href="<?= site_url('/login') ?>">Login di sini</a>
                </div>
            </div>
        </div>
    </div>

    <script src="<?= base_url('assets/js/bootstrap.min.js') ?>"></script>
    <script>
        function previewPhoto(input) {
            const preview = document.getElementById('photoPreview');
            preview.innerHTML = '';

            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    preview.appendChild(img);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        // Add smooth scroll behavior
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth'
                    });
                }
            });
        });
    </script>
</body>

</html>