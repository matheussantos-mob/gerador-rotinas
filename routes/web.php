<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AtividadeController;

Route::get('/', function () {
    return redirect()->route('atividades.index');
});

Route::resource('atividades', AtividadeController::class);

Route::get('/gerar-rotina', [AtividadeController::class, 'gerarRotina'])->name('gerar-rotina');
