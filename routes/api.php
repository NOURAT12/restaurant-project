<?php

use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\manager\AuthController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\manager\ManagerController;
use App\Http\Controllers\manager\ManagerFunctionsController;
use App\Http\Controllers\employee\EmployeeController;
use App\Http\Controllers\employee\EmployeeFunctionsController;
use App\Http\Controllers\customer\AuthCustomerController;
use App\Http\Controllers\customer\CustomerController;
use App\Http\Controllers\customer\CustomerFunctionsController;
use App\Http\Controllers\MealsController;
use App\Http\Controllers\VerifyController;
use App\Mail\TestMail;
use Illuminate\Http\Request;
use Illuminate\Routing\Route as RoutingRoute;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::post('register', function ($id) {

});


Route::controller(AuthController::class)->group(function () {
    Route::post('/register', 'register');
    Route::post('/resendotp', 'resendotp');
    Route::post('/verifyotp', 'verifyOtp');


});
Route::controller(ManagerController::class)->group(function () {
    Route::post('/login', 'login');
    Route::post('/createRestaurant', 'createRestaurant');
    Route::post('/update_restaurent', 'update_restaurent');
    Route::post('/addCategory', 'addCategory');
    Route::post('/updateCategory', 'updateCategory');
    Route::post('/deleteCategory', 'deleteCategory');
    Route::get('/displayCategory', 'displayCategory');
    Route::post('/add_meals', 'store_meal');
    Route::post('/delete_meal', 'delete_meal');
    Route::post('/update_meal', 'update_meal');
    Route::get('/displayMeals', 'displayMeals');
    Route::post('/addMenu', 'addMenu');
    Route::post('/dropMenu', 'dropMenu');
    Route::get('/displayMenu', 'displayMenu');
    Route::post('/addOffer', 'addOffer');
    Route::post('/deleteOffer', 'deleteOffer');
    Route::post('/activeOffer', 'activeOffer');
    Route::post('/unactiveOffer', 'unactiveOffer');
    Route::get('/displayOffers', 'displayOffers');
    Route::get('/getImage', 'getImage');
    Route::post('/createEmployee', 'createEmployee');
    Route::post('/changePasswordEmployee', 'changePasswordEmployee');
    Route::get('/displayEmployees', 'displayEmployees');
    Route::get('/logout', 'logout');

});
Route::controller(ManagerFunctionsController::class)->group(function () {
    Route::get('/displayWaitReservation', 'displayWaitReservation');
    Route::get('/displayWaitDoneReservation', 'displayWaitDoneReservation');
    Route::get('/displayAllReservation', 'displayAllReservation');
    Route::post('/setDoneReservation', 'setDoneReservation');
    Route::post('/setStateReservation', 'setStateReservation');
    Route::get('/displayWaitOrder', 'displayWaitOrder');
    Route::get('/displayAcceptOrder', 'displayAcceptOrder');
    Route::get('/displayRejectOrder', 'displayRejectOrder');
    Route::get('/displayAllOrder', 'displayAllOrder');
    Route::get('/displayTables', 'displayTables');
    Route::post('/closeOrOpenTable', 'closeOrOpenTable');
    Route::post('/acceptOrRejectOrder', 'acceptOrRejectOrder');

});
Route::prefix('admin')->controller(AdminController::class)->group(function () {
    Route::get('/displayRestaurantWait', 'displayRestaurantWait');
    Route::get('/displayAllRestaurant', 'displayAllRestaurant');
    Route::get('/displayUsers', 'displayUsers');
    Route::get('/displayEmployees', 'displayEmployees');
    Route::get('/displayManagers', 'displayManagers');
    Route::get('/displayblockedUsers', 'displayblockedUsers');
    Route::post('/acceptRestaurant', 'acceptRestaurant');
    Route::post('/rejectRestaurant', 'rejectRestaurant');
    Route::post('/blockUser', 'blockUser');
    Route::post('/unblockUser', 'unblockUser');
    Route::post('/setPayRestaurant', 'setPayRestaurant');
});

// Route::post('verificaton',[VerifyController::class,'sendVerificationEmail']);
// Route::post('register',[AuthController::class,'register']);
// Route::post('sendotp',[AuthController::class,'sendotp']);
// Route::post('verifyOtp',[AuthController::class,'verifyOtp']);
// Route::get('verify-email/{id}/{hash}',[VerifyController::class,'verify'])->name('verification.verify');

Route::controller(EmployeeController::class)->prefix('employee')->group(function () {
    Route::post('/login', 'login');
    Route::post('/createRestaurant', 'createRestaurant');
    Route::post('/update_restaurent', 'update_restaurent');
    Route::post('/addCategory', 'addCategory');
    Route::post('/updateCategory', 'updateCategory');
    Route::post('/deleteCategory', 'deleteCategory');
    Route::get('/displayCategory', 'displayCategory');
    Route::post('/add_meals', 'store_meal');
    Route::post('/delete_meal', 'delete_meal');
    Route::post('/update_meal', 'update_meal');
    Route::get('/displayMeals', 'displayMeals');
    Route::post('/addMenu', 'addMenu');
    Route::post('/dropMenu', 'dropMenu');
    Route::get('/displayMenu', 'displayMenu');
    Route::post('/addOffer', 'addOffer');
    Route::post('/deleteOffer', 'deleteOffer');
    Route::post('/activeOffer', 'activeOffer');
    Route::post('/unactiveOffer', 'unactiveOffer');
    Route::get('/displayOffers', 'displayOffers');
    Route::get('/getImage', 'getImage');
    Route::get('/logout', 'logout');

});

Route::controller(EmployeeFunctionsController::class)->prefix('employee')->group(function () {
    Route::get('/displayWaitReservation', 'displayWaitReservation');
    Route::get('/displayWaitDoneReservation', 'displayWaitDoneReservation');
    Route::get('/displayAllReservation', 'displayAllReservation');
    Route::post('/setDoneReservation', 'setDoneReservation');
    Route::post('/setStateReservation', 'setStateReservation');
    Route::get('/displayWaitOrder', 'displayWaitOrder');
    Route::get('/displayAcceptOrder', 'displayAcceptOrder');
    Route::get('/displayRejectOrder', 'displayRejectOrder');
    Route::get('/displayAllOrder', 'displayAllOrder');
    Route::get('/displayTables', 'displayTables');
    Route::post('/closeOrOpenTable', 'closeOrOpenTable');
    Route::post('/acceptOrRejectOrder', 'acceptOrRejectOrder');

});

Route::controller(AuthCustomerController::class)->prefix('customer')->group(function () {
    Route::post('/register', 'register');
    Route::post('/resendotp', 'resendotp');
    Route::post('/verifyotp', 'verifyOtp');
});


Route::controller(CustomerController::class)->prefix('customer')->group(function () {
    Route::post('/login', 'login');
    Route::get('/logout', 'logout');
    Route::get('/displayAllRestaurant', 'displayAllRestaurant');
    Route::post('/displayRestaurantInformation', 'displayRestaurantInformation');
    Route::post('/displayRestaurantDetails', 'displayRestaurantDetails');
    Route::post('/search', 'search');
    Route::get('/displayOffers', 'displayOffers');
    Route::post('/displayTable', 'displayTable');
    Route::post('/displayRestaurantOffers', 'displayRestaurantOffers');
    Route::post('/addRestaurantRate', 'addRestaurantRate');
    Route::post('/updateRestaurantRate', 'updateRestaurantRate');
    Route::post('/deleteRestaurantRate', 'deleteRestaurantRate');
    Route::post('/addMealRate', 'addMealRate');
    Route::post('/updateMealRate', 'updateMealRate');
    Route::post('/deleteMealRate', 'deleteMealRate');
    Route::post('/displayMenu', 'displayMenu');
    Route::post('/displayCategoryRestaurant', 'displayCategoryRestaurant');
    Route::post('/displayCategoryMeal', 'displayCategoryMeal');

});

Route::controller(CustomerFunctionsController::class)->prefix('customer')->group(function () {
    Route::post('/addReservation', 'addReservation');
    Route::post('/DeleteReservation', 'DeleteReservation');
    Route::post('/updateReservation', 'updateReservation');
    Route::get('/displayWaitReservation', 'displayWaitReservation');
    Route::get('/displayWaitDoneReservation', 'displayWaitDoneReservation');
    Route::get('/displayDoneReservation', 'displayDoneReservation');
    Route::get('/displayAllReservation', 'displayAllReservation');
    Route::post('/addOrder', 'addOrder');
    Route::post('/updateOrder', 'updateOrder');
    Route::post('/DeleteOrder', 'DeleteOrder');
    Route::get('/displayWaitOrder', 'displayWaitOrder');
    Route::get('/displayAcceptOrder', 'displayAcceptOrder');
    Route::get('/displayRejectOrder', 'displayRejectOrder');
    Route::get('/displayAllOrder', 'displayAllOrder');

});

