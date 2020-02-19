<?php

Route::redirect('/', '/login');
Route::redirect('/home', '/admin/dashboard');
//Auth::routes();
//Route::get('/logout', 'Auth\LoginController@logout');

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
    Route::redirect('/', '/admin/dashboard');
    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');
    Route::post('users/allOrganization','UsersController@allOrganization');

    // Company Users
    Route::delete('company-user/destroy', 'CompanyUsersController@massDestroy')->name('companyusers.massDestroy');
    Route::resource('company-user', 'CompanyUsersController');
    Route::post('company-user/verifyUser','CompanyUsersController@verifyUser');

    //Dashboard
    Route::resource('dashboard', 'DashboardController');

    //Log 
    Route::resource('log','LogController');
    
    //Refrence Data
    Route::resource('refdata','RefDataController');
    Route::post('refdata/refDatakey','RefDataController@referenceDataKey');
    Route::post('refdata/upload','RefDataController@refDataUpload');

    //Refrence Data Field Definition
    Route::resource('refdatafield','RefDataFieldController');
    Route::post('refdatafield/refDatakey','RefDataController@referenceDataKey');
    Route::post('refdatafield/upload','RefDataFieldController@fieldDataUpload');

    //DocType
    Route::resource('doctype','DocTypeController');
    Route::post('doctype/referenceDataField','DocTypeController@referenceDataField');
});

//Overwrite Auth routes
Route::group(['namespace' => 'Auth'],function(){
     // Authentication Routes...
    Route::get('login', 'LoginController@showLoginForm')->name('login');
    Route::post('login', 'LoginController@login');
    Route::post('logout', 'LoginController@logout')->name('logout');
    
    // Password Reset Routes...
    Route::get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.reset');
    Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset.token');
    Route::post('password/reset', 'ResetPasswordController@reset');
});

