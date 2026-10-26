<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        if ($this->session->userdata('id_pengguna')) {
            redirect('Dashboard');
            return;
        }
        $this->load->view('auth/login');
    }

    public function login() {
        if ($this->session->userdata('id_pengguna')) {
            redirect('Dashboard');
            return;
        }

        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $username = $this->input->post('username', TRUE);
            $password = $this->input->post('password', TRUE);

            $user = $this->M_disdik->login($username, $password);

            if ($user) {
                $this->session->set_userdata([
                    'id_pengguna'  => $user->id_pengguna,
                    'nama_lengkap' => $user->nama_lengkap,
                    'username'     => $user->username,
                    'role'         => $user->role,
                    'id_bidang'    => $user->id_bidang,
                    'jabatan'      => $user->jabatan,
                    'foto'         => $user->foto,
                ]);
                $this->M_disdik->update_last_login($user->id_pengguna);
                redirect('Dashboard');
            } else {
                $this->session->set_flashdata('error', 'Username atau password salah!');
                redirect('Auth/index');
            }
            return;
        }

        $this->load->view('auth/login');
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect('Auth/index');
    }

    public function error404() {
        $this->load->view('auth/404');
    }
}
