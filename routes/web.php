<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

/**
 * Jgn lupa tunnel/forward port
 */

Route::get('/', function () {
    return Inertia::render('Test');
})->name('home');

/**
 * Route ini buat request ke OnlineCompilernya, gak dri client biar gak kena CORS
 *
 * Jangan lupa register route ini ke OnlineCompilernya saat buat app, misal you-server.com/compile
 */
Route::get('/compile', function () {
    /**
     * W coba baca file, mungkin ajh bisa
     */
    $file = file_get_contents(storage_path('app/private/test.py'));
    $response = Http::withHeaders([
        'Authorization' => 'API KEY',
        'Accept' => 'application/json',
    ])->post('https://onlinecompiler.io/api/v2/run-code/', [
        'code' => 'print("test")',
        'input' => '5',
        'compiler' => 'python-3.9.7'
    ]);
    Log::info($response);
    Log::info($file);
})->name('compile');

Route::post('/hook', function (Request $request) {
    /**
     * Ini baru nyatet apa yang dikirim si OnlineCompilernya, belum diapa"in, klo mau liat tinggal liat logs (storage/logs)
     */
    Log::info($request->all());
})->withoutMiddleware(VerifyCsrfToken::class);


Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__ . '/settings.php';
