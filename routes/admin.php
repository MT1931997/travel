<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CountryController;
use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\AirplaneController;
use App\Http\Controllers\Admin\SearchController;
use App\Http\Controllers\Accounting\AccountController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\HotelController;
use App\Http\Controllers\Admin\TaskController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Reports\BookingReportController;
use App\Http\Controllers\Reports\UserReportController;
use App\Http\Controllers\SuperAdmin\ClientController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

use App\Http\Controllers\SuperAdmin\DashboardSuperController;
use App\Http\Controllers\SuperAdmin\LoginSuperController;

use Spatie\Permission\Models\Permission;
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

define('PAGINATION_COUNT',11);

// Super Admin Login Routes
Route::group(['namespace' => 'SuperAdmin', 'prefix' => 'super-admin', 'middleware' => 'guest:admin'], function () {
    Route::get('login', [LoginSuperController::class, 'show_login_view'])->name('superAdmin.showlogin');
    Route::post('login', [LoginSuperController::class, 'login'])->name('superAdmin.login');
});

// Super Admin Routes
Route::group(['prefix' => LaravelLocalization::setLocale(), 'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']], function () {
    Route::group(['prefix' => 'super-admin', 'middleware' => ['auth:admin', 'superAdmin']], function () {
        // Super Admin Dashboard
        Route::get('/', [DashboardSuperController::class, 'index'])->name('superAdmin.dashboard');
        Route::get('/logout', [LoginSuperController::class, 'logout'])->name('superAdmin.logout');

        // Manage Clients (Tenants)
        Route::resource('clients', ClientController::class); // Create, update, delete clients
        Route::get('clients/{id}/subscriptions', [ClientController::class, 'subscriptions'])->name('clients.subscriptions');
        Route::post('clients/{id}/subscriptions', [ClientController::class, 'storeSubscription'])->name('clients.storeSubscription');
        Route::get('endSubscription', [ClientController::class, 'endSubscription'])->name('endSubscriptions.index');

  });
});




// End Super Admin Route #########################################








// tenant routes
Route::group(['prefix' => LaravelLocalization::setLocale(), 'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']], function () {

    Route::middleware(['web',
    \Stancl\Tenancy\Middleware\InitializeTenancyByDomain::class,
    \Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains::class,
    ])->group(function () {

        Route::group(['prefix'=>'admin','middleware'=>'auth:admin'],function(){

            Route::get('/',[DashboardController::class,'index'])->name('admin.dashboard');
            Route::get('logout',[LoginController::class,'logout'])->name('admin.logout');

            //Search For Input Search and select
            Route::get('/search', [SearchController::class, 'search'])->name('search');
            Route::get('/getUserBookings/{user_id}', [SearchController::class, 'getUserBookings'])->name('getUserBookings');
            Route::get('/accounts/search', [AccountController::class, 'search'])->name('accounts.search');

            // for ajax
            Route::get('/country/search', [CountryController::class, 'search'])->name('api.countries.search');
            Route::get('/hotel/search', [HotelController::class, 'search'])->name('api.hotels.search');
            Route::get('/airplane/search', [AirplaneController::class, 'search'])->name('api.airplanes.search');
            Route::get('/users/search', [UserController::class, 'search'])->name('api.users.search');
            Route::get('/users/searchBrothers', [UserController::class, 'searchBrothers'])->name('users.searchBrothers');

            Route::get('/users/getUserFamily', [BookingController::class, 'getUserFamily'])->name('users.getUserFamily');
            Route::post('/bookings/delete-service}', [BookingController::class, 'deleteService'])->name('bookings.delete.service');
            Route::get('/bookings/create-or-edit/{booking?}', [BookingController::class, 'createOrEdit'])->name('bookings.createOrEdit');
            Route::post('/bookings/create-or-edit/{booking?}', [BookingController::class, 'save'])->name('bookings.save');
            Route::post('/bookings/create-service/{booking?}', [BookingController::class, 'createService'])->name('bookings.create.service');
            Route::post('/bookings/edit-service/{id}/{service_type?}/{booking_id?}', [BookingController::class, 'editService'])->name('bookings.edit.service');
            Route::post('/bookings/change-status', [BookingController::class, 'changeStatus'])->name('bookings.changeStatus');
            Route::get('/bookings/store-new-user', [BookingController::class, 'storeUser'])->name('user.store.modal');
            Route::post('/bookings/store-new-user', [BookingController::class, 'storeUser'])->name('user.store.modal');

            // Add company
            Route::post('/users/store-new-company', [CompanyController::class, 'storeCompany'])->name('company.store.modal');
            Route::get('/companies/search', [CompanyController::class, 'search'])->name('api.companies.search');

            // for each employee task
            Route::get('/employee/task/{status}', [TaskController::class, 'eachEmployeeTask'])->name('employee.task');


            /*         start  update login admin                 */
            Route::get('/admin/edit/{id}',[LoginController::class,'editlogin'])->name('admin.login.edit');
            Route::post('/admin/update/{id}',[LoginController::class,'updatelogin'])->name('admin.login.update');
            /*         end  update login admin                */

            /// Role and permission
            Route::resource('employee', 'App\Http\Controllers\Admin\EmployeeController',[ 'as' => 'admin']);
            Route::get('role', 'App\Http\Controllers\Admin\RoleController@index')->name('admin.role.index');
            Route::get('role/create', 'App\Http\Controllers\Admin\RoleController@create')->name('admin.role.create');
            Route::get('role/{id}/edit', 'App\Http\Controllers\Admin\RoleController@edit')->name('admin.role.edit');
            Route::patch('role/{id}', 'App\Http\Controllers\Admin\RoleController@update')->name('admin.role.update');
            Route::post('role', 'App\Http\Controllers\Admin\RoleController@store')->name('admin.role.store');
            Route::post('admin/role/destroy', 'App\Http\Controllers\Admin\RoleController@destroy')->name('admin.role.destroy');

            Route::get('/permissions/{guard_name}', function($guard_name){
                return response()->json(Permission::where('guard_name',$guard_name)->get());
            });

            // Notification
            Route::get('/notifications/eachEmployeeNotification',[NotificationController::class,'eachEmployeeNotification'])->name('notifications.index');
            Route::get('/notifications/create',[NotificationController::class,'create'])->name('notifications.create');
            Route::post('/notifications/send',[NotificationController::class,'send'])->name('notifications.send');


            // Reports
            Route::get('/reports/bookings', [BookingReportController::class, 'index'])->name('reports.bookings');
            Route::get('/reports/users', [UserReportController::class, 'index'])->name('reports.users');



            // Resource Route
            Route::resource('users', UserController::class);
            Route::resource('hotels', HotelController::class);
            Route::resource('countries', CountryController::class);
            Route::resource('airplanes', AirplaneController::class);
            Route::resource('companies', CompanyController::class);
            Route::resource('bookings', BookingController::class);
            Route::resource('tasks', TaskController::class);
            Route::resource('settings', SettingController::class);

            Route::get('/accounting/dashboard', [DashboardController::class, 'getAllModuleOfAccounting'])->name('accounting.dashboard');
            Route::get('/hr/dashboard', [DashboardController::class, 'getAllModuleOfHr'])->name('hr.dashboard');


            // Accounting and hr
            Route::resource('branches', 'App\Http\Controllers\BranchController');

            Route::resource('mainAccounts', 'App\Http\Controllers\Accounting\MainAccountController');
            Route::resource('journals', 'App\Http\Controllers\Accounting\JournalController');
            Route::resource('costCenters', 'App\Http\Controllers\Accounting\CostCenterController');
            Route::resource('accounts', 'App\Http\Controllers\Accounting\AccountController');
            Route::resource('invoiceTypes', 'App\Http\Controllers\Accounting\InvoiceTypeController');
            Route::resource('paymentTerms', 'App\Http\Controllers\Accounting\PaymentTermController');
            Route::resource('assets', 'App\Http\Controllers\Accounting\AssetController');
            Route::resource('creditCards', 'App\Http\Controllers\Accounting\CreditCardController');
            Route::resource('accountSettings', 'App\Http\Controllers\Accounting\AccountSettingController');
            Route::resource('suplierCategories', 'App\Http\Controllers\Accounting\SuplierCategoryController');
            Route::resource('supliers', 'App\Http\Controllers\Accounting\SuplierController');
            Route::resource('invoices', 'App\Http\Controllers\Accounting\InvoiceController');
            Route::resource('journalEntries', 'App\Http\Controllers\Accounting\JournalEntryController');
            Route::resource('payReceives', 'App\Http\Controllers\Accounting\PayReceiveController');
            Route::resource('checkPortfolios', 'App\Http\Controllers\Accounting\CheckPortfolioController');
            Route::resource('journalEntryCheques', 'App\Http\Controllers\Accounting\JournalEntryChequeController');


            Route::resource('shifts', 'App\Http\Controllers\Hr\ShiftController');
            Route::resource('holidays', 'App\Http\Controllers\Hr\HolidayController');
            Route::resource('rewards', 'App\Http\Controllers\Hr\RewardController');
            Route::resource('deductions', 'App\Http\Controllers\Hr\DeductionController');
            Route::resource('salaryCutoffs', 'App\Http\Controllers\Hr\SalaryCutoffController');
            Route::resource('allowanceOnSalarys', 'App\Http\Controllers\Hr\AllowanceOnSalaryController');
            Route::resource('pettyCashes', 'App\Http\Controllers\Hr\PettyCashController');
            Route::resource('permitTypes', 'App\Http\Controllers\Hr\PermitTypeController');
            Route::resource('employeeLoanPayments', 'App\Http\Controllers\Hr\EmployeeLoanPaymentController');
            Route::resource('hrmSettings', 'App\Http\Controllers\Hr\HrmSettingController');
            Route::resource('hr/employees', 'App\Http\Controllers\Hr\EmployeeController');
            Route::resource('addShiftToEmployees', 'App\Http\Controllers\Hr\AddShiftToEmployeeController');
            Route::resource('employeeAttendances', 'App\Http\Controllers\Hr\EmployeeAttendanceController');
            Route::resource('employeePermits', 'App\Http\Controllers\Hr\EmployeePermitController');
            Route::resource('employeeRewards', 'App\Http\Controllers\Hr\EmployeeRewardController');
            Route::resource('employeeDeductions', 'App\Http\Controllers\Hr\EmployeeDeductionController');
            Route::resource('employeeCutoffs', 'App\Http\Controllers\Hr\EmployeeCutoffController');
            Route::resource('employeeAllowanceOnSalaries', 'App\Http\Controllers\Hr\EmployeeAllowanceOnSalaryController');
            Route::resource('employeePettyCashes', 'App\Http\Controllers\Hr\EmployeePettyCashController');
            Route::resource('shiftHolidays', 'App\Http\Controllers\Hr\ShiftHolidayController');
            Route::resource('employeeLoans', 'App\Http\Controllers\Hr\EmployeeLoanController');
            Route::resource('employeeClearances', 'App\Http\Controllers\Hr\EmployeeClearanceController');

            Route::get('employees/fingerprint', 'App\Http\Controllers\Hr\EmployeeController@fingerprint')->name('employees.fingerprint');
            Route::post('employees/getMyLocationToFingerPrint','App\Http\Controllers\Hr\EmployeeController@getMyLocationToFingerPrint')->name('employees.getMyLocationToFingerPrint');

        });

    });
});

// tenant login routes
Route::middleware(['web',
    \Stancl\Tenancy\Middleware\InitializeTenancyByDomain::class,  // Ensure subdomains trigger tenant identification
    \Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains::class,  // Block central domain access to tenant routes
    ])->group(function () {

    Route::group(['namespace'=>'Admin','prefix'=>'admin','middleware'=>'guest:admin'],function(){
        Route::get('login',[LoginController::class,'show_login_view'])->name('admin.showlogin');
        Route::post('login',[LoginController::class,'login'])->name('admin.login');

    });

});







