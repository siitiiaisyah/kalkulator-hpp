<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Kalkulator HPP Jualan - HitungDapur</title>
    
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
                    <circle cx="6.5" cy="16" r="1" fill="#FFFFFF"/>
                    <circle cx="10" cy="16" r="1" fill="#FFFFFF"/>
                    <circle cx="13.5" cy="16" r="1" fill="#FFFFFF"/>
                </svg>
            </div>
            <div class="brand-name">HitungDapur</div>
        </a>

        <div class="masthead-badge">
            ALAT USAHA &nbsp;/&nbsp; KALKULATOR HPP
        </div>

          <div class="masthead-actions">
            <a href="<?= site_url('riwayat'); ?>" class="btn-header" title="Lihat Riwayat Perhitungan">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"></circle>
                    <polyline points="12 6 12 12 16 14"></polyline>
                </svg>
                <span>Riwayat</span>
            </a>

            <!-- TOMBOL BARU: Bahan Master -->
            <a href="<?= site_url('master_bahan'); ?>" class="btn-header" title="Kelola Bahan Master">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                    <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                    <line x1="12" y1="22.08" x2="12" y2="12"></line>
                </svg>
                <span>Bahan Master</span>
            </a>

            <button type="button" class="btn-header primary" id="btn-simpan-master" onclick="simpanData()" title="Simpan perhitungan ke database">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                    <polyline points="17 21 17 13 7 13 7 21"></polyline>
                    <polyline points="7 3 7 8 15 8"></polyline>
                </svg>
                <span>Simpan</span>
            </button>
        </div>
    </header>

    <!-- BANNER -->
    <section class="recipe-costing-banner">
        <div class="banner-intro">
            <div class="banner-tag">LEMBAR HITUNG &nbsp;/&nbsp; 01</div>
            <h1 class="banner-title">Kalkulator HPP</h1>
            <p class="banner-subtitle">Hitung modal satu resep dan tentukan harga jual per porsi secara akurat.</p>
        </div>

        <!-- STRUK PRODUKSI TICKET -->
        <div class="recipe-ticket-box">
            <div class="recipe-ticket">
                <div class="ticket-header">
                    <div class="ticket-tag">STRUK PRODUKSI</div>
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--primary)" stroke-width="2">
                        <path d="M4 2v20l2-1 2 1 2-1 2 1 2-1 2 1 2-1 2 1V2l-2 1-2-1-2 1-2-1-2 1-2-1-2 1Z"></path>
                        <path d="M8 7h8"></path>
                        <path d="M8 11h8"></path>
                        <path d="M8 15h6"></path>
                    </svg>
                </div>
                <div class="divider"></div>
                <div class="ticket-row">
                    <span class="ticket-label">Resep:</span>
                    <span class="ticket-val" id="ticket-resep">Risol Mayo</span>
                </div>
                <div class="ticket-row">
                    <span class="ticket-label">Hasil:</span>
                    <span class="ticket-val" id="ticket-hasil">20 pcs</span>
                </div>
                <div class="divider"></div>
                <!-- BARCODE STRIPES -->
                <div class="barcode">
                    <div class="b-bar" style="width: 2px;"></div>
                    <div class="b-bar" style="width: 4px;"></div>
                    <div class="b-bar" style="width: 1px;"></div>
                    <div class="b-bar" style="width: 3px;"></div>
                    <div class="b-bar" style="width: 2px;"></div>
                    <div class="b-bar" style="width: 5px;"></div>
                    <div class="b-bar" style="width: 1px;"></div>
                    <div class="b-bar" style="width: 4px;"></div>
                    <div class="b-bar" style="width: 2px;"></div>
                    <div class="b-bar" style="width: 3px;"></div>
                    <div class="b-bar" style="width: 1px;"></div>
                    <div class="b-bar" style="width: 4px;"></div>
                    <div class="b-bar" style="width: 2px;"></div>
                    <div class="b-bar" style="width: 5px;"></div>
                    <div class="b-bar" style="width: 1px;"></div>
                    <div class="b-bar" style="width: 3px;"></div>
                    <div class="b-bar" style="width: 2px;"></div>
                    <div class="b-bar" style="width: 4px;"></div>
                    <div class="b-bar" style="width: 1px;"></div>
                    <div class="b-bar" style="width: 3px;"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- CONTENT: WORKSHEET & SUMMARY -->
    <main class="content-layout">

        <!-- WORKSHEET COLUMN (LEFT) -->
        <div class="worksheet-column">

            <!-- 01. DETAIL RESEP -->
            <div class="card-sheet">
                <div class="card-title-row">
                    <div class="step-badge">01</div>
                    <h2 class="card-heading">Detail resep</h2>
                </div>
                <div class="form-grid-2">
                    <div class="form-group">
                        <label for="nama-produk" class="form-label">Nama produk / resep</label>
                        <input type="text" id="nama-produk" class="form-control-custom" placeholder="Contoh: Risol Mayo (1 Resep)" value="<?= isset($loaded_data['nama_produk']) ? html_escape($loaded_data['nama_produk']) : 'Risol Mayo'; ?>" />
                    </div>
                    <div class="form-group">
                        <label for="jumlah-produk" class="form-label">Jumlah produk jadi (pcs)</label>
                        <input type="number" id="jumlah-produk" class="form-control-custom" placeholder="20" min="1" step="1" value="<?= isset($loaded_data['jumlah_produk']) ? $loaded_data['jumlah_produk'] : '20'; ?>" />
                    </div>
                </div>
            </div>

            <!-- 02. BAHAN BAKU -->
            <div class="card-sheet">
                <div class="card-title-row">
                    <div class="step-badge">02</div>
                    <h2 class="card-heading">Bahan baku</h2>
                </div>
                <p style="font-size: 13px; color: var(--muted-text); margin: -6px 0 6px 0;">
                    Masukkan semua bahan yang digunakan untuk satu kali resep produksi. Saran bahan otomatis akan muncul saat Anda mengetik.
                </p>

                <!-- Datalist Autocomplete dari master_bahan -->
                <datalist id="master-bahan-list">
                    <?php if (!empty($master_bahan)): ?>
                        <?php foreach ($master_bahan as $mb): ?>
                            <option value="<?= html_escape($mb['nama_bahan']); ?>">
                        <?php endforeach; ?>
                    <?php endif; ?>
                </datalist>

                <div class="table-container">
                    <table class="custom-table" id="bahan-table">
                        <thead>
                            <tr>
                                <th style="width: 38px;">No</th>
                                <th>Bahan</th>
                                <th style="width: 120px;">Harga Beli (Rp)</th>
                                <th style="width: 110px;">Satuan</th>
                                <th style="width: 110px;">Kemasan</th>
                                <th style="width: 100px;">Dipakai</th>
                                <th style="width: 110px;">Biaya</th>
                                <th style="width: 44px; text-align: center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Baris bahan ditambahkan dinamis oleh JavaScript -->
                        </tbody>
                    </table>
                </div>

                <div class="table-footer-row">
                    <button type="button" class="btn-add-row" onclick="addBahanRow()">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                        Tambah bahan
                    </button>
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <span class="footer-total-label">Total Bahan:</span>
                        <span class="footer-total-val" id="total-bahan-text">Rp 0</span>
                    </div>
                </div>
            </div>

            <!-- 03. BIAYA OPERASIONAL -->
            <div class="card-sheet">
                <div class="card-title-row">
                    <div class="step-badge">03</div>
                    <h2 class="card-heading">Biaya operasional</h2>
                </div>
                <p style="font-size: 13px; color: var(--muted-text); margin: -6px 0 4px 0;">
                    Biaya operasional mencakup gas, listrik, tenaga kerja, serta kemasan yang mendukung produksi. Klik setiap kategori untuk mengisi rincian.
                </p>

                <!-- ACCORDION 1: GAS -->
                <div class="accordion-item">
                    <div class="accordion-header">
                        <div class="accordion-header-left">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--primary)" stroke-width="2">
                                <path d="M8.5 14.5A2.5 2.5 0 0 0 11 12c0-1.38-.5-2-1-3-1.072-2.143-.224-4.054 2-6 .5 2.5 2 4.9 4 6.5 2 1.6 3 3.5 3 5.5a7 7 0 1 1-14 0c0-1.153.433-2.294 1-3a2.5 2.5 0 0 0 2.5 2.5z"></path>
                            </svg>
                            <span class="accordion-title">Gas Elpiji</span>
                        </div>
                        <div class="accordion-header-right">
                            <span class="accordion-cost-badge" id="gas-badge-cost">Rp 0</span>
                            <svg class="accordion-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"></polyline></svg>
                        </div>
                    </div>
                    <div class="accordion-body">
                        <p style="font-size: 12px; color: var(--muted-text); margin-top: 0;">
                            Estimasi konsumsi kompor standar: <strong>0.2 kg / jam</strong>.
                        </p>
                        <div class="form-grid-3">
                            <div class="form-group">
                                <label class="form-label">Lama Pemakaian (Jam)</label>
                                <input type="number" id="gas-jam" class="form-control-custom" placeholder="0" min="0" step="any" value="<?= isset($loaded_data['lama_gas_jam']) ? $loaded_data['lama_gas_jam'] : '1'; ?>" oninput="calculateGas()" />
                            </div>
                            <div class="form-group">
                                <label class="form-label">Harga Tabung Gas (Rp)</label>
                                <input type="number" id="gas-harga" class="form-control-custom" placeholder="20000" min="0" value="<?= isset($loaded_data['harga_tabung_gas']) ? $loaded_data['harga_tabung_gas'] : '20000'; ?>" oninput="calculateGas()" />
                            </div>
                            <div class="form-group">
                                <label class="form-label">Isi Tabung (kg)</label>
                                <input type="number" id="gas-isi" class="form-control-custom" placeholder="3" min="0.1" step="any" value="<?= isset($loaded_data['isi_tabung_kg']) ? $loaded_data['isi_tabung_kg'] : '3'; ?>" oninput="calculateGas()" />
                            </div>
                        </div>
                        <div style="display: flex; justify-content: flex-end; margin-top: 10px; font-size: 13px;">
                            <span style="color: var(--muted-text);">Biaya Gas Estimasi:&nbsp;</span>
                            <strong id="gas-cost-text" style="color: var(--primary);">Rp 0</strong>
                        </div>
                    </div>
                </div>

                <!-- ACCORDION 2: LISTRIK -->
                <div class="accordion-item">
                    <div class="accordion-header">
                        <div class="accordion-header-left">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--primary)" stroke-width="2">
                                <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon>
                            </svg>
                            <span class="accordion-title">Listrik (Peralatan)</span>
                        </div>
                        <div class="accordion-header-right">
                            <span class="accordion-cost-badge" id="listrik-badge-cost">Rp 0</span>
                            <svg class="accordion-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"></polyline></svg>
                        </div>
                    </div>
                    <div class="accordion-body">
                        <p style="font-size: 12px; color: var(--muted-text); margin-top: 0;">
                            Rumus: <em>daya</em> (Watt) &times; <em>t</em> (jam) &divide; 1000 = kWh. Biaya = total kWh &times; Tarif.
                        </p>

                        <!-- Pilihan Golongan PLN -->
                        <div class="form-grid-2" style="margin-bottom: 12px;">
                            <div class="form-group">
                                <label class="form-label">Pilih Tarif Golongan PLN</label>
                                <select id="select-tarif-pln" class="form-control-custom select-custom">
                                    <option value="" data-tarif="1444.70">-- Pilih Golongan Listrik --</option>
                                    <?php if (!empty($tarif_listrik)): ?>
                                        <?php foreach ($tarif_listrik as $tl): ?>
                                            <option value="<?= $tl['id_tarif']; ?>" data-tarif="<?= $tl['tarif_per_kwh']; ?>" <?= (isset($loaded_data['id_tarif']) && $loaded_data['id_tarif'] == $tl['id_tarif']) ? 'selected' : ($tl['id_tarif'] == 4 ? 'selected' : ''); ?>>
                                                <?= html_escape($tl['golongan_daya']); ?> (Rp <?= number_format($tl['tarif_per_kwh'], 2, ',', '.'); ?>/kWh)
                                            </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Tarif yang Digunakan (Rp/kWh)</label>
                                <input type="number" id="listrik-tarif" class="form-control-custom" placeholder="1444.70" step="any" min="0" value="<?= isset($loaded_data['tarif_listrik']) ? $loaded_data['tarif_listrik'] : '1444.70'; ?>" oninput="calculateListrikAll()" />
                            </div>
                        </div>

                        <!-- Tabel Peralatan Listrik -->
                        <div class="table-container">
                            <table class="custom-table" id="listrik-table">
                                <thead>
                                    <tr>
                                        <th style="width: 38px;">No</th>
                                        <th>Nama Perangkat</th>
                                        <th style="width: 110px;">Daya (W)</th>
                                        <th style="width: 100px;">Jam</th>
                                        <th style="width: 90px;">kWh</th>
                                        <th style="width: 110px;">Biaya</th>
                                        <th style="width: 44px; text-align: center;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Baris perangkat ditambahkan dinamis -->
                                </tbody>
                            </table>
                        </div>

                        <div class="table-footer-row" style="margin-top: 8px;">
                            <button type="button" class="btn-add-row" onclick="addListrikRow()">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                                Tambah Perangkat
                            </button>
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <span class="footer-total-label">Total Listrik:</span>
                                <span class="footer-total-val" id="total-listrik-text">Rp 0</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ACCORDION 3: TENAGA KERJA -->
                <div class="accordion-item">
                    <div class="accordion-header">
                        <div class="accordion-header-left">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--primary)" stroke-width="2">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                <circle cx="9" cy="7" r="4"></circle>
                                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                            </svg>
                            <span class="accordion-title">Tenaga Kerja</span>
                        </div>
                        <div class="accordion-header-right">
                            <span class="accordion-cost-badge" id="labor-badge-cost">Rp 0</span>
                            <svg class="accordion-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"></polyline></svg>
                        </div>
                    </div>
                    <div class="accordion-body">
                        <p style="font-size: 12px; color: var(--muted-text); margin-top: 0;">
                            Upah pekerja dihitung berdasarkan tarif per jam dikalikan durasi jam kerja produksi.
                        </p>
                        <div class="table-container">
                            <table class="custom-table" id="labor-table">
                                <thead>
                                    <tr>
                                        <th style="width: 38px;">No</th>
                                        <th>Nama Pekerja</th>
                                        <th style="width: 140px;">Gaji / Jam (Rp)</th>
                                        <th style="width: 100px;">Jam Kerja</th>
                                        <th style="width: 110px;">Biaya</th>
                                        <th style="width: 44px; text-align: center;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Baris tenaga kerja ditambahkan dinamis -->
                                </tbody>
                            </table>
                        </div>

                        <div class="table-footer-row" style="margin-top: 8px;">
                            <button type="button" class="btn-add-row" onclick="addLaborRow()">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                                Tambah Tenaga Kerja
                            </button>
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <span class="footer-total-label">Total Tenaga Kerja:</span>
                                <span class="footer-total-val" id="total-labor-text">Rp 0</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ACCORDION 4: KEMASAN & OPERASIONAL LAIN -->
                <div class="accordion-item">
                    <div class="accordion-header">
                        <div class="accordion-header-left">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--primary)" stroke-width="2">
                                <line x1="16.5" y1="9.4" x2="7.5" y2="4.21"></line>
                                <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                                <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                                <line x1="12" y1="22.08" x2="12" y2="12"></line>
                            </svg>
                            <span class="accordion-title">Kemasan & Biaya Lain</span>
                        </div>
                        <div class="accordion-header-right">
                            <span class="accordion-cost-badge" id="op-badge-cost">Rp 0</span>
                            <svg class="accordion-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"></polyline></svg>
                        </div>
                    </div>
                    <div class="accordion-body">
                        <p style="font-size: 12px; color: var(--muted-text); margin-top: 0;">
                            Contoh: Toples, stiker label, plastik mika, sendok mini. Rumus: (Harga beli &divide; Kapasitas pack) &times; Total pakai.
                        </p>
                        <div class="table-container">
                            <table class="custom-table" id="op-table">
                                <thead>
                                    <tr>
                                        <th style="width: 38px;">No</th>
                                        <th>Jenis Kemasan / Biaya</th>
                                        <th style="width: 120px;">Harga (Rp)</th>
                                        <th style="width: 110px;">Isi / Pack</th>
                                        <th style="width: 100px;">Dipakai</th>
                                        <th style="width: 110px;">Biaya</th>
                                        <th style="width: 44px; text-align: center;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Baris operasional ditambahkan dinamis -->
                                </tbody>
                            </table>
                        </div>

                        <div class="table-footer-row" style="margin-top: 8px;">
                            <button type="button" class="btn-add-row" onclick="addOpRow()">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                                Tambah Operasional
                            </button>
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <span class="footer-total-label">Subtotal Kemasan/Lain:</span>
                                <span class="footer-total-val" id="total-op-text">Rp 0</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TOTAL OPERASIONAL KESELURUHAN -->
                <div class="table-footer-row" style="margin-top: 10px; padding: 12px 14px; background-color: var(--primary-light); border-radius: 8px; border: 1px solid var(--border-divider);">
                    <span style="font-size: 14px; font-weight: 600; color: var(--dark-text);">Total Biaya Operasional (Gas+Listrik+Tenaga+Kemasan):</span>
                    <span style="font-size: 18px; font-weight: 700; color: var(--primary);" id="total-biaya-operasional-text">Rp 0</span>
                </div>

            </div>

        </div>

        <!-- SUMMARY COLUMN (RIGHT ON DESKTOP, BOTTOM ON MOBILE) -->
        <div class="summary-column">

            <!-- RINGKASAN PRODUKSI (DARK NAVY CARD #192C66) -->
            <div class="summary-card">
                <div class="summary-tag">RINGKASAN PRODUKSI</div>
                <div class="summary-subtitle">Modal per pcs</div>
                <div class="summary-giant-price" id="giant-hpp-per-pcs">Rp 0</div>
                
                <div class="summary-row">
                    <span class="summary-row-label">Total biaya resep:</span>
                    <span class="summary-row-val" id="recipe-total-cost-text">Rp 0</span>
                </div>

                <!-- Proportional Bar -->
                <div>
                    <div class="prop-bar-container">
                        <div class="prop-bar-bahan" id="bar-bahan" style="width: 50%;"></div>
                        <div class="prop-bar-op" id="bar-op" style="width: 50%;"></div>
                    </div>
                    <div class="prop-labels" style="margin-top: 6px;">
                        <span id="label-share-bahan">Bahan 50.0%</span>
                        <span id="label-share-op">Operasional 50.0%</span>
                    </div>
                </div>
            </div>

            <!-- HARGA JUAL & LABA CARD -->
            <div class="selling-card">
                <h3 class="selling-title">Harga jual</h3>

                <div class="form-group">
                    <label for="persen-laba" class="form-label">Target keuntungan atas modal (%)</label>
                    <input type="number" id="persen-laba" class="form-control-custom" placeholder="50" min="0" step="any" value="<?= isset($loaded_data['persen_untung']) ? $loaded_data['persen_untung'] : '50'; ?>" oninput="calculateAll()" />
                </div>

                <div class="suggested-price-box">
                    <div class="suggested-tag">SARAN HARGA / PCS</div>
                    <div class="suggested-amount" id="saran-harga-text">Rp 0</div>
                </div>

                <div class="price-row">
                    <span class="price-label">Laba per pcs</span>
                    <span class="price-val" id="laba-unit-text">Rp 0</span>
                </div>

                <div class="price-row">
                    <span class="price-label">Laba per resep</span>
                    <span class="price-val" id="laba-resep-text">Rp 0</span>
                </div>

                <div class="divider"></div>

                <!-- SIMULASI HARGA KHUSUS -->
                <div class="simulasi-toggle" id="simulasi-toggle">
                    <span>Simulasi harga khusus</span>
                    <svg class="accordion-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"></polyline></svg>
                </div>

                <div class="simulasi-body" id="simulasi-body">
                    <div class="form-group">
                        <label for="harga-jual-manual" class="form-label">Harga jual saya (per pcs)</label>
                        <input type="number" id="harga-jual-manual" class="form-control-custom" placeholder="Contoh: 15000" min="0" value="<?= isset($loaded_data['harga_jual_simulasi']) ? $loaded_data['harga_jual_simulasi'] : ''; ?>" oninput="calculateAll()" />
                    </div>
                    <div class="price-row">
                        <span class="price-label">Keuntungan riil / pcs</span>
                        <span class="price-val" id="laba-riil-unit-text">Rp 0</span>
                    </div>
                    <div class="price-row">
                        <span class="price-label">Keuntungan riil / resep</span>
                        <span class="price-val" id="laba-riil-resep-text">Rp 0</span>
                    </div>
                </div>
            </div>

            <!-- BUTTON CETAK / SIMPAN PDF -->
            <button type="button" class="btn-action-primary" onclick="window.print()">
                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="6 9 6 2 18 2 18 9"></polyline>
                    <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path>
                    <rect x="6" y="14" width="12" height="8"></rect>
                </svg>
                <span>Cetak / Simpan PDF</span>
            </button>

            <!-- BUTTON SIMPAN DATA KE DATABASE -->
            <button type="button" class="btn-action-secondary" onclick="simpanData()">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                    <polyline points="17 21 17 13 7 13 7 21"></polyline>
                    <polyline points="7 3 7 8 15 8"></polyline>
                </svg>
                <span>Simpan Perhitungan Ini</span>
            </button>

        </div>

    </main>

</div>

<!-- Global Config variables for JS -->
<script>
    window.BASE_URL = '<?= rtrim(base_url(), "/") . "/"; ?>';
    window.MASTER_BAHAN_DATA = <?= json_encode(!empty($master_bahan) ? $master_bahan : []); ?>;
    <?php if (!empty($loaded_data)): ?>
        window.PRELOADED_DATA = <?= json_encode($loaded_data); ?>;
    <?php else: ?>
        window.PRELOADED_DATA = null;
    <?php endif; ?>
</script>

<!-- Scripts -->
<script src="<?= base_url('assets/js/validation.js'); ?>"></script>
<script src="<?= base_url('assets/js/calculator.js'); ?>"></script>

</body>
</html>
