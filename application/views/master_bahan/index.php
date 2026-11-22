<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Bahan Master - HitungDapur</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
  :root { --blue:#2342c0; --navy:#1b2a6b; --bg:#f4f6fb; --line:#e2e6f0; --muted:#6b7490; }
  * { box-sizing:border-box; }
  body { margin:0; font-family:'Inter',sans-serif; background:var(--bg); color:#1c2340; }
  .wrap { max-width:1000px; margin:0 auto; background:#fff; min-height:100vh; }
  .nav { display:flex; justify-content:space-between; align-items:center; padding:14px 32px; border-bottom:1px solid var(--line); }
  .nav .brand { font-weight:700; font-size:18px; color:#1c2340; text-decoration:none; }
  .btn { display:inline-block; padding:8px 14px; border-radius:6px; border:1px solid var(--line); background:#fff; font:600 13px 'Inter'; cursor:pointer; text-decoration:none; color:#1c2340; }
  .btn.primary { background:var(--blue); color:#fff; border-color:var(--blue); }
  .btn.danger { color:#c62828; }
  .hero { background:var(--blue); color:#fff; padding:32px; }
  .hero h1 { margin:0 0 6px; font-size:32px; }
  .hero p { margin:0; opacity:.85; font-size:14px; }
  .content { padding:24px 32px 48px; }
  .toolbar { display:flex; gap:10px; justify-content:space-between; margin-bottom:16px; }
  .toolbar form { display:flex; gap:8px; flex:1; }
  input, select { padding:10px 12px; border:1px solid var(--line); border-radius:6px; font:14px 'Inter'; width:100%; }
  table { width:100%; border-collapse:collapse; font-size:14px; }
  th { text-align:left; font-size:11px; letter-spacing:.05em; color:var(--muted); background:#f4f6fb; padding:10px 12px; }
  td { padding:12px; border-bottom:1px solid var(--line); }
  td.num { text-align:right; }
  .alert { padding:10px 14px; border-radius:6px; margin-bottom:14px; font-size:14px; }
  .alert.success { background:#e8f5e9; color:#2e7d32; }
  .alert.error { background:#fdecea; color:#c62828; }
  dialog { border:none; border-radius:12px; padding:24px; width:420px; max-width:92vw; }
  dialog::backdrop { background:rgba(0,0,0,.4); }
  dialog h3 { margin:0 0 16px; }
  .field { margin-bottom:12px; }
  .field label { display:block; font-size:12px; color:var(--muted); margin-bottom:4px; }
  .row { display:flex; gap:10px; }
  .actions { display:flex; justify-content:flex-end; gap:8px; margin-top:16px; }
  .empty { text-align:center; color:var(--muted); padding:32px; }
</style>
</head>
<body>
<div class="wrap">

  <div class="nav">
    <a class="brand" href="<?= base_url() ?>">HitungDapur</a>
    <div>
      <a class="btn" href="<?= base_url() ?>">&larr; Kembali ke Kalkulator</a>
    </div>
  </div>

  <div class="hero">
    <h1>Bahan Master</h1>
    <p>Simpan bahan yang sering dipakai, jadi tidak perlu mengetik ulang di kalkulator.</p>
  </div>

  <div class="content">

    <?php if ($this->session->flashdata('success')): ?>
      <div class="alert success"><?= html_escape($this->session->flashdata('success')) ?></div>
    <?php endif; ?>
    <?php if ($this->session->flashdata('error')): ?>
      <div class="alert error"><?= html_escape($this->session->flashdata('error')) ?></div>
    <?php endif; ?>

    <div class="toolbar">
      <form method="get" action="<?= site_url('master_bahan') ?>">
        <input type="text" name="q" placeholder="Cari bahan..." value="<?= html_escape($keyword) ?>">
        <button class="btn" type="submit">Cari</button>
      </form>
      <button class="btn primary" type="button" onclick="bukaForm()">+ Tambah bahan</button>
    </div>

    <table>
      <thead>
        <tr>
          <th>BAHAN</th>
          <th>SATUAN</th>
          <th style="text-align:right">HARGA BELI</th>
          <th style="text-align:right">ISI KEMASAN</th>
          <th style="text-align:right">HARGA / SATUAN</th>
          <th style="text-align:right">AKSI</th>
        </tr>
      </thead>
      <tbody>
      <?php if (empty($bahan)): ?>
        <tr><td colspan="6" class="empty">Belum ada bahan master.</td></tr>
      <?php else: foreach ($bahan as $b): ?>
        <tr>
          <td><strong><?= html_escape($b->nama_bahan) ?></strong></td>
          <td><?= html_escape($b->satuan) ?></td>
          <td class="num">Rp <?= number_format($b->harga_beli_terakhir, 0, ',', '.') ?></td>
          <td class="num"><?= rtrim(rtrim(number_format($b->isi_kemasan_terakhir, 2, ',', '.'), '0'), ',') ?></td>
          <td class="num">Rp <?= number_format($b->harga_beli_terakhir / $b->isi_kemasan_terakhir, 0, ',', '.') ?></td>
          <td class="num">
            <button class="btn" type="button"
              data-id="<?= $b->id_master_bahan ?>"
              data-nama="<?= html_escape($b->nama_bahan) ?>"
              data-satuan="<?= html_escape($b->satuan) ?>"
              data-harga="<?= $b->harga_beli_terakhir ?>"
              data-isi="<?= $b->isi_kemasan_terakhir ?>"
              onclick="bukaForm(this)">Edit</button>

            <?= form_open('master_bahan/hapus', ['style' => 'display:inline', 'onsubmit' => "return confirm('Hapus bahan ini?')"]) ?>
              <input type="hidden" name="id_master_bahan" value="<?= $b->id_master_bahan ?>">
              <button class="btn danger" type="submit">Hapus</button>
            <?= form_close() ?>
          </td>
        </tr>
      <?php endforeach; endif; ?>
      </tbody>
    </table>
  </div>
</div>

<!-- Modal tambah / edit -->
<dialog id="dlg">
  <?= form_open('master_bahan/simpan') ?>
    <h3 id="dlgTitle">Tambah bahan</h3>
    <input type="hidden" name="id_master_bahan" id="f_id">

    <div class="field">
      <label>Nama bahan</label>
      <input type="text" name="nama_bahan" id="f_nama" maxlength="50" required>
    </div>

    <div class="row">
      <div class="field" style="flex:1">
        <label>Satuan</label>
        <select name="satuan" id="f_satuan">
          <option value="gr">Gram (gr)</option>
          <option value="ml">Mililiter (ml)</option>
          <option value="pcs">Pcs</option>
        </select>
      </div>
      <div class="field" style="flex:1">
        <label>Isi kemasan</label>
        <input type="number" name="isi_kemasan_terakhir" id="f_isi" step="0.01" min="0.01" required>
      </div>
    </div>

    <div class="field">
      <label>Harga beli per kemasan (Rp)</label>
      <input type="number" name="harga_beli_terakhir" id="f_harga" step="1" min="1" required>
    </div>

    <div class="actions">
      <button type="button" class="btn" onclick="document.getElementById('dlg').close()">Batal</button>
      <button type="submit" class="btn primary">Simpan</button>
    </div>
  <?= form_close() ?>
</dialog>

<script>
function bukaForm(btn) {
  const d = document.getElementById('dlg');
  document.getElementById('dlgTitle').textContent = btn ? 'Edit bahan' : 'Tambah bahan';
  document.getElementById('f_id').value     = btn ? btn.dataset.id : '';
  document.getElementById('f_nama').value   = btn ? btn.dataset.nama : '';
  document.getElementById('f_satuan').value = btn ? btn.dataset.satuan : 'gr';
  document.getElementById('f_isi').value    = btn ? btn.dataset.isi : '';
  document.getElementById('f_harga').value  = btn ? btn.dataset.harga : '';
  d.showModal();
}
</script>
</body>
</html>