<?php
Route::get('/', 'C_Front@home');
Route::post('/pilih-rute', 'C_Front@pilihRute');
Route::post('/pesan', 'C_Front@pesan');
Route::post('/order', 'C_Front@order');
Route::get('/tour/{id}', 'C_Front@tour');

Route::get('pesanan', 'C_Home@pesananBaru');
Route::post('pesanan', 'C_Home@pesananBaruPost');
Route::get('pesanan/baru', 'C_Home@pesananBaru');
Route::post('pesanan/baru', 'C_Home@pesananBaruPost');
Route::get('pesanan/selesai', 'C_Home@pesananSelesai');
Route::get('pesanan/hapus/{id_transaction}', 'C_Home@pesananHapus');
Route::post('pesanan/selesai', 'C_Home@pesananBaruPost');
Route::any('pesanan/diantar/{id_driver_schedule}', 'C_Home@updatePengantaranOnProcess');
Route::any('pesanan/selesai/{id_driver_schedule}', 'C_Home@updatePengantaranFinished');
Route::any('driver/{name}', 'C_Home@driverSchedule');
Route::any('driver/{name}/selesai', 'C_Home@driverScheduleFinished');

