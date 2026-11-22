<!doctype html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Bahan Master - HitungDapur</title>

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=IBM+Plex+Mono:wght@400;500;600;700&family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet" />

    <link rel="stylesheet" href="<?= base_url('assets/css/style.css'); ?>" />

    <style>
        .mb-input {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #E2E6F0;
            border-radius: 8px;
            font: 14px 'Inter', sans-serif;
            box-sizing: border-box;
        }

        .mb-label {
            display: block;
            font-size: 12px;
            color: var(--muted-text);
            margin-bottom: 4px;
        }

        .mb-field {
            margin-bottom: 12px;
        }

        .mb-row {
            display: flex;
            gap: 10px;
        }

        .mb-row .mb-field {
            flex: 1;
        }

        #dlg {
            border: none;
            border-radius: 12px;
            padding: 24px;
            width: 420px;
            max-width: 92vw;
        }

        #dlg::backdrop {
            background: rgba(0, 0, 0, .4);
        }

        #dlg h3 {
            margin: 0 0 16px;
        }

        .mb-actions {
            display: flex;
            justify-content: flex-end;
            gap: 8px;
            margin-top: 16px;
        }

        .btn-header {
            cursor: pointer;
        }
    </style>
</head>

<body>

    <div class="app-wrapper">

        <!-- MASTHEAD -->
        <header class="masthead">
            <a href="<?= site_url(); ?>" class="brand-wrapper">
                <div class="calculator-mark">
                    <svg viewBox="0 0 20 20" width="20" height="20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="3" y="2" width="14" height="16" rx="2" stroke="#FFFFFF" stroke-width="1.8" />
                        <rect x="5.5" y="4.5" width="9" height="2.8" rx="0.8" fill="#FFFFFF" />
                        <circle cx="6.5" cy="10" r="1" fill="#FFFFFF" />
                        <circle cx="10" cy="10" r="1" fill="#FFFFFF" />
                        <circle cx="13.5" cy="10" r="1" fill="#FFFFFF" />
                        <circle cx="6.5" cy="13" r="1" fill="#FFFFFF" />
                        <circle cx="10" cy="13" r="1" fill="#FFFFFF" />
                        <circle cx="13.5" cy="13" r="1" fill="#FFFFFF" />
                    </svg>
                </div>
                <div class="brand-name">HitungDapur</div>
            </a>

            <div class="masthead-badge">
                DATA MASTER BAHAN
            </div>

            <div class="masthead-actions">
                <a href="<?= site_url('riwayat'); ?>" class="btn-header">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"></circle>
                        <polyline points="12 6 12 12 16 14"></polyline>
                    </svg>
                    <span>Riwayat</span>
                </a>
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
                <div class="banner-tag">DATA MASTER &nbsp;/&nbsp; BAHAN</div>
                <h1 class="banner-title" style="font-size: 38px;">Bahan Master</h1>
                <p class="banner-subtitle">Simpan bahan yang sering dipakai, jadi tidak perlu mengetik ulang di
                    kalkulator.</p>
            </div>
        </section>

        <!-- CONTENT -->
        <main style="padding: 32px 40px; display: flex; flex-direction: column; gap: 20px;">

            <?php if ($this->session->flashdata('success')): ?>
                <div
                    style="background-color: #D1FAE5; color: #065F46; padding: 12px 16px; border-radius: 8px; font-size: 13px; font-weight: 500; border: 1px solid #A7F3D0;">
                    <?= html_escape($this->session->flashdata('success')); ?>
                </div>
            <?php endif; ?>

            <?php if ($this->session->flashdata('error')): ?>
                <div
                    style="background-color: var(--danger-bg); color: var(--danger); padding: 12px 16px; border-radius: 8px; font-size: 13px; font-weight: 500; border: 1px solid #FECACA;">
                    <?= html_escape($this->session->flashdata('error')); ?>
                </div>
            <?php endif; ?>

            <div class="card-sheet">
                <div
                    style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
                    <h2 class="card-heading">Daftar Bahan Master</h2>

                    <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                        <form method="get" action="<?= site_url('master_bahan'); ?>"
                            style="display: flex; gap: 6px; margin: 0;">
                            <input type="text" name="q" class="mb-input"
                                style="width: 200px; padding: 6px 10px; font-size: 13px;" placeholder="Cari bahan..."
                                value="<?= html_escape($keyword); ?>">
                            <button type="submit" class="btn-header"
                                style="font-size: 12px; padding: 6px 12px;">Cari</button>
                        </form>
                        <button type="button" class="btn-header primary" style="font-size: 12px; padding: 6px 12px;"
                            onclick="bukaForm()">
                            + Tambah Bahan
                        </button>
                    </div>
                </div>

                <?php if (empty($bahan)): ?>
                    <div style="text-align: center; padding: 48px 20px; color: var(--muted-text);">
                        <p style="font-size: 16px; font-weight: 600; margin: 0 0 6px 0; color: var(--dark-text);">Belum Ada
                            Bahan Master</p>
                        <p style="font-size: 13px; margin: 0;">Klik "+ Tambah Bahan" untuk menyimpan bahan pertama Anda.</p>
                    </div>
                <?php else: ?>
                    <div class="table-container">
                        <table class="custom-table">
                            <thead>
                                <tr>
                                    <th style="width: 40px;">No</th>
                                    <th>Bahan</th>
                                    <th style="width: 90px;">Satuan</th>
                                    <th style="width: 130px;">Harga Beli</th>
                                    <th style="width: 110px;">Isi Kemasan</th>
                                    <th style="width: 130px;">Harga / Satuan</th>
                                    <th style="width: 150px; text-align: center;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($bahan as $b): ?>
                                    <tr>
                                        <td class="text-center" style="font-weight: 600; color: var(--muted-text);">
                                            <?= $no++; ?></td>
                                        <td>
                                            <div style="font-weight: 600; color: var(--primary); font-size: 14px;">
                                                <?= html_escape($b->nama_bahan); ?>
                                            </div>
                                        </td>
                                        <td><?= html_escape($b->satuan); ?></td>
                                        <td>Rp <?= number_format($b->harga_beli_terakhir, 0, ',', '.'); ?></td>
                                        <td><?= rtrim(rtrim(number_format($b->isi_kemasan_terakhir, 2, ',', '.'), '0'), ','); ?>
                                        </td>
                                        <td>
                                            <strong style="color: var(--primary);">
                                                Rp
                                                <?= number_format($b->harga_beli_terakhir / $b->isi_kemasan_terakhir, 0, ',', '.'); ?>
                                            </strong>
                                        </td>
                                        <td style="text-align: center;">
                                            <div style="display: inline-flex; gap: 6px;">
                                                <button type="button" class="btn-header"
                                                    style="padding: 4px 8px; font-size: 11px;"
                                                    data-id="<?= $b->id_master_bahan; ?>"
                                                    data-nama="<?= html_escape($b->nama_bahan); ?>"
                                                    data-satuan="<?= html_escape($b->satuan); ?>"
                                                    data-harga="<?= $b->harga_beli_terakhir; ?>"
                                                    data-isi="<?= $b->isi_kemasan_terakhir; ?>"
                                                    onclick="bukaForm(this)">Edit</button>

                                                <?= form_open('master_bahan/hapus', ['style' => 'margin:0', 'onsubmit' => "return confirm('Hapus bahan ini?')"]); ?>
                                                <input type="hidden" name="id_master_bahan" value="<?= $b->id_master_bahan; ?>">
                                                <button type="submit" class="btn-header"
                                                    style="padding: 4px 8px; font-size: 11px; color: var(--danger); border-color: #FECACA;">Hapus</button>
                                                <?= form_close(); ?>
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

    <!-- MODAL TAMBAH / EDIT -->
    <dialog id="dlg">
        <?= form_open('master_bahan/simpan'); ?>
        <h3 id="dlgTitle">Tambah Bahan</h3>
        <input type="hidden" name="id_master_bahan" id="f_id">

        <div class="mb-field">
            <label class="mb-label">Nama bahan</label>
            <input type="text" class="mb-input" name="nama_bahan" id="f_nama" maxlength="50" required>
        </div>

        <div class="mb-row">
            <div class="mb-field">
                <label class="mb-label">Satuan</label>
                <select class="mb-input" name="satuan" id="f_satuan">
                    <option value="gr">Gram (gr)</option>
                    <option value="ml">Mililiter (ml)</option>
                    <option value="pcs">Pcs</option>
                </select>
            </div>
            <div class="mb-field">
                <label class="mb-label">Isi kemasan</label>
                <input type="number" class="mb-input" name="isi_kemasan_terakhir" id="f_isi" step="0.01" min="0.01"
                    required>
            </div>
        </div>

        <div class="mb-field">
            <label class="mb-label">Harga beli per kemasan (Rp)</label>
            <input type="number" class="mb-input" name="harga_beli_terakhir" id="f_harga" step="1" min="1" required>
        </div>

        <div class="mb-actions">
            <button type="button" class="btn-header" onclick="document.getElementById('dlg').close()">Batal</button>
            <button type="submit" class="btn-header primary">Simpan</button>
        </div>
        <?= form_close(); ?>
    </dialog>

    <script>
        function bukaForm(btn) {
            document.getElementById('dlgTitle').textContent = btn ? 'Edit Bahan' : 'Tambah Bahan';
            document.getElementById('f_id').value = btn ? btn.dataset.id : '';
            document.getElementById('f_nama').value = btn ? btn.dataset.nama : '';
            document.getElementById('f_satuan').value = btn ? btn.dataset.satuan : 'gr';
            document.getElementById('f_isi').value = btn ? btn.dataset.isi : '';
            document.getElementById('f_harga').value = btn ? btn.dataset.harga : '';
            document.getElementById('dlg').showModal();
        }
    </script>
</body>

</html>