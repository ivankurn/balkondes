<?php
Route::get('/', 'C_Front@home');
Route::post('/pilih-rute', 'C_Front@pilihRute');
Route::post('/pesan', 'C_Front@pesan');
Route::post('/order', 'C_Front@order');


Route::any('pesan', 'C_Front@pesan');
Route::any('home', 'C_Home@kasir');
Route::any('kasir', 'C_Home@kasir');
Route::any('driver/{name}', 'C_Home@driver');
