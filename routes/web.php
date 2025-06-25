<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BelajarController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\DashboardController;
use App\Models\Service;
use PHPUnit\Architecture\Services\ServiceContainer;

// Route::get('/', function () {
//     return view('welcome');
// });

// (/):default route
Route::get('/', [App\Http\Controllers\LoginController::class, 'login']);
Route::get('login', [App\Http\Controllers\LoginController::class, 'login'])->name('login');
Route::post('actionLogin', [App\Http\Controllers\LoginController::class, 'actionLogin'])->name('actionLogin');
Route::get('logout', [App\Http\Controllers\LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::resource('dashboard', App\Http\Controllers\DashboardController::class);

    //tYPE OF SERVICE
    Route::get('service', [DashboardController::class, 'indexService'])->name('service.index');
    Route::get('insert/service', [DashboardController::class, 'showInsService']);
    Route::post('service/store', [ServiceController::class, 'store'])->name('service.store');
    Route::get('service/edit/{id}', [ServiceController::class, 'edit'])->name('service.edit');
    Route::put('service/update/{id}', [ServiceController::class, 'update'])->name('service.update');
    Route::delete('service/softDelete/{id}', [ServiceController::class, 'softDelete'])->name('service.softDelete');
    Route::get('recycle/service', [ServiceController::class, 'recycle']);
    Route::get('service/restore/{id}', [ServiceController::class, 'restore'])->name('service.restore');
    Route::delete('service/destroy/{id}', [ServiceController::class, 'destroy'])->name('service.destroy');
});


// get:hanya bisa melihat dan membaca
// post:tambah dan dan ubah data(form)
// put : ubah data(form)
// delete:hapus data(form)

Route::get('belajar', [App\Http\Controllers\BelajarController::class, 'index']);
Route::get('tambah', [App\Http\Controllers\BelajarController::class, 'tambah'])->name('tambah');


//Table Counts
Route::get('data/hitungan', [BelajarController::class, 'viewHitungan'])->name('data.hitungan');
Route::get('edit/data-hitung/{id}', [BelajarController::class, 'editDataHitung'])->name('edit.data-hitung');
Route::put('update/tambahan/{id}', [BelajarController::class, 'updateTambahan'])->name('update.tambahan');
Route::delete('softDelete/data-hitung/{id}', [BelajarController::class, 'softDeleteTambahan'])->name('softDelete.data-hitung');


Route::get('duar/{id}', [App\Http\Controllers\BelajarController::class, 'update']);
Route::get('edit', [App\Http\Controllers\BelajarController::class, 'nuall']);

Route::post('tambah-action', [App\Http\Controllers\BelajarController::class, 'tambahAction'])->name('tambah-action');
