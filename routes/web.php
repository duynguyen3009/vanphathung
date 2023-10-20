<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HaigoKeyMeiController;
use App\Http\Controllers\HaigoKeyController;
use App\Http\Controllers\TokuisakiController;
use App\Http\Controllers\ShiireController;
use App\Http\Controllers\GanryoPumpController;
use App\Http\Controllers\HinmokuController;
use App\Http\Controllers\HanbaiKojoHinmokuController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::any('/', [\App\Http\Controllers\AuthController::class, 'store']);
Route::group(['middleware' => 'auth'], function () {
    Route::any('menu', function () {
        return view('menu');
    })->name('menu');
    Route::any('logout', [\App\Http\Controllers\AuthController::class, 'destroy'])->name('logout');

    Route::group([
        'prefix' => '/tokuisaki', 'as' => 'tokuisaki.'
    ], function () {
        Route::any('/', [TokuisakiController::class, 'index'])->name("index");
        Route::any('create', [TokuisakiController::class, 'create'])->name("create");
        Route::any('copy/{tokCd}/{tokCd2}', [TokuisakiController::class, 'copy'])->name("copy");
        Route::post('store', [TokuisakiController::class, 'store'])->name("store");
        Route::put('edit/{tokCd}/{tokCd2}', [TokuisakiController::class, 'update'])->name("update");
        Route::any('edit/{tokCd}/{tokCd2}', [TokuisakiController::class, 'edit'])->name("edit");
        Route::delete('delete/{tokCd}/{tokCd2}', [TokuisakiController::class, 'delete'])->name('delete');
        Route::any('add-item', [TokuisakiController::class, 'addItemGird'])->name('addItemGird');
    });

    Route::group([
        'name' => 'haigo_key', 'prefix' => '/haigo-key',
    ], function () {
        Route::any('/', [HaigoKeyController::class, 'index'])->name("haigo_key.index");
        Route::any('create', [HaigoKeyController::class, 'create'])->name("haigo_key.create");
        Route::any('edit/{haigoKey}', [HaigoKeyController::class, 'edit'])->name("haigo_key.edit");
        Route::any('copy/{haigoKey}', [HaigoKeyController::class, 'copy'])->name("haigo_key.copy");
        Route::post('save', [HaigoKeyController::class, 'save'])->name("haigo_key.save");
        Route::post('delete', [HaigoKeyController::class, 'delete'])->name("haigo_key.delete");

        Route::group(['prefix' => '{haigoKey}/haigo-key-mei', 'as' => 'haigo_key_mei.'], function () {
            Route::any('create', [HaigoKeyMeiController::class, 'create'])->name('create');
            Route::post('/', [HaigoKeyMeiController::class, 'store'])->name('store');
            Route::any('{hinCd}/{kikakuCd}/edit', [HaigoKeyMeiController::class, 'edit'])->name('edit');
            Route::put('{hinCd}/{kikakuCd}/edit', [HaigoKeyMeiController::class, 'update'])->name('update');
            Route::delete('{hinCd}/{kikakuCd}', [HaigoKeyMeiController::class, 'delete'])->name('delete');
        });

        Route::post('ajax-haigo-key-mei',
            [HaigoKeyMeiController::class, 'ajax'])->name('haigo_key_mei.ajax_m_haigo_key_mei');
    });

    Route::group(['name' => 'shiire', 'prefix' => '/shiire'], function () {
        Route::any('/', [ShiireController::class, 'index'])->name('shiire.index');
        Route::any('/create', [ShiireController::class, 'create'])->name('shiire.create');
        Route::any('/edit/{shiire_cd}', [ShiireController::class, 'edit'])->name('shiire.edit');
        Route::post('/store', [ShiireController::class, 'store'])->name('shiire.store');
        Route::post('/update', [ShiireController::class, 'update'])->name('shiire.update');
        Route::post('/delete', [ShiireController::class, 'delete'])->name('shiire.delete');
        Route::get('/shiire_ajax', [ShiireController::class, 'ajax'])->name('shiire.shiire_ajax');
    });

    Route::group(['prefix' => 'ganryo-pump', 'as' => 'ganryo_pump.'], function () {
        Route::any('/', [GanryoPumpController::class, 'index'])->name('index');
        Route::any('create', [GanryoPumpController::class, 'create'])->name('create');
        Route::any('{ktnCd}/{hinCd}/{kikakuCd}/{dispenserKbn}/edit',
            [GanryoPumpController::class, 'edit'])->name('edit');
        Route::any('{ktnCd}/{hinCd}/{kikakuCd}/{dispenserKbn}/copy',
            [GanryoPumpController::class, 'copy'])->name('copy');
        Route::post('store', [GanryoPumpController::class, 'store'])->name('store');
        Route::delete('delete', [GanryoPumpController::class, 'delete'])->name('delete');
        Route::post('ajax-ganryo-pump', [GanryoPumpController::class, 'ajax'])->name('ajax_ganryo_pump');
    });

    Route::group([
        'prefix' => '/hinmoku', 'as' => 'hinmoku.'
    ], function () {
        Route::any('/', [HinmokuController::class, 'index'])->name("index");
        Route::any('/create', [HinmokuController::class, 'create'])->name("create");
        Route::any('edit/{hinCd}', [HinmokuController::class, 'edit'])->name("edit");
        Route::any('copy/{hinCd}', [HinmokuController::class, 'copy'])->name("copy");
    });

    Route::group(['prefix' => 'hanbai-kojo-hinmoku', 'as' => 'hanbai_kojo_hinmoku.'], function () {
        Route::any('/', [HanbaiKojoHinmokuController::class, 'index'])->name("index");
        Route::any('spec', [HanbaiKojoHinmokuController::class, 'spec'])->name("spec");
    });
});
