<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;

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

// Owner
Route::get('dashboard', [EmployeeController::class, 'all_employee_record'])->middleware('owner')->name('dashboard');

Route::view("add-employee", 'add_employee')->middleware('owner');

Route::post('store-employee', [EmployeeController::class, 'store'])->middleware('owner');

Route::get('employees/records/{date}', [EmployeeController::class, 'all_employee_record'])->middleware('owner');

Route::get('employee/record/{id}', [EmployeeController::class, 'employee_record'])->middleware('owner');


//Employee
Route::get('login_as_employee', function () {
    return view('employee_login');
})->name('login_as_employee');

Route::post('employee-login', [EmployeeController::class, 'login']);

Route::get('employee', [EmployeeController::class, 'employee_home'])->middleware('employee')->name('employee');

Route::get('check-in', [EmployeeController::class, 'checkin'])->middleware('employee')->name('checkin');

Route::get('check-out', [EmployeeController::class, 'checkout'])->middleware('employee')->name('checkout');

require __DIR__.'/auth.php';
