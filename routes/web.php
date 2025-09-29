<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\WorkController;
use App\Http\Controllers\CareerController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\ContactusController;
use App\Http\Controllers\Admin\AdminDashbordController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\SubjectController;

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
Route::controller(HomeController::class)->group(function () {
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






Route::controller(WorkController::class)->prefix('admin')->middleware('auth')->group(function () {
    // Show all works
    Route::get('/works', 'index')->name('admin.works.works');

    // Show form to create a new work
    Route::get('/add-work', 'create')->name('admin.works.add');

    // Store a new work
    Route::post('/works/add', 'store')->name('admin.works.store');

    // Show form to edit an existing work
    Route::get('/edit-work/{id}', 'edit')->name('admin.works.edit');

    // Update an existing work
    Route::put('/update-work/{id}', 'update')->name('admin.works.update');

    // Delete an existing work
    Route::delete('/delete-work/{id}', 'destroy')->name('admin.works.delete');
});

Route::controller(ServicesController::class)->prefix('admin')->middleware('auth')->group(function () {
    // Show all services
    Route::get('/services', 'index')->name('admin.services.list');

    // Show form to create a new service
    Route::get('/add-service', 'create')->name('admin.services.add');

    // Store a new service
    Route::post('/services/add', 'store')->name('admin.services.store');

    // Show form to edit an existing service
    Route::get('/edit-service/{id}', 'edit')->name('admin.services.edit');

    // Update an existing service
    Route::put('/update-service/{id}', 'update')->name('admin.services.update');

    // Delete an existing service
    Route::delete('/delete-service/{id}', 'destroy')->name('admin.services.delete');
});


Route::controller(CareerController::class)->prefix('admin')->middleware('auth')->group(function () {
    // List all careers
    Route::get('/careers', 'index')->name('admin.careers.list');

    // Show form to add new career
    Route::get('/add-career', 'create')->name('admin.careers.add');

    // Store new career
    Route::post('/careers/add', 'store')->name('admin.careers.store');

    // Show form to edit existing career
    Route::get('/edit-career/{id}', 'edit')->name('admin.careers.edit');

    // Update existing career
    Route::put('/update-career/{id}', 'update')->name('admin.careers.update');

    // Delete existing career
    Route::delete('/delete-career/{id}', 'destroy')->name('admin.careers.delete');
});


Route::post('/contacts', [ContactusController::class, 'store'])->name('landing.contacts.store');

Route::controller(ContactusController::class)->prefix('admin')->middleware('auth')->group(function () {
    // List all contact us entries
    Route::get('/contacts', 'index')->name('admin.contacts.list');

    // Store a new contact us entry
    Route::post('/contacts', 'store')->name('admin.contacts.store');

    // Show a specific contact us entry
    Route::get('/contacts/{id}', 'show')->name('admin.contacts.show');

    // Update a contact us entry
    Route::put('/contacts/{id}', 'update')->name('admin.contacts.update');

    // Delete a contact us entry
    Route::delete('/contacts/{id}', 'destroy')->name('admin.contacts.delete');
});
Route::controller(QuizController::class)->prefix('admin')->middleware('auth')->group(function () {
    // List all contact us entries
    Route::get('/quiz', 'QuizFormView')->name('quiz.formview');
    Route::post('/quiz', 'QuizFormStore')->name('quiz.store');
    Route::get('/allquiz', 'FetchallQuiz')->name('quiz.fetch');
    // Route::get('/admin/get-subjects/{classId}', [QuizController::class, 'getSubjectsByClass'])->name('quiz.getSubjects');
    Route::get('/get-subjects/{classId}', 'getSubjectsByClass')->name('quiz.getSubjects');
    

});
Route::controller(SubjectController::class)->prefix('admin')->middleware('auth')->group(function () {
    // List all contact us entries
    Route::get('/subjects', [SubjectController::class, 'index'])->name('subjects.index');
    //     Route::get('/subjects/create', [SubjectController::class, 'create'])->name('subjects.create');
    Route::post('/subjects', [SubjectController::class, 'store'])->name('subjects.store');
    Route::get('/class-subject', [SubjectController::class, 'ClassSubjView'])->name('class_subject.view');
    Route::post('/class-subject', [SubjectController::class, 'ClassSubjStore'])->name('class_subject.store');
    
});





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
