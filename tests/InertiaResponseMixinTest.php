<?php

use Illuminate\Support\Facades\Request;
use Inertia\Inertia;
use Inertia\SSRHead\HeadManager;

// app('view')->addLocation(__DIR__.'/stubs/views');

test('can add title with inertia response', function () {
    // dd(view('app'));
    $response = Inertia::render('TestPage')->title('Page title')->toResponse(request());
    dd($response);
});
