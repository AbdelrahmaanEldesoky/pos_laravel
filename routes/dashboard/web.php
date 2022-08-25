<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => LaravelLocalization::setLocale(), 'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']],
    function () {

            Route::prefix('dashboard')->name('dashboard.')->middleware(['auth'])->group(function () {

            Route::get('/', 'WelcomeController@index')->name('welcome');

            //category routes
            Route::resource('categories', 'CategoryController')->except(['show']);

            //product routes
            Route::resource('products', 'ProductController')->except(['show']);



            //client routes
                Route::resource('takeaway', 'Client\TakeawayController')->except(['show']);
                Route::resource('place', 'Client\PlaceController')->except(['show']);
            Route::resource('clients', 'ClientController')->except(['show']);
            Route::get('clients.type','ClientController@type')->name('type');
         //       Route::get('clients.place','ClientController@place')->name('clients.place');
            Route::resource('clients.orders', 'Client\OrderController')->except(['show']);
                Route::resource('clients.total', 'Client\totalController')->except(['show']);


                Route::resource('p', 'PrintController');

        //    Route::resource('place', 'Place\OrderController');
            //order routes
            Route::resource('orders', 'OrderController');
            Route::get('/orders/{order}/products', 'OrderController@products')->name('orders.products');


            //user routes
            Route::resource('users', 'UserController')->except(['show' , '__construct']);

            //report routes
                Route::get('report','ReportController@index')->name('report');

        });//end of dashboard routes
    });


