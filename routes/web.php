<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;

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

Route::get('/', function(){ return redirect()->route('contacts.index'); });
Route::resource('contacts', ContactController::class);

Route::get('contacts-import', [ContactController::class, 'importForm'])->name('contacts.import.form');
Route::post('contacts-import', [ContactController::class, 'importXml'])->name('contacts.importXml');

