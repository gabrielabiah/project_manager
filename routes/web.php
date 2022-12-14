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
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

Route::get(

  '/{slug}/invoices/{id}/pay', [
           'as' => 'pay.invoice',
           'uses' => 'InvoiceController@payinvoice',
       ]
);


Route::get('/', ['uses' => 'HomeController@landingPage'])->middleware(['XSS']);

Route::get('/home', ['as' => 'home','uses' =>'HomeController@index'])->middleware(['auth','XSS']);


Route::get('login/{lang?}', 'Auth\AuthenticatedSessionController@showLoginForm')->name('login
')->middleware(['XSS']);
Route::get('register/{lang?}', 'Auth\RegisteredUserController@showRegistrationForm')->name('register.form')->middleware(['XSS']);
Route::get('password/resets/{lang?}', 'Auth\AuthenticatedSessionController@showLinkRequestForm')->name('password.request.form')->middleware(['XSS']);

Route::prefix('client')->as('client.')->group(function() {
    Route::post('login', 'Auth\AuthenticatedSessionController@clientLogin')->name('login')->middleware(['XSS']);
    Route::get('login/{lang?}', 'Auth\AuthenticatedSessionController@showClientLoginForm')->name('login.form')->middleware(['XSS']);
    Route::post('logout', 'ClientController@clientLogout')->name('logout')->middleware(['auth:client','XSS']);
    Route::get('/my-account',['as' => 'users.my.account','uses' =>'UserController@account'])->middleware(['auth:client','XSS']);
    Route::post('/my-account/{id}',['as' => 'update.account','uses' =>'UserController@update'])->middleware(['auth:client','XSS']);
    Route::post('/my-account/password',['as' => 'update.password','uses' =>'UserController@updatePassword'])->middleware(['auth:client','XSS']);
    Route::post('/my-account/billing',['as' => 'update.billing','uses' =>'ClientController@updateBilling'])->middleware(['auth:client','XSS']);
    Route::delete('/my-account',['as' => 'delete.avatar','uses' =>'UserController@deleteAvatar'])->middleware(['auth:client','XSS']);

    // project
    Route::get('/{slug}/projects',['as' => 'projects.index','uses' =>'ProjectController@index'])->middleware(['auth:client','XSS']);
    Route::get('/{slug}/projects/{id}',['as' => 'projects.show','uses' =>'ProjectController@show'])->middleware(['auth:client','XSS']);
    Route::get('/{slug}/projects/milestone/{id}',['as' => 'projects.milestone','uses' =>'ProjectController@milestone'])->middleware(['auth:client','XSS']);
    Route::post('/{slug}/projects/milestone/{id}/store',['as' => 'projects.milestone.store','uses' =>'ProjectController@milestoneStore'])->middleware(['auth:client','XSS']);
    Route::get('/{slug}/projects/milestone/{id}/show',['as' => 'projects.milestone.show','uses' =>'ProjectController@milestoneShow'])->middleware(['auth:client','XSS']);
    Route::get('/{slug}/projects/milestone/{id}/edit',['as' => 'projects.milestone.edit','uses' =>'ProjectController@milestoneEdit'])->middleware(['auth:client','XSS']);
    Route::post('/{slug}/projects/milestone/{id}/update',['as' => 'projects.milestone.update','uses' =>'ProjectController@milestoneUpdate'])->middleware(['auth:client','XSS']);
    Route::delete('/{slug}/projects/milestone/{id}',['as' => 'projects.milestone.destroy','uses' =>'ProjectController@milestoneDestroy'])->middleware(['auth:client','XSS']);
    Route::get('/{slug}/projects/{id}/file/{fid}',['as' => 'projects.file.download','uses' =>'ProjectController@fileDownload'])->middleware(['auth:client','XSS']);

    // Task Board
    Route::get('/{slug}/projects/{id}/task-board',['as' => 'projects.task.board','uses' =>'ProjectController@taskBoard'])->middleware(['auth:client','XSS']);
    Route::get('/{slug}/projects/{id}/task-board/create',['as' => 'tasks.create','uses' =>'ProjectController@taskCreate'])->middleware(['auth:client','XSS']);
    Route::post('/{slug}/projects/{id}/task-board',['as' => 'tasks.store','uses' =>'ProjectController@taskStore'])->middleware(['auth:client','XSS']);
    Route::post('/{slug}/projects/{id}/task-board/order',['as' => 'tasks.update.order','uses' =>'ProjectController@taskOrderUpdate'])->middleware(['auth:client','XSS']);
    Route::get('/{slug}/projects/{id}/task-board/edit/{tid}',['as' => 'tasks.edit','uses' =>'ProjectController@taskEdit'])->middleware(['auth:client','XSS']);
    Route::post('/{slug}/projects/{id}/task-board/{tid}/update',['as' => 'tasks.update','uses' =>'ProjectController@taskUpdate'])->middleware(['auth:client','XSS']);
    Route::delete('/{slug}/projects/{id}/task-board/{tid}',['as' => 'tasks.destroy','uses' =>'ProjectController@taskDestroy'])->middleware(['auth:client','XSS']);
    Route::get('/{slug}/projects/{id}/task-board/{tid}/{cid?}',['as' => 'tasks.show','uses' =>'ProjectController@taskShow'])->middleware(['auth:client','XSS']);;

    Route::get('/{slug}/timesheet',['as' => 'timesheet.index','uses' =>'ProjectController@timesheet'])->middleware(['auth:client','XSS']);
    Route::get('/{slug}/timesheet-table-view', 'ProjectController@filterTimesheetTableView')->name('filter.timesheet.table.view')->middleware(['auth:client', 'XSS']);
    Route::get('/{slug}/timesheet/{id}',['as' => 'projects.timesheet.index','uses' =>'ProjectController@projectsTimesheet'])->middleware(['auth:client','XSS']);

    // Gantt Chart
    Route::get('/{slug}/projects/{id}/gantt/{duration?}',['as' => 'projects.gantt','uses' =>'ProjectController@gantt'])->middleware(['auth:client','XSS']);
    Route::post('/{slug}/projects/{id}/gantt',['as' => 'projects.gantt.post','uses' =>'ProjectController@ganttPost'])->middleware(['auth:client','XSS']);


    // bug report
    Route::get('/{slug}/projects/{id}/bug_report',['as' => 'projects.bug.report','uses' =>'ProjectController@bugReport'])->middleware(['auth:client','XSS']);
    Route::get('/{slug}/projects/{id}/bug_report/create',['as' => 'projects.bug.report.create','uses' =>'ProjectController@bugReportCreate'])->middleware(['auth:client','XSS']);
    Route::post('/{slug}/projects/{id}/bug_report',['as' => 'projects.bug.report.store','uses' =>'ProjectController@bugReportStore'])->middleware(['auth:client','XSS']);
    Route::post('/{slug}/projects/{id}/bug_report/order',['as' => 'projects.bug.report.update.order','uses' =>'ProjectController@bugReportOrderUpdate'])->middleware(['auth:client','XSS']);
    Route::get('/{slug}/projects/{id}/bug_report/{bid}/show',['as' => 'projects.bug.report.show','uses' =>'ProjectController@bugReportShow'])->middleware(['auth:client','XSS']);
    Route::get('/{slug}/projects/{id}/bug_report/{bid}/edit',['as' => 'projects.bug.report.edit','uses' =>'ProjectController@bugReportEdit'])->middleware(['auth:client','XSS']);
    Route::post('/{slug}/projects/{id}/bug_report/{bid}/update',['as' => 'projects.bug.report.update','uses' =>'ProjectController@bugReportUpdate'])->middleware(['auth:client','XSS']);
    Route::delete('/{slug}/projects/{id}/bug_report/{bid}',['as' => 'projects.bug.report.destroy','uses' =>'ProjectController@bugReportDestroy'])->middleware(['auth:client','XSS']);

    Route::get('/{slug}/searchJson/{search?}',['as' => 'search.json','uses' =>'ProjectController@getSearchJson'])->middleware(['auth:client','XSS']);
    Route::get('/userProjectJson/{id}',['as' => 'user.project.json','uses' =>'UserController@getProjectUserJson'])->middleware(['auth:client','XSS']);
    Route::get('/projectMilestoneJson/{id}',['as' => 'project.milestone.json','uses' =>'UserController@getProjectMilestoneJson'])->middleware(['auth:client','XSS']);

    Route::get('/{slug}/invoices',['as' => 'invoices.index','uses' =>'InvoiceController@index'])->middleware(['auth:client', 'XSS']);
    Route::get('/{slug}/invoices/{id}',['as' => 'invoices.show','uses' =>'InvoiceController@show'])->middleware(['auth:client', 'XSS']);
    Route::get('/{slug}/invoices/{id}/print',['as' => 'invoice.print','uses' =>'InvoiceController@printInvoice']);
    Route::post('/{slug}/invoices/{id}/payment',['as' => 'invoice.payment','uses' =>'InvoiceController@addPayment'])->middleware(['auth:client', 'XSS']);
    Route::get('/workspace/{id}',['as' => 'change-workspace','uses' =>'WorkspaceController@changeCurrentWorkspace'])->middleware('XSS');

    Route::get('/{slug}/calender/{id?}',['as' => 'calender.index','uses' =>'CalenderController@index'])->middleware(['auth:client','XSS']);




    Route::post('/{slug}/{id}/pay-with-paypal',['as' => 'pay.with.paypal','uses' =>'PaypalController@clientPayWithPaypal'])->middleware('XSS');
    Route::get('/{slug}/{id}/get-payment-status',['as' => 'get.payment.status','uses' =>'PaypalController@clientGetPaymentStatus'])->middleware('XSS');







    Route::get('/{slug?}', ['as' => 'home','uses' =>'HomeController@index'])->middleware(['auth:client','XSS']);

    //================================= Invoice Payment Gateways  ====================================//
    Route::post('/{slug}/invoice-pay-with-paystack/{invoice_id}',['as' => 'invoice.pay.with.paystack','uses' =>'PaystackPaymentController@invoicePayWithPaystack'])->middleware(['auth:client','XSS']);
    Route::get('/{slug}/invoice/paystack/{pay_id}/{invoice_id}', ['as' => 'invoice.paystack','uses' => 'PaystackPaymentController@getInvoicePaymentStatus'])->middleware(['auth:client']);

    Route::post('/{slug}/invoice-pay-with-flaterwave/{invoice_id}',['as' => 'invoice.pay.with.flaterwave','uses' =>'FlutterwavePaymentController@invoicePayWithFlutterwave'])->middleware(['auth:client','XSS']);
    Route::get('/{slug}/invoice/flaterwave/{txref}/{invoice_id}', ['as' => 'invoice.flaterwave','uses' => 'FlutterwavePaymentController@getInvoicePaymentStatus'])->middleware(['auth:client']);

    Route::post('/{slug}/invoice-pay-with-razorpay/{invoice_id}',['as' => 'invoice.pay.with.razorpay','uses' =>'RazorpayPaymentController@invoicePayWithRazorpay'])->middleware(['auth:client','XSS']);
    Route::get('/{slug}/invoice/razorpay/{txref}/{invoice_id}', ['as' => 'invoice.razorpay','uses' => 'RazorpayPaymentController@getInvoicePaymentStatus'])->middleware(['auth:client']);

    Route::post('/{slug}/invoice-pay-with-paytm/{invoice_id}',['as' => 'invoice.pay.with.paytm','uses' =>'PaytmPaymentController@invoicePayWithPaytm'])->middleware(['auth:client','XSS']);
    Route::post('/{slug}/invoice/paytm/{invoice}', ['as' => 'invoice.paytm','uses' => 'PaytmPaymentController@getInvoicePaymentStatus'])->middleware(['auth:client']);

    Route::post('/{slug}/invoice-pay-with-mercado/{invoice_id}',['as' => 'invoice.pay.with.mercado','uses' =>'MercadoPaymentController@invoicePayWithMercado'])->middleware(['auth:client','XSS']);
    Route::get('/{slug}/invoice/mercado/{invoice}', ['as' => 'invoice.mercado','uses' => 'MercadoPaymentController@getInvoicePaymentStatus'])->middleware(['auth:client']);

    Route::post('/{slug}/invoice-pay-with-mollie/{invoice_id}',['as' => 'invoice.pay.with.mollie','uses' =>'MolliePaymentController@invoicePayWithMollie'])->middleware(['auth:client','XSS']);
    Route::get('/{slug}/invoice/mollie/{invoice}', ['as' => 'invoice.mollie','uses' => 'MolliePaymentController@getInvoicePaymentStatus'])->middleware(['auth:client']);

    Route::post('/{slug}/invoice-pay-with-skrill/{invoice_id}',['as' => 'invoice.pay.with.skrill','uses' =>'SkrillPaymentController@invoicePayWithSkrill'])->middleware(['auth:client','XSS']);
    Route::get('/{slug}/invoice/skrill/{invoice}', ['as' => 'invoice.skrill','uses' => 'SkrillPaymentController@getInvoicePaymentStatus'])->middleware(['auth:client']);

    Route::post('/{slug}/invoice-pay-with-coingate/{invoice_id}',['as' => 'invoice.pay.with.coingate','uses' =>'CoingatePaymentController@invoicePayWithCoingate'])->middleware(['auth:client','XSS']);
    Route::get('/{slug}/invoice/coingate/{invoice}', ['as' => 'invoice.coingate','uses' => 'CoingatePaymentController@getInvoicePaymentStatus'])->middleware(['auth:client']);

    //================================= End Invoice Payment Gateways  ====================================//

    Route::get('/{slug}/zoom-meeting',['as' => 'zoom-meeting.index','uses' =>'ZoomMeetingController@index'])->middleware(['auth:client']);

});


// Calender
Route::get('/{slug}/calender/{id?}',['as' => 'calender.index','uses' =>'CalenderController@index'])->middleware(['auth','XSS']);

// Chats
Route::get('/{slug}/notification/seen',['as' => 'notification.seen','uses' =>'UserController@notificationSeen']);
// End Chats

Route::get('/settings',['as' => 'settings.index','uses' =>'SettingsController@index'])->middleware(['auth','XSS']);
Route::post('/settings',['as' => 'settings.store','uses' =>'SettingsController@store'])->middleware(['auth','XSS']);
Route::post('/email-settings',['as' => 'email.settings.store','uses' =>'SettingsController@emailSettingStore'])->middleware(['auth','XSS']);
Route::post('/pusher-settings',['as' => 'pusher.settings.store','uses' =>'SettingsController@pusherSettingStore'])->middleware(['auth','XSS']);
Route::get('/test',['as' => 'test.email','uses' =>'SettingsController@testEmail'])->middleware(['auth','XSS']);
Route::post('/test/send',['as' => 'test.email.send','uses' =>'SettingsController@testEmailSend'])->middleware(['auth','XSS']);

Route::get('/{slug}/clients',['as' => 'clients.index','uses' =>'ClientController@index'])->middleware(['auth','XSS']);
Route::post('/{slug}/clients/store',['as' => 'clients.store','uses' =>'ClientController@store'])->middleware(['auth','XSS']);
Route::get('/{slug}/clients/create',['as' => 'clients.create','uses' =>'ClientController@create'])->middleware(['auth','XSS']);
Route::get('/{slug}/clients/edit/{id}',['as' => 'clients.edit','uses' =>'ClientController@edit'])->middleware(['auth','XSS']);
Route::post('/{slug}/clients/{id}/update',['as' => 'clients.update','uses' =>'ClientController@update'])->middleware(['auth','XSS']);
Route::delete('/{slug}/clients/{id}',['as' => 'clients.destroy','uses' =>'ClientController@destroy'])->middleware(['auth','XSS']);
// User
Route::get('/usersJson/{id}',['as' => 'user.email.json','uses' =>'UserController@getUserJson'])->middleware(['auth','XSS']);
Route::get('/{slug}/searchJson/{search?}',['as' => 'search.json','uses' =>'ProjectController@getSearchJson'])->middleware(['auth','XSS']);
Route::get('/userProjectJson/{id}',['as' => 'user.project.json','uses' =>'UserController@getProjectUserJson'])->middleware(['auth','XSS']);
Route::get('/projectMilestoneJson/{id}',['as' => 'project.milestone.json','uses' =>'UserController@getProjectMilestoneJson'])->middleware(['auth','XSS']);
Route::get('/users',['as' => 'users.index.list','uses' =>'UserController@index'])->middleware(['auth','XSS']);
Route::get('/users/create',['as' => 'users.create','uses' =>'UserController@create'])->middleware(['auth','XSS']);
Route::post('/users/store',['as' => 'users.store','uses' =>'UserController@store'])->middleware(['auth','XSS']);
Route::delete('/users/{id}',['as' => 'users.delete','uses' =>'UserController@destroy'])->middleware(['auth','XSS']);

Route::get('/resetpassword/{id}',['as' => 'users.reset.password','uses' =>'UserController@resetPassword'])->middleware(['auth','XSS']);
Route::post('/changepassword/{id}',['as' => 'users.change.password','uses' =>'UserController@changePassword'])->middleware(['auth','XSS']);

Route::get('/{slug}/users',['as' => 'users.index','uses' =>'UserController@index'])->middleware(['auth','XSS']);
Route::get('/{slug}/users/invite',['as' => 'users.invite','uses' =>'UserController@invite'])->middleware(['auth','XSS']);
Route::post('/{slug}/users/invite',['as' => 'users.invite.update','uses' =>'UserController@inviteUser'])->middleware(['auth','XSS']);
Route::get('/{slug}/users/{id}/edit',['as' => 'users.edit','uses' =>'UserController@edit'])->middleware(['auth','XSS']);
Route::post('/{slug}/users/{id}/update',['as' => 'users.update','uses' =>'UserController@update'])->middleware(['auth','XSS']);
Route::delete('/{slug}/users/{id}',['as' => 'users.remove','uses' =>'UserController@removeUser'])->middleware(['auth','XSS']);
Route::get('/my-account',['as' => 'users.my.account','uses' =>'UserController@account'])->middleware(['auth','XSS']);
Route::post('/my-account/{id}',['as' => 'update.account','uses' =>'UserController@update'])->middleware(['auth','XSS']);
Route::post('/my-account/password',['as' => 'update.password','uses' =>'UserController@updatePassword'])->middleware(['auth','XSS']);
Route::delete('/my-account',['as' => 'delete.avatar','uses' =>'UserController@deleteAvatar'])->middleware(['auth','XSS']);
Route::delete('/delete-my-account',['as' => 'delete.my.account','uses' =>'UserController@deleteMyAccount'])->middleware(['auth','XSS']);
// Lang

Route::get('/admin/change_lang/{lang}',['as' => 'change_lang_admin','uses' =>'WorkspaceController@changeLangAdmin'])->middleware(['auth','XSS']);

// Route::get('/workspace/{slug}/change_lang/{lang}',['as' => 'change_langua_workspace','uses' =>'WorkspaceController@changeLangWorkspace'])->middleware(['auth:client','XSS']);
Route::get('/workspace/{slug}/change_lang/{lang}',['as' => 'change_lang_workspace','uses' =>'WorkspaceController@changeLangWorkspace'])->middleware(['auth','XSS']);
Route::get('/workspace/{slug}/change_lang1/{lang}',['as' => 'change_lang_workspace1','uses' =>'WorkspaceController@changeLangWorkspace1'])->middleware(['auth:client','XSS']);
Route::get('/workspace/lang/create',['as' => 'create_lang_workspace','uses' =>'WorkspaceController@createLangWorkspace'])->middleware(['auth','XSS']);
Route::get('/workspace/lang/{lang?}',['as' => 'lang_workspace','uses' =>'WorkspaceController@langWorkspace'])->middleware(['auth','XSS']);
Route::post('/workspace/lang/{lang}',['as' => 'store_lang_data_workspace','uses' =>'WorkspaceController@storeLangDataWorkspace'])->middleware(['auth','XSS']);
Route::post('/workspace/lang',['as' => 'store_lang_workspace','uses' =>'WorkspaceController@storeLangWorkspace'])->middleware(['auth','XSS']);

// Workspace
Route::get('/workspace/{slug}/settings',['as' => 'workspace.settings','uses' =>'WorkspaceController@settings'])->middleware(['auth','XSS']);
Route::post('/workspace/{slug}/settings',['as' => 'workspace.settings.store','uses' =>'WorkspaceController@settingsStore'])->middleware(['auth','XSS']);
Route::post('/workspace',['as' => 'add-workspace','uses' =>'WorkspaceController@store'])->middleware(['auth','XSS']);
Route::delete('/workspace/{id}',['as' => 'delete-workspace','uses' =>'WorkspaceController@destroy'])->middleware(['auth','XSS']);
Route::delete('/workspace/leave/{id}',['as' => 'leave-workspace','uses' =>'WorkspaceController@leave'])->middleware(['auth','XSS']);
Route::get('/workspace/{id}',['as' => 'change-workspace','uses' =>'WorkspaceController@changeCurrentWorkspace'])->middleware(['auth','XSS']);
// project
Route::get('/{slug}/projects',['as' => 'projects.index','uses' =>'ProjectController@index'])->middleware(['auth','XSS']);
Route::get('/{slug}/projects/create',['as' => 'projects.create','uses' =>'ProjectController@create'])->middleware(['auth','XSS']);
Route::get('/{slug}/projects/{id}',['as' => 'projects.show','uses' =>'ProjectController@show'])->middleware(['auth','XSS']);
Route::post('/{slug}/projects/store',['as' => 'projects.store','uses' =>'ProjectController@store'])->middleware(['auth','XSS']);
Route::get('/{slug}/projects/edit/{id}',['as' => 'projects.edit','uses' =>'ProjectController@edit'])->middleware(['auth','XSS']);
Route::post('/{slug}/projects/{id}/update',['as' => 'projects.update','uses' =>'ProjectController@update'])->middleware(['auth','XSS']);
Route::delete('/{slug}/projects/{id}',['as' => 'projects.destroy','uses' =>'ProjectController@destroy'])->middleware(['auth','XSS']);
Route::delete('/{slug}/projects/leave/{id}',['as' => 'projects.leave','uses' =>'ProjectController@leave'])->middleware(['auth','XSS']);
Route::get('/{slug}/projects/invite/{id}',['as' => 'projects.invite.popup','uses' =>'ProjectController@popup'])->middleware(['auth','XSS']);
Route::get('/{slug}/projects/{id}/user/{uid}/permission',['as' => 'projects.user.permission','uses' =>'ProjectController@userPermission'])->middleware(['auth','XSS']);
Route::post('/{slug}/projects/{id}/user/{uid}/permission',['as' => 'projects.user.permission.store','uses' =>'ProjectController@userPermissionStore'])->middleware(['auth','XSS']);
Route::delete('/{slug}/projects/{id}/user/{uid}',['as' => 'projects.user.delete','uses' =>'ProjectController@userDelete'])->middleware(['auth','XSS']);
Route::get('/{slug}/projects/share/{id}',['as' => 'projects.share.popup','uses' =>'ProjectController@sharePopup'])->middleware(['auth','XSS']);
Route::get('/{slug}/projects/{id}/client/{uid}/permission',['as' => 'projects.client.permission','uses' =>'ProjectController@clientPermission'])->middleware(['auth','XSS']);
Route::post('/{slug}/projects/{id}/client/{uid}/permission',['as' => 'projects.client.permission.store','uses' =>'ProjectController@clientPermissionStore'])->middleware(['auth','XSS']);
Route::delete('/{slug}/projects/{id}/client/{uid}',['as' => 'projects.client.delete','uses' =>'ProjectController@clientDelete'])->middleware(['auth','XSS']);
Route::post('/{slug}/projects/share/{id}',['as' => 'projects.share','uses' =>'ProjectController@share'])->middleware(['auth','XSS']);
Route::post('/{slug}/projects/invite/{id}/update',['as' => 'projects.invite.update','uses' =>'ProjectController@invite'])->middleware(['auth','XSS']);
Route::get('/{slug}/projects/milestone/{id}',['as' => 'projects.milestone','uses' =>'ProjectController@milestone'])->middleware(['auth','XSS']);
Route::post('/{slug}/projects/milestone/{id}/store',['as' => 'projects.milestone.store','uses' =>'ProjectController@milestoneStore'])->middleware(['auth','XSS']);
Route::get('/{slug}/projects/milestone/{id}/show',['as' => 'projects.milestone.show','uses' =>'ProjectController@milestoneShow'])->middleware(['auth','XSS']);
Route::get('/{slug}/projects/milestone/{id}/edit',['as' => 'projects.milestone.edit','uses' =>'ProjectController@milestoneEdit'])->middleware(['auth','XSS']);
Route::post('/{slug}/projects/milestone/{id}/update',['as' => 'projects.milestone.update','uses' =>'ProjectController@milestoneUpdate'])->middleware(['auth','XSS']);
Route::delete('/{slug}/projects/milestone/{id}',['as' => 'projects.milestone.destroy','uses' =>'ProjectController@milestoneDestroy'])->middleware(['auth','XSS']);
Route::post('/{slug}/projects/{id}/file',['as' => 'projects.file.upload','uses' =>'ProjectController@fileUpload'])->middleware(['auth','XSS']);
Route::get('/{slug}/projects/{id}/file/{fid}',['as' => 'projects.file.download','uses' =>'ProjectController@fileDownload'])->middleware(['auth','XSS']);
Route::delete('/{slug}/projects/{id}/file/delete/{fid}',['as' => 'projects.file.delete','uses' =>'ProjectController@fileDelete'])->middleware(['auth','XSS']);

// Task Board
Route::get('/{slug}/projects/client/task-board/{code}',['as' => 'projects.client.task.board','uses' =>'ProjectController@taskBoard']);
Route::get('/{slug}/projects/{id}/task-board',['as' => 'projects.task.board','uses' =>'ProjectController@taskBoard'])->middleware(['auth','XSS']);
Route::get('/{slug}/projects/{id}/task-board/create',['as' => 'tasks.create','uses' =>'ProjectController@taskCreate'])->middleware(['auth','XSS']);
Route::post('/{slug}/projects/{id}/task-board',['as' => 'tasks.store','uses' =>'ProjectController@taskStore'])->middleware(['auth','XSS']);
Route::post('/{slug}/projects/{id}/task-board/order-update',['as' => 'tasks.update.order','uses' =>'ProjectController@taskOrderUpdate']);
Route::get('/{slug}/projects/{id}/task-board/edit/{tid}',['as' => 'tasks.edit','uses' =>'ProjectController@taskEdit'])->middleware(['auth','XSS']);
Route::post('/{slug}/projects/{id}/task-board/{tid}/update',['as' => 'tasks.update','uses' =>'ProjectController@taskUpdate'])->middleware(['auth','XSS']);
Route::delete('/{slug}/projects/{id}/task-board/{tid}',['as' => 'tasks.destroy','uses' =>'ProjectController@taskDestroy'])->middleware(['auth','XSS']);
Route::get('/{slug}/projects/{id}/task-board/{tid}/{cid?}',['as' => 'tasks.show','uses' =>'ProjectController@taskShow']);
Route::post('/{slug}/projects/{id}/task-board/{tid}/drag',['as' => 'tasks.drag.event','uses' =>'ProjectController@taskDrag']);

// Gantt Chart
Route::get('/{slug}/projects/{id}/gantt/{duration?}',['as' => 'projects.gantt','uses' =>'ProjectController@gantt'])->middleware(['auth','XSS']);
Route::post('/{slug}/projects/{id}/gantt',['as' => 'projects.gantt.post','uses' =>'ProjectController@ganttPost'])->middleware(['auth','XSS']);

Route::get('/{slug}/tasks',['as' => 'tasks.index','uses' =>'ProjectController@allTasks'])->middleware(['auth','XSS']);
Route::post('/{slug}/tasks',['as' => 'tasks.ajax.chart','uses' =>'ProjectController@ajax_tasks'])->middleware(['auth','XSS']);

// Timesheet
Route::get('/{slug}/tasks/{id?}',['as' => 'tasks.ajax','uses' =>'ProjectController@getTask'])->middleware(['auth','XSS']);
Route::get('/{slug}/timesheet',['as' => 'timesheet.index','uses' =>'ProjectController@timesheet'])->middleware(['auth','XSS']);
Route::get('/{slug}/timesheet/create',['as' => 'timesheet.create','uses' =>'ProjectController@timesheetCreate'])->middleware(['auth','XSS']);
Route::post('/{slug}/timesheet/store',['as' => 'timesheet.store','uses' =>'ProjectController@timesheetStore'])->middleware(['auth','XSS']);
Route::get('/{slug}/timesheet/{id}/edit',['as' => 'timesheet.edit','uses' =>'ProjectController@timesheetEdit'])->middleware(['auth','XSS']);
Route::post('/{slug}/timesheet/{id}/update',['as' => 'timesheet.update','uses' =>'ProjectController@timesheetUpdate'])->middleware(['auth','XSS']);
Route::delete('/{slug}/timesheet/{id}',['as' => 'timesheet.destroy','uses' =>'ProjectController@timesheetDestroy'])->middleware(['auth','XSS']);

Route::post('/{slug}/projects/{id}/comment/{tid}/file/{cid?}',['as' => 'comment.store.file','uses' =>'ProjectController@commentStoreFile']);
Route::delete('/{slug}/projects/{id}/comment/{tid}/file/{fid}',['as' => 'comment.destroy.file','uses' =>'ProjectController@commentDestroyFile']);
Route::post('/{slug}/projects/{id}/comment/{tid}/{cid?}',['as' => 'comment.store','uses' =>'ProjectController@commentStore']);
Route::delete('/{slug}/projects/{id}/comment/{tid}/{cid}',['as' => 'comment.destroy','uses' =>'ProjectController@commentDestroy']);
Route::post('/{slug}/projects/{id}/sub-task/{stid}/update',['as' => 'subtask.update','uses' =>'ProjectController@subTaskUpdate']);
Route::post('/{slug}/projects/{id}/sub-task/{tid}/{cid?}',['as' => 'subtask.store','uses' =>'ProjectController@subTaskStore']);
Route::delete('/{slug}/projects/{id}/sub-task/{stid}',['as' => 'subtask.destroy','uses' =>'ProjectController@subTaskDestroy']);


Route::get('/{slug}/projects/time-tracker/{id}','ProjectController@tracker')->name('projecttime.tracker')->middleware(['auth','XSS']);
Route::get('/{slug}/projectsss/time-tracker/{id}','ProjectController@tracker')->name('client.projecttime.tracker')->middleware(['auth:client','XSS']);

// todo
//Route::get('/{slug}/todo',['as' => 'todos.index','uses' =>'TodoController@index'])->middleware(['auth','XSS']);
//Route::post('/{slug}/todo',['as' => 'todos.store','uses' =>'TodoController@store'])->middleware(['auth','XSS']);
//Route::post('/{slug}/todo',['as' => 'todos.update','uses' =>'TodoController@update'])->middleware(['auth','XSS']);
//Route::delete('/{slug}/todo',['as' => 'todos.destroy','uses' =>'TodoController@destroy'])->middleware(['auth','XSS']);

// note
Route::get('/{slug}/notes',['as' => 'notes.index','uses' =>'NoteController@index'])->middleware(['auth','XSS']);
Route::get('/{slug}/notes/create',['as' => 'notes.create','uses' =>'NoteController@create'])->middleware(['auth','XSS']);
Route::post('/{slug}/notes',['as' => 'notes.store','uses' =>'NoteController@store'])->middleware(['auth','XSS']);
Route::get('/{slug}/notes/{id}/edit',['as' => 'notes.edit','uses' =>'NoteController@edit'])->middleware(['auth','XSS']);
Route::post('/{slug}/notes/{id}/update',['as' => 'notes.update','uses' =>'NoteController@update'])->middleware(['auth','XSS']);
Route::delete('/{slug}/notes/{id}',['as' => 'notes.destroy','uses' =>'NoteController@destroy'])->middleware(['auth','XSS']);

// bug report
Route::get('/{slug}/projects/{id}/bug_report',['as' => 'projects.bug.report','uses' =>'ProjectController@bugReport'])->middleware(['auth','XSS']);
Route::get('/{slug}/projects/{id}/bug_report/create',['as' => 'projects.bug.report.create','uses' =>'ProjectController@bugReportCreate'])->middleware(['auth','XSS']);
Route::post('/{slug}/projects/{id}/bug_report',['as' => 'projects.bug.report.store','uses' =>'ProjectController@bugReportStore'])->middleware(['auth','XSS']);
Route::post('/{slug}/projects/{id}/bug_report/order-update',['as' => 'projects.bug.report.update.order','uses' =>'ProjectController@bugReportOrderUpdate'])->middleware(['auth','XSS']);
Route::get('/{slug}/projects/{id}/bug_report/{bid}/show',['as' => 'projects.bug.report.show','uses' =>'ProjectController@bugReportShow'])->middleware(['auth','XSS']);
Route::get('/{slug}/projects/{id}/bug_report/{bid}/edit',['as' => 'projects.bug.report.edit','uses' =>'ProjectController@bugReportEdit'])->middleware(['auth','XSS']);
Route::put('/{slug}/projects/{id}/bug_report/{bid}',['as' => 'projects.bug.report.update','uses' =>'ProjectController@bugReportUpdate'])->middleware(['auth','XSS']);
Route::delete('/{slug}/projects/{id}/bug_report/{bid}',['as' => 'projects.bug.report.destroy','uses' =>'ProjectController@bugReportDestroy'])->middleware(['auth','XSS']);

Route::post('/{slug}/projects/{id}/bug_comment/{tid}/file/{cid?}',['as' => 'bug.comment.store.file','uses' =>'ProjectController@bugStoreFile']);
Route::delete('/{slug}/projects/{id}/bug_comment/{tid}/file/{fid}',['as' => 'bug.comment.destroy.file','uses' =>'ProjectController@bugDestroyFile']);
Route::post('/{slug}/projects/{id}/bug_comment/{tid}/{cid?}',['as' => 'bug.comment.store','uses' =>'ProjectController@bugCommentStore']);
Route::delete('/{slug}/projects/{id}/bug_comment/{tid}/{cid}',['as' => 'bug.comment.destroy','uses' =>'ProjectController@bugCommentDestroy']);

Route::get('/{slug}/invoices/preview/{template}/{color}',['as' => 'invoice.preview','uses' =>'InvoiceController@previewInvoice']);
Route::resource('/{slug}/invoices','InvoiceController');
Route::get('/{slug}/invoices/{id}/item',['as' => 'invoice.item.create','uses' =>'InvoiceController@create_item']);
Route::post('/{slug}/invoices/{id}/item',['as' => 'invoice.item.store','uses' =>'InvoiceController@store_item']);
Route::delete('/{slug}/invoices/{id}/item/{iid}',['as' => 'invoice.item.destroy','uses' =>'InvoiceController@destroy_item']);
Route::get('/{slug}/invoices/{id}/print',['as' => 'invoice.print','uses' =>'InvoiceController@printInvoice']);

Route::get('/{slug}/taxes',['as' => 'tax.create','uses' =>'WorkspaceController@create_tax'])->middleware(['auth','XSS']);
Route::post('/{slug}/taxes',['as' => 'tax.store','uses' =>'WorkspaceController@store_tax'])->middleware(['auth','XSS']);
Route::get('/{slug}/taxes/{id}/edit',['as' => 'tax.edit','uses' =>'WorkspaceController@edit_tax'])->middleware(['auth','XSS']);
Route::post('/{slug}/taxes/{id}/update',['as' => 'tax.update','uses' =>'WorkspaceController@update_tax'])->middleware(['auth','XSS']);
Route::delete('/{slug}/taxes/{id}',['as' => 'tax.destroy','uses' =>'WorkspaceController@destroy_tax'])->middleware(['auth','XSS']);

Route::post('/{slug}/stages',['as' => 'stages.store','uses' =>'WorkspaceController@store_stages'])->middleware(['auth','XSS']);
Route::post('/{slug}/bug/stages',['as' => 'bug.stages.store','uses' =>'WorkspaceController@store_bug_stages'])->middleware(['auth','XSS']);


Route::post('/{slug}/manual-invoice-payment/{invoice_id}',['as' => 'manual.invoice.payment','uses' =>'InvoiceController@addManualPayment'])->middleware(['auth','XSS']);



Route::get('/{slug}/timesheet/{id}',['as' => 'projects.timesheet.index','uses' =>'ProjectController@projectsTimesheet'])->middleware(['auth','XSS']);

Route::get('/{slug}/timesheet-table-view', 'ProjectController@filterTimesheetTableView')->name('filter.timesheet.table.view')->middleware(['auth', 'XSS']);

Route::get('/{slug}/append-timesheet-task-html', 'ProjectController@appendTimesheetTaskHTML')->name('append.timesheet.task.html')->middleware(['auth', 'XSS']);

Route::get('/{slug}/timesheet/create/{project_id}',['as' => 'project.timesheet.create','uses' =>'ProjectController@projectTimesheetCreate'])->middleware(['auth','XSS']);

Route::post('/{slug}/timesheet/store/{project_id}',['as' => 'project.timesheet.store','uses' =>'ProjectController@projectTimesheetStore'])->middleware(['auth','XSS']);

Route::get('/{slug}/timesheet/{timesheet_id}/edit/{project_id}',['as' => 'project.timesheet.edit','uses' =>'ProjectController@projectTimesheetEdit'])->middleware(['auth','XSS']);

Route::post('/{slug}/timesheet/{timesheet_id}/update/{project_id}',['as' => 'project.timesheet.update','uses' =>'ProjectController@projectTimesheetUpdate'])->middleware(['auth','XSS']);

Route::get('/{slug}/checkuserexists', 'UserController@checkUserExists')->name('user.exists')->middleware(['auth', 'XSS']);

Route::delete('/lang/{lang}',['as' => 'lang.destroy','uses' =>'WorkspaceController@destroyLang'])->middleware(['auth','XSS']);


//================================= Custom Landing Page ====================================//

Route::get('/landingpage', 'LandingPageSectionController@index')->name('custom_landing_page.index')->middleware(['auth','XSS']);
Route::get('/LandingPage/show/{id}', 'LandingPageSectionController@show');
Route::post('/LandingPage/setConetent', 'LandingPageSectionController@setConetent')->middleware(['auth','XSS']);
Route::post('/LandingPage/removeSection/{id}', 'LandingPageSectionController@removeSection')->middleware(['auth','XSS']);
Route::post('/LandingPage/setOrder', 'LandingPageSectionController@setOrder')->middleware(['auth','XSS']);
Route::post('/LandingPage/copySection', 'LandingPageSectionController@copySection')->middleware(['auth','XSS']);



//--------------------------------------------------------Import/Export Data Route-----------------------------------------------------------------


Route::get('import/user/file', 'UserController@importFile')->name('user.file.import');
Route::post('/import/user', 'UserController@import')->name('user.import');
Route::get('export/user', 'UserController@export')->name('user.export');



Route::get('/{slug}/import/client/file', 'ClientController@importFile')->name('client.file.import');
Route::post('import/client', 'ClientController@import')->name('client.import');
Route::get('export/client', 'ClientController@export')->name('client.export');

Route::get('/{slug}/import/project/file', 'ProjectController@importFile')->name('project.file.import');
Route::post('import/project', 'ProjectController@import')->name('project.import');
Route::get('export/project', 'ProjectController@export')->name('project.export');
Route::get('export/invoice', 'InvoiceController@export')->name('invoice.export');



////------------------------tracker-----------------------------------------////
Route::delete('tracker/{tid}/destroy', 'TimeTrackerController@Destroy')->name('tracker.destroy');
Route::get('/{slug}/time-tracker','TimeTrackerController@index')->name('time.tracker')->middleware(['auth','XSS']);
Route::post('/{slug}/tracker/image-view', ['as' => 'tracker.image.view','uses' => 'TimeTrackerController@getTrackerImages']);
Route::any('tracker/image-remove', ['as' => 'tracker.image.remove','uses' => 'TimeTrackerController@removeTrackerImages']);



// ================================= Zoom Meeting ======================================//


Route::get('/{slug}/zoom-meeting',['as' => 'zoom-meeting.index','uses' =>'ZoomMeetingController@index'])->middleware(['auth','XSS']);
Route::get('/{slug}/zoom-meeting/create',['as' => 'zoom-meeting.create','uses' =>'ZoomMeetingController@create'])->middleware(['auth','XSS']);
Route::get('/{slug}/zoom-meeting/calender',['as' => 'zoommeeting.Calender','uses' =>'ZoomMeetingController@calender'])->middleware(['auth','XSS']);
Route::get('/{slug}/zoom-meeting/calenderss',['as' => 'zoommeetings.Calender','uses' =>'ZoomMeetingController@calender'])->middleware(['auth:client','XSS']);

Route::get('/{slug}/zoom-meeting/{id}/show',['as' => 'zoom_meeting.show','uses' =>'ZoomMeetingController@show'])->middleware(['auth','XSS']);

Route::get('/{slug}/zoom-meetings/{id}/show',['as' => 'zoom_meetings.show','uses' =>'ZoomMeetingController@show'])->middleware(['auth:client','XSS']);

Route::post('/{slug}/zoom-meeting/store',['as' => 'zoom-meeting.store','uses' =>'ZoomMeetingController@store'])->middleware(['auth','XSS']);
Route::get('/{slug}/zoom-meeting/{id}/edit',['as' => 'zoom-meeting.edit','uses' =>'ZoomMeetingController@edit'])->middleware(['auth','XSS']);
Route::post('/{slug}/zoom-meeting/{id}/update',['as' => 'zoom-meeting.update','uses' =>'ZoomMeetingController@update'])->middleware(['auth','XSS']);
Route::delete('/{slug}/zoom-meeting/{id}',['as' => 'zoom-meeting.destroy','uses' =>'ZoomMeetingController@destroy'])->middleware(['auth','XSS']);
Route::get('/{slug}/projects/{id}/members',['as' => 'projects.members','uses' =>'ProjectController@members'])->middleware(['auth','XSS']);


//=================================== slack=============================================================//

Route::post('/workspace/{slug}/settingsss',['as' => 'workspace.settings.Slack','uses' =>'WorkspaceController@settingsSlack'])->middleware(['auth','XSS']);

// ====================================telegram===============================================================//

Route::post('/workspace/{slug}/telegram',['as' => 'workspace.settings.telegram','uses' =>'WorkspaceController@settingstelegram'])->middleware(['auth','XSS']);

/*==================================Recaptcha====================================================*/

Route::post('/recaptcha-settings',['as' => 'recaptcha.settings.store','uses' =>'SettingsController@recaptchaSettingStore'])->middleware(['auth','XSS']);

/*==============================================Invoice Paymentwall===========================================================*/
Route::any('{slug}/paymentwall/invoice/{invoice_id}', ['as' => 'paymentwall.index', 'uses' => 'PaymentWallPaymentController@invoiceindex']);
Route::post('{slug}/invoice-pay-with-paymentwall/{invoice_id}', ['as' => 'invoice.pay.with.paymentwall', 'uses' => 'PaymentWallPaymentController@invoicePayWithPaymentwall']);
Route::any('{slug}/invoice/error/{flag}/{invoice_id}', 'PaymentWallPaymentController@orderpaymenterror')->name('invoice.callback.error');

/*======================================================================================================*/
Route::get('{slug}/client/resetpassword/{id}',['as' => 'client.reset.password','uses' =>'ClientController@resetPassword'])->middleware(['auth','XSS']);
Route::post('{slug}/client/changepassword/{id}',['as' => 'client.change.password','uses' =>'ClientController@changePassword'])->middleware(['auth','XSS']);
