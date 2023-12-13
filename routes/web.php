<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\WhatsController;
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

Route::get('/', [WhatsController::class, 'index'])->name('chats.index');

/*
Route::get('/', function () {
    return view('welcome');
});
*/
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//Route::get('/chatindex', [WhatsController::class, 'index'])->name('chat.index');
Route::post('/sendMessage', [WhatsController::class, 'sendMessage'])->name('chat.send');
Route::get('/recibeMessage',[WhatsController::class, 'recibeMessage'])->name('chat.recibe');
//Route::get('/chats', [WhatsController::class, 'index'])->name('chats.index');
Route::get('/chats/{id}', [WhatsController::class, 'show'])->name('chats.show');

//routes of youtube verifyWebhook
Route::post('/send-message', [WhatsController::class, 'sendMessage'])->name('chat.send');
Route::get('/whatsaap-webhook', [WhatsController::class, 'verifyWebhook']);
Route::post('/whatsaap-webhook', [WhatsController::class, 'processWebhook']);

require __DIR__.'/auth.php';
