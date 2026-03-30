<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\ComputerController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\NextpageController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\technicalController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ResponseController;
use App\Http\Controllers\QuestionerController;
use App\Http\Controllers\EquipmentTypeController;
use App\Http\Controllers\CustodianInfoController;   
use App\Http\Controllers\ErrorAndConcernController; 
use App\Http\Controllers\TypeErrorController; 
use App\Http\Controllers\SystemServerController; 
use App\Http\Controllers\DowntimeController; 
Route::post('/response/questioner', [ResponseController::class, 'questioner'])
    ->name('response.questioner');
//downtime
Route::get('downtime', [DowntimeController::class, 'index'])->name('downtime.index');
Route::post('downtime/fetch', [DowntimeController::class, 'fetch'])->name('downtime.fetch');
Route::post('downtime/save', [DowntimeController::class, 'save'])->name('downtime.save');
Route::post('downtime/info', [DowntimeController::class, 'info'])->name('downtime.info');
Route::post('downtime/delete', [DowntimeController::class, 'delete'])->name('downtime.delete');

//system server
Route::get('system_server', [SystemServerController::class, 'index'])->name('system_server.index');
Route::post('system_server/fetch', [SystemServerController::class, 'fetch'])->name('system_server.fetch');
Route::post('system_server/save', [SystemServerController::class, 'save'])->name('system_server.save');
Route::post('system_server/info', [SystemServerController::class, 'info'])->name('system_server.info');
Route::post('system_server/delete', [SystemServerController::class, 'delete'])->name('system_server.delete');




//type_error
Route::get('type_error', [TypeErrorController::class, 'index'])->name('type_error.index');
Route::post('type_error/fetch', [TypeErrorController::class, 'fetch'])->name('type_error.fetch');
Route::post('type_error/save', [TypeErrorController::class, 'save'])->name('type_error.save');
Route::post('type_error/info', [TypeErrorController::class, 'info'])->name('type_error.info');
Route::post('type_error/delete', [TypeErrorController::class, 'delete'])->name('type_error.delete');
//error_and_concern
Route::get('error_and_concern', [ErrorAndConcernController::class, 'index'])->name('error_and_concern.index');
Route::post('error_and_concern/fetch', [ErrorAndConcernController::class, 'fetch'])->name('error_and_concern.fetch');
Route::post('error_and_concern/save', [ErrorAndConcernController::class, 'save'])->name('error_and_concern.save');
Route::post('error_and_concern/info', [ErrorAndConcernController::class, 'info'])->name('error_and_concern.info');
Route::post('error_and_concern/delete', [ErrorAndConcernController::class, 'delete'])->name('error_and_concern.delete');

//sub category
Route::get('sub_category', [SubCategoryController::class, 'index'])->name('sub_category.index');
Route::post('sub_category/fetch', [SubCategoryController::class, 'fetch'])->name('sub_category.fetch');
Route::post('sub_category/save', [SubCategoryController::class, 'save'])->name('sub_category.save');
Route::post('sub_category/info', [SubCategoryController::class, 'info'])->name('sub_category.info');
Route::post('sub_category/delete', [SubCategoryController::class, 'delete'])->name('sub_category.delete');
//equipment type
Route::get('equipment_type', [EquipmentTypeController::class, 'index'])->name('equipment_type.index');
Route::post('equipment_type/fetch', [EquipmentTypeController::class, 'fetch'])->name('equipment_type.fetch');
Route::post('equipment_type/save', [EquipmentTypeController::class, 'save'])->name('equipment_type.save');
Route::post('equipment_type/info', [EquipmentTypeController::class, 'info'])->name('equipment_type.info');
Route::post('equipment_type/delete', [EquipmentTypeController::class, 'delete'])->name('equipment_type.delete');

//custodian info
Route::get('custodian_info/index', [CustodianInfoController::class, 'index'])->name('custodian_info.index');
Route::post('custodian_info/fetch', [CustodianInfoController::class, 'fetch'])->name('custodian_info.fetch');
Route::post('custodian_info/save', [CustodianInfoController::class, 'save'])->name('custodian_info.save');
Route::post('custodian_info/info', [CustodianInfoController::class, 'info'])->name('custodian_info.info');
Route::post('custodian_info/delete', [CustodianInfoController::class, 'delete'])->name('custodian_info.delete');


//employee
Route::get('employee/main', [EmployeeController::class, 'index'])->name('employee.main');
Route::post('employee/fetch', [EmployeeController::class, 'fetch'])->name('employee.fetch');
Route::post('employee/save', [EmployeeController::class, 'save'])->name('employee.save');
Route::post('employee/info', [EmployeeController::class, 'info'])->name('employee.info');
Route::post('employee/delete', [EmployeeController::class, 'delete'])->name('employee.delete');

Route::get('nextpage', [NextpageController::class, 'index'])->name('users.nextpage');
//technical

Route::get('technical', [TechnicalController::class, 'index'])->name('users.Technical');
Route::post('technical/fetch', [TechnicalController::class, 'fetch'])->name('technical.fetch');
Route::post('technical/save', [TechnicalController::class, 'save'])->name('technical.save');
Route::post('technical/info', [TechnicalController::class, 'info'])->name('technical.info');
Route::post('technical/delete', [TechnicalController::class, 'delete'])->name('technical.delete');
//response
Route::get('response', [ResponseController::class, 'index'])->name('response.index');
Route::post('/response/fetch', [ResponseController::class, 'fetch'])->name('response.fetch');
Route::post('/response/save', [ResponseController::class, 'save'])->name('response.save');
Route::post('/response/info', [ResponseController::class, 'info'])->name('response.info');
Route::post('/response/delete', [ResponseController::class, 'delete'])->name('response.delete');
Route::post('/response/staffs', [ResponseController::class, 'staffs'])->name('response.staffs');
Route::post('/response/ict_staffs', [ResponseController::class, 'ict_staffs'])->name('response.ict_staffs');
Route::post('/response/sections', [ResponseController::class, 'sections'])->name('response.sections');
Route::get('/response/pdf/{id}', [ResponseController::class, 'downloadPDF'])->name('response.pdf');
Route::prefix('users')->group(function () {
    Route::get('/', [UsersController::class, 'index'])->name('users.index');
    Route::get('/nextpage', [UsersController::class, 'nextpage'])->name('users.nextpage');
    Route::get('/dashboard', [UsersController::class, 'dashboard'])->name('users.dashboard');
    Route::get('/technical', [UsersController::class, 'technical'])->name('users.technical');
    Route::get('/fetch', [UsersController::class, 'fetch'])->name('users.fetch');
    Route::post('/save', [UsersController::class, 'save'])->name('users.save');
    Route::get('/info', [UsersController::class, 'info'])->name('users.info');
    Route::post('/delete', [UsersController::class, 'delete'])->name('users.delete');

});




Route::get('/computers', [ComputerController::class, 'index'])->name('computers.index');
Route::post('/add-brand', [ComputerController::class, 'store'])->name('computers.store');
Route::post('/update-brand/{id}', [ComputerController::class, 'update'])->name('computers.update');
Route::delete('/delete-brand/{id}', [ComputerController::class, 'destroy'])->name('computers.destroy');

// Brand routes
Route::get('/brands', [BrandController::class, 'index'])->name('brands.index');
Route::post('/brands/store', [BrandController::class, 'store'])->name('brands.store');
Route::post('/brands/update/{id}', [BrandController::class, 'update'])->name('brands.update');
Route::delete('/brands/destroy/{id}', [BrandController::class, 'destroy'])->name('brands.destroy');
Route::get('/dashboard', [BrandController::class, 'index']);

Route::get('/brands/fetch', [BrandController::class, 'fetch'])->name('brands.fetch');
// Questioner routes
Route::get('/questioner/index', [QuestionerController::class, 'index'])->name   ('questioner.index'); //initial load of page
Route::post('/questioner/fetch', [QuestionerController::class, 'fetch'])->name('questioner.fetch'); //fetching data for datatable
Route::post('/questioner/save', [QuestionerController::class, 'save'])->name('questioner.save'); //saving new questioner
Route::post('/questioner/info', [QuestionerController::class, 'info'])->name('questioner.info'); //fetching questioner info for editing
Route::post('/questioner/delete', [QuestionerController::class, 'delete'])->name('questioner.delete'); //deleting questioner


Route::get('/category/index', [CategoryController::class, 'index'])->name('categories.index'); //initial load of page
Route::post('/category/fetch', [CategoryController::class, 'fetch'])->name('category.fetch'); //fetching data for datatable
Route::post('/category/save', [CategoryController::class, 'save'])->name('category.save'); //saving new category
Route::post('/category/info', [CategoryController::class, 'info'])->name('category.info'); //fetching category info for editing
Route::post('/category/delete', [CategoryController::class, 'delete'])->name('category.delete'); //deleting category



Route::get('/dashboard', function () {
    return view('welcome');
})->name('dashboard');
