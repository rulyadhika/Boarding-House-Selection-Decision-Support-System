<?php

use App\Http\Livewire\Backend\Dashboard;
use App\Http\Livewire\Backend\Kost;
use App\Http\Livewire\Frontend\RankData;
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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::group(['prefix' => 'admin'], function () {
    Route::get('/', Dashboard::class);
    Route::get('/kost', Kost::class)->name('admin.kost');
});

Route::get('/', RankData::class);
