<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\CargoController;
use App\Http\Controllers\ExploreController;
use App\Http\Controllers\DashboardController;
// Import Controller Admin
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminTicketController;
use App\Http\Controllers\Admin\AdminCargoController;
use App\Http\Controllers\Admin\AdminExploreController;
use App\Http\Controllers\Admin\AdminScheduleController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/tentang-kami', function () {
    return view('pages.tentang-kami');
})->name('tentang-kami');

Route::get('/informasi-bus', function () {
    return view('pages.informasi-bus');
})->name('informasi-bus');

Route::get('/kontak', function () {
    return view('pages.kontak');
})->name('kontak');

Route::get('/syarat-ketentuan', function () {
    return view('pages.syarat-ketentuan');
})->name('syarat-ketentuan');

// Dashboard Routes (User Biasa)
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ==========================================
    // TICKET ROUTES (USER)
    // ==========================================
    
    // 1. Halaman Seleksi (Menu antara Kursi vs Charter)
    Route::get('/tickets/selection', function () {
        return view('tickets.select_type');
    })->name('tickets.selection');

    // 2. Pemesanan Kursi (Pindahkan index lama ke sini atau tetap)
    Route::get('/tickets', [TicketController::class, 'index'])->name('tickets.index');
    
    // 3. Pemesanan Unit / Charter (Baru)
    Route::get('/tickets/charter', [TicketController::class, 'createCharter'])->name('tickets.charter');
    Route::get('/tickets/charter', [TicketController::class, 'charterIndex'])->name('tickets.charter.index');
    Route::post('/tickets/charter', [TicketController::class, 'storeCharter'])->name('tickets.charter.store');
    Route::patch('/charter/{id}/cancel', [TicketController::class, 'cancel'])->name('tickets.charter.cancel');
    Route::delete('/charter/{id}', [TicketController::class, 'destroy'])->name('tickets.charter.destroy');
    Route::get('/tickets/charter/{id}/download', [TicketController::class, 'download'])->name('tickets.charter.download');

    // Route Proses Ticket Umum
    Route::post('/tickets', [TicketController::class, 'store'])->name('tickets.store');
    Route::get('/tickets/payment/{id}', [TicketController::class, 'payment'])->name('tickets.payment');
    Route::post('/tickets/upload/{id}', [TicketController::class, 'uploadProof'])->name('tickets.upload');
    Route::delete('/tickets/{id}', [TicketController::class, 'destroy'])->name('tickets.destroy');
    Route::get('/tickets/download/{id}', [TicketController::class, 'download'])->name('tickets.download');

    // ==========================================
    // CARGO ROUTES (USER)
    // ==========================================
    Route::get('/cargos', [CargoController::class, 'index'])->name('cargos.index');
    Route::post('/cargos', [CargoController::class, 'store'])->name('cargos.store');
    Route::delete('/cargos/{id}', [CargoController::class, 'destroy'])->name('cargos.destroy');
    Route::get('/cargos/resi/{id}', [CargoController::class, 'downloadResi'])->name('cargos.download');

    // ==========================================
    // EXPLORE ROUTES (USER)
    // ==========================================
    Route::get('/explore', [ExploreController::class, 'index'])->name('explore.index');

    /**
     * ADMIN ROUTES
     */
    Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
        
        // 1. Dashboard Admin Utama
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::resource('/schedules', AdminScheduleController::class);

        // 2. Kontrol Kirana Ticket
        // Halaman Validasi & Cetak Manifest
        Route::get('/tickets', [AdminTicketController::class, 'index'])->name('tickets.index');
        
        // Route Input Harga Manual untuk Charter
        Route::patch('/tickets/{id}/set-price', [AdminTicketController::class, 'setCharterPrice'])->name('tickets.set_price');
        Route::post('/tickets/manual', [AdminTicketController::class, 'storeManual'])->name('tickets.store_manual');
        Route::get('/tickets/print', [AdminTicketController::class, 'printManifest'])->name('tickets.print');
        Route::patch('/tickets/{id}/validate', [AdminTicketController::class, 'validatePayment'])->name('tickets.validate');   

        // 3. Kontrol Kirana Cargo
        Route::get('/cargos', [AdminCargoController::class, 'index'])->name('cargos.index');
        Route::get('/cargos/{id}/edit', [AdminCargoController::class, 'edit'])->name('cargos.edit');
        Route::patch('/cargos/{id}/process', [AdminCargoController::class, 'processCargo'])->name('cargos.process'); 
        Route::patch('/cargos/{id}/update-tracking', [AdminCargoController::class, 'updateTracking'])->name('cargos.tracking');
        Route::get('/cargos/{id}/resi', [AdminCargoController::class, 'printResi'])->name('cargos.resi');
        Route::delete('/cargos/{id}', [AdminCargoController::class, 'destroy'])->name('cargos.destroy');

        // 4. Kontrol Kirana Explore
        Route::resource('/explore', AdminExploreController::class)->except(['show']);
    });
});

require __DIR__.'/auth.php';