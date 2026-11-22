<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Master_bahan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Master_bahan_model', 'mb');
        $this->load->library(['form_validation', 'session']);
        $this->load->helper(['form', 'url']);
    }

    public function index()
    {
        $data['keyword'] = $this->input->get('q', TRUE);
        $data['bahan']   = $this->mb->get_all($data['keyword']);
        $this->load->view('master_bahan/index', $data);
    }

    // Dipakai untuk tambah (id kosong) dan edit (id terisi)
    public function simpan()
    {
        if ($this->input->method() !== 'post') {
            redirect('master_bahan');
        }

        $this->form_validation->set_rules('nama_bahan', 'Nama bahan', 'trim|required|max_length[50]');
        $this->form_validation->set_rules('satuan', 'Satuan', 'trim|required|max_length[30]');
        $this->form_validation->set_rules('harga_beli_terakhir', 'Harga beli', 'required|numeric|greater_than[0]');
        $this->form_validation->set_rules('isi_kemasan_terakhir', 'Isi kemasan', 'required|numeric|greater_than[0]');

        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('error', strip_tags(validation_errors()));
            redirect('master_bahan');
        }

        $id   = (int) $this->input->post('id_master_bahan');
        $nama = $this->input->post('nama_bahan', TRUE);

        if ($this->mb->nama_exists($nama, $id)) {
            $this->session->set_flashdata('error', "Bahan \"$nama\" sudah ada.");
            redirect('master_bahan');
        }

        $data = [
            'nama_bahan'           => $nama,
            'satuan'               => $this->input->post('satuan', TRUE),
            'harga_beli_terakhir'  => $this->input->post('harga_beli_terakhir'),
            'isi_kemasan_terakhir' => $this->input->post('isi_kemasan_terakhir'),
        ];

        if ($id) {
            $this->mb->update($id, $data);
            $this->session->set_flashdata('success', 'Bahan berhasil diperbarui.');
        } else {
            $this->mb->insert($data);
            $this->session->set_flashdata('success', 'Bahan berhasil ditambahkan.');
        }
        redirect('master_bahan');
    }

    public function hapus()
    {
        if ($this->input->method() === 'post') {
            $id = (int) $this->input->post('id_master_bahan');
            if ($id) {
                $this->mb->delete($id);
                $this->session->set_flashdata('success', 'Bahan berhasil dihapus.');
            }
        }
        redirect('master_bahan');
    }
}