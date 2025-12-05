<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link href="<?= base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet">
    <style>
        body {
            background: #f3f6ff;
        }

        .dashboard-card {
            max-width: 400px;
            margin: 80px auto;
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.12);
            padding: 40px 30px;
            text-align: center;
        }

        .dashboard-card h2 {
            margin-bottom: 18px;
        }

        .dashboard-card .role {
            font-size: 1.1em;
            color: #667eea;
            margin-bottom: 12px;
        }
    </style>
</head>

<body>
    <div class="dashboard-card">
        <h2>Selamat Datang!</h2>
        <?php if (!empty($user)): ?>
            <div class="role">
                Anda login sebagai <b><?= esc($user['role'] ?? '-') ?></b>
            </div>
            <div>
                <b>Nama:</b> <?= esc($user['name'] ?? '-') ?><br>
                <b>Email:</b> <?= esc($user['email'] ?? '-') ?><br>
                <b>No HP:</b> <?= esc($user['phone'] ?? '-') ?>
            </div>
        <?php else: ?>
            <div>Data user tidak ditemukan.</div>
        <?php endif; ?>
        <a href="<?= site_url('logout') ?>" class="btn btn-danger mt-4">Logout</a>
    </div>
    <script src="<?= base_url('assets/js/bootstrap.min.js') ?>"></script>
</body>

</html>