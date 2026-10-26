<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bidang extends MY_Controller {

    public function index() {
        $this->only_role(['admin']);
        $data['judul']  = 'Manajemen Bidang';
        $data['bidang'] = $this->M_disdik->get_all_bidang();
        $this->render('bidang/index', $data);
    }

    public function simpan() {
        $this->only_role(['admin']);
        if ($this->input->server('REQUEST_METHOD') !== 'POST') { redirect('Bidang'); return; }
        $nama = $this->input->post('nama_bidang', TRUE);
        if (empty($nama)) {
            $this->session->set_flashdata('error', 'Nama bidang wajib diisi.');
            redirect('Bidang');
            return;
        }
        $this->M_disdik->save_bidang([
            'kode_bidang' => $this->input->post('kode_bidang', TRUE),
            'nama_bidang' => $nama,
            'keterangan'  => $this->input->post('keterangan', TRUE),
            'aktif'       => 1,
        ]);
        $this->session->set_flashdata('success', 'Bidang berhasil ditambahkan.');
        redirect('Bidang');
    }

    public function update() {
        $this->only_role(['admin']);
        if ($this->input->server('REQUEST_METHOD') !== 'POST') { redirect('Bidang'); return; }
        $id   = $this->input->post('id_bidang');
        $nama = $this->input->post('nama_bidang', TRUE);
        if (empty($id) || empty($nama)) {
            $this->session->set_flashdata('error', 'Data tidak valid.');
            redirect('Bidang');
            return;
        }
        $this->M_disdik->update_bidang($id, [
            'kode_bidang' => $this->input->post('kode_bidang', TRUE),
            'nama_bidang' => $nama,
            'keterangan'  => $this->input->post('keterangan', TRUE),
        ]);
        $this->session->set_flashdata('success', 'Bidang berhasil diperbarui.');
        redirect('Bidang');
    }

    public function hapus($id) {
        $this->only_role(['admin']);
        $this->M_disdik->update_bidang($id, ['aktif' => 0]);
        $this->session->set_flashdata('success', 'Bidang berhasil dinonaktifkan.');
        redirect('Bidang');
    }
}
