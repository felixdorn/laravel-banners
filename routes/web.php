<?php

use Delights\Banners\Generator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Spatie\Browsershot\Browsershot;

Route::get('/_/banners/generate', function (Request $request) {
    $request->validate([
        'title' => 'required|string',
        'body' => 'required|string',
        'image' => 'required|string',
    ]);

    return Generator::make(
        $request->query('title'),
        $request->query('body'),
        $request->query('image'),
        $request->query('theme')
    );
})->name('generate-banner');


Route::get('/_/banners/render', function (Request $request) {
    $request->validate(['payload' => 'required|json']);
    $data = json_decode($request->payload, true, 512, JSON_THROW_ON_ERROR);

    return view('banners::render', $data);
})->name('render-banner');
