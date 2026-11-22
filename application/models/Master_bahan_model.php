<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Master_bahan_model extends CI_Model
{
    protected $table = 'master_bahan';

    public function get_all($keyword = null)
    {
        if ($keyword) {
            $this->db->like('nama_bahan', $keyword);
        }
        return $this->db->order_by('nama_bahan', 'ASC')->get($this->table)->result();
    }

    public function nama_exists($nama, $except_id = 0)
    {
        $this->db->where('nama_bahan', $nama);
        if ($except_id) {
            $this->db->where('id_master_bahan !=', $except_id);
        }
        return $this->db->count_all_results($this->table) > 0;
    }

    public function insert($data)
    {
        return $this->db->insert($this->table, $data);
    }

    public function update($id, $data)
    {
        return $this->db->where('id_master_bahan', $id)->update($this->table, $data);
    }

    public function delete($id)
    {
        return $this->db->where('id_master_bahan', $id)->delete($this->table);
    }
}