/**
 * Modul Kalkulasi Sisi Klien (PPSI Komponen 2)
 * Menghitung biaya per baris dan total secara langsung setiap kali input berubah tanpa memuat ulang halaman.
 */

// Helper Format Rupiah
const formatRupiah = (number) => {
    if (isNaN(number) || number === null || number === undefined) number = 0;
    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0,
        maximumFractionDigits: 0
    }).format(Math.round(number));
};

// Counter baris dinamis
let bahanCounter = 0;
let listrikCounter = 0;
let laborCounter = 0;
let opCounter = 0;

// Subtotal global state
let totalBahanCost = 0;
let gasCost = 0;
let listrikCost = 0;
let laborCost = 0;
let opCost = 0;
let totalOperasionalCost = 0;
let totalProduksiCost = 0;
let hppPerUnit = 0;

// Master Bahan Cache untuk Autocomplete Cepat
let masterBahanMap = {};

document.addEventListener('DOMContentLoaded', () => {
    // Inisialisasi Master Bahan Cache dari Datalist jika ada
    initMasterBahanMap();

    // Inisialisasi Data jika ada preloaded data dari server
    if (window.PRELOADED_DATA) {
        populateData(window.PRELOADED_DATA);
    } else {
        // Tambahkan baris awal default
        addBahanRow();
        addListrikRow();
        addLaborRow();
        addOpRow();
        calculateGas();
        calculateAll();
    }

    // Listener Nama Produk & Jumlah untuk Struk Tiket
    const namaProdukInput = document.getElementById('nama-produk');
    if (namaProdukInput) {
        namaProdukInput.addEventListener('input', (e) => {
            const val = e.target.value.trim();
            const ticketResep = document.getElementById('ticket-resep');
            if (ticketResep) {
                ticketResep.textContent = val || 'Nama Produk';
            }
            document.title = val ? `HPP - ${val}` : 'Kalkulator HPP Jualan';
        });
    }

    const jmlProdukInput = document.getElementById('jumlah-produk');
    if (jmlProdukInput) {
        jmlProdukInput.addEventListener('input', (e) => {
            const val = parseFloat(e.target.value) || 0;
            const ticketHasil = document.getElementById('ticket-hasil');
            if (ticketHasil) {
                ticketHasil.textContent = `${val} pcs`;
            }
            calculateAll();
        });
    }

    // Listener Accordion
    initAccordions();

    // Listener Simulasi Harga Khusus
    const simulasiToggle = document.getElementById('simulasi-toggle');
    if (simulasiToggle) {
        simulasiToggle.addEventListener('click', () => {
            const body = document.getElementById('simulasi-body');
            const chevron = simulasiToggle.querySelector('.accordion-icon');
            if (body) {
                body.classList.toggle('open');
                if (chevron) {
                    chevron.style.transform = body.classList.contains('open') ? 'rotate(180deg)' : 'rotate(0deg)';
                }
            }
        });
    }

    // Listener Pilihan Tarif Listrik PLN
    const tarifSelect = document.getElementById('select-tarif-pln');
    if (tarifSelect) {
        tarifSelect.addEventListener('change', (e) => {
            const selectedOpt = e.target.selectedOptions[0];
            const tarifVal = selectedOpt ? parseFloat(selectedOpt.getAttribute('data-tarif')) || 0 : 0;
            const tarifInput = document.getElementById('listrik-tarif');
            if (tarifInput) {
                tarifInput.value = tarifVal;
                calculateListrikAll();
            }
        });
    }
});

/**
 * Inisialisasi Accordion Operasional
 */
function initAccordions() {
    document.querySelectorAll('.accordion-header').forEach(header => {
        header.addEventListener('click', () => {
            const item = header.closest('.accordion-item');
            if (item) {
                item.classList.toggle('active');
            }
        });
    });
}

/**
 * Inisialisasi Cache Master Bahan
 */
function initMasterBahanMap() {
    if (window.MASTER_BAHAN_DATA && Array.isArray(window.MASTER_BAHAN_DATA)) {
        window.MASTER_BAHAN_DATA.forEach(b => {
            masterBahanMap[b.nama_bahan.toLowerCase()] = b;
        });
    }
}

/**
 * Handler Autocomplete Bahan Baku
 */
function handleBahanInput(id) {
    const input = document.getElementById(`bahan-nama-${id}`);
    if (!input) return;

    const val = input.value.trim().toLowerCase();
    if (masterBahanMap[val]) {
        const item = masterBahanMap[val];
        const satuanSelect = document.getElementById(`bahan-satuan-${id}`);
        const hargaInput = document.getElementById(`bahan-harga-${id}`);
        const isiInput = document.getElementById(`bahan-isi-${id}`);

        if (satuanSelect && item.satuan) satuanSelect.value = item.satuan;
        if (hargaInput && item.harga_beli_terakhir) hargaInput.value = parseFloat(item.harga_beli_terakhir);
        if (isiInput && item.isi_kemasan_terakhir) isiInput.value = parseFloat(item.isi_kemasan_terakhir);

        calculateBahanRow(id);
    }
}

/**
 * --- 1. BAHAN BAKU ---
 */
function addBahanRow(data = null) {
    bahanCounter++;
    const tbody = document.querySelector('#bahan-table tbody');
    if (!tbody) return;

    const tr = document.createElement('tr');
    tr.id = `bahan-row-${bahanCounter}`;
    tr.setAttribute('data-id', bahanCounter);

    const nama = data ? data.nama_bahan : '';
    const harga = data ? data.harga_beli : '';
    const satuan = data ? data.satuan : 'gr';
    const isi = data ? data.isi_kemasan : '';
    const terpakai = data ? data.jumlah_terpakai : '';

    tr.innerHTML = `
        <td class="row-num text-center"></td>
        <td>
            <input type="text" id="bahan-nama-${bahanCounter}" class="table-input bahan-nama" placeholder="Contoh: Tepung Terigu" list="master-bahan-list" value="${nama}" oninput="handleBahanInput(${bahanCounter})">
        </td>
        <td>
            <input type="number" id="bahan-harga-${bahanCounter}" class="table-input" placeholder="0" min="0" value="${harga}" oninput="calculateBahanRow(${bahanCounter})">
        </td>
        <td>
            <select id="bahan-satuan-${bahanCounter}" class="table-input select-custom" onchange="calculateBahanRow(${bahanCounter})">
                <option value="gr" ${satuan === 'gr' ? 'selected' : ''}>Gram (gr)</option>
                <option value="kg" ${satuan === 'kg' ? 'selected' : ''}>Kilogram (kg)</option>
                <option value="ml" ${satuan === 'ml' ? 'selected' : ''}>Mililiter (ml)</option>
                <option value="l" ${satuan === 'l' ? 'selected' : ''}>Liter (L)</option>
                <option value="pcs" ${satuan === 'pcs' ? 'selected' : ''}>Pcs/Butir</option>
            </select>
        </td>
        <td>
            <input type="number" id="bahan-isi-${bahanCounter}" class="table-input" placeholder="1000" min="0.01" step="any" value="${isi}" oninput="calculateBahanRow(${bahanCounter})">
        </td>
        <td>
            <input type="number" id="bahan-terpakai-${bahanCounter}" class="table-input" placeholder="0" min="0" step="any" value="${terpakai}" oninput="calculateBahanRow(${bahanCounter})">
        </td>
        <td>
            <span id="bahan-biaya-${bahanCounter}" class="readonly-cost" data-value="0">Rp 0</span>
        </td>
        <td class="text-center">
            <button type="button" class="btn-remove-row" onclick="removeBahanRow(${bahanCounter})" title="Hapus baris">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
            </button>
        </td>
    `;

    tbody.appendChild(tr);
    updateRowNumbers('bahan-table');
    calculateBahanRow(bahanCounter);
}

function removeBahanRow(id) {
    const row = document.getElementById(`bahan-row-${id}`);
    if (row) {
        row.remove();
        updateRowNumbers('bahan-table');
        calculateAll();
    }
}

function calculateBahanRow(id) {
    const harga = parseFloat(document.getElementById(`bahan-harga-${id}`)?.value) || 0;
    const isi = parseFloat(document.getElementById(`bahan-isi-${id}`)?.value) || 0;
    const terpakai = parseFloat(document.getElementById(`bahan-terpakai-${id}`)?.value) || 0;

    let biaya = 0;
    if (isi > 0) {
        biaya = (harga / isi) * terpakai;
    }

    const span = document.getElementById(`bahan-biaya-${id}`);
    if (span) {
        span.textContent = formatRupiah(biaya);
        span.setAttribute('data-value', biaya);
    }

    calculateAll();
}

/**
 * --- 2. BIAYA OPERASIONAL: GAS ---
 * Rumus: BG = (H_g / I_g) * 0.2 * T_g
 */
function calculateGas() {
    const jam = parseFloat(document.getElementById('gas-jam')?.value) || 0;
    const harga = parseFloat(document.getElementById('gas-harga')?.value) || 0;
    const isi = parseFloat(document.getElementById('gas-isi')?.value) || 0;

    let biaya = 0;
    if (isi > 0) {
        biaya = (harga / isi) * 0.20 * jam;
    }

    gasCost = biaya;

    const gasText = document.getElementById('gas-cost-text');
    if (gasText) gasText.textContent = formatRupiah(biaya);

    const gasBadge = document.getElementById('gas-badge-cost');
    if (gasBadge) gasBadge.textContent = formatRupiah(biaya);

    calculateAll();
}

/**
 * --- 3. BIAYA OPERASIONAL: LISTRIK ---
 * Rumus: kWh = (Watt * jam) / 1000; Biaya = kWh * Tarif
 */
function addListrikRow(data = null) {
    listrikCounter++;
    const tbody = document.querySelector('#listrik-table tbody');
    if (!tbody) return;

    const tr = document.createElement('tr');
    tr.id = `listrik-row-${listrikCounter}`;
    tr.setAttribute('data-id', listrikCounter);

    const nama = data ? data.nama_perangkat : '';
    const daya = data ? data.daya_watt : '';
    const jam = data ? data.jam_pakai : '';

    tr.innerHTML = `
        <td class="row-num text-center"></td>
        <td>
            <input type="text" id="listrik-nama-${listrikCounter}" class="table-input" placeholder="Contoh: Oven / Mixer" value="${nama}">
        </td>
        <td>
            <input type="number" id="listrik-daya-${listrikCounter}" class="table-input" placeholder="350" min="0" value="${daya}" oninput="calculateListrikRow(${listrikCounter})">
        </td>
        <td>
            <input type="number" id="listrik-jam-${listrikCounter}" class="table-input" placeholder="1" min="0" step="any" value="${jam}" oninput="calculateListrikRow(${listrikCounter})">
        </td>
        <td>
            <span id="listrik-kwh-${listrikCounter}" class="mono-text" style="font-size: 12px; color: var(--muted-text);">0.000</span>
        </td>
        <td>
            <span id="listrik-biaya-${listrikCounter}" class="readonly-cost" data-value="0">Rp 0</span>
        </td>
        <td class="text-center">
            <button type="button" class="btn-remove-row" onclick="removeListrikRow(${listrikCounter})" title="Hapus baris">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
            </button>
        </td>
    `;

    tbody.appendChild(tr);
    updateRowNumbers('listrik-table');
    calculateListrikRow(listrikCounter);
}

function removeListrikRow(id) {
    const row = document.getElementById(`listrik-row-${id}`);
    if (row) {
        row.remove();
        updateRowNumbers('listrik-table');
        calculateListrikAll();
    }
}

function calculateListrikRow(id) {
    const daya = parseFloat(document.getElementById(`listrik-daya-${id}`)?.value) || 0;
    const jam = parseFloat(document.getElementById(`listrik-jam-${id}`)?.value) || 0;
    const tarif = parseFloat(document.getElementById('listrik-tarif')?.value) || 0;

    const kwh = (daya * jam) / 1000.0;
    const biaya = kwh * tarif;

    const kwhSpan = document.getElementById(`listrik-kwh-${id}`);
    if (kwhSpan) kwhSpan.textContent = kwh.toFixed(3);

    const span = document.getElementById(`listrik-biaya-${id}`);
    if (span) {
        span.textContent = formatRupiah(biaya);
        span.setAttribute('data-value', biaya);
    }

    calculateListrikAll();
}

function calculateListrikAll() {
    const tarif = parseFloat(document.getElementById('listrik-tarif')?.value) || 0;

    let totalBiaya = 0;
    document.querySelectorAll('#listrik-table tbody tr').forEach(tr => {
        const id = tr.getAttribute('data-id');
        const daya = parseFloat(document.getElementById(`listrik-daya-${id}`)?.value) || 0;
        const jam = parseFloat(document.getElementById(`listrik-jam-${id}`)?.value) || 0;
        const kwh = (daya * jam) / 1000.0;
        const biaya = kwh * tarif;

        const kwhSpan = document.getElementById(`listrik-kwh-${id}`);
        if (kwhSpan) kwhSpan.textContent = kwh.toFixed(3);

        const span = document.getElementById(`listrik-biaya-${id}`);
        if (span) {
            span.textContent = formatRupiah(biaya);
            span.setAttribute('data-value', biaya);
        }

        totalBiaya += biaya;
    });

    listrikCost = totalBiaya;

    const text = document.getElementById('total-listrik-text');
    if (text) text.textContent = formatRupiah(listrikCost);

    const badge = document.getElementById('listrik-badge-cost');
    if (badge) badge.textContent = formatRupiah(listrikCost);

    calculateAll();
}

/**
 * --- 4. BIAYA OPERASIONAL: TENAGA KERJA ---
 * Rumus: Biaya = Gaji per jam * Jam kerja
 */
function addLaborRow(data = null) {
    laborCounter++;
    const tbody = document.querySelector('#labor-table tbody');
    if (!tbody) return;

    const tr = document.createElement('tr');
    tr.id = `labor-row-${laborCounter}`;
    tr.setAttribute('data-id', laborCounter);

    const nama = data ? data.nama_pekerja : '';
    const gaji = data ? data.gaji_per_jam : '';
    const jam = data ? data.jam_kerja : '';

    tr.innerHTML = `
        <td class="row-num text-center"></td>
        <td>
            <input type="text" id="labor-nama-${laborCounter}" class="table-input" placeholder="Contoh: Siti / Budi" value="${nama}">
        </td>
        <td>
            <input type="number" id="labor-gaji-${laborCounter}" class="table-input" placeholder="20000" min="0" value="${gaji}" oninput="calculateLaborRow(${laborCounter})">
        </td>
        <td>
            <input type="number" id="labor-jam-${laborCounter}" class="table-input" placeholder="1.5" min="0" step="any" value="${jam}" oninput="calculateLaborRow(${laborCounter})">
        </td>
        <td>
            <span id="labor-biaya-${laborCounter}" class="readonly-cost" data-value="0">Rp 0</span>
        </td>
        <td class="text-center">
            <button type="button" class="btn-remove-row" onclick="removeLaborRow(${laborCounter})" title="Hapus baris">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
            </button>
        </td>
    `;

    tbody.appendChild(tr);
    updateRowNumbers('labor-table');
    calculateLaborRow(laborCounter);
}

function removeLaborRow(id) {
    const row = document.getElementById(`labor-row-${id}`);
    if (row) {
        row.remove();
        updateRowNumbers('labor-table');
        calculateLaborAll();
    }
}

function calculateLaborRow(id) {
    const gaji = parseFloat(document.getElementById(`labor-gaji-${id}`)?.value) || 0;
    const jam = parseFloat(document.getElementById(`labor-jam-${id}`)?.value) || 0;
    const biaya = gaji * jam;

    const span = document.getElementById(`labor-biaya-${id}`);
    if (span) {
        span.textContent = formatRupiah(biaya);
        span.setAttribute('data-value', biaya);
    }

    calculateLaborAll();
}

function calculateLaborAll() {
    let total = 0;
    document.querySelectorAll('[id^="labor-biaya-"]').forEach(span => {
        total += parseFloat(span.getAttribute('data-value')) || 0;
    });

    laborCost = total;

    const text = document.getElementById('total-labor-text');
    if (text) text.textContent = formatRupiah(laborCost);

    const badge = document.getElementById('labor-badge-cost');
    if (badge) badge.textContent = formatRupiah(laborCost);

    calculateAll();
}

/**
 * --- 5. BIAYA OPERASIONAL: KEMASAN / LAIN ---
 * Rumus: Biaya = (Harga / Kapasitas) * Total pakai
 */
function addOpRow(data = null) {
    opCounter++;
    const tbody = document.querySelector('#op-table tbody');
    if (!tbody) return;

    const tr = document.createElement('tr');
    tr.id = `op-row-${opCounter}`;
    tr.setAttribute('data-id', opCounter);

    const jenis = data ? data.jenis_biaya : '';
    const harga = data ? data.harga : '';
    const kapasitas = data ? data.kapasitas : '1';
    const pakai = data ? data.total_pakai : '1';

    tr.innerHTML = `
        <td class="row-num text-center"></td>
        <td>
            <input type="text" id="op-jenis-${opCounter}" class="table-input op-jenis" placeholder="Contoh: Toples / Stiker / Plastik" value="${jenis}">
        </td>
        <td>
            <input type="number" id="op-harga-${opCounter}" class="table-input" placeholder="0" min="0" value="${harga}" oninput="calculateOpRow(${opCounter})">
        </td>
        <td>
            <input type="number" id="op-kapasitas-${opCounter}" class="table-input" placeholder="1" min="0.01" step="any" value="${kapasitas}" oninput="calculateOpRow(${opCounter})">
        </td>
        <td>
            <input type="number" id="op-pakai-${opCounter}" class="table-input" placeholder="1" min="0" step="any" value="${pakai}" oninput="calculateOpRow(${opCounter})">
        </td>
        <td>
            <span id="op-biaya-${opCounter}" class="readonly-cost" data-value="0">Rp 0</span>
        </td>
        <td class="text-center">
            <button type="button" class="btn-remove-row" onclick="removeOpRow(${opCounter})" title="Hapus baris">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
            </button>
        </td>
    `;

    tbody.appendChild(tr);
    updateRowNumbers('op-table');
    calculateOpRow(opCounter);
}

function removeOpRow(id) {
    const row = document.getElementById(`op-row-${id}`);
    if (row) {
        row.remove();
        updateRowNumbers('op-table');
        calculateOpAll();
    }
}

function calculateOpRow(id) {
    const harga = parseFloat(document.getElementById(`op-harga-${id}`)?.value) || 0;
    const kapasitas = parseFloat(document.getElementById(`op-kapasitas-${id}`)?.value) || 0;
    const pakai = parseFloat(document.getElementById(`op-pakai-${id}`)?.value) || 0;

    let biaya = 0;
    if (kapasitas > 0) {
        biaya = (harga / kapasitas) * pakai;
    }

    const span = document.getElementById(`op-biaya-${id}`);
    if (span) {
        span.textContent = formatRupiah(biaya);
        span.setAttribute('data-value', biaya);
    }

    calculateOpAll();
}

function calculateOpAll() {
    let total = 0;
    document.querySelectorAll('[id^="op-biaya-"]').forEach(span => {
        total += parseFloat(span.getAttribute('data-value')) || 0;
    });

    opCost = total;

    const text = document.getElementById('total-op-text');
    if (text) text.textContent = formatRupiah(opCost);

    const badge = document.getElementById('op-badge-cost');
    if (badge) badge.textContent = formatRupiah(opCost);

    calculateAll();
}

/**
 * Update Nomor Baris Tabel
 */
function updateRowNumbers(tableId) {
    const rows = document.querySelectorAll(`#${tableId} tbody tr`);
    rows.forEach((row, index) => {
        const numCell = row.querySelector('.row-num');
        if (numCell) numCell.textContent = index + 1;
    });
}

/**
 * --- KALKULASI UTAMA (SDD Bab 6) ---
 */
function calculateAll() {
    // 1. Total Bahan Baku
    let totalBahan = 0;
    document.querySelectorAll('[id^="bahan-biaya-"]').forEach(span => {
        totalBahan += parseFloat(span.getAttribute('data-value')) || 0;
    });
    totalBahanCost = totalBahan;

    const bahanText = document.getElementById('total-bahan-text');
    if (bahanText) bahanText.textContent = formatRupiah(totalBahan);

    const bahanSubtotal = document.getElementById('bahan-action-total');
    if (bahanSubtotal) bahanSubtotal.textContent = formatRupiah(totalBahan);

    // 2. Total Biaya Operasional (TO = BK + BG + BL + BT)
    totalOperasionalCost = opCost + gasCost + listrikCost + laborCost;

    const opTotalText = document.getElementById('total-biaya-operasional-text');
    if (opTotalText) opTotalText.textContent = formatRupiah(totalOperasionalCost);

    // 3. Total Biaya Produksi (HPP Resep: TP = TB + TO)
    totalProduksiCost = totalBahanCost + totalOperasionalCost;

    const recipeCostText = document.getElementById('recipe-total-cost-text');
    if (recipeCostText) recipeCostText.textContent = formatRupiah(totalProduksiCost);

    // 4. HPP per Produk (HPP = TP / N)
    const jmlProduk = parseFloat(document.getElementById('jumlah-produk')?.value) || 1;
    hppPerUnit = (jmlProduk > 0) ? (totalProduksiCost / jmlProduk) : 0;

    const hppGiant = document.getElementById('giant-hpp-per-pcs');
    if (hppGiant) hppGiant.textContent = formatRupiah(hppPerUnit);

    // 5. Proporsi Biaya (Proportion Bar)
    let pctBahan = 50;
    let pctOp = 50;
    if (totalProduksiCost > 0) {
        pctBahan = (totalBahanCost / totalProduksiCost) * 100;
        pctOp = (totalOperasionalCost / totalProduksiCost) * 100;
    }

    const barBahan = document.getElementById('bar-bahan');
    if (barBahan) barBahan.style.width = `${pctBahan}%`;

    const barOp = document.getElementById('bar-op');
    if (barOp) barOp.style.width = `${pctOp}%`;

    const labelBahan = document.getElementById('label-share-bahan');
    if (labelBahan) labelBahan.textContent = `Bahan ${pctBahan.toFixed(1)}%`;

    const labelOp = document.getElementById('label-share-op');
    if (labelOp) labelOp.textContent = `Operasional ${pctOp.toFixed(1)}%`;

    // 6. Saran Harga Jual: HJ = HPP * (1 + p / 100)
    const persenLaba = parseFloat(document.getElementById('persen-laba')?.value) || 0;
    const labaPerUnit = hppPerUnit * (persenLaba / 100.0);
    const saranHarga = hppPerUnit + labaPerUnit;
    const labaResep = labaPerUnit * jmlProduk;

    const saranHargaText = document.getElementById('saran-harga-text');
    if (saranHargaText) saranHargaText.textContent = formatRupiah(saranHarga);

    const labaUnitText = document.getElementById('laba-unit-text');
    if (labaUnitText) labaUnitText.textContent = formatRupiah(labaPerUnit);

    const labaResepText = document.getElementById('laba-resep-text');
    if (labaResepText) labaResepText.textContent = formatRupiah(labaResep);

    // 7. Simulasi Harga Khusus
    const hargaManualInput = document.getElementById('harga-jual-manual');
    const hargaManual = hargaManualInput ? parseFloat(hargaManualInput.value) || 0 : 0;

    const labaRiilUnitText = document.getElementById('laba-riil-unit-text');
    const labaRiilResepText = document.getElementById('laba-riil-resep-text');

    if (hargaManual > 0) {
        const labaRiilUnit = hargaManual - hppPerUnit;
        const labaRiilResep = labaRiilUnit * jmlProduk;

        if (labaRiilUnitText) {
            labaRiilUnitText.textContent = formatRupiah(labaRiilUnit);
            labaRiilUnitText.style.color = labaRiilUnit >= 0 ? 'var(--success)' : 'var(--danger)';
        }
        if (labaRiilResepText) {
            labaRiilResepText.textContent = formatRupiah(labaRiilResep);
            labaRiilResepText.style.color = labaRiilResep >= 0 ? 'var(--success)' : 'var(--danger)';
        }
    } else {
        if (labaRiilUnitText) {
            labaRiilUnitText.textContent = 'Rp 0';
            labaRiilUnitText.style.color = 'var(--dark-text)';
        }
        if (labaRiilResepText) {
            labaRiilResepText.textContent = 'Rp 0';
            labaRiilResepText.style.color = 'var(--dark-text)';
        }
    }
}

/**
 * --- SIMPAN DATA KE SERVER (AJAX FETCH) ---
 */
function simpanData() {
    if (!Validator.validate()) {
        showToast('Validasi Gagal: Silakan lengkapi kolom yang masih bermasalah.', 'danger');
        return;
    }

    const saveBtn = document.getElementById('btn-simpan-master');
    if (saveBtn) {
        saveBtn.disabled = true;
        saveBtn.innerHTML = 'Menyimpan...';
    }

    // Kumpulkan Data Form
    const payload = {
        nama_produk: document.getElementById('nama-produk')?.value.trim() || '',
        jumlah_produk: parseFloat(document.getElementById('jumlah-produk')?.value) || 1,
        persen_untung: parseFloat(document.getElementById('persen-laba')?.value) || 0,
        harga_jual_simulasi: document.getElementById('harga-jual-manual')?.value || null,

        // Gas
        lama_gas_jam: parseFloat(document.getElementById('gas-jam')?.value) || 0,
        harga_tabung_gas: parseFloat(document.getElementById('gas-harga')?.value) || 0,
        isi_tabung_kg: parseFloat(document.getElementById('gas-isi')?.value) || 3,

        // Listrik
        id_tarif: document.getElementById('select-tarif-pln')?.value || null,
        tarif_listrik: parseFloat(document.getElementById('listrik-tarif')?.value) || 0,

        // Bahan Baku
        bahan: [],
        listrik: [],
        tenaga: [],
        operasional: []
    };

    // Parse Bahan Baku
    document.querySelectorAll('#bahan-table tbody tr').forEach(tr => {
        const id = tr.getAttribute('data-id');
        const nama = document.getElementById(`bahan-nama-${id}`)?.value.trim() || '';
        const harga = parseFloat(document.getElementById(`bahan-harga-${id}`)?.value) || 0;
        const satuan = document.getElementById(`bahan-satuan-${id}`)?.value || 'gr';
        const isi = parseFloat(document.getElementById(`bahan-isi-${id}`)?.value) || 0;
        const pakai = parseFloat(document.getElementById(`bahan-terpakai-${id}`)?.value) || 0;

        if (nama || harga > 0 || pakai > 0) {
            payload.bahan.push({
                nama_bahan: nama,
                harga_beli: harga,
                satuan: satuan,
                isi_kemasan: isi,
                jumlah_terpakai: pakai
            });
        }
    });

    // Parse Listrik
    document.querySelectorAll('#listrik-table tbody tr').forEach(tr => {
        const id = tr.getAttribute('data-id');
        const nama = document.getElementById(`listrik-nama-${id}`)?.value.trim() || '';
        const daya = parseFloat(document.getElementById(`listrik-daya-${id}`)?.value) || 0;
        const jam = parseFloat(document.getElementById(`listrik-jam-${id}`)?.value) || 0;

        if (nama || daya > 0 || jam > 0) {
            payload.listrik.push({
                nama_perangkat: nama,
                daya_watt: daya,
                jam_pakai: jam
            });
        }
    });

    // Parse Tenaga Kerja
    document.querySelectorAll('#labor-table tbody tr').forEach(tr => {
        const id = tr.getAttribute('data-id');
        const nama = document.getElementById(`labor-nama-${id}`)?.value.trim() || '';
        const gaji = parseFloat(document.getElementById(`labor-gaji-${id}`)?.value) || 0;
        const jam = parseFloat(document.getElementById(`labor-jam-${id}`)?.value) || 0;

        if (nama || gaji > 0 || jam > 0) {
            payload.tenaga.push({
                nama_pekerja: nama,
                gaji_per_jam: gaji,
                jam_kerja: jam
            });
        }
    });

    // Parse Operasional / Kemasan
    document.querySelectorAll('#op-table tbody tr').forEach(tr => {
        const id = tr.getAttribute('data-id');
        const jenis = document.getElementById(`op-jenis-${id}`)?.value.trim() || '';
        const harga = parseFloat(document.getElementById(`op-harga-${id}`)?.value) || 0;
        const kapasitas = parseFloat(document.getElementById(`op-kapasitas-${id}`)?.value) || 0;
        const pakai = parseFloat(document.getElementById(`op-pakai-${id}`)?.value) || 0;

        if (jenis || harga > 0 || pakai > 0) {
            payload.operasional.push({
                jenis_biaya: jenis,
                harga: harga,
                kapasitas: kapasitas,
                total_pakai: pakai
            });
        }
    });

    // Kirim AJAX POST
    fetch(window.BASE_URL + 'kalkulator/simpan', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify(payload)
    })
    .then(res => res.json())
    .then(data => {
        if (saveBtn) {
            saveBtn.disabled = false;
            saveBtn.innerHTML = `
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>
                Simpan
            `;
        }

        if (data.success) {
            showToast(data.message || 'Data berhasil disimpan!', 'success');
            setTimeout(() => {
                window.location.href = data.redirect_url || (window.BASE_URL + 'riwayat');
            }, 1200);
        } else {
            showToast(data.message || 'Terjadi kesalahan saat menyimpan.', 'danger');
            if (data.errors) {
                console.error('Server validation errors:', data.errors);
            }
        }
    })
    .catch(err => {
        if (saveBtn) {
            saveBtn.disabled = false;
            saveBtn.innerHTML = 'Simpan';
        }
        showToast('Koneksi gagal atau terjadi error server.', 'danger');
        console.error(err);
    });
}

/**
 * Tampilkan Toast Notification
 */
function showToast(message, type = 'info') {
    let container = document.getElementById('toast-container');
    if (!container) {
        container = document.createElement('div');
        container.id = 'toast-container';
        container.className = 'toast-container';
        document.body.appendChild(container);
    }

    const toast = document.createElement('div');
    toast.className = `custom-toast toast-${type}`;
    toast.innerHTML = `
        <span>${message}</span>
    `;

    container.appendChild(toast);

    setTimeout(() => {
        toast.style.opacity = '0';
        toast.style.transform = 'translateY(10px)';
        toast.style.transition = 'all 0.3s ease';
        setTimeout(() => toast.remove(), 300);
    }, 4000);
}

/**
 * Mengisi Data jika Me-load Riwayat Sebelumnya
 */
function populateData(data) {
    if (!data) return;

    if (data.nama_produk) {
        const np = document.getElementById('nama-produk');
        if (np) np.value = data.nama_produk;
        const tr = document.getElementById('ticket-resep');
        if (tr) tr.textContent = data.nama_produk;
    }

    if (data.jumlah_produk) {
        const jp = document.getElementById('jumlah-produk');
        if (jp) jp.value = data.jumlah_produk;
        const th = document.getElementById('ticket-hasil');
        if (th) th.textContent = `${data.jumlah_produk} pcs`;
    }

    if (data.persen_untung !== undefined) {
        const pu = document.getElementById('persen-laba');
        if (pu) pu.value = data.persen_untung;
    }

    if (data.harga_jual_simulasi) {
        const hm = document.getElementById('harga-jual-manual');
        if (hm) hm.value = data.harga_jual_simulasi;
        const body = document.getElementById('simulasi-body');
        if (body) body.classList.add('open');
    }

    // Gas
    if (data.lama_gas_jam !== undefined) document.getElementById('gas-jam').value = data.lama_gas_jam;
    if (data.harga_tabung_gas !== undefined) document.getElementById('gas-harga').value = data.harga_tabung_gas;
    if (data.isi_tabung_kg !== undefined) document.getElementById('gas-isi').value = data.isi_tabung_kg;

    // Listrik
    if (data.id_tarif) document.getElementById('select-tarif-pln').value = data.id_tarif;
    if (data.tarif_listrik !== undefined) document.getElementById('listrik-tarif').value = data.tarif_listrik;

    // Bahan Baku
    const tbodyBahan = document.querySelector('#bahan-table tbody');
    if (tbodyBahan) tbodyBahan.innerHTML = '';
    if (data.bahan && data.bahan.length > 0) {
        data.bahan.forEach(b => addBahanRow(b));
    } else {
        addBahanRow();
    }

    // Listrik
    const tbodyListrik = document.querySelector('#listrik-table tbody');
    if (tbodyListrik) tbodyListrik.innerHTML = '';
    if (data.listrik && data.listrik.length > 0) {
        data.listrik.forEach(l => addListrikRow(l));
    } else {
        addListrikRow();
    }

    // Tenaga Kerja
    const tbodyLabor = document.querySelector('#labor-table tbody');
    if (tbodyLabor) tbodyLabor.innerHTML = '';
    if (data.tenaga && data.tenaga.length > 0) {
        data.tenaga.forEach(t => addLaborRow(t));
    } else {
        addLaborRow();
    }

    // Operasional
    const tbodyOp = document.querySelector('#op-table tbody');
    if (tbodyOp) tbodyOp.innerHTML = '';
    if (data.operasional && data.operasional.length > 0) {
        data.operasional.forEach(o => addOpRow(o));
    } else {
        addOpRow();
    }

    calculateGas();
    calculateListrikAll();
    calculateLaborAll();
    calculateOpAll();
    calculateAll();
}
