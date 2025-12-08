<?= $this->extend('main'); ?>
<?= $this->section('isi'); ?>

<style>
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

    .dashboard-container {
        padding: 30px;
        background: #f5f7fa;
        min-height: 100vh;
    }

    .welcome-section {
        background: white;
        border-radius: 15px;
        padding: 25px 30px;
        margin-bottom: 30px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        display: flex;
        align-items: center;
        gap: 20px;
        animation: fadeInUp 0.5s ease;
    }

    .welcome-avatar {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid #f0f0f0;
    }

    .welcome-initial {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        font-weight: bold;
        color: white;
    }

    .welcome-info h3 {
        margin: 0 0 5px 0;
        font-size: 24px;
        font-weight: 600;
        color: #2c3e50;
    }

    .welcome-info p {
        margin: 0;
        color: #7f8c8d;
        font-size: 14px;
    }

    .welcome-badge {
        display: inline-block;
        background: #e8f5e9;
        color: #2e7d32;
        padding: 4px 12px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 600;
        margin-left: 10px;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .stat-card {
        background: white;
        border-radius: 15px;
        padding: 25px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
        animation: fadeInUp 0.5s ease;
        animation-fill-mode: both;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
    }

    .stat-card.purple::before {
        background: linear-gradient(90deg, #667eea, #764ba2);
    }

    .stat-card.green::before {
        background: linear-gradient(90deg, #11998e, #38ef7d);
    }

    .stat-card.pink::before {
        background: linear-gradient(90deg, #f093fb, #f5576c);
    }

    .stat-card.cyan::before {
        background: linear-gradient(90deg, #4facfe, #00f2fe);
    }

    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        color: white;
        margin-bottom: 15px;
    }

    .stat-card.purple .stat-icon {
        background: linear-gradient(135deg, #667eea, #764ba2);
    }

    .stat-card.green .stat-icon {
        background: linear-gradient(135deg, #11998e, #38ef7d);
    }

    .stat-card.pink .stat-icon {
        background: linear-gradient(135deg, #f093fb, #f5576c);
    }

    .stat-card.cyan .stat-icon {
        background: linear-gradient(135deg, #4facfe, #00f2fe);
    }

    .stat-label {
        font-size: 12px;
        color: #95a5a6;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 600;
        margin-bottom: 8px;
    }

    .stat-value {
        font-size: 32px;
        font-weight: 700;
        color: #2c3e50;
        margin: 0;
    }

    .menu-section {
        background: white;
        border-radius: 15px;
        padding: 30px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        animation: fadeInUp 0.7s ease;
    }

    .menu-title {
        font-size: 18px;
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 20px;
    }

    .menu-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
    }

    .menu-btn {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 16px 20px;
        border-radius: 12px;
        text-decoration: none;
        transition: all 0.3s ease;
        font-weight: 600;
        font-size: 14px;
        color: white;
        border: none;
    }

    .menu-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
        color: white;
        text-decoration: none;
    }

    .menu-btn i {
        font-size: 20px;
    }

    .menu-btn.purple {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .menu-btn.green {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
    }

    .menu-btn.pink {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    }

    .menu-btn.cyan {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    }

    .stat-card:nth-child(1) {
        animation-delay: 0.1s;
    }

    .stat-card:nth-child(2) {
        animation-delay: 0.2s;
    }

    .stat-card:nth-child(3) {
        animation-delay: 0.3s;
    }

    .stat-card:nth-child(4) {
        animation-delay: 0.4s;
    }

    .info-cards-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .quote-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 15px;
        padding: 25px;
        color: white;
        box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
        animation: fadeInUp 0.6s ease;
    }

    .quote-text {
        font-size: 16px;
        font-style: italic;
        line-height: 1.6;
        margin-bottom: 10px;
    }

    .quote-author {
        font-size: 13px;
        opacity: 0.9;
        font-weight: 600;
    }

    .funfact-card {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        border-radius: 15px;
        padding: 25px;
        color: white;
        box-shadow: 0 8px 20px rgba(240, 147, 251, 0.3);
        animation: fadeInUp 0.6s ease;
        animation-delay: 0.1s;
        animation-fill-mode: both;
    }

    .funfact-header {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 15px;
        font-size: 18px;
        font-weight: 700;
    }

    .funfact-icon {
        font-size: 32px;
    }

    .funfact-text {
        font-size: 15px;
        line-height: 1.6;
        margin: 0;
    }
</style>

<div class="dashboard-container">
    <!-- Welcome Section -->
    <div class="welcome-section">
        <?php if (!empty($user_foto)): ?>
            <img src="<?= base_url('uploads/' . esc($user_foto)) ?>" alt="Foto Profil" class="welcome-avatar">
        <?php else: ?>
            <div class="welcome-initial">
                <?= strtoupper(substr($user_name, 0, 1)) ?>
            </div>
        <?php endif; ?>

        <div class="welcome-info">
            <h3>
                Selamat Datang, <?= esc($user_name) ?>!
                <span class="welcome-badge"><?= ucfirst(esc($user_role)) ?></span>
            </h3>
            <p>Email: <?= esc($user_email) ?></p>
        </div>
    </div>

    <!-- Quote Motivasi & Fun Fact -->
    <div class="info-cards-grid">
        <div class="quote-card">
            <div class="quote-text">"<?= esc($quote['text']) ?>"</div>
            <div class="quote-author">— <?= esc($quote['author']) ?></div>
        </div>

        <div class="funfact-card">
            <div class="funfact-header">
                <span class="funfact-icon"><?= $funFact['icon'] ?></span>
                <span>Fun Fact!</span>
            </div>
            <p class="funfact-text"><?= esc($funFact['text']) ?></p>
        </div>
    </div>

</div>

<?= $this->endSection(); ?>