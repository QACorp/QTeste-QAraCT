<?php

use App\Modules\QAraCasosTeste\Controllers\QAraController;
use App\Modules\QAraCasosTeste\Controllers\QAraConfiguracaoController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => '/casos-teste'],function() {
    Route::group(['prefix' => '/'],function() {
        Route::get('/', [QAraController::class, 'index'])->name('caso-teste.qara.index');
        Route::post('/gerar-texto', [QAraController::class, 'gerarTexto'])->name('caso-teste.qara.gerar-texto');
        Route::post('/salvar', [QAraController::class, 'salvar'])->name('caso-teste.qara.salvar');
    });

});
Route::group(['prefix' => '/configuracao'],function() {
    Route::get('/', [QAraConfiguracaoController::class, 'index'])->name('caso-teste.qara.configuracao');
    Route::post('/', [QAraConfiguracaoController::class, 'salvar'])->name('caso-teste.qara.salvar-configuracao');

});


