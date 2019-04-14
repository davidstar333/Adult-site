<?php

Route::group(array('module' => 'Model', 'namespace' => 'App\Modules\Model\Controllers'), function() {

  //Get model video
  Route::post('getvideo', 'MediaController@postVideoItem');

  Route::post('like', 'MediaController@postLikeVideoItem');

  Route::get('file/video/{id}', 'MediaController@getVideo');
  Route::get('profile/{user}', 'ModelController@getModelProfile');
  Route::get('/all-model', 'ModelController@getCommunity');
  Route::get('/category/{name}', 'ModelController@getModelByCategory');
  
  Route::get('models/conversation', 'StreamingController@conversation');

  Route::group(array('middleware' => 'isModel'), function() {

    //Message Route

    Route::get('models/dashboard/messages', 'MessageController@getMessageBox');

    Route::get('models/dashboard/messages/sent', 'MessageController@getMessageSent');

    Route::get('models/dashboard/messages/trash', 'MessageController@getMessageTrash');

    Route::get('models/dashboard/messages/new-thread&newthread[username]={username}', 'MessageController@newMessage');

    Route::post('models/dashboard/messages/new-thread&newthread[username]={username}', 'MessageController@sendMessage');

    Route::get('models/dashboard/messages/new-thread', 'MessageController@newMessage');

    Route::post('models/dashboard/messages/new-thread', 'MessageController@sendMessage');

    Route::get('models/dashboard/messages/private-thread&thread_id={threadId}&sub-action={action}&reid={reid}', 'MessageController@setTrashMessage');

    Route::get('models/dashboard/messages/private-thread&thread_id={threadId}', 'MessageController@getPrivateMessage');

    Route::post('models/dashboard/messages/private-thread&thread_id={threadId}', 'MessageController@postRelayPrivateMessage');

    //End Message


    Route::get('model/room/{roomId}', 'ModelController@chatRoom');

    Route::get('models/dashboard/chat-settings', 'ModelController@chatSettings');

    Route::resource('model', 'ModelController');
    
    //geo blocking
    Route::get('models/dashboard/geo-blocking', 'GeoController@index');
    Route::post('models/dashboard/geo-blocking', 'GeoController@update');
    
    //Route::get('models/dashboard/messages', 'ModelController@getMessageBox');

    

    Route::get('profile/{username}/offline-tip', 'ModelController@getOfflineTip');
    Route::post('profile/{username}/offline-tip', 'ModelController@postOfflineTip');
    /**
     * Check pay for image /video
     */
    Route::group(array('middleware' => 'checkPayMent'), function() {
      Route::get('profile/{username}/gallery/{id}', 'MediaController@getGalleryView');
      Route::get('profile/{username}/videos/{id}', 'MediaController@getVideoView');
    });

    Route::get('/searchmodel', 'ModelController@getSearchModel');
    //route for streaming
    Route::get('models/live', 'StreamingController@goLive');

    Route::get('models/go-online-popup', 'StreamingController@goOnlinePopup');
    //models/privatechat/1?roomId=1235
    Route::get('models/privatechat/{memberId}', 'ChatController@privateChat');

    Route::get('models/dashboard/wall', 'ModelController@getMemberProfile');
    Route::get('models/dashboard', 'ModelController@modelDashboard');
    Route::get('models/dashboard/feed/create', 'ModelController@createFeed');
    Route::get('models/dashboard/edit/{feedId}', 'ModelController@editFeed');
    Route::post('models/dashboard/store', 'ModelController@store');
    Route::get('models/feed/{feedId}', 'ModelController@showFeed');

    Route::post('models/dashboard/feed/update', 'ModelController@updateFeed');
    Route::delete('models/dashboard/feed/remove/{id}', 'ModelController@destroyFeed');
    Route::post('models/dashboard/feed/upload', 'ModelController@uploadAttachment');
    Route::delete('models/dashboard/feed/attachment/{id}', 'ModelController@deleteAttachment');

    Route::get('models/dashboard/account-settings', 'ModelController@getMySettings');
    Route::post('models/dashboard/account-settings/documents', 'ModelController@updateDocumentSetting');
    Route::post('models/dashboard/account-settings/payee-info','ModelController@postPayeeInfo');
    Route::post('models/dashboard/account-settings/direct-deposity','ModelController@postDirectDeposity');
    Route::post('models/dashboard/account-settings/paxum','ModelController@postPaxum');
    Route::post('models/dashboard/account-settings/bitpay','ModelController@postBitpay');

    Route::get('models/dashboard/schedule', 'ModelController@mySchedule');
    Route::get('models/dashboard/schedule/edit', 'ModelController@editSchedule');
    Route::post('models/dashboard/schedule', 'ModelController@postSchedule');

    Route::get('models/dashboard/profile', 'ModelController@getMyProfile');
    Route::get('models/dashboard/profile/view-images', 'ModelController@getProfileImages');
    Route::get('models/dashboard/profile/edit', 'ModelController@getEditProfile');
    Route::post('models/dashboard/profile/edit', 'ModelController@updateProfile');
    

    Route::get('models/dashboard/earnings', 'ModelController@myEarnings');

    //Gallery
    Route::get('models/dashboard/media/add-image-gallery', 'MediaController@addImageGallery');
    Route::get('models/dashboard/media/edit-image-gallery/{imageId}', 'MediaController@editImageGallery');
    //Image
    Route::get('models/dashboard/media/add-image', 'MediaController@addImage');
    Route::get('models/dashboard/media/edit-image/{imageId}', 'MediaController@editImage');
    //Video
    Route::get('models/dashboard/media/video-gallery/upload', 'MediaController@uploadVideo');

    Route::get('models/dashboard/media/add-video-gallery', 'MediaController@addVideoGallery');
    Route::get('models/dashboard/media/edit-video-gallery/{videoId}', 'MediaController@editVideoGallery');
    Route::get('models/dashboard/media/edit-video/{videoId}', 'MediaController@editVideo');

    Route::get('models/dashboard/images', 'MediaController@myImages');
    Route::get('models/dashboard/media/image-galleries', 'MediaController@myImageGalleries');
    Route::get('models/dashboard/media/image-gallery/{galleryId}', 'MediaController@myImageGallery');
    Route::get('models/dashboard/media/video-galleries', 'MediaController@myVideoGalleries');
    Route::get('models/dashboard/media/video-gallery/{galleryId}', 'MediaController@myVideoGallery');

    Route::get('models/dashboard/media/videos', 'MediaController@myMediaVideos');
    Route::get('models/dashboard/videos', 'MediaController@myVideos');
    Route::get('models/dashboard/media/view-video/{videoId}', 'MediaController@viewVideoDetail');

    Route::post('paidgallery', 'ModelController@paidAllbumImage');

    Route::get('models/logout', 'ModelController@getLogOut');
    
    //group chat
    Route::get('models/groupchat', 'ChatController@groupChat');

    //request payout
    Route::match(['GET', 'POST'], 'models/dashboard/payouts/requests/create', 'RequestPayoutController@createRequest');
    Route::match(['GET', 'POST'], 'models/dashboard/payouts/edit/requests/{id}', 'RequestPayoutController@editRequest');
    Route::get('models/dashboard/payouts/requests', 'RequestPayoutController@listingRequests');
    Route::get('models/dashboard/payouts/requests/{id}', 'RequestPayoutController@viewRequest');

    //product
    Route::match(['GET', 'POST'], 'models/dashboard/products/add', 'ProductController@create');
    Route::match(['GET', 'POST'], 'models/dashboard/products/{id}/update', 'ProductController@update');
    Route::match(['GET', 'POST'], 'models/dashboard/products/{id}/delete', 'ProductController@deleteProduct');
    Route::get('models/dashboard/products', 'ProductController@listing');
    Route::get('models/dashboard/products/orders', 'ProductOrderController@listing');
    Route::get('models/dashboard/products/orders/{id}', 'ProductOrderController@view');
  });
  Route::get('products/{id}', 'ProductController@view');
});
