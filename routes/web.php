<?php

use App\Http\Controllers\LivewireTestController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AlpineTestController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

/* Livewireの動作確認用 */
Route::controller(LivewireTestController::class)
    ->prefix('livewire-test')->name('livewire-test.')->group(function () {
    /* 1つめのindex にはprefixで'livewire-test'が、
     * 2つめのindex にはRoute::controller() で LivewireTestController が自動的に付与される
     * name() も、これを囲んでいる 上の階層のRoute でname('livewire-test.') が含まれているので、
     * すべてのnameにlivewire-test. が先頭に付与される
     */
    Route::get('index', 'index')->name('index');
    Route::get('register', 'register')->name('register');
});

/* Alpine.js の動作確認用 */
Route::get('alpine-test/index', [AlpineTestController::class, 'index']);
