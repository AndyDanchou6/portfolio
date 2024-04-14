<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\BackgroundsController;
use App\Http\Controllers\PeopleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\ViewController;

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

Route::get('/', function () {
    return view('index');
})->name('index');

Route::get('/login', function () {
    return view('login');
})->name('login');

// Route::get('/contents/{}', function () {
//     return view('contents');
// })->name('contents');

Route::post('/login/post', [AuthController::class, 'login'])->name('login.post');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');


Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', function () {
        return view('adminPanel/adminDashboard');
    })->name('dashboard');

    Route::get('/projects', function () {
        return view('adminPanel/adminProjects');
    })->name('projects');

    Route::get('/backgrounds', function () {
        return view('adminPanel/adminBackgrounds');
    })->name('backgrounds');

    Route::get('/testimonials', function () {
        return view('adminPanel/adminTestimonials');
    })->name('testimonials');

    Route::get('/messages', function () {
        return view('adminPanel/adminMessages');
    })->name('messages');

    Route::get('/profile', [ViewController::class, 'adminProfile'])->name('profile');
    Route::post('/profile/update', [AboutController::class, 'update'])->name('profile.update');
    // Route::get('/profile', function () {
    //     return view('adminPanel.adminProfile');
    // })->name('profile');



    Route::post('/newProjects', [ProjectsController::class, 'store'])->name('projects.store');
    Route::patch('/api/updateProjects/{id}', [ProjectsController::class, 'update'])->name('projects.update');
    Route::get('/api/deleteProjects/{id}', [ProjectsController::class, 'delete'])->name('projects.delete');

    Route::post('/newBackgrounds', [BackgroundsController::class, 'store'])->name('backgrounds.store');
    Route::patch('/api/updateBackgrounds/{id}', [BackgroundsController::class, 'update'])->name('backgrounds.update');
    Route::get('/api/deleteBackgrounds/{id}', [BackgroundsController::class, 'delete'])->name('backgrounds.delete');

    Route::post('/newTestimonials', [PeopleController::class, 'store'])->name('testimonials.store');
    Route::patch('/api/updateTestimonials/{id}', [PeopleController::class, 'update'])->name('testimonials.update');
    Route::get('/api/deleteTestimonials/{id}', [PeopleController::class, 'delete'])->name('testimonials.delete');

    Route::post('/api/messages/store', [PeopleController::class, 'feedbackStore'])->name('feedback.store');
    Route::get('/api/messages/deleteAll', [PeopleController::class, 'deleteAll']);
    Route::get('/api/messages/updateAll', [PeopleController::class, 'updateAll']);
});


Route::post('/api/messages/store', [PeopleController::class, 'feedbackStore'])->name('feedback.store');
Route::get('/api/messages', [PeopleController::class, 'indexMessage']);

Route::get('/api/testimonials', [PeopleController::class, 'index']);
Route::get('/api/testimonials/{id}', [PeopleController::class, 'show']);

Route::get('/api/backgrounds', [BackgroundsController::class, 'index']);
Route::get('/api/backgrounds/{id}', [BackgroundsController::class, 'show']);

Route::get('/api/backgrounds', [BackgroundsController::class, 'index']);
Route::get('/api/backgrounds/{id}', [BackgroundsController::class, 'show']);

Route::get('/api/projects', [ProjectsController::class, 'index']);
Route::get('/api/projects/{id}', [ProjectsController::class, 'show']);

Route::get('/api/about', [AboutController::class, 'index']);
Route::get('/contents/{id}', [ProjectsController::class, 'contents'])->name('contents');
