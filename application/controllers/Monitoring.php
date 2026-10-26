<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Monitoring extends MY_Controller {

    public function index() {
        $data['judul']      = 'Monitoring Distribusi';
        $data['breadcrumb'] = [['label' => 'Monitoring', 'active' => true]];
        $data['monitoring'] = $this->M_disdik->get_monitoring_distribusi();
        $data['stat']       = $this->M_disdik->count_surat_by_status($this->user->role, $this->user->id_bidang);
        $this->render('monitoring/index', $data);
    }
}
