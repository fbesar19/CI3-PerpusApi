<?php

use Restserver\Libraries\REST_Controller;

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Buku extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('BukuModel', 'buku');
    }
    public function index_get()
    {
        $id = $this->get('id');

        if ($id == null) {
            $data = $this->buku->getBuku();
        } else {
            $data = $this->buku->getBuku($id);
        }

        if ($data) {
            $this->response([
                'status' => true,
                'data' => $data
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => true,
                'message' => 'id tidak ditemukan'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function index_delete()
    {
        $id = $this->delete('id');
        if ($id === null) {
            $this->response([
                'status' => false,
                'data' => 'id tidak ada'
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            if ($this->buku->deleteBuku($id) > 0) {
                $this->response([
                    'status' => true,
                    'data' => $id,
                    'message' => 'terhapus'
                ], REST_Controller::HTTP_NO_CONTENT);
            } else {
                $this->response([
                    'status' => false,
                    'data' => 'id tidak ada'
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }
    }

    public function index_post()
    {
        $data = [
            "judul_buku" => $this->post('nama_obat'),
            "penulis_buku" => $this->post('stok_obat'),
            "penerbit_buku" => $this->post('harga_obat'),
            "tahun_terbit" => $this->post('deskripsi_obat'),
            "sinopsi_buku" => $this->post('sinopsis_buku')
        ];

        if ($this->buku->createBuku($data) > 0) {
            $this->response([
                'status' => true,
                'message' => 'data pendaftaran baru berhasil ditambah'
            ], REST_Controller::HTTP_CREATED);
        } else {
            $this->response([
                'status' => false,
                'data' => 'gagal menambahkan data'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function index_put()
    {
        $id = $this->put('id');
        $data = [
            "judul_buku" => $this->post('nama_obat'),
            "penulis_buku" => $this->post('stok_obat'),
            "penerbit_buku" => $this->post('harga_obat'),
            "tahun_terbit" => $this->post('deskripsi_obat'),
            "sinopsi_buku" => $this->post('sinopsis_buku')
        ];

        if ($this->buku->updateBuku($data, $id) > 0) {
            $this->response([
                'status' => true,
                'message' => 'data pendaftaran berhasil diupdate'
            ], REST_Controller::HTTP_NO_CONTENT);
        } else {
            $this->response([
                'status' => false,
                'message' => 'gagal update data'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
}
