<?php

use Illuminate\Support\Facades\Route;
// use Nwidart\Modules\Facades\Module;


Route::get('/', function () {
    return view('welcome');
});


// Module::load('GestionArticle', 'Routes/web.php');
// Module::load('GestionCategories', 'Routes/web.php');