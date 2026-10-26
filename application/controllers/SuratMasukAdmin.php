<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SuratMasukAdmin extends MY_Controller {

    private $allowed_roles = ['bidang_umum', 'kepala_bidang', 'sepri', 'kadis', 'admin'];

    private function cek_akses_bidang_umum() {
        // Sepri boleh akses untuk validasi, bidang umum harus id_bidang=9
        if ($this->user->role === 'sepri') return;
        if ($this->user->role !== 'admin' && (int)$this->user->id_bidang !== 9) {
            $this->session->set_flashdata('error', 'Halaman ini hanya untuk Bidang Umum.');
            redirect('Dashboard');
            exit;
        }
    }

    public function index() {
        $this->only_role($this->allowed_roles);
        $this->cek_akses_bidang_umum();

        $status_filter = $this->input->get('status');

        $this->db->select('s.*, pb.nama_lengkap as nama_bu, ps.nama_lengkap as nama_sepri');
        $this->db->from('tbl_surat_masuk_luar s');
        $this->db->join('tbl_pengguna pb', 'pb.id_pengguna = s.id_pengguna_bu', 'left');
        $this->db->join('tbl_pengguna ps', 'ps.id_pengguna = s.id_pengguna_sepri', 'left');

        if ($status_filter) $this->db->where('s.status', $status_filter);

        $this->db->order_by('s.created_at', 'DESC');
        $list = $this->db->get()->result();

        $data['judul']         = 'Surat Masuk Luar';
        $data['breadcrumb']    = [['label' => 'Surat Masuk Luar', 'active' => true]];
        $data['list']          = $list;
        $data['status_filter'] = $status_filter;
        $this->render('surat_masuk/index_admin', $data);
    }

    public function detail($id) {
        $this->only_role($this->allowed_roles);
        $this->cek_akses_bidang_umum();
        $sml = $this->db->get_where('tbl_surat_masuk_luar', ['id_sml' => $id])->row();
        if (!$sml) show_404();

        $data['judul']      = 'Detail Surat Masuk';
        $data['breadcrumb'] = [
            ['label' => 'Surat Masuk Luar', 'url' => base_url('SuratMasukAdmin')],
            ['label' => 'Detail', 'active' => true]
        ];
        $data['sml'] = $sml;
        $this->render('surat_masuk/detail_admin', $data);
    }

    // Bidang Umum: terima & teruskan ke Sepri
    public function terima($id) {
        $this->only_role(['bidang_umum', 'admin']);
        $this->cek_akses_bidang_umum();
        $sml = $this->db->get_where('tbl_surat_masuk_luar', ['id_sml' => $id])->row();
        if (!$sml || $sml->status !== 'menunggu') {
            $this->session->set_flashdata('error', 'Surat tidak ditemukan atau sudah diproses.');
            redirect('SuratMasukAdmin');
            return;
        }

        $this->db->update('tbl_surat_masuk_luar', [
            'status'         => 'diterima_bu',
            'catatan_bu'     => $this->input->post('catatan_bu', TRUE),
            'id_pengguna_bu' => $this->user->id_pengguna,
            'tgl_terima_bu'  => date('Y-m-d H:i:s'),
        ], ['id_sml' => $id]);

        // Notif ke sepri
        $this->db->where('role', 'sepri');
        foreach ($this->db->get('tbl_pengguna')->result() as $sp) {
            $this->M_disdik->save_notifikasi($sp->id_pengguna, null,
                'Surat dari '.$sml->instansi_pengirim.' telah diterima Bidang Umum, menunggu validasi Anda.');
        }

        $this->session->set_flashdata('success', 'Surat berhasil diterima dan diteruskan ke Sepri untuk validasi.');
        redirect('SuratMasukAdmin/detail/'.$id);
    }

    // Sepri: validasi & teruskan ke Kadis (buat surat internal)
    public function validasi($id) {
        $this->only_role(['sepri', 'admin']);
        $sml = $this->db->get_where('tbl_surat_masuk_luar', ['id_sml' => $id])->row();
        if (!$sml || $sml->status !== 'diterima_bu') {
            $this->session->set_flashdata('error', 'Surat tidak ditemukan atau belum diterima Bidang Umum.');
            redirect('SuratMasukAdmin');
            return;
        }

        $no_urut   = $this->M_disdik->get_no_agenda_terakhir();
        $no_agenda = 'AGD/' . date('Y') . '/' . str_pad($no_urut, 4, '0', STR_PAD_LEFT);

        $id_surat = $this->M_disdik->save_surat([
            'no_agenda'         => $no_agenda,
            'no_surat'          => $sml->no_surat,
            'tgl_surat'         => $sml->tgl_surat,
            'tgl_terima'        => date('Y-m-d'),
            'asal_surat'        => $sml->instansi_pengirim,
            'perihal'           => $sml->perihal,
            'sifat'             => $sml->sifat,
            'jenis_surat'       => 'masuk',
            'file_surat'        => null,
            'keterangan'        => 'Surat masuk dari luar. Pengirim: '.$sml->nama_pengirim.' ('.$sml->instansi_pengirim.'). '.$sml->keterangan,
            'status'            => 'baru',
            'id_pengguna_input' => $this->user->id_pengguna,
        ]);

        $this->M_disdik->save_riwayat($id_surat, $this->user->id_pengguna, 'Surat dicatat', 'Dari surat masuk luar: '.$sml->kode_tiket);

        $this->db->update('tbl_surat_masuk_luar', [
            'status'             => 'diteruskan_kadis',
            'catatan_sepri'      => $this->input->post('catatan_sepri', TRUE),
            'id_pengguna_sepri'  => $this->user->id_pengguna,
            'tgl_validasi_sepri' => date('Y-m-d H:i:s'),
            'id_surat_internal'  => $id_surat,
        ], ['id_sml' => $id]);

        // Notif ke kadis dan admin
        $this->db->where_in('role', ['kadis', 'admin']);
        foreach ($this->db->get('tbl_pengguna')->result() as $k) {
            $this->M_disdik->save_notifikasi($k->id_pengguna, $id_surat,
                'Surat baru dari '.$sml->instansi_pengirim.' telah divalidasi Sepri dan siap untuk disposisi.');
        }

        $this->session->set_flashdata('success', 'Surat berhasil divalidasi dan diteruskan ke Kepala Dinas. No. Agenda: '.$no_agenda);
        redirect('SuratMasukAdmin/detail/'.$id);
    }

    // Sepri: tolak surat
    public function tolak_sepri($id) {
        $this->only_role(['sepri', 'admin']);
        $sml = $this->db->get_where('tbl_surat_masuk_luar', ['id_sml' => $id])->row();
        if (!$sml || $sml->status !== 'diterima_bu') {
            $this->session->set_flashdata('error', 'Surat tidak dapat ditolak pada status ini.');
            redirect('SuratMasukAdmin');
            return;
        }

        $catatan = $this->input->post('catatan_sepri', TRUE);
        if (empty($catatan)) {
            $this->session->set_flashdata('error', 'Alasan penolakan wajib diisi.');
            redirect('SuratMasukAdmin/detail/'.$id);
            return;
        }

        $this->db->update('tbl_surat_masuk_luar', [
            'status'             => 'ditolak',
            'catatan_sepri'      => $catatan,
            'id_pengguna_sepri'  => $this->user->id_pengguna,
            'tgl_validasi_sepri' => date('Y-m-d H:i:s'),
        ], ['id_sml' => $id]);

        $this->session->set_flashdata('success', 'Surat telah ditolak.');
        redirect('SuratMasukAdmin/detail/'.$id);
    }

    // Bidang Umum: tolak surat
    public function tolak($id) {
        $this->only_role(['bidang_umum', 'admin']);
        $this->cek_akses_bidang_umum();
        $sml = $this->db->get_where('tbl_surat_masuk_luar', ['id_sml' => $id])->row();
        if (!$sml || $sml->status !== 'menunggu') {
            $this->session->set_flashdata('error', 'Surat tidak ditemukan atau sudah diproses.');
            redirect('SuratMasukAdmin');
            return;
        }

        $catatan = $this->input->post('catatan_bu', TRUE);
        if (empty($catatan)) {
            $this->session->set_flashdata('error', 'Alasan penolakan wajib diisi.');
            redirect('SuratMasukAdmin/detail/'.$id);
            return;
        }

        $this->db->update('tbl_surat_masuk_luar', [
            'status'         => 'ditolak',
            'catatan_bu'     => $catatan,
            'id_pengguna_bu' => $this->user->id_pengguna,
            'tgl_terima_bu'  => date('Y-m-d H:i:s'),
        ], ['id_sml' => $id]);

        $this->session->set_flashdata('success', 'Surat telah ditolak.');
        redirect('SuratMasukAdmin/detail/'.$id);
    }

    public function lihat_file($id) {
        $this->only_role($this->allowed_roles);
        // File asli bisa diakses bidang umum, sepri, kadis, dan admin
        if (!in_array($this->user->role, ['sepri', 'kadis', 'admin']) && (int)$this->user->id_bidang !== 9) {
            $this->session->set_flashdata('error', 'Akses ditolak.');
            redirect('Dashboard');
            return;
        }
        $sml = $this->db->get_where('tbl_surat_masuk_luar', ['id_sml' => $id])->row();
        if (!$sml || !$sml->file_surat) show_404();
        $file = FCPATH . 'uploads/surat_masuk_luar/' . $sml->file_surat;
        if (!file_exists($file)) show_404();
        header('Content-Type: application/pdf');
        header('Content-Disposition: inline; filename="'.$sml->file_surat.'"');
        readfile($file);
    }
}
