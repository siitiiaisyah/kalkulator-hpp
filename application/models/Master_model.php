<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Master_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Ambil semua data master bahan
     */
    public function get_all_bahan() {
        return $this->db->order_by('nama_bahan', 'ASC')->get('master_bahan')->result_array();
    }

    /**
     * Cari bahan untuk autocomplete saran bahan otomatis (JSON)
     */
    public function search_bahan($keyword = '') {
        $this->db->select('id_master_bahan, nama_bahan, satuan, harga_beli_terakhir, isi_kemasan_terakhir');
        if (!empty($keyword)) {
            $this->db->like('nama_bahan', $keyword);
        }
        $this->db->order_by('nama_bahan', 'ASC');
        $this->db->limit(20);
        return $this->db->get('master_bahan')->result_array();
    }

    /**
     * Simpan bahan baru atau perbarui harga beli & isi kemasan terakhir
     */
    public function upsert_bahan($nama_bahan, $satuan, $harga_beli, $isi_kemasan) {
        $nama_bahan = trim($nama_bahan);
        if (empty($nama_bahan)) return null;

        $existing = $this->db->get_where('master_bahan', array('nama_bahan' => $nama_bahan))->row_array();

        if ($existing) {
            $this->db->where('id_master_bahan', $existing['id_master_bahan']);
            $this->db->update('master_bahan', array(
                'satuan' => $satuan,
                'harga_beli_terakhir' => $harga_beli,
                'isi_kemasan_terakhir' => $isi_kemasan,
                'updated_at' => date('Y-m-d H:i:s')
            ));
            return $existing['id_master_bahan'];
        } else {
            $this->db->insert('master_bahan', array(
                'nama_bahan' => $nama_bahan,
                'satuan' => $satuan,
                'harga_beli_terakhir' => $harga_beli,
                'isi_kemasan_terakhir' => $isi_kemasan,
                'updated_at' => date('Y-m-d H:i:s')
            ));
            return $this->db->insert_id();
        }
    }

    /**
     * Ambil semua golongan tarif listrik PLN
     */
    public function get_all_tarif_listrik() {
        return $this->db->where('status_aktif', 1)->order_by('id_tarif', 'ASC')->get('tarif_listrik')->result_array();
    }

    /**
     * Ambil tarif listrik berdasarkan ID
     */
    public function get_tarif_by_id($id_tarif) {
        return $this->db->get_where('tarif_listrik', array('id_tarif' => $id_tarif))->row_array();
    }
}
