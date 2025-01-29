<?php

use App\Exports\EmployeeReportExport;
use App\Http\Controllers\AndonController;
use App\Http\Controllers\AndonnoController;
use App\Http\Controllers\AssignWOController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\AndonCatController;
use App\Http\Controllers\AndonReceivedController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\OperatorController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WorkOrderController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!!
|
*/


// OPERATOR MAIN RTM
Route::post('/validasi-operator', [OperatorController::class, 'store'])->name('operator.store');
Route::post('/validasi-andon', [OperatorController::class, 'storeAndon'])->name('operator.store.andon');
Route::post('/start-operator', [OperatorController::class, 'start'])->name('operator.start');
Route::post('/stop-operator', [OperatorController::class, 'stop'])->name('operator.stop');
Route::post('/continue-operator', [OperatorController::class, 'continue'])->name('operator.continue');
Route::post('/finish-operator', [OperatorController::class, 'finish'])->name('operator.finish');
Route::post('/close-operator', [OperatorController::class, 'close'])->name('operator.close');
Route::post('/storeAndonAcc', [OperatorController::class, 'storeAndonAcc'])->name('operator.storeAndonAcc');

// YAJRA OPERATOR
Route::get('/', [OperatorController::class, 'index'])->name('operator');
Route::get('/employeerun', [OperatorController::class, 'employeerun'])
    ->name('employeerun.data');
Route::get('/employeestop', [OperatorController::class, 'employeestop'])
    ->name('employeestop.data');

// Error page
Route::get('custom-404', function () {
    return view('errors.404');
})->name('custom.404');

Route::get('custom-403', function () {
    return view('errors.403');
})->name('custom.403');



Route::get('/workorder', function () {
    return view('wo/index');
});

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.auth');

Route::middleware(['auth', 'inactivityTimeout:1800'])->group(function () {
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');

    // Andon & ADMIN
    Route::middleware('role:Admin')->group(function () {
        Route::prefix('admin')->group(function () {

            Route::get('main', [DashboardController::class, 'index'])->name('dashboard');

            // User Employee
            Route::get('employee-list', [EmployeeController::class, 'index'])->name('employee.index');
            Route::get('employee-task', [EmployeeController::class, 'indextask'])->name('employee.indextask');
            Route::get('employee/create', [EmployeeController::class, 'create'])->name('employee.create');
            Route::post('employee', [EmployeeController::class, 'store'])->name('employee.store');
            Route::post('employee/cetak-barcode', [EmployeeController::class, 'cetakBarcode'])->name('employee.cetakBarcode');
            Route::get('employee/edit/{id}', [EmployeeController::class, 'edit'])->name('employee.edit');
            Route::put('employee/{id}', [EmployeeController::class, 'update'])->name('employee.update');
            Route::delete('employee/{id}', [EmployeeController::class, 'destroy'])->name('employee.destroy');
            Route::get('employee/{id}', [EmployeeController::class, 'showPhoto'])->name('employee.photo');

            // Work Order
            Route::get('workorder', [WorkOrderController::class, 'index'])->name('workorder.index');
            Route::get('workorder-barcode', [WorkOrderController::class, 'indexBarcode'])->name('workorder.indexBarcode');
            Route::get('workorder/create', [WorkOrderController::class, 'create'])->name('workorder.create');
            Route::post('workorder', [WorkOrderController::class, 'store'])->name('workorder.store');
            Route::post('workorder/cetak-barcode', [WorkOrderController::class, 'cetakcodeqr'])->name('workorder.cetakBarcode');
            Route::get('workorder/edit/{id}', [WorkOrderController::class, 'edit'])->name('workorder.edit');
            Route::put('workorder/{id}', [WorkOrderController::class, 'update'])->name('workorder.update');
            Route::delete('workorder/{id}', [WorkOrderController::class, 'destroy'])->name('workorder.destroy');
            Route::get('workorder/show/{id}', [WorkOrderController::class, 'showDetail'])->name('workorder.show');

            // Work Order Assign
            Route::get('workorder-assign', [AssignWOController::class, 'index'])->name('assignwo.index');
            Route::get('workorder-assign/create', [AssignWOController::class, 'create'])->name('assignwo.create');
            Route::post('workorder-assign', [AssignWOController::class, 'store'])->name('assignwo.store');
            Route::get('workorder-assign/edit/{OprID}', [AssignWOController::class, 'edit'])->name('assignwo.edit');
            Route::put('workorder-assign/{id}', [AssignWOController::class, 'update'])->name('assignwo.update');
            Route::delete('workorder-assign/{id}', [AssignWOController::class, 'destroy'])->name('assignwo.destroy');

            // Department
            Route::get('department', [DepartmentController::class, 'index'])->name('department.index');
            Route::get('department/create', [DepartmentController::class, 'create'])->name('department.create');
            Route::post('department', [DepartmentController::class, 'store'])->name('department.store');
            Route::get('department/edit/{id}', [DepartmentController::class, 'edit'])->name('department.edit');
            Route::put('department/{id}', [DepartmentController::class, 'update'])->name('department.update');
            Route::delete('department/{id}', [DepartmentController::class, 'destroy'])->name('department.destroy');

            // Import-export Work Order
            Route::post('workorder-import', [WorkOrderController::class, 'import'])->name('workorder.import');
            Route::get('workorder-export', [WorkOrderController::class, 'export'])->name('workorder.export');

            // Upload Image
            Route::post('upload-image', [EmployeeController::class, 'upload'])->name('upload-image');

            // ADMIN
            // User
            Route::get('/user', [UserController::class, 'index'])->name('user.index');
            Route::get('/user/create', [UserController::class, 'create'])->name('user.create');
            Route::post('/user', [UserController::class, 'store'])->name('user.store');
            Route::get('/user/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
            Route::put('/user/{id}', [UserController::class, 'update'])->name('user.update');
            Route::delete('/user/{id}', [UserController::class, 'destroy'])->name('user.destroy');

            // Role
            Route::get('/role', [RoleController::class, 'index'])->name('role.index');
            Route::get('/role/create', [RoleController::class, 'create'])->name('role.create');
            Route::post('/role', [RoleController::class, 'store'])->name('role.store');
            Route::get('/role/edit/{id}', [RoleController::class, 'edit'])->name('role.edit');
            Route::put('/role/{id}', [RoleController::class, 'update'])->name('role.update');
            Route::delete('/role/{id}', [RoleController::class, 'destroy'])->name('role.destroy');

            //Andon Cat
            Route::get('/andcat', [AndonCatController::class, 'index'])->name('andcat.index');
            Route::get('/andcat/edit/{id}', [AndonCatController::class, 'edit'])->name('andcat.edit');
            Route::put('andcat/{id}', [AndonCatController::class, 'update'])->name('andcat.update');
        });
    });


    Route::middleware('role:Admin|Andon')->group(function () {
        Route::prefix('andon')->group(function () {
            // Andon Received
            Route::get('index', [AndonReceivedController::class, 'index'])->name('andon.received');
            Route::get('history', [AndonReceivedController::class, 'historyAndon'])->name('andon.history');
            Route::post('save-to-session/{andonSerie}', [AndonReceivedController::class, 'saveToSession'])->name('save.to.session');
            Route::post('save-to-history/{andonSerie}', [AndonReceivedController::class, 'saveToSessionHistory'])->name('save.to.history');
            Route::put('index/serie/{andonSerie}', [AndonReceivedController::class, 'updateAndonReceived'])->name('update.andon.received');
            Route::put('index/{andonSerie}', [AndonReceivedController::class, 'updateAndonReceivedSolved'])->name('update.andon.received.solved');
            // Route::put('andon-close', [AndonReceivedController::class, 'andonModalClose'])->name('andon.modal.close');
            Route::get('export/exporthistory', [AndonReceivedController::class, 'andonexport'])->name('andon.export');

            // Andon no
            Route::get('andon', [AndonnoController::class, 'index'])->name('andon.index');
            Route::post('cetak-barcode', [AndonnoController::class, 'cetakBarcode'])->name('andon.cetakBarcode');
            Route::get('/filter-data', [AndonnoController::class, 'filterData'])->name('andon.filterData');

            // Andon Receive
            // Route::post('andon-received', [AndonController::class, 'index'])->name('andon.received');
        });
    });

    Route::middleware('role:Admin|Accounting')->group(function () {
        Route::prefix('report')->group(function () {
            Route::get('303', [ReportController::class, 'index'])->name('report.index');
            Route::post('303', [ReportController::class, 'report'])->name('report.report');
            Route::get('303/{WOnborig}/{date}/{department}', [ReportController::class, 'details'])->name('report.details');
           
            // Export Excel 
            Route::get('303/export/{WOnborig}/{date}/{workcenter}', [ReportController::class, 'exportreport'])->name('report.export');
            Route::get('export/{daterange}/{department}', [ReportController::class, 'exportwo'])->name('report.exportwo');

            // Export CSV
            Route::get('303/exportcsv/{WOnborig}/{date}/{workcenter}', [ReportController::class, 'exportreportcsv'])->name('report.exportcsv');
            Route::get('exportcsv/{daterange}/{department}', [ReportController::class, 'exportwocsv'])->name('report.exportwocsv');
        });
    });
});
