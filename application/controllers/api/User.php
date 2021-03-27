<?php

use Restserver\Libraries\REST_Controller;

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class User extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('UserModel', 'user');
    }
    public function index_get()
    {
        $id = $this->get('id');

        if ($id == null) {
            $user = $this->user->getUser();
        } else {
            $user = $this->user->getUser($id);
        }

        if ($user) {
            $this->response([
                'status' => true,
                'data' => $user
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
            if ($this->user->deleteUser($id) > 0) {
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
            'email_user' => $this->post('email_user'),
            'nama_user' => $this->post('nama_user'),
            'password_user' => $this->post('password_user'),
            'alamat_user' => $this->post('alamat_user')
        ];

        if ($this->user->createUser($data) > 0) {
            $this->response([
                'status' => true,
                'message' => 'data user baru berhasil ditambah'
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
            'email_user' => $this->put('email_user'),
            'nama_user' => $this->put('nama_user'),
            'password_user' => $this->put('password_user'),
            'alamat_user' => $this->put('alamat_user')
        ];

        if ($this->user->updateUser($data, $id) > 0) {
            $this->response([
                'status' => true,
                'message' => 'data user berhasil diupdate'
            ], REST_Controller::HTTP_NO_CONTENT);
        } else {
            $this->response([
                'status' => false,
                'message' => 'gagal update data'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
}
