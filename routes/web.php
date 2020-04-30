<?php
Route::get('/', function () { return redirect('/admin/home'); });

// Authentication Routes...
$this->get('login', 'Auth\LoginController@showLoginForm')->name('auth.login');
$this->post('login', 'Auth\LoginController@login')->name('auth.login');
$this->post('logout', 'Auth\LoginController@logout')->name('auth.logout');

// Change Password Routes...
$this->get('change_password', 'Auth\ChangePasswordController@showChangePasswordForm')->name('auth.change_password');
$this->patch('change_password', 'Auth\ChangePasswordController@changePassword')->name('auth.change_password');

// Password Reset Routes...
$this->get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('auth.password.reset');
$this->post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('auth.password.reset');
$this->get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
$this->post('password/reset', 'Auth\ResetPasswordController@reset')->name('auth.password.reset');

Route::group(['middleware' => ['auth'], 'prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::get('/home', 'HomeController@index');

    Route::resource('permissions', 'Admin\PermissionsController');
    Route::post('permissions_mass_destroy', ['uses' => 'Admin\PermissionsController@massDestroy', 'as' => 'permissions.mass_destroy']);

    Route::resource('roles', 'Admin\RolesController');
    Route::post('roles_mass_destroy', ['uses' => 'Admin\RolesController@massDestroy', 'as' => 'roles.mass_destroy']);
    
    Route::resource('users', 'Admin\UsersController');
    Route::post('users_mass_destroy', ['uses' => 'Admin\UsersController@massDestroy', 'as' => 'users.mass_destroy']);

    Route::resource('customers', 'Admin\CustomersController');
    Route::post('customer/destroy/{id}', 'Admin\CustomersController@destroy');

    Route::resource('logs', 'Admin\LogsController');
    Route::post('logs/destroy/{id}', 'Admin\LogsController@destroy');

    Route::resource('companies', 'Admin\CompaniesController');
    Route::post('companies/destroy/{id}', 'Admin\CompaniesController@destroy');

    Route::resource('departments', 'Admin\DepartmentsController');
    Route::post('departments/destroy/{id}', 'Admin\DepartmentsController@destroy');

    Route::get('usersetting', 'HomeController@usersetting')->name('usersetting');

    // admin messages
    Route::resource('messages', 'Admin\MessagesContoller');
    Route::post('messages/destroy/{id}', 'Admin\MessagesContoller@destroy');

    // our goal
    Route::resource('goals', 'Admin\GoalsController');

    // contact
    Route::get('contacts', 'Admin\GoalsController@getContact');
    Route::get('contacts/create', 'Admin\GoalsController@createContact');
    Route::post('contacts', 'Admin\GoalsController@storeContact');

    // event and gallery
    Route::resource('events', 'Admin\EventsController');
    Route::post('events/destroy/{id}', 'Admin\EventsController@destroy');
    Route::resource('galleries', 'Admin\GalleriesController');
    Route::post('galleries/destroy/{id}', 'Admin\GalleriesController@destroy');
});

Route::get('admin/setting/logo', 'Admin\SettingController@logo')->name('admin.setting.logo');
Route::post('admin/setting/update_logo', 'Admin\SettingController@update_logo')->name('admin.setting.update_logo');

Route::middleware(['auth'])->group(function(){

    Route::get('/profile', function () {
        if (!isset($_GET['message']))
            return view('auth.profile');
        else
            return view('auth.profile');
    });

    Route::post('/savepro/{id}', 'HomeController@savepro');
    Route::post('/changepwd/{id}', 'HomeController@changepwd');

    Route::resource('document', 'Document\DocumentsController');
    Route::post('document/destroy/{id}', 'Document\DocumentsController@destroy');
    Route::get('/document/downfile/{id}', 'Document\DocumentsController@downfile')->name('document.downfile');
    Route::get('getdepartments', 'Document\DocumentsController@getdepartments')->name('document.getdepartments');
    Route::get('getdeparttree', 'Document\DocumentsController@getdeparttree');
    Route::get('savedeparttree', 'Document\DocumentsController@savedeparttree');

    Route::resource('category', 'Document\CategoriesController');
    Route::post('category/destroy/{id}', 'Document\CategoriesController@destroy');

    Route::resource('revision', 'Document\RevisionsController');
    Route::post('revision/destroy/{id}', 'Document\RevisionsController@destroy');
    Route::get('revision/index/{id}', 'Document\RevisionsController@index')->name('revision.index');
    Route::get('revision/create/{id}', 'Document\RevisionsController@create')->name('revision.create');
    Route::post('revision/save/{id}', 'Document\RevisionsController@store')->name('revision.save');
    Route::get('/revision/downfile/{id}', 'Document\RevisionsController@downfile')->name('revision.downfile');

    //todo
    Route::get('dashboard/gettodo', 'HomeController@getTodo');
    Route::post('dashboard/addtodo', 'HomeController@addTodo');
    Route::post('dashboard/updatetodo', 'HomeController@updateTodo');
    Route::post('dashboard/deletetodo', 'HomeController@deleteTodo');

    //memo
    Route::resource('memos', 'MemoController');
    Route::post('memos/destroy/{id}', 'MemoController@destroy');

    //oraganisation
    Route::resource('organisations', 'OrganisationsController');
    Route::post('organisations/destroy/{id}', 'OrganisationsController@destroy');
    Route::get('organisations/profile/{id}', 'OrganisationsController@getprofile');

    Route::resource('download', 'Document\DownhistoryController');
    Route::resource('calendar', 'Setting\CalendarController');
    Route::post('calendar/storeevtname', 'Setting\CalendarController@storeevtname');
    Route::post('calendar/destroy/{id}', 'Setting\CalendarController@destroy');

    Route::get('document/view/{id}', 'Document\DocumentViewController@view');
    Route::post('document/confirm/{id}', 'Document\DocumentViewController@confirm');
    Route::get('acknowledgment/adminview', 'Document\DocumentViewController@adminview');

    // user gallery view
    Route::get('galleries/event', 'Admin\GalleriesController@showEvent');
    Route::get('galleries/gallery/{id}', 'Admin\GalleriesController@showGallery');

    // embed html
    Route::resource('embeds', 'EmbedController');
    Route::post('embeds/destroy/{id}', 'EmbedController@destroy');
    Route::post('embeds/confirm/{id}', 'EmbedController@confirm');
    Route::get('embeds/view/{id}', 'EmbedController@view');
    Route::get('embeds/history/{id}', 'EmbedController@history')->name("embeds.history");
});


