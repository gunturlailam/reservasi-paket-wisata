<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Login | G-Tour Reservasi Wisata</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="<?= base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            background: radial-gradient(circle at top, #a0b4ff 0%, #5561c5 35%, #161a32 100%);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .auth-card {
            width: 100%;
            max-width: 420px;
            padding: 40px 35px;
            border-radius: 20px;
            background: rgba(13, 19, 41, 0.8);
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.35);
            backdrop-filter: blur(14px);
            color: #f2f3ff;
            border: 1px solid rgba(255, 255, 255, 0.08);
        }

        .auth-card h2 {
            font-weight: 700;
            letter-spacing: 0.3px;
            margin-bottom: 25px;
        }

        .auth-card label {
            font-size: 0.9rem;
            color: #c9cdfc;
        }

        .auth-card .form-control {
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            background: rgba(15, 22, 52, 0.65);
            color: #fff;
        }

        .auth-card .form-control:focus {
            border-color: #8fb3ff;
            box-shadow: 0 0 0 0.15rem rgba(143, 179, 255, 0.25);
        }

        .btn-gradient {
            width: 100%;
            border-radius: 14px;
            background: linear-gradient(135deg, #ff8fb3 0%, #6c6cff 100%);
            border: none;
            padding: 12px 0;
            font-weight: 600;
            letter-spacing: 0.5px;
            color: #fff;
        }

        .alert-custom {
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.25);
            background: rgba(255, 107, 126, 0.15);
            color: #ffeff4;
        }
    </style>
</head>

<body>
    <div class="auth-card">
        <h2>Login Email</h2>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-custom alert-dismissible fade show" role="alert">
                <?= session()->getFlashdata('error') ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true" style="color:#fff;">&times;</span>
                </button>
            </div>
        <?php endif; ?>

        <form method="post" action="<?= site_url('login/authenticate') ?>">
            <?= csrf_field() ?>

            <div class="form-group mb-4">
                <label>Email</label>
                <input class="form-control" type="email" name="email" value="<?= set_value('email') ?>" placeholder="Masukkan email" required>
            </div>

            <div class="form-group mb-3">
                <label>Password</label>
                <input class="form-control" type="password" name="password" placeholder="Masukkan password" required>
            </div>

            <div class="form-group mb-3">
                <label>Login Sebagai</label>
                <select class="form-control" name="role" required>
                    <option value="">-- Pilih Role --</option>
                    <option value="karyawan">Karyawan</option>
                    <option value="penyewa">Penyewa</option>
                </select>
            </div>

            <button class="btn btn-gradient mt-2" type="submit">Login</button>
            <div class="text-center mt-3">
                <a href="<?= site_url('/register') ?>" style="color: #8fb3ff; text-decoration: none;">Belum punya akun? Daftar di sini</a>
            </div>
        </form>
    </div>
    <script src="<?= base_url('assets/js/bootstrap.min.js') ?>"></script>
</body>

</html>