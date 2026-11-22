<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Detail HPP - <?= html_escape($detail['nama_produk']); ?> - HitungDapur</title>
    
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
            DETAIL PERHITUNGAN HPP
        </div>

        <div class="masthead-actions">
            <a href="<?= site_url('riwayat'); ?>" class="btn-header">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"></polyline></svg>
                <span>Daftar Riwayat</span>
            </a>
            <a href="<?= site_url('kalkulator/index/' . $detail['id_perhitungan']); ?>" class="btn-header primary">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                <span>Edit di Kalkulator</span>
            </a>
        </div>
    </header>

    <!-- BANNER -->
    <section class="recipe-costing-banner">
        <div class="banner-intro">
            <div class="banner-tag">DETAIL BIAYA &nbsp;/&nbsp; <?= date('d M Y, H:i', strtotime($detail['created_at'])); ?></div>
            <h1 class="banner-title" style="font-size: 42px;"><?= html_escape($detail['nama_produk']); ?></h1>
            <p class="banner-subtitle">Hasil produksi: <strong><?= $detail['jumlah_produk']; ?> pcs</strong> &bull; Total Modal: <strong>Rp <?= number_format($detail['total_biaya_produksi'], 0, ',', '.'); ?></strong></p>
        </div>

        <div class="recipe-ticket-box">
            <div class="recipe-ticket" style="transform: rotate(0deg);">
                <div class="ticket-header">
                    <div class="ticket-tag">STRUK PRODUKSI</div>
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--primary)" stroke-width="2"><path d="M4 2v20l2-1 2 1 2-1 2 1 2-1 2 1 2-1 2 1V2l-2 1-2-1-2 1-2-1-2 1-2-1-2 1Z"></path></svg>
                </div>
                <div class="divider"></div>
                <div class="ticket-row">
                    <span class="ticket-label">Resep:</span>
                    <span class="ticket-val"><?= html_escape($detail['nama_produk']); ?></span>
                </div>
                <div class="ticket-row">
                    <span class="ticket-label">Hasil:</span>
                    <span class="ticket-val"><?= $detail['jumlah_produk']; ?> pcs</span>
                </div>
                <div class="ticket-row">
                    <span class="ticket-label">HPP / pcs:</span>
                    <span class="ticket-val" style="color: var(--primary);">Rp <?= number_format($detail['hpp_per_produk'], 0, ',', '.'); ?></span>
                </div>
                <div class="divider"></div>
                <div class="barcode">
                    <div class="b-bar" style="width: 2px;"></div>
                    <div class="b-bar" style="width: 4px;"></div>
                    <div class="b-bar" style="width: 1px;"></div>
                    <div class="b-bar" style="width: 3px;"></div>
                    <div class="b-bar" style="width: 5px;"></div>
                    <div class="b-bar" style="width: 2px;"></div>
                    <div class="b-bar" style="width: 4px;"></div>
                    <div class="b-bar" style="width: 1px;"></div>
                    <div class="b-bar" style="width: 3px;"></div>
                    <div class="b-bar" style="width: 2px;"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- CONTENT -->
    <main class="content-layout">

        <!-- RINCIAN WORKSHEET -->
        <div class="worksheet-column">

            <!-- 1. BAHAN BAKU -->
            <div class="card-sheet">
                <div class="card-title-row">
                    <div class="step-badge">01</div>
                    <h2 class="card-heading">Rincian Bahan Baku</h2>
                </div>
                <div class="table-container">
                    <table class="custom-table">
                        <thead>
                            <tr>
                                <th style="width: 40px;">No</th>
                                <th>Nama Bahan</th>
                                <th>Harga Beli</th>
                                <th>Isi Kemasan</th>
                                <th>Jml Terpakai</th>
                                <th style="text-align: right;">Biaya (Rp)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($detail['bahan'])): ?>
                                <?php $no = 1; foreach ($detail['bahan'] as $b): ?>
                                    <tr>
                                        <td class="text-center"><?= $no++; ?></td>
                                        <td><strong><?= html_escape($b['nama_bahan']); ?></strong></td>
                                        <td>Rp <?= number_format($b['harga_beli'], 0, ',', '.'); ?></td>
                                        <td><?= number_format($b['isi_kemasan'], 0, ',', '.'); ?> <?= html_escape($b['satuan']); ?></td>
                                        <td><?= number_format($b['jumlah_terpakai'], 0, ',', '.'); ?> <?= html_escape($b['satuan']); ?></td>
                                        <td style="text-align: right; font-weight: 600; color: var(--primary);">
                                            Rp <?= number_format($b['biaya'], 0, ',', '.'); ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr><td colspan="6" class="text-center" style="color: var(--muted-text);">Tidak ada bahan baku.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                <div class="table-footer-row">
                    <span class="footer-total-label">Total Biaya Bahan Baku:</span>
                    <span class="footer-total-val" style="color: var(--primary);">Rp <?= number_format($detail['total_biaya_bahan'], 0, ',', '.'); ?></span>
                </div>
            </div>

            <!-- 2. BIAYA OPERASIONAL LENGKAP -->
            <div class="card-sheet">
                <div class="card-title-row">
                    <div class="step-badge">02</div>
                    <h2 class="card-heading">Rincian Biaya Operasional</h2>
                </div>

                <!-- Gas -->
                <div style="background-color: var(--bg-app); border-radius: 8px; padding: 14px; border: 1px solid var(--border-divider); margin-bottom: 12px;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                        <strong style="font-size: 14px; color: var(--dark-text);">Gas Elpiji</strong>
                        <strong style="color: var(--primary);">Rp <?= number_format($detail['biaya_gas'], 0, ',', '.'); ?></strong>
                    </div>
                    <div style="font-size: 12px; color: var(--muted-text);">
                        Pemakaian: <?= $detail['lama_gas_jam']; ?> jam &bull; Tabung <?= $detail['isi_tabung_kg']; ?> kg (Rp <?= number_format($detail['harga_tabung_gas'], 0, ',', '.'); ?>) &bull; Konsumsi: 0.2 kg/jam
                    </div>
                </div>

                <!-- Listrik -->
                <div style="background-color: var(--bg-app); border-radius: 8px; padding: 14px; border: 1px solid var(--border-divider); margin-bottom: 12px;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                        <strong style="font-size: 14px; color: var(--dark-text);">Listrik (Peralatan)</strong>
                        <strong style="color: var(--primary);">Rp <?= number_format($detail['biaya_listrik'], 0, ',', '.'); ?></strong>
                    </div>
                    <div style="font-size: 12px; color: var(--muted-text); margin-bottom: 8px;">
                        Tarif: Rp <?= number_format($detail['tarif_listrik'], 2, ',', '.'); ?> / kWh
                    </div>
                    <?php if (!empty($detail['listrik'])): ?>
                        <div class="table-container" style="background: #FFFFFF;">
                            <table class="custom-table" style="font-size: 12px;">
                                <thead>
                                    <tr>
                                        <th>Perangkat</th>
                                        <th>Daya (W)</th>
                                        <th>Jam</th>
                                        <th>kWh</th>
                                        <th style="text-align: right;">Biaya</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($detail['listrik'] as $l): ?>
                                        <tr>
                                            <td><?= html_escape($l['nama_perangkat']); ?></td>
                                            <td><?= $l['daya_watt']; ?> W</td>
                                            <td><?= $l['jam_pakai']; ?> jam</td>
                                            <td class="mono-text"><?= number_format($l['kwh'], 3); ?></td>
                                            <td style="text-align: right; font-weight: 600;">Rp <?= number_format($l['biaya'], 0, ',', '.'); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Tenaga Kerja -->
                <div style="background-color: var(--bg-app); border-radius: 8px; padding: 14px; border: 1px solid var(--border-divider); margin-bottom: 12px;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                        <strong style="font-size: 14px; color: var(--dark-text);">Tenaga Kerja</strong>
                        <strong style="color: var(--primary);">Rp <?= number_format($detail['biaya_tenaga_kerja'], 0, ',', '.'); ?></strong>
                    </div>
                    <?php if (!empty($detail['tenaga'])): ?>
                        <div class="table-container" style="background: #FFFFFF;">
                            <table class="custom-table" style="font-size: 12px;">
                                <thead>
                                    <tr>
                                        <th>Pekerja</th>
                                        <th>Gaji / Jam</th>
                                        <th>Jam Kerja</th>
                                        <th style="text-align: right;">Biaya</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($detail['tenaga'] as $t): ?>
                                        <tr>
                                            <td><?= html_escape($t['nama_pekerja']); ?></td>
                                            <td>Rp <?= number_format($t['gaji_per_jam'], 0, ',', '.'); ?></td>
                                            <td><?= $t['jam_kerja']; ?> jam</td>
                                            <td style="text-align: right; font-weight: 600;">Rp <?= number_format($t['biaya'], 0, ',', '.'); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Kemasan / Biaya Lain -->
                <div style="background-color: var(--bg-app); border-radius: 8px; padding: 14px; border: 1px solid var(--border-divider);">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                        <strong style="font-size: 14px; color: var(--dark-text);">Kemasan & Operasional Lain</strong>
                        <strong style="color: var(--primary);">Rp <?= number_format($detail['biaya_operasional_lain'], 0, ',', '.'); ?></strong>
                    </div>
                    <?php if (!empty($detail['operasional'])): ?>
                        <div class="table-container" style="background: #FFFFFF;">
                            <table class="custom-table" style="font-size: 12px;">
                                <thead>
                                    <tr>
                                        <th>Jenis</th>
                                        <th>Harga Beli</th>
                                        <th>Kapasitas</th>
                                        <th>Dipakai</th>
                                        <th style="text-align: right;">Biaya</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($detail['operasional'] as $o): ?>
                                        <tr>
                                            <td><?= html_escape($o['jenis_biaya']); ?></td>
                                            <td>Rp <?= number_format($o['harga'], 0, ',', '.'); ?></td>
                                            <td><?= number_format($o['kapasitas'], 0); ?></td>
                                            <td><?= number_format($o['total_pakai'], 0); ?></td>
                                            <td style="text-align: right; font-weight: 600;">Rp <?= number_format($o['biaya'], 0, ',', '.'); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- TOTAL OPERASIONAL -->
                <?php
                    $total_op = $detail['biaya_gas'] + $detail['biaya_listrik'] + $detail['biaya_tenaga_kerja'] + $detail['biaya_operasional_lain'];
                ?>
                <div class="table-footer-row" style="margin-top: 8px;">
                    <span class="footer-total-label">Total Biaya Operasional:</span>
                    <span class="footer-total-val" style="color: var(--primary);">Rp <?= number_format($total_op, 0, ',', '.'); ?></span>
                </div>
            </div>

        </div>

        <!-- SIDEBAR RINGKASAN & HARGA -->
        <div class="summary-column">

            <!-- RINGKASAN PRODUKSI -->
            <div class="summary-card">
                <div class="summary-tag">RINGKASAN PRODUKSI</div>
                <div class="summary-subtitle">Modal per pcs</div>
                <div class="summary-giant-price">Rp <?= number_format($detail['hpp_per_produk'], 0, ',', '.'); ?></div>
                
                <div class="summary-row">
                    <span class="summary-row-label">Total biaya resep:</span>
                    <span class="summary-row-val">Rp <?= number_format($detail['total_biaya_produksi'], 0, ',', '.'); ?></span>
                </div>

                <!-- Proporsi -->
                <?php
                    $pctBahan = ($detail['total_biaya_produksi'] > 0) ? ($detail['total_biaya_bahan'] / $detail['total_biaya_produksi']) * 100 : 50;
                    $pctOp = 100 - $pctBahan;
                ?>
                <div>
                    <div class="prop-bar-container">
                        <div class="prop-bar-bahan" style="width: <?= $pctBahan; ?>%;"></div>
                        <div class="prop-bar-op" style="width: <?= $pctOp; ?>%;"></div>
                    </div>
                    <div class="prop-labels" style="margin-top: 6px;">
                        <span>Bahan <?= number_format($pctBahan, 1); ?>%</span>
                        <span>Operasional <?= number_format($pctOp, 1); ?>%</span>
                    </div>
                </div>
            </div>

            <!-- HARGA JUAL -->
            <div class="selling-card">
                <h3 class="selling-title">Harga jual & Keuntungan</h3>

                <div class="price-row">
                    <span class="price-label">Target Keuntungan</span>
                    <span class="price-val"><?= number_format($detail['persen_untung'], 0); ?>%</span>
                </div>

                <div class="suggested-price-box">
                    <div class="suggested-tag">SARAN HARGA / PCS</div>
                    <div class="suggested-amount">Rp <?= number_format($detail['harga_jual_saran'], 0, ',', '.'); ?></div>
                </div>

                <div class="price-row">
                    <span class="price-label">Laba per pcs</span>
                    <span class="price-val" style="color: var(--success);">Rp <?= number_format($detail['laba_per_produk'], 0, ',', '.'); ?></span>
                </div>

                <div class="price-row">
                    <span class="price-label">Laba per resep</span>
                    <span class="price-val" style="color: var(--success); font-weight: 700;">Rp <?= number_format($detail['laba_per_resep'], 0, ',', '.'); ?></span>
                </div>

                <?php if ($detail['harga_jual_simulasi'] !== null && $detail['harga_jual_simulasi'] > 0): ?>
                    <div class="divider"></div>
                    <div style="font-weight: 600; font-size: 13px; color: var(--primary);">Simulasi Harga Khusus</div>
                    <div class="price-row">
                        <span class="price-label">Harga Jual Saya</span>
                        <span class="price-val">Rp <?= number_format($detail['harga_jual_simulasi'], 0, ',', '.'); ?></span>
                    </div>
                    <div class="price-row">
                        <span class="price-label">Keuntungan Riil / pcs</span>
                        <span class="price-val" style="color: <?= ($detail['laba_riil_per_produk'] >= 0) ? 'var(--success)' : 'var(--danger)'; ?>;">
                            Rp <?= number_format($detail['laba_riil_per_produk'], 0, ',', '.'); ?>
                        </span>
                    </div>
                <?php endif; ?>
            </div>

            <!-- BUTTON CETAK -->
            <a href="<?= site_url('riwayat/cetak/' . $detail['id_perhitungan']); ?>" target="_blank" class="btn-action-primary" style="text-decoration: none;">
                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="6 9 6 2 18 2 18 9"></polyline>
                    <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path>
                    <rect x="6" y="14" width="12" height="8"></rect>
                </svg>
                <span>Cetak / Cetak PDF</span>
            </a>

            <!-- BUTTON EDIT -->
            <a href="<?= site_url('kalkulator/index/' . $detail['id_perhitungan']); ?>" class="btn-action-secondary" style="text-decoration: none;">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                <span>Buka di Kalkulator</span>
            </a>

            <!-- BUTTON HAPUS -->
            <a href="<?= site_url('riwayat/hapus/' . $detail['id_perhitungan']); ?>" onclick="return confirm('Hapus perhitungan ini?')" class="btn-action-secondary" style="color: var(--danger); border-color: #FECACA; text-decoration: none;">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                <span>Hapus Riwayat Ini</span>
            </a>

        </div>

    </main>

</div>

</body>
</html>
