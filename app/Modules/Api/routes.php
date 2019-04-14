<?php

Route::group(array('module' => 'Api', 'namespace' => 'App\Modules\Api\Controllers', 'prefix' => 'api/v1'), function() {

  Route::post('auth/login', 'AuthController@appLogin');
  Route::get('auth/logout', 'AuthController@getLogout');
  Route::get('findMe', 'UserController@findMe');
  Route::get('findMember/{id}', 'UserController@findMember');
  Route::get('user/find-by-id/{id}', 'UserController@findById');
  Route::get('members/find-by-room/{roomId}', 'ChatThreadUserController@findByRoom');
  Route::put('users/change-password', 'UserController@changePassword');
  Route::post('user/account-status/{id}', 'UserController@changeStatus');
  Route::post('user/account-role/{id}', 'UserController@changeRole');
  Route::post('user/account-new', 'UserController@createNewAccount');

  Route::get('member/get-token', 'UserController@getToken');
  Route::post('member/send-tokens', 'PaymentTokensController@sendTokens');
  Route::post('member/send-paid-tokens', 'PaymentTokensController@sendPaidTokens');
  Route::post('member/send-instant-tokens/{modelId}', 'PaymentTokensController@sendInstantTokens');
  Route::post('member/send-tip-tokens/{roomId}', 'PaymentTokensController@sendTipTokens');
  Route::get('member/send-offline-tokens/{roomId}', 'PaymentTokensController@sendOfflineTokens');
  Route::get('me/check-premium/{room}', 'UserController@checkPremium');

  Route::get('checkRoom/{roomId}', 'RoomController@checkRoom');
  Route::post('rooms/{roomId}/setImage', 'RoomController@setCaptureImage');
  Route::get('chat-messages', 'ChatMessageController@chatMessages');
  Route::delete('chat-messages', 'ChatMessageController@deleteMessages');
  
  Route::get('likes/count', 'LikeController@countMe');
  Route::get('likes/checkMe', 'LikeController@checkMe');
  Route::post('likes/likeMe', 'LikeController@likeMe');
  Route::get('performerchat/{role}/{modelId}', 'PerformerChatController@getPerformerChat');
  Route::post('performerchat/update/{modelId}', 'PerformerChatController@updatePerformerChat');

  //chat messages in model room
  Route::get('messages', 'ChatMessageController@findByModel');
  //black list
  Route::get('user/add-black-list/{username}', 'BlackListController@addBlackList');
  Route::get('user/remove-black-list/{username}', 'BlackListController@removeBlackList');
  Route::get('user/check-black-list/{modelId}', 'BlackListController@checkBlackList');

  Route::get('performer-chat-price/{type}/{modelId}', 'PerformerChatController@getChatPrice');
  Route::post('upload-items', 'MediaController@uploadItems');

  Route::get('media/model/find-my-profile-image', 'MediaController@findMyProfileImages');
  Route::get('media/model/find-my-media-gallery', 'MediaController@findMyMediaGallery');
  Route::get('media/model/find-my-video-gallery', 'MediaController@findMyVideoGallery');
  Route::put('media/model/set-main-image/{imageId}', 'MediaController@setMainImage');
  Route::post('media/model/set-media-status/{id}', 'MediaController@setMediaStatus');


  Route::get('me/profile/image/{imageId}', 'UserController@setMyProfile');
  Route::get('profile/performer', 'UserController@getPerformer');
  Route::delete('media/model/delete/{id}', 'MediaController@destroy');

  Route::get('country/countries', 'CountryController@allCounties');

  //Gallery
  Route::get('gallery/find-my-galleries', 'GalleryController@FindMyGalleries');
  Route::get('gallery/find-gallery-name', 'GalleryController@FindGalleryName');
  Route::post('gallery/store', 'GalleryController@store');
  Route::post('gallery/update', 'GalleryController@update');
  Route::post('gallery/status', 'GalleryController@setGalleryStatus');
  Route::delete('gallery/delete/{id}', 'GalleryController@destroy');

  Route::get('gallery/get-model-galleries/{id}', 'GalleryController@getModelGalleries');

  Route::post('media/check-owner', 'MediaController@checkOwner');

  //video
  Route::get('media/video/find-video-name', 'VideoController@findVideoName');
  Route::post('media/video/store', 'VideoController@store');
  Route::post('media/video/update', 'VideoController@update');

  Route::delete('media/image/{id}', 'MediaController@destroyImage');
  Route::delete('media/video/{id}', 'MediaController@destroyVideo');

  Route::post('media/video/status/{id}', 'VideoController@setVideoStatus');
  Route::get('media/video/find-by-id/{id}', 'VideoController@getVideoById');

  Route::get('media/video/get-model-videos/{id}', 'VideoController@getModelVideos');

  //Other settings
  Route::post('users/model/other-settings', 'UserController@modelOtherSetting');
  Route::post('users/model/update-contact', 'UserController@modelUpdateContact');
  Route::post('users/model/update-payment', 'UserController@modelUpdatePayment');
  Route::post('users/model/suspend', 'UserController@modelSuspendAcount');
  Route::post('users/model/performer', 'UserController@modelPerformer');
  //Transaction
  Route::get('transaction/{id}', 'PaymentController@getTransactionDetail');
   Route::get('mytransaction/{id}', 'PaymentController@getMyTransactionDetail');

//schedule
  Route::post('schedule/model/update', 'ScheduleController@setModelSchedule');
  //category
  Route::get('category/findAll', 'CategoryController@findAll');
  Route::group(array('middleware' => 'AdminCheckLogin'), function() {
    Route::post('category/check-name', 'CategoryController@checkName');
    Route::post('category/add-new', 'CategoryController@store');
    Route::post('category/update/{category}', 'CategoryController@update');
    Route::delete('category/delete/{category}', 'CategoryController@destroy');

    Route::get('user/find-all', 'UserController@findAll');
    Route::delete('user/disable', 'UserController@disableAll');
    Route::post('user/change-account-status/{status}', 'UserController@changeAllAccountStatus');
  });
  //Earning
  Route::get('earning/find-earning', 'EarningController@findReport');
  Route::get('earning/pagination', 'EarningController@pagination');
  Route::get('earning/commission', 'EarningController@ModelEarningCommission');
  Route::get('earning/detail', 'EarningController@getDetail');
  Route::get('earning/count-paid-gallery', 'EarningController@countPaidGallery');
  Route::get('earning/count-paid-item', 'EarningController@countPaidItem');
  Route::get('earning/get-earning-by-item/{item}/{id}', 'EarningController@getEarningByItem');

  Route::get('earning/model/statics', 'EarningController@getStatics');

//get admin Commisson
  Route::get('admin/commission/detail/{id}', 'CommissionController@detail');

  //buy item
  Route::post('buy-item', 'PaymentTokensController@buyItem');
  //Top models
  Route::get('top-models', 'UserController@getTopModels');
  Route::get('get-models-by-category', 'UserController@getModelsByCategory');
  //delete messages
  Route::delete('messages/delete/{type}', 'MessageController@deleteAll');

  //get models
  Route::get('online', 'UserController@getModelOnlines');
  Route::get('check-online/{chatType}/{roomId}', 'ChatThreadController@checkOnline');

  //get model rotate image
  Route::get('get-model-rotate-images/{thread}', 'UserController@getModelRotateImages');

  Route::post('user/favorite', 'UserController@setMemberFavorite');
  Route::get('models/favorites', 'UserController@getMyFavorites');
  Route::get('models/{id}/check-busy', 'UserController@checkBusy');
  //document
  Route::get('document/{id}', 'DocumentController@getDetail');
  //studio profile
  Route::post('studio/profile', 'UserController@updateStudioProfile');
  
  //save user device info
  route::put('member/device', 'UserController@updateDevice');
  //Search model 
  Route::get('search/member', 'UserController@searchModel');


  Route::group([
    'middleware' => ['isLogin']
  ], function() {
    Route::post('products/{id}/buy', 'PerformerProductController@buy');
    Route::get('orders/{id}/comments', 'PerformerProductTrackingController@getComments');
    Route::post('orders/{id}/comments', 'PerformerProductTrackingController@addComment');

    Route::get('payouts/get-earning-by-requested-day', 'PerformerRequestPayoutController@getEarningByRequestedDate');
    Route::get('payouts/get-lastest-request-payout', 'PerformerRequestPayoutController@getLastestRequestPayout');
    Route::get('payouts/get-total-pending-balance', 'PerformerRequestPayoutController@getTotalPendingBalance');
    Route::get('payouts/{id}/comments', 'PerformerRequestPayoutController@getComments');
    Route::post('payouts/{id}/comments', 'PerformerRequestPayoutController@addComment');
    //for studio
    Route::get('payouts/studio/{id}/comments', 'StudioRequestPayoutController@getComments');
    Route::post('payouts/studio/{id}/comments', 'StudioRequestPayoutController@addComment');
  });
  
  Route::group([
    'middleware' => ['isModel']
  ], function() {
    Route::put('orders/{id}', 'PerformerProductTrackingController@changeOrderStatus');
  });

  Route::post('payouts/{id}/status', 'PerformerRequestPayoutController@updateStatus');
  Route::group(array('middleware' => 'AdminCheckLogin'), function() {
    Route::post('payouts/studio/{id}/status', 'StudioRequestPayoutController@updateStatus');
  });
});
