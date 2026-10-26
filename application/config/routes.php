<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller']   = 'Landing';
$route['404_override']         = 'Auth/error404';
$route['translate_uri_dashes'] = FALSE;

$route['landing'] = 'Landing/index';

$route['logout']                   = 'Auth/logout';
$route['Dashboard']                = 'Dashboard/index';
$route['Surat']                    = 'Surat/index';
$route['Surat/tambah']             = 'Surat/tambah';
$route['Surat/detail/(:num)']      = 'Surat/detail/$1';
$route['Surat/edit/(:num)']        = 'Surat/edit/$1';
$route['Surat/hapus/(:num)']       = 'Surat/hapus/$1';
$route['Surat/lihat_pdf/(:num)']   = 'Surat/lihat_pdf/$1';
$route['Disposisi/proses/(:num)']  = 'Disposisi/proses/$1';
$route['Distribusi/kirim/(:num)']  = 'Distribusi/kirim/$1';
$route['Distribusi/terima/(:num)'] = 'Distribusi/terima/$1';
$route['Distribusi/proses/(:num)'] = 'Distribusi/proses/$1';
$route['Pengguna']                 = 'Pengguna/index';
$route['Pengguna/simpan']          = 'Pengguna/simpan';
$route['Pengguna/update']          = 'Pengguna/update';
$route['Pengguna/hapus/(:num)']    = 'Pengguna/hapus/$1';
$route['Pengguna/profil']          = 'Pengguna/profil';
$route['Pengguna/update_profil']   = 'Pengguna/update_profil';
$route['Pengguna/ganti_password']  = 'Pengguna/ganti_password';
$route['Pengguna/upload_foto']     = 'Pengguna/upload_foto';
$route['Bidang']                   = 'Bidang/index';
$route['Bidang/simpan']            = 'Bidang/simpan';
$route['Bidang/update']            = 'Bidang/update';
$route['Notifikasi/baca_semua']    = 'Notifikasi/baca_semua';

// Surat Masuk Luar (publik, tanpa login)
$route['surat-masuk']                    = 'SuratMasuk/index';
$route['surat-masuk/kirim']              = 'SuratMasuk/kirim';
$route['surat-masuk/sukses']             = 'SuratMasuk/sukses';
$route['surat-masuk/cek-status']         = 'SuratMasuk/cek_status';

// Surat Masuk Luar (admin)
$route['SuratMasukAdmin']                = 'SuratMasukAdmin/index';
$route['SuratMasukAdmin/detail/(:num)']  = 'SuratMasukAdmin/detail/$1';
$route['SuratMasukAdmin/terima/(:num)']  = 'SuratMasukAdmin/terima/$1';
$route['SuratMasukAdmin/tolak/(:num)']   = 'SuratMasukAdmin/tolak/$1';
$route['SuratMasukAdmin/validasi/(:num)']= 'SuratMasukAdmin/validasi/$1';
$route['SuratMasukAdmin/tolak_sepri/(:num)'] = 'SuratMasukAdmin/tolak_sepri/$1';
$route['SuratMasukAdmin/lihat_file/(:num)']  = 'SuratMasukAdmin/lihat_file/$1';
