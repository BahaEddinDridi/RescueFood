<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\DemandeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\InventaireBeneficiaireController;
use App\Http\Controllers\ProduitAlimentaireController;
use App\Http\Controllers\CertificationController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\DonController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\RecommendationController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\InventaireDonateurController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\DemandeAdminController;
use App\Http\Controllers\Admin\EventAdminController;
use App\Http\Controllers\Admin\RecommendationAdminController;
use App\Http\Controllers\Admin\ProduitAdminController;
use App\Http\Controllers\Admin\DonAdminController;
use App\Http\Controllers\Admin\ReservationAdminController;
use App\Http\Controllers\Admin\FeedbackAdminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::resource('posts', PostController::class);
Route::resource('demandes', DemandeController::class);
Route::resource('inventaires-beneficiaires', InventaireBeneficiaireController::class);
Route::resource('reservations', ReservationController::class);
Route::resource('notifications', NotificationController::class);
Route::resource('recommendations', RecommendationController::class);
Route::resource('events', EventController::class);
Route::resource('feedbacks', FeedbackController::class);
Route::resource('Dons', DonController::class);
Route::resource('invertaireDonateurs', InventaireDonateurController::class);


Route::get('/', function () {
    return view('welcome');
});
// Route::get('/demandes', function () {

//     return view('demandes/index');
// });
Route::get('/hi', function () {

    return view('hi');
});

Route::get('/test', function () {

    return view('test');
});
Route::resource('produitAlimentaire', ProduitAlimentaireController::class)->middleware('auth');
Route::middleware('auth')->group(function () {
    Route::get('/mesProduits', [ProduitAlimentaireController::class, 'mesProduits'])
         ->name('produitAlimentaire.mesProduits');
});

Route::resource('certifications', CertificationController::class);

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    
    // User resource route
    Route::resource('users', UserController::class);
    
    // Demande resource route
    Route::resource('demandes', DemandeAdminController::class);
    Route::resource('events', EventAdminController::class);
    Route::resource('recommendations', RecommendationAdminController::class);
   
    Route::resource('produits', ProduitAdminController::class);
        // Définir la route d’approbation correctement
        Route::patch('produits/{id}/approuver', [ProduitAdminController::class, 'approuver'])
        ->name('produitAlimentaire.approuver');
    Route::resource('dons', DonAdminController::class);

    // Reservation resource route
    Route::resource('reservations', ReservationAdminController::class);

    // Feedback resource route
    Route::resource('feedbacks', FeedbackAdminController::class);
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::post('/posts/{post}/like', [PostController::class, 'toggleLike'])->name('posts.like');
Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');


