<?php

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

Route::get('/', 'FrontEndController@index')->name('front');
Route::get('/'.env('URL_ROUTE','restaurant').'/{alias}', 'FrontEndController@restorant')->name('vendor');
Route::post('/search/location', 'FrontEndController@getCurrentLocation')->name('search.location');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//Route::group(['middleware' => 'auth'], function () {
Route::group(['middleware' => ['auth']], function () {
    Route::resource('user', 'UserController', ['except' => ['show']]);
    Route::post('/user/push', 'UserController@checkPushNotificationId');

    Route::resource('restorants', 'RestorantController');
    Route::post('/updateres/location/{restorant}', 'RestorantController@updateLocation');
    Route::get('/get/rlocation/{restorant}', 'RestorantController@getLocation');
    //Route::post('/updateres/radius/{restorant}', 'RestorantController@updateRadius');
    Route::post('/updateres/delivery/{restorant}', 'RestorantController@updateDeliveryArea');
    Route::post('/import/restaurants', 'RestorantController@import')->name('import.restaurants');
    Route::get('/restaurant/{restorant}/activate', 'RestorantController@activateRestaurant')->name('restaurant.activate');
    Route::post('/restaurant/workinghours', 'RestorantController@workingHours')->name('restaurant.workinghours');

    Route::resource('drivers', 'DriverController');
    Route::resource('clients', 'ClientController');
    Route::resource('orders', 'OrderController');

    Route::get('ordertracingapi/{order}', 'OrderController@orderLocationAPI');
    Route::get('liveapi', 'OrderController@liveapi');

    Route::get('live', 'OrderController@live');
    Route::get('/updatestatus/{alias}/{order}', ['as' => 'update.status', 'uses'=>'OrderController@updateStatus']);

    Route::resource('settings', 'SettingsController');

	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'ProfileController@update']);
    Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'ProfileController@password']);

    Route::resource('items', 'ItemsController');
    Route::get('/items/list/{restorant}', 'ItemsController@indexAdmin')->name('items.admin');
    Route::post('/import/items', 'ItemsController@import')->name('import.items');
    Route::post('/item/change/{item}', 'ItemsController@change');
    Route::post('/{item}/extras', 'ItemsController@storeExtras')->name('extras.store');
    Route::get('/extras/{extras}', 'ItemsController@showExtras')->name('extras.show');
    Route::get('/ingredients/{foodIngredientItem}', 'ItemsController@showIngredients')->name('ingredients.show');
    Route::post('/{item}/extras/edit', 'ItemsController@editExtras')->name('extras.edit');
    Route::delete('/{item}/extras/{extras}', 'ItemsController@deleteExtras')->name('extras.destroy');

    Route::post('/{item}/ingredients', 'ItemsController@storeIngredients')->name('ingredients.store');
    Route::post('/{item}/ingredients/edit', 'ItemsController@editIngredients')->name('ingredients.edit');

    Route::resource('categories', 'CategoriesController');

    Route::resource('addresses', 'AddressControler');
    //Route::post('/order/address','AddressControler@orderAddress')->name('order.address');
    Route::get('/new/address/autocomplete','AddressControler@newAddressAutocomplete');
    Route::post('/new/address/details','AddressControler@newAdressPlaceDetails');
    Route::post('/address/delivery','AddressControler@AddressInDeliveryArea');

    Route::post('/change/{page}', 'PagesController@change')->name('changes');

    Route::post('ckeditor/image_upload', 'CKEditorController@upload')->name('upload');
    Route::get('/payment','PaymentController@view')->name('payment.view');
    Route::post('/make/payment','PaymentController@payment')->name('make.payment');

    Route::get('/cart-checkout', 'CartController@cart')->name('cart.checkout');

    Route::resource('plans','PlansController');
});

Route::get('/footer-pages', 'PagesController@getPages');
Route::get('/cart-getContent', 'CartController@getContent')->name('cart.getContent');
Route::post('/cart-add', 'CartController@add')->name('cart.add');
Route::post('/cart-remove', 'CartController@remove')->name('cart.remove');
Route::get('/cart-update', 'CartController@update')->name('cart.update');
Route::get('/cartinc/{item}', 'CartController@increase')->name('cart.increase');
Route::get('/cartdec/{item}', 'CartController@decrease')->name('cart.decrease');


Route::post('/order', 'OrderController@store')->name('order.store');

/*Route for paypal payment method*/
Route::get('/status','OrderController@getPaymentStatus')->name('order.paypalpaymentstatus');

Route::resource('pages', 'PagesController');

Route::get('/login/google', 'Auth\LoginController@googleRedirectToProvider')->name('google.login');
Route::get('/login/google/redirect', 'Auth\LoginController@googleHandleProviderCallback');

Route::get('/login/facebook', 'Auth\LoginController@facebookRedirectToProvider')->name('facebook.login');
Route::get('/login/facebook/redirect', 'Auth\LoginController@facebookHandleProviderCallback');

Route::get('/new/restaurant/register', 'RestorantController@showRegisterRestaurant')->name('newrestaurant.register');
Route::post('/new/restaurant/register/store', 'RestorantController@storeRegisterRestaurant')->name('newrestaurant.store');

Route::get('phone/verify', 'PhoneVerificationController@show')->name('phoneverification.notice');
Route::post('phone/verify', 'PhoneVerificationController@verify')->name('phoneverification.verify');


Route::group(['middleware'=>'auth'],function (){
    //Extras Groups Routes
    Route::resource('extra-groups' , 'ExtraGroupController');
    //Ingredient Groups Routes
    Route::resource('ingredient-groups' , 'FoodIngredientController');
    Route::get('notification-alert','AdminController@showNotification')->name('notifications.index');
    Route::post('send-alert','AdminController@sendAlert')->name('notifications.send');
});

Route::get('/sendEmail','TestController@sendMail');
