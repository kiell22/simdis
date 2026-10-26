<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengguna extends MY_Controller {

    public function index() {
        $this->only_role('admin');
        $data['judul']    = 'Manajemen Pengguna';
        $data['pengguna'] = $this->M_disdik->get_all_pengguna();
        $data['bidang']   = $this->M_disdik->get_all_bidang();
        $this->render('pengguna/index', $data);
    }

    // Dipanggil dari modal tambah di pengguna/index
    public function simpan() {
        $this->only_role('admin');
        if ($this->input->server('REQUEST_METHOD') !== 'POST') { redirect('Pengguna'); return; }
        $username = $this->input->post('username', TRUE);
        $password = $this->input->post('password');
        $nama     = $this->input->post('nama_lengkap', TRUE);
        $role     = $this->input->post('role');

        if (empty($username) || empty($password) || empty($nama) || empty($role)) {
            $this->session->set_flashdata('error', 'Username, password, nama lengkap, dan role wajib diisi.');
            redirect('Pengguna');
            return;
        }
        if ($this->M_disdik->cek_username($username)) {
            $this->session->set_flashdata('error', 'Username "'.$username.'" sudah digunakan.');
            redirect('Pengguna');
            return;
        }
        $role_input = $this->input->post('role');
        $id_bidang  = $this->input->post('id_bidang') ?: null;
        $this->M_disdik->save_pengguna([
            'username'     => $username,
            'password'     => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
            'nama_lengkap' => $this->input->post('nama_lengkap', TRUE),
            'jabatan'      => $this->input->post('jabatan', TRUE),
            'role'         => $role_input,
            'id_bidang'    => $id_bidang,
            'email'        => $this->input->post('email', TRUE),
            'telp'         => $this->input->post('telp', TRUE),
            'aktif'        => 1,
        ]);
        $this->session->set_flashdata('success', 'Pengguna berhasil ditambahkan.');
        redirect('Pengguna');
    }

    // Dipanggil dari modal edit di pengguna/index
    public function update() {
        $this->only_role('admin');
        if ($this->input->server('REQUEST_METHOD') !== 'POST') { redirect('Pengguna'); return; }
        $id         = $this->input->post('id_pengguna');
        $role_input = $this->input->post('role');
        $id_bidang  = $this->input->post('id_bidang') ?: null;
        $upd = [
            'nama_lengkap' => $this->input->post('nama_lengkap', TRUE),
            'jabatan'      => $this->input->post('jabatan', TRUE),
            'role'         => $role_input,
            'id_bidang'    => $id_bidang,
            'email'        => $this->input->post('email', TRUE),
            'telp'         => $this->input->post('telp', TRUE),
        ];
        if ($this->input->post('password')) {
            $upd['password'] = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
        }
        $this->M_disdik->update_pengguna($id, $upd);
        $this->session->set_flashdata('success', 'Pengguna berhasil diperbarui.');
        redirect('Pengguna');
    }

    public function hapus($id) {
        $this->only_role('admin');
        if ($id == $this->user->id_pengguna) {
            $this->session->set_flashdata('error', 'Tidak bisa menghapus akun sendiri.');
        } else {
            $this->M_disdik->delete_pengguna($id);
            $this->session->set_flashdata('success', 'Pengguna berhasil dinonaktifkan.');
        }
        redirect('Pengguna');
    }

    public function profil() {
        $data['judul']    = 'Profil Saya';
        $data['pengguna'] = $this->M_disdik->get_pengguna_by_id($this->user->id_pengguna);
        $this->render('pengguna/profil', $data);
    }

    public function update_profil() {
        $upd = [
            'nama_lengkap' => $this->input->post('nama_lengkap', TRUE),
            'jabatan'      => $this->input->post('jabatan', TRUE),
            'email'        => $this->input->post('email', TRUE),
            'telp'         => $this->input->post('telp', TRUE),
        ];
        $this->M_disdik->update_pengguna($this->user->id_pengguna, $upd);
        $this->session->set_userdata('nama_lengkap', $this->input->post('nama_lengkap', TRUE));
        $this->session->set_flashdata('success', 'Profil berhasil diperbarui.');
        redirect('Pengguna/profil');
    }

    public function ganti_password() {
        $lama  = $this->input->post('password_lama');
        $baru  = $this->input->post('password_baru');
        $konfirm = $this->input->post('konfirmasi');

        $cek = $this->M_disdik->login($this->user->username, $lama);
        if (!$cek) {
            $this->session->set_flashdata('error', 'Password lama tidak sesuai.');
            redirect('Pengguna/profil');
            return;
        }
        if ($baru !== $konfirm) {
            $this->session->set_flashdata('error', 'Konfirmasi password tidak cocok.');
            redirect('Pengguna/profil');
            return;
        }
        $this->M_disdik->update_pengguna($this->user->id_pengguna, ['password' => password_hash($baru, PASSWORD_DEFAULT)]);
        $this->session->set_flashdata('success', 'Password berhasil diubah.');
        redirect('Pengguna/profil');
    }

    public function upload_foto() {
        if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
            $tmp     = $_FILES['foto']['tmp_name'];
            $ori_ext = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));
            if (!in_array($ori_ext, ['jpg', 'jpeg', 'png'])) {
                $this->session->set_flashdata('error', 'File harus berformat JPG atau PNG.');
                redirect('Pengguna/profil');
                return;
            }
            if ($_FILES['foto']['size'] > 2 * 1024 * 1024) {
                $this->session->set_flashdata('error', 'Ukuran foto maksimal 2MB.');
                redirect('Pengguna/profil');
                return;
            }
            $upload_dir = FCPATH . 'uploads' . DIRECTORY_SEPARATOR . 'foto' . DIRECTORY_SEPARATOR;
            if (!is_dir($upload_dir)) mkdir($upload_dir, 0755, true);
            $nama_file = 'foto_' . $this->user->id_pengguna . '_' . time() . '.' . $ori_ext;
            if (move_uploaded_file($tmp, $upload_dir . $nama_file)) {
                $old = $this->M_disdik->get_pengguna_by_id($this->user->id_pengguna)->foto;
                if ($old && $old !== 'default.png' && file_exists($upload_dir . $old)) {
                    unlink($upload_dir . $old);
                }
                $this->M_disdik->update_pengguna($this->user->id_pengguna, ['foto' => $nama_file]);
                $this->session->set_userdata('foto', $nama_file);
                $this->session->set_flashdata('success', 'Foto profil berhasil diperbarui.');
            } else {
                $this->session->set_flashdata('error', 'Upload gagal, coba lagi.');
            }
        } else {
            $this->session->set_flashdata('error', 'Pilih file foto terlebih dahulu.');
        }
        redirect('Pengguna/profil');
    }
}
