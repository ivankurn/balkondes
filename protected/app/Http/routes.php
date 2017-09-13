<?php
Route::any('/', 'C_Front@home');
Route::any('pesan', 'C_Front@pesan');
Route::any('home', 'C_Home@kasir');
Route::any('kasir', 'C_Home@kasir');
Route::any('driver/{name}', 'C_Home@driver');

