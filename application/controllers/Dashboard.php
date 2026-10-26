<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {

    public function index() {
        $id_bidang = $this->user->id_bidang;
        $role      = $this->user->role;

        $data['judul']       = 'Dashboard';
        $data['stat']        = $this->M_disdik->count_surat_by_status($role, $id_bidang);
        $data['surat_baru']  = $this->M_disdik->get_surat_terbaru(5, $role, $id_bidang);
        $data['aktivitas']   = $this->M_disdik->get_aktivitas_terbaru(8);
        $data['monitoring']  = $this->M_disdik->get_monitoring_distribusi();
        $data['surat_aksi']  = $this->M_disdik->get_surat_perlu_aksi($role, $id_bidang);

        $this->render('dashboard/index', $data);
    }
}
