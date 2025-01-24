<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/{id}/{name}', function (int $id, string $name) {
//     //http://127.0.0.1:8000/1/luffy
//     return view('welcome', compact('id', 'name'));
// });

Route::get('/', function () {
    $names = ['a', 'b', 'c', 'd', 'e'];
    return view('welcome', compact('names'));
});
