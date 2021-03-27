<?php

class PeminjamanModel extends CI_Model
{
    public function getPeminjaman($id = null)
    {
        if ($id === null) {
            return $this->db->get('peminjaman')->result_array();
        } else {
            return $this->db->get_where('peminjaman', ['id_peminjaman' => $id])->result_array();
        }
    }

    public function deletePeminjaman($id)
    {
        $this->db->delete('peminjaman', ['id_peminjaman' => $id]);
        return $this->db->affected_rows();
    }

    public function createPeminjaman($data)
    {
        $this->db->insert('peminjaman', $data);
        return $this->db->affected_rows();
    }

    public function updatePeminjaman($data, $id)
    {
        $this->db->update('peminjaman', $data, ['id_peminjaman' => $id]);
        return $this->db->affected_rows();
    }
}
