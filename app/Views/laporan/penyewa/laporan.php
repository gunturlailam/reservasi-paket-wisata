<?= $this->extend('main') ?>

<?= $this->section('isi') ?>
<style>
    .laporan-container {
        background: white;
        border-radius: 12px;
        padding: 30px;
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
    }

    .laporan-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        padding-bottom: 20px;
        border-bottom: 3px solid #667eea;
    }

    .laporan-header h2 {
        font-size: 28px;
        color: #333;
        font-weight: 800;
        margin: 0;
    }

    .laporan-header .badge {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 8px 16px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 600;
    }

    .laporan-actions {
        display: flex;
        gap: 12px;
        margin-bottom: 25px;
    }

    .btn-action {
        padding: 12px 24px;
        border: none;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
    }

    .btn-print {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
    }

    .btn-print:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
    }

    .btn-export {
        background: #f0f4ff;
        color: #667eea;
        border: 2px solid #667eea;
    }

    .btn-export:hover {
        background: #667eea;
        color: white;
    }

    .stats-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
        margin-bottom: 30px;
    }

    .stat-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 20px;
        border-radius: 10px;
        text-align: center;
    }

    .stat-card .number {
        font-size: 32px;
        font-weight: 800;
        margin: 10px 0;
    }

    .stat-card .label {
        font-size: 13px;
        opacity: 0.9;
    }

    .table-responsive {
        border-radius: 8px;
        overflow: hidden;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    thead {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    th {
        padding: 15px;
        text-align: left;
        font-weight: 600;
        font-size: 14px;
    }

    td {
        padding: 12px 15px;
        border-bottom: 1px solid #eee;
    }

    tbody tr:hover {
        background: #f9f9f9;
    }

    tbody tr:last-child td {
        border-bottom: none;
    }

    .no-data {
        text-align: center;
        padding: 40px;
        color: #999;
    }

    @media print {
        .laporan-actions {
            display: none;
        }
    }
</style>

<div class="laporan-container">
    <div class="laporan-header">
        <h2>👥 Laporan Penyewa</h2>
        <span class="badge"><?= $total ?> Data</span>
    </div>

    <div class="laporan-actions">
        <a href="<?= site_url('/laporanpenyewa/cetak') ?>" class="btn-action btn-print" target="_blank">
            <i class="mdi mdi-printer"></i> Cetak/Print
        </a>
        <button class="btn-action btn-export" onclick="exportToCSV()">
            <i class="mdi mdi-download"></i> Export CSV
        </button>
    </div>

    <div class="stats-row">
        <div class="stat-card">
            <div class="label">Total Penyewa</div>
            <div class="number"><?= $total ?></div>
        </div>
    </div>

    <div class="table-responsive">
        <?php if (!empty($penyewa)): ?>
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Penyewa</th>
                        <th>Email</th>
                        <th>No Telp</th>
                        <th>Alamat</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    foreach ($penyewa as $item): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $item['nama_penyewa'] ?></td>
                            <td><?= $item['email'] ?></td>
                            <td><?= $item['no_telp'] ?></td>
                            <td><?= $item['alamat'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="no-data">
                <p>Tidak ada data penyewa</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
    function exportToCSV() {
        const table = document.querySelector('table');
        let csv = [];

        const headers = [];
        table.querySelectorAll('thead th').forEach(th => {
            headers.push(th.textContent);
        });
        csv.push(headers.join(','));

        table.querySelectorAll('tbody tr').forEach(tr => {
            const row = [];
            tr.querySelectorAll('td').forEach(td => {
                row.push('"' + td.textContent.trim() + '"');
            });
            csv.push(row.join(','));
        });

        const csvContent = csv.join('\n');
        const blob = new Blob([csvContent], {
            type: 'text/csv'
        });
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = 'laporan_penyewa.csv';
        a.click();
    }
</script>

<?= $this->endSection() ?>