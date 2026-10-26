<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_disdik extends CI_Model {

    // ===================== AUTH =====================

    public function login($username, $password) {
        $user = $this->db->get_where('tbl_pengguna', [
            'username' => $username,
            'aktif'    => 1
        ])->row();
        if (!$user) return false;
        // Support bcrypt dan md5 (legacy)
        if (password_verify($password, $user->password) || md5($password) === $user->password) {
            return $user;
        }
        return false;
    }

    public function get_pengguna_by_id($id) {
        return $this->db->get_where('tbl_pengguna', ['id_pengguna' => $id])->row();
    }

    public function update_last_login($id) {
        $this->db->update('tbl_pengguna', ['terakhir_login' => date('Y-m-d H:i:s')], ['id_pengguna' => $id]);
    }

    // ===================== PENGGUNA =====================

    public function get_all_pengguna() {
        $this->db->select('p.*, b.nama_bidang');
        $this->db->from('tbl_pengguna p');
        $this->db->join('tbl_bidang b', 'b.id_bidang = p.id_bidang', 'left');
        $this->db->order_by('p.nama_lengkap', 'ASC');
        return $this->db->get()->result();
    }

    public function save_pengguna($data) {
        $this->db->insert('tbl_pengguna', $data);
        return $this->db->insert_id();
    }

    public function update_pengguna($id, $data) {
        $this->db->update('tbl_pengguna', $data, ['id_pengguna' => $id]);
    }

    public function delete_pengguna($id) {
        $this->db->update('tbl_pengguna', ['aktif' => 0], ['id_pengguna' => $id]);
    }

    public function cek_username($username, $exclude_id = null) {
        $this->db->where('username', $username);
        if ($exclude_id) $this->db->where('id_pengguna !=', $exclude_id);
        return $this->db->count_all_results('tbl_pengguna');
    }

    // ===================== BIDANG =====================

    public function get_all_bidang() {
        return $this->db->get_where('tbl_bidang', ['aktif' => 1])->result();
    }

    public function get_bidang_by_id($id) {
        return $this->db->get_where('tbl_bidang', ['id_bidang' => $id])->row();
    }

    public function save_bidang($data) {
        $this->db->insert('tbl_bidang', $data);
        return $this->db->insert_id();
    }

    public function update_bidang($id, $data) {
        $this->db->update('tbl_bidang', $data, ['id_bidang' => $id]);
    }

    // ===================== SURAT =====================

    public function get_surat_list($filter = []) {
        $this->db->select('s.*, p.nama_lengkap as input_oleh');
        $this->db->from('tbl_surat s');
        $this->db->join('tbl_pengguna p', 'p.id_pengguna = s.id_pengguna_input', 'left');

        if (!empty($filter['status']))
            $this->db->where('s.status', $filter['status']);
        if (!empty($filter['tgl_dari']))
            $this->db->where('s.tgl_terima >=', $filter['tgl_dari']);
        if (!empty($filter['tgl_sampai']))
            $this->db->where('s.tgl_terima <=', $filter['tgl_sampai']);
        if (!empty($filter['keyword']))
            $this->db->group_start()
                ->like('s.no_surat', $filter['keyword'])
                ->or_like('s.perihal', $filter['keyword'])
                ->or_like('s.asal_surat', $filter['keyword'])
            ->group_end();
        if (!empty($filter['id_bidang'])) {
            $this->db->join('tbl_distribusi d', 'd.id_surat = s.id_surat', 'left');
            $this->db->where('d.id_bidang', $filter['id_bidang']);
        }

        $this->db->order_by('s.created_at', 'DESC');
        return $this->db->get()->result();
    }

    public function get_surat_by_id($id) {
        $this->db->select('s.*, p.nama_lengkap as input_oleh');
        $this->db->from('tbl_surat s');
        $this->db->join('tbl_pengguna p', 'p.id_pengguna = s.id_pengguna_input', 'left');
        $this->db->where('s.id_surat', $id);
        return $this->db->get()->row();
    }

    public function get_surat_by_role($role, $id_bidang = null, $filter = []) {
        $this->db->select('s.*, p.nama_lengkap as input_oleh');
        $this->db->from('tbl_surat s');
        $this->db->join('tbl_pengguna p', 'p.id_pengguna = s.id_pengguna_input', 'left');

        if ($role == 'kepala_bidang' && $id_bidang) {
            $this->db->join('tbl_distribusi d', 'd.id_surat = s.id_surat', 'inner');
            $this->db->where('d.id_bidang', $id_bidang);
        } elseif ($role == 'bidang_umum') {
            $this->db->where_in('s.status', ['disposisi', 'distribusi', 'diterima', 'diproses', 'selesai']);
        }

        if (!empty($filter['status']))    $this->db->where('s.status', $filter['status']);
        if (!empty($filter['tgl_dari']))  $this->db->where('s.tgl_terima >=', $filter['tgl_dari']);
        if (!empty($filter['tgl_sampai']))$this->db->where('s.tgl_terima <=', $filter['tgl_sampai']);
        if (!empty($filter['id_bidang']) && !in_array($role, ['kepala_bidang', 'bidang_umum'])) {
            $this->db->join('tbl_distribusi d2', 'd2.id_surat = s.id_surat', 'left');
            $this->db->where('d2.id_bidang', $filter['id_bidang']);
        }
        if (!empty($filter['keyword']))
            $this->db->group_start()
                ->like('s.no_surat', $filter['keyword'])
                ->or_like('s.perihal', $filter['keyword'])
                ->or_like('s.asal_surat', $filter['keyword'])
            ->group_end();

        $this->db->order_by('s.created_at', 'DESC');
        return $this->db->get()->result();
    }

    public function save_surat($data) {
        $this->db->insert('tbl_surat', $data);
        return $this->db->insert_id();
    }

    public function update_surat($id, $data) {
        $this->db->update('tbl_surat', $data, ['id_surat' => $id]);
    }

    public function update_status_surat($id, $status) {
        $this->db->update('tbl_surat', ['status' => $status, 'updated_at' => date('Y-m-d H:i:s')], ['id_surat' => $id]);
    }

    public function get_no_agenda_terakhir() {
        $tahun = date('Y');
        $this->db->like('no_agenda', 'AGD/'.$tahun.'/', 'after');
        $this->db->order_by('id_surat', 'DESC');
        $this->db->limit(1);
        $row = $this->db->get('tbl_surat')->row();
        if ($row) {
            $parts = explode('/', $row->no_agenda);
            return (int)end($parts) + 1;
        }
        return 1;
    }

    // ===================== DISPOSISI =====================

    public function save_disposisi($data) {
        $this->db->insert('tbl_disposisi', $data);
        return $this->db->insert_id();
    }

    public function save_disposisi_bidang($id_disposisi, $bidang_ids) {
        foreach ($bidang_ids as $id_bidang) {
            $this->db->insert('tbl_disposisi_bidang', [
                'id_disposisi' => $id_disposisi,
                'id_bidang'    => $id_bidang
            ]);
        }
    }

    public function get_disposisi_by_surat($id_surat) {
        $this->db->select('d.*, p.nama_lengkap as disposisi_oleh');
        $this->db->from('tbl_disposisi d');
        $this->db->join('tbl_pengguna p', 'p.id_pengguna = d.id_pengguna_disposisi', 'left');
        $this->db->where('d.id_surat', $id_surat);
        $this->db->order_by('d.tgl_disposisi', 'DESC');
        return $this->db->get()->result();
    }

    public function get_bidang_disposisi($id_disposisi) {
        $this->db->select('b.*');
        $this->db->from('tbl_disposisi_bidang db');
        $this->db->join('tbl_bidang b', 'b.id_bidang = db.id_bidang');
        $this->db->where('db.id_disposisi', $id_disposisi);
        return $this->db->get()->result();
    }

    // ===================== DISTRIBUSI =====================

    public function save_distribusi($data) {
        $this->db->insert('tbl_distribusi', $data);
        return $this->db->insert_id();
    }

    public function get_distribusi_by_surat($id_surat) {
        $this->db->select('d.*, b.nama_bidang, pk.nama_lengkap as kirim_oleh, pt.nama_lengkap as terima_oleh');
        $this->db->from('tbl_distribusi d');
        $this->db->join('tbl_bidang b', 'b.id_bidang = d.id_bidang', 'left');
        $this->db->join('tbl_pengguna pk', 'pk.id_pengguna = d.id_pengguna_kirim', 'left');
        $this->db->join('tbl_pengguna pt', 'pt.id_pengguna = d.id_pengguna_terima', 'left');
        $this->db->where('d.id_surat', $id_surat);
        return $this->db->get()->result();
    }

    public function get_distribusi_by_id($id) {
        return $this->db->get_where('tbl_distribusi', ['id_distribusi' => $id])->row();
    }

    public function update_distribusi($id, $data) {
        $this->db->update('tbl_distribusi', $data, ['id_distribusi' => $id]);
    }

    public function get_surat_distribusi_pending($id_bidang = null) {
        $this->db->select('d.*, s.no_surat, s.perihal, s.sifat, b.nama_bidang');
        $this->db->from('tbl_distribusi d');
        $this->db->join('tbl_surat s', 's.id_surat = d.id_surat');
        $this->db->join('tbl_bidang b', 'b.id_bidang = d.id_bidang');
        $this->db->where('d.status', 'dikirim');
        if ($id_bidang) $this->db->where('d.id_bidang', $id_bidang);
        $this->db->order_by('d.tgl_kirim', 'DESC');
        return $this->db->get()->result();
    }

    // ===================== PROSES SURAT =====================

    public function save_proses($data) {
        $this->db->insert('tbl_proses_surat', $data);
        return $this->db->insert_id();
    }

    public function get_proses_by_surat($id_surat) {
        $this->db->select('ps.*, p.nama_lengkap, b.nama_bidang');
        $this->db->from('tbl_proses_surat ps');
        $this->db->join('tbl_pengguna p', 'p.id_pengguna = ps.id_pengguna', 'left');
        $this->db->join('tbl_bidang b', 'b.id_bidang = ps.id_bidang', 'left');
        $this->db->where('ps.id_surat', $id_surat);
        $this->db->order_by('ps.tgl_proses', 'DESC');
        return $this->db->get()->result();
    }

    // ===================== RIWAYAT =====================

    public function save_riwayat($id_surat, $id_pengguna, $aksi, $keterangan = '') {
        $this->db->insert('tbl_riwayat', [
            'id_surat'    => $id_surat,
            'id_pengguna' => $id_pengguna,
            'aksi'        => $aksi,
            'keterangan'  => $keterangan,
            'tgl_aksi'    => date('Y-m-d H:i:s')
        ]);
    }

    public function get_riwayat_by_surat($id_surat) {
        $this->db->select('r.*, p.nama_lengkap, p.role');
        $this->db->from('tbl_riwayat r');
        $this->db->join('tbl_pengguna p', 'p.id_pengguna = r.id_pengguna', 'left');
        $this->db->where('r.id_surat', $id_surat);
        $this->db->order_by('r.tgl_aksi', 'ASC');
        return $this->db->get()->result();
    }

    // ===================== NOTIFIKASI =====================

    public function save_notifikasi($id_pengguna, $id_surat, $pesan) {
        $this->db->insert('tbl_notifikasi', [
            'id_pengguna' => $id_pengguna,
            'id_surat'    => $id_surat,
            'pesan'       => $pesan
        ]);
    }

    public function get_notifikasi($id_pengguna, $limit = 10) {
        $this->db->where('id_pengguna', $id_pengguna);
        $this->db->order_by('created_at', 'DESC');
        $this->db->limit($limit);
        return $this->db->get('tbl_notifikasi')->result();
    }

    public function count_notif_belum_baca($id_pengguna) {
        return $this->db->where(['id_pengguna' => $id_pengguna, 'dibaca' => 0])
                        ->count_all_results('tbl_notifikasi');
    }

    public function baca_notifikasi($id_pengguna) {
        $this->db->update('tbl_notifikasi', ['dibaca' => 1], ['id_pengguna' => $id_pengguna]);
    }

    // ===================== DASHBOARD =====================

    public function get_surat_perlu_aksi($role, $id_bidang = null) {
        switch ($role) {
            case 'kadis':
                // Surat baru yang belum didisposisi
                return $this->db->get_where('tbl_surat', ['status' => 'baru'])->result();

            case 'bidang_umum':
                // Surat sudah disposisi, belum didistribusi
                return $this->db->get_where('tbl_surat', ['status' => 'disposisi'])->result();

            case 'kepala_bidang':
                // Surat yang dikirim ke bidang ini dan belum diterima
                $this->db->select('s.*, d.id_distribusi, d.tgl_kirim, d.catatan_kirim, d.status as status_dist');
                $this->db->from('tbl_surat s');
                $this->db->join('tbl_distribusi d', 'd.id_surat = s.id_surat');
                $this->db->where('d.id_bidang', $id_bidang);
                $this->db->where('d.status', 'dikirim');
                return $this->db->get()->result();

            case 'admin':
            case 'sepri':
                // Surat baru yang belum diproses
                return $this->db->get_where('tbl_surat', ['status' => 'baru'])->result();

            default:
                return [];
        }
    }

    public function count_surat_by_status($role = null, $id_bidang = null) {
        $statuses = ['baru','disposisi','distribusi','diterima','diproses','selesai'];
        $result = [];
        foreach ($statuses as $s) {
            if ($role == 'bidang_umum' && $s === 'baru') {
                $result[$s] = 0;
                continue;
            }
            if ($role == 'kepala_bidang' && $id_bidang) {
                $this->db->select('COUNT(*) as total');
                $this->db->from('tbl_surat');
                $this->db->join('tbl_distribusi', 'tbl_distribusi.id_surat = tbl_surat.id_surat', 'inner');
                $this->db->where('tbl_surat.status', $s);
                $this->db->where('tbl_distribusi.id_bidang', $id_bidang);
                $row = $this->db->get()->row();
                $result[$s] = $row ? (int)$row->total : 0;
            } else {
                $result[$s] = $this->db->where('status', $s)->count_all_results('tbl_surat');
            }
        }
        return $result;
    }

    public function get_surat_terbaru($limit = 5, $role = null, $id_bidang = null) {
        $this->db->select('s.*, p.nama_lengkap as input_oleh');
        $this->db->from('tbl_surat s');
        $this->db->join('tbl_pengguna p', 'p.id_pengguna = s.id_pengguna_input', 'left');
        if ($role == 'kepala_bidang' && $id_bidang) {
            $this->db->join('tbl_distribusi d', 'd.id_surat = s.id_surat', 'inner');
            $this->db->where('d.id_bidang', $id_bidang);
        } elseif ($role == 'bidang_umum') {
            $this->db->where_in('s.status', ['disposisi', 'distribusi', 'diterima', 'diproses', 'selesai']);
        }
        $this->db->order_by('s.created_at', 'DESC');
        $this->db->limit($limit);
        return $this->db->get()->result();
    }

    public function get_aktivitas_terbaru($limit = 10) {
        $this->db->select('r.*, p.nama_lengkap, p.role, s.no_surat, s.perihal');
        $this->db->from('tbl_riwayat r');
        $this->db->join('tbl_pengguna p', 'p.id_pengguna = r.id_pengguna', 'left');
        $this->db->join('tbl_surat s', 's.id_surat = r.id_surat', 'left');
        $this->db->order_by('r.tgl_aksi', 'DESC');
        $this->db->limit($limit);
        return $this->db->get()->result();
    }

    public function get_monitoring_distribusi() {
        $this->db->select('s.id_surat, s.no_surat, s.perihal, s.status, s.tgl_terima,
            GROUP_CONCAT(b.nama_bidang SEPARATOR ", ") as bidang_tujuan,
            COUNT(d.id_distribusi) as total_distribusi,
            SUM(CASE WHEN d.status="diterima" THEN 1 ELSE 0 END) as sudah_diterima');
        $this->db->from('tbl_surat s');
        $this->db->join('tbl_distribusi d', 'd.id_surat = s.id_surat', 'left');
        $this->db->join('tbl_bidang b', 'b.id_bidang = d.id_bidang', 'left');
        $this->db->where_in('s.status', ['disposisi','distribusi','diterima','diproses']);
        $this->db->group_by('s.id_surat');
        $this->db->order_by('s.created_at', 'DESC');
        $this->db->limit(20);
        return $this->db->get()->result();
    }
}
