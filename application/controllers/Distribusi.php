<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Distribusi extends MY_Controller {

    public function index() {
        $this->only_role(['bidang_umum', 'admin']);
        $data['judul']      = 'Distribusi Surat';
        $data['breadcrumb'] = [['label' => 'Distribusi Surat', 'active' => true]];
        $data['surat_disposisi']  = $this->M_disdik->get_surat_by_role('bidang_umum', null, ['status' => 'disposisi']);
        $data['surat_distribusi'] = $this->M_disdik->get_monitoring_distribusi();
        $this->render('distribusi/index', $data);
    }

    public function kirim($id_surat) {
        $this->only_role(['bidang_umum', 'admin']);

        $surat = $this->M_disdik->get_surat_by_id($id_surat);
        if (!$surat || $surat->status != 'disposisi') {
            $this->session->set_flashdata('error', 'Surat belum didisposisi atau tidak ditemukan.');
            redirect('Surat/detail/'.$id_surat);
            return;
        }

        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $bidang_ids = $this->input->post('bidang_kirim');
            if (empty($bidang_ids)) {
                $this->session->set_flashdata('error', 'Pilih bidang tujuan pengiriman.');
                redirect('Surat/detail/'.$id_surat);
                return;
            }

            $bidang_names = [];
            foreach ($bidang_ids as $id_bidang) {
                $this->M_disdik->save_distribusi([
                    'id_surat'          => $id_surat,
                    'id_bidang'         => $id_bidang,
                    'id_pengguna_kirim' => $this->user->id_pengguna,
                    'tgl_kirim'         => date('Y-m-d H:i:s'),
                    'catatan_kirim'     => $this->input->post('catatan_kirim', TRUE),
                    'status'            => 'dikirim',
                ]);

                $b = $this->M_disdik->get_bidang_by_id($id_bidang);
                if ($b) $bidang_names[] = $b->nama_bidang;

                // Notif ke kepala bidang
                $this->db->where(['role' => 'kepala_bidang', 'id_bidang' => $id_bidang]);
                $kb_list = $this->db->get('tbl_pengguna')->result();
                foreach ($kb_list as $kb) {
                    $this->M_disdik->save_notifikasi($kb->id_pengguna, $id_surat,
                        'Surat "'.$surat->perihal.'" sedang dikirim ke bidang Anda.');
                }
            }

            $this->M_disdik->update_status_surat($id_surat, 'distribusi');
            $ket = 'Dikirim ke: '.implode(', ', $bidang_names);
            $this->M_disdik->save_riwayat($id_surat, $this->user->id_pengguna, 'Surat dikirim/distribusi', $ket);

            $this->session->set_flashdata('success', 'Surat berhasil dikirim ke '.implode(', ', $bidang_names).'.');
            redirect('Surat/detail/'.$id_surat);
        }

        redirect('Surat/detail/'.$id_surat);
    }

    public function terima($id_distribusi) {
        $this->only_role(['kepala_bidang', 'admin']);

        $dist = $this->M_disdik->get_distribusi_by_id($id_distribusi);
        if (!$dist) show_404();

        // Cek akses: kepala_bidang hanya bisa terima surat untuk bidangnya sendiri
        if ($this->user->role == 'kepala_bidang' && $dist->id_bidang != $this->user->id_bidang) {
            $this->session->set_flashdata('error', 'Anda tidak berhak menerima surat ini.');
            redirect('Surat/detail/'.$dist->id_surat);
            return;
        }

        if ($dist->status == 'diterima') {
            $this->session->set_flashdata('error', 'Surat ini sudah diterima sebelumnya.');
            redirect('Surat/detail/'.$dist->id_surat);
            return;
        }

        // Proses penerimaan (GET atau POST)
        $this->M_disdik->update_distribusi($id_distribusi, [
            'status'             => 'diterima',
            'tgl_terima'         => date('Y-m-d H:i:s'),
            'id_pengguna_terima' => $this->user->id_pengguna,
            'catatan_terima'     => $this->input->post('catatan_terima', TRUE) ?? '',
        ]);

        // Cek apakah semua distribusi untuk surat ini sudah diterima
        $this->db->where('tbl_distribusi.id_surat', $dist->id_surat);
        $this->db->where('tbl_distribusi.status', 'dikirim');
        $sisa = $this->db->count_all_results('tbl_distribusi');

        if ($sisa == 0) {
            $this->M_disdik->update_status_surat($dist->id_surat, 'diterima');
        }

        $b   = $this->M_disdik->get_bidang_by_id($dist->id_bidang);
        $ket = 'Diterima oleh: '.$this->user->nama_lengkap.' ('.($b ? $b->nama_bidang : '').')';
        $this->M_disdik->save_riwayat($dist->id_surat, $this->user->id_pengguna, 'Surat diterima bidang', $ket);

        // Notif ke bidang_umum dan admin bahwa surat sudah diterima
        $surat = $this->M_disdik->get_surat_by_id($dist->id_surat);
        $pesan = 'Surat "'.($surat ? $surat->perihal : '').'" telah diterima oleh '.$this->user->nama_lengkap.' ('.($b ? $b->nama_bidang : '').')';
        $this->db->where_in('role', ['bidang_umum', 'admin']);
        $notif_targets = $this->db->get('tbl_pengguna')->result();
        foreach ($notif_targets as $t) {
            $this->M_disdik->save_notifikasi($t->id_pengguna, $dist->id_surat, $pesan);
        }

        $this->session->set_flashdata('success', 'Penerimaan surat berhasil dicatat.');
        redirect('Surat/detail/'.$dist->id_surat);
    }

    public function proses($id_surat) {
        $this->only_role(['kepala_bidang', 'admin']);

        $surat = $this->M_disdik->get_surat_by_id($id_surat);
        if (!$surat) show_404();

        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $status_proses = $this->input->post('status_proses');

            $this->M_disdik->save_proses([
                'id_surat'    => $id_surat,
                'id_bidang'   => $this->user->id_bidang,
                'id_pengguna' => $this->user->id_pengguna,
                'keterangan'  => $this->input->post('keterangan', TRUE),
                'tgl_proses'  => date('Y-m-d H:i:s'),
                'status'      => $status_proses,
            ]);

            // Update status surat: selesai hanya jika SEMUA bidang sudah selesai
            $new_status = ($status_proses == 'selesai') ? 'selesai' : 'diproses';
            if ($status_proses == 'selesai') {
                // Cek apakah masih ada proses yang belum selesai di bidang lain
                $this->db->where('tbl_proses_surat.id_surat', $id_surat);
                $this->db->where('tbl_proses_surat.status', 'diproses');
                $masih_proses = $this->db->count_all_results('tbl_proses_surat');
                if ($masih_proses > 0) {
                    $new_status = 'diproses';
                }
            }

            $this->M_disdik->update_status_surat($id_surat, $new_status);
            $this->M_disdik->save_riwayat(
                $id_surat,
                $this->user->id_pengguna,
                $new_status == 'selesai' ? 'Surat selesai diproses' : 'Surat sedang diproses',
                $this->input->post('keterangan', TRUE)
            );

            $this->session->set_flashdata('success', 'Status surat berhasil diperbarui.');
            redirect('Surat/detail/'.$id_surat);
        }

        redirect('Surat/detail/'.$id_surat);
    }
}
