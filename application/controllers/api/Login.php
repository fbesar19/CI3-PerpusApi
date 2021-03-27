<?php

use Restserver\Libraries\REST_Controller;

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Login extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('UserModel', 'user');
    }

    public function index_post()
    {

        $email = $this->post('email_user');
        $password = $this->post('password_user');
        $data = $this->user->getLogin($email, $password);

        if ($data) {
            $this->response([
                'status' => true,
                'message' => 'Berhasil Login',
                'data' => $data
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'data' => 'Gagal Login'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
}
