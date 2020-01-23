<?php

Route::redirect('/', '/login');
Route::redirect('/home', '/admin/dashboard');
Auth::routes();

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
    
});

