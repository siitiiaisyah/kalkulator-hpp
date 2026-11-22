<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Laporan HPP - <?= html_escape($detail['nama_produk']); ?> - HitungDapur</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Mono:wght@400;500;600;700&family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />

    <style>
        :root {
            --primary: #2243BD;
            --primary-light: #E6EDFF;
            --dark-card: #192C66;
            --dark-text: #17264D;
            --muted-text: #58647D;
            --border-divider: #CBD3E1;
            --bg-light: #F6F8FC;
            --white: #FFFFFF;
            --success: #16A34A;
        }

        *, *::before, *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background-color: var(--bg-light);
            color: var(--dark-text);
            line-height: 1.5;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        /* Top Action Bar (hidden on print) */
        .no-print-bar {
            background-color: var(--white);
            border-bottom: 1px solid var(--border-divider);
            padding: 12px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        }

        .bar-left {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .bar-title {
            font-size: 14px;
            font-weight: 600;
            color: var(--dark-text);
        }

        .bar-actions {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .btn-action {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.2s ease;
            border: 1px solid var(--border-divider);
            background-color: var(--white);
            color: var(--dark-text);
        }

        .btn-action:hover {
            background-color: #f1f5f9;
        }

        .btn-action.primary {
            background-color: var(--primary);
            border-color: var(--primary);
            color: var(--white);
        }

        .btn-action.primary:hover {
            background-color: #1a349b;
        }

        /* Printable Sheet Container (A4 layout) */
        .sheet-container {
            max-width: 860px;
            margin: 28px auto 40px;
            background-color: var(--white);
            padding: 40px 48px;
            border-radius: 8px;
            border: 1px solid var(--border-divider);
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        }

        /* Header Document */
        .doc-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            border-bottom: 2px solid var(--dark-text);
            padding-bottom: 20px;
            margin-bottom: 24px;
        }

        .doc-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 8px;
        }

        .brand-icon {
            width: 32px;
            height: 32px;
            background-color: var(--primary);
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .brand-name {
            font-size: 20px;
            font-weight: 800;
            letter-spacing: -0.5px;
            color: var(--dark-text);
        }

        .doc-subtitle {
            font-family: 'IBM Plex Mono', monospace;
            font-size: 11px;
            font-weight: 600;
            color: var(--muted-text);
            letter-spacing: 0.5px;
        }

        .doc-meta {
            text-align: right;
            font-family: 'IBM Plex Mono', monospace;
            font-size: 12px;
            color: var(--muted-text);
        }

        .doc-meta .doc-no {
            font-size: 14px;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 4px;
        }

        /* Title section */
        .title-section {
            margin-bottom: 24px;
        }

        .title-section h1 {
            font-size: 26px;
            font-weight: 800;
            letter-spacing: -0.8px;
            color: var(--dark-text);
            margin-bottom: 6px;
        }

        .title-section p {
            font-size: 14px;
            color: var(--muted-text);
        }

        /* Highlight Summary Grid */
        .summary-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
            margin-bottom: 28px;
        }

        .summary-box {
            background-color: var(--bg-light);
            border: 1px solid var(--border-divider);
            border-radius: 8px;
            padding: 14px 16px;
        }

        .summary-box.highlight-dark {
            background-color: var(--dark-card);
            border-color: var(--dark-card);
            color: var(--white);
        }

        .summary-box.highlight-primary {
            background-color: var(--primary);
            border-color: var(--primary);
            color: var(--white);
        }

        .summary-box-tag {
            font-family: 'IBM Plex Mono', monospace;
            font-size: 10px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
            opacity: 0.85;
        }

        .summary-box-val {
            font-size: 18px;
            font-weight: 800;
            letter-spacing: -0.5px;
        }

        .summary-box-sub {
            font-size: 11px;
            margin-top: 3px;
            opacity: 0.8;
        }

        /* Section Headings */
        .section-heading {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-top: 24px;
            margin-bottom: 12px;
            padding-bottom: 6px;
            border-bottom: 1px solid var(--border-divider);
        }

        .section-num {
            font-family: 'IBM Plex Mono', monospace;
            font-size: 11px;
            font-weight: 700;
            background-color: var(--primary);
            color: var(--white);
            padding: 2px 7px;
            border-radius: 4px;
        }

        .section-title {
            font-size: 14px;
            font-weight: 700;
            color: var(--dark-text);
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        /* Printable Table */
        .print-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
            margin-bottom: 12px;
        }

        .print-table th, .print-table td {
            padding: 7px 10px;
            text-align: left;
            border-bottom: 1px solid #E2E8F0;
        }

        .print-table th {
            background-color: var(--bg-light);
            font-weight: 600;
            color: var(--muted-text);
            text-transform: uppercase;
            font-size: 10px;
            letter-spacing: 0.5px;
            border-top: 1px solid var(--border-divider);
            border-bottom: 1px solid var(--border-divider);
        }

        .print-table td.num {
            text-align: right;
            font-family: 'IBM Plex Mono', monospace;
            font-weight: 600;
        }

        .print-table td.center {
            text-align: center;
        }

        .table-subtotal-row {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            gap: 16px;
            padding: 8px 10px;
            background-color: var(--bg-light);
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
            margin-bottom: 16px;
        }

        .table-subtotal-val {
            font-family: 'IBM Plex Mono', monospace;
            font-size: 13px;
            font-weight: 700;
            color: var(--primary);
        }

        /* 2-Col Grid for Side-by-side Tables */
        .two-col-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        /* Grand Total Box */
        .grand-total-box {
            background-color: #F8FAFC;
            border: 1.5px solid var(--border-divider);
            border-radius: 8px;
            padding: 16px 20px;
            margin-top: 24px;
            margin-bottom: 24px;
        }

        .grand-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 6px 0;
            font-size: 13px;
            border-bottom: 1px dashed #E2E8F0;
        }

        .grand-row:last-child {
            border-bottom: none;
            padding-top: 10px;
            margin-top: 6px;
            border-top: 2px solid var(--dark-text);
            font-size: 15px;
            font-weight: 800;
        }

        .grand-row .val {
            font-family: 'IBM Plex Mono', monospace;
            font-weight: 700;
        }

        /* Signature Area */
        .signature-area {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            margin-top: 48px;
            padding-top: 20px;
            page-break-inside: avoid;
        }

        .signature-box {
            text-align: center;
            font-size: 12px;
        }

        .signature-box .role {
            font-weight: 600;
            color: var(--muted-text);
            margin-bottom: 60px;
        }

        .signature-box .line {
            width: 180px;
            margin: 0 auto 6px;
            border-bottom: 1px solid var(--dark-text);
        }

        .signature-box .name {
            font-weight: 700;
            color: var(--dark-text);
        }

        /* Footer watermark */
        .doc-footer {
            margin-top: 32px;
            padding-top: 14px;
            border-top: 1px solid var(--border-divider);
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 10px;
            color: var(--muted-text);
            font-family: 'IBM Plex Mono', monospace;
        }

        /* Print Media Styles */
        @media print {
            body {
                background-color: #FFFFFF !important;
            }

            .no-print-bar {
                display: none !important;
            }

            .sheet-container {
                max-width: 100% !important;
                margin: 0 !important;
                padding: 0 !important;
                border: none !important;
                box-shadow: none !important;
            }

            @page {
                size: A4;
                margin: 15mm 15mm 15mm 15mm;
            }
        }
    </style>
</head>
<body>

    <!-- Top Action Bar (Hanya tampil di layar) -->
    <div class="no-print-bar">
        <div class="bar-left">
            <span class="bar-title">Pratinjau Cetak / Ekspor PDF</span>
        </div>
        <div class="bar-actions">
            <a href="<?= site_url('riwayat/detail/' . $detail['id_perhitungan']); ?>" class="btn-action">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"></polyline></svg>
                Kembali ke Detail
            </a>
            <a href="<?= site_url('kalkulator/index/' . $detail['id_perhitungan']); ?>" class="btn-action">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                Edit di Kalkulator
            </a>
            <button type="button" class="btn-action primary" onclick="window.print()">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
                Cetak / Simpan PDF
            </button>
        </div>
    </div>

    <!-- Lembar Cetak Dokumen A4 -->
    <div class="sheet-container">

        <!-- Dokumen Header -->
        <header class="doc-header">
            <div>
                <div class="doc-brand">
                    <div class="brand-icon">
                        <svg viewBox="0 0 20 20" width="18" height="18" fill="none" xmlns="http://www.w3.org/2000/svg">
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
                    <span class="brand-name">HitungDapur</span>
                </div>
                <div class="doc-subtitle">SISTEM KALKULATOR HARGA POKOK PRODUKSI (HPP) &bull; PPSI</div>
            </div>
            <div class="doc-meta">
                <div class="doc-no">REF #<?= str_pad($detail['id_perhitungan'], 6, '0', STR_PAD_LEFT); ?></div>
                <div>Tanggal: <?= date('d/m/Y H:i', strtotime($detail['created_at'])); ?></div>
                <div>Status: Terverifikasi Sistem</div>
            </div>
        </header>

        <!-- Judul Produk -->
        <div class="title-section">
            <h1><?= html_escape($detail['nama_produk']); ?></h1>
            <p>Lembar Rincian Biaya Pokok Produksi dan Rekomendasi Penentuan Harga Jual Porsi/Unit</p>
        </div>

        <!-- 4 Kotak Ringkasan Utama -->
        <div class="summary-grid">
            <div class="summary-box highlight-dark">
                <div class="summary-box-tag">HPP per Pcs/Porsi</div>
                <div class="summary-box-val">Rp <?= number_format($detail['hpp_per_produk'], 0, ',', '.'); ?></div>
                <div class="summary-box-sub">Modal Dasar / Unit</div>
            </div>
            <div class="summary-box">
                <div class="summary-box-tag">Total Modal Resep</div>
                <div class="summary-box-val" style="color: var(--primary);">Rp <?= number_format($detail['total_biaya_produksi'], 0, ',', '.'); ?></div>
                <div class="summary-box-sub">Hasil: <?= $detail['jumlah_produk']; ?> pcs</div>
            </div>
            <div class="summary-box highlight-primary">
                <div class="summary-box-tag">Saran Harga Jual</div>
                <div class="summary-box-val">Rp <?= number_format($detail['harga_jual_saran'], 0, ',', '.'); ?></div>
                <div class="summary-box-sub">Target Margin +<?= $detail['persen_untung']; ?>%</div>
            </div>
            <div class="summary-box">
                <div class="summary-box-tag">Estimasi Laba Resep</div>
                <div class="summary-box-val" style="color: var(--success);">Rp <?= number_format($detail['keuntungan_per_resep'], 0, ',', '.'); ?></div>
                <div class="summary-box-sub">Rp <?= number_format($detail['keuntungan_per_produk'], 0, ',', '.'); ?> / pcs</div>
            </div>
        </div>

        <!-- 1. BIAYA BAHAN BAKU -->
        <div class="section-heading">
            <span class="section-num">01</span>
            <span class="section-title">Rincian Biaya Bahan Baku</span>
        </div>
        <table class="print-table">
            <thead>
                <tr>
                    <th style="width: 35px;" class="center">No</th>
                    <th>Nama Bahan</th>
                    <th style="text-align: right;">Harga Beli</th>
                    <th style="text-align: right;">Isi Kemasan</th>
                    <th style="text-align: right;">Jumlah Terpakai</th>
                    <th style="text-align: right;">Biaya Terpakai (Rp)</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($detail['bahan'])): ?>
                    <?php $no = 1; foreach ($detail['bahan'] as $b): ?>
                        <tr>
                            <td class="center"><?= $no++; ?></td>
                            <td><strong><?= html_escape($b['nama_bahan']); ?></strong></td>
                            <td class="num">Rp <?= number_format($b['harga_beli'], 0, ',', '.'); ?></td>
                            <td class="num"><?= number_format($b['isi_kemasan'], 0, ',', '.'); ?> <?= html_escape($b['satuan']); ?></td>
                            <td class="num"><?= number_format($b['jumlah_terpakai'], 0, ',', '.'); ?> <?= html_escape($b['satuan']); ?></td>
                            <td class="num" style="color: var(--primary);">Rp <?= number_format($b['biaya'], 0, ',', '.'); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="6" class="center">Tidak ada bahan baku.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
        <div class="table-subtotal-row">
            <span>Subtotal Biaya Bahan Baku:</span>
            <span class="table-subtotal-val">Rp <?= number_format($detail['total_biaya_bahan'], 0, ',', '.'); ?></span>
        </div>

        <!-- 2. BIAYA GAS & LISTRIK (2 KOLOM) -->
        <div class="section-heading">
            <span class="section-num">02</span>
            <span class="section-title">Biaya Utilitas: Gas & Listrik</span>
        </div>
        <div class="two-col-grid">
            <!-- Kolom Gas -->
            <div>
                <table class="print-table">
                    <thead>
                        <tr><th colspan="2">Perhitungan Gas (0.2 kg/jam)</th></tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Lama Nyala Api</td>
                            <td class="num"><?= $detail['lama_gas_jam']; ?> Jam</td>
                        </tr>
                        <tr>
                            <td>Harga Tabung Gas</td>
                            <td class="num">Rp <?= number_format($detail['harga_tabung_gas'], 0, ',', '.'); ?></td>
                        </tr>
                        <tr>
                            <td>Kapasitas Tabung</td>
                            <td class="num"><?= $detail['isi_tabung_kg']; ?> kg</td>
                        </tr>
                        <tr style="background-color: var(--bg-light); font-weight: 700;">
                            <td>Biaya Gas Estimasi</td>
                            <td class="num" style="color: var(--primary);">Rp <?= number_format($detail['total_biaya_gas'], 0, ',', '.'); ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Kolom Listrik -->
            <div>
                <table class="print-table">
                    <thead>
                        <tr>
                            <th>Perangkat Listrik</th>
                            <th style="text-align: right;">Daya</th>
                            <th style="text-align: right;">Durasi</th>
                            <th style="text-align: right;">Biaya</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($detail['listrik'])): ?>
                            <?php foreach ($detail['listrik'] as $l): ?>
                                <tr>
                                    <td><?= html_escape($l['nama_perangkat']); ?></td>
                                    <td class="num"><?= $l['daya_watt']; ?> W</td>
                                    <td class="num"><?= $l['jam_pakai']; ?> Jam</td>
                                    <td class="num">Rp <?= number_format($l['biaya'], 0, ',', '.'); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="4" class="center">Tidak ada perangkat listrik.</td></tr>
                        <?php endif; ?>
                        <tr style="background-color: var(--bg-light); font-weight: 700;">
                            <td colspan="3">Total Biaya Listrik (Tarif: Rp <?= number_format($detail['tarif_listrik'], 0, ',', '.'); ?>/kWh)</td>
                            <td class="num" style="color: var(--primary);">Rp <?= number_format($detail['total_biaya_listrik'], 0, ',', '.'); ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- 3. TENAGA KERJA & OPERASIONAL LAIN (2 KOLOM) -->
        <div class="section-heading">
            <span class="section-num">03</span>
            <span class="section-title">Tenaga Kerja & Operasional / Kemasan</span>
        </div>
        <div class="two-col-grid">
            <!-- Kolom Tenaga Kerja -->
            <div>
                <table class="print-table">
                    <thead>
                        <tr>
                            <th>Nama Pekerja</th>
                            <th style="text-align: right;">Gaji/Jam</th>
                            <th style="text-align: right;">Jam</th>
                            <th style="text-align: right;">Biaya</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($detail['tenaga'])): ?>
                            <?php foreach ($detail['tenaga'] as $t): ?>
                                <tr>
                                    <td><?= html_escape($t['nama_pekerja']); ?></td>
                                    <td class="num">Rp <?= number_format($t['gaji_per_jam'], 0, ',', '.'); ?></td>
                                    <td class="num"><?= $t['jam_kerja']; ?> Jam</td>
                                    <td class="num">Rp <?= number_format($t['biaya'], 0, ',', '.'); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="4" class="center">Tidak ada data tenaga kerja.</td></tr>
                        <?php endif; ?>
                        <tr style="background-color: var(--bg-light); font-weight: 700;">
                            <td colspan="3">Total Biaya Tenaga Kerja</td>
                            <td class="num" style="color: var(--primary);">Rp <?= number_format($detail['total_biaya_tenaga_kerja'], 0, ',', '.'); ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Kolom Kemasan & Operasional Lain -->
            <div>
                <table class="print-table">
                    <thead>
                        <tr>
                            <th>Jenis Biaya</th>
                            <th style="text-align: right;">Harga</th>
                            <th style="text-align: right;">Pakai</th>
                            <th style="text-align: right;">Biaya</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($detail['operasional'])): ?>
                            <?php foreach ($detail['operasional'] as $op): ?>
                                <tr>
                                    <td><?= html_escape($op['jenis_biaya']); ?></td>
                                    <td class="num">Rp <?= number_format($op['harga'], 0, ',', '.'); ?></td>
                                    <td class="num"><?= $op['total_pakai']; ?> / <?= $op['kapasitas']; ?></td>
                                    <td class="num">Rp <?= number_format($op['biaya'], 0, ',', '.'); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="4" class="center">Tidak ada biaya operasional lain.</td></tr>
                        <?php endif; ?>
                        <tr style="background-color: var(--bg-light); font-weight: 700;">
                            <td colspan="3">Subtotal Kemasan & Lainnya</td>
                            <td class="num" style="color: var(--primary);">Rp <?= number_format($detail['total_biaya_operasional_lain'], 0, ',', '.'); ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- REKAPITULASI BIAYA & PENENTUAN HARGA -->
        <div class="grand-total-box">
            <div class="grand-row">
                <span>Total Biaya Bahan Baku</span>
                <span class="val">Rp <?= number_format($detail['total_biaya_bahan'], 0, ',', '.'); ?></span>
            </div>
            <div class="grand-row">
                <span>Total Biaya Operasional (Gas + Listrik + Tenaga + Kemasan)</span>
                <span class="val">Rp <?= number_format($detail['total_biaya_operasional'], 0, ',', '.'); ?></span>
            </div>
            <div class="grand-row">
                <span>TOTAL BIAYA PRODUKSI (HPP SATU RESEP)</span>
                <span class="val" style="color: var(--primary); font-size: 15px;">Rp <?= number_format($detail['total_biaya_produksi'], 0, ',', '.'); ?></span>
            </div>
            <div class="grand-row">
                <span>Jumlah Hasil Jadi (Porsi/Batch)</span>
                <span class="val"><?= $detail['jumlah_produk']; ?> Pcs / Porsi</span>
            </div>
            <div class="grand-row">
                <span>HARGA POKOK PRODUKSI PER UNIT (HPP / PCS)</span>
                <span class="val" style="color: var(--primary); font-size: 16px;">Rp <?= number_format($detail['hpp_per_produk'], 0, ',', '.'); ?></span>
            </div>
            <div class="grand-row">
                <span>Target Persentase Keuntungan</span>
                <span class="val">+ <?= $detail['persen_untung']; ?>%</span>
            </div>
            <div class="grand-row">
                <span>REKOMENDASI HARGA JUAL PER PCS</span>
                <span class="val" style="color: var(--success); font-size: 17px;">Rp <?= number_format($detail['harga_jual_saran'], 0, ',', '.'); ?></span>
            </div>
            <div class="grand-row">
                <span>ESTIMASI TOTAL KEUNTUNGAN SATU RESEP</span>
                <span class="val" style="color: var(--success); font-size: 16px;">Rp <?= number_format($detail['keuntungan_per_resep'], 0, ',', '.'); ?></span>
            </div>

            <?php if (!empty($detail['harga_jual_simulasi']) && $detail['harga_jual_simulasi'] > 0): ?>
                <div class="grand-row" style="background-color: #FEF3C7; padding: 8px 10px; border-radius: 4px; margin-top: 8px;">
                    <span style="font-weight: 700; color: #92400E;">Simulasi Harga Khusus (Rp <?= number_format($detail['harga_jual_simulasi'], 0, ',', '.'); ?>/pcs)</span>
                    <span class="val" style="color: #92400E;">Keuntungan Riil: Rp <?= number_format($detail['keuntungan_simulasi_per_resep'], 0, ',', '.'); ?></span>
                </div>
            <?php endif; ?>
        </div>

        <!-- Kolom Tanda Tangan -->
        <div class="signature-area">
            <div class="signature-box">
                <div class="role">Dihitung & Dibuat Oleh:</div>
                <div class="line"></div>
                <div class="name">Staff / Penanggung Jawab Dapur</div>
            </div>
            <div class="signature-box">
                <div class="role">Disetujui Oleh:</div>
                <div class="line"></div>
                <div class="name">Pemilik Usaha (Owner)</div>
            </div>
        </div>

        <!-- Watermark / Footer -->
        <footer class="doc-footer">
            <span>Dokumen dicetak secara digital melalui aplikasi HitungDapur.</span>
            <span>Halaman 1 dari 1 &bull; <?= date('Y-m-d H:i:s'); ?></span>
        </footer>

    </div>

    <!-- Auto-print trigger jika ada parameter ?auto=1 -->
    <script>
        if (new URLSearchParams(window.location.search).get('auto') === '1') {
            window.addEventListener('load', () => {
                setTimeout(() => { window.print(); }, 400);
            });
        }
    </script>
</body>
</html>
