<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::passkeys();

Route::get('/email/verify/{id}/{hash}', function (\Illuminate\Http\Request $request) {
    return redirect()->route('filament.app.auth.email-verification.verify', [
        'id' => $request->route('id'),
        'hash' => $request->route('hash'),
        'expires' => $request->query('expires'),
        'signature' => $request->query('signature'),
    ]);
})->middleware(['signed'])->name('verification.verify');

Route::get('/password-reset/reset', function (\Illuminate\Http\Request $request) {
    return redirect()->route('filament.app.auth.password-reset.reset', [
        'token' => $request->query('token'),
        'email' => $request->query('email'),
    ]);
})->name('password.reset');
