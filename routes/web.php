<?php

use Delights\Banners\Generator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Spatie\Browsershot\Browsershot;

Route::get('/_/banners/generate', function (Request $request) {
    return Generator::make(
        $request->query('title'),
        $request->query('body'),
        $request->query('image'),
    );
})->name('generate-banner');


Route::get('/_/banners/render', function (Request $request) {
    $data = json_decode($request->payload);

    return view('banners::render', $data);
})->name('render-banner');
