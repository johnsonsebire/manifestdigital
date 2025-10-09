<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AiChatController;

Route::prefix('ai')->name('ai.')->group(function () {
    // AI Chat Routes
    Route::get('/chat', [AiChatController::class, 'index'])->name('chat');
    Route::post('/chat/message', [AiChatController::class, 'sendMessage'])->name('chat.message');
    Route::post('/chat/voice', [AiChatController::class, 'processVoice'])->name('chat.voice');
});