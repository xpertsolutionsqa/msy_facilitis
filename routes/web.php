<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AjaxController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BookingsController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\FacilityController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\LogsController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\CheckLogin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    dd('here');
    if (Auth::check())
        return redirect()->route('dashboard');
    if (Auth::guard('client')->check())
        return redirect()->route('facilities');
    
    return redirect()->route('login');
})->name('home');

Route::get('/login', [LoginController::class, 'show'])->name('login');
Route::post('/systemlogin', [LoginController::class, 'login'])->name('user.login');
Route::get('auth/redirect', [LoginController::class, 'redirectToProvider'])->name('auth.redirect');
Route::get('loginResult', [LoginController::class, 'handleProviderCallback'])->name('auth.callback');

Route::get('lang/{locale}', [LanguageController::class, 'switchLang'])->name('lang.switch');
Route::get('/mangelang', [LanguageController::class, 'manage'])->name('lang.manage');


Route::get('/dashboard', [Controller::class, 'showdashboard'])->middleware('check:user,login')->name('dashboard');

Route::post('/delete-notification', [AjaxController::class, 'deleteNotification'])->name('notification.delete');
Route::group(['middleware' => 'check:any'], function () {

    Route::get('/maintenance', [MaintenanceController::class, 'show'])->middleware('grid.or.list')->name('maintenance');

    Route::post('/createbooking', [BookingsController::class, 'create'])->name('booking.create');
    Route::post('/createfullbooking', [BookingsController::class, 'EmployeeCreate'])->name('booking.admincreate');
    Route::get('/facilities', [FacilityController::class, 'show'])->middleware(['grid.or.list'])->name('facilities');
    Route::get('/facility-details/{FaNumber}', [FacilityController::class, 'showDetails'])->name('facility.details');
    Route::get('/facility-edit/{FaNumber}', [FacilityController::class, 'showedit'])->name('facility.editpage');
    Route::post('/delete-facility', [FacilityController::class, 'delete'])->middleware('inlevel:1.6')->name('facility.delete');
    Route::post('/checkAvailablity', [AjaxController::class, 'checkAvailablity'])->name('bookings.checkAvailablity');
    Route::post('/getbookingDetails', [AjaxController::class, 'getBookingCardData'])->name('bookings.getDetails');
    Route::post('/getMaintenance', [AjaxController::class, 'getMaintenanceEvents'])->name('maintenance.get');
    Route::post('/getTemplate', [AjaxController::class, 'getTemplate'])->name('settings.showtemplate');
    Route::post('/saveTemplate', [AjaxController::class, 'saveTemplate'])->name('template.update');

    Route::post('/getEvents', [AjaxController::class, 'getEvents'])->name('bookings.get');
    Route::post('/getMyEvents', [AjaxController::class, 'getMyEvents'])->name('mybookings.get');
    Route::post('/user-showedit', [AjaxController::class, 'showEditUserModel'])->name('user.showedit');
    Route::post('/client-showedit', [AjaxController::class, 'showEditClientModel'])->name('client.showedit');

    Route::post('/min-showedit', [AjaxController::class, 'showEditMinModel'])->name('min.showedit');
    Route::post('/min-showdelete', [AjaxController::class, 'showDeleteMinModel'])->name('min.showdelete');
    Route::post('/client-showdelete', [AjaxController::class, 'showDeleteClientModel'])->name('client.showdelete');
    Route::post('/booking-showcancel', [AjaxController::class, 'showCancelbookingModel'])->name('booking.showcancel');
    Route::post('/booking-showedit', [AjaxController::class, 'showEditbookingModel'])->name('booking.showedit');
    Route::post('/checkLocation', [AjaxController::class, 'checkLocation'])->name('location.check');
    Route::post('/changeReq', [AjaxController::class, 'changeReqiuredValue'])->name('changeReq');
    Route::post('/changePer', [AjaxController::class, 'changeUserPermission'])->name('changePer');
    Route::post('/getTotals', [AjaxController::class, 'getDashboardTotals'])->name('getTotals');
    Route::post('/facility-showdelete', [AjaxController::class, 'showDeleteFacilityModel'])->name('facility.showdelete');
    Route::get('/mybookings', [BookingsController::class, 'show'])->middleware(['grid.or.list', 'check:client'])->name('mybookings');
    Route::get('/bookings', [BookingsController::class, 'show'])->middleware(['grid.or.list', 'check:user'])->name('bookings');
    Route::post('/changePass', [UserController::class, 'changePassword'])->middleware('check:client')->name('client.changepassword');
});



Route::group(['middleware' => 'inlevel:2.3.6'], function () {

    Route::get('/createnewfacility', [FacilityController::class, 'showcreate'])->middleware('inlevel:2')->name('createFacility');
    Route::post('/createfacility', [FacilityController::class, 'create'])->name('facility.create');
    Route::post('/removesubfacilityImage', [FacilityController::class, 'removesubImage'])->name('subimage.remove');
    Route::post('/createsubfacilityImage', [FacilityController::class, 'addsubImage'])->name('subimage.add');
    Route::post('/removefacilityImage', [FacilityController::class, 'removeImage'])->name('facility.removeimage');
    Route::post('/createfacilityImage', [FacilityController::class, 'addImage'])->name('facility.addimage');

    Route::post('/updatefacility', [FacilityController::class, 'update'])->name('facility.update');
    Route::post('/updatesubfacility', [FacilityController::class, 'updateSub'])->name('sub.edit');
    Route::post('/create-sub-facility', [FacilityController::class, 'createSub'])->name('subfacility.create');
    Route::post('/enable-facility', [FacilityController::class, 'enable'])->name('facility.enable');
    Route::post('/disable-facility', [FacilityController::class, 'disable'])->name('facility.disable');
    Route::post('/enable-sfacility', [FacilityController::class, 'enableSub'])->name('subfacility.enable');
    Route::post('/disable-sfacility', [FacilityController::class, 'disableSub'])->name('subfacility.disable');
});



Route::post('/create-maintenance', [MaintenanceController::class, 'create'])->name('maintenance.create');
Route::post('/edit-maintenance', [MaintenanceController::class, 'edit'])->name('maintenance.edit');
Route::post('/delete-maintenance', [MaintenanceController::class, 'delete'])->name('maintenance.delete');
Route::get('/booking-details/{bookingNumber}', [BookingsController::class, 'showDetails'])->name('booking.details');
Route::post('/cancel-booking', 'App\Http\Controllers\BookingsController@cancel')->name('booking.cancel');
Route::post('/edit-booking', [BookingsController::class, 'edit'])->name('booking.edit');
Route::post('/approve-booking', [BookingsController::class, 'approve'])->name('booking.approve');
Route::post('/reject-booking', 'App\Http\Controllers\BookingsController@reject')->name('booking.reject');



Route::group(['middleware' => 'inlevel:6'], function () { // Super Admin Routes


    Route::get('/logs', [Controller::class, 'showLogs'])->middleware('grid.or.list')->name('logs');
    Route::get('/reports', [Controller::class, 'showReports'])->middleware('grid.or.list')->name('reports');
    Route::get('/admins', [AdminController::class, 'showAdmins'])->name('admins');
    Route::get('/clients',  [UserController::class, 'show'])->name('clients');


    Route::post('/generate-report', [AjaxController::class, 'generateReport'])->name('report.generate');
    Route::post('/settings/sendTest', [AjaxController::class, 'sendTestMail'])->name('settings.sendtestmail');
    Route::get('/settings/facilityTypes', [SettingsController::class, 'showFacilityTypes'])->name('settings.facility.types');
    Route::get('/settings/subFacilityTypes', [SettingsController::class, 'showSubfacilityTypes'])->name('settings.subfacility.types');
    Route::get('/settings/notifications', [SettingsController::class, 'showNotification'])->name('settings.notifications');
    Route::get('/settings/attachments', [SettingsController::class, 'showattachments'])->name('settings.attachments');
    Route::get('/settings/languages', [LanguageController::class, 'manage'])->name('settings.languages');
    Route::post('/settings/savenotifications', [SettingsController::class, 'savenotifications'])->name('settings.notification.save');
    Route::post('/settings/saveattachemnts', [SettingsController::class, 'saveattachemnts'])->name('settings.attachemnts.save');
    Route::post('/settings/savefacilitytype', [SettingsController::class, 'savefacilitytype'])->name('settings.facilityType.save');
    Route::post('/settings/savesubfacilitytype', [SettingsController::class, 'savesubfacilitytype'])->name('settings.subfacilityType.save');
    Route::post('/toggle-facilityType', [SettingsController::class, 'facilityTypeChangeStatus'])->name('facility.type.toggle');
    Route::post('/toggle-subfacilityType', [SettingsController::class, 'subFacilityTypeChangeStatus'])->name('subfacility.type.toggle');
    Route::post('/update-FacilityType', [SettingsController::class, 'updateFacilityType'])->name('facility.type.update');
    Route::post('/update-SubFacilityType', [SettingsController::class, 'updateSubFacilityType'])->name('subfacility.type.update');
    Route::post('/disable-attachment', [SettingsController::class, 'disableAttachment'])->name('attachment.disable');
    Route::post('/enable-attachment', [SettingsController::class, 'enableAttachment'])->name('attachment.enable');
    Route::post('/update-attachment', [SettingsController::class, 'updateAttachment'])->name('attachment.update');

    Route::post('/settings/savelanguages', [LanguageController::class, 'save'])->name('settings.languages.save');
    Route::post('/settings/removelanguages', [LanguageController::class, 'remove'])->name('settings.languages.remove');


    Route::post('/reset-client', [UserController::class, 'reset'])->name('client.reset');
    Route::post('/enable-client', [UserController::class, 'enable'])->name('client.enable');
    Route::post('/disable-client', [UserController::class, 'disable'])->name('client.disable');
    Route::post('/edit-client', [UserController::class, 'editClient'])->name('client.edit');
    Route::post('/delete-client', [UserController::class, 'delete'])->name('client.delete');
    Route::post('/create-client', [UserController::class, 'create'])->name('client.create');

    Route::post('/create-user', [AdminController::class, 'create'])->name('user.create');
    Route::post('/edit-user', [AdminController::class, 'edit'])->name('user.edit');
    Route::post('/disable-user', [AdminController::class, 'disable'])->name('user.disable');
    Route::post('/enable-user', [AdminController::class, 'enable'])->name('user.enable');
});






Route::get('/terms&condtions', function () {
    return view('terms');
})->name('terms');


Route::get('/403', function () {
    return view('403');
})->name('403');

Route::post('/logout', function () {
    Auth::logout();
    return redirect()->route('login');
})->name('logout');
Route::post('/clientlogout', function () {
    Auth::guard('client')->logout();
    return redirect()->route('login');
})->name('client.logout');
