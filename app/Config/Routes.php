<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Rute untuk root URL, mengarahkan ke halaman login
$routes->get('/', 'AuthController::login');

// Rute login Myth:Auth (untuk kejelasan)
$routes->get('login', 'AuthController::login');

// Halaman publik (tidak memerlukan login)
$routes->get('/jadwal', 'Jadwal::index');
$routes->get('/jadwal/cetak_pdf', 'Jadwal::cetak_pdf');

// Grup route yang memerlukan login
$routes->group('', ['filter' => 'login'], function ($routes) {
    $routes->get('home', 'Home::index');
    // $routes->get('home/user', 'Home::user');

    $routes->get('/jam', 'Jam::index');
    $routes->get('/jam/create', 'Jam::create');
    $routes->post('/jam/store', 'Jam::store');
    $routes->get('/jam/edit/(:num)', 'Jam::edit/$1');
    $routes->post('/jam/update/(:num)', 'Jam::update/$1');
    $routes->get('/jam/delete/(:num)', 'Jam::delete/$1');

    $routes->get('/hari', 'Hari::index');
    $routes->get('/hari/create', 'Hari::create');
    $routes->post('/hari/store', 'Hari::store');
    $routes->get('/hari/edit/(:num)', 'Hari::edit/$1');
    $routes->post('/hari/update/(:num)', 'Hari::update/$1');
    $routes->get('/hari/delete/(:num)', 'Hari::delete/$1');

    $routes->get('/dosen', 'Dosen::index');
    $routes->post('/dosen/store', 'Dosen::store');
    $routes->get('/dosen/cetak', 'Dosen::cetak');
    $routes->get('/dosen/edit/(:segment)', 'Dosen::edit/$1');
    $routes->post('/dosen/update/(:segment)', 'Dosen::update/$1');
    $routes->get('/dosen/delete/(:segment)', 'Dosen::delete/$1');

    $routes->get('/prodi', 'Prodi::index');
    $routes->get('/prodi/create', 'Prodi::create');
    $routes->post('/prodi/store', 'Prodi::store');
    $routes->get('/prodi/edit/(:num)', 'Prodi::edit/$1');
    $routes->post('/prodi/update/(:num)', 'Prodi::update/$1');
    $routes->get('/prodi/delete/(:num)', 'Prodi::delete/$1');

    $routes->get('/kelas', 'Kelas::index');
    $routes->get('/kelas/create', 'Kelas::create');
    $routes->post('/kelas/store', 'Kelas::store');
    $routes->get('/kelas/edit/(:num)', 'Kelas::edit/$1');
    $routes->post('/kelas/update/(:segment)', 'Kelas::update/$1');
    $routes->get('/kelas/delete/(:segment)', 'Kelas::delete/$1');

    $routes->get('/ruang', 'Ruang::index');
    $routes->get('/ruang/create', 'Ruang::create');
    $routes->post('/ruang/store', 'Ruang::store');
    $routes->get('/ruang/edit/(:num)', 'Ruang::edit/$1');
    $routes->post('/ruang/update/(:segment)', 'Ruang::update/$1');
    $routes->get('/ruang/delete/(:segment)', 'Ruang::delete/$1');

    $routes->get('/semester', 'Semester::index');
    $routes->get('/semester/create', 'Semester::create');
    $routes->post('/semester/store', 'Semester::store');
    $routes->get('/semester/edit/(:num)', 'Semester::edit/$1');
    $routes->post('/semester/update/(:segment)', 'Semester::update/$1');
    $routes->get('/semester/delete/(:segment)', 'Semester::delete/$1');

    $routes->get('/matakuliah', 'Matakuliah::index');
    $routes->get('/matakuliah/create', 'Matakuliah::create');
    $routes->post('/matakuliah/store', 'Matakuliah::store');
    $routes->get('/matakuliah/edit/(:num)', 'Matakuliah::edit/$1');
    $routes->post('/matakuliah/update/(:num)', 'Matakuliah::update/$1');
    $routes->get('/matakuliah/delete/(:segment)', 'Matakuliah::delete/$1');

    $routes->get('/tahunakademik', 'Tahunakademik::index');
    $routes->get('/tahunakademik/create', 'Tahunakademik::create');
    $routes->post('/tahunakademik/store', 'Tahunakademik::store');
    $routes->get('/tahunakademik/edit/(:num)', 'Tahunakademik::edit/$1');
    $routes->post('/tahunakademik/update/(:num)', 'Tahunakademik::update/$1');
    $routes->get('/tahunakademik/delete/(:num)', 'Tahunakademik::delete/$1');

    $routes->get('/pengampu', 'Pengampu::index');
    $routes->get('/pengampu/create', 'Pengampu::create');
    $routes->post('/pengampu/store', 'Pengampu::store');
    $routes->get('/pengampu/edit/(:num)', 'Pengampu::edit/$1');
    $routes->post('/pengampu/update/(:num)', 'Pengampu::update/$1');
    $routes->get('/pengampu/delete/(:num)', 'Pengampu::delete/$1');

    $routes->get('/waktutidakbersedia', 'Waktutidakbersedia::index');
    $routes->post('/waktutidakbersedia/store', 'Waktutidakbersedia::store');
    $routes->post('/waktutidakbersedia/update/(:num)', 'Waktutidakbersedia::update/$1');
    $routes->get('/waktutidakbersedia/delete/(:num)', 'Waktutidakbersedia::delete/$1');

    $routes->get('/penjadwalan', 'Penjadwalan2::index');
    $routes->post('/penjadwalan/store', 'Penjadwalan2::store');
    $routes->get('/penjadwalan/excel_report', 'Penjadwalan2::excel_report');
    $routes->get('/penjadwalan/simpan_jadwal', 'Penjadwalan2::simpan_jadwal');
    $routes->post('/penjadwalan/simpan_jadwal', 'Penjadwalan2::simpan_jadwal');
    $routes->get('/penjadwalan/hapus_jadwal', 'Penjadwalan2::hapus_jadwal');

    $routes->get('/penjadwalan3', 'Penjadwalan3::index');
    $routes->get('/penjadwalan3/store', 'Penjadwalan3::store');
    $routes->post('/penjadwalan3/store', 'Penjadwalan3::store');
    $routes->get('/penjadwalan3/excel_report', 'Penjadwalan3::excel_report');
    $routes->get('/penjadwalan3/simpan_jadwal', 'Penjadwalan3::simpan_jadwal');
    $routes->get('/penjadwalan3/hapus_jadwal', 'Penjadwalan3::hapus_jadwal');

    $routes->get('/penjadwalan4', 'Penjadwalan4::index');
    $routes->get('/penjadwalan4/store', 'Penjadwalan4::store');
    $routes->post('/penjadwalan4/store', 'Penjadwalan4::store');
    $routes->get('/penjadwalan4/excel_report', 'Penjadwalan4::excel_report');
    $routes->get('/penjadwalan4/simpan_jadwal', 'Penjadwalan4::simpan_jadwal');
    $routes->get('/penjadwalan4/hapus_jadwal', 'Penjadwalan4::hapus_jadwal');

    $routes->get('/riwayatpenjadwalan', 'Riwayatpenjadwalan::index');
    $routes->get('/riwayatpenjadwalan/(:num)/(:num)/(:num)', 'Riwayatpenjadwalan::index/$1/$2/$3');
    $routes->get('/riwayatpenjadwalan/excel_report', 'Riwayatpenjadwalan::excel_report');
    $routes->post('/riwayatpenjadwalan/simpan_jadwal', 'Riwayatpenjadwalan::simpan_jadwal');
    $routes->get('/riwayatpenjadwalan/hapus_jadwal', 'Riwayatpenjadwalan::hapus_jadwal');
    $routes->get('riwayatpenjadwalan/cek_bentrok', 'Riwayatpenjadwalan::cek_bentrok');
    $routes->get('riwayatpenjadwalan/edit/(:num)', 'Riwayatpenjadwalan::edit/$1');
    $routes->post('riwayatpenjadwalan/update/(:num)', 'Riwayatpenjadwalan::update/$1');
    $routes->get('riwayatpenjadwalan/get_sesi/(:num)', 'Riwayatpenjadwalan::get_sesi/$1');

    $routes->get('/admin', 'Admin::index');
    $routes->get('/admin/create', 'Admin::create');
    $routes->post('/admin/store', 'Admin::store');
    $routes->get('/admin/edit/(:num)', 'Admin::edit/$1');
    $routes->post('/admin/update/(:num)', 'Admin::update/$1');
    $routes->get('/admin/delete/(:num)', 'Admin::delete/$1');
});