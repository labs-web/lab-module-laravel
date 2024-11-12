<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

require base_path('modules/pkg_articles/Routes/web.php');
require base_path('modules/GestionCategories/Routes/web.php');