<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Auth::login');
$routes->get('/auth/login', 'Auth::login');
$routes->post('/auth/loginProcess', 'Auth::loginProcess');
$routes->get('/auth/register', 'Auth::register');
$routes->post('/auth/registerProcess', 'Auth::registerProcess');
$routes->get('/auth/logout', 'Auth::logout');
// $routes->get('/auth/forgot-password', 'Auth::forgotPassword');
$routes->get('/auth/forgot_password', 'Auth::forgotPassword');
$routes->post('/auth/sendResetLink', 'Auth::sendResetLink');
$routes->get('/auth/reset_password/(:any)', 'Auth::resetPassword/$1');
$routes->post('/auth/updatePassword', 'Auth::updatePassword');


// Rute untuk pengguna
$routes->get('/userDashboard', 'UserController::dashboard', ['filter' => 'auth']);
$routes->get('/user/dashboard', 'UserController::dashboard');
$routes->get('/userTambah', 'UserTambah::index');
$routes->post('/userTambah/tambahData', 'UserTambah::tambahData');


$routes->post('/user/tambahData', 'UserController::tambahData');
$routes->get('/getDocumentDetails', 'UserController::getDocumentDetails');

// Rute untuk admin
$routes->get('/admin/dashboard', 'Admin::dashboard', ['filter' => 'auth']);
$routes->get('/adminKontrak', 'AdminKontrak::index');
$routes->get('/adminSpph', 'AdminSpph::index');
$routes->get('/adminSuratpesanan', 'AdminSuratpesanan::index');
$routes->get('/adminUmk', 'AdminUmk::index');
$routes->get('/adminDatakepala', 'AdminDatakepala::index');
$routes->get('/adminDatakacab', 'AdminDatakacab::index');


$routes->get('/userTambah', 'UserTambah::index');
$routes->post('/userTambah/tambahData', 'UserTambah::tambahData');


// Proses TOR
$routes->get('prosesTor', 'ProsesTor::index');
$routes->get('prosesTor/prosesTor', 'ProsesTor::prosesTor');
$routes->post('prosesTor/saveTor', 'ProsesTor::saveTor');
$routes->get('prosesTor/resetTor', 'ProsesTor::resetTor');


// Proses Budgeting
$routes->get('prosesBudgeting', 'ProsesBudgeting::index');
$routes->get('prosesBudgeting/prosesBudgeting', 'ProsesBudgeting::prosesBudgeting');
$routes->post('prosesBudgeting/saveBudget', 'ProsesBudgeting::saveBudget');
$routes->get('prosesBudgeting/resetBudget', 'ProsesBudgeting::resetBudget');


// Proses PPbj
$routes->get('prosesPpbj', 'ProsesPpbj::index');
$routes->get('prosesPpbj/prosesPpbj', 'ProsesPpbj::prosesPpbj');
$routes->post('prosesPpbj/savePpbj', 'ProsesPpbj::savePpbj');
$routes->get('prosesPpbj/resetPpbj', 'ProsesPpbj::resetPpbj');


// Rute update status admin
$routes->post('admin/updateStatus', 'Admin::updateStatus');
$routes->get('admin/getDocument/(:num)', 'Admin::getDocument/$1');
$routes->delete('admin/deleteDocument/(:num)', 'Admin::deleteDocument/$1');
$routes->get('admin/deleteDocument/(:num)', 'Admin::deleteDocument/$1');


// Rute admin delete
$routes->post('admin/deleteDocument', 'Admin::deleteDocument');
$routes->post('admin/deleteDocument/(:num)', 'Admin::deleteDocument/$1');




// Rute update kepala admin
$routes->post('adminDatakepala/updateKepalaBidang', 'AdminDatakepala::updateKepalaBidang');

$routes->get('adminDatakacab', 'AdminDatakacab::index');
$routes->post('adminDatakacab/updateKacab', 'AdminDatakacab::updateKacab');


$routes->get('/adminDatapengguna', 'AdminDatapengguna::index');
$routes->post('adminDatapengguna/updatePassword', 'AdminDatapengguna::updatePassword');
$routes->post('adminDatapengguna/deleteDocument', 'AdminDatapengguna::deleteDocument');


$routes->get('adminPenerima', 'AdminPenerima::index');
$routes->get('adminPenerima', 'AdminPenerima::index');
$routes->post('adminPenerima/updateNamapenerima', 'AdminPenerima::updateNamapenerima');
$routes->post('adminPenerima/deleteDocument', 'AdminPenerima::deleteDocument');
$routes->get('adminTambahpenerima', 'AdminTambahpenerima::index');
$routes->post('adminTambahpenerima/tambahData', 'AdminTambahpenerima::tambahData');




// Rute Forgot password
$routes->get('auth/forgotPassword', 'Auth::forgotPassword');

// Surat Pesanan
$routes->get('adminSuratpesanan', 'AdminSuratpesanan::index');
$routes->get('adminSuratpesanan/prosesSuratpesanan', 'AdminSuratpesanan::prosesSuratpesanan');
$routes->post('adminSuratpesanan/saveSuratpesanan', 'AdminSuratpesanan::saveSuratpesanan');
$routes->get('adminSuratpesanan/resetSuratpesanan', 'AdminSuratpesanan::resetSuratpesanan');


// Kontrak
$routes->get('adminKontrak', 'AdminKontrak::index');
$routes->get('adminKontrak/prosesKontrak', 'AdminKontrak::prosesKontrak');
$routes->post('adminKontrak/saveKontrak', 'AdminKontrak::saveKontrak');
$routes->get('adminKontrak/resetKontrak', 'AdminKontrak::resetKontrak');

// Spph
$routes->get('adminSpph', 'AdminSpph::index');
$routes->get('adminSpph/prosesSpph', 'AdminSpph::prosesSpph');
$routes->post('adminSpph/saveSpph', 'AdminSpph::saveSpph');
$routes->get('adminSpph/resetSpph', 'AdminSpph::resetSpph');


// UMK
$routes->get('adminUmk', 'AdminUmk::index');
$routes->get('adminUmk/prosesUmk', 'AdminUmk::prosesUmk');
$routes->post('adminUmk/saveUmk', 'AdminUmk::saveUmk');
$routes->get('adminUmk/resetUmk', 'AdminUmk::resetUmk');

//rekap
$routes->get('/rekapBulanan', 'RekapController::bulanan');
$routes->get('/rekapTahunan', 'RekapController::tahunan');

$routes->get('rekap/bulanan', 'RekapController::bulanan');
$routes->get('rekap/tahunan', 'RekapController::tahunan');
$routes->get('rekap/bulanan/excel', 'RekapController::exportToExcel');
$routes->get('rekap/tahunan/excel', 'RekapController::exportToExcelTahunan');


