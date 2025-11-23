<?= $this->extend('main') ?>
<?= $this->section('isi') ?>

<style>
.landing-wrap {
    max-width: 750px;
    margin: 70px auto;
    padding: 50px 40px;
    background: white;
    border-radius: 14px;
    box-shadow: 0 8px 36px rgba(0, 0, 0, 0.09);
    text-align: center;
}

.landing-title {
    font-size: 42px;
    font-weight: 700;
    margin-bottom: 10px;
    color: #222;
}

.landing-sub {
    font-size: 17px;
    color: #555;
    margin-bottom: 35px;
}

.highlight-box {
    background: #f3f6ff;
    padding: 25px;
    border-radius: 12px;
    margin: 35px 0;
    color: #3b4c8c;
    font-size: 16px;
    line-height: 1.6;
    box-shadow: inset 0 0 0 1px #dbe3ff;
}

.mini-features {
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
    gap: 18px;
    margin-top: 30px;
}

.mini-item {
    background: #fafafa;
    border-radius: 10px;
    padding: 12px 18px;
    font-size: 15px;
    color: #444;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.06);
}
</style>

<div class="landing-wrap">

    <h1 class="landing-title">🌿 G-Tour</h1>
    <p class="landing-sub">Ruang santai untuk kamu yang ingin menjelajahi dunia tanpa terburu-buru.</p>

    <div class="highlight-box">
        Temukan tempat yang membuat langkahmu terasa lebih ringan.
        Dari pantai tenang, kota penuh warna, hingga hutan yang berbisik lembut,
        G-Tour siap menemani perjalanan imajinasimu.
    </div>

    <div class="mini-features">
        <div class="mini-item">Destinasi curated</div>
        <div class="mini-item">Visual lembut & bersih</div>
        <div class="mini-item">Atmosfer rileks</div>
        <div class="mini-item">Moodboard perjalanan</div>
    </div>

</div>

<?= $this->endSection() ?>