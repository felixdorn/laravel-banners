<?php

use Delights\Banners\Generator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Spatie\Browsershot\Browsershot;

Route::get('/_/banners/generate', function (Request $request) {
    return Generator::make(
        $request->query('title') ?? config('banners.title'),
        $request->query('body') ?? config('banners.body'),
        $request->query('image') ?? config('banners.image'),
        $request->query('theme') ?? config('banners.theme'),
        $request->query('width') ?? config('banners.width'),
        $request->query('height') ?? config('banners.height')
    );
})->name('generate-banner');


Route::get('/_/banners/render', function (Request $request) {
    $request->validate(['payload' => 'required|json']);
    $data = json_decode($request->payload, true, 512);
    $data = array_merge(config('banners'), $data);

    return view('banners::render', $data);
})->name('render-banner');
