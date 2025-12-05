<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Register | G-Tour Reservasi Wisata</title>
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
            max-width: 440px;
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
        <h2>Registrasi Akun</h2>
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-custom alert-dismissible fade show" role="alert">
                <?= session()->getFlashdata('error') ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true" style="color:#fff;">&times;</span>
                </button>
            </div>
        <?php endif; ?>
        <form method="post" action="<?= site_url('register/store') ?>">
            <?= csrf_field() ?>
            <div class="form-group mb-3">
                <label>Nama Lengkap</label>
                <input class="form-control" type="text" name="nama" required>
            </div>
            <div class="form-group mb-3">
                <label>Email</label>
                <input class="form-control" type="email" name="email" required>
            </div>
            <div class="form-group mb-3">
                <label>No. HP</label>
                <input class="form-control" type="text" name="nohp" required>
            </div>
            <div class="form-group mb-3">
                <label>Alamat</label>
                <input class="form-control" type="text" name="alamat" required>
            </div>
            <div class="form-group mb-3">
                <label>Password</label>
                <input class="form-control" type="password" name="password" required>
            </div>
            <div class="form-group mb-4">
                <label>Daftar Sebagai</label>
                <select class="form-control" name="role" id="role" required onchange="toggleJabatan()">
                    <option value="">-- Pilih --</option>
                    <option value="karyawan">Karyawan</option>
                    <option value="penyewa">Penyewa</option>
                </select>
            </div>
            <div class="form-group mb-4" id="jabatan-group" style="display:none;">
                <label>Pilih Jabatan</label>
                <select class="form-control" name="id_jabatan">
                    <option value="">-- Pilih Jabatan --</option>
                    <?php if (!empty($jabatan)): ?>
                        <?php foreach ($jabatan as $j): ?>
                            <option value="<?= $j['id'] ?>"><?= $j['nama_jabatan'] ?></option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>
            <button class="btn btn-gradient mt-2" type="submit">Register</button>
        </form>
    </div>
    <script src="<?= base_url('assets/js/bootstrap.min.js') ?>"></script>
    <script>
        function toggleJabatan() {
            var role = document.getElementById('role').value;
            document.getElementById('jabatan-group').style.display = (role === 'karyawan') ? 'block' : 'none';
        }
    </script>
</body>

</html>