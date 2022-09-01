<?php

use App\Http\Controllers\LivewireTestController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AlpineTestController;
use App\Http\Controllers\MyPageController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ReservationController;

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
    return view('calendar');
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

/* Gate の利用例
 * middleware('can:Gate名称')で、認可処理を行ってくれる
 */

/*
 * manager 以下のルートは、manager-higher のGate でtrue が返らないとアクセスできない
 * 認可が失敗した場合、403 エラーがレスポンスされる
 */
Route::prefix('manager')
->middleware('can:manager-higher')->group(function(){
    Route::get('index', function () {
        /* prefixがついているので、割当されるURLは /manager/index */
        dump('this user is manager role upper');
    });

    /* リソースルーティングにないURLは、resource() の呼び出しより先に書いておく(割当を吸われる可能性があるので) */
    Route::get('events/past', [EventController::class, 'past'])->name('events.past');

    /* event のリソースコントローラへのアクセス権はマネージャー以上に設定 */
    Route::resource('events', EventController::class);
});

/* user-higher のGate でtrue が返らないとアクセスできない */
Route::middleware('can:user-higher')
->group(function(){

    Route::get('/dashboard', [ReservationController::class, 'dashboard'])->name('dashboard');

    Route::get('/mypage', [MyPageController::class, 'index'])->name('mypage.index');
    Route::get('/mypage/{id}', [MyPageController::class, 'show'])->name('mypage.show');
    Route::post('/mypage/{id}', [MyPageController::class, 'cancel'])->name('mypage.cancel');

    // Route::get('/{event}', [ReservationController::class, 'detail'])->name('events.detail');
    Route::post('/{event}', [ReservationController::class, 'reserve'])->name('events.reserve');
});

Route::middleware('auth')->get('/{event}', [ReservationController::class, 'detail'])->name('events.detail');
