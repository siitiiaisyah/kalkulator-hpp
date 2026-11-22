<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Riwayat extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Hpp_model');
        $this->load->model('Master_model');
    }

    /**
     * Halaman Daftar Riwayat Perhitungan (UI-04)
     */
    public function index() {
        $data['riwayat'] = $this->Hpp_model->get_riwayat(100);
        $this->load->view('riwayat/index', $data);
    }

    /**
     * Halaman Detail Riwayat Perhitungan
     */
    public function detail($id = null) {
        if (!$id) {
            redirect('riwayat');
            return;
        }

        $detail = $this->Hpp_model->get_detail_perhitungan($id);
        if (!$detail) {
            show_404();
            return;
        }

        // Jika request via AJAX / JSON
        if ($this->input->is_ajax_request() || $this->input->get('format') === 'json') {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(array('success' => true, 'data' => $detail)));
            return;
        }

        $data['detail'] = $detail;
        $this->load->view('riwayat/detail', $data);
    }

    /**
     * Halaman Cetak / Dokumen PDF (window.print() / Browser PDF)
     */
    public function cetak($id = null) {
        if (!$id) {
            redirect('riwayat');
            return;
        }

        $detail = $this->Hpp_model->get_detail_perhitungan($id);
        if (!$detail) {
            show_404();
            return;
        }

        $data['detail'] = $detail;
        $this->load->view('riwayat/cetak', $data);
    }

    /**
     * Hapus Riwayat Perhitungan
     */
    public function hapus($id = null) {
        if (!$id) {
            redirect('riwayat');
            return;
        }

        $deleted = $this->Hpp_model->hapus_perhitungan($id);

        if ($this->input->is_ajax_request()) {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(array(
                    'success' => $deleted ? true : false,
                    'message' => $deleted ? 'Riwayat berhasil dihapus.' : 'Gagal menghapus riwayat.'
                )));
            return;
        }

        if ($deleted) {
            $this->session->set_flashdata('pesan_sukses', 'Riwayat perhitungan berhasil dihapus.');
        } else {
            $this->session->set_flashdata('pesan_error', 'Gagal menghapus riwayat perhitungan.');
        }

        redirect('riwayat');
    }
}
