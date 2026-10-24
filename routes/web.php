<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\UserController;




Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
        Route::get('/chat',                  [ChatController::class, 'index'])->name('chat.index');
        Route::get('/chat/messages/{userId}',[ChatController::class, 'getMessages'])->name('chat.messages');
        Route::post('/chat/send',            [ChatController::class, 'send'])->name('chat.send');
        Route::delete('/chat/delete/{id}', [ChatController::class, 'delete']);
});

require __DIR__.'/auth.php';

Route::middleware('auth')->group(function(){
        Route::controller('ProfileController::class')->group(function(){
            Route::get('profile/edit/{id?}', 'edit')->name('profile.edit');
            // Route::post('');
        });
}); 


Route::middleware('auth')->group(function () {

    Route::controller(UserController::class)->group(function(){


            Route::get('/user', [User::class, 'index'])
            ->name('user');

        Route::get('/user/create/{id?}', [UserController::class, 'create'])
            ->name('user.create');

        

        Route::get('/user/datatable', [UserController::class,'datatable'])
                ->name('user.datatable');

        

          

            Route::match(['post', 'put'], '/user/save/{id?}', [UserController::class, 'save'])
            ->name('user.save');

            

    });

    
});