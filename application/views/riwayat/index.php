<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Riwayat Perhitungan HPP - HitungDapur</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Mono:wght@400;500;600;700&family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />

    <!-- Main Stylesheet -->
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css'); ?>" />
</head>
<body>

<div class="app-wrapper">

    <!-- MASTHEAD -->
    <header class="masthead">
        <a href="<?= site_url(); ?>" class="brand-wrapper">
            <div class="calculator-mark">
                <svg viewBox="0 0 20 20" width="20" height="20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect x="3" y="2" width="14" height="16" rx="2" stroke="#FFFFFF" stroke-width="1.8"/>
                    <rect x="5.5" y="4.5" width="9" height="2.8" rx="0.8" fill="#FFFFFF"/>
                    <circle cx="6.5" cy="10" r="1" fill="#FFFFFF"/>
                    <circle cx="10" cy="10" r="1" fill="#FFFFFF"/>
                    <circle cx="13.5" cy="10" r="1" fill="#FFFFFF"/>
                    <circle cx="6.5" cy="13" r="1" fill="#FFFFFF"/>
                    <circle cx="10" cy="13" r="1" fill="#FFFFFF"/>
                    <circle cx="13.5" cy="13" r="1" fill="#FFFFFF"/>
                </svg>
            </div>
            <div class="brand-name">HitungDapur</div>
        </a>

        <div class="masthead-badge">
            RIWAYAT PERHITUNGAN HPP
        </div>

        <div class="masthead-actions">
            <a href="<?= site_url(); ?>" class="btn-header primary">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="19" y1="12" x2="5" y2="12"></line>
                    <polyline points="12 19 5 12 12 5"></polyline>
                </svg>
                <span>Kalkulator</span>
            </a>
        </div>
    </header>

    <!-- BANNER -->
    <section class="recipe-costing-banner" style="padding: 24px 40px;">
        <div class="banner-intro">
            <div class="banner-tag">ARSIP & DOKUMENTASI &nbsp;/&nbsp; UI-04</div>
            <h1 class="banner-title" style="font-size: 38px;">Riwayat Perhitungan</h1>
            <p class="banner-subtitle">Daftar semua perhitungan HPP produk yang telah disimpan ke basis data MySQL.</p>
        </div>
    </section>

    <!-- CONTENT -->
    <main style="padding: 32px 40px; display: flex; flex-direction: column; gap: 20px;">

        <?php if ($this->session->flashdata('pesan_sukses')): ?>
            <div style="background-color: #D1FAE5; color: #065F46; padding: 12px 16px; border-radius: 8px; font-size: 13px; font-weight: 500; border: 1px solid #A7F3D0;">
                <?= $this->session->flashdata('pesan_sukses'); ?>
            </div>
        <?php endif; ?>

        <?php if ($this->session->flashdata('pesan_error')): ?>
            <div style="background-color: var(--danger-bg); color: var(--danger); padding: 12px 16px; border-radius: 8px; font-size: 13px; font-weight: 500; border: 1px solid #FECACA;">
                <?= $this->session->flashdata('pesan_error'); ?>
            </div>
        <?php endif; ?>

        <div class="card-sheet">
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
                <h2 class="card-heading">Daftar Catatan Perhitungan</h2>
                <a href="<?= site_url(); ?>" class="btn-header primary" style="font-size: 12px; padding: 6px 12px;">
                    + Buat Perhitungan Baru
                </a>
            </div>

            <?php if (empty($riwayat)): ?>
                <div style="text-align: center; padding: 48px 20px; color: var(--muted-text);">
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="margin-bottom: 12px; opacity: 0.6;">
                        <circle cx="12" cy="12" r="10"></circle>
                        <polyline points="12 6 12 12 16 14"></polyline>
                    </svg>
                    <p style="font-size: 16px; font-weight: 600; margin: 0 0 6px 0; color: var(--dark-text);">Belum Ada Riwayat Perhitungan</p>
                    <p style="font-size: 13px; margin: 0 0 16px 0;">Hitung modal dan harga jual produk Anda sekarang, lalu klik tombol Simpan.</p>
                    <a href="<?= site_url(); ?>" class="btn-header primary" style="display: inline-flex;">Buka Kalkulator</a>
                </div>
            <?php else: ?>
                <div class="table-container">
                    <table class="custom-table">
                        <thead>
                            <tr>
                                <th style="width: 40px;">No</th>
                                <th>Tanggal & Waktu</th>
                                <th>Nama Produk</th>
                                <th style="width: 80px; text-align: center;">Hasil</th>
                                <th style="width: 120px;">Total Modal</th>
                                <th style="width: 120px;">HPP / Pcs</th>
                                <th style="width: 120px;">Saran Harga</th>
                                <th style="width: 120px;">Laba / Resep</th>
                                <th style="width: 180px; text-align: center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; foreach ($riwayat as $r): ?>
                                <tr>
                                    <td class="text-center" style="font-weight: 600; color: var(--muted-text);"><?= $no++; ?></td>
                                    <td>
                                        <div style="font-weight: 500; color: var(--dark-text); font-size: 13px;">
                                            <?= date('d M Y, H:i', strtotime($r['created_at'])); ?>
                                        </div>
                                    </td>
                                    <td>
                                        <div style="font-weight: 600; color: var(--primary); font-size: 14px;">
                                            <?= html_escape($r['nama_produk']); ?>
                                        </div>
                                    </td>
                                    <td style="text-align: center;">
                                        <span class="mono-text" style="font-size: 12px; background: var(--primary-light); padding: 3px 8px; border-radius: 4px; color: var(--primary); font-weight: 600;">
                                            <?= $r['jumlah_produk']; ?> pcs
                                        </span>
                                    </td>
                                    <td>
                                        <span style="font-weight: 500;">Rp <?= number_format($r['total_biaya_produksi'], 0, ',', '.'); ?></span>
                                    </td>
                                    <td>
                                        <strong style="color: var(--primary);">Rp <?= number_format($r['hpp_per_produk'], 0, ',', '.'); ?></strong>
                                    </td>
                                    <td>
                                        <strong style="color: var(--success);">Rp <?= number_format($r['harga_jual_saran'], 0, ',', '.'); ?></strong>
                                        <div style="font-size: 11px; color: var(--muted-text);"><?= number_format($r['persen_untung'], 0); ?>% untung</div>
                                    </td>
                                    <td>
                                        <span style="font-weight: 600; color: var(--success);">Rp <?= number_format($r['laba_per_resep'], 0, ',', '.'); ?></span>
                                    </td>
                                    <td style="text-align: center;">
                                        <div style="display: inline-flex; gap: 6px;">
                                            <a href="<?= site_url('kalkulator/index/' . $r['id_perhitungan']); ?>" class="btn-header" style="padding: 4px 8px; font-size: 11px;" title="Buka & Edit di Kalkulator">
                                                Buka
                                            </a>
                                            <a href="<?= site_url('riwayat/detail/' . $r['id_perhitungan']); ?>" class="btn-header" style="padding: 4px 8px; font-size: 11px;" title="Lihat Rincian">
                                                Detail
                                            </a>
                                            <a href="<?= site_url('riwayat/cetak/' . $r['id_perhitungan']); ?>" target="_blank" class="btn-header primary" style="padding: 4px 8px; font-size: 11px;" title="Cetak / PDF">
                                                Cetak
                                            </a>
                                            <a href="<?= site_url('riwayat/hapus/' . $r['id_perhitungan']); ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus data perhitungan ini?')" class="btn-header" style="padding: 4px 8px; font-size: 11px; color: var(--danger); border-color: #FECACA;" title="Hapus">
                                                Hapus
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>

    </main>

</div>

</body>
</html>
