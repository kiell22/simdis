<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SuratMasuk extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('M_disdik');
        $this->load->library(['session', 'form_validation']);
        $this->load->helper(['url', 'form']);
    }

    // Landing page form publik
    public function index() {
        $this->load->view('surat_masuk/form_publik');
    }

    // Proses submit form publik
    public function kirim() {
        if ($this->input->server('REQUEST_METHOD') !== 'POST') {
            redirect('surat-masuk');
            return;
        }

        $nama       = $this->input->post('nama_pengirim', TRUE);
        $instansi   = $this->input->post('instansi_pengirim', TRUE);
        $no_surat   = $this->input->post('no_surat', TRUE);
        $tgl_surat  = $this->input->post('tgl_surat');
        $perihal    = $this->input->post('perihal', TRUE);

        if (empty($nama) || empty($instansi) || empty($no_surat) || empty($tgl_surat) || empty($perihal)) {
            $this->session->set_flashdata('error', 'Nama, instansi, no. surat, tanggal, dan perihal wajib diisi.');
            redirect('surat-masuk');
            return;
        }

        $file_surat = null;
        if (isset($_FILES['file_surat']) && $_FILES['file_surat']['error'] === UPLOAD_ERR_OK) {
            $ext = strtolower(pathinfo($_FILES['file_surat']['name'], PATHINFO_EXTENSION));
            if ($ext !== 'pdf') {
                $this->session->set_flashdata('error', 'File harus berformat PDF.');
                redirect('surat-masuk');
                return;
            }
            if ($_FILES['file_surat']['size'] > 10 * 1024 * 1024) {
                $this->session->set_flashdata('error', 'Ukuran file maksimal 10MB.');
                redirect('surat-masuk');
                return;
            }
            $upload_dir = FCPATH . 'uploads/surat_masuk_luar/';
            if (!is_dir($upload_dir)) mkdir($upload_dir, 0755, true);
            $file_surat = 'sml_' . time() . '.' . $ext;
            if (!move_uploaded_file($_FILES['file_surat']['tmp_name'], $upload_dir . $file_surat)) {
                $this->session->set_flashdata('error', 'Upload file gagal, coba lagi.');
                redirect('surat-masuk');
                return;
            }
        }

        $kode_tiket = 'SML-' . strtoupper(substr(md5(uniqid()), 0, 8));

        $this->db->insert('tbl_surat_masuk_luar', [
            'kode_tiket'        => $kode_tiket,
            'nama_pengirim'     => $nama,
            'instansi_pengirim' => $instansi,
            'nip_pengirim'      => $this->input->post('nip_pengirim', TRUE),
            'no_hp'             => $this->input->post('no_hp', TRUE),
            'email_pengirim'    => $this->input->post('email_pengirim', TRUE),
            'no_surat'          => $no_surat,
            'tgl_surat'         => $tgl_surat,
            'perihal'           => $perihal,
            'sifat'             => $this->input->post('sifat') ?: 'biasa',
            'file_surat'        => $file_surat,
            'keterangan'        => $this->input->post('keterangan', TRUE),
            'status'            => 'menunggu',
        ]);

        // Notif ke bidang_umum
        $id_sml = $this->db->insert_id();
        $this->db->where('role', 'bidang_umum');
        $bu_list = $this->db->get('tbl_pengguna')->result();
        foreach ($bu_list as $bu) {
            $this->M_disdik->save_notifikasi($bu->id_pengguna, null,
                'Surat masuk baru dari '.$instansi.' - "'.$perihal.'" menunggu penerimaan.');
        }

        $this->session->set_flashdata('sukses_tiket', $kode_tiket);
        $this->session->set_flashdata('sukses_perihal', $perihal);
        redirect('surat-masuk/sukses');
    }

    // Halaman sukses setelah submit
    public function sukses() {
        $tiket   = $this->session->flashdata('sukses_tiket');
        $perihal = $this->session->flashdata('sukses_perihal');
        if (!$tiket) { redirect('surat-masuk'); return; }
        $this->load->view('surat_masuk/sukses', ['tiket' => $tiket, 'perihal' => $perihal]);
    }

    // Cek status tiket (publik)
    public function cek_status() {
        $kode  = $this->input->get('kode', TRUE);
        $data  = ['result' => null, 'kode' => $kode];
        if ($kode) {
            $data['result'] = $this->db->get_where('tbl_surat_masuk_luar', ['kode_tiket' => $kode])->row();
        }
        $this->load->view('surat_masuk/cek_status', $data);
    }
}
