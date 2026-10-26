<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan extends MY_Controller {

    public function index() {
        $data['judul']      = 'Laporan Surat';
        $data['breadcrumb'] = [['label' => 'Laporan', 'active' => true]];

        $filter = [
            'status'     => $this->input->get('status'),
            'tgl_dari'   => $this->input->get('tgl_dari'),
            'tgl_sampai' => $this->input->get('tgl_sampai'),
            'keyword'    => $this->input->get('keyword'),
        ];

        $data['surat']  = $this->M_disdik->get_surat_by_role($this->user->role, $this->user->id_bidang, $filter);
        $data['filter'] = $filter;
        $data['stat']   = $this->M_disdik->count_surat_by_status($this->user->role, $this->user->id_bidang);
        $this->render('laporan/index', $data);
    }
}
