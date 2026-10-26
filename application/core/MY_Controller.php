<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

    protected $user;

    public function __construct() {
        ob_start();
        parent::__construct();

        if (!$this->session->userdata('id_pengguna')) {
            redirect('Auth');
            exit;
        }

        $this->user = (object)[
            'id_pengguna'  => $this->session->userdata('id_pengguna'),
            'nama_lengkap' => $this->session->userdata('nama_lengkap'),
            'username'     => $this->session->userdata('username'),
            'role'         => $this->session->userdata('role'),
            'id_bidang'    => (int)$this->session->userdata('id_bidang'),
            'jabatan'      => $this->session->userdata('jabatan'),
            'foto'         => $this->session->userdata('foto'),
        ];
    }

    protected function render($view, $data = []) {
        $data['user']        = $this->user;
        $data['notif_count'] = $this->M_disdik->count_notif_belum_baca($this->user->id_pengguna);
        $data['notifikasi']  = $this->M_disdik->get_notifikasi($this->user->id_pengguna, 5);
        $this->load->view('layout/header', $data);
        $this->load->view($view, $data);
        $this->load->view('layout/footer', $data);
    }

    protected function only_role($roles) {
        if (!in_array($this->user->role, (array)$roles)) {
            $this->session->set_flashdata('error', 'Anda tidak memiliki akses ke halaman ini.');
            redirect('Dashboard');
            exit;
        }
    }
}
