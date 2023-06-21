<?php

use App\Http\Controllers\usercontroller;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});
Route::get('register',[usercontroller::class,'registerView'])->name('registerView');
Route::post('register',[usercontroller::class,'register'])->name('register');

Route::get('login',[usercontroller::class,'loginView'])->name('loginview');
Route::post('login',[usercontroller::class,'login'])->name('login');

Route::get('country-state-city', [usercontroller::class, 'index']);
Route::post('get-states-by-country', [usercontroller::class, 'getState']);
Route::post('get-cities-by-state', [usercontroller::class, 'getCity']);

Route::get('studunt',[usercontroller::class,'studuntView'])->name('studuntview');

Route::get('studuntRegister',[usercontroller::class,'studuntRegisterview'])->name('studuntRegisterview');
Route::post('studuntRegister',[usercontroller::class,'studuntRegister'])->name('studuntRegister');

Route::get('edit/{id}',[usercontroller::class,'edit']);
Route::post('update',[usercontroller::class,'update'])->name('update');

Route::get('delete/{id}',[usercontroller::class,'delete']);





