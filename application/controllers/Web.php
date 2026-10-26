<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Controller lama, dialihkan ke Auth
class Web extends CI_Controller {

    public function index() {
        redirect('Auth');
    }

    public function login() {
        redirect('Auth');
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect('Auth');
    }

    public function lupa_password() {
        redirect('Auth');
    }

    public function konfirm_pass() {
        redirect('Auth');
    }

    public function error_not_found() {
        redirect('Auth/error404');
    }
}
