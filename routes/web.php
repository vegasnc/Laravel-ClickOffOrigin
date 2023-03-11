<?php

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
    return redirect()->route('login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/logout', [App\Http\Controllers\HomeController::class, 'logout'])->name('logout');

//start Test
Route::get('/test', [App\Http\Controllers\TestController::class, 'index'])->name('test');
//End test
Route::group(['prefix' => 'v1'], function () {
    Route::POST('/clientlist', 'App\Http\Controllers\ApiController@clientlist')->name('clientlist');

    Route::POST('/contactlist', 'App\Http\Controllers\ApiController@contactlist')->name('contactlist');
    Route::POST('/contactlocation', 'App\Http\Controllers\ApiController@contactlocation')->name('contactlocation');
    Route::POST('/clientiteamtype', 'App\Http\Controllers\ApiController@clientiteamtype')->name('clientiteamtype');

    Route::POST('/getEstimateProposal', 'App\Http\Controllers\ApiController@getEstimateProposal')->name('getEstimateProposal');

    Route::POST('/listmeter', 'App\Http\Controllers\ApiController@listmeter')->name('listmeter');
    Route::POST('/listmetercount', 'App\Http\Controllers\ApiController@listmetercount')->name('listmetercount');
    
    Route::POST('/getTotalRevenue', 'App\Http\Controllers\ApiController@getTotalRevenue')->name('getTotalRevenue');
    Route::POST('/getTotalAsset', 'App\Http\Controllers\ApiController@getTotalAsset')->name('getTotalAsset');

    Route::POST('/getTotalRevenueT', 'App\Http\Controllers\ApiController@getTotalRevenueT')->name('getTotalRevenueT');
    Route::POST('/getTotalAssetT', 'App\Http\Controllers\ApiController@getTotalAssetT')->name('getTotalAssetT');
    
    Route::POST('/getGoogleMap', 'App\Http\Controllers\ApiController@getGoogleMap')->name('getGoogleMap');

    Route::POST('/getBarChart', 'App\Http\Controllers\ApiController@getBarChart')->name('getBarChart');
    Route::POST('/getBarChartTotalRevenue', 'App\Http\Controllers\ApiController@getBarChartTotalRevenue')->name('getBarChartTotalRevenue');

    Route::get('/users', 'App\Http\Controllers\TestController@users')->name('users');

    Route::post('/create-users', 'App\Http\Controllers\TestController@createUsers')->name('apicreateEnv');

    Route::POST('/location', 'App\Http\Controllers\ApiController@locationAddress')->name('location');
});


Route::get('/index',[App\Http\Controllers\HomeController::class, 'showIndex']);

Route::get('/datacollection',[App\Http\Controllers\DatacollectionController::class, 'index'])->name('datacollection');
Route::get('/data-form',[App\Http\Controllers\DatacollectionController::class, 'dataform'])->name('data-form');
Route::post('/data-add',[App\Http\Controllers\DatacollectionController::class, 'dataadd'])->name('data-add');

Route::get('/data-edit/{id}',[App\Http\Controllers\DatacollectionController::class, 'dataedit'])->name('data-edit');
Route::post('/data-update/{id}',[App\Http\Controllers\DatacollectionController::class, 'dataupdate'])->name('data-update');

Route::post('/data-delete/{id}',[App\Http\Controllers\DatacollectionController::class, 'destroy'])->name('data-delete');