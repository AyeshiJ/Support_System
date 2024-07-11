<?php

use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});


Route::group(['prefix'=> 'ticket'], function(){
    Route::get('/all', [TicketController::class, 'index'])->name('ticket.index');
    Route::get('/create', [TicketController::class, 'create'])->name('ticket.create');
    Route::post('/store', [TicketController::class, 'store'])->name('ticket.store');
    Route::get('/{ticket_id}', [TicketController::class, 'edit'])->name('ticket.edit');
    Route::put('/{ticket_id}', [TicketController::class, 'update'])->name('ticket.update');
    Route::delete('/{ticket_id}', [TicketController::class, 'destroy'])->name('ticket.destroy');
    });

