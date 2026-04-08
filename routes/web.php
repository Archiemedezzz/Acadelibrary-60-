<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Scholar\DashboardController;
use App\Http\Controllers\Scholar\DiscoverController;
use App\Http\Controllers\Librarian\DashboardController as LibrarianDashboardController;
use App\Http\Controllers\Librarian\DiscoverController as LibrarianDiscoverController;



Route::get('/', function () {
    return view('landing.index');
});



Route::middleware(['auth'])->group(function () {



    Route::prefix('scholar')
        ->middleware('role:scholar')
        ->name('scholar.')
        ->group(function () {

            Route::get('/dashboard', [DashboardController::class, 'index'])
                ->name('dashboard');

            Route::get('/discover', [DiscoverController::class, 'index'])
                ->name('discover');

            Route::get('/reading-log', [App\Http\Controllers\Scholar\ReadingLogController::class, 'index'])
                ->name('reading-log.index');

            Route::post('/borrow/{book}', [App\Http\Controllers\Scholar\BorrowController::class, 'borrow'])->name('borrow');
            Route::post('/folders', [App\Http\Controllers\Scholar\PersonalFolderController::class, 'store'])->name('folders.store');
            Route::post('/folders/add-book', [App\Http\Controllers\Scholar\PersonalFolderController::class, 'addBook'])->name('folders.addBook');

            Route::get('/help', function () {
                return view('scholar.help');
            })->name('help');

            Route::get('/feedback', function () {
                return view('scholar.feedback');
            })->name('feedback');
        });



    Route::prefix('librarian')
        ->middleware('role:librarian')
        ->name('librarian.')
        ->group(function () {

            Route::get('/dashboard', [LibrarianDashboardController::class, 'index'])
                ->name('dashboard');

            Route::get('/discover', [LibrarianDiscoverController::class, 'index'])
                ->name('discover');

            Route::get('/reading-log', [App\Http\Controllers\Librarian\ReadingLogController::class, 'index'])
                ->name('reading-log.index');

            Route::post('/borrow/{book}', [App\Http\Controllers\Scholar\BorrowController::class, 'borrow'])->name('borrow');
            Route::post('/folders', [App\Http\Controllers\Scholar\PersonalFolderController::class, 'store'])->name('folders.store');
            Route::post('/folders/add-book', [App\Http\Controllers\Scholar\PersonalFolderController::class, 'addBook'])->name('folders.addBook');

            Route::get('/manage-books', [App\Http\Controllers\Librarian\BookController::class, 'index'])->name('manage-books');
            Route::get('/manage-books/create', [App\Http\Controllers\Librarian\BookController::class, 'create'])->name('manage-books.create');
            Route::post('/manage-books', [App\Http\Controllers\Librarian\BookController::class, 'store'])->name('manage-books.store');
            Route::get('/manage-books/{book}', [App\Http\Controllers\Librarian\BookController::class, 'show'])->name('manage-books.show');
            Route::get('/manage-books/{book}/edit', [App\Http\Controllers\Librarian\BookController::class, 'edit'])->name('manage-books.edit');
            Route::put('/manage-books/{book}', [App\Http\Controllers\Librarian\BookController::class, 'update'])->name('manage-books.update');
            Route::delete('/manage-books/{book}', [App\Http\Controllers\Librarian\BookController::class, 'destroy'])->name('manage-books.destroy');

            Route::get('/manage-scholars', [App\Http\Controllers\Librarian\ScholarController::class, 'index'])->name('manage-scholars');
            Route::get('/manage-scholars/create', [App\Http\Controllers\Librarian\ScholarController::class, 'create'])->name('manage-scholars.create');
            Route::post('/manage-scholars', [App\Http\Controllers\Librarian\ScholarController::class, 'store'])->name('manage-scholars.store');
            Route::get('/manage-scholars/{scholar}/edit', [App\Http\Controllers\Librarian\ScholarController::class, 'edit'])->name('manage-scholars.edit');
            Route::get('/manage-scholars/{scholar}', [App\Http\Controllers\Librarian\ScholarController::class, 'show'])->name('manage-scholars.show');
            Route::put('/manage-scholars/{scholar}', [App\Http\Controllers\Librarian\ScholarController::class, 'update'])->name('manage-scholars.update');
            Route::delete('/manage-scholars/{scholar}', [App\Http\Controllers\Librarian\ScholarController::class, 'destroy'])->name('manage-scholars.destroy');

            Route::get('/circulations', [App\Http\Controllers\Librarian\CirculationController::class, 'index'])->name('circulations');
            Route::get('/circulations/create', [App\Http\Controllers\Librarian\CirculationController::class, 'create'])->name('circulations.create');
            Route::post('/circulations', [App\Http\Controllers\Librarian\CirculationController::class, 'store'])->name('circulations.store');
            Route::get('/circulations/{borrowing}', [App\Http\Controllers\Librarian\CirculationController::class, 'show'])->name('circulations.show');
            Route::patch('/circulations/{borrowing}/approve', [App\Http\Controllers\Librarian\CirculationController::class, 'approve'])->name('circulations.approve');
            Route::patch('/circulations/{borrowing}/reject', [App\Http\Controllers\Librarian\CirculationController::class, 'reject'])->name('circulations.reject');
            Route::patch('/circulations/{borrowing}/return', [App\Http\Controllers\Librarian\CirculationController::class, 'returnBook'])->name('circulations.return');

            Route::get('/reports', [App\Http\Controllers\Librarian\ReportController::class, 'index'])->name('reports');

            Route::get('/help', function () {
                return view('librarian.help');
            })->name('help');

            Route::get('/feedback', function () {
                return view('librarian.feedback');
            })->name('feedback');
        });



    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
