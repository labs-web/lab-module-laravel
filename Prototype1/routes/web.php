<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

require base_path('app/Modules/GestionArticle/Routes/web.php');
require base_path('app/Modules/GestionCategories/Routes/web.php');