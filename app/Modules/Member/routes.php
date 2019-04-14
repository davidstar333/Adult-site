<?php

Route::group(array('module' => 'Member', 'after' => 'no-cache', 'namespace' => 'App\Modules\Member\Controllers'), function() {
  //TODO - should remove resource
  Route::get('/login/redirect/{provider}', ['uses' => 'MemberAuthController@redirectToProvider', 'as' => 'social.login']);

  Route::get('/login/{provider}', 'MemberAuthController@handleProviderCallback');

  Route::get('login', 'MemberAuthController@getLogin');
  Route::post('auth/login', 'MemberAuthController@postLogin');
  Route::get('terms-and-conditions', 'MemberController@getTermsConditions');
  Route::get('privacy-policy', 'MemberController@getPrivacyPolicy');

  Route::get('/register', 'MemberAuthController@getRegister');
  Route::get('/blog', 'MemberController@getBlog');

  Route::post('/resetpassword', 'MemberAuthController@postForgotPassword');

  Route::get('/verifypassword', 'MemberAuthController@getResetPassword');

  Route::post('/register', 'MemberAuthController@postRegister');

  Route::get('/verify', 'MemberAuthController@getActiveAccount');

  Route::resource('member', 'MemberController');

  Route::group(array('middleware' => 'MemberCheckLogin'), function() {

    Route::get('members/logout', 'MemberAuthController@getLogOut');

    Route::get('members', 'MemberController@getMemberProfile');

    Route::get('members/dashboard', 'MemberController@getMemberProfile');

    //Message Route

    Route::get('messages', 'MessageController@getMessageBox');

    Route::get('messages/sent', 'MessageController@getMessageSent');

    Route::get('messages/trash', 'MessageController@getMessageTrash');

    Route::get('messages/new-thread&newthread[username]={username}', 'MessageController@newMessage');

    Route::post('messages/new-thread&newthread[username]={username}', 'MessageController@sendMessage');

    Route::get('messages/new-thread', 'MessageController@newMessage');

    Route::post('messages/new-thread', 'MessageController@sendMessage');

    Route::get('messages/private-thread&thread_id={threadId}&sub-action={action}&reid={reid}', 'MessageController@setTrashMessage');

    Route::get('messages/private-thread&thread_id={threadId}', 'MessageController@getPrivateMessage');

    Route::post('messages/private-thread&thread_id={threadId}', 'MessageController@postRelayPrivateMessage');
    //End message Route

    Route::post('members/follow', 'MemberController@postFollow');

    Route::post('members/like', 'MemberController@postLike');

    Route::get('members/profile', 'MemberController@getMyProfile');

    Route::post('members/profile', 'MemberController@postUpdateProfile');

    Route::get('members/favorites', 'MemberController@getFavorites');

    Route::get('members/following', 'MemberController@getMemberFollowing');

    Route::get('members/account-settings', 'MemberController@getMemberSettings');

    Route::post('members/account-settings', 'MemberController@postMemberSettings');
    
    Route::get('members/account-settings/other-settings', 'MemberController@getOtherSettings');
    Route::post('members/account-settings/other-settings', 'MemberController@postOtherSettings');

    Route::get('members/my-xitytrips', 'MemberController@getMemberXitytrips');

    Route::get('members/my-candies', 'MemberController@getMemberCandies');
    
    Route::get('members/purchased/{action}', 'MemberController@getPurchased');
	
	  //transaction
  Route::get('members/transaction-history', 'PaymentController@getMyTransactions');
  Route::get('members/payment-tokens-history', 'PaymentTokenController@getPaymentTokens');
  });

  //route for video streaming
  Route::get('members/streaming/{modelId}', 'StreamingController@joinModelRoom');
  //chat settings
  Route::get('members/privatechat/{modelId}', 'ChatController@privateChat');
  Route::get('members/groupchat/{modelId}', 'ChatController@groupChat');

  Route::post('accesspayment', 'MemberController@postPaymentAccessBackData');

  Route::get('accesspayment', 'MemberController@getPaymentAccessBackData');

  Route::post('denipayment', 'MemberController@postPaymentDeniBackData');

  Route::group([
   'middleware' => 'isLogin'
  ], function() {
     Route::get('members/products/purchased', 'ProductController@purchasedItems');
     Route::get('members/products/purchased/{id}', 'ProductController@purchasedView');
  });
});
