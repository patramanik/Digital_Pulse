<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminDashbordController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider, and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/admin', function () {
    return view('admin');
});



Route::get('/', [HomeController::class, 'index']);
Route::controller(HomeController::class)->group(function (){
    Route::get('/', 'index');
    Route::get('/about', 'about');
    Route::get('/services', 'services');
    Route::get('/ourwork', 'ourwork');
    Route::get('/career', 'career');
    Route::get('/seo', 'seo');
    Route::get('/socialmedia', 'socialmedia');
    Route::get('/pragent', 'pragent');
    Route::get('/influencer', 'influencer');
    Route::get('/contact', 'contact');
});




// Route::controller(SubjectController::class)->group(function () {
//     Route::prefix('admin')->group(function () {
//         Route::get('/subject', 'index')->name('admin.subject.subject');
//         Route::get('/addSubject', 'create')->name('admin.subject.add-subject');
//         Route::Post('/subject/add', 'store');
//         Route::get('/edit-subject/{id}', 'edit')->name('admin.subject.edit-subject');
//         Route::put('/update-subject/{id}', 'update');
//         Route::delete('/delete-subject/{id}', 'deleteSubject');
//     });
// })->middleware('auth');




Route::post('/delete-commend/{id}', [AdminDashbordController::class, 'deletCommend'])
->middleware('auth')->name('deletecommend');

// Admin Routes
Route::get('admin', [AdminDashbordController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('admin');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::get('/search', [SearchController::class, 'index'])->name('search');


require __DIR__ . '/auth.php';

