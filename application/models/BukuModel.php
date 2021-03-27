<?php

class BukuModel extends CI_Model
{
    public function getBuku($id = null)
    {
        if ($id === null) {
            return $this->db->get('buku')->result_array();
        } else {
            return $this->db->get_where('buku', ['id_buku' => $id])->result_array();
        }
    }

    public function deleteBuku($id)
    {
        $this->db->delete('buku', ['id_buku' => $id]);
        return $this->db->affected_rows();
    }

    public function createBuku($data)
    {
        $this->db->insert('buku', $data);
        return $this->db->affected_rows();
    }

    public function updateBuku($data, $id)
    {
        $this->db->update('buku', $data, ['id_buku' => $id]);
        return $this->db->affected_rows();
    }
}
