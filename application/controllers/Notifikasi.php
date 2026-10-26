<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notifikasi extends MY_Controller {

    // Route: Notifikasi/baca (dipanggil dari header dropdown)
    public function baca() {
        $this->M_disdik->baca_notifikasi($this->user->id_pengguna);
        $ref = $this->input->server('HTTP_REFERER');
        redirect($ref ? $ref : 'Dashboard');
    }

    public function baca_semua() {
        $this->M_disdik->baca_notifikasi($this->user->id_pengguna);
        if ($this->input->is_ajax_request()) {
            echo json_encode(['status' => 'ok']);
        } else {
            $ref = $this->input->server('HTTP_REFERER');
            redirect($ref ? $ref : 'Dashboard');
        }
    }
}
