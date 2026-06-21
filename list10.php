<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\AppointmentController;

// ========== ПУБЛИЧНЫЕ СТРАНИЦЫ (доступны всем) ==========

// Главная страница
Route::get('/', [PageController::class, 'home'])->name('home');

// Страница услуг
Route::get('/services', [PageController::class, 'services'])->name('services');

// Страница мастеров
Route::get('/masters', [PageController::class, 'masters'])->name('masters');

// Страница контактов
Route::get('/contacts', [PageController::class, 'contacts'])->name('contacts');

// Форма записи
Route::get('/appointment/create', [AppointmentController::class, 'create'])->name('appointment.create');

// Сохранение записи
Route::post('/appointment', [AppointmentController::class, 'store'])->name('appointment.store');

// Страница успешной записи
Route::get('/appointment/success', [AppointmentController::class, 'success'])->name('appointment.success');

// Получение свободного времени (AJAX)
Route::get('/api/available-time/{masterId}/{date}', [AppointmentController::class, 'getAvailableTime']);

// ========== АДМИН-ПАНЕЛЬ (только для авторизованных администраторов) ==========

Route::middleware(['auth', 'admin'])->group(function () {
    
    // Список всех записей
    Route::get('/appointments', [AppointmentController::class, 'index'])->name('appointments.index');
    
    // Подтверждение записи
    Route::post('/appointment/{id}/confirm', [AppointmentController::class, 'confirm'])->name('appointment.confirm');
    
    // Отмена записи
    Route::post('/appointment/{id}/cancel', [AppointmentController::class, 'cancel'])->name('appointment.cancel');
    
    // Страница статистики
    Route::get('/statistics', [AppointmentController::class, 'statistics'])->name('statistics');
    
    // Страница логов изменений
    Route::get('/appointment-logs', [AppointmentController::class, 'logs'])->name('appointment.logs');
});

// ========== АВТОРИЗАЦИЯ (Laravel Breeze / Jetstream) ==========

require __DIR__.'/auth.php';