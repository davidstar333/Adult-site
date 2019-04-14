<?php

Route::group(array('module' => 'Studio', 'prefix'=>'studio', 'namespace' => 'App\Modules\Studio\Controllers'), function() {

  Route::get('login', 'LoginController@studioLogin');
  Route::post('auth/login', 'LoginController@postLogin');

  Route::get('logout', 'LoginController@actionStudioLogout');

  Route::get('recover-account', 'LoginController@studioRecover');

  Route::group(array('middleware' => 'StudioCheckLogin'),function(){

    Route::get('', 'StudioController@studioDashboard');

    Route::get('performers', 'PerformersController@studioPerformers');

    Route::get('earnings','EarningsController@studioEarnings');

    Route::get('stats', 'StatsController@studioStats');

    Route::get('commission-report', 'StatsController@studioCommissionReport');
    
    Route::get('commission-report/{id}', 'StatsController@editModelCommission');
    Route::post('commission-report/{id}', 'StatsController@updateModelCommission');

    Route::get('payments','PaymentsController@studioPayments');

    Route::get('members','MembersController@studioMembers');

    Route::get('members/add','MembersController@studioAddMember');

    Route::post('members/add','MembersController@studioActionAddMember');

    Route::get('members/edit/{id}','MembersController@studioEditMember');
    Route::post('members/edit/{id}','MembersController@studioActionEditMember');
    Route::get('members/documents/{id}','MembersController@getMemberDocuments');
    Route::post('members/documents/{id}','MembersController@postMemberDocuments');
    Route::get('members/payee-info/{id}','MembersController@getMemberPayeeInfo');
    Route::post('members/payee-info/{id}','MembersController@postMemberPayeeInfo');
    Route::get('members/direct-deposity/{id}','MembersController@getMemberDirectDeposity');
    Route::post('members/direct-deposity/{id}','MembersController@postMemberDirectDeposity');  
    Route::get('members/paxum-&-payoneer/{id}','MembersController@getMemberPaxum');
    Route::post('members/paxum-&-payoneer/{id}','MembersController@postMemberPaxum');  
    Route::get('members/bitpay/{id}','MembersController@getMemberBitpay');
    Route::post('members/bitpay/{id}','MembersController@postMemberBitpay');  
    Route::get('members/disable/{id}','MembersController@studiodisableMember');

    Route::get('account-settings','StudioController@studioEditAccountSettings');
    Route::post('account-settings','StudioController@updateAccountSettings');

    Route::get('change-password','StudioController@getChangePassword');
    Route::post('change-password','StudioController@postChangePassword');
    Route::get('payee-info','StudioController@getPayeeInfo');
    Route::post('payee-info','StudioController@postPayeeInfo');
    Route::get('direct-deposity','StudioController@getDirectDeposity');
    Route::post('direct-deposity','StudioController@postDirectDeposity');  
    Route::get('paxum-&-payoneer','StudioController@getPaxum');
    Route::post('paxum-&-payoneer','StudioController@postPaxum');  
    Route::get('bitpay','StudioController@getBitpay');
    Route::post('bitpay','StudioController@postBitpay');  

    Route::get('helps','StudioController@studioHelps');
    Route::get('helps/categories_{catid}','StudioController@studioHelpsCategoriesList');
    Route::get('helps/categories_{catid}_{itemid}/{name}','StudioController@studioHelpItemDetail');
    Route::get('members/delete/{id}', 'MembersController@studioDeleteMember');

     //request payout
    Route::match(['GET', 'POST'], 'payouts/accounts/create', 'RequestPayoutController@createAccount');
    Route::match(['GET', 'POST'], 'payouts/accounts/{id}/edit', 'RequestPayoutController@updateAccount');
    Route::get('payouts/accounts', 'RequestPayoutController@listingAccounts');
    Route::match(['GET', 'POST'], 'payouts/requests/create', 'RequestPayoutController@createRequest');
    Route::match(['GET', 'POST'], 'payouts/requests/edit/{id}', 'RequestPayoutController@editRequest');
    Route::match(['GET', 'POST'], 'payouts/requests', 'RequestPayoutController@listingRequests');

    Route::match('GET', 'payouts/performer-requests', 'RequestPayoutController@performerRequests');
    Route::match('GET', 'payouts/performer-requests/{id}/delete', 'RequestPayoutController@performerRequestsDelete');
    Route::match('GET', 'payouts/performer-requests/{id}', 'RequestPayoutController@performerRequestsView');

    Route::get('payouts/requests/{id}', 'RequestPayoutController@viewRequest');
    Route::get('commission-setting', 'StudioController@commisionSetting');
    Route::get('performers/stats', 'StatsController@performerStats');
  });


});