<?php

use Illuminate\Support\Facades\Route;

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

Route::namespace('Api')->group(function(){
    Route::controller('AppController')->group(function () {
        Route::get('general-setting','generalSetting');
        Route::get('get-countries','getCountries');
        Route::get('language/{key?}','getLanguage');
        Route::get('language/{key}','getLanguage');
        Route::get('policies', 'policies');
        Route::get('policy/{slug}', 'policyContent');
        Route::get('faq', 'faq');
        Route::get('seo', 'seo');
        Route::get('get-extension/{act}','getExtension');
        Route::post('contact', 'submitContact');
        Route::get('cookie', 'cookie');
        Route::post('cookie/accept', 'cookieAccept');
        Route::get('custom-pages', 'customPages');
        Route::get('custom-page/{slug}', 'customPageData');
        Route::get('sections/{key?}', 'allSections');
        Route::get('ticket/{ticket}', 'viewTicket');
        Route::post('ticket/ticket-reply/{id}', 'replyTicket');
    });

	Route::namespace('Auth')->group(function(){
        Route::controller('LoginController')->group(function(){
            Route::post('login', 'login');
            Route::post('check-token', 'checkToken');
        });
		Route::post('register', 'RegisterController@register');

        Route::controller('ForgotPasswordController')->group(function(){
            Route::post('password/email', 'sendResetCodeEmail');
            Route::post('password/verify-code', 'verifyCode');
            Route::post('password/reset', 'reset');
        });
	});

    Route::middleware('auth:sanctum')->group(function () {
        Route::controller('UserController')->group(function(){
            Route::post('user-data-submit', 'userDataSubmit');
            Route::get('business-user-form', 'businessUserForm');
        });

        //authorization
        Route::middleware('registration.complete')->controller('AuthorizationController')->group(function(){
            Route::get('authorization', 'authorization');
            Route::get('resend-verify/{type}', 'sendVerifyCode');
            Route::post('verify-email', 'emailVerification');
            Route::post('verify-mobile', 'mobileVerification');
            Route::post('verify-g2fa', 'g2faVerification');
        });

        Route::middleware(['check.status'])->group(function () {
            Route::middleware('registration.complete')->group(function(){
                Route::controller('UserController')->group(function(){
                    Route::get('dashboard', 'dashboard');

                    Route::get('download-attachments/{file_hash}', 'downloadAttachment')->name('download.attachment');

                    // profile setting
                    Route::post('profile-setting', 'submitProfile');
                    Route::post('change-password', 'submitPassword');

                    // user info
                    Route::get('user-info','userInfo');

                    //KYC
                    Route::get('kyc-form','kycForm');
                    Route::post('kyc-submit','kycSubmit');

                    // app
                    Route::get('home', 'home');
                    Route::post('calculate', 'calculate');

                    //Report
                    Route::get('transactions','transactions');
                    Route::get('transaction-detail/{id}', 'transactionDetail'); //.

                    // push notification
                    Route::post('add-device-token', 'addDeviceToken');
                    Route::get('push-notifications', 'pushNotifications');
                    Route::post('push-notifications/read/{id}', 'pushNotificationsRead');


                    //2FA
                    Route::get('twofactor', 'show2faForm');
                    Route::post('twofactor/enable', 'create2fa');
                    Route::post('twofactor/disable', 'disable2fa');

                    Route::post('delete-account', 'deleteAccount');
                });

                Route::controller('SendMoneyController')->name('send.money.')->group(function () {
                    Route::get('send-money/send-now', 'sendMoney');
                    Route::post('send-money/save', 'saveMoney')->middleware('kyc:send_money');
                    Route::post('send-money/service', 'getServices');
                    Route::get('send-money/transfers/history', 'history');
                    Route::get('send-money/detail/{id}', 'sendMoneyDetail');
                });

                // Payment
                Route::middleware(['registration.complete', 'kyc:direct_payment'])->controller('PaymentController')->group(function(){
                    Route::get('payment/methods', 'methods');
                    Route::post('payment/insert', 'depositInsert');
                    Route::post('manual/confirm', 'manualDepositConfirm');
                });

                Route::controller('TicketController')->prefix('ticket')->group(function () {
                    Route::get('/', 'supportTicket');
                    Route::post('create', 'storeSupportTicket');
                    Route::get('view/{ticket}', 'viewTicket');
                    Route::post('reply/{id}', 'replyTicket');
                    Route::post('close/{id}', 'closeTicket');
                    Route::get('download/{attachment_id}', 'ticketDownload');
                });
            });
        });

        Route::get('logout', 'Auth\LoginController@logout');
    });
});
