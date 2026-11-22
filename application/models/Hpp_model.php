<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Hpp_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->model('Master_model');
    }

    /**
     * Modul Validasi Sisi Server (PPSI Komponen 3)
     * Memeriksa input kosong, bukan angka, bernilai negatif, atau pembagi bernilai nol.
     */
    public function validate_input($post) {
        $errors = array();

        // 1. Validasi Nama Produk
        $nama_produk = isset($post['nama_produk']) ? trim($post['nama_produk']) : '';
        if (empty($nama_produk)) {
            $errors['nama_produk'] = 'Nama produk / resep wajib diisi.';
        }

        // 2. Validasi Jumlah Produk Jadi (N >= 1)
        $jumlah_produk = isset($post['jumlah_produk']) ? floatval($post['jumlah_produk']) : 0;
        if ($jumlah_produk <= 0) {
            $errors['jumlah_produk'] = 'Jumlah produk jadi harus berupa angka dan minimal 1 pcs.';
        }

        // 3. Validasi Persentase Keuntungan (>= 0)
        $persen_untung = isset($post['persen_untung']) ? floatval($post['persen_untung']) : 0;
        if ($persen_untung < 0) {
            $errors['persen_untung'] = 'Persentase keuntungan tidak boleh bernilai negatif.';
        }

        // 4. Validasi Gas
        $lama_gas = isset($post['lama_gas_jam']) ? floatval($post['lama_gas_jam']) : 0;
        $harga_gas = isset($post['harga_tabung_gas']) ? floatval($post['harga_tabung_gas']) : 0;
        $isi_gas = isset($post['isi_tabung_kg']) ? floatval($post['isi_tabung_kg']) : 0;

        if ($lama_gas < 0) $errors['lama_gas_jam'] = 'Lama pemakaian gas tidak boleh negatif.';
        if ($harga_gas < 0) $errors['harga_tabung_gas'] = 'Harga tabung gas tidak boleh negatif.';
        if ($lama_gas > 0 && $isi_gas <= 0) {
            $errors['isi_tabung_kg'] = 'Isi tabung gas harus lebih dari 0 kg (pembagi tidak boleh nol).';
        }

        // 5. Validasi Bahan Baku
        if (isset($post['bahan']) && is_array($post['bahan'])) {
            foreach ($post['bahan'] as $idx => $b) {
                $nama = isset($b['nama_bahan']) ? trim($b['nama_bahan']) : '';
                $harga = isset($b['harga_beli']) ? floatval($b['harga_beli']) : 0;
                $isi = isset($b['isi_kemasan']) ? floatval($b['isi_kemasan']) : 0;
                $pakai = isset($b['jumlah_terpakai']) ? floatval($b['jumlah_terpakai']) : 0;

                // Hanya validasi jika salah satu kolom terisi
                if (!empty($nama) || $harga > 0 || $isi > 0 || $pakai > 0) {
                    if (empty($nama)) {
                        $errors["bahan_{$idx}_nama"] = "Nama bahan pada baris ke-" . ($idx + 1) . " wajib diisi.";
                    }
                    if ($harga < 0) {
                        $errors["bahan_{$idx}_harga"] = "Harga beli bahan pada baris ke-" . ($idx + 1) . " tidak boleh negatif.";
                    }
                    if ($isi <= 0) {
                        $errors["bahan_{$idx}_isi"] = "Isi kemasan bahan pada baris ke-" . ($idx + 1) . " harus lebih dari 0.";
                    }
                    if ($pakai < 0) {
                        $errors["bahan_{$idx}_pakai"] = "Jumlah terpakai bahan pada baris ke-" . ($idx + 1) . " tidak boleh negatif.";
                    }
                }
            }
        }

        // 6. Validasi Listrik
        $tarif_listrik = isset($post['tarif_listrik']) ? floatval($post['tarif_listrik']) : 0;
        if ($tarif_listrik < 0) {
            $errors['tarif_listrik'] = 'Tarif listrik tidak boleh bernilai negatif.';
        }
        if (isset($post['listrik']) && is_array($post['listrik'])) {
            foreach ($post['listrik'] as $idx => $l) {
                $nama = isset($l['nama_perangkat']) ? trim($l['nama_perangkat']) : '';
                $daya = isset($l['daya_watt']) ? floatval($l['daya_watt']) : 0;
                $jam = isset($l['jam_pakai']) ? floatval($l['jam_pakai']) : 0;

                if (!empty($nama) || $daya > 0 || $jam > 0) {
                    if ($daya < 0) $errors["listrik_{$idx}_daya"] = "Daya perangkat baris " . ($idx + 1) . " tidak boleh negatif.";
                    if ($jam < 0) $errors["listrik_{$idx}_jam"] = "Jam pakai baris " . ($idx + 1) . " tidak boleh negatif.";
                }
            }
        }

        // 7. Validasi Tenaga Kerja
        if (isset($post['tenaga']) && is_array($post['tenaga'])) {
            foreach ($post['tenaga'] as $idx => $t) {
                $nama = isset($t['nama_pekerja']) ? trim($t['nama_pekerja']) : '';
                $gaji = isset($t['gaji_per_jam']) ? floatval($t['gaji_per_jam']) : 0;
                $jam = isset($t['jam_kerja']) ? floatval($t['jam_kerja']) : 0;

                if (!empty($nama) || $gaji > 0 || $jam > 0) {
                    if ($gaji < 0) $errors["tenaga_{$idx}_gaji"] = "Gaji per jam baris " . ($idx + 1) . " tidak boleh negatif.";
                    if ($jam < 0) $errors["tenaga_{$idx}_jam"] = "Jam kerja baris " . ($idx + 1) . " tidak boleh negatif.";
                }
            }
        }

        // 8. Validasi Biaya Operasional / Kemasan
        if (isset($post['operasional']) && is_array($post['operasional'])) {
            foreach ($post['operasional'] as $idx => $o) {
                $jenis = isset($o['jenis_biaya']) ? trim($o['jenis_biaya']) : '';
                $harga = isset($o['harga']) ? floatval($o['harga']) : 0;
                $kapasitas = isset($o['kapasitas']) ? floatval($o['kapasitas']) : 0;
                $pakai = isset($o['total_pakai']) ? floatval($o['total_pakai']) : 0;

                if (!empty($jenis) || $harga > 0 || $kapasitas > 0 || $pakai > 0) {
                    if ($harga < 0) $errors["op_{$idx}_harga"] = "Harga operasional baris " . ($idx + 1) . " tidak boleh negatif.";
                    if ($kapasitas <= 0) $errors["op_{$idx}_kapasitas"] = "Kapasitas/isi baris " . ($idx + 1) . " harus lebih dari 0.";
                    if ($pakai < 0) $errors["op_{$idx}_pakai"] = "Total pakai baris " . ($idx + 1) . " tidak boleh negatif.";
                }
            }
        }

        return $errors;
    }

    /**
     * Modul Kalkulasi Sisi Server (PPSI Komponen 4 & SDD Bab 6)
     * Menghitung nilai deterministik tanpa pembulatan perantara.
     */
    public function hitung($post) {
        // 1. Bahan Baku
        $total_biaya_bahan = 0.0;
        $bahan_processed = array();

        if (isset($post['bahan']) && is_array($post['bahan'])) {
            foreach ($post['bahan'] as $b) {
                $nama = isset($b['nama_bahan']) ? trim($b['nama_bahan']) : '';
                $satuan = isset($b['satuan']) ? trim($b['satuan']) : 'gr';
                $harga = isset($b['harga_beli']) ? floatval($b['harga_beli']) : 0.0;
                $isi = isset($b['isi_kemasan']) ? floatval($b['isi_kemasan']) : 0.0;
                $pakai = isset($b['jumlah_terpakai']) ? floatval($b['jumlah_terpakai']) : 0.0;

                if (!empty($nama) || $harga > 0 || $pakai > 0) {
                    $biaya_baris = ($isi > 0) ? ($harga / $isi) * $pakai : 0.0;
                    $total_biaya_bahan += $biaya_baris;

                    $bahan_processed[] = array(
                        'id_master_bahan' => isset($b['id_master_bahan']) ? intval($b['id_master_bahan']) : null,
                        'nama_bahan' => !empty($nama) ? $nama : 'Bahan',
                        'satuan' => !empty($satuan) ? $satuan : 'gr',
                        'harga_beli' => $harga,
                        'isi_kemasan' => $isi,
                        'jumlah_terpakai' => $pakai,
                        'biaya' => $biaya_baris
                    );
                }
            }
        }

        // 2. Gas
        $lama_gas = isset($post['lama_gas_jam']) ? floatval($post['lama_gas_jam']) : 0.0;
        $harga_gas = isset($post['harga_tabung_gas']) ? floatval($post['harga_tabung_gas']) : 0.0;
        $isi_gas = isset($post['isi_tabung_kg']) ? floatval($post['isi_tabung_kg']) : 3.0;
        if ($isi_gas <= 0) $isi_gas = 3.0;
        $konsumsi_gas = 0.20; // parameter tetap 0.2 kg/jam

        $biaya_gas = ($isi_gas > 0) ? ($harga_gas / $isi_gas) * $konsumsi_gas * $lama_gas : 0.0;

        // 3. Listrik
        $tarif_listrik = isset($post['tarif_listrik']) ? floatval($post['tarif_listrik']) : 0.0;
        $id_tarif = !empty($post['id_tarif']) ? intval($post['id_tarif']) : null;
        $total_kwh = 0.0;
        $listrik_processed = array();

        if (isset($post['listrik']) && is_array($post['listrik'])) {
            foreach ($post['listrik'] as $l) {
                $nama = isset($l['nama_perangkat']) ? trim($l['nama_perangkat']) : '';
                $daya = isset($l['daya_watt']) ? floatval($l['daya_watt']) : 0.0;
                $jam = isset($l['jam_pakai']) ? floatval($l['jam_pakai']) : 0.0;

                if (!empty($nama) || $daya > 0 || $jam > 0) {
                    $kwh = ($daya * $jam) / 1000.0;
                    $biaya_perangkat = $kwh * $tarif_listrik;
                    $total_kwh += $kwh;

                    $listrik_processed[] = array(
                        'nama_perangkat' => !empty($nama) ? $nama : 'Perangkat',
                        'daya_watt' => $daya,
                        'jam_pakai' => $jam,
                        'kwh' => $kwh,
                        'biaya' => $biaya_perangkat
                    );
                }
            }
        }
        $biaya_listrik = $total_kwh * $tarif_listrik;

        // 4. Tenaga Kerja
        $biaya_tenaga_kerja = 0.0;
        $tenaga_processed = array();

        if (isset($post['tenaga']) && is_array($post['tenaga'])) {
            foreach ($post['tenaga'] as $t) {
                $nama = isset($t['nama_pekerja']) ? trim($t['nama_pekerja']) : '';
                $gaji = isset($t['gaji_per_jam']) ? floatval($t['gaji_per_jam']) : 0.0;
                $jam = isset($t['jam_kerja']) ? floatval($t['jam_kerja']) : 0.0;

                if (!empty($nama) || $gaji > 0 || $jam > 0) {
                    $biaya_worker = $gaji * $jam;
                    $biaya_tenaga_kerja += $biaya_worker;

                    $tenaga_processed[] = array(
                        'nama_pekerja' => !empty($nama) ? $nama : 'Tenaga Kerja',
                        'gaji_per_jam' => $gaji,
                        'jam_kerja' => $jam,
                        'biaya' => $biaya_worker
                    );
                }
            }
        }

        // 5. Biaya Operasional / Kemasan
        $biaya_operasional_lain = 0.0;
        $op_processed = array();

        if (isset($post['operasional']) && is_array($post['operasional'])) {
            foreach ($post['operasional'] as $o) {
                $jenis = isset($o['jenis_biaya']) ? trim($o['jenis_biaya']) : '';
                $harga = isset($o['harga']) ? floatval($o['harga']) : 0.0;
                $kapasitas = isset($o['kapasitas']) ? floatval($o['kapasitas']) : 0.0;
                $pakai = isset($o['total_pakai']) ? floatval($o['total_pakai']) : 0.0;

                if (!empty($jenis) || $harga > 0 || $pakai > 0) {
                    $biaya_op = ($kapasitas > 0) ? ($harga / $kapasitas) * $pakai : 0.0;
                    $biaya_operasional_lain += $biaya_op;

                    $op_processed[] = array(
                        'jenis_biaya' => !empty($jenis) ? $jenis : 'Kemasan/Lain',
                        'harga' => $harga,
                        'kapasitas' => $kapasitas,
                        'total_pakai' => $pakai,
                        'biaya' => $biaya_op
                    );
                }
            }
        }

        // 6. Total Biaya Operasional (TO = BK + BG + BL + BT)
        $total_biaya_operasional = $biaya_operasional_lain + $biaya_gas + $biaya_listrik + $biaya_tenaga_kerja;

        // 7. Total Biaya Produksi (TP = TB + TO)
        $total_biaya_produksi = $total_biaya_bahan + $total_biaya_operasional;

        // 8. HPP per Produk (HPP = TP ÷ N)
        $jumlah_produk = isset($post['jumlah_produk']) ? max(1, intval($post['jumlah_produk'])) : 1;
        $hpp_per_produk = ($jumlah_produk > 0) ? ($total_biaya_produksi / $jumlah_produk) : 0.0;

        // 9. Saran Harga Jual & Keuntungan
        // HJ = HPP × (1 + p ÷ 100)
        $persen_untung = isset($post['persen_untung']) ? floatval($post['persen_untung']) : 50.0;
        $harga_jual_saran = $hpp_per_produk * (1.0 + ($persen_untung / 100.0));
        $laba_per_produk = $harga_jual_saran - $hpp_per_produk;
        $laba_per_resep = $laba_per_produk * $jumlah_produk;

        // 10. Simulasi Harga Khusus
        $harga_jual_simulasi = isset($post['harga_jual_simulasi']) && $post['harga_jual_simulasi'] !== '' ? floatval($post['harga_jual_simulasi']) : null;
        $laba_riil_per_produk = null;
        $laba_riil_per_resep = null;
        if ($harga_jual_simulasi !== null && $harga_jual_simulasi > 0) {
            $laba_riil_per_produk = $harga_jual_simulasi - $hpp_per_produk;
            $laba_riil_per_resep = $laba_riil_per_produk * $jumlah_produk;
        }

        return array(
            'nama_produk' => isset($post['nama_produk']) ? trim($post['nama_produk']) : 'Produk',
            'lama_gas_jam' => $lama_gas,
            'harga_tabung_gas' => $harga_gas,
            'isi_tabung_kg' => $isi_gas,
            'konsumsi_gas_kg_jam' => $konsumsi_gas,
            'id_tarif' => $id_tarif,
            'tarif_listrik' => $tarif_listrik,
            'jumlah_produk' => $jumlah_produk,
            'persen_untung' => $persen_untung,
            'harga_jual_simulasi' => $harga_jual_simulasi,
            'total_biaya_bahan' => round($total_biaya_bahan, 2),
            'biaya_operasional_lain' => round($biaya_operasional_lain, 2),
            'biaya_gas' => round($biaya_gas, 2),
            'biaya_listrik' => round($biaya_listrik, 2),
            'biaya_tenaga_kerja' => round($biaya_tenaga_kerja, 2),
            'total_biaya_operasional' => round($total_biaya_operasional, 2),
            'total_biaya_produksi' => round($total_biaya_produksi, 2),
            'hpp_per_produk' => round($hpp_per_produk, 2),
            'harga_jual_saran' => round($harga_jual_saran, 2),
            'laba_per_produk' => round($laba_per_produk, 2),
            'laba_per_resep' => round($laba_per_resep, 2),
            'laba_riil_per_produk' => ($laba_riil_per_produk !== null) ? round($laba_riil_per_produk, 2) : null,
            'laba_riil_per_resep' => ($laba_riil_per_resep !== null) ? round($laba_riil_per_resep, 2) : null,
            'bahan_processed' => $bahan_processed,
            'listrik_processed' => $listrik_processed,
            'tenaga_processed' => $tenaga_processed,
            'op_processed' => $op_processed
        );
    }

    /**
     * Simpan Perhitungan Lengkap ke Basis Data (MySQL)
     */
    public function simpan_perhitungan($post) {
        $calc = $this->hitung($post);

        $this->db->trans_start();

        // 1. Simpan Header Perhitungan
        $data_perhitungan = array(
            'nama_produk' => $calc['nama_produk'],
            'lama_gas_jam' => $calc['lama_gas_jam'],
            'harga_tabung_gas' => $calc['harga_tabung_gas'],
            'isi_tabung_kg' => $calc['isi_tabung_kg'],
            'konsumsi_gas_kg_jam' => $calc['konsumsi_gas_kg_jam'],
            'id_tarif' => $calc['id_tarif'],
            'tarif_listrik' => $calc['tarif_listrik'],
            'jumlah_produk' => $calc['jumlah_produk'],
            'persen_untung' => $calc['persen_untung'],
            'harga_jual_simulasi' => $calc['harga_jual_simulasi'],
            'total_biaya_bahan' => $calc['total_biaya_bahan'],
            'biaya_operasional_lain' => $calc['biaya_operasional_lain'],
            'biaya_gas' => $calc['biaya_gas'],
            'biaya_listrik' => $calc['biaya_listrik'],
            'biaya_tenaga_kerja' => $calc['biaya_tenaga_kerja'],
            'total_biaya_produksi' => $calc['total_biaya_produksi'],
            'hpp_per_produk' => $calc['hpp_per_produk'],
            'harga_jual_saran' => $calc['harga_jual_saran'],
            'laba_per_produk' => $calc['laba_per_produk'],
            'laba_per_resep' => $calc['laba_per_resep'],
            'laba_riil_per_produk' => $calc['laba_riil_per_produk'],
            'created_at' => date('Y-m-d H:i:s')
        );

        $this->db->insert('perhitungan', $data_perhitungan);
        $id_perhitungan = $this->db->insert_id();

        // 2. Simpan Rincian Bahan Baku & Update Master Bahan Otomatis
        foreach ($calc['bahan_processed'] as $b) {
            // Update atau simpan ke master_bahan
            $id_master = $this->Master_model->upsert_bahan(
                $b['nama_bahan'],
                $b['satuan'],
                $b['harga_beli'],
                $b['isi_kemasan']
            );

            $this->db->insert('bahan_baku', array(
                'id_perhitungan' => $id_perhitungan,
                'id_master_bahan' => $id_master,
                'nama_bahan' => $b['nama_bahan'],
                'satuan' => $b['satuan'],
                'harga_beli' => $b['harga_beli'],
                'isi_kemasan' => $b['isi_kemasan'],
                'jumlah_terpakai' => $b['jumlah_terpakai'],
                'biaya' => $b['biaya']
            ));
        }

        // 3. Simpan Rincian Perangkat Listrik
        foreach ($calc['listrik_processed'] as $l) {
            $this->db->insert('perangkat_listrik', array(
                'id_perhitungan' => $id_perhitungan,
                'nama_perangkat' => $l['nama_perangkat'],
                'daya_watt' => $l['daya_watt'],
                'jam_pakai' => $l['jam_pakai'],
                'kwh' => $l['kwh'],
                'biaya' => $l['biaya']
            ));
        }

        // 4. Simpan Rincian Tenaga Kerja
        foreach ($calc['tenaga_processed'] as $t) {
            $this->db->insert('tenaga_kerja', array(
                'id_perhitungan' => $id_perhitungan,
                'nama_pekerja' => $t['nama_pekerja'],
                'gaji_per_jam' => $t['gaji_per_jam'],
                'jam_kerja' => $t['jam_kerja'],
                'biaya' => $t['biaya']
            ));
        }

        // 5. Simpan Rincian Biaya Operasional / Kemasan
        foreach ($calc['op_processed'] as $o) {
            $this->db->insert('biaya_operasional', array(
                'id_perhitungan' => $id_perhitungan,
                'jenis_biaya' => $o['jenis_biaya'],
                'harga' => $o['harga'],
                'kapasitas' => $o['kapasitas'],
                'total_pakai' => $o['total_pakai'],
                'biaya' => $o['biaya']
            ));
        }

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            return false;
        }

        return $id_perhitungan;
    }

    /**
     * Ambil Daftar Riwayat Perhitungan
     */
    public function get_riwayat($limit = 50, $offset = 0) {
        $this->db->order_by('created_at', 'DESC');
        $this->db->limit($limit, $offset);
        return $this->db->get('perhitungan')->result_array();
    }

    /**
     * Ambil Detail Lengkap 1 Perhitungan beserta relasi
     */
    public function get_detail_perhitungan($id_perhitungan) {
        $p = $this->db->get_where('perhitungan', array('id_perhitungan' => $id_perhitungan))->row_array();
        if (!$p) return null;

        // Ambil relasi
        $p['bahan'] = $this->db->get_where('bahan_baku', array('id_perhitungan' => $id_perhitungan))->result_array();
        $p['listrik'] = $this->db->get_where('perangkat_listrik', array('id_perhitungan' => $id_perhitungan))->result_array();
        $p['tenaga'] = $this->db->get_where('tenaga_kerja', array('id_perhitungan' => $id_perhitungan))->result_array();
        $p['operasional'] = $this->db->get_where('biaya_operasional', array('id_perhitungan' => $id_perhitungan))->result_array();

        if (!empty($p['id_tarif'])) {
            $p['tarif_info'] = $this->db->get_where('tarif_listrik', array('id_tarif' => $p['id_tarif']))->row_array();
        }

        // Aliases untuk kenyamanan view & API
        $p['total_biaya_gas'] = (float)$p['biaya_gas'];
        $p['total_biaya_listrik'] = (float)$p['biaya_listrik'];
        $p['total_biaya_tenaga_kerja'] = (float)$p['biaya_tenaga_kerja'];
        $p['total_biaya_operasional_lain'] = (float)$p['biaya_operasional_lain'];
        $p['total_biaya_operasional'] = $p['total_biaya_gas'] + $p['total_biaya_listrik'] + $p['total_biaya_tenaga_kerja'] + $p['total_biaya_operasional_lain'];
        $p['keuntungan_per_produk'] = (float)$p['laba_per_produk'];
        $p['keuntungan_per_resep'] = (float)$p['laba_per_resep'];
        $p['keuntungan_simulasi_per_produk'] = isset($p['laba_riil_per_produk']) ? (float)$p['laba_riil_per_produk'] : null;
        $p['keuntungan_simulasi_per_resep'] = isset($p['laba_riil_per_produk']) ? ((float)$p['laba_riil_per_produk'] * (int)$p['jumlah_produk']) : null;

        return $p;
    }

    /**
     * Hapus Riwayat Perhitungan
     */
    public function hapus_perhitungan($id_perhitungan) {
        return $this->db->delete('perhitungan', array('id_perhitungan' => $id_perhitungan));
    }
}
