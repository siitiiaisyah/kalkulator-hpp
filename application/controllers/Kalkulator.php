<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kalkulator extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Hpp_model');
        $this->load->model('Master_model');
    }

    /**
     * Halaman Utama Kalkulator HPP
     */
    public function index($load_id = null) {
        $data['tarif_listrik'] = $this->Master_model->get_all_tarif_listrik();
        $data['master_bahan'] = $this->Master_model->get_all_bahan();
        $data['riwayat_terbaru'] = $this->Hpp_model->get_riwayat(10);
        $data['loaded_data'] = null;

        if ($load_id !== null) {
            $data['loaded_data'] = $this->Hpp_model->get_detail_perhitungan($load_id);
        }

        $this->load->view('kalkulator/index', $data);
    }

    /**
     * Endpoint API JSON: Autocomplete saran bahan otomatis
     */
    public function saran_bahan() {
        $keyword = $this->input->get('q', TRUE);
        $results = $this->Master_model->search_bahan($keyword);

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($results));
    }

    /**
     * Endpoint API JSON: Hitung Ulang di Server (Verifikasi Akurasi NFR-05)
     */
    public function hitung() {
        $post = json_decode($this->input->raw_input_stream, TRUE);
        if (!$post) {
            $post = $this->input->post();
        }

        $hasil = $this->Hpp_model->hitung($post);

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(array(
                'success' => true,
                'data' => $hasil
            )));
    }

    /**
     * Endpoint API JSON: Simpan Perhitungan ke Database (FR-09)
     * Melakukan validasi sisi server dan kalkulasi ulang akurat.
     */
    public function simpan() {
        $post = json_decode($this->input->raw_input_stream, TRUE);
        if (!$post) {
            $post = $this->input->post();
        }

        // 1. Validasi Sisi Server
        $errors = $this->Hpp_model->validate_input($post);
        if (!empty($errors)) {
            $this->output
                ->set_status_header(400)
                ->set_content_type('application/json')
                ->set_output(json_encode(array(
                    'success' => false,
                    'message' => 'Validasi gagal: Harap periksa kolom yang ditandai merah.',
                    'errors' => $errors
                )));
            return;
        }

        // 2. Simpan ke Database
        $id_perhitungan = $this->Hpp_model->simpan_perhitungan($post);

        if ($id_perhitungan) {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(array(
                    'success' => true,
                    'id_perhitungan' => $id_perhitungan,
                    'message' => 'Data perhitungan berhasil disimpan ke database!',
                    'redirect_url' => site_url('riwayat/detail/' . $id_perhitungan)
                )));
        } else {
            $this->output
                ->set_status_header(500)
                ->set_content_type('application/json')
                ->set_output(json_encode(array(
                    'success' => false,
                    'message' => 'Gagal menyimpan perhitungan ke database. Terjadi kesalahan transaksi.'
                )));
        }
    }
}
