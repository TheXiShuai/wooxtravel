<?php

use Illuminate\Support\Facades\Route;


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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('auth:web');
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('index');


Route::group(['prefix' => 'traveling'], function () {
    Route::get('/about/{id}', [App\Http\Controllers\Traveling\TravelingController::class, 'about'])->name('traveling.about');


    //booking
    Route::get('/reservation/{id}', [App\Http\Controllers\Traveling\TravelingController::class, 'makeReservations'])->name('traveling.reservation');
    Route::post('/reservation/{id}', [App\Http\Controllers\Traveling\TravelingController::class, 'storeReservations'])->name('traveling.reservation.store');

    //Deals
    Route::any('/deals', [App\Http\Controllers\Traveling\TravelingController::class, 'deals'])->name('traveling.deals');
    Route::any('/search-deals', [App\Http\Controllers\Traveling\TravelingController::class, 'searchDeals'])->name('traveling.deals.search');
});


//users pages

Route::get('users/my-bookings', [App\Http\Controllers\Users\UsersController::class, 'bookings'])->name('users.bookings')->middleware('auth:web');



// admin panel 

Route::get('admin/login', [App\Http\Controllers\Admins\AdminsController::class, 'viewLogin'])->name('view.login')->middleware('check.for.login');
Route::post('admin/login', [App\Http\Controllers\Admins\AdminsController::class, 'checkLogin'])->name('check.login');

Route::group(['prefix' => 'admin', 'middleware' => 'auth:admin'], function () {


    Route::get('/index', [App\Http\Controllers\Admins\AdminsController::class, 'index'])->name('admins.dashboard');


    //admins
    Route::get('/all-admins', [App\Http\Controllers\Admins\AdminsController::class, 'allAdmins'])->name('admins.all.admins');
    Route::get('/create-admins', [App\Http\Controllers\Admins\AdminsController::class, 'createAdmins'])->name('admins.create');
    Route::post('/create-admins', [App\Http\Controllers\Admins\AdminsController::class, 'storeAdmins'])->name('admins.store');

    //countries
    Route::get('/all-countries', [App\Http\Controllers\Admins\AdminsController::class, 'allCountries'])->name('all.countries');
    Route::get('/create-countries', [App\Http\Controllers\Admins\AdminsController::class, 'createCountries'])->name('create.countries');
    Route::post('/create-countries', [App\Http\Controllers\Admins\AdminsController::class, 'storeCountries'])->name('store.countries');
    Route::get('/delete-countries/{id}', [App\Http\Controllers\Admins\AdminsController::class, 'deleteCountries'])->name('delete.countries');


    //cities

    Route::get('/all-cities', [App\Http\Controllers\Admins\AdminsController::class, 'allcities'])->name('all.cities');
    Route::get('/create-cities', [App\Http\Controllers\Admins\AdminsController::class, 'createCities'])->name('create.cities');
    Route::post('/create-cities', [App\Http\Controllers\Admins\AdminsController::class, 'storeCities'])->name('store.cities');
    Route::get('/delete-cities/{id}', [App\Http\Controllers\Admins\AdminsController::class, 'deleteCities'])->name('delete.cities');
});
