<?php

use Ybzc\Laravel\Pay\PayController;

Route::prefix("/pay")->middleware(['web', 'auth', 'verified'])->group(function () {
    Route::get('/', [PayController::class, 'index'])->name('pay.index');
    Route::get('/show', [PayController::class, 'show'])->name('pay.show');
    Route::get('/create', [PayController::class, 'create'])->name('pay.create');
    Route::post('/store', [PayController::class, 'store'])->name('pay.store')
        ->middleware('rebind.request:'. \Ybzc\Laravel\Pay\StorePayRequest::class)
        ->middleware(\Ybzc\Laravel\Base\No::class);
    Route::get('/edit', [PayController::class, 'edit'])->name('pay.edit');
    Route::put('/update', [PayController::class, 'update'])->name('pay.update')
        ->middleware('rebind.request:'. \Ybzc\Laravel\Pay\UpdatePayRequest::class);
    Route::get('/export', [PayController::class, 'export'])->name('pay.export');
    Route::get('/components', [PayController::class, 'components'])->name('pay.components');
    Route::get('/config', [PayController::class, 'config'])->name('pay.config');
    Route::put('/config/update', [PayController::class, 'updateConfig'])->name('pay.config.update');
});
