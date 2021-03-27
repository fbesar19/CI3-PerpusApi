<?php

use Restserver\Libraries\REST_Controller;

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Peminjaman extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('PeminjamanModel', 'peminjaman');
    }
    public function index_get()
    {
        $id = $this->get('id');

        if ($id == null) {
            $data = $this->peminjaman->getPeminjaman();
        } else {
            $data = $this->peminjaman->getPeminjaman($id);
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
            if ($this->peminjaman->deletePeminjaman($id) > 0) {
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
            "tanggal_pinjam" => $this->post('tanggal_pinjam'),
            "batas_waktu" => $this->post('batas_waktu'),
            "id_user" => $this->post('id_buku'),
            "id_user" => $this->post('id_user'),
            "biaya" => $this->post('biaya')
        ];

        if ($this->peminjaman->createPeminjaman($data) > 0) {
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
            "tanggal_pinjam" => $this->post('tanggal_pinjam'),
            "batas_waktu" => $this->post('batas_waktu'),
            "id_user" => $this->post('id_buku'),
            "id_user" => $this->post('id_user'),
            "biaya" => $this->post('biaya')
        ];

        if ($this->peminjaman->updatePeminjaman($data, $id) > 0) {
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
