/**
 * Modul Validasi Sisi Klien (PPSI Komponen 3)
 * Memeriksa input kosong, bukan angka, bernilai negatif, atau pembagi bernilai nol.
 */

const Validator = {
    clearErrors: function() {
        document.querySelectorAll('.is-invalid').forEach(el => {
            el.classList.remove('is-invalid');
        });
        document.querySelectorAll('.invalid-feedback').forEach(el => {
            el.remove();
        });
    },

    setError: function(element, message) {
        if (!element) return;
        element.classList.add('is-invalid');
        
        let feedback = element.parentElement.querySelector('.invalid-feedback');
        if (!feedback) {
            feedback = document.createElement('div');
            feedback.className = 'invalid-feedback';
            element.parentElement.appendChild(feedback);
        }
        feedback.textContent = message;
    },

    validate: function() {
        this.clearErrors();
        let isValid = true;
        let firstInvalid = null;

        // 1. Validasi Nama Produk
        const namaProduk = document.getElementById('nama-produk');
        if (namaProduk && !namaProduk.value.trim()) {
            this.setError(namaProduk, 'Nama produk / resep tidak boleh kosong.');
            isValid = false;
            if (!firstInvalid) firstInvalid = namaProduk;
        }

        // 2. Validasi Jumlah Produk Jadi (N >= 1)
        const jmlProduk = document.getElementById('jumlah-produk');
        if (jmlProduk) {
            const val = parseFloat(jmlProduk.value);
            if (isNaN(val) || val < 1) {
                this.setError(jmlProduk, 'Jumlah produk jadi minimal 1 pcs.');
                isValid = false;
                if (!firstInvalid) firstInvalid = jmlProduk;
            }
        }

        // 3. Validasi Persentase Keuntungan (>= 0)
        const persenLaba = document.getElementById('persen-laba');
        if (persenLaba) {
            const val = parseFloat(persenLaba.value);
            if (isNaN(val) || val < 0) {
                this.setError(persenLaba, 'Persentase keuntungan tidak boleh negatif.');
                isValid = false;
                if (!firstInvalid) firstInvalid = persenLaba;
            }
        }

        // 4. Validasi Gas
        const gasJam = document.getElementById('gas-jam');
        const gasHarga = document.getElementById('gas-harga');
        const gasIsi = document.getElementById('gas-isi');

        if (gasJam && parseFloat(gasJam.value) < 0) {
            this.setError(gasJam, 'Lama pemakaian gas tidak boleh negatif.');
            isValid = false;
            if (!firstInvalid) firstInvalid = gasJam;
        }
        if (gasHarga && parseFloat(gasHarga.value) < 0) {
            this.setError(gasHarga, 'Harga tabung tidak boleh negatif.');
            isValid = false;
            if (!firstInvalid) firstInvalid = gasHarga;
        }
        if (gasJam && parseFloat(gasJam.value) > 0) {
            if (gasIsi && (isNaN(parseFloat(gasIsi.value)) || parseFloat(gasIsi.value) <= 0)) {
                this.setError(gasIsi, 'Isi tabung gas harus lebih dari 0 kg (pembagi tidak boleh nol).');
                isValid = false;
                if (!firstInvalid) firstInvalid = gasIsi;
            }
        }

        // 5. Validasi Baris Bahan Baku
        document.querySelectorAll('#bahan-table tbody tr').forEach((tr, idx) => {
            const id = tr.getAttribute('data-id');
            const nama = tr.querySelector('.bahan-nama');
            const harga = document.getElementById(`bahan-harga-${id}`);
            const isi = document.getElementById(`bahan-isi-${id}`);
            const terpakai = document.getElementById(`bahan-terpakai-${id}`);

            if (nama && harga && isi && terpakai) {
                const hasValue = nama.value.trim() !== '' || parseFloat(harga.value) > 0 || parseFloat(terpakai.value) > 0;
                if (hasValue) {
                    if (!nama.value.trim()) {
                        this.setError(nama, 'Nama bahan wajib diisi.');
                        isValid = false;
                        if (!firstInvalid) firstInvalid = nama;
                    }
                    if (parseFloat(harga.value) < 0) {
                        this.setError(harga, 'Harga beli tidak boleh negatif.');
                        isValid = false;
                        if (!firstInvalid) firstInvalid = harga;
                    }
                    if (isNaN(parseFloat(isi.value)) || parseFloat(isi.value) <= 0) {
                        this.setError(isi, 'Isi kemasan harus > 0.');
                        isValid = false;
                        if (!firstInvalid) firstInvalid = isi;
                    }
                    if (parseFloat(terpakai.value) < 0) {
                        this.setError(terpakai, 'Jumlah pakai tidak boleh negatif.');
                        isValid = false;
                        if (!firstInvalid) firstInvalid = terpakai;
                    }
                }
            }
        });

        // 6. Validasi Listrik
        const listrikTarif = document.getElementById('listrik-tarif');
        if (listrikTarif && parseFloat(listrikTarif.value) < 0) {
            this.setError(listrikTarif, 'Tarif listrik tidak boleh negatif.');
            isValid = false;
            if (!firstInvalid) firstInvalid = listrikTarif;
        }

        // 7. Validasi Operasional Lain
        document.querySelectorAll('#op-table tbody tr').forEach((tr, idx) => {
            const id = tr.getAttribute('data-id');
            const jenis = tr.querySelector('.op-jenis');
            const harga = document.getElementById(`op-harga-${id}`);
            const kapasitas = document.getElementById(`op-kapasitas-${id}`);
            const pakai = document.getElementById(`op-pakai-${id}`);

            if (jenis && harga && kapasitas && pakai) {
                const hasValue = jenis.value.trim() !== '' || parseFloat(harga.value) > 0 || parseFloat(pakai.value) > 0;
                if (hasValue) {
                    if (parseFloat(harga.value) < 0) {
                        this.setError(harga, 'Harga tidak boleh negatif.');
                        isValid = false;
                        if (!firstInvalid) firstInvalid = harga;
                    }
                    if (isNaN(parseFloat(kapasitas.value)) || parseFloat(kapasitas.value) <= 0) {
                        this.setError(kapasitas, 'Kapasitas harus > 0.');
                        isValid = false;
                        if (!firstInvalid) firstInvalid = kapasitas;
                    }
                    if (parseFloat(pakai.value) < 0) {
                        this.setError(pakai, 'Jumlah pakai tidak boleh negatif.');
                        isValid = false;
                        if (!firstInvalid) firstInvalid = pakai;
                    }
                }
            }
        });

        if (!isValid && firstInvalid) {
            firstInvalid.focus();
            if (firstInvalid.scrollIntoView) {
                firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        }

        return isValid;
    }
};
