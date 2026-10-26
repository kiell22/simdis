<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Disposisi extends MY_Controller {

    public function proses($id_surat) {
        $this->only_role(['kadis', 'admin']);

        $surat = $this->M_disdik->get_surat_by_id($id_surat);
        if (!$surat) show_404();

        if ($this->input->server('REQUEST_METHOD') !== 'POST') {
            redirect('Surat/detail/'.$id_surat);
            return;
        }

        $bidang_ids = $this->input->post('bidang_tujuan');
        if (empty($bidang_ids)) {
            $this->session->set_flashdata('error', 'Pilih minimal satu bidang tujuan.');
            redirect('Surat/detail/'.$id_surat);
            return;
        }

        $isi_disposisi = $this->input->post('isi_disposisi', TRUE);
        if (empty($isi_disposisi)) {
            $this->session->set_flashdata('error', 'Isi disposisi wajib diisi.');
            redirect('Surat/detail/'.$id_surat);
            return;
        }

        $id_disposisi = $this->M_disdik->save_disposisi([
            'id_surat'              => $id_surat,
            'id_pengguna_disposisi' => $this->user->id_pengguna,
            'isi_disposisi'         => $isi_disposisi,
            'instruksi'             => $this->input->post('instruksi', TRUE),
            'tgl_disposisi'         => date('Y-m-d H:i:s'),
        ]);

        $this->M_disdik->save_disposisi_bidang($id_disposisi, $bidang_ids);
        $this->M_disdik->update_status_surat($id_surat, 'disposisi');

        $bidang_names = [];
        foreach ($bidang_ids as $bid) {
            $b = $this->M_disdik->get_bidang_by_id($bid);
            if ($b) $bidang_names[] = $b->nama_bidang;
        }

        $ket = 'Didisposisi ke: '.implode(', ', $bidang_names);
        $this->M_disdik->save_riwayat($id_surat, $this->user->id_pengguna, 'Surat didisposisi', $ket);

        // Notif ke bidang umum
        $this->db->where('role', 'bidang_umum');
        $bu_list = $this->db->get('tbl_pengguna')->result();
        foreach ($bu_list as $bu) {
            $this->M_disdik->save_notifikasi($bu->id_pengguna, $id_surat,
                'Surat "'.$surat->perihal.'" telah didisposisi, siap didistribusikan.');
        }

        // Notif ke sepri dan admin
        $this->db->where_in('role', ['sepri', 'admin']);
        $sepri_list = $this->db->get('tbl_pengguna')->result();
        foreach ($sepri_list as $sp) {
            $this->M_disdik->save_notifikasi($sp->id_pengguna, $id_surat,
                'Surat "'.$surat->perihal.'" telah didisposisi oleh '.$this->user->nama_lengkap.'.');
        }

        $this->session->set_flashdata('success', 'Disposisi berhasil disimpan.');
        redirect('Surat/detail/'.$id_surat);
    }
}
