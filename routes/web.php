<?php

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
    //return view('welcome');
   return redirect(url('/admin-login-cardif'));
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => 'auth','prefix' => 'user'], function () {
    Route::resource('/reports', 'ReportsController');
    Route::get('/reports/{id}/duplicate', 'ReportsController@duplicate');
    Route::any('daily/report', 'ReportsController@dailyReport123');
    Route::any('monthly/report123', 'ReportsController@monthlyReport123');
    Route::any('user-indexReport-optimize', 'ReportsController@indexOptimize')->name('user-indexReport-optimize');

    /** Message Tool Controller **/
    Route::get('message-create', 'MessageToolController@create')->name('message.create');
    Route::post('message-send-email', 'MessageToolController@sendMessageEmail')->name('message.send.email');
    Route::get('message-search', 'MessageToolController@messageSearch')->name('message.search');
    Route::any('message-search-optimize', 'MessageToolController@messageSearchOptimize')->name('message.search.optimize');
    Route::get('message-search-edit/{id}', 'MessageToolController@editMessage')->name('message.search.edit');

});
Route::group(['namespace' => 'Admin', 'prefix' => 'admin-login-cardif'], function () {
    Route::get('/', 'Auth\LoginController@showLoginForm');
    Route::post('login', 'Auth\LoginController@login');
    Route::post('logout', 'Auth\LoginController@logout')->name('admin.logout');
    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
    Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('admin.password.reset');
    Route::get('register', 'Auth\RegisterController@showRegistrationForm');
    Route::post('register', 'Auth\RegisterController@register');

    Route::group(['middleware' => 'auth.admin'], function () {

        Route::get('home', 'DashboardController@admin');
        /*Route::get('home2', 'DashboardController@admin2')->name('home2');
        Route::get('reports-optimize', 'DashboardController@adminOptimize')->name('reports-optimize');*/
        Route::get('/profile', 'UserController@show')->name('admin.profile');
        Route::post('/profile/{id}/update', 'UserController@profileUpdate');

        //Managers
        Route::get('managers', ['uses'=>'UserController@managers', 'as' => 'admin.managers']);
        Route::get('managers/{id}/show', ['uses'=>'UserController@show', 'as' => 'admin.managers.show']);
        Route::get('managers/create', ['uses'=>'UserController@managerCreate', 'as' => 'admin.managers.create']);
        Route::post('managers/create', ['uses'=>'UserController@store', 'as' => 'admin.managers.store']);
        Route::get('managers/{id}/edit', ['uses'=>'UserController@edit', 'as' => 'admin.managers.edit']);
        Route::post('managers/{id}/edit', ['uses'=>'UserController@update', 'as' => 'admin.managers.update']);
        Route::delete('/managers/{id}/delete', 'UserController@destroy')->name('admin.managers.destroy');

        //Agents
        Route::get('agents', ['uses'=>'UserController@agents', 'as' => 'admin.agents']);
        Route::get('agents/{id}/show', ['uses'=>'UserController@show', 'as' => 'admin.agents.show']);
        Route::get('agents/create', ['uses'=>'UserController@agentCreate', 'as' => 'admin.agents.create']);
        Route::post('agents/create', ['uses'=>'UserController@store', 'as' => 'admin.agents.store']);
        Route::get('agents/{id}/edit', ['uses'=>'UserController@edit', 'as' => 'admin.agents.edit']);
        Route::post('agents/{id}/edit', ['uses'=>'UserController@update', 'as' => 'admin.agents.update']);
        Route::delete('/agents/{id}/delete', 'UserController@destroy')->name('admin.agents.destroy');

        Route::post('/user/{user_id}/toggle-status', 'UserController@toggleStatus')->name('users.toggle.status');


        //Users
        Route::get('/user/view/{user_id}', 'UserController@show');
        Route::get('/users', 'UserController@users');
        Route::get('/users/edit/{user_id}', 'UserController@edit')->name('users.edit');
        Route::post('/users/edit/{user_id}', 'UserController@update');
        Route::delete('/user/delete/{user_id}', 'UserController@destroy')->name('users.destroy');
        Route::get('/user/create/{role_id}', 'UserController@create');
        Route::post('/user/store', 'UserController@store');
        Route::get('/user/edit/{user_id}', 'UserController@edit')->name('admin.user.edit');
        Route::post('/user/update/{user_id}', 'UserController@store')->name('admin.user.update');

        //Change Password
        Route::get('/user/{id?}/change-password', 'UserController@adminChangePassword')->name('admin.change-password');
        Route::post('/user/{id}/admin-change-password', 'UserController@adminChangePasswordStore')->name('admin.change-password.store');
        Route::get('/user/{id?}/manager-change-password', 'UserController@managerChangePassword')->name('admin.manager.change-password');
        Route::get('/user/{id?}/agent-change-password', 'UserController@agentChangePassword')->name('admin.agent.change-password');
        Route::post('/user/{id}/change-password', 'UserController@userChangePasswordStore')->name('user.change-password.store');

        Route::resource('/emails', 'EmailController');
        Route::resource('/adminReports', 'ReportsController');
        Route::get('reports-optimize', 'ReportsController@adminOptimize')->name('reports-optimize');

        Route::resource('/dailyReports', 'DailyReportsController');
        Route::get('/daily', 'DailyReportsController@dailyMonthly')->name('reports.dailyMonthly');
        Route::get('/dailyStatus', 'DailyReportsController@dailyStatus')->name('status.daily');
        Route::any('/dailyStatusResend', 'DailyReportsController@dailyStatusResend')->name('status.dailyResend');

        Route::resource('/monthlyReports', 'MonthlyReportsController');
        Route::get('/monthlyStatus', 'MonthlyReportsController@monthlyStatus')->name('status.monthly');
        Route::any('/monthlyStatusResend', 'MonthlyReportsController@monthlyStatusResend')->name('status.monthlyResend');

        //Client Section
        Route::get('client-index', 'ClientController@index')->name('client.index');
        Route::get('client-create', 'ClientController@create')->name('client.create');
        Route::post('client-store', 'ClientController@store')->name('client.store');
        Route::get('client-edit/{id}', 'ClientController@edit')->name('client.edit');
        Route::post('client-update/{id}', 'ClientController@update')->name('client.update');
        Route::delete('client-destroy/{id}', 'ClientController@destroy')->name('client.destroy');

        //Reply To Section
        Route::get('replyto-index', 'ClientController@replyToIndex')->name('replyto.index');
        Route::get('replyto-create', 'ClientController@replyToCreate')->name('replyto.create');
        Route::post('replyto-store', 'ClientController@replyTostore')->name('replyto.store');
        Route::get('replyto-edit/{id}', 'ClientController@replyToEdit')->name('replyto.edit');
        Route::post('replyto-update/{id}', 'ClientController@replyToUpdate')->name('replyto.update');
        Route::delete('replyto-destroy/{id}', 'ClientController@replyTodestroy')->name('replyto.destroy');

        //Reply To Section
        Route::get('bcc-index', 'ClientController@bccIndex')->name('bcc.index');
        Route::get('bcc-create', 'ClientController@bccCreate')->name('bcc.create');
        Route::get('bcc-edit/{id}', 'ClientController@bccEdit')->name('bcc.edit');
        Route::post('bcc-update/{id}', 'ClientController@bccUpdate')->name('bcc.update');
        Route::post('bcc-store', 'ClientController@bccStore')->name('bcc.store');
        Route::delete('bcc-destroy/{id}', 'ClientController@bccDestroy')->name('bcc.destroy');


    });
});


Route::get('/info', function () {


    return date('t');
    //return \Carbon\Carbon::now()->format('H:i');

    //return date('d.m.Y',strtotime("-1 days"));
    // return \Carbon\Carbon::yesterday()->format('d-m-Y');



});


/*
    Mail::send('emails.instant_report', [], function ($message){

        $message->to("testing.rvtech@gmail.com");
        $message->subject("Test Mail");
    });*/



Route::get('test-email',function (){

    \Illuminate\Support\Facades\Mail::raw('This is test email',function($message){
        $message->replyTo('kshitiz_agrawal@rvtechnologies.co.in', 'Reply Guy');
        $message->to('rajat_jain@rvtechnologies.co.in');
    });

    return phpinfo();

});