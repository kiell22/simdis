<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Surat extends MY_Controller {

    public function index() {
        $filter = [
            'status'     => $this->input->get('status'),
            'tgl_dari'   => $this->input->get('tgl_dari'),
            'tgl_sampai' => $this->input->get('tgl_sampai'),
            'id_bidang'  => $this->input->get('id_bidang'),
            'keyword'    => $this->input->get('keyword'),
        ];
        $data['judul']  = 'Daftar Surat';
        $data['surat']  = $this->M_disdik->get_surat_by_role($this->user->role, $this->user->id_bidang, $filter);
        $data['bidang'] = $this->M_disdik->get_all_bidang();
        $data['filter'] = $filter;
        $this->render('surat/index', $data);
    }

    public function tambah() {
        $this->only_role(['admin', 'sepri']);

        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $no_surat   = $this->input->post('no_surat', TRUE);
            $perihal    = $this->input->post('perihal', TRUE);
            $asal_surat = $this->input->post('asal_surat', TRUE);
            $tgl_surat  = $this->input->post('tgl_surat');
            $tgl_terima = $this->input->post('tgl_terima');

            if (empty($no_surat) || empty($perihal) || empty($asal_surat) || empty($tgl_surat) || empty($tgl_terima)) {
                $this->session->set_flashdata('error', 'No. surat, perihal, asal surat, tanggal surat, dan tanggal terima wajib diisi.');
                redirect('Surat/tambah');
                return;
            }

            $no_urut   = $this->M_disdik->get_no_agenda_terakhir();
            $no_agenda = 'AGD/'.date('Y').'/'.str_pad($no_urut, 4, '0', STR_PAD_LEFT);

            $file_surat = null;
            if (isset($_FILES['file_surat']) && $_FILES['file_surat']['error'] === UPLOAD_ERR_OK) {
                $tmp      = $_FILES['file_surat']['tmp_name'];
                $ori_ext  = strtolower(pathinfo($_FILES['file_surat']['name'], PATHINFO_EXTENSION));
                if ($ori_ext !== 'pdf') {
                    $this->session->set_flashdata('error', 'File harus berformat PDF.');
                    redirect('Surat/tambah');
                    return;
                }
                if ($_FILES['file_surat']['size'] > 10 * 1024 * 1024) {
                    $this->session->set_flashdata('error', 'Ukuran file maksimal 10MB.');
                    redirect('Surat/tambah');
                    return;
                }
                $upload_dir = FCPATH . 'uploads' . DIRECTORY_SEPARATOR . 'surat' . DIRECTORY_SEPARATOR;
                if (!is_dir($upload_dir)) mkdir($upload_dir, 0755, true);
                $file_surat = 'surat_' . time() . '.pdf';
                if (!move_uploaded_file($tmp, $upload_dir . $file_surat)) {
                    $this->session->set_flashdata('error', 'Upload gagal, coba lagi.');
                    redirect('Surat/tambah');
                    return;
                }
            }

            $id = $this->M_disdik->save_surat([
                'no_agenda'         => $no_agenda,
                'no_surat'          => $this->input->post('no_surat', TRUE),
                'tgl_surat'         => $this->input->post('tgl_surat'),
                'tgl_terima'        => $this->input->post('tgl_terima'),
                'asal_surat'        => $this->input->post('asal_surat', TRUE),
                'perihal'           => $this->input->post('perihal', TRUE),
                'sifat'             => $this->input->post('sifat'),
                'jenis_surat'       => $this->input->post('jenis_surat'),
                'file_surat'        => $file_surat,
                'keterangan'        => $this->input->post('keterangan', TRUE),
                'status'            => 'baru',
                'id_pengguna_input' => $this->user->id_pengguna,
            ]);

            $this->M_disdik->save_riwayat($id, $this->user->id_pengguna, 'Surat dicatat', 'No. Agenda: '.$no_agenda);
            $this->_notif_kadis($id, 'Surat baru masuk: '.$this->input->post('perihal', TRUE));
            $this->session->set_flashdata('success', 'Surat berhasil dicatat dengan No. Agenda: '.$no_agenda);
            redirect('Surat');
        }

        $data['judul'] = 'Tambah Surat';
        $this->render('surat/tambah', $data);
    }

    public function detail($id) {
        $surat = $this->M_disdik->get_surat_by_id($id);
        if (!$surat) show_404();

        // Kepala bidang hanya bisa lihat detail surat yang didistribusikan ke bidangnya
        if ($this->user->role == 'kepala_bidang') {
            $cek = $this->db->get_where('tbl_distribusi', [
                'id_surat'  => $id,
                'id_bidang' => $this->user->id_bidang
            ])->row();
            if (!$cek) {
                $this->session->set_flashdata('error', 'Anda tidak memiliki akses ke surat ini.');
                redirect('Surat');
                return;
            }
        }

        $data['judul']      = 'Detail Surat';
        $data['surat']      = $surat;
        $data['disposisi']  = $this->M_disdik->get_disposisi_by_surat($id);
        $data['distribusi'] = $this->M_disdik->get_distribusi_by_surat($id);
        $data['proses']     = $this->M_disdik->get_proses_by_surat($id);
        $data['riwayat']    = $this->M_disdik->get_riwayat_by_surat($id);
        $data['bidang']     = $this->M_disdik->get_all_bidang();

        // Cek apakah surat ini berasal dari surat masuk luar (untuk tampilkan link file asli)
        $data['sml'] = $this->db->get_where('tbl_surat_masuk_luar', ['id_surat_internal' => $id])->row();

        $data['bidang_disposisi'] = [];
        foreach ($data['disposisi'] as $d) {
            $data['bidang_disposisi'][$d->id_disposisi] = $this->M_disdik->get_bidang_disposisi($d->id_disposisi);
        }

        $this->render('surat/detail', $data);
    }

    public function edit($id) {
        $this->only_role(['admin', 'sepri']);
        $surat = $this->M_disdik->get_surat_by_id($id);
        if (!$surat) show_404();

        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $update = [
                'no_surat'   => $this->input->post('no_surat', TRUE),
                'tgl_surat'  => $this->input->post('tgl_surat'),
                'tgl_terima' => $this->input->post('tgl_terima'),
                'asal_surat' => $this->input->post('asal_surat', TRUE),
                'perihal'    => $this->input->post('perihal', TRUE),
                'sifat'      => $this->input->post('sifat'),
                'keterangan' => $this->input->post('keterangan', TRUE),
            ];

            if (isset($_FILES['file_surat']) && $_FILES['file_surat']['error'] === UPLOAD_ERR_OK) {
                $tmp     = $_FILES['file_surat']['tmp_name'];
                $ori_ext = strtolower(pathinfo($_FILES['file_surat']['name'], PATHINFO_EXTENSION));
                if ($ori_ext !== 'pdf') {
                    $this->session->set_flashdata('error', 'File harus berformat PDF.');
                    redirect('Surat/edit/'.$id);
                    return;
                }
                if ($_FILES['file_surat']['size'] > 10 * 1024 * 1024) {
                    $this->session->set_flashdata('error', 'Ukuran file maksimal 10MB.');
                    redirect('Surat/edit/'.$id);
                    return;
                }
                $upload_dir  = FCPATH . 'uploads' . DIRECTORY_SEPARATOR . 'surat' . DIRECTORY_SEPARATOR;
                if (!is_dir($upload_dir)) mkdir($upload_dir, 0755, true);
                $nama_file = 'surat_' . time() . '.pdf';
                if (move_uploaded_file($tmp, $upload_dir . $nama_file)) {
                    if ($surat->file_surat && file_exists($upload_dir . $surat->file_surat)) {
                        unlink($upload_dir . $surat->file_surat);
                    }
                    $update['file_surat'] = $nama_file;
                } else {
                    $this->session->set_flashdata('error', 'Upload gagal, coba lagi.');
                    redirect('Surat/edit/'.$id);
                    return;
                }
            }

            $this->M_disdik->update_surat($id, $update);
            $this->M_disdik->save_riwayat($id, $this->user->id_pengguna, 'Surat diperbarui', '');
            $this->session->set_flashdata('success', 'Surat berhasil diperbarui.');
            redirect('Surat/detail/'.$id);
        }

        $data['judul'] = 'Edit Surat';
        $data['surat'] = $surat;
        $this->render('surat/edit', $data);
    }

    public function hapus($id) {
        $surat = $this->M_disdik->get_surat_by_id($id);
        if ($surat && $surat->file_surat && file_exists(FCPATH.'uploads/surat/'.$surat->file_surat)) {
            unlink(FCPATH.'uploads/surat/'.$surat->file_surat);
        }
        $this->db->delete('tbl_surat', ['id_surat' => $id]);
        $this->session->set_flashdata('success', 'Surat berhasil dihapus.');
        redirect('Surat');
    }

    public function lihat_pdf($id) {
        $surat = $this->M_disdik->get_surat_by_id($id);
        if (!$surat || !$surat->file_surat) show_404();

        if ($this->user->role == 'kepala_bidang') {
            $cek = $this->db->get_where('tbl_distribusi', [
                'id_surat'  => $id,
                'id_bidang' => $this->user->id_bidang
            ])->row();
            if (!$cek) show_404();
        }
        $file = FCPATH . 'uploads/surat/' . $surat->file_surat;
        if (!file_exists($file)) show_404();
        header('Content-Type: application/pdf');
        header('Content-Disposition: inline; filename="'.$surat->file_surat.'"');
        readfile($file);
    }

    private function _notif_kadis($id_surat, $pesan) {
        $this->db->where_in('role', ['kadis', 'admin']);
        $targets = $this->db->get('tbl_pengguna')->result();
        foreach ($targets as $k) {
            $this->M_disdik->save_notifikasi($k->id_pengguna, $id_surat, $pesan);
        }
    }
}
