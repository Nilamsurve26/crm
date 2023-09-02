<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('me', 'MeController@me');

Route::get('count', 'HomeController@count');
Route::get('usersExports', 'UsersController@exports');


Route::post('/register', 'Auth\RegisterController@register');
Route::post('/reset_password', 'Auth\ResetPasswordController@reset_password');
Route::post('login', 'Auth\LoginController@login')->name('login');
Route::post('/logout', 'Auth\LoginController@logout');
Route::get('/logout', 'Auth\LoginController@logout');

Route::resource('versions', 'VersionsController');
Route::resource('roles', 'RolesController');
Route::resource('role_user', 'RoleUserController');

Route::resource('permissions', 'PermissionsController');
Route::resource('permission_role', 'PermissionRoleController');

Route::post('upload_user_image', 'UploadsController@uploadUserImage');
Route::post('upload_ticket_image', 'UploadsController@uploadTicketImage');
Route::post('upload_product_image', 'UploadsController@uploadProductImage');


Route::resource('products/{product}/product_issues', 'IssuesController');
Route::post('products/{product}/value_lists_multiple', 'IssuesController@storeMultiple');

Route::resource('products', 'ProductsController');


Route::get('users/masters', 'UsersController@masters');
Route::resource('users', 'UsersController');

Route::resource('companies', 'CompaniesController');
Route::resource('company_user', 'CompanyUserController');

Route::post('sendEmail', 'SendEmailController@index');


Route::get('crude_users', 'CrudeUsersController@index');
Route::post('upload_user', 'CrudeUsersController@uploadUser');
Route::get('process_user', 'CrudeUsersController@processUser');
Route::get('truncate_users', 'CrudeUsersController@truncate');

Route::get('send_otp', 'SendSmsController@index');

// Value 
Route::resource('values', 'ValuesController');
//  Value List
Route::get('value_lists/masters', 'ValueListsController@masters');
Route::post('values/{value}/value_lists_multiple', 'ValueListsController@storeMultiple');
Route::resource('values/{value}/value_lists', 'ValueListsController');

// Upload Excell Values
Route::get('crud_value', 'CrudValuesController@index');
Route::post('upload_value', 'CrudValuesController@uploadValue');
Route::get('process_value', 'CrudValuesController@processValue');
Route::get('truncate_values', 'CrudValuesController@truncate');


Route::post('update-ticket-assignments', 'TicketsController@updateTicketAssignments');

Route::resource('tickets', 'TicketsController');





